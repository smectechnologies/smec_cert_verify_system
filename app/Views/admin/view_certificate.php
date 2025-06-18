<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificate - SMEC Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar .nav-link {
            color: white;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #34495e;
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
        }
        .main-content {
            padding: 20px;
        }
        .header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .certificate-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .certificate-image:hover {
            transform: scale(1.02);
        }
        .certificate-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .certificate-details dt {
            font-weight: bold;
            color: #2c3e50;
        }
        .certificate-details dd {
            margin-bottom: 15px;
        }
        .status-badge {
            font-size: 1rem;
            padding: 8px 15px;
        }
        .sidebar-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
        }
        .sidebar-title {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
        /* Image Modal styles */
        .image-view-modal .modal-dialog {
            max-width: 90% !important;
            margin: 1.75rem auto !important;
        }
        .image-view-modal .modal-content {
            background-color: transparent !important;
            border: none !important;
        }
        .image-view-modal .modal-body {
            padding: 0 !important;
            text-align: center !important;
        }
        .image-view-modal .close-button {
            position: absolute !important;
            right: 10px !important;
            top: 10px !important;
            color: white !important;
            font-size: 2rem !important;
            text-shadow: 0 0 5px rgba(0,0,0,0.5) !important;
            cursor: pointer !important;
            z-index: 1050 !important;
        }
        .image-view-modal .modal-image {
            max-width: 100% !important;
            height: auto !important;
        }
        /* Edit Modal styles */
        .certificate-edit-modal .modal-dialog {
            max-width: 800px !important;
            margin: 1.75rem auto !important;
        }
        .certificate-edit-modal .modal-content {
            background-color: #f8f9fa !important;
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 0 30px rgba(0,0,0,0.15) !important;
        }
        .certificate-edit-modal .modal-header {
            background-color: #2c3e50 !important;
            border-bottom: none !important;
            padding: 1.5rem !important;
            border-radius: 15px 15px 0 0 !important;
        }
        .certificate-edit-modal .modal-title {
            color: white !important;
            font-weight: 600 !important;
        }
        .certificate-edit-modal .btn-close {
            filter: brightness(0) invert(1) !important;
        }
        .certificate-edit-modal .modal-body {
            background-color: #f8f9fa !important;
            padding: 2rem !important;
        }
        .certificate-edit-modal .modal-footer {
            background-color: #f8f9fa !important;
            border-top: 1px solid #dee2e6 !important;
            padding: 1.5rem !important;
            border-radius: 0 0 15px 15px !important;
        }
        .certificate-edit-modal .form-label {
            font-weight: 500 !important;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem !important;
        }
        .certificate-edit-modal .form-control {
            border-radius: 8px !important;
            border: 1px solid #dee2e6 !important;
            padding: 0.75rem 1rem !important;
            background-color: white !important;
            font-size: 1rem !important;
        }
        .certificate-edit-modal .form-control:focus {
            border-color: #3498db !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25) !important;
        }
        .certificate-edit-modal .btn {
            padding: 0.75rem 1.5rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
        }
        .certificate-edit-modal .btn-primary {
            background-color: #3498db !important;
            border-color: #3498db !important;
        }
        .certificate-edit-modal .btn-primary:hover {
            background-color: #2980b9 !important;
            border-color: #2980b9 !important;
        }
        .certificate-edit-modal .btn-secondary {
            background-color: #95a5a6 !important;
            border-color: #95a5a6 !important;
        }
        .certificate-edit-modal .btn-secondary:hover {
            background-color: #7f8c8d !important;
            border-color: #7f8c8d !important;
        }
        .certificate-edit-modal .current-image {
            max-width: 200px !important;
            height: auto !important;
            border-radius: 8px !important;
            margin-top: 10px !important;
            background-color: white !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="SMEC Labs Logo" class="sidebar-logo">
                    <div class="sidebar-title">SMEC Labs</div>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="<?= base_url('admin/add_certificate') ?>">
                        <i class="fas fa-plus-circle me-2"></i> Add Certificate
                    </a>
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="header">
                    <h2 class="mb-0">View Certificate</h2>
                </div>

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
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade image-view-modal" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</span>
                    <img src="" class="modal-image" id="modalImage">
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Certificate Modal -->
    <div class="modal fade certificate-edit-modal" id="editCertificateModal" tabindex="-1" aria-labelledby="editCertificateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCertificateModalLabel">Edit Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCertificateForm" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div id="editErrorAlert" class="alert alert-danger d-none"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_certificate_number" class="form-label">Certificate Number</label>
                            <input type="text" class="form-control" id="edit_certificate_number" name="certificate_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="edit_designation" name="designation" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_work_from_date" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="edit_work_from_date" name="work_from_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_work_to_date" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="edit_work_to_date" name="work_to_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_certificate_image" class="form-label">Certificate Image</label>
                            <input type="file" class="form-control" id="edit_certificate_image" name="certificate_image" accept="image/*">
                            <div id="currentImage" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        function openEditModal(certificate) {
            document.getElementById('edit_id').value = certificate.id;
            document.getElementById('edit_name').value = certificate.name;
            document.getElementById('edit_certificate_number').value = certificate.certificate_number;
            document.getElementById('edit_designation').value = certificate.designation;
            document.getElementById('edit_work_from_date').value = certificate.work_from_date;
            document.getElementById('edit_work_to_date').value = certificate.work_to_date;
            
            // Show current image if exists
            const currentImageDiv = document.getElementById('currentImage');
            if (certificate.image_path) {
                currentImageDiv.innerHTML = `<img src="${certificate.image_path}" alt="Current Certificate" class="current-image">`;
            } else {
                currentImageDiv.innerHTML = '<p>No current image</p>';
            }
            
            // Set form action
            document.getElementById('editCertificateForm').action = `<?= base_url('admin/edit_certificate/') ?>${certificate.id}`;
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editCertificateModal')).show();
        }

        document.getElementById('editCertificateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const errorAlert = document.getElementById('editErrorAlert');
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Hide any previous error
            errorAlert.classList.add('d-none');
            errorAlert.innerHTML = '';
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        window.location.href = '<?= base_url('admin/dashboard') ?>';
                    } else {
                        errorAlert.classList.remove('d-none');
                        if (data.errors) {
                            const errorMessages = Object.values(data.errors).join('<br>');
                            errorAlert.innerHTML = errorMessages;
                        } else {
                            errorAlert.innerHTML = data.message || 'Failed to update certificate';
                        }
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Save Changes';
                    }
                } catch (e) {
                    // If response is not JSON, redirect to dashboard
                    window.location.href = '<?= base_url('admin/dashboard') ?>';
                    }
            })
            .catch(error => {
                console.error('Error:', error);
                errorAlert.classList.remove('d-none');
                errorAlert.innerHTML = `An error occurred while updating the certificate: ${error.message}`;
                submitButton.disabled = false;
                submitButton.innerHTML = 'Save Changes';
            });
        });
    </script>
</body>
</html> 