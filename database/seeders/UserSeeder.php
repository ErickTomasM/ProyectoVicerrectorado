<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Erick Tomas',
            'email' => '1222ericktomas@gmail.com',
            'password' => bcrypt('123456')
        ])->assignRole('Vicerrectorado');
        User::create([
            'name' => 'Artes',
            'email' => '1222artes@gmail.com',
            'password' => bcrypt('123456')
        ])->assignRole('FacultadArtes');
        User::create([
            'name' => 'Sistemas',
            'email' => '1222sistemas@gmail.com',
            'password' => bcrypt('123456')
        ])->assignRole('Sistemas');
       
    }
}
