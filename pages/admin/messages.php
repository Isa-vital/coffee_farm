<?php

/**
 * Messages Management - Admin Panel
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

// Create messages table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `messages` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `subject` varchar(200) NOT NULL,
        `message` text NOT NULL,
        `status` enum('new','read','replied','archived') NOT NULL DEFAULT 'new',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (PDOException $e) {
    // Table already exists
}

// Handle message status update
if (isset($_POST['update_status'])) {
    $messageId = intval($_POST['message_id']);
    $newStatus = sanitizeInput($_POST['status']);

    try {
        $stmt = $pdo->prepare("UPDATE messages SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $messageId]);
        $success = 'Message status updated successfully!';
    } catch (PDOException $e) {
        $error = 'Error updating message: ' . $e->getMessage();
    }
}

// Handle message deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = 'Message deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error deleting message: ' . $e->getMessage();
    }
}

// Get all messages
$messages = fetchAll($pdo, "SELECT * FROM messages ORDER BY created_at DESC");

// Get statistics
$totalMessages = fetchOne($pdo, "SELECT COUNT(*) as count FROM messages")['count'];
$newMessages = fetchOne($pdo, "SELECT COUNT(*) as count FROM messages WHERE status = 'new'")['count'];
$readMessages = fetchOne($pdo, "SELECT COUNT(*) as count FROM messages WHERE status = 'read'")['count'];
$repliedMessages = fetchOne($pdo, "SELECT COUNT(*) as count FROM messages WHERE status = 'replied'")['count'];

$pageTitle = 'Messages Management - ' . SITE_NAME;
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
                    <h1 class="h2">Messages Management</h1>
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
                                <h6 class="text-muted">Total Messages</h6>
                                <h3 class="mb-0"><?php echo $totalMessages; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="text-muted">New Messages</h6>
                                <h3 class="mb-0"><?php echo $newMessages; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="text-muted">Read</h6>
                                <h3 class="mb-0"><?php echo $readMessages; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="text-muted">Replied</h6>
                                <h3 class="mb-0"><?php echo $repliedMessages; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($messages)): ?>
                                        <?php foreach ($messages as $message): ?>
                                            <tr class="<?php echo $message['status'] === 'new' ? 'table-warning' : ''; ?>">
                                                <td><?php echo $message['id']; ?></td>
                                                <td><strong><?php echo e($message['name']); ?></strong></td>
                                                <td>
                                                    <small>
                                                        <i class="fas fa-envelope"></i> <?php echo e($message['email']); ?><br>
                                                        <?php if (!empty($message['phone'])): ?>
                                                            <i class="fas fa-phone"></i> <?php echo e($message['phone']); ?>
                                                        <?php endif; ?>
                                                    </small>
                                                </td>
                                                <td><?php echo e($message['subject']); ?></td>
                                                <td><?php echo e(truncateText($message['message'], 50)); ?></td>
                                                <td>
                                                    <?php
                                                    $statusColors = [
                                                        'new' => 'warning',
                                                        'read' => 'info',
                                                        'replied' => 'success',
                                                        'archived' => 'secondary'
                                                    ];
                                                    $color = $statusColors[$message['status']] ?? 'secondary';
                                                    ?>
                                                    <span class="badge bg-<?php echo $color; ?>">
                                                        <?php echo ucfirst($message['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick='viewMessage(<?php echo json_encode($message); ?>)'>
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-primary" onclick='updateMessageStatus(<?php echo $message["id"]; ?>, "<?php echo $message["status"]; ?>")'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="mailto:<?php echo e($message['email']); ?>" class="btn btn-sm btn-success"
                                                        title="Reply via email">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <a href="?delete=<?php echo $message['id']; ?>" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this message?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No messages yet. Messages from the contact form will appear here.
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

    <!-- Message Details Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="messageDetails">
                    <!-- Message details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <a href="#" id="replyLink" class="btn btn-success">
                        <i class="fas fa-reply me-2"></i>Reply via Email
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <h5 class="modal-title">Update Message Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="message_id" id="statusMessageId">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="messageStatus">
                                <option value="new">New</option>
                                <option value="read">Read</option>
                                <option value="replied">Replied</option>
                                <option value="archived">Archived</option>
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
        function viewMessage(message) {
            const details = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>From</h6>
                        <p><strong>${message.name}</strong></p>
                        <p>
                            <i class="fas fa-envelope"></i> ${message.email}<br>
                            ${message.phone ? '<i class="fas fa-phone"></i> ' + message.phone : ''}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Details</h6>
                        <p><strong>Date:</strong> ${new Date(message.created_at).toLocaleString()}</p>
                        <p><strong>Status:</strong> <span class="badge bg-info">${message.status}</span></p>
                    </div>
                </div>
                <hr>
                <h6>Subject</h6>
                <p><strong>${message.subject}</strong></p>
                <hr>
                <h6>Message</h6>
                <p>${message.message.replace(/\n/g, '<br>')}</p>
            `;
            document.getElementById('messageDetails').innerHTML = details;
            document.getElementById('replyLink').href = `mailto:${message.email}?subject=Re: ${encodeURIComponent(message.subject)}`;
            new bootstrap.Modal(document.getElementById('messageModal')).show();
        }

        function updateMessageStatus(messageId, currentStatus) {
            document.getElementById('statusMessageId').value = messageId;
            document.getElementById('messageStatus').value = currentStatus;
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        }
    </script>
</body>

</html>