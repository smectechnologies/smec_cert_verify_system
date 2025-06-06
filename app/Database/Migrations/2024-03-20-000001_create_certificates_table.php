<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'certificate_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'designation' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'work_dates' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'certificate_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Verified'],
                'default' => 'Pending',
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
        $this->forge->addUniqueKey('certificate_number');
        $this->forge->createTable('certificates');
    }

    public function down()
    {
        $this->forge->dropTable('certificates');
    }
} 