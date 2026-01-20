<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning('Password reset requested for non-existent email:', ['email' => $request->email]);
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan di sistem kami.']);
        }

        try {
            // Generate token 6 digit
            $token = strtoupper(str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT));

            Log::info('Generated token:', ['email' => $request->email, 'token' => $token]);

            // Hapus token lama
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            // Simpan token baru
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);

            Log::info('Token saved to database:', ['email' => $request->email]);

            // Kirim email langsung via User Notification (bypass Password Broker rate limit)
            $user->notify(new \App\Notifications\ResetPasswordNotification($token));

            Log::info('Email sent directly via User notification:', ['email' => $request->email]);

            return redirect()->route('password.verify-token', ['email' => $request->email])
                ->with('status', 'Kode verifikasi telah dikirim ke email Anda!');

        } catch (\Exception $e) {
            Log::error('Error sending password reset:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Gagal mengirim email: ' . $e->getMessage()]);
        }
    }

    public function verifyToken(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-reset-token', compact('email'));
    }

    public function checkToken(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string', 'size:6'],
        ], [
            'token.size' => 'Kode verifikasi harus 6 digit.',
        ]);

        $resetToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', strtoupper($request->token))
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$resetToken) {
            Log::warning('Invalid token attempt:', ['email' => $request->email, 'token' => $request->token]);
            return back()->withErrors(['token' => 'Kode verifikasi tidak valid atau sudah expired.']);
        }

        $longToken = \Illuminate\Support\Str::random(60);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->update([
                'token' => $longToken,
                'created_at' => now(),
            ]);

        return redirect()->route('password.reset', ['token' => $longToken, 'email' => $request->email])
            ->with('status', 'Kode verifikasi valid! Silahkan reset password Anda.');
    }
}