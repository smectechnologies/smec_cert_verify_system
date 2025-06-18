<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,.1);
            color: white;
        }
        .sidebar .nav-link.active {
            background: #007bff;
            color: white;
        }
        .main-content {
            padding: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h3 class="mb-4">Admin Panel</h3>
                <nav class="nav flex-column">
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="<?= base_url('admin/add') ?>">
                        <i class="fas fa-plus-circle me-2"></i> Add Certificate
                    </a>
                    <a class="nav-link" href="<?= base_url('admin_logout') ?>">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit Certificate</h2>
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= session('error') ?>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form action="<?= base_url('admin/edit/' . $certificate['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= esc($certificate['name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="certificate_number" class="form-label">Certificate Number</label>
                                <input type="text" class="form-control" id="certificate_number" name="certificate_number" value="<?= esc($certificate['certificate_number']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?= esc($certificate['designation']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="certificate_image" class="form-label">Certificate Image</label>
                                <?php if (!empty($certificate['image_path'])): ?>
                                    <div>
                                        <img src="<?= base_url($certificate['image_path']) ?>" class="current-image" alt="Current Certificate">
                                        <p class="text-muted">Current image</p>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="certificate_image" name="certificate_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="work_from_date" class="form-label">Work From Date</label>
                                <input type="date" class="form-control" id="work_from_date" name="work_from_date" value="<?= $certificate['work_from_date'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="work_to_date" class="form-label">Work To Date</label>
                                <input type="date" class="form-control" id="work_to_date" name="work_to_date" value="<?= $certificate['work_to_date'] ?>" required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Certificate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 