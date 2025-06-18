<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];

    public function __construct()
    {
        parent::__construct();
        log_message('debug', 'AdminModel initialized');
    }

    public function getAdminByUsername($username)
    {
        log_message('debug', 'Getting admin by username: ' . $username);
        return $this->where('username', $username)->first();
    }
} 