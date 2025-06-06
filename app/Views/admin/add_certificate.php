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
                        <form action="<?= base_url('admin/add_certificate') ?>" method="post" id="addCertificateForm">
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