<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new User();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    /**
     * Muestra el formulario de login
     */
    public function login()
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Procesa el login
     */
    public function loginPost()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verificarCredenciales($username, $password);

        if ($user) {
            // Crear sesión
            $sessionData = [
                'user_id'     => $user['id'],
                'username'    => $user['username'],
                'email'       => $user['email'],
                'nombre'      => $user['nombre'],
                'apellido'    => $user['apellido'],
                'foto_perfil' => $user['foto_perfil'],
                'isLoggedIn'  => true,
            ];

            $this->session->set($sessionData);

            return redirect()->to('/dashboard')->with('success', '¡Bienvenido ' . $user['nombre'] . '!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos');
        }
    }

    /**
     * Muestra el formulario de registro
     */
    public function register()
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    /**
     * Procesa el registro
     */
    public function registerPost()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'nombre'   => 'required|min_length[2]|max_length[100]',
            'apellido' => 'required|min_length[2]|max_length[100]',
        ];

        $messages = [
            'username' => [
                'required'    => 'El nombre de usuario es obligatorio',
                'min_length'  => 'El nombre de usuario debe tener al menos 3 caracteres',
                'max_length'  => 'El nombre de usuario no puede exceder 100 caracteres',
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
            'password_confirm' => [
                'required' => 'Debe confirmar la contraseña',
                'matches'  => 'Las contraseñas no coinciden',
            ],
            'nombre' => [
                'required'   => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 2 caracteres',
                'max_length' => 'El nombre no puede exceder 100 caracteres',
            ],
            'apellido' => [
                'required'   => 'El apellido es obligatorio',
                'min_length' => 'El apellido debe tener al menos 2 caracteres',
                'max_length' => 'El apellido no puede exceder 100 caracteres',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => $this->request->getPost('password'),
            'nombre'      => $this->request->getPost('nombre'),
            'apellido'    => $this->request->getPost('apellido'),
            'foto_perfil' => null,
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/login')->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario');
        }
    }

    /**
     * Muestra el perfil del usuario
     */
    public function profile()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        return view('auth/profile', ['user' => $user]);
    }

    /**
     * Actualiza el perfil del usuario
     */
    public function updateProfile()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');

        $rules = [
            'nombre'   => 'required|min_length[2]|max_length[100]',
            'apellido' => 'required|min_length[2]|max_length[100]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $this->request->getPost('email'),
        ];

        // Manejar la foto de perfil
        $foto = $this->request->getFile('foto_perfil');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $validationRule = [
                'foto_perfil' => [
                    'label' => 'Foto de perfil',
                    'rules' => 'uploaded[foto_perfil]|is_image[foto_perfil]|mime_in[foto_perfil,image/jpg,image/jpeg,image/png]|max_size[foto_perfil,2048]',
                ],
            ];

            if ($this->validate($validationRule)) {
                // Crear directorio si no existe
                $uploadPath = FCPATH . 'uploads/perfiles/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Eliminar foto anterior si existe
                $user = $this->userModel->find($userId);
                if ($user['foto_perfil'] && file_exists($uploadPath . $user['foto_perfil'])) {
                    unlink($uploadPath . $user['foto_perfil']);
                }

                // Generar nombre único
                $newName = 'perfil_' . $userId . '_' . time() . '.' . $foto->getExtension();
                $foto->move($uploadPath, $newName);

                $data['foto_perfil'] = $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Error al subir la foto. Asegúrate de que sea JPG o PNG y no supere 2MB');
            }
        }

        if ($this->userModel->update($userId, $data)) {
            // Actualizar sesión
            $this->session->set([
                'nombre'      => $data['nombre'],
                'apellido'    => $data['apellido'],
                'email'       => $data['email'],
                'foto_perfil' => $data['foto_perfil'] ?? $this->session->get('foto_perfil'),
            ]);

            return redirect()->back()->with('success', 'Perfil actualizado correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil');
        }
    }

    /**
     * Cierra la sesión
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'Sesión cerrada correctamente');
    }

    /**
     * Dashboard principal
     */
    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('auth/dashboard');
    }
}
