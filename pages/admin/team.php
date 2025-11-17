<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ' . SITE_URL . '/pages/admin/login.php');
    exit;
}

$pageTitle = 'Team Management - ' . SITE_NAME;
$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $success = '';
    
    // Add or Edit Team Member
    if (isset($_POST['action']) && in_array($_POST['action'], ['add', 'edit'])) {
        $name = trim($_POST['name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $category = $_POST['category'] ?? '';
        $bio = trim($_POST['bio'] ?? '');
        $display_order = intval($_POST['display_order'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        
        // Validation
        if (empty($name)) {
            $error = 'Name is required.';
        } elseif (empty($category) || !in_array($category, ['board', 'management', 'partner'])) {
            $error = 'Please select a valid category.';
        }
        
        // Handle photo upload
        $photo_url = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($_FILES['photo']['type'], $allowed_types)) {
                $error = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
            } elseif ($_FILES['photo']['size'] > $max_size) {
                $error = 'File is too large. Maximum size is 5MB.';
            } else {
                $upload_dir = __DIR__ . '/../../assets/images/team/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid('team_') . '_' . time() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                    $photo_url = $new_filename;
                } else {
                    $error = 'Failed to upload photo.';
                }
            }
        }
        
        if (empty($error)) {
            if ($_POST['action'] === 'add') {
                $sql = "INSERT INTO team_members (name, position, category, bio, photo_url, display_order, status) 
                        VALUES (:name, :position, :category, :bio, :photo_url, :display_order, :status)";
                $params = [
                    ':name' => $name,
                    ':position' => $position,
                    ':category' => $category,
                    ':bio' => $bio,
                    ':photo_url' => $photo_url,
                    ':display_order' => $display_order,
                    ':status' => $status
                ];
                
                if (executeQuery($pdo, $sql, $params)) {
                    $success = 'Team member added successfully!';
                } else {
                    $error = 'Failed to add team member.';
                }
            } elseif ($_POST['action'] === 'edit') {
                $id = intval($_POST['id']);
                
                // If new photo uploaded, delete old photo
                if (!empty($photo_url)) {
                    $old_member = fetchOne($pdo, "SELECT photo_url FROM team_members WHERE id = :id", [':id' => $id]);
                    if ($old_member && !empty($old_member['photo_url'])) {
                        $old_photo_path = __DIR__ . '/../../assets/images/team/' . $old_member['photo_url'];
                        if (file_exists($old_photo_path)) {
                            unlink($old_photo_path);
                        }
                    }
                    
                    $sql = "UPDATE team_members SET name = :name, position = :position, category = :category, 
                            bio = :bio, photo_url = :photo_url, display_order = :display_order, status = :status 
                            WHERE id = :id";
                    $params = [
                        ':name' => $name,
                        ':position' => $position,
                        ':category' => $category,
                        ':bio' => $bio,
                        ':photo_url' => $photo_url,
                        ':display_order' => $display_order,
                        ':status' => $status,
                        ':id' => $id
                    ];
                } else {
                    $sql = "UPDATE team_members SET name = :name, position = :position, category = :category, 
                            bio = :bio, display_order = :display_order, status = :status 
                            WHERE id = :id";
                    $params = [
                        ':name' => $name,
                        ':position' => $position,
                        ':category' => $category,
                        ':bio' => $bio,
                        ':display_order' => $display_order,
                        ':status' => $status,
                        ':id' => $id
                    ];
                }
                
                if (executeQuery($pdo, $sql, $params)) {
                    $success = 'Team member updated successfully!';
                } else {
                    $error = 'Failed to update team member.';
                }
            }
        }
    }
    
    // Delete Team Member
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        
        // Delete photo file
        $member = fetchOne($pdo, "SELECT photo_url FROM team_members WHERE id = :id", [':id' => $id]);
        if ($member && !empty($member['photo_url'])) {
            $photo_path = __DIR__ . '/../../assets/images/team/' . $member['photo_url'];
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
        }
        
        if (executeQuery($pdo, "DELETE FROM team_members WHERE id = :id", [':id' => $id])) {
            $success = 'Team member deleted successfully!';
        } else {
            $error = 'Failed to delete team member.';
        }
    }
    
    // Toggle Status
    if (isset($_POST['action']) && $_POST['action'] === 'toggle_status' && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "UPDATE team_members SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id";
        
        if (executeQuery($pdo, $sql, [':id' => $id])) {
            $success = 'Status updated successfully!';
        } else {
            $error = 'Failed to update status.';
        }
    }
}

// Fetch all team members
$teamMembers = fetchAll($pdo, "SELECT * FROM team_members ORDER BY category ASC, display_order ASC");

// Group by category
$board = array_filter($teamMembers, fn($m) => $m['category'] === 'board');
$management = array_filter($teamMembers, fn($m) => $m['category'] === 'management');
$partners = array_filter($teamMembers, fn($m) => $m['category'] === 'partner');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #2D5016;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 0.8rem 1rem;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .team-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .badge-board { background-color: #6F4E37; }
        .badge-management { background-color: #2D5016; }
        .badge-partner { background-color: #FFC107; color: #000; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3">
                <h5 class="text-white px-3 mb-3">KDC Admin</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/products.php">
                            <i class="fas fa-box me-2"></i>Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/orders.php">
                            <i class="fas fa-shopping-cart me-2"></i>Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo SITE_URL; ?>/pages/admin/team.php">
                            <i class="fas fa-users me-2"></i>Team
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/messages.php">
                            <i class="fas fa-envelope me-2"></i>Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/settings.php">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>">
                            <i class="fas fa-globe me-2"></i>View Site
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/admin/logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Team Management</h1>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                    <i class="fas fa-plus me-2"></i>Add Team Member
                </button>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Board Members -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Board Members (<?php echo count($board); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($board)): ?>
                                    <tr><td colspan="6" class="text-center text-muted">No board members added yet.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($board as $member): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($member['photo_url'])): ?>
                                                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($member['photo_url']); ?>" 
                                                         class="rounded-circle team-photo" alt="<?php echo e($member['name']); ?>">
                                                <?php else: ?>
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center team-photo">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($member['name']); ?></td>
                                            <td><?php echo e($member['position']); ?></td>
                                            <td><?php echo $member['display_order']; ?></td>
                                            <td>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($member['status']); ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="editTeamMember(<?php echo htmlspecialchars(json_encode($member)); ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Management Team -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: #2D5016; color: white;">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Management Team (<?php echo count($management); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($management)): ?>
                                    <tr><td colspan="6" class="text-center text-muted">No management members added yet.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($management as $member): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($member['photo_url'])): ?>
                                                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($member['photo_url']); ?>" 
                                                         class="rounded-circle team-photo" alt="<?php echo e($member['name']); ?>">
                                                <?php else: ?>
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center team-photo">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($member['name']); ?></td>
                                            <td><?php echo e($member['position']); ?></td>
                                            <td><?php echo $member['display_order']; ?></td>
                                            <td>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($member['status']); ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="editTeamMember(<?php echo htmlspecialchars(json_encode($member)); ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Partners -->
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>Partners (<?php echo count($partners); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Logo/Photo</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($partners)): ?>
                                    <tr><td colspan="6" class="text-center text-muted">No partners added yet.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($partners as $member): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($member['photo_url'])): ?>
                                                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($member['photo_url']); ?>" 
                                                         class="team-photo" style="border-radius: 4px;" alt="<?php echo e($member['name']); ?>">
                                                <?php else: ?>
                                                    <div class="bg-secondary d-flex align-items-center justify-content-center team-photo" style="border-radius: 4px;">
                                                        <i class="fas fa-building text-white"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($member['name']); ?></td>
                                            <td><?php echo e($member['position']); ?></td>
                                            <td><?php echo $member['display_order']; ?></td>
                                            <td>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($member['status']); ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" onclick="editTeamMember(<?php echo htmlspecialchars(json_encode($member)); ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Team Member Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position/Title</label>
                            <input type="text" name="position" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="board">Board Member</option>
                                <option value="management">Management Team</option>
                                <option value="partner">Partner</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Photo (JPG, PNG, GIF - Max 5MB)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bio/Description</label>
                        <textarea name="bio" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Team Member Modal -->
<div class="modal fade" id="editTeamModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position/Title</label>
                            <input type="text" name="position" id="edit_position" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select name="category" id="edit_category" class="form-select" required>
                                <option value="board">Board Member</option>
                                <option value="management">Management Team</option>
                                <option value="partner">Partner</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" id="edit_display_order" class="form-control" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Photo (Leave empty to keep current)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <div id="current_photo" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Bio/Description</label>
                        <textarea name="bio" id="edit_bio" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editTeamMember(member) {
    document.getElementById('edit_id').value = member.id;
    document.getElementById('edit_name').value = member.name;
    document.getElementById('edit_position').value = member.position || '';
    document.getElementById('edit_category').value = member.category;
    document.getElementById('edit_display_order').value = member.display_order;
    document.getElementById('edit_status').value = member.status;
    document.getElementById('edit_bio').value = member.bio || '';
    
    const photoDiv = document.getElementById('current_photo');
    if (member.photo_url) {
        photoDiv.innerHTML = '<small class="text-muted">Current photo:</small><br><img src="<?php echo SITE_URL; ?>/assets/images/team/' + member.photo_url + '" class="img-thumbnail mt-1" style="max-width: 150px;">';
    } else {
        photoDiv.innerHTML = '<small class="text-muted">No photo uploaded</small>';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('editTeamModal'));
    modal.show();
}
</script>

</body>
</html>
