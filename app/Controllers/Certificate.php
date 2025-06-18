<?php

namespace App\Controllers;

use App\Models\CertificateModel;

class Certificate extends BaseController
{
    protected $certificateModel;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
    }

    public function verify()
    {
        $certificateNumber = $this->request->getGet('certificate_number');
        
        if (empty($certificateNumber)) {
            return view('verify', [
                'error' => 'Please enter a certificate number',
                'certificate' => null
            ]);
        }

        $certificate = $this->certificateModel->where('certificate_number', $certificateNumber)->first();

        if (!$certificate) {
            return view('verify', [
                'error' => 'Certificate not found',
                'certificate' => null
            ]);
        }

        // Format the image path correctly
        if (!empty($certificate['image_path'])) {
            $certificate['image_path'] = 'writable/uploads/certificates/' . basename($certificate['image_path']);
        }

        return view('verify', [
            'certificate' => $certificate,
            'error' => null
        ]);
    }
} 