<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCertificatesTable extends Migration
{
    public function up()
    {
        // Drop the old status column
        $this->forge->dropColumn('certificates', 'status');

        // Add is_verified column
        $this->forge->addColumn('certificates', [
            'is_verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'work_dates'
            ]
        ]);

        // Rename certificate_image to image_path
        $this->forge->modifyColumn('certificates', [
            'certificate_image' => [
                'name' => 'image_path',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ]
        ]);

        // Update created_at and updated_at to be NOT NULL with default values
        $this->forge->modifyColumn('certificates', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            ]
        ]);
    }

    public function down()
    {
        // Revert changes
        $this->forge->dropColumn('certificates', 'is_verified');

        $this->forge->modifyColumn('certificates', [
            'image_path' => [
                'name' => 'certificate_image',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ]
        ]);

        $this->forge->addColumn('certificates', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Verified'],
                'default' => 'Pending',
                'after' => 'certificate_image'
            ]
        ]);

        $this->forge->modifyColumn('certificates', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
    }
} 