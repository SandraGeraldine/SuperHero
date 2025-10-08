<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'    => 'admin',
                'email'       => 'admin@superhero.com',
                'password'    => password_hash('admin123', PASSWORD_DEFAULT),
                'nombre'      => 'Administrador',
                'apellido'    => 'Sistema',
                'foto_perfil' => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'usuario1',
                'email'       => 'usuario1@superhero.com',
                'password'    => password_hash('password123', PASSWORD_DEFAULT),
                'nombre'      => 'Juan',
                'apellido'    => 'Pérez',
                'foto_perfil' => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'maria',
                'email'       => 'maria@superhero.com',
                'password'    => password_hash('maria123', PASSWORD_DEFAULT),
                'nombre'      => 'María',
                'apellido'    => 'González',
                'foto_perfil' => null,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Insertar datos
        $this->db->table('users')->insertBatch($data);
    }
}
