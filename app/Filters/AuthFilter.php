<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth');

        if (!$auth->isLoggedIn()) {
            return redirect()->to('/login');
        }

        // If group filter is specified, check access
        if (!empty($arguments)) {
            if (!$auth->hasGroup($arguments)) {
                return redirect()->to('/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
    }
}