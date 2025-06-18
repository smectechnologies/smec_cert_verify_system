<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        // First create the table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Create the table if it doesn't exist
        if (!$this->db->tableExists('admins')) {
            $this->forge->createTable('admins');
        }

        // Then insert the admin user if it doesn't exist
        $builder = $this->db->table('admins');
        $admin = $builder->where('username', 'SMEC_Admin_2025!')->get()->getRow();

        if (!$admin) {
            $data = [
                'username' => 'SMEC_Admin_2025!',
                'password' => password_hash('V3rify@SMEC#9274', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $builder->insert($data);
        }
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
} 