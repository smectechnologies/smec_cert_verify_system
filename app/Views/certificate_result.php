<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .result-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .certificate-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .status-badge {
            font-size: 1.2em;
            padding: 10px 20px;
        }
        .back-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="result-container">
            <h1 class="text-center mb-4">Certificate Verification Result</h1>

            <?php if (empty($certificate)): ?>
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Certificate Not Found!</h4>
                    <p>The certificate number you entered could not be found in our database.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-4">
                        <?php if (!empty($certificate['image_path'])): ?>
                            <img src="<?= base_url($certificate['image_path']) ?>" alt="Certificate" class="certificate-image">
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> No image available
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3>Certificate Details</h3>
                            <p><strong>Name:</strong> <?= esc($certificate['name']) ?></p>
                            <p><strong>Certificate Number:</strong> <?= esc($certificate['certificate_number']) ?></p>
                            <p><strong>Designation:</strong> <?= esc($certificate['designation']) ?></p>
                            <p><strong>Work Period:</strong> 
                                <?= date('d M Y', strtotime($certificate['work_from_date'])) ?> to 
                                <?= date('d M Y', strtotime($certificate['work_to_date'])) ?>
                            </p>
                            <p><strong>Status:</strong> 
                                <?php if ($certificate['is_verified']): ?>
                                    <span class="badge bg-success status-badge">Verified</span>
                                <?php else: ?>
                                    <span class="badge bg-warning status-badge">Pending Verification</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center back-link">
                <a href="<?= base_url() ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Verification
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 