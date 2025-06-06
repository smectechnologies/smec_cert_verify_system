<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Auth routes
$routes->get('admin_login', 'Auth::login');
$routes->post('admin_login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('add_certificate', 'Admin::addCertificate');
    $routes->post('add_certificate', 'Admin::addCertificate');
    $routes->get('edit_certificate/(:num)', 'Admin::editCertificate/$1');
    $routes->post('edit_certificate/(:num)', 'Admin::editCertificate/$1');
    $routes->post('delete_certificate/(:num)', 'Admin::deleteCertificate/$1');
    $routes->post('verify_certificate/(:num)', 'Admin::verifyCertificate/$1');
    $routes->get('view_certificate/(:num)', 'Admin::viewCertificate/$1');
    $routes->get('test_database', 'Admin::testDatabase');
});

// Public routes
$routes->get('/', 'Home::index');
$routes->get('verify/(:any)', 'Home::verify/$1');

// Home routes
$routes->get('certificate/verify', 'Home::verifyCertificate');

// Serve uploaded files
$routes->get('uploads/certificates/(:segment)', 'Home::serveCertificate/$1');

// Test database connection
$routes->get('test-db', function() {
    try {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT 1');
        return 'Database connection successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

// Test certificates table
$routes->get('test-table', function() {
    try {
        $db = \Config\Database::connect();
        
        // Check if table exists
        $tables = $db->listTables();
        if (!in_array('certificates', $tables)) {
            return 'Certificates table does not exist!';
        }
        
        // Get table structure
        $fields = $db->getFieldData('certificates');
        $output = "Certificates table structure:\n\n";
        foreach ($fields as $field) {
            $output .= "Field: {$field->name}\n";
            $output .= "Type: {$field->type}\n";
            $output .= "Null: " . ($field->nullable ? 'Yes' : 'No') . "\n";
            $output .= "Default: " . ($field->default ?? 'None') . "\n\n";
        }
        
        // Try to insert a test record
        $testData = [
            'name' => 'Test Certificate',
            'certificate_number' => 'TEST' . time(),
            'designation' => 'Test Designation',
            'work_dates' => '2024-01-01 to 2024-12-31',
            'is_verified' => 0
        ];
        
        if ($db->table('certificates')->insert($testData)) {
            $output .= "\nTest record inserted successfully!";
            // Clean up test record
            $db->table('certificates')->where('certificate_number', $testData['certificate_number'])->delete();
        } else {
            $output .= "\nFailed to insert test record: " . implode(', ', $db->error());
        }
        
        return $output;
    } catch (\Exception $e) {
        return 'Error checking table: ' . $e->getMessage();
    }
});
