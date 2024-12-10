<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenggunaPolicy
{
    use HandlesAuthorization;

    /**
     * Menentukan apakah pengguna bisa mengakses atau tidak.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function before(User $user)
    {
        // Jika pengguna adalah admin, beri akses ke semua tindakan
        if ($user->peran === 'admin') {
            return true;
        }
    }

    /**
     * Menentukan apakah pengguna dapat membuat pengguna baru.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->peran === 'admin';
    }

    /**
     * Menentukan apakah pengguna dapat mengubah pengguna lain.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengguna  $pengguna
     * @return bool
     */
    public function update(User $user, Pengguna $pengguna)
    {
        return $user->peran === 'admin';
    }

    /**
     * Menentukan apakah pengguna dapat menghapus pengguna lain.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengguna  $pengguna
     * @return bool
     */
    public function delete(User $user, Pengguna $pengguna)
    {
        return $user->peran === 'admin';
    }

    /**
     * Menentukan apakah pengguna dapat melihat pengguna lain.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengguna  $pengguna
     * @return bool
     */
    public function view(User $user, Pengguna $pengguna)
    {
        return $user->peran === 'admin' || $user->id === $pengguna->id;
    }
}
