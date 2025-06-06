<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Auth extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('admin/dashboard');
        }

        return view('auth/login');
    }

    public function authenticate()
    {
        // Debug log
        log_message('debug', 'Login attempt with POST data: ' . json_encode($this->request->getPost()));

        // Validate input
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('error', 'Please enter both username and password');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug log
        log_message('debug', 'Attempting to find admin with username: ' . $username);

        // Get admin from database
        $admin = $this->adminModel->getAdminByUsername($username);

        if (!$admin) {
            log_message('debug', 'Admin not found for username: ' . $username);
            return redirect()->back()->withInput()->with('error', 'Invalid username or password');
        }

        // Debug log
        log_message('debug', 'Found admin, stored password hash: ' . $admin['password']);
        log_message('debug', 'Attempting to verify password');

        // Verify password
        if (!password_verify($password, $admin['password'])) {
            log_message('debug', 'Password verification failed');
            return redirect()->back()->withInput()->with('error', 'Invalid username or password');
        }

        // Debug log
        log_message('debug', 'Password verified successfully');

        // Set session data
        $sessionData = [
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username'],
            'admin_logged_in' => true
        ];

        // Debug log
        log_message('debug', 'Setting session data: ' . json_encode($sessionData));

        session()->set($sessionData);

        // Debug log
        log_message('debug', 'Session data set, redirecting to dashboard');

        return redirect()->to('admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('admin_login')->with('message', 'Successfully logged out');
    }
} 