<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el usuario está logueado
        if (!session()->get('isLoggedIn')) {
            // Redirigir al login si no está autenticado
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder a esta página');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita hacer nada después de la respuesta
    }
}
