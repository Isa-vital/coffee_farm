<?php

/**
 * Admin Dashboard - Kiihabwemi Development Company Ltd
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

// Get dashboard statistics
try {
    // Total products
    $totalProducts = fetchOne($pdo, "SELECT COUNT(*) as count FROM products WHERE status = 'active'")['count'];

    // Low stock products
    $lowStockProducts = fetchOne($pdo, "SELECT COUNT(*) as count FROM products WHERE stock_quantity < 10 AND status = 'active'")['count'];

    // Total messages
    $totalMessages = fetchOne($pdo, "SELECT COUNT(*) as count FROM messages WHERE status = 'new'")['count'];

    // Total inventory value
    $inventoryValue = fetchOne($pdo, "SELECT SUM(price * stock_quantity) as total FROM products WHERE status = 'active'")['total'] ?? 0;

    // Recent products
    $recentProducts = fetchAll($pdo, "SELECT * FROM products ORDER BY created_at DESC LIMIT 5");

    // Recent messages
    $recentMessages = fetchAll($pdo, "SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $totalProducts = $lowStockProducts = $totalMessages = 0;
    $inventoryValue = 0;
    $recentProducts = $recentMessages = [];
}

$pageTitle = 'Admin Dashboard - ' . SITE_NAME;
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
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-calendar me-1"></i><?php echo date('F d, Y'); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 opacity-75">Total Products</h6>
                                        <h2 class="card-title mb-0"><?php echo $totalProducts; ?></h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-box fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-warning text-dark h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 opacity-75">Low Stock</h6>
                                        <h2 class="card-title mb-0"><?php echo $lowStockProducts; ?></h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 opacity-75">New Messages</h6>
                                        <h2 class="card-title mb-0"><?php echo $totalMessages; ?></h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-envelope fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 opacity-75">Inventory Value</h6>
                                        <h2 class="card-title mb-0"><?php echo formatPrice($inventoryValue); ?></h2>
                                    </div>
                                    <div>
                                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Products and Messages -->
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Recent Products</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentProducts)): ?>
                                                <?php foreach ($recentProducts as $product): ?>
                                                    <tr>
                                                        <td><?php echo e($product['name']); ?></td>
                                                        <td><?php echo formatPrice($product['price']); ?></td>
                                                        <td>
                                                            <?php if ($product['stock_quantity'] < 10): ?>
                                                                <span class="badge bg-danger"><?php echo $product['stock_quantity']; ?></span>
                                                            <?php else: ?>
                                                                <?php echo $product['stock_quantity']; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-<?php echo $product['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                                <?php echo ucfirst($product['status']); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No products yet</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Recent Messages</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($recentMessages)): ?>
                                                <?php foreach ($recentMessages as $message): ?>
                                                    <tr>
                                                        <td><?php echo e($message['name']); ?></td>
                                                        <td><?php echo e(truncateText($message['subject'], 30)); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($message['created_at'])); ?></td>
                                                        <td>
                                                            <span class="badge bg-<?php echo $message['status'] === 'new' ? 'primary' : 'secondary'; ?>">
                                                                <?php echo ucfirst($message['status']); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No messages yet</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>

</html>