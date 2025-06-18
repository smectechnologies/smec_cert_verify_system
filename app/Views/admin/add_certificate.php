<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Certificate - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar a.active {
            background-color: #0d6efd;
        }
        .main-content {
            padding: 20px;
        }
        /* Add Certificate Modal styles */
        .certificate-add-modal .modal-dialog {
            max-width: 600px !important;
            margin: 1.75rem auto !important;
        }
        .certificate-add-modal .modal-content {
            background-color: #f8f9fa !important;
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 0 30px rgba(0,0,0,0.15) !important;
        }
        .certificate-add-modal .modal-header {
            background-color: #2c3e50 !important;
            border-bottom: none !important;
            padding: 1.5rem !important;
            border-radius: 15px 15px 0 0 !important;
        }
        .certificate-add-modal .modal-title {
            color: white !important;
            font-weight: 600 !important;
        }
        .certificate-add-modal .btn-close {
            filter: brightness(0) invert(1) !important;
        }
        .certificate-add-modal .modal-body {
            background-color: #f8f9fa !important;
            padding: 2rem !important;
        }
        .certificate-add-modal .modal-footer {
            background-color: #f8f9fa !important;
            border-top: 1px solid #dee2e6 !important;
            padding: 1.5rem !important;
            border-radius: 0 0 15px 15px !important;
        }
        .certificate-add-modal .form-label {
            font-weight: 500 !important;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem !important;
        }
        .certificate-add-modal .form-control {
            border-radius: 8px !important;
            border: 1px solid #dee2e6 !important;
            padding: 0.75rem 1rem !important;
            background-color: white !important;
            font-size: 1rem !important;
        }
        .certificate-add-modal .form-control:focus {
            border-color: #3498db !important;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25) !important;
        }
        .certificate-add-modal .btn {
            padding: 0.75rem 1.5rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
        }
        .certificate-add-modal .btn-primary {
            background-color: #3498db !important;
            border-color: #3498db !important;
        }
        .certificate-add-modal .btn-primary:hover {
            background-color: #2980b9 !important;
            border-color: #2980b9 !important;
        }
        .certificate-add-modal .btn-secondary {
            background-color: #95a5a6 !important;
            border-color: #95a5a6 !important;
        }
        .certificate-add-modal .btn-secondary:hover {
            background-color: #7f8c8d !important;
            border-color: #7f8c8d !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3 class="text-white text-center mb-4">Admin Panel</h3>
                <a href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                <a href="<?= base_url('admin/add_certificate') ?>" class="active"><i class="fas fa-plus-circle me-2"></i> Add Certificate</a>
                <a href="<?= base_url('admin/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Add New Certificate</h2>
                </div>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('admin/add_certificate') ?>" method="post" id="addCertificateForm" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="certificate_number" class="form-label">Certificate Number</label>
                                <input type="text" class="form-control" id="certificate_number" name="certificate_number" value="<?= old('certificate_number') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?= old('designation') ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="work_from_date" class="form-label">Work From Date</label>
                                        <input type="date" class="form-control" id="work_from_date" name="work_from_date" value="<?= old('work_from_date') ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="work_to_date" class="form-label">Work To Date</label>
                                        <input type="date" class="form-control" id="work_to_date" name="work_to_date" value="<?= old('work_to_date') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="certificate_image" class="form-label">Certificate Image (optional)</label>
                                <input type="file" class="form-control" id="certificate_image" name="certificate_image" accept="image/*">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Certificate</button>
                                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Certificate Modal -->
    <div class="modal fade certificate-add-modal" id="addCertificateModal" tabindex="-1" aria-labelledby="addCertificateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCertificateModalLabel">Add New Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCertificateForm" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div id="addErrorAlert" class="alert alert-danger d-none"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="certificate_number" class="form-label">Certificate Number</label>
                            <input type="text" class="form-control" id="certificate_number" name="certificate_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="work_from_date" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="work_from_date" name="work_from_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="work_to_date" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="work_to_date" name="work_to_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="certificate_image" class="form-label">Certificate Image</label>
                            <input type="file" class="form-control" id="certificate_image" name="certificate_image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Certificate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission
        document.getElementById('addCertificateForm').addEventListener('submit', function(e) {
            console.log('Form submitted');
            const formData = new FormData(this);
            console.log('Form data:', Object.fromEntries(formData));
        });

        // Date validation
        document.getElementById('work_from_date').addEventListener('change', function() {
            const toDate = document.getElementById('work_to_date');
            toDate.min = this.value;
        });

        document.getElementById('work_to_date').addEventListener('change', function() {
            const fromDate = document.getElementById('work_from_date');
            fromDate.max = this.value;
        });
    </script>
</body>
</html>