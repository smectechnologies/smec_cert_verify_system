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

        .certificate-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .certificate-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .certificate-details dt {
            font-weight: 600;
            color: #495057;
        }

        .certificate-details dd {
            margin-bottom: 1rem;
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
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-add" href="#" data-bs-toggle="modal" data-bs-target="#addCertificateModal">
                        <i class="fas fa-plus-circle"></i> Add Certificate
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="<?= base_url('admin_logout') ?>">
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
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Certificate Details</h5>
                            <div>
                                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="certificate-details">
                                <dl class="row">
                                    <dt class="col-sm-3">Certificate Number</dt>
                                    <dd class="col-sm-9"><?= esc($certificate['certificate_number']) ?></dd>

                                    <dt class="col-sm-3">Name</dt>
                                    <dd class="col-sm-9"><?= esc($certificate['name']) ?></dd>

                                    <dt class="col-sm-3">Designation</dt>
                                    <dd class="col-sm-9"><?= esc($certificate['designation']) ?></dd>

                                    <dt class="col-sm-3">Work Period</dt>
                                    <dd class="col-sm-9">
                                        <?= date('d M Y', strtotime($certificate['work_from_date'])) ?> to 
                                        <?= date('d M Y', strtotime($certificate['work_to_date'])) ?>
                                    </dd>

                                    <dt class="col-sm-3">Status</dt>
                                    <dd class="col-sm-9">
                                        <?php if ($certificate['is_verified']): ?>
                                            <span class="badge bg-success">Verified</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php endif; ?>
                                    </dd>
                                </dl>
                            </div>

                            <div class="mt-4">
                                <h6>Certificate Image</h6>
                                <?php if (!empty($certificate['image_path'])): ?>
                                    <img src="<?= base_url($certificate['image_path']) ?>" 
                                         alt="Certificate" 
                                         class="certificate-image">
                                <?php else: ?>
                                    <p class="text-muted">No image available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>
</html> 