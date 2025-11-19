<?php

/**
 * Settings Management - Admin Panel
 * Kiihabwemi Development Company Ltd
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db_connect.php';
require_once __DIR__ . '/../../includes/functions.php';

session_start();

// Check if logged in
if (!isLoggedIn()) {
    redirect(SITE_URL . '/pages/admin/login.php');
}

// Check session timeout
if (checkSessionTimeout()) {
    redirect(SITE_URL . '/pages/admin/login.php');
}

$success = '';
$error = '';

// Create settings table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(100) NOT NULL,
        `setting_value` text,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Insert default settings if table is empty
    $count = fetchOne($pdo, "SELECT COUNT(*) as count FROM settings")['count'];
    if ($count == 0) {
        $defaultSettings = [
            ['whatsapp_number', '256700000000'],
            ['site_email', 'info@kdc.com'],
            ['site_phone', '+256 700 000 000'],
            ['site_address', 'Kiihabwemi Village, Uganda'],
            ['facebook_url', 'https://facebook.com/kdc'],
            ['twitter_url', 'https://twitter.com/kdc'],
            ['instagram_url', 'https://instagram.com/kdc'],
            ['linkedin_url', 'https://linkedin.com/company/kdc'],
        ];

        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
        foreach ($defaultSettings as $setting) {
            $stmt->execute($setting);
        }
    }
} catch (PDOException $e) {
    // Table already exists
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    try {
        $updateCount = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== 'update_settings') {
                $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                                      ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$key, $value]);
                $updateCount++;
            }
        }
        $success = "Settings updated successfully! ($updateCount fields updated)";
    } catch (PDOException $e) {
        $error = 'Error updating settings: ' . $e->getMessage();
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All password fields are required.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New passwords do not match.';
    } elseif (strlen($newPassword) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        try {
            // Verify current password
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['admin_id']]);
            $user = $stmt->fetch();

            if ($user && password_verify($currentPassword, $user['password'])) {
                // Update password
                $newHash = password_hash($newPassword, PASSWORD_ARGON2ID);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$newHash, $_SESSION['admin_id']]);
                $success = 'Password changed successfully!';
            } else {
                $error = 'Current password is incorrect.';
            }
        } catch (PDOException $e) {
            $error = 'Error changing password: ' . $e->getMessage();
        }
    }
}

// Get current settings
$settingsData = fetchAll($pdo, "SELECT * FROM settings");
$settings = [];
foreach ($settingsData as $setting) {
    $settings[$setting['setting_key']] = $setting['setting_value'];
}

$pageTitle = 'Settings - ' . SITE_NAME;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include __DIR__ . '/includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Settings</h1>
                </div>

                <!-- Alert Messages -->
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo e($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo e($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- General Settings -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>General Settings</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">WhatsApp Number</label>
                                        <input type="text" class="form-control" name="whatsapp_number"
                                            value="<?php echo e($settings['whatsapp_number'] ?? ''); ?>"
                                            placeholder="256700000000">
                                        <small class="text-muted">Include country code (e.g., 256700000000)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Site Email</label>
                                        <input type="email" class="form-control" name="site_email"
                                            value="<?php echo e($settings['site_email'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Site Phone</label>
                                        <input type="text" class="form-control" name="site_phone"
                                            value="<?php echo e($settings['site_phone'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Site Address</label>
                                        <textarea class="form-control" name="site_address" rows="2"><?php echo e($settings['site_address'] ?? ''); ?></textarea>
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="mb-3">Social Media Links</h6>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fab fa-facebook me-2"></i>Facebook URL</label>
                                        <input type="url" class="form-control" name="facebook_url"
                                            value="<?php echo e($settings['facebook_url'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fab fa-twitter me-2"></i>Twitter URL</label>
                                        <input type="url" class="form-control" name="twitter_url"
                                            value="<?php echo e($settings['twitter_url'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fab fa-instagram me-2"></i>Instagram URL</label>
                                        <input type="url" class="form-control" name="instagram_url"
                                            value="<?php echo e($settings['instagram_url'] ?? ''); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fab fa-linkedin me-2"></i>LinkedIn URL</label>
                                        <input type="url" class="form-control" name="linkedin_url"
                                            value="<?php echo e($settings['linkedin_url'] ?? ''); ?>">
                                    </div>

                                    <button type="submit" name="update_settings" class="btn btn-coffee">
                                        <i class="fas fa-save me-2"></i>Save Settings
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Change Password</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                        <small class="text-muted">Minimum 8 characters</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>

                                    <button type="submit" name="change_password" class="btn btn-primary w-100">
                                        <i class="fas fa-key me-2"></i>Change Password
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>System Info</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Admin:</strong> <?php echo e($_SESSION['admin_username']); ?></p>
                                <p><strong>Role:</strong> <?php echo e(ucfirst($_SESSION['admin_role'])); ?></p>
                                <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
                                <p><strong>Database:</strong> MySQL</p>
                                <hr>
                                <a href="<?php echo SITE_URL; ?>/pages/admin/logout.php" class="btn btn-danger w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>