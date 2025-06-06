<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCertificatesDates extends Migration
{
    public function up()
    {
        // Add new date columns
        $this->forge->addColumn('certificates', [
            'work_from_date' => [
                'type' => 'DATE',
                'null' => false,
                'after' => 'designation'
            ],
            'work_to_date' => [
                'type' => 'DATE',
                'null' => false,
                'after' => 'work_from_date'
            ]
        ]);

        // Migrate existing data
        $db = \Config\Database::connect();
        $certificates = $db->table('certificates')->get()->getResultArray();
        
        foreach ($certificates as $certificate) {
            if (!empty($certificate['work_dates'])) {
                $dates = explode(' to ', $certificate['work_dates']);
                if (count($dates) === 2) {
                    $db->table('certificates')
                       ->where('id', $certificate['id'])
                       ->update([
                           'work_from_date' => $dates[0],
                           'work_to_date' => $dates[1]
                       ]);
                }
            }
        }

        // Drop the old work_dates column
        $this->forge->dropColumn('certificates', 'work_dates');
    }

    public function down()
    {
        // Add back the work_dates column
        $this->forge->addColumn('certificates', [
            'work_dates' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'after' => 'designation'
            ]
        ]);

        // Migrate data back
        $db = \Config\Database::connect();
        $certificates = $db->table('certificates')->get()->getResultArray();
        
        foreach ($certificates as $certificate) {
            $db->table('certificates')
               ->where('id', $certificate['id'])
               ->update([
                   'work_dates' => $certificate['work_from_date'] . ' to ' . $certificate['work_to_date']
               ]);
        }

        // Drop the new date columns
        $this->forge->dropColumn('certificates', ['work_from_date', 'work_to_date']);
    }
} 