<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Buscar el rol "super-admin" creado previamente por RolePermissionSeeder
        $superAdminRole = Role::where('name', 'super-admin')->first();

        if (!$superAdminRole) {
            $this->command->error('❌ El rol "super-admin" no existe. Ejecuta primero RolePermissionSeeder.');
            return;
        }

        // Crear el usuario admin si no existe
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123456'),
                'estado' => '1',
                'photo' => null,
                'email_verified_at' => Carbon::now(),
            ]
        );

        // Asignar el rol super-admin (si no lo tiene ya)
        if (!$adminUser->hasRole('super-admin')) {
            $adminUser->assignRole($superAdminRole);
        }

        // Mensaje informativo
        $this->command->info(" Usuario Super Admin creado correctamente.");
        $this->command->line(" Email: admin@admin.com");
        $this->command->line(" Contraseña: admin123456");
        $this->command->line(" Email verificado el: " . $adminUser->email_verified_at);
    }
}
