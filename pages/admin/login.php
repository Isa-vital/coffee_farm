<?php

/**
 * Admin Login Page
 * Kiihabwemi Development Company Ltd
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../includes/functions.php';

session_start();

// Check if already logged in
if (isLoggedIn()) {
    redirect(SITE_URL . '/pages/admin/dashboard.php');
}

$error = '';
$loginAttempts = $_SESSION['login_attempts'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check login attempts
    if ($loginAttempts >= MAX_LOGIN_ATTEMPTS) {
        $error = 'Too many failed login attempts. Please try again later.';
    } else {
        $username = sanitizeInput($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            try {
                $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Successful login
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_role'] = $user['role'];
                    $_SESSION['last_activity'] = time();
                    $_SESSION['login_attempts'] = 0;

                    redirect(SITE_URL . '/pages/admin/dashboard.php');
                } else {
                    // Failed login
                    $_SESSION['login_attempts'] = $loginAttempts + 1;
                    $error = 'Invalid username or password.';
                }
            } catch (PDOException $e) {
                error_log("Login error: " . $e->getMessage());
                $error = 'An error occurred. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6F4E37 0%, #4B3621 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="<?php echo SITE_URL; ?>/assets/images/logo.jpg" alt="KDC Logo" height="60" class="mb-3">
                        <h3 class="fw-bold">Admin Login</h3>
                        <p class="text-muted">Enter your credentials to access the admin panel</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo e($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    required
                                    autofocus
                                    autocomplete="username">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', 'toggleIcon')">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-coffee btn-lg w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="<?php echo SITE_URL; ?>" class="text-decoration-none text-muted">
                            <i class="fas fa-arrow-left me-2"></i>Back to Website
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3 text-white small">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>

</html>