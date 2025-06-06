<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMEC Labs - Certificate Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-logo-container {
            text-align: center;
            margin: 30px 0;
        }
        .main-logo-container img {
            max-width: 300px;
            height: auto;
        }
        .search-container {
            max-width: 600px;
            margin: 0 auto 40px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .search-box {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .search-button {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
        .partner-logos {
            padding: 40px 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .partner-logos h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .logo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }
        .logo-item {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        .logo-item:hover {
            transform: translateY(-5px);
        }
        .logo-item img {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
        .logo-item h4 {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-logo-container">
            <img src="<?= base_url('assets/images/smec-labs-logo.png') ?>" alt="SMEC Labs Logo">
        </div>
        
        <div class="search-container">
            <form action="<?= base_url('certificate/verify') ?>" method="GET">
                <input type="text" name="certificate_number" class="search-box" placeholder="Enter Certificate Number" required>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Verify Certificate
                </button>
            </form>
        </div>

        <div class="partner-logos">
            <h2>Our Partners</h2>
            <div class="logo-grid">
                <!-- Partner 1 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner1.png') ?>" alt="Partner 1">
                    <h4>Partner Name 1</h4>
                </div>
                <!-- Partner 2 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner2.png') ?>" alt="Partner 2">
                    <h4>Partner Name 2</h4>
                </div>
                <!-- Partner 3 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner3.png') ?>" alt="Partner 3">
                    <h4>Partner Name 3</h4>
                </div>
                <!-- Partner 4 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner4.png') ?>" alt="Partner 4">
                    <h4>Partner Name 4</h4>
                </div>
                <!-- Partner 5 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner5.png') ?>" alt="Partner 5">
                    <h4>Partner Name 5</h4>
                </div>
                <!-- Partner 6 -->
                <div class="logo-item">
                    <img src="<?= base_url('assets/images/partner6.png') ?>" alt="Partner 6">
                    <h4>Partner Name 6</h4>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?= date('Y') ?> SMEC Labs. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 