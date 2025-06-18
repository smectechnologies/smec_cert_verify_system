<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Debug log
        log_message('debug', 'NoAuthFilter: Starting check');
        log_message('debug', 'NoAuthFilter: Session data = ' . json_encode(session()->get()));
        
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            log_message('debug', 'NoAuthFilter: User is logged in, redirecting to dashboard');
            return redirect()->to('admin/dashboard');
        }

        log_message('debug', 'NoAuthFilter: User is not logged in, proceeding');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 