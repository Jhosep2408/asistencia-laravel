<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Ejecutar otros seeders
        $this->call([
            GradeClassroomSeeder::class,
        ]);

        // Crear usuario administrador por defecto
        User::updateOrCreate(
            ['email' => 'admin@escuela.com'], // busca por email
            [
                'name' => 'Administrador',
                'email' => 'admin@escuela.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin', // si tu tabla users tiene columna role
            ]
        );
        // Crear otro usuario
    User::updateOrCreate(
        ['email' => 'usuario@escuela.com'], // busca por email
        [
            'name' => 'Usuario Regular',
            'email' => 'usuario@escuela.com',
            'password' => Hash::make('usuario123'),
            'role' => 'user', // o el rol que uses para usuarios normales
        ]
    );
        
    }
}
