<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Layanan;

class LayananPolicy
{
    public function view(User $user, Layanan $layanan): bool
    {
        // allow if user is admin/kepala_desa (support multiple role implementations)
        if ($this->isAdminOrKepala($user)) return true;

        // check ownership: try common owner columns
        $ownerId = $layanan->user_id ?? $layanan->penduduk_id ?? null;
        return $ownerId !== null && $user->id === $ownerId;
    }

    public function update(User $user, Layanan $layanan): bool
    {
        if ($this->isAdminOrKepala($user)) return true;

        $ownerId = $layanan->user_id ?? $layanan->penduduk_id ?? null;
        return $ownerId !== null && $user->id === $ownerId;
    }

    public function delete(User $user, Layanan $layanan): bool
    {
        if ($this->isAdminOrKepala($user)) return true;

        $ownerId = $layanan->user_id ?? $layanan->penduduk_id ?? null;
        return $ownerId !== null && $user->id === $ownerId;
    }

    protected function isAdminOrKepala(User $user): bool
    {
        // try common role checks (adjust to your app)
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) return true;
        if (method_exists($user, 'hasRole') && $user->hasRole('kepala_desa')) return true;
        if (property_exists($user, 'is_admin') && $user->is_admin) return true;
        if (isset($user->roles) && $user->roles->contains('name', 'admin')) return true;

        return false;
    }
}