<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAdminCredentials extends Migration
{
    public function up()
    {
        $data = [
            'username' => 'SMEC_Admin_2025!',
            'password' => password_hash('V3rify@SMEC#9274', PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('admins')->update($data, ['id' => 1]);
    }

    public function down()
    {
        // No down migration needed
    }
} 