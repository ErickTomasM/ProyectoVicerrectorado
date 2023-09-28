<?php

namespace App\Policies;

use App\Models\Carrera;
use App\Models\User;
use App\Models\Facultad;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarreraPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('Vicerrectorado') || $user->can('ver todas las carreras');
    }
    public function view(User $user)
    {
       // return $user->can('ver carreras FacultadArtes' . $carrera->id_facultad);

    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Carrera $carrera)
    {
        //
    }

    public function delete(User $user, Carrera $carrera)
    {
        //
    }

    public function restore(User $user, Carrera $carrera)
    {
        //
    }

    public function forceDelete(User $user, Carrera $carrera)
    {
        //
    }
}
