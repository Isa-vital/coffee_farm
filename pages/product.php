<?php

/**
 * Product Detail Page - Kiihabwemi Development Company Ltd
 */

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

// Get product ID from URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($productId === 0) {
    redirect(SITE_URL . '/pages/shop.php');
}

// Get product details
$product = getProductById($pdo, $productId);

if (!$product) {
    redirect(SITE_URL . '/pages/shop.php');
}

// Set page meta tags
$pageTitle = e($product['name']) . ' - ' . SITE_NAME;
$pageDescription = truncateText($product['description'], 160);
$pageKeywords = e($product['name']) . ', Uganda coffee, premium coffee, buy coffee online';
$pageImage = SITE_URL . '/assets/images/products/' . e($product['image_url']);

// Get related products (same category or random)
$relatedProducts = getProducts($pdo, 3);
?>

<!-- Product Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo e($product['name']); ?>",
        "image": "<?php echo $pageImage; ?>",
        "description": "<?php echo e($product['description']); ?>",
        "brand": {
            "@type": "Brand",
            "name": "<?php echo SITE_NAME; ?>"
        },
        "offers": {
            "@type": "Offer",
            "url": "<?php echo SITE_URL . '/pages/product.php?id=' . $product['id']; ?>",
            "priceCurrency": "UGX",
            "price": "<?php echo $product['price']; ?>",
            "availability": "<?php echo $product['stock_quantity'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'; ?>"
        }
    }
</script>

<!-- Breadcrumb -->
<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/pages/shop.php">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($product['name']); ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="product-detail-image">
                    <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($product['image_url']); ?>"
                        class="img-fluid rounded shadow"
                        alt="<?php echo e($product['name']); ?>"
                        id="mainProductImage">
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <h1 class="display-5 fw-bold mb-3"><?php echo e($product['name']); ?></h1>

                <!-- Stock Status -->
                <div class="mb-3">
                    <?php if ($product['stock_quantity'] > 10): ?>
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>In Stock (<?php echo $product['stock_quantity']; ?> available)
                        </span>
                    <?php elseif ($product['stock_quantity'] > 0): ?>
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-exclamation-triangle me-1"></i>Low Stock (<?php echo $product['stock_quantity']; ?> left)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>Out of Stock
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <span class="display-4 fw-bold text-coffee"><?php echo formatPrice($product['price']); ?></span>
                    <span class="text-muted ms-2">per unit</span>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Description</h5>
                    <p class="text-muted"><?php echo nl2br(e($product['description'])); ?></p>
                </div>

                <!-- Features -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Features</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>100% Organic Ugandan Coffee</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Sustainably Grown</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Ethically Sourced</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Premium Quality</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Rich Aroma & Flavor</li>
                    </ul>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-4">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <div class="input-group w-50">
                        <button class="btn btn-outline-coffee" type="button" id="decreaseQty">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                        <button class="btn btn-outline-coffee" type="button" id="increaseQty">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 flex-wrap mb-4">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <button class="btn btn-coffee btn-lg add-to-cart"
                            data-id="<?php echo $product['id']; ?>"
                            data-name="<?php echo e($product['name']); ?>"
                            data-price="<?php echo $product['price']; ?>"
                            data-image="<?php echo e($product['image_url']); ?>"
                            id="addToCartBtn">
                            <i class="fas fa-cart-plus me-2"></i>Add to Cart
                        </button>
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20KDC!%20I%20want%20to%20order%20<?php echo urlencode($product['name']); ?>"
                            class="btn btn-success btn-lg" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Buy via WhatsApp
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times-circle me-2"></i>Out of Stock
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Social Share -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Share this product:</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/pages/product.php?id=' . $product['id']); ?>"
                            class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($product['name']); ?>&url=<?php echo urlencode(SITE_URL . '/pages/product.php?id=' . $product['id']); ?>"
                            class="btn btn-outline-info btn-sm" target="_blank" rel="noopener">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode('Check out ' . $product['name'] . ' at ' . SITE_URL . '/pages/product.php?id=' . $product['id']); ?>"
                            class="btn btn-outline-success btn-sm" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-6 fw-bold">You May Also Like</h2>
                <p class="lead text-muted">Explore more of our premium coffee collection</p>
            </div>

            <div class="row g-4">
                <?php foreach ($relatedProducts as $index => $relatedProduct): ?>
                    <?php if ($relatedProduct['id'] != $product['id']): ?>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                            <div class="product-card h-100">
                                <div class="product-image-wrapper">
                                    <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($relatedProduct['image_url']); ?>"
                                        class="product-image"
                                        alt="<?php echo e($relatedProduct['name']); ?>"
                                        loading="lazy">
                                </div>
                                <div class="product-body p-4">
                                    <h5 class="product-title fw-bold">
                                        <a href="<?php echo SITE_URL; ?>/pages/product.php?id=<?php echo $relatedProduct['id']; ?>"
                                            class="text-decoration-none text-dark">
                                            <?php echo e($relatedProduct['name']); ?>
                                        </a>
                                    </h5>
                                    <p class="product-description text-muted small">
                                        <?php echo e(truncateText($relatedProduct['description'], 100)); ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="product-price fw-bold text-coffee fs-5">
                                            <?php echo formatPrice($relatedProduct['price']); ?>
                                        </span>
                                        <a href="<?php echo SITE_URL; ?>/pages/product.php?id=<?php echo $relatedProduct['id']; ?>"
                                            class="btn btn-outline-coffee">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
    // Quantity controls
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        const addToCartBtn = document.getElementById('addToCartBtn');

        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
        }

        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                let max = parseInt(quantityInput.max);
                if (value < max) {
                    quantityInput.value = value + 1;
                }
            });
        }

        // Update add to cart with quantity
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const quantity = parseInt(quantityInput.value);
                // The cart.js will handle this with the quantity
                addToCartBtn.setAttribute('data-quantity', quantity);
            });
        }
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
