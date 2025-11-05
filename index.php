<?php

/**
 * Home Page - Kiihabwemi Development Company Ltd
 */

// Load configuration
require_once __DIR__ . '/config/config.php';

$pageTitle = SITE_NAME . ' - ' . SITE_TAGLINE;
$pageDescription = 'Discover premium Ugandan coffee from Kiihabwemi Development Company Ltd. Supporting youth empowerment, sustainable farming, and community development.';
$pageKeywords = 'KDC coffee, Uganda coffee, premium coffee, arabica coffee, sustainable farming, youth empowerment';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

// Get featured products
$featuredProducts = getProducts($pdo, 6);

// Hero carousel slides
$heroSlides = [
    [
        'title' => 'Premium Coffee',
        'subtitle' => 'From the Heart of Uganda',
        'description' => 'Experience the rich, authentic taste of Ugandan coffee. Sustainably grown, ethically sourced, and crafted with passion.',
        'btn1_text' => 'Shop Now',
        'btn1_link' => SITE_URL . '/pages/shop.php',
        'btn1_icon' => 'fa-shopping-bag',
        'btn2_text' => 'Learn More',
        'btn2_link' => SITE_URL . '/pages/about.php',
        'bg_image' => SITE_URL . '/assets/images/hero/coffee-beans.jpg'
    ],
    [
        'title' => 'Empowering Youth',
        'subtitle' => 'Building Sustainable Futures',
        'description' => 'Supporting young farmers and entrepreneurs through agriculture. Join us in creating opportunities for the next generation.',
        'btn1_text' => 'Our Mission',
        'btn1_link' => SITE_URL . '/pages/about.php',
        'btn1_icon' => 'fa-heart',
        'btn2_text' => 'Get Involved',
        'btn2_link' => SITE_URL . '/pages/community.php',
        'bg_image' => SITE_URL . '/assets/images/products/fortune.jpg'
    ],
    [
        'title' => '100% Organic',
        'subtitle' => 'Naturally Grown Excellence',
        'description' => 'Hand-picked Arabica and Robusta beans grown without harmful chemicals. Taste the pure essence of Uganda\'s finest coffee.',
        'btn1_text' => 'Browse Products',
        'btn1_link' => SITE_URL . '/pages/shop.php',
        'btn1_icon' => 'fa-leaf',
        'btn2_text' => 'Contact Us',
        'btn2_link' => SITE_URL . '/pages/contact.php',
        'bg_image' => SITE_URL . '/assets/images/hero/organic-farm.jpg'
    ],
];
?>

<!-- Hero Section with Carousel -->
<section class="hero-section position-relative overflow-hidden">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php foreach ($heroSlides as $index => $slide): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo e($slide['bg_image']); ?>');">
                    <div class="carousel-overlay"></div>
                    <div class="container">
                        <div class="row min-vh-100 align-items-center">
                            <div class="col-lg-8" data-aos="fade-right">
                                <h1 class="display-3 fw-bold text-white mb-4">
                                    <?php echo e($slide['title']); ?><br>
                                    <span class="text-warning"><?php echo e($slide['subtitle']); ?></span>
                                </h1>
                                <p class="lead text-white mb-4">
                                    <?php echo e($slide['description']); ?>
                                </p>
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="<?php echo $slide['btn1_link']; ?>" class="btn btn-coffee btn-lg">
                                        <i class="fas <?php echo $slide['btn1_icon']; ?> me-2"></i><?php echo e($slide['btn1_text']); ?>
                                    </a>
                                    <a href="<?php echo $slide['btn2_link']; ?>" class="btn btn-outline-light btn-lg">
                                        <?php echo e($slide['btn2_text']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($heroSlides as $index => $slide): ?>
                <button type="button"
                    data-bs-target="#heroCarousel"
                    data-bs-slide-to="<?php echo $index; ?>"
                    class="<?php echo $index === 0 ? 'active' : ''; ?>"
                    aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    aria-label="Slide <?php echo $index + 1; ?>">
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-leaf fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold">100% Organic</h5>
                    <p class="small text-muted">Naturally grown without harmful chemicals</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-users fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold">Youth Empowerment</h5>
                    <p class="small text-muted">Supporting young farmers and communities</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-award fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold">Premium Quality</h5>
                    <p class="small text-muted">Hand-picked and carefully processed</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-truck fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold">Fast Delivery</h5>
                    <p class="small text-muted">Quick and reliable shipping across Uganda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Featured Products</h2>
            <p class="lead text-muted">Discover our premium coffee collection</p>
        </div>

        <?php if (!empty($featuredProducts)): ?>
            <!-- Products Carousel -->
            <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $chunks = array_chunk($featuredProducts, 3);
                    foreach ($chunks as $chunkIndex => $chunk):
                    ?>
                        <div class="carousel-item <?php echo $chunkIndex === 0 ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php foreach ($chunk as $product): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-card h-100">
                                            <div class="product-image-wrapper">
                                                <img src="<?php echo SITE_URL; ?>/assets/images/products/<?php echo e($product['image_url']); ?>"
                                                    class="product-image"
                                                    alt="<?php echo e($product['name']); ?>"
                                                    loading="lazy"
                                                    onerror="this.src='<?php echo SITE_URL; ?>/assets/images/placeholder.jpg'">
                                                <?php if ($product['stock_quantity'] < 10): ?>
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">Low Stock</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-body p-4">
                                                <h5 class="product-title fw-bold"><?php echo e($product['name']); ?></h5>
                                                <p class="product-description text-muted small">
                                                    <?php echo e(truncateText($product['description'], 100)); ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <span class="product-price fw-bold text-coffee fs-5">
                                                        <?php echo formatPrice($product['price']); ?>
                                                    </span>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-coffee add-to-cart"
                                                            data-id="<?php echo $product['id']; ?>"
                                                            data-name="<?php echo e($product['name']); ?>"
                                                            data-price="<?php echo $product['price']; ?>"
                                                            data-image="<?php echo e($product['image_url']); ?>"
                                                            data-weight="<?php echo e($product['weight']); ?>">
                                                            <i class="fas fa-cart-plus"></i>
                                                        </button>
                                                        <a href="<?php echo SITE_URL; ?>/pages/product.php?id=<?php echo $product['id']; ?>"
                                                            class="btn btn-sm btn-outline-coffee">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Carousel Controls -->
                <?php if (count($chunks) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-coffee rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-coffee rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators position-relative mt-4">
                        <?php foreach ($chunks as $chunkIndex => $chunk): ?>
                            <button type="button"
                                data-bs-target="#productsCarousel"
                                data-bs-slide-to="<?php echo $chunkIndex; ?>"
                                class="<?php echo $chunkIndex === 0 ? 'active' : ''; ?>"
                                aria-current="<?php echo $chunkIndex === 0 ? 'true' : 'false'; ?>"
                                aria-label="Slide <?php echo $chunkIndex + 1; ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>No products available at the moment. Please check back soon!
            </div>
        <?php endif; ?>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-coffee btn-lg">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- About Preview Section -->
<section class="py-5 position-relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background-image: url('data:image/svg+xml,%3Csvg width=" 60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none" fill-rule="evenodd" %3E%3Cg fill="%232D5016" fill-opacity="0.1" %3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container position-relative">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <p class="lead text-muted">
                    More than coffee – we're cultivating opportunities and transforming communities across Uganda
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row align-items-center g-5">
            <!-- Image Side with Stats Overlay -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <!-- Main Image -->
                    <div class="rounded-4 overflow-hidden shadow-lg">
                        <img src="<?php echo SITE_URL; ?>/assets/images/products/coffeeseedling.jpg"
                            class="img-fluid w-100"
                            alt="Coffee farmers"
                            loading="lazy"
                            style="object-fit: cover; height: 500px;">
                    </div>

                    <!-- Floating Stats Cards -->
                    <div class="position-absolute bottom-0 start-0 m-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card bg-white shadow-lg border-0 rounded-3" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.95);">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-coffee text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0 fw-bold text-coffee">100+</h3>
                                        <small class="text-muted">Youth Empowered</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-absolute top-0 end-0 m-4" data-aos="fade-down" data-aos-delay="300">
                        <div class="card bg-white shadow-lg border-0 rounded-3" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.95);">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-leaf fa-2x"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0 fw-bold text-success">100%</h3>
                                        <small class="text-muted">Organic</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Side -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="pe-lg-4">
                    <h3 class="h2 fw-bold mb-4 text-coffee">
                        Building Sustainable Futures Through Agriculture
                    </h3>
                    <p class="text-muted mb-4">
                        Kiihabwemi Development Company Ltd is a community-driven enterprise committed to
                        transforming lives through sustainable agriculture. We believe that every cup of
                        coffee should tell a story of empowerment, quality, and positive change.
                    </p>

                    <!-- Feature Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex gap-3 p-3 bg-light rounded-3 h-100">
                                <div class="text-coffee">
                                    <i class="fas fa-chart-line fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Youth Empowerment</h6>
                                    <small class="text-muted">Creating opportunities through agribusiness</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex gap-3 p-3 bg-light rounded-3 h-100">
                                <div class="text-success">
                                    <i class="fas fa-recycle fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Sustainable Practices</h6>
                                    <small class="text-muted">Eco-friendly farming methods</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex gap-3 p-3 bg-light rounded-3 h-100">
                                <div class="text-warning">
                                    <i class="fas fa-hands-helping fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Community Support</h6>
                                    <small class="text-muted">Uplifting local communities</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex gap-3 p-3 bg-light rounded-3 h-100">
                                <div class="text-coffee">
                                    <i class="fas fa-award fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Premium Quality</h6>
                                    <small class="text-muted">Excellence in every bean</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="<?php echo SITE_URL; ?>/pages/about.php" class="btn btn-coffee btn-lg">
                            <i class="fas fa-book-open me-2"></i>Our Full Story
                        </a>
                        <a href="<?php echo SITE_URL; ?>/pages/community.php" class="btn btn-outline-coffee btn-lg">
                            <i class="fas fa-users me-2"></i>Join Our Community
                        </a>
                    </div>

                    <!-- Trust Badge -->
                    <div class="mt-4 p-3 border-start border-coffee border-4 bg-light">
                        <p class="mb-0 small fst-italic text-muted">
                            <i class="fas fa-quote-left text-coffee me-2"></i>
                            "Committed to ethical sourcing, environmental stewardship, and creating
                            lasting impact in Uganda's agricultural sector."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Stats Bar -->
        <div class="row mt-5 pt-5 border-top" data-aos="fade-up">
            <div class="col-md-3 col-6 text-center mb-4 mb-md-0">
                <div class="counter-box">
                    <i class="fas fa-coffee fa-3x text-coffee mb-3"></i>
                    <h3 class="fw-bold mb-0 text-coffee">10+</h3>
                    <p class="text-muted mb-0">Products</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4 mb-md-0">
                <div class="counter-box">
                    <i class="fas fa-users fa-3x text-coffee mb-3"></i>
                    <h3 class="fw-bold mb-0 text-coffee">500+</h3>
                    <p class="text-muted mb-0">Farmers Supported</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4 mb-md-0">
                <div class="counter-box">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold mb-0 text-success">100%</h3>
                    <p class="text-muted mb-0">Organic Certified</p>
                </div>
            </div>
            <div class="col-md-3 col-6 text-center mb-4 mb-md-0">
                <div class="counter-box">
                    <i class="fas fa-heart fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold mb-0 text-danger">1000+</h3>
                    <p class="text-muted mb-0">Happy Customers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-coffee text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Ready to Experience Premium Coffee?</h2>
        <p class="lead mb-4">Order now and get fresh coffee delivered to your doorstep</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-cart me-2"></i>Start Shopping
            </a>
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20KDC!%20I%20want%20to%20place%20an%20order"
                class="btn btn-outline-light btn-lg" target="_blank">
                <i class="fab fa-whatsapp me-2"></i>Order via WhatsApp
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>