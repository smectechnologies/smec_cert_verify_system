<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Certificate Verification System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            padding: 20px;
        }
        .certificate-image {
            max-width: 100px;
            height: auto;
        }
        .action-buttons .btn {
            margin: 0 2px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3 class="text-white text-center mb-4">Admin Panel</h3>
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('admin/add_certificate') ?>">Add Certificate</a>
                <a href="<?= base_url('logout') ?>">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Certificates</h2>
                    <a href="<?= base_url('admin/add_certificate') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Certificate
                    </a>
                </div>

                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session('message') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Certificate Number</th>
                                <th>Designation</th>
                                <th>Work Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($certificates)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No certificates found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($certificates as $certificate): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($certificate['image_path'])): ?>
                                                <img src="<?= base_url($certificate['image_path']) ?>" alt="Certificate" class="certificate-image">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($certificate['name']) ?></td>
                                        <td><?= esc($certificate['certificate_number']) ?></td>
                                        <td><?= esc($certificate['designation']) ?></td>
                                        <td>
                                            <?= date('d M Y', strtotime($certificate['work_from_date'])) ?> to 
                                            <?= date('d M Y', strtotime($certificate['work_to_date'])) ?>
                                        </td>
                                        <td>
                                            <?php if ($certificate['is_verified']): ?>
                                                <span class="badge bg-success">Verified</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="<?= base_url('admin/view_certificate/' . $certificate['id']) ?>" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/edit_certificate/' . $certificate['id']) ?>" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (!$certificate['is_verified']): ?>
                                                <button onclick="verifyCertificate(<?= $certificate['id'] ?>)" class="btn btn-success btn-sm" title="Verify">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteCertificate(<?= $certificate['id'] ?>)" class="btn btn-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verifyCertificate(id) {
            if (confirm('Are you sure you want to verify this certificate?')) {
                fetch(`<?= base_url('admin/verify_certificate/') ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to verify certificate');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while verifying the certificate');
                });
            }
        }

        function deleteCertificate(id) {
            if (confirm('Are you sure you want to delete this certificate?')) {
                fetch(`<?= base_url('admin/delete_certificate/') ?>${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete certificate');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the certificate');
                });
            }
        }
    </script>
</body>
</html> 