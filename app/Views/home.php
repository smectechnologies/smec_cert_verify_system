<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMEC Labs - Certificate Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-logo-container {
            text-align: center;
            margin: 30px 0;
        }
        .main-logo-container img {
            max-width: 300px;
            height: auto;
            margin-top: 20px;
            margin-bottom: 80px;
        }
        .search-container {
            max-width: 600px;
            width: 100%;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: auto;
            margin-top: 50px;
            margin-bottom: 30px;
        }
        .search-box {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .search-button {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
        .partner-logos {
            padding: 40px 0;
            margin-top: auto;
            margin-bottom: 30px;
        }
        .partner-logos h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .logo-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            padding: 0 20px;
        }
        .logo-item {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        .logo-item:hover {
            transform: translateY(-5px);
        }
        .logo-item img {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        .logo-item h4 {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            color: #666;
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 0;
        }
        .hero-logo {
            max-width: 300px;
            height: auto;
            margin-top: 20px;
            margin-bottom: 100px;
        }
        .portal-heading {
            text-align: center;
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .portal-subheading {
            text-align: center;
            color: #34495e;
            font-size: 1.2rem;
            margin-bottom: 40px;
            font-weight: 400;
        }
        .certificate-image {
            transition: transform 0.3s ease;
            max-width: 200px;
            height: auto;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .certificate-image:hover {
            transform: scale(1.05);
        }
        #imageModal .modal-dialog {
            max-width: 90%;
            margin: 1.75rem auto;
        }
        #imageModal .modal-content {
            background-color: rgba(0, 0, 0, 0.9);
        }
        #imageModal .modal-header {
            border-bottom: none;
            padding: 1rem;
        }
        #imageModal .modal-title {
            color: white;
        }
        #imageModal .btn-close {
            filter: brightness(0) invert(1);
        }
        #imageModal .modal-body {
            padding: 0;
        }
        #modalImage {
            max-height: 80vh;
            width: auto;
            margin: 0 auto;
        }
        .certificate-thumbnail {
            text-align: center;
            margin-top: 20px;
        }
        .certificate-thumbnail img {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .certificate-thumbnail img:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .modal-content {
                max-width: 95%;
            }
        }

        /* Media Queries */
        @media (max-width: 1200px) {
            .main-logo-container img {
                max-width: 250px;
            }
            
            .search-container {
                max-width: 500px;
            }
            
            .logo-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .main-logo-container img {
                max-width: 200px;
                margin-bottom: 50px;
            }

            .portal-heading {
                font-size: 2rem;
            }

            .portal-subheading {
                font-size: 1.1rem;
            }

            .search-container {
                padding: 20px;
            }

            .logo-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-logo-container img {
                max-width: 180px;
                margin-bottom: 30px;
            }

            .portal-heading {
                font-size: 1.8rem;
            }

            .portal-subheading {
                font-size: 1rem;
            }

            .search-container {
                max-width: 90%;
                padding: 15px;
            }

            .search-box {
                padding: 12px;
                font-size: 14px;
            }

            .search-button {
                padding: 12px;
                font-size: 14px;
            }

            .logo-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .logo-item img {
                max-width: 120px;
            }
        }

        @media (max-width: 576px) {
            .main-logo-container img {
                max-width: 150px;
                margin-bottom: 10px;
            }

            .portal-heading {
                font-size: 1.5rem;
            }

            .portal-subheading {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .search-container {
                padding: 12px;
            }

            .search-box {
                padding: 10px;
                font-size: 13px;
            }

            .search-button {
                padding: 10px;
                font-size: 13px;
            }

            .logo-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .logo-item {
                padding: 10px;
            }

            .logo-item img {
                max-width: 100px;
            }

            .footer {
                font-size: 0.9rem;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .main-logo-container img {
                max-width: 120px;
            }

            .portal-heading {
                font-size: 1.3rem;
            }

            .portal-subheading {
                font-size: 0.85rem;
            }

            .search-container {
                padding: 10px;
            }

            .search-box {
                padding: 8px;
                font-size: 12px;
            }

            .search-button {
                padding: 8px;
                font-size: 12px;
            }

            .logo-item h4 {
                font-size: 12px;
            }
        }

        /* Print styles */
        @media print {
            .main-logo-container,
            .partner-logos,
            .footer {
                display: none;
            }

            .search-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }

            body {
                background-color: white;
            }
        }

        .search-box::placeholder {
            color: #999;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .search-box::placeholder {
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .search-box::placeholder {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .search-box::placeholder {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Add modal HTML at the start of body -->
    <div id="imageModal" class="modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <div class="container">
        <div class="text-center">
            <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="SMEC Labs Logo" class="hero-logo">
            <h1 class="portal-heading">SMEC Certificate Verification Portal</h1>
            <p class="portal-subheading">Verify the authenticity of your SMEC certificates</p>
        </div>
        
        <div class="content-wrapper">
        <div class="search-container">
                <h1 class="mb-4">Verify Your Certificate</h1>
                <p class="mb-4">Enter your certificate number to verify its authenticity</p>
                <form action="<?= base_url('verify') ?>" method="get" class="mb-3">
                    <div class="input-group">
                        <input type="text" 
                               name="certificate_number" 
                               class="form-control form-control-lg search-input" 
                               placeholder="Enter Certificate Number"
                               required>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i> Verify
                        </button>
                    </div>
                </form>
                <div id="searchResult" class="mt-4"></div>
            </div>
        </div>

        <div class="partner-logos">
            <div class="logo-grid">
                <!-- Row 1 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smeclabs.webp') ?>" alt="Partner 1">
                </div>
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smecmarine.png') ?>" alt="Partner 2">
                </div>
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smecautomation.png') ?>" alt="Partner 3">
                </div>
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smec4indystry.png') ?>" alt="Partner 4">
                </div>
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smecrobotics.png') ?>" alt="Partner 5">
                </div>
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/smectechnologies.png') ?>" alt="Partner 6">
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?= date('Y') ?> SMEC Labs. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchCertificate(event) {
            event.preventDefault();
            
            const certificateNumber = document.getElementById('certificate_number').value;
            const resultDiv = document.getElementById('searchResult');
            
            // Show loading state
            resultDiv.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Verifying certificate...</div>';
            
            // Make AJAX request
            fetch(`<?= base_url('certificate/verify') ?>`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ certificate_number: certificateNumber })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    resultDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> ${data.error}
                        </div>
                    `;
                } else {
                    const imagePath = data.image_path ? `<?= base_url() ?>/${data.image_path}` : '<?= base_url() ?>/assets/images/no-image.png';
                    resultDiv.innerHTML = `
                        <div class="alert alert-success">
                            <h4 class="alert-heading">Certificate Verified!</h4>
                            <p><strong>Name:</strong> ${data.name}</p>
                            <p><strong>Certificate Number:</strong> ${data.certificate_number}</p>
                            <p><strong>Designation:</strong> ${data.designation}</p>
                            <p><strong>Work Period:</strong> ${data.work_from_date} to ${data.work_to_date}</p>
                            <p><strong>Status:</strong> ${data.is_verified ? 'Verified' : 'Pending Verification'}</p>
                            <div class="certificate-thumbnail">
                                <img src="${imagePath}" 
                                     alt="Certificate" 
                                     onclick="openImageModal('${imagePath}')"
                                     class="img-fluid">
                                <p class="text-muted mt-2">Click image to view full size</p>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> An error occurred while verifying the certificate.
                    </div>
                `;
            });
            
            return false;
        }

        function openImageModal(imageSrc) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const closeBtn = document.querySelector('.close-modal');
            const certificateImg = document.querySelector('.certificate-thumbnail img');

            certificateImg.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            }

            closeBtn.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>
</html> 