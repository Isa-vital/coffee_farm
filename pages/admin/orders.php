<?php

/**
 * Orders Management - Admin Panel
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

// Handle order status update
if (isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = sanitizeInput($_POST['status']);

    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $orderId]);
        $success = 'Order status updated successfully!';
    } catch (PDOException $e) {
        $error = 'Error updating order: ' . $e->getMessage();
    }
}

// Handle order deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = 'Order deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error deleting order: ' . $e->getMessage();
    }
}

// Get all orders with items
$orders = fetchAll($pdo, "SELECT o.*, COUNT(oi.id) as item_count 
                          FROM orders o 
                          LEFT JOIN order_items oi ON o.id = oi.order_id 
                          GROUP BY o.id 
                          ORDER BY o.created_at DESC");

// Get statistics
$totalOrders = fetchOne($pdo, "SELECT COUNT(*) as count FROM orders")['count'];
$pendingOrders = fetchOne($pdo, "SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")['count'];
$completedOrders = fetchOne($pdo, "SELECT COUNT(*) as count FROM orders WHERE status = 'completed'")['count'];
$totalRevenue = fetchOne($pdo, "SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'")['total'] ?? 0;

$pageTitle = 'Orders Management - ' . SITE_NAME;
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
                    <h1 class="h2">Orders Management</h1>
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

                <!-- Statistics Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="text-muted">Total Orders</h6>
                                <h3 class="mb-0"><?php echo $totalOrders; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="text-muted">Pending Orders</h6>
                                <h3 class="mb-0"><?php echo $pendingOrders; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="text-muted">Completed Orders</h6>
                                <h3 class="mb-0"><?php echo $completedOrders; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="text-muted">Total Revenue</h6>
                                <h3 class="mb-0"><?php echo formatPrice($totalRevenue); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><strong><?php echo e($order['order_number']); ?></strong></td>
                                                <td><?php echo e($order['customer_name']); ?></td>
                                                <td>
                                                    <small>
                                                        <?php echo e($order['customer_phone']); ?><br>
                                                        <?php echo e($order['customer_email']); ?>
                                                    </small>
                                                </td>
                                                <td><?php echo $order['item_count']; ?> items</td>
                                                <td><?php echo formatPrice($order['total_amount']); ?></td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $color = $statusColors[$order['status']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick='viewOrder(<?php echo json_encode($order); ?>)'>
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-primary" onclick='updateOrderStatus(<?php echo $order["id"]; ?>, "<?php echo $order["status"]; ?>")'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="?delete=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this order?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No orders yet. Orders will appear here when customers place them via WhatsApp.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="orderDetails">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="statusOrderId">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="orderStatus">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewOrder(order) {
            const details = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p><strong>Name:</strong> ${order.customer_name}</p>
                        <p><strong>Email:</strong> ${order.customer_email}</p>
                        <p><strong>Phone:</strong> ${order.customer_phone}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p><strong>Order Number:</strong> ${order.order_number}</p>
                        <p><strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                        <p><strong>Status:</strong> <span class="badge bg-info">${order.status}</span></p>
                    </div>
                </div>
                <hr>
                <h6>Delivery Address</h6>
                <p>${order.delivery_address}</p>
                <hr>
                <h6>Order Total</h6>
                <h4>UGX ${parseFloat(order.total_amount).toLocaleString()}</h4>
            `;
            document.getElementById('orderDetails').innerHTML = details;
            new bootstrap.Modal(document.getElementById('orderModal')).show();
        }

        function updateOrderStatus(orderId, currentStatus) {
            document.getElementById('statusOrderId').value = orderId;
            document.getElementById('orderStatus').value = currentStatus;
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        }
    </script>
</body>

</html>