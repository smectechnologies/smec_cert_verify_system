<?php

namespace App\Controllers;

use App\Models\CertificateModel;
use App\Models\AdminModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $certificateModel;
    protected $adminModel;
    protected $session;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
        $this->adminModel = new AdminModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        return redirect()->to('admin/dashboard');
    }

    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        // Handle POST request
        if ($this->request->getMethod() === 'post') {
            // Get form data
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // Validate input
            if (empty($username) || empty($password)) {
                return redirect()->back()->with('error', 'Username and password are required');
            }

            // Check credentials
            if ($username === 'admin' && $password === 'admin123') {
                // Set session data
                $sessionData = [
                    'admin_id' => 1,
                    'admin_username' => $username,
                    'admin_logged_in' => true
                ];
                
                // Set session
                foreach ($sessionData as $key => $value) {
                    $this->session->set($key, $value);
                }
                
                // Regenerate session ID for security
                $this->session->regenerate();
                
                return redirect()->to(base_url('admin/dashboard'));
            }

            // If login fails
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        // Show login form for GET requests
        return view('admin/login');
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            log_message('debug', 'Dashboard access denied - Not logged in');
            return redirect()->to(base_url('admin_login'));
        }

        log_message('debug', 'Dashboard accessed by: ' . $this->session->get('admin_username'));
        
        // Get all certificates with pagination
        $data = [
            'title' => 'Dashboard',
            'certificates' => $this->certificateModel->paginate(10),
            'pager' => $this->certificateModel->pager
        ];
        
        return view('admin/dashboard', $data);
    }

    public function logout()
    {
        // Destroy session
        $this->session->destroy();
        
        log_message('debug', 'Session destroyed');
        return redirect()->to(base_url('admin_login'));
    }

    public function addCertificate()
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin_login'));
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required',
                'certificate_number' => 'required',
                'designation' => 'required',
                'work_from_date' => 'required|valid_date',
                'work_to_date' => 'required|valid_date',
                'certificate_image' => 'uploaded[certificate_image]|mime_in[certificate_image,image/jpg,image/jpeg,image/png]|max_size[certificate_image,2048]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            try {
                $image = $this->request->getFile('certificate_image');
                $newName = $image->getRandomName();
                
                // Create upload directory if it doesn't exist
                $uploadPath = FCPATH . 'writable/uploads/certificates';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Move the file to the upload directory
                $image->move($uploadPath, $newName);

                $data = [
                    'name' => $this->request->getPost('name'),
                    'certificate_number' => $this->request->getPost('certificate_number'),
                    'designation' => $this->request->getPost('designation'),
                    'work_from_date' => $this->request->getPost('work_from_date'),
                    'work_to_date' => $this->request->getPost('work_to_date'),
                    'image_path' => 'writable/uploads/certificates/' . $newName,
                    'is_verified' => 0
                ];

                $this->certificateModel->insert($data);
                return redirect()->to('admin/dashboard')->with('message', 'Certificate added successfully');
            } catch (\Exception $e) {
                log_message('error', 'Error adding certificate: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Failed to add certificate: ' . $e->getMessage());
            }
        }

        // Show the add certificate form
        return view('admin/add', ['title' => 'Add Certificate']);
    }

    public function editCertificate($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin_login'));
        }

        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required',
                'certificate_number' => 'required',
                'designation' => 'required',
                'work_from_date' => 'required|valid_date',
                'work_to_date' => 'required|valid_date'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'certificate_number' => $this->request->getPost('certificate_number'),
                    'designation' => $this->request->getPost('designation'),
                    'work_from_date' => $this->request->getPost('work_from_date'),
                    'work_to_date' => $this->request->getPost('work_to_date')
                ];

                // Handle image upload if provided
                $image = $this->request->getFile('certificate_image');
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $uploadPath = FCPATH . 'writable/uploads/certificates';
                    $image->move($uploadPath, $newName);
                    $data['image_path'] = 'writable/uploads/certificates/' . $newName;
                }

                if ($this->certificateModel->update($id, $data)) {
                    return redirect()->to('admin/dashboard')->with('message', 'Certificate updated successfully');
                }
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        return view('admin/edit', [
            'title' => 'Edit Certificate',
            'certificate' => $certificate
        ]);
    }

    public function viewCertificate($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin_login'));
        }

        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
        }

        return view('admin/view', [
            'title' => 'View Certificate',
            'certificate' => $certificate
        ]);
    }

    public function verifyCertificate($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin_login'));
        }

        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
        }

        if ($this->certificateModel->update($id, ['is_verified' => 1])) {
            return redirect()->to('admin/dashboard')->with('message', 'Certificate verified successfully');
        }

        return redirect()->to('admin/dashboard')->with('error', 'Failed to verify certificate');
    }

    public function deleteCertificate($id = null)
    {
        // Check if user is logged in
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to(base_url('admin_login'));
        }

        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('admin/dashboard')->with('error', 'Certificate not found');
        }

        // Delete the certificate image if exists
        if (!empty($certificate['image_path'])) {
            $imagePath = FCPATH . $certificate['image_path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->certificateModel->delete($id)) {
            return redirect()->to('admin/dashboard')->with('message', 'Certificate deleted successfully');
        }

        return redirect()->to('admin/dashboard')->with('error', 'Failed to delete certificate');
    }

    public function getCertificateJson($id)
    {
        if (!$this->session->get('admin_logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return $this->response->setJSON(['error' => 'Certificate not found'])->setStatusCode(404);
        }

        return $this->response->setJSON($certificate);
    }

    public function getCertificateByNumber($certificateNumber)
    {
        if (!$this->session->get('admin_logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        // Decode the URL-encoded certificate number
        $certificateNumber = urldecode($certificateNumber);
        
        // Search for the certificate
        $certificate = $this->certificateModel->where('certificate_number', $certificateNumber)->first();
        
        if (!$certificate) {
            return $this->response->setJSON(['error' => 'Certificate not found'])->setStatusCode(404);
        }
        
        return $this->response->setJSON($certificate);
    }
}