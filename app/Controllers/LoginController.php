<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        // Debug: Check if already logged in
        log_message('debug', 'Login page accessed. Session data: ' . json_encode(session()->get()));
        
        // If already logged in, redirect to dashboard
        if (session()->get('admin_logged_in')) {
            log_message('debug', 'User already logged in, redirecting to dashboard');
            return redirect()->to(base_url('admin/dashboard'));
        }

        // Show login form
        return view('admin/login');
    }

    public function authenticate()
    {
        // Debug: Log request details
        log_message('debug', 'Authentication attempt - Method: ' . $this->request->getMethod());
        log_message('debug', 'Authentication attempt - POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'Authentication attempt - Session data before: ' . json_encode(session()->get()));

        // Handle POST request
        if ($this->request->getMethod() === 'POST') {
            // Get form data
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // Debug: Log credentials
            log_message('debug', 'Authentication attempt - Username: ' . $username);
            
            // Validate input
            if (empty($username) || empty($password)) {
                log_message('debug', 'Authentication failed - Empty username or password');
                return redirect()->back()->with('error', 'Username and password are required');
            }

            // Check credentials
            if ($username === 'SMEC_Admin_2025' && $password === 'V3rify@SMEC#9274') {
                // Set session data
                $sessionData = [
                    'admin_id' => 1,
                    'admin_username' => $username,
                    'admin_logged_in' => true
                ];
                
                // Set session
                foreach ($sessionData as $key => $value) {
                    session()->set($key, $value);
                }
                
                // Debug: Log session after setting
                log_message('debug', 'Authentication successful - Session data after: ' . json_encode(session()->get()));
                
                // Regenerate session ID for security
                session()->regenerate();
                
                // Debug: Log final session state
                log_message('debug', 'Authentication successful - Final session data: ' . json_encode(session()->get()));
                
                // Redirect to dashboard
                return redirect()->to(base_url('admin/dashboard'))->with('success', 'Welcome back, ' . $username);
            }

            // If login fails
            log_message('debug', 'Authentication failed - Invalid credentials');
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        // If not POST request, redirect to login page
        log_message('debug', 'Invalid request method - Redirecting to login');
        return redirect()->to(base_url('admin_login'));
    }

    public function logout()
    {
        // Debug: Log session before logout
        log_message('debug', 'Logout - Session data before: ' . json_encode(session()->get()));
        
        // Destroy session
        session()->destroy();
        
        // Debug: Log session after logout
        log_message('debug', 'Logout - Session data after: ' . json_encode(session()->get()));
        
        // Redirect to login page
        return redirect()->to(base_url('admin_login'));
    }
} 