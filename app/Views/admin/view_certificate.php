<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificate - SMEC Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h4 class="mb-4">SMEC Labs</h4>
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
                <div class="header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Certificate Details</h4>
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>

                <div class="row">
                    <!-- Certificate Image -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Certificate Image</h5>
                                <?php if (!empty($certificate['image_path'])): ?>
                                    <img src="<?= base_url($certificate['image_path']) ?>" 
                                         alt="Certificate" 
                                         class="certificate-image">
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        No image available
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Details -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Certificate Information</h5>
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
                                                <span class="badge bg-warning status-badge">Pending</span>
                                            <?php endif; ?>
                                        </dd>

                                        <dt class="col-sm-4">Created At:</dt>
                                        <dd class="col-sm-8"><?= date('F j, Y g:i A', strtotime($certificate['created_at'])) ?></dd>

                                        <dt class="col-sm-4">Last Updated:</dt>
                                        <dd class="col-sm-8"><?= date('F j, Y g:i A', strtotime($certificate['updated_at'])) ?></dd>
                                    </dl>
                                </div>

                                <div class="mt-4">
                                    <a href="<?= base_url('admin/edit_certificate/' . $certificate['id']) ?>" 
                                       class="btn btn-primary me-2">
                                        <i class="fas fa-edit me-2"></i> Edit Certificate
                                    </a>
                                    <?php if (!$certificate['is_verified']): ?>
                                        <button onclick="verifyCertificate(<?= $certificate['id'] ?>)" 
                                                class="btn btn-success me-2">
                                            <i class="fas fa-check me-2"></i> Verify Certificate
                                        </button>
                                    <?php endif; ?>
                                    <button onclick="deleteCertificate(<?= $certificate['id'] ?>)" 
                                            class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i> Delete Certificate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verifyCertificate(id) {
            if (confirm('Are you sure you want to verify this certificate?')) {
                $.post('<?= base_url('admin/verify_certificate/') ?>' + id, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to verify certificate');
                    }
                });
            }
        }

        function deleteCertificate(id) {
            if (confirm('Are you sure you want to delete this certificate? This action cannot be undone.')) {
                $.post('<?= base_url('admin/delete_certificate/') ?>' + id, function(response) {
                    if (response.success) {
                        window.location.href = '<?= base_url('admin/dashboard') ?>';
                    } else {
                        alert('Failed to delete certificate');
                    }
                });
            }
        }
    </script>
</body>
</html> 