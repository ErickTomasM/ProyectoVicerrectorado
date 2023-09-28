<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;


use App\Models\Carrera;
use App\Models\User;
use App\Models\Facultad;
use App\Models\Docente;
use App\Models\Materia;
use App\Policies\CarreraPolicy;


// use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Carrera::class => CarreraPolicy::class,
        //'App\Carrera' => 'App\Policies\CarreraPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    
    
    }
}
