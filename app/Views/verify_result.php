<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification - SMEC Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }
        .company-name {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .verification-title {
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        .certificate-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .certificate-details dt {
            font-weight: 600;
            color: #2c3e50;
        }
        .certificate-details dd {
            margin-bottom: 15px;
        }
        .status-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 30px;
        }
        .certificate-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .certificate-image:hover {
            transform: scale(1.02);
        }
        .back-button {
            margin-top: 20px;
        }
        /* Modal styles */
        .modal-image {
            max-width: 100%;
            height: auto;
        }
        .modal-dialog {
            max-width: 90%;
            margin: 1.75rem auto;
        }
        .modal-content {
            background-color: transparent;
            border: none;
        }
        .modal-body {
            padding: 0;
            text-align: center;
        }
        .close-button {
            position: absolute;
            right: 10px;
            top: 10px;
            color: white;
            font-size: 2rem;
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
            cursor: pointer;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verification-container">
            <div class="logo-container">
                <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="SMEC Labs Logo" class="logo">
                <div class="company-name">SMEC Labs</div>
            </div>
            
            <h1 class="verification-title">Certificate Verification Result</h1>

            <?php if (isset($certificate)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="certificate-details">
                            <dl class="row">
                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8"><?= esc($certificate['name']) ?></dd>

                                <dt class="col-sm-4">Certificate Number:</dt>
                                <dd class="col-sm-8"><?= esc($certificate['certificate_number']) ?></dd>

                                <dt class="col-sm-4">Designation:</dt>
                                <dd class="col-sm-8"><?= esc($certificate['designation']) ?></dd>

                                <dt class="col-sm-4">Work Period:</dt>
                                <dd class="col-sm-8">
                                    <?= date('d M Y', strtotime($certificate['work_from_date'])) ?> to 
                                    <?= date('d M Y', strtotime($certificate['work_to_date'])) ?>
                                </dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    <?php if ($certificate['is_verified']): ?>
                                        <span class="badge bg-success status-badge">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning status-badge">Pending Verification</span>
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php if (!empty($certificate['image_path'])): ?>
                            <img src="<?= base_url($certificate['image_path']) ?>" 
                                 alt="Certificate" 
                                 class="certificate-image"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal"
                                 onclick="openImageModal(this.src)">
                        <?php else: ?>
                            <p class="text-muted">No certificate image available</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Invalid or expired verification link. Please contact the administrator for assistance.
                </div>
            <?php endif; ?>

            <div class="text-center back-button">
                <a href="<?= base_url() ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</span>
                    <img src="" class="modal-image" id="modalImage">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                bootstrap.Modal.getInstance(this).hide();
            }
        });
    </script>
</body>
</html> 