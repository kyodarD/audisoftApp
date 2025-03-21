<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Si deseas crear 10 usuarios de prueba, descomenta la siguiente línea:
        // User::factory(10)->create();

        // Llamar al seeder de roles y permisos
        $this->call(RolePermissionSeeder::class);

        // Llamar al seeder que crea el usuario administrador
        $this->call(AdminUserSeeder::class);
        // $this -> call (TestUserSeeder:: class);
        
    }
}
