<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Vicerrectorado = Role::create(['name' => 'Vicerrectorado', 'id_facultad' => 23]);
        $FacultadArtes = Role::create(['name' => 'FacultadArtes', 'id_facultad' => 0 ]);
        $FacultadeMedicina = Role::create(['name' => 'FacultadMedicina', 'id_facultad' => 11]);
        $FacultadMinera = Role::create(['name' => 'FacultadMinera', 'id_facultad' =>8 ]);
        $FacultadAgricola = Role::create(['name' => 'FacultadAgricola', 'id_facultad' => 1]);
        $FacultadSociales = Role::create(['name' => 'FacultadSociales', 'id_facultad' => 4 ]);
        $FacultadGeologica = Role::create(['name' => 'FacultadGeologica', 'id_facultad' => 7]);
        $FacultadIngenieria = Role::create(['name' => 'FacultadIngenieria', 'id_facultad' => 6]);
        $FacultadTecnologica = Role::create(['name' => 'FacultadTecnologica', 'id_facultad' => 9]);
        $FacultadSalud = Role::create(['name' => 'FacultadSalud', 'id_facultad' => 10]);
        $FacultadPuras = Role::create(['name' => 'FacultadPuras', 'id_facultad' => 3]);
        $FacultadEconomicas = Role::create(['name' => 'FacultadEconomicas', 'id_facultad' => 2]);
        $FacultadDerecho = Role::create(['name' => 'FacultadDerecho', 'id_facultad' => 5]);
        $Sistemas = Role::create(['name' => 'Sistemas', 'id_facultad' => 23 ]);
        $Odontologia = Role::create(['name' => 'Odontologia', 'id_facultad' => 23]);



        $permissions = Permission::all();
        $Vicerrectorado->syncPermissions($permissions);
        Permission::create(['name' => 'ver vicerrectorado'])->syncRoles(['Vicerrectorado']);
        Permission::create(['name' => 'ver carreras FacultadArtes'])->syncRoles(['FacultadArtes']);
        Permission::create(['name' => 'ver carreras FacultadMedicina'])->syncRoles(['FacultadMedicina']);
        Permission::create(['name' => 'ver carreras FacultadMinera'])->syncRoles(['FacultadMinera']);
        Permission::create(['name' => 'ver carreras FacultadAgricola'])->syncRoles(['FacultadAgricola']);
        Permission::create(['name' => 'ver carreras FacultadSociales'])->syncRoles(['FacultadSociales']);
        Permission::create(['name' => 'ver carreras FacultadGeologica'])->syncRoles(['FacultadGeologica']);
        Permission::create(['name' => 'ver carreras FacultadIngenieria'])->syncRoles(['FacultadIngenieria']);
        Permission::create(['name' => 'ver carreras FacultadTecnologica'])->syncRoles(['FacultadTecnologica']);
        Permission::create(['name' => 'ver carreras FacultadSalud'])->syncRoles(['FacultadSalud']);
        Permission::create(['name' => 'ver carreras FacultadPuras'])->syncRoles(['FacultadPuras']);
        Permission::create(['name' => 'ver carreras FacultadEconomicas'])->syncRoles(['FacultadEconomicas']);
        Permission::create(['name' => 'ver carreras FacultadDerecho'])->syncRoles(['FacultadDerecho']);
        Permission::create(['name' => 'ver docentes Sistemas'])->syncRoles(['Sistemas']);
        Permission::create(['name' => 'ver docentes Odontologia'])->syncRoles(['Odontologia']);
       
    }
}
