<?php

namespace App\Controllers;

use App\Models\CertificateModel;
use App\Models\AdminModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Admin extends BaseController
{
    protected $certificateModel;
    protected $adminModel;
    protected $session;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
        $this->adminModel = new AdminModel();
        $this->session = \Config\Services::session();
        
        // Check authentication for all methods except index
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('admin_login');
        }
    }

    public function index()
    {
        return redirect()->to('admin/dashboard');
    }

    public function dashboard()
    {
        try {
            $certificates = $this->certificateModel->findAll();
            log_message('debug', 'Loading dashboard with ' . count($certificates) . ' certificates');
            return view('admin/dashboard', ['certificates' => $certificates]);
        } catch (\Exception $e) {
            log_message('error', 'Error loading dashboard: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'Failed to load certificates');
        }
    }

    public function viewCertificate($id)
    {
        try {
            $certificate = $this->certificateModel->find($id);
            if (!$certificate) {
                log_message('error', 'Certificate not found: ' . $id);
                return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
            }

            log_message('debug', 'Viewing certificate: ' . json_encode($certificate));
            return view('admin/view_certificate', ['certificate' => $certificate]);
        } catch (\Exception $e) {
            log_message('error', 'Error viewing certificate: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'An error occurred while viewing the certificate');
        }
    }

    public function addCertificate()
    {
        log_message('debug', '=== addCertificate method called ===');
        
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'POST request received');
            try {
                // Log raw POST data
                log_message('debug', 'Raw POST data: ' . print_r($_POST, true));

                // Check database connection
                try {
                    $db = \Config\Database::connect();
                    log_message('debug', 'Database connection successful');
                } catch (\Exception $e) {
                    log_message('error', 'Database connection failed: ' . $e->getMessage());
                    return redirect()->back()->withInput()->with('error', 'Database connection failed: ' . $e->getMessage());
                }

                $rules = [
                    'name' => 'required|min_length[3]',
                    'certificate_number' => 'required|min_length[3]',
                    'designation' => 'required|min_length[3]',
                    'work_from_date' => 'required|valid_date',
                    'work_to_date' => 'required|valid_date'
                ];

                if (!$this->validate($rules)) {
                    log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                    return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
                }

                // Prepare data for insertion
                $data = [
                    'name' => $this->request->getPost('name'),
                    'certificate_number' => $this->request->getPost('certificate_number'),
                    'designation' => $this->request->getPost('designation'),
                    'work_from_date' => $this->request->getPost('work_from_date'),
                    'work_to_date' => $this->request->getPost('work_to_date'),
                    'image_path' => null,
                    'is_verified' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                log_message('debug', 'Prepared data for insertion: ' . json_encode($data));
                
                try {
                    // Check if certificate number already exists using direct query
                    $builder = $db->table('certificates');
                    $existing = $builder->where('certificate_number', $data['certificate_number'])->get()->getResult();
                    
                    if (!empty($existing)) {
                        log_message('error', 'Certificate number already exists: ' . $data['certificate_number']);
                        return redirect()->back()->withInput()->with('error', 'Certificate number already exists');
                    }

                    // Attempt to insert using direct query
                    $inserted = $builder->insert($data);
                    log_message('debug', 'Direct insert result: ' . ($inserted ? 'true' : 'false'));
                    
                    if ($inserted) {
                        $insertId = $db->insertID();
                        log_message('info', 'Certificate added successfully with ID: ' . $insertId);
                        
                        // Verify the insertion
                        $verify = $builder->where('id', $insertId)->get()->getResult();
                        if (!empty($verify)) {
                            log_message('debug', 'Verified insertion: ' . json_encode($verify));
                            return redirect()->to('admin/dashboard')->with('message', 'Certificate added successfully');
                        } else {
                            log_message('error', 'Insertion verification failed');
                            return redirect()->back()->withInput()->with('error', 'Certificate was added but verification failed');
                        }
                    } else {
                        log_message('error', 'Failed to add certificate. Last query: ' . $db->getLastQuery());
                        return redirect()->back()->withInput()->with('error', 'Failed to add certificate. Please try again.');
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Database error: ' . $e->getMessage());
                    log_message('error', 'Last query: ' . $db->getLastQuery());
                    return redirect()->back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                log_message('error', 'Error adding certificate: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred while adding the certificate: ' . $e->getMessage());
            }
        }

        return view('admin/add_certificate');
    }

    public function editCertificate($id)
    {
        try {
            $certificate = $this->certificateModel->find($id);
            if (!$certificate) {
                log_message('error', 'Certificate not found: ' . $id);
                return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
            }

            if ($this->request->getMethod() === 'post') {
                $rules = [
                    'name' => 'required|min_length[3]',
                    'certificate_number' => 'required|min_length[3]',
                    'designation' => 'required|min_length[3]',
                    'work_from_date' => 'required|valid_date',
                    'work_to_date' => 'required|valid_date'
                ];

                if (!$this->validate($rules)) {
                    log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                    return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
                }

                $data = [
                    'name' => $this->request->getPost('name'),
                    'certificate_number' => $this->request->getPost('certificate_number'),
                    'designation' => $this->request->getPost('designation'),
                    'work_from_date' => $this->request->getPost('work_from_date'),
                    'work_to_date' => $this->request->getPost('work_to_date')
                ];

                $image = $this->request->getFile('certificate_image');
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(WRITEPATH . 'uploads/certificates', $newName);
                    $data['image_path'] = 'writable/uploads/certificates/' . $newName;

                    // Delete old image if exists
                    if (!empty($certificate['image_path']) && file_exists(ROOTPATH . $certificate['image_path'])) {
                        unlink(ROOTPATH . $certificate['image_path']);
                    }
                }

                log_message('debug', 'Updating certificate: ' . json_encode($data));

                if ($this->certificateModel->update($id, $data)) {
                    log_message('info', 'Certificate updated successfully');
                    return redirect()->to('admin/dashboard')->with('message', 'Certificate updated successfully');
                } else {
                    log_message('error', 'Failed to update certificate: ' . json_encode($this->certificateModel->errors()));
                    return redirect()->back()->withInput()->with('error', 'Failed to update certificate');
                }
            }

            return view('admin/edit_certificate', ['certificate' => $certificate]);
        } catch (\Exception $e) {
            log_message('error', 'Error editing certificate: ' . $e->getMessage());
            return redirect()->to('admin/dashboard')->with('error', 'An error occurred while editing the certificate');
        }
    }

    public function deleteCertificate($id)
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
            }

            $certificate = $this->certificateModel->find($id);
            if (!$certificate) {
                log_message('error', 'Certificate not found for deletion: ' . $id);
                return $this->response->setJSON(['success' => false, 'message' => 'Certificate not found']);
            }

            // Delete image if exists
            if (!empty($certificate['image_path']) && file_exists(ROOTPATH . $certificate['image_path'])) {
                unlink(ROOTPATH . $certificate['image_path']);
            }

            log_message('debug', 'Deleting certificate: ' . $id);

            if ($this->certificateModel->delete($id)) {
                log_message('info', 'Certificate deleted successfully');
                return $this->response->setJSON(['success' => true]);
            } else {
                log_message('error', 'Failed to delete certificate: ' . json_encode($this->certificateModel->errors()));
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete certificate']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting certificate: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while deleting the certificate']);
        }
    }

    public function verifyCertificate($id)
    {
        try {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
            }

            $certificate = $this->certificateModel->find($id);
            if (!$certificate) {
                log_message('error', 'Certificate not found for verification: ' . $id);
                return $this->response->setJSON(['success' => false, 'message' => 'Certificate not found']);
            }

            log_message('debug', 'Verifying certificate: ' . $id);

            if ($this->certificateModel->update($id, ['is_verified' => 1])) {
                log_message('info', 'Certificate verified successfully');
                return $this->response->setJSON(['success' => true]);
            } else {
                log_message('error', 'Failed to verify certificate: ' . json_encode($this->certificateModel->errors()));
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to verify certificate']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error verifying certificate: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while verifying the certificate']);
        }
    }

    public function testDatabase()
    {
        try {
            $db = \Config\Database::connect();
            log_message('debug', 'Attempting database connection...');
            
            // Test connection
            $query = $db->query('SELECT 1');
            log_message('debug', 'Basic query successful');
            
            // Test database exists
            $query = $db->query('SHOW DATABASES LIKE "certificate_verification"');
            $result = $query->getResult();
            log_message('debug', 'Database check result: ' . json_encode($result));
            
            // Test table exists
            $query = $db->query('SHOW TABLES LIKE "certificates"');
            $result = $query->getResult();
            log_message('debug', 'Table check result: ' . json_encode($result));
            
            // Test table structure
            $query = $db->query('DESCRIBE certificates');
            $result = $query->getResult();
            log_message('debug', 'Table structure: ' . json_encode($result));
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Database connection successful',
                'data' => [
                    'database_exists' => !empty($result),
                    'table_exists' => !empty($result),
                    'table_structure' => $result
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database test failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Database test failed: ' . $e->getMessage()
            ]);
        }
    }
} 