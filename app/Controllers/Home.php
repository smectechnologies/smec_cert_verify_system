<?php

namespace App\Controllers;

use App\Models\CertificateModel;

class Home extends BaseController
{
    protected $certificateModel;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
    }

    public function index()
    {
        return view('home');
    }

    public function verify()
    {
        // Get certificate number from POST data
        $certificateNumber = $this->request->getJSON()->certificate_number ?? null;

        if (!$certificateNumber) {
            return $this->response->setJSON(['error' => 'Please enter a certificate number'])->setStatusCode(400);
        }

        $certificate = $this->certificateModel->where('certificate_number', $certificateNumber)->first();
        
        if (!$certificate) {
            return $this->response->setJSON(['error' => 'Certificate not found'])->setStatusCode(404);
        }

        return $this->response->setJSON($certificate);
    }

    public function serveCertificate($filename)
    {
        $path = WRITEPATH . 'uploads/certificates/' . $filename;
        
        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
