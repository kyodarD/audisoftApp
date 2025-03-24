<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Crear el rol "Administrador" si no existe
        $adminRole = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);

        // Asignarle todos los permisos al rol de Administrador
        $permissions = Permission::pluck('name')->toArray(); // Obtener todos los permisos
        $adminRole->syncPermissions($permissions);

        // Crear el usuario administrador si no existe
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'], 
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123456'), 
                'estado' => '1',
                'photo' => null, 
                'email_verified_at' => Carbon::now()
            ]
        );

        // Asignar el rol de Administrador al usuario
        $adminUser->assignRole($adminRole);

        echo "Usuario Administrador creado correctamente.\n";
        echo "Email: admin@admin.com\n";
        echo "Contraseña: admin123456\n";
        echo "Email verificado el: " . $adminUser->email_verified_at . "\n";
    }
}
