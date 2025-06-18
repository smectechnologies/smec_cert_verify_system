<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Public routes
$routes->get('/', 'Home::index');
$routes->get('/verify', 'Certificate::verify');
$routes->post('/certificate/verify', 'Certificate::verify');

// Admin login routes
$routes->get('admin_login', 'Login::index');
$routes->post('admin_login', 'Login::auth');
$routes->get('logout', 'Login::logout');

// Admin dashboard routes (protected)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Certificate management
    $routes->get('add', 'Admin::addCertificate');
    $routes->post('add', 'Admin::addCertificate');
    $routes->get('edit/(:num)', 'Admin::editCertificate/$1');
    $routes->post('edit/(:num)', 'Admin::editCertificate/$1');
    $routes->get('view/(:num)', 'Admin::viewCertificate/$1');
    $routes->get('verify/(:num)', 'Admin::verifyCertificate/$1');
    $routes->get('delete/(:num)', 'Admin::deleteCertificate/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

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
