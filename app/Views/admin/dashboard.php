<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Certificate Verification System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            min-height: 100vh;
            display: flex;
        }

        .navbar {
            background-color: #007bff;
            padding: 1rem;
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1000;
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

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding-top: 1rem;
            z-index: 1001;
        }

        .sidebar-header {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header img {
            max-width: 120px;
            margin-bottom: 1rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white !important;
        }

        .sidebar-menu .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu .nav-link.active {
            background: #007bff;
            color: white !important;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: 70px;
            flex: 1;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .action-buttons .btn {
            margin-right: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="Logo">
            <h5 class="mb-0">Admin Panel</h5>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-add" href="#" data-bs-toggle="modal" data-bs-target="#addCertificateModal">
                        <i class="fas fa-plus-circle"></i> Add Certificate
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex align-items-center">
                <h5 class="text-white mb-0">Welcome, <?= session()->get('admin_username') ?></h5>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Certificates</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Certificate Number</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Work Period</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($certificates as $certificate): ?>
                                <tr>
                                    <td><?= esc($certificate['certificate_number']) ?></td>
                                    <td><?= esc($certificate['name']) ?></td>
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
                                        <a href="<?= base_url('admin/view/' . $certificate['id']) ?>" 
                                           class="btn btn-sm btn-info" 
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-primary btn-edit"
                                                data-id="<?= $certificate['id'] ?>"
                                                data-certificate='<?= json_encode($certificate) ?>'
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if (!$certificate['is_verified']): ?>
                                        <a href="<?= base_url('admin/verify/' . $certificate['id']) ?>" 
                                           class="btn btn-sm btn-success" 
                                           title="Verify"
                                           onclick="return confirm('Are you sure you want to verify this certificate?')">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/delete/' . $certificate['id']) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this certificate?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?= $pager->links() ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Certificate Modal -->
    <div class="modal fade" id="addCertificateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('admin/add') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="certificate_number" class="form-label">Certificate Number</label>
                                <input type="text" class="form-control" id="certificate_number" name="certificate_number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="certificate_image" class="form-label">Certificate Image</label>
                                <input type="file" class="form-control" id="certificate_image" name="certificate_image" accept="image/*" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="work_from_date" class="form-label">Work From Date</label>
                                <input type="date" class="form-control" id="work_from_date" name="work_from_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="work_to_date" class="form-label">Work To Date</label>
                                <input type="date" class="form-control" id="work_to_date" name="work_to_date" required>
                            </div>
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

    <!-- Edit Certificate Modal -->
    <div class="modal fade" id="editCertificateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCertificateForm" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_certificate_number" class="form-label">Certificate Number</label>
                                <input type="text" class="form-control" id="edit_certificate_number" name="certificate_number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="edit_designation" name="designation" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_certificate_image" class="form-label">Certificate Image</label>
                                <input type="file" class="form-control" id="edit_certificate_image" name="certificate_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep existing image</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_work_from_date" class="form-label">Work From Date</label>
                                <input type="date" class="form-control" id="edit_work_from_date" name="work_from_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_work_to_date" class="form-label">Work To Date</label>
                                <input type="date" class="form-control" id="edit_work_to_date" name="work_to_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Certificate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Handle edit button clicks
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const certificate = JSON.parse(this.dataset.certificate);
                const modal = document.getElementById('editCertificateModal');
                
                // Populate form fields
                modal.querySelector('[name="name"]').value = certificate.name;
                modal.querySelector('[name="certificate_number"]').value = certificate.certificate_number;
                modal.querySelector('[name="designation"]').value = certificate.designation;
                modal.querySelector('[name="work_from_date"]').value = certificate.work_from_date;
                modal.querySelector('[name="work_to_date"]').value = certificate.work_to_date;
                
                // Update form action
                modal.querySelector('form').action = `<?= base_url('admin/edit/') ?>${certificate.id}`;
                
                // Show modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });

        // Handle add button click
        document.querySelector('.btn-add').addEventListener('click', function() {
            const modal = document.getElementById('addCertificateModal');
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });

        // Handle modal close events
        ['addCertificateModal', 'editCertificateModal'].forEach(modalId => {
            const modal = document.getElementById(modalId);
            const bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);

            // Handle close button click
            modal.querySelector('.btn-close').addEventListener('click', function() {
                bsModal.hide();
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });

            // Handle modal hidden event
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    </script>
</body>
</html>