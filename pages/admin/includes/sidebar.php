<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar admin-sidebar">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="KDC Logo" height="50" class="mb-2"
                onerror="this.style.display='none'">
            <h5 class="text-white">Admin Panel</h5>
            <p class="text-white-50 small mb-0">Welcome, <?php echo e($_SESSION['admin_username']); ?></p>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/products.php">
                    <i class="fas fa-box me-2"></i>Products
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/orders.php">
                    <i class="fas fa-shopping-cart me-2"></i>Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'messages.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/messages.php">
                    <i class="fas fa-envelope me-2"></i>Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'team.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/team.php">
                    <i class="fas fa-users me-2"></i>Team Members
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>"
                    href="<?php echo SITE_URL; ?>/pages/admin/settings.php">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
            </li>
            <li class="nav-item mt-3 pt-3 border-top border-secondary">
                <a class="admin-nav-link" href="<?php echo SITE_URL; ?>/" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i>View Website
                </a>
            </li>
            <li class="nav-item">
                <a class="admin-nav-link" href="<?php echo SITE_URL; ?>/pages/admin/logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>