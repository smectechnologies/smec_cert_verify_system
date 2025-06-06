<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Debug log
        log_message('debug', 'AuthFilter: Checking session data');
        log_message('debug', 'AuthFilter: Session data = ' . json_encode(session()->get()));

        if (!session()->get('admin_logged_in')) {
            log_message('debug', 'AuthFilter: User not logged in, redirecting to login page');
            return redirect()->to('admin_login');
        }

        log_message('debug', 'AuthFilter: User is logged in, proceeding');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 