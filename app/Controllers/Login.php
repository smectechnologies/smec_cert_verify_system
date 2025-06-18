<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Login extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('admin/dashboard');
        }
        return view('login');
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('username', $username)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            $sessionData = [
                'admin_id' => $admin['id'],
                'admin_username' => $admin['username'],
                'admin_logged_in' => true
            ];
            session()->set($sessionData);
            return redirect()->to('admin/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();
        
        // Redirect to home page
        return redirect()->to('/');
    }
} 