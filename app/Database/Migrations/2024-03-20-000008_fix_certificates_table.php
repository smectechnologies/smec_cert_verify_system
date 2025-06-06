<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixCertificatesTable extends Migration
{
    public function up()
    {
        // Drop the table if it exists
        $this->forge->dropTable('certificates', true);

        // Create the table with the correct structure
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
                'constraint' => 255,
            ],
            'designation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'work_from_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'work_to_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'is_verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
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