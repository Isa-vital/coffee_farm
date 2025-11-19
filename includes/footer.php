    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-md-4">
                    <h5 class="text-coffee fw-bold mb-3">About KDC</h5>
                    <p class="small">
                        Kiihabwemi Development Company Ltd is committed to producing premium coffee
                        while empowering youth and promoting sustainable farming practices in Uganda.
                    </p>
                    <div class="social-links mt-3">
                        <?php if ($fbUrl = getSetting('facebook_url')): ?>
                        <a href="<?php echo e($fbUrl); ?>" class="text-white me-3" aria-label="Facebook" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if ($twUrl = getSetting('twitter_url')): ?>
                        <a href="<?php echo e($twUrl); ?>" class="text-white me-3" aria-label="Twitter" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if ($igUrl = getSetting('instagram_url')): ?>
                        <a href="<?php echo e($igUrl); ?>" class="text-white me-3" aria-label="Instagram" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                        <?php endif; ?>
                        <?php if ($liUrl = getSetting('linkedin_url')): ?>
                        <a href="<?php echo e($liUrl); ?>" class="text-white" aria-label="LinkedIn" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-2">
                    <h5 class="text-coffee fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/" class="text-white text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/about.php" class="text-white text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/shop.php" class="text-white text-decoration-none">Shop</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/community.php" class="text-white text-decoration-none">Community</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/contact.php" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Products -->
                <div class="col-md-3">
                    <h5 class="text-coffee fw-bold mb-3">Our Products</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/shop.php" class="text-white text-decoration-none">Arabica Coffee</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/shop.php" class="text-white text-decoration-none">Robusta Coffee</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/shop.php" class="text-white text-decoration-none">Ground Coffee</a></li>
                        <li class="mb-2"><a href="<?php echo SITE_URL; ?>/pages/shop.php" class="text-white text-decoration-none">Coffee Beans</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3">
                    <h5 class="text-coffee fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <?php echo e(getSetting('site_address', 'Kiihabwemi, Uganda')); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:<?php echo e(getSetting('site_phone', WHATSAPP_NUMBER)); ?>" class="text-white text-decoration-none">
                                <?php echo e(getSetting('site_phone', '+' . WHATSAPP_NUMBER)); ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:<?php echo e(getSetting('site_email', 'info@kdc-coffee.com')); ?>" class="text-white text-decoration-none">
                                <?php echo e(getSetting('site_email', 'info@kdc-coffee.com')); ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fab fa-whatsapp me-2"></i>
                            <a href="https://wa.me/<?php echo e(getSetting('whatsapp_number', WHATSAPP_NUMBER)); ?>" class="text-white text-decoration-none" target="_blank">
                                WhatsApp Us
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 bg-secondary">

            <div class="row">
                <div class="col-md-6 text-center text-md-start small">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Kiihabwemi Development Company Ltd. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end small">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none me-3">Terms of Service</a>
                    <a href="<?php echo SITE_URL; ?>/pages/admin/login.php" class="text-white text-decoration-none">Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20KDC!%20I%20have%20a%20question"
        class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-coffee rounded-circle" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/cart.js?v=2.0"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>

    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
    </body>

    </html>