<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear o buscar el rol admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear o buscar el usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@pasteladmin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password123'),
            ]
        );

        // Asignar rol (evita duplicados)
        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
