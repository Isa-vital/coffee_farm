<?php

/**
 * Shop Page - Kiihabwemi Development Company Ltd
 */
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'Shop Premium Coffee - ' . SITE_NAME;
$pageDescription = 'Browse our collection of premium Ugandan coffee. High-quality arabica and robusta coffee beans, ground coffee, and specialty blends.';
$pageKeywords = 'buy coffee Uganda, premium coffee shop, arabica coffee, robusta coffee, coffee beans Uganda';



// Get all products
$products = getProducts($pdo);
?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Our Coffee Shop</h1>
                <p class="lead">Premium coffee, ethically sourced, sustainably grown</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Filter and Sort Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    <strong><?php echo count($products); ?></strong> products available
                </p>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2 justify-content-md-end">
                    <select class="form-select form-select-sm w-auto" id="sortProducts">
                        <option value="default">Default Sorting</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name-az">Name: A to Z</option>
                        <option value="name-za">Name: Z to A</option>
                    </select>
                    <button class="btn btn-sm btn-outline-coffee" id="gridView">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-coffee" id="listView">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4" id="productsContainer">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                    <div class="col-md-6 col-lg-4 product-item"
                        data-aos="fade-up"
                        data-aos-delay="<?php echo ($index + 1) * 50; ?>"
                        data-price="<?php echo $product['price']; ?>"
                        data-name="<?php echo strtolower($product['name']); ?>">
                        <div class="product-card h-100">
                            <div class="product-image-wrapper">
                                <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($product['image_url']); ?>"
                                    class="product-image"
                                    alt="<?php echo e($product['name']); ?>"
                                    loading="lazy"
                                    onerror="this.src='<?php echo SITE_URL; ?>/assets/images/placeholder.jpg'">
                                <?php if ($product['stock_quantity'] < 10): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                                        Only <?php echo $product['stock_quantity']; ?> left
                                    </span>
                                <?php endif; ?>
                                <?php if ($product['stock_quantity'] > 50): ?>
                                    <span class="badge bg-success position-absolute top-0 start-0 m-3">
                                        In Stock
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="product-body p-4">
                                <h5 class="product-title fw-bold">
                                    <a href="<?php echo SITE_URL; ?>/pages/product.php?id=<?php echo $product['id']; ?>"
                                        class="text-decoration-none text-dark">
                                        <?php echo e($product['name']); ?>
                                    </a>
                                </h5>
                                <p class="product-description text-muted small">
                                    <?php echo e(truncateText($product['description'], 120)); ?>
                                </p>
                                <div class="product-meta mb-3">
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-box me-1"></i><?php echo $product['stock_quantity']; ?> in stock
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="product-price fw-bold text-coffee fs-4">
                                        <?php echo formatPrice($product['price']); ?>
                                    </span>
                                    <div class="btn-group">
                                        <button class="btn btn-coffee add-to-cart"
                                            data-id="<?php echo $product['id']; ?>"
                                            data-name="<?php echo e($product['name']); ?>"
                                            data-price="<?php echo $product['price']; ?>"
                                            data-image="<?php echo e($product['image_url']); ?>"
                                            data-weight="<?php echo e($product['weight']); ?>"
                                            title="Add to cart">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                        <a href="<?php echo SITE_URL; ?>/pages/product.php?id=<?php echo $product['id']; ?>"
                                            class="btn btn-outline-coffee"
                                            title="View details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-info-circle fa-3x mb-3 d-block"></i>
                        <h4>No Products Available</h4>
                        <p class="mb-0">We're currently updating our inventory. Please check back soon!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why Choose Our Coffee -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">Why Choose KDC Coffee?</h2>
            <p class="lead text-muted">Quality you can taste, impact you can feel</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4">
                    <i class="fas fa-certificate fa-3x text-coffee mb-3"></i>
                    <h5 class="fw-bold">Certified Quality</h5>
                    <p class="small text-muted">100% authentic Ugandan coffee, carefully selected and processed</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4">
                    <i class="fas fa-leaf fa-3x text-coffee mb-3"></i>
                    <h5 class="fw-bold">Organic Farming</h5>
                    <p class="small text-muted">Grown naturally without harmful chemicals or pesticides</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center p-4">
                    <i class="fas fa-hands-helping fa-3x text-coffee mb-3"></i>
                    <h5 class="fw-bold">Fair Trade</h5>
                    <p class="small text-muted">Supporting farmers and communities with fair prices</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center p-4">
                    <i class="fas fa-shipping-fast fa-3x text-coffee mb-3"></i>
                    <h5 class="fw-bold">Fast Delivery</h5>
                    <p class="small text-muted">Quick and reliable delivery across Uganda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-coffee text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-6 fw-bold mb-3">Need Help Choosing?</h2>
        <p class="lead mb-4">Our team is here to help you find the perfect coffee for your taste</p>
        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20KDC!%20I%20need%20help%20choosing%20coffee"
            class="btn btn-light btn-lg" target="_blank">
            <i class="fab fa-whatsapp me-2"></i>Chat with Us on WhatsApp
        </a>
    </div>
</section>

<script>
    // Product sorting and filtering
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sortProducts');
        const productsContainer = document.getElementById('productsContainer');

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const products = Array.from(document.querySelectorAll('.product-item'));
                const sortValue = this.value;

                products.sort((a, b) => {
                    switch (sortValue) {
                        case 'price-low':
                            return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                        case 'price-high':
                            return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                        case 'name-az':
                            return a.dataset.name.localeCompare(b.dataset.name);
                        case 'name-za':
                            return b.dataset.name.localeCompare(a.dataset.name);
                        default:
                            return 0;
                    }
                });

                products.forEach(product => productsContainer.appendChild(product));
            });
        }
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>