<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home');
    }

    public function verifyCertificate()
    {
        $certificateNumber = $this->request->getGet('certificate_number');
        
        // Load the Certificate model
        $certificateModel = new \App\Models\CertificateModel();
        
        // Search for the certificate
        $certificate = $certificateModel->where('certificate_number', $certificateNumber)
                                      ->first();
        
        if ($certificate) {
            return view('certificate_result', ['certificate' => $certificate]);
        } else {
            return view('certificate_result', ['error' => 'Certificate not found']);
        }
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
