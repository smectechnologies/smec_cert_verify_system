<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class UpdateAdminData extends BaseCommand
{
    protected $group       = 'Auth';
    protected $name        = 'admin:update';
    protected $description = 'Updates admin credentials';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // Check if admin exists
        $admin = $db->table('admins')->where('id', 1)->get()->getRow();
        
        if ($admin) {
            // Update existing admin
            $data = [
                'username' => 'SMEC_Admin_2025!',
                'password' => password_hash('V3rify@SMEC#9274', PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('admins')->update($data, ['id' => 1]);
            CLI::write('Admin credentials updated successfully!', 'green');
        } else {
            // Create new admin
            $data = [
                'username' => 'SMEC_Admin_2025!',
                'password' => password_hash('V3rify@SMEC#9274', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('admins')->insert($data);
            CLI::write('New admin account created successfully!', 'green');
        }
    }
} 