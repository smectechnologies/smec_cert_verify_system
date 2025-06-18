<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate - SMEC Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #007bff;
            padding: 1rem;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }

        .nav-link:hover {
            color: white !important;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        .certificate-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .certificate-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .certificate-image:hover {
            transform: scale(1.02);
        }

        .certificate-details dt {
            font-weight: 600;
            color: #495057;
        }

        .certificate-details dd {
            margin-bottom: 1rem;
        }

        .verification-badge {
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            margin-top: auto;
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
            width: 210mm; /* A4 width */
            height: 297mm; /* A4 height */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: contain;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                height: auto;
                max-height: 90vh;
            }

            .container {
                padding: 10px;
            }

            .verification-box {
                padding: 15px;
            }

            .verification-box h2 {
                font-size: 1.5rem;
            }

            .verification-box p {
                font-size: 0.9rem;
            }

            .certificate-image {
                max-width: 100%;
                margin: 10px 0;
            }

            .btn-verify {
                padding: 8px 20px;
                font-size: 0.9rem;
            }

            .form-control {
                font-size: 0.9rem;
                padding: 8px;
            }

            .navbar-brand img {
                max-width: 150px;
            }

            .navbar-toggler {
                padding: 4px 8px;
            }
        }

        @media (max-width: 576px) {
            .verification-box {
                padding: 10px;
            }

            .verification-box h2 {
                font-size: 1.3rem;
            }

            .verification-box p {
                font-size: 0.85rem;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .btn-verify {
                width: 100%;
                margin-top: 10px;
            }

            .navbar-brand img {
                max-width: 120px;
            }

            .modal-content {
                width: 100%;
                padding: 10px;
            }

            .close-modal {
                top: 10px;
                right: 20px;
                font-size: 30px;
            }
        }

        @media (max-width: 480px) {
            .verification-box h2 {
                font-size: 1.2rem;
            }

            .verification-box p {
                font-size: 0.8rem;
            }

            .form-control {
                font-size: 0.8rem;
                padding: 6px;
            }

            .btn-verify {
                font-size: 0.8rem;
                padding: 6px 15px;
            }

            .navbar-brand img {
                max-width: 100px;
            }

            .modal-content {
                padding: 5px;
            }
        }

        /* Print styles */
        @media print {
            .navbar,
            .btn-verify,
            .footer {
                display: none;
            }

            .verification-box {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .certificate-image {
                max-width: 100%;
                page-break-inside: avoid;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="Logo" height="40" class="me-2">
                Certificate Verification
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <?= esc($error) ?>
                        </div>
                        <div class="text-center mt-4">
                            <a href="<?= base_url() ?>" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Back to Home
                            </a>
                        </div>
                    <?php elseif (isset($certificate)): ?>
                        <div class="certificate-card">
                            <div class="text-center mb-4">
                                <h2 class="mb-3">Certificate Verification Result</h2>
                                <?php if (isset($certificate['is_verified']) && $certificate['is_verified']): ?>
                                    <span class="verification-badge bg-success text-white">
                                        <i class="fas fa-check-circle"></i> Verified Certificate
                                    </span>
                                <?php else: ?>
                                    <span class="verification-badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Pending Verification
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="certificate-details">
                                        <dt>Certificate Number</dt>
                                        <dd><?= esc($certificate['certificate_number'] ?? 'N/A') ?></dd>

                                        <dt>Name</dt>
                                        <dd><?= esc($certificate['name'] ?? 'N/A') ?></dd>

                                        <dt>Designation</dt>
                                        <dd><?= esc($certificate['designation'] ?? 'N/A') ?></dd>

                                        <dt>Work Period</dt>
                                        <dd>
                                            <?= !empty($certificate['work_from_date']) ? date('d M Y', strtotime($certificate['work_from_date'])) : 'N/A' ?> to 
                                            <?= !empty($certificate['work_to_date']) ? date('d M Y', strtotime($certificate['work_to_date'])) : 'N/A' ?>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <?php if (!empty($certificate['image_path'])): ?>
                                        <div class="text-center">
                                            <h6 class="mb-3">Certificate Image</h6>
                                            <img src="<?= base_url($certificate['image_path']) ?>" 
                                                 alt="Certificate" 
                                                 class="certificate-image"
                                                 onerror="this.onerror=null; this.src='<?= base_url('assets/images/no-image.png') ?>';">
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>No image available</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?= base_url() ?>" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to Home
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> SMEC Labs. All rights reserved.eee</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const closeBtn = document.querySelector('.close-modal');
            const certificateImg = document.querySelector('.certificate-image');

            if (certificateImg) {
                certificateImg.onclick = function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                }
            }

            closeBtn.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Close modal with ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    modal.style.display = "none";
                }
            });
        });
    </script>
</body>
</html> 