<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDefaultAdmin extends Migration
{
    public function up()
    {
        // Check if admin user already exists
        $admin = $this->db->table('admins')
                         ->where('username', 'admin')
                         ->get()
                         ->getRow();

        if (!$admin) {
            $data = [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('admins')->insert($data);
        }
    }

    public function down()
    {
        $this->db->table('admins')
                 ->where('username', 'admin')
                 ->delete();
    }
} 