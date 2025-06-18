<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Certificate</h2>
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= esc($certificate['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="certificate_number" class="form-label">Certificate Number</label>
                <input type="text" class="form-control" id="certificate_number" name="certificate_number" value="<?= esc($certificate['certificate_number']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?= esc($certificate['designation']) ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="work_from_date" class="form-label">Work From Date</label>
                    <input type="date" class="form-control" id="work_from_date" name="work_from_date" value="<?= esc($certificate['work_from_date']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="work_to_date" class="form-label">Work To Date</label>
                    <input type="date" class="form-control" id="work_to_date" name="work_to_date" value="<?= esc($certificate['work_to_date']) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="certificate_image" class="form-label">Certificate Image</label>
                <input type="file" class="form-control" id="certificate_image" name="certificate_image">
                <?php if (!empty($certificate['image_path'])): ?>
                    <img src="<?= base_url($certificate['image_path']) ?>" alt="Certificate Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Certificate</button>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
