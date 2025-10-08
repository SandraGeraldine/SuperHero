<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password',
        'nombre',
        'apellido',
        'foto_perfil'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'nombre'   => 'required|min_length[2]|max_length[100]',
        'apellido' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'    => 'El nombre de usuario es obligatorio',
            'min_length'  => 'El nombre de usuario debe tener al menos 3 caracteres',
            'is_unique'   => 'Este nombre de usuario ya está en uso',
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio',
            'valid_email' => 'Debe proporcionar un correo electrónico válido',
            'is_unique'   => 'Este correo electrónico ya está registrado',
        ],
        'password' => [
            'required'   => 'La contraseña es obligatoria',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres',
        ],
        'nombre' => [
            'required' => 'El nombre es obligatorio',
        ],
        'apellido' => [
            'required' => 'El apellido es obligatorio',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    /**
     * Verifica las credenciales del usuario
     */
    public function verificarCredenciales($username, $password)
    {
        $user = $this->where('username', $username)
                     ->orWhere('email', $username)
                     ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    /**
     * Obtiene la foto de perfil del usuario o la imagen por defecto
     */
    public function getFotoPerfil($userId)
    {
        $user = $this->find($userId);
        
        if ($user && $user['foto_perfil'] && file_exists(FCPATH . 'uploads/perfiles/' . $user['foto_perfil'])) {
            return base_url('uploads/perfiles/' . $user['foto_perfil']);
        }
        
        return base_url('assets/img/default-avatar.png');
    }
}
