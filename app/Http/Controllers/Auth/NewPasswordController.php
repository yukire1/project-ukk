<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Verifikasi token dari database (bypass Password::reset() yang strict)
            $resetToken = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->where('created_at', '>', now()->subMinutes(60))
                ->first();

            if (!$resetToken) {
                Log::warning('Invalid password reset token:', ['email' => $request->email]);
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'Token reset password tidak valid atau sudah expired.']);
            }

            // Cari user
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Log::warning('User not found for password reset:', ['email' => $request->email]);
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'User tidak ditemukan.']);
            }

            // Update password langsung (bypass Password::reset())
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            // Hapus token yang sudah digunakan
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            // Trigger password reset event
            event(new PasswordReset($user));

            Log::info('Password reset successfully:', ['email' => $request->email]);

            return redirect()->route('login')
                ->with('status', 'Password Anda telah berhasil direset. Silakan login dengan password baru Anda.');

        } catch (\Exception $e) {
            Log::error('Error resetting password:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Gagal mereset password: ' . $e->getMessage()]);
        }
    }
}
