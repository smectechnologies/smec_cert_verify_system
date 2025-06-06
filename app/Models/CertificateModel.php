<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table = 'certificates';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name',
        'certificate_number',
        'designation',
        'work_from_date',
        'work_to_date',
        'image_path',
        'is_verified'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'certificate_number' => 'required|min_length[3]|max_length[50]',
        'designation' => 'required|min_length[3]|max_length[255]',
        'work_from_date' => 'required|valid_date',
        'work_to_date' => 'required|valid_date',
        'image_path' => 'permit_empty|max_length[255]',
        'is_verified' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'min_length' => 'Name must be at least 3 characters long',
            'max_length' => 'Name cannot exceed 255 characters'
        ],
        'certificate_number' => [
            'required' => 'Certificate number is required',
            'min_length' => 'Certificate number must be at least 3 characters long',
            'max_length' => 'Certificate number cannot exceed 50 characters'
        ],
        'designation' => [
            'required' => 'Designation is required',
            'min_length' => 'Designation must be at least 3 characters long',
            'max_length' => 'Designation cannot exceed 255 characters'
        ],
        'work_from_date' => [
            'required' => 'From date is required',
            'valid_date' => 'Please enter a valid from date'
        ],
        'work_to_date' => [
            'required' => 'To date is required',
            'valid_date' => 'Please enter a valid to date'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
} 