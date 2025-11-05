<?php

/**
 * Shopping Cart Page - Kiihabwemi Development Company Ltd
 */
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'Shopping Cart - ' . SITE_NAME;
$pageDescription = 'Review your coffee order and checkout via WhatsApp for quick and easy delivery.';
$pageKeywords = 'shopping cart, checkout, order coffee Uganda';


?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Shopping Cart</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Cart Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <!-- Empty Cart Message -->
                        <div id="emptyCartMessage" class="text-center py-5" style="display: none;">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h4 class="fw-bold">Your cart is empty</h4>
                            <p class="text-muted mb-4">Start adding some delicious coffee to your cart!</p>
                            <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-coffee">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>

                        <!-- Cart Items Table -->
                        <div id="cartItemsContainer">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="ps-4">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col" class="pe-4"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTableBody">
                                        <!-- Cart items will be inserted here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Continue Shopping Button -->
                <div id="continueShoppingBtn">
                    <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-outline-coffee">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;" id="cartSummary">
                    <div class="card-header bg-coffee text-white py-3">
                        <h5 class="mb-0 fw-bold">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span id="cartSubtotal" class="fw-bold">UGX 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Items:</span>
                            <span id="cartItemCount" class="fw-bold">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 mb-0">Total:</span>
                            <span id="cartTotal" class="h4 mb-0 fw-bold text-coffee">UGX 0</span>
                        </div>

                        <!-- Checkout Button -->
                        <button class="btn btn-success btn-lg w-100 mb-3" id="checkoutBtn" disabled>
                            <i class="fab fa-whatsapp me-2"></i>Checkout via WhatsApp
                        </button>

                        <!-- Clear Cart Button -->
                        <button class="btn btn-outline-danger w-100" id="clearCartBtn" disabled>
                            <i class="fas fa-trash-alt me-2"></i>Clear Cart
                        </button>
                    </div>

                    <!-- Delivery Info -->
                    <div class="card-footer bg-light">
                        <div class="small">
                            <p class="mb-2">
                                <i class="fas fa-truck text-coffee me-2"></i>
                                <strong>Free delivery</strong> within Kampala
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-shield-alt text-coffee me-2"></i>
                                <strong>Secure checkout</strong> via WhatsApp
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-headset text-coffee me-2"></i>
                                <strong>24/7 support</strong> available
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recommended Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">You May Also Like</h2>
            <p class="lead text-muted">Complete your order with these items</p>
        </div>

        <div class="row g-4">
            <?php
            $recommendedProducts = getProducts($pdo, 3);
            if (!empty($recommendedProducts)):
                foreach ($recommendedProducts as $index => $product):
            ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                        <div class="product-card h-100">
                            <div class="product-image-wrapper">
                                <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($product['image_url']); ?>"
                                    class="product-image"
                                    alt="<?php echo e($product['name']); ?>"
                                    loading="lazy">
                            </div>
                            <div class="product-body p-4">
                                <h5 class="product-title fw-bold"><?php echo e($product['name']); ?></h5>
                                <p class="product-description text-muted small">
                                    <?php echo e(truncateText($product['description'], 80)); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price fw-bold text-coffee fs-5">
                                        <?php echo formatPrice($product['price']); ?>
                                    </span>
                                    <button class="btn btn-coffee add-to-cart"
                                        data-id="<?php echo $product['id']; ?>"
                                        data-name="<?php echo e($product['name']); ?>"
                                        data-price="<?php echo $product['price']; ?>"
                                        data-image="<?php echo e($product['image_url']); ?>">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Pass WhatsApp number to JavaScript -->
<script>
    window.WHATSAPP_NUMBER = '<?php echo WHATSAPP_NUMBER; ?>';
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
