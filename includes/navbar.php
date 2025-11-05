    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-coffee sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo SITE_URL; ?>">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo.jpg" alt="KDC Logo" height="40" class="me-2">
                <span class="fw-bold">Kiihabwemi Devt Co. Ltd</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php echo ($currentPage === 'index') ? 'active' : ''; ?>"
                            href="<?php echo SITE_URL; ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php echo ($currentPage === 'about') ? 'active' : ''; ?>"
                            href="<?php echo SITE_URL; ?>/pages/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php echo ($currentPage === 'shop') ? 'active' : ''; ?>"
                            href="<?php echo SITE_URL; ?>/pages/shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php echo ($currentPage === 'community') ? 'active' : ''; ?>"
                            href="<?php echo SITE_URL; ?>/pages/community.php">Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold <?php echo ($currentPage === 'contact') ? 'active' : ''; ?>"
                            href="<?php echo SITE_URL; ?>/pages/contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="<?php echo SITE_URL; ?>/pages/cart.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger rounded-pill cart-count" id="cartCount">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>