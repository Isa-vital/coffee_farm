<?php

/**
 * Products Management - Admin Panel
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

// Handle product deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = 'Product deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error deleting product: ' . $e->getMessage();
    }
}

// Handle product status toggle
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    try {
        $stmt = $pdo->prepare("UPDATE products SET status = IF(status = 'active', 'inactive', 'active') WHERE id = ?");
        $stmt->execute([$_GET['toggle']]);
        $success = 'Product status updated!';
    } catch (PDOException $e) {
        $error = 'Error updating status: ' . $e->getMessage();
    }
}

// Handle product add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reset error and success messages for this operation
    $error = '';
    $success = '';

    $id = $_POST['id'] ?? null;
    $name = sanitizeInput($_POST['name'] ?? '');
    $slug = sanitizeInput($_POST['slug'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $weight = sanitizeInput($_POST['weight'] ?? '');
    $category = sanitizeInput($_POST['category'] ?? '');
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Handle image upload
    $image_url = $_POST['existing_image'] ?? '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../assets/images/products/';

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Validate image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $fileType = $_FILES['product_image']['type'];
        $fileSize = $_FILES['product_image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $error = 'Invalid file type. Only JPG, PNG, and WebP are allowed.';
        } elseif ($fileSize > 5242880) { // 5MB
            $error = 'File size exceeds 5MB limit.';
        } else {
            // Generate unique filename
            $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            $filename = $slug . '-' . time() . '.' . $extension;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                // Delete old image if updating
                if ($id && !empty($image_url) && file_exists($uploadDir . $image_url)) {
                    unlink($uploadDir . $image_url);
                }
                $image_url = $filename;
            } else {
                $error = 'Failed to upload image.';
            }
        }
    }

    if (empty($error)) {
        try {
            if ($id) {
                // Update existing product
                $sql = "UPDATE products SET name = ?, slug = ?, description = ?, price = ?, weight = ?, 
                        category = ?, image_url = ?, stock_quantity = ?, is_featured = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([$name, $slug, $description, $price, $weight, $category, $image_url, $stock_quantity, $is_featured, $id]);
                if ($result) {
                    $success = 'Product updated successfully!';
                } else {
                    $error = 'Failed to update product. Error info: ' . print_r($stmt->errorInfo(), true);
                }
            } else {
                // Add new product
                $sql = "INSERT INTO products (name, slug, description, price, weight, category, image_url, stock_quantity, is_featured) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $result = $stmt->execute([$name, $slug, $description, $price, $weight, $category, $image_url, $stock_quantity, $is_featured]);
                if ($result) {
                    $lastId = $pdo->lastInsertId();
                    $success = 'Product added successfully! (ID: ' . $lastId . ')';
                } else {
                    $error = 'Failed to insert product. Error info: ' . print_r($stmt->errorInfo(), true);
                }
            }
        } catch (PDOException $e) {
            $error = 'Error saving product: ' . $e->getMessage();
        }
    }
}

// Get all products
$products = fetchAll($pdo, "SELECT * FROM products ORDER BY created_at DESC");

// Get statistics
$totalProducts = fetchOne($pdo, "SELECT COUNT(*) as count FROM products")['count'];
$activeProducts = fetchOne($pdo, "SELECT COUNT(*) as count FROM products WHERE status = 'active'")['count'];
$lowStockProducts = fetchOne($pdo, "SELECT COUNT(*) as count FROM products WHERE stock_quantity < 10")['count'];

$pageTitle = 'Products Management - ' . SITE_NAME;
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
                    <h1 class="h2">Products Management</h1>
                    <button class="btn btn-coffee" data-bs-toggle="modal" data-bs-target="#productModal" onclick="resetProductForm()">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </button>
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
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="text-muted">Total Products</h6>
                                <h3 class="mb-0"><?php echo $totalProducts; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="text-muted">Active Products</h6>
                                <h3 class="mb-0"><?php echo $activeProducts; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="text-muted">Low Stock</h6>
                                <h3 class="mb-0"><?php echo $lowStockProducts; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="productsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo $product['id']; ?></td>
                                                <td>
                                                    <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($product['image_url']); ?>"
                                                        alt="<?php echo e($product['name']); ?>"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        onerror="this.src='<?php echo SITE_URL; ?>/assets/images/placeholder.jpg'">
                                                </td>
                                                <td>
                                                    <strong><?php echo e($product['name']); ?></strong><br>
                                                    <small class="text-muted"><?php echo e($product['weight']); ?></small>
                                                </td>
                                                <td><?php echo e($product['category']); ?></td>
                                                <td><?php echo formatPrice($product['price']); ?></td>
                                                <td>
                                                    <?php if ($product['stock_quantity'] < 10): ?>
                                                        <span class="badge bg-danger"><?php echo $product['stock_quantity']; ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success"><?php echo $product['stock_quantity']; ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($product['is_featured']): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star text-muted"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?php echo $product['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst($product['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" onclick='editProduct(<?php echo json_encode($product); ?>)'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="?toggle=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Toggle product status?')">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                    <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">No products found. Add your first product!</td>
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

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="productId">
                        <input type="hidden" name="existing_image" id="existingImage">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">Slug *</label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                                <small class="text-muted">URL-friendly name (e.g., arabica-coffee-beans)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Price (UGX) *</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="text" class="form-control" id="weight" name="weight" placeholder="e.g., 1kg">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="Coffee Beans">Coffee Beans</option>
                                    <option value="Ground Coffee">Ground Coffee</option>
                                    <option value="Instant Coffee">Instant Coffee</option>
                                    <option value="Gift Sets">Gift Sets</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product_image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted">JPG, PNG, or WebP (max 5MB)</small>
                                <div id="currentImagePreview" class="mt-2" style="display: none;">
                                    <img id="currentImage" src="" alt="Current image" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    <p class="small text-muted mb-0">Current image (leave empty to keep)</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                            <label class="form-check-label" for="is_featured">
                                Featured Product (Show on homepage)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-coffee">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function resetProductForm() {
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.querySelector('#productModal form').reset();
            document.getElementById('productId').value = '';
            document.getElementById('existingImage').value = '';
            document.getElementById('currentImagePreview').style.display = 'none';
        }

        function editProduct(product) {
            document.getElementById('modalTitle').textContent = 'Edit Product';
            document.getElementById('productId').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('slug').value = product.slug;
            document.getElementById('description').value = product.description || '';
            document.getElementById('price').value = product.price;
            document.getElementById('weight').value = product.weight || '';
            document.getElementById('stock_quantity').value = product.stock_quantity;
            document.getElementById('category').value = product.category || '';
            document.getElementById('is_featured').checked = product.is_featured == 1;

            // Handle existing image
            if (product.image_url) {
                document.getElementById('existingImage').value = product.image_url;
                document.getElementById('currentImage').src = '<?php echo SITE_URL; ?>/assets/images/products/' + product.image_url;
                document.getElementById('currentImagePreview').style.display = 'block';
            } else {
                document.getElementById('currentImagePreview').style.display = 'none';
            }

            new bootstrap.Modal(document.getElementById('productModal')).show();
        }

        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            if (!document.getElementById('productId').value) {
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            }
        });

        // Image preview on file selection
        document.getElementById('product_image').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('currentImage').src = e.target.result;
                    document.getElementById('currentImagePreview').style.display = 'block';
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>

</html>