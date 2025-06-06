<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SMEC Labs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
        }
        .btn-login {
            background-color: #2c3e50;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #34495e;
        }
        .alert {
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Admin Login</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('message')): ?>
                        <div class="alert alert-success">
                            <?= session('message') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin_login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   id="username" name="username" 
                                   value="<?= old('username') ?>" required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                   id="password" name="password" required>
                            <?php if (session('errors.password')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 