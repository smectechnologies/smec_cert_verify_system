<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|is_unique[admins.username,id,{id}]',
        'password' => 'required|min_length[6]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'is_unique' => 'This username is already taken'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ]
    ];

    public function __construct()
    {
        parent::__construct();
        
        // Debug database connection
        log_message('debug', 'AdminModel initialized');
        log_message('debug', 'Database connection status: ' . ($this->db->connect(false) ? 'Connected' : 'Not connected'));
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function getAdminByUsername($username)
    {
        // Add debugging
        log_message('debug', 'Attempting to find admin with username: ' . $username);
        
        $result = $this->where('username', $username)->first();
        
        // Add debugging
        log_message('debug', 'Admin lookup result: ' . ($result ? 'Found' : 'Not found'));
        
        return $result;
    }
} 