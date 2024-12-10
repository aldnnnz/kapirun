<?php

namespace App\Providers;

use App\Models\Pengguna;
use App\Policies\PenggunaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        // Pastikan policy Pengguna terdaftar di sini
        Gate::policy(Pengguna::class, PenggunaPolicy::class);
    }
}
