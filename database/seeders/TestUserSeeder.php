<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        // Crear el primer usuario sin roles
        $user1 = User::firstOrCreate(
            ['email' => 'user1@example.com'], // Cambia esto si lo deseas
            [
                'name' => 'Usuario de Prueba 1',
                'password' => Hash::make('user12345'), // Cambia la contraseña después
                'estado' => '1',
                'photo' => null,  // Deja el campo photo como null
                'email_verified_at' => Carbon::now()
            ]
        );

        // Crear el segundo usuario sin roles
        $user2 = User::firstOrCreate(
            ['email' => 'user2@example.com'], // Cambia esto si lo deseas
            [
                'name' => 'Usuario de Prueba 2',
                'password' => Hash::make('user12345'), // Cambia la contraseña después
                'estado' => '1',
                'photo' => null,  // Deja el campo photo como null
                'email_verified_at' => Carbon::now()
            ]
        );

        // Mostrar un mensaje en la consola para indicar que se crearon los usuarios
        echo "Usuarios de prueba creados correctamente.\n";
        echo "Usuario 1: user1@example.com\n";
        echo "Contraseña: user12345\n";
        echo "Usuario 2: user2@example.com\n";
        echo "Contraseña: user12345\n";
    }
}
