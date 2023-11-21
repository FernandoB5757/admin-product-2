<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class LocalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* User::factory()->make([
            'email' => 'administrador@correo.com',
            'name' => 'Administrador',
            'password' => Hash::make('password'),
        ])->assignRole('Administrador')->save(); */

        User::factory()->make([
            'email' => 'dev@correo.com',
            'name' => 'Desarrollador'
        ])->assignRole('Desarrollador')->save();

        Artisan::call(
            'make:filament-user --name=Administrador --password=toor --email=administrador@correo.com'
        );
    }
}
