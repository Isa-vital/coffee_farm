<?php

/**
 * About Us Page - Kiihabwemi Development Company Ltd
 */
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'About Us - ' . SITE_NAME;
$pageDescription = 'Learn about Kiihabwemi Development Company Ltd - our vision, mission, and commitment to sustainable coffee farming and youth empowerment in Uganda.';
$pageKeywords = 'about KDC, coffee company Uganda, sustainable farming, youth empowerment, agribusiness';


?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">About Us</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Company Overview -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo.jpg"
                    class="img-fluid rounded shadow"
                    alt="KDC Coffee Farm"
                    loading="lazy">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-5 fw-bold mb-4">Who We Are</h2>
                <p class="lead">
                    Kiihabwemi Development Company Ltd (KDC) is your trusted agribusiness partner
                    dedicated to serving the community and helping individuals realize their potential
                    through environmentally friendly, sustainable, and profitable agribusinesses.
                </p>
                <p>
                    Established in 2018 and officially incorporated in 2019, we are a limited company
                    with our registered office in Buhimba Town Council, Kikuube district, Bunyoro region.
                    Our business model focuses on agribusiness, with coffee production as our key value chain.
                </p>
                <p>
                    Coffee is a crop of national importance in Uganda, offering significant opportunities
                    for socioeconomic development. Through the Working Farm Model (WFM), we provide training
                    in agronomic practices, farming inputs, and extension services to smallholder farmers,
                    ensuring they receive competitive prices and market access for their coffee.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Vision, Mission, Objectives -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Vision -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="vmo-card h-100 p-4 bg-white rounded shadow-sm">
                    <div class="vmo-icon mb-3">
                        <i class="fas fa-eye fa-3x text-coffee"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Our Vision</h3>
                    <p>
                        Create a sustainable and prosperous future for the entire community by investing
                        in viable agri-business.
                    </p>
                </div>
            </div>

            <!-- Mission -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="vmo-card h-100 p-4 bg-white rounded shadow-sm">
                    <div class="vmo-icon mb-3">
                        <i class="fas fa-bullseye fa-3x text-coffee"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Our Mission</h3>
                    <p>
                        To promote sustainable agriculture production by practicing climate-smart
                        agriculture and creating market linkages, particularly for smallholder farmers
                        in the Bunyoro region.
                    </p>
                </div>
            </div>

            <!-- Objectives -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="vmo-card h-100 p-4 bg-white rounded shadow-sm">
                    <div class="vmo-icon mb-3">
                        <i class="fas fa-tasks fa-3x text-coffee"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3">Our Objectives</h3>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Increase production volumes for enhanced returns</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Value addition to prioritized crops</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Provide sustainable markets for farmers</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Promote savings culture for resilience</li>
                        <li class="mb-2"><i class="fas fa-check text-coffee me-2"></i>Encourage eco-friendly production</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Our Core Values</h2>
            <p class="lead text-muted">The principles that guide everything we do</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="value-card text-center p-4">
                    <i class="fas fa-users fa-3x text-green mb-3"></i>
                    <h5 class="fw-bold">Teamwork</h5>
                    <p class="small text-muted">Collaborating for success</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="value-card text-center p-4">
                    <i class="fas fa-clipboard-check fa-3x text-green mb-3"></i>
                    <h5 class="fw-bold">Accountability</h5>
                    <p class="small text-muted">Taking responsibility</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="value-card text-center p-4">
                    <i class="fas fa-shield-alt fa-3x text-green mb-3"></i>
                    <h5 class="fw-bold">Trustworthiness</h5>
                    <p class="small text-muted">Building reliable partnerships</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="value-card text-center p-4">
                    <i class="fas fa-handshake fa-3x text-green mb-3"></i>
                    <h5 class="fw-bold">Integrity</h5>
                    <p class="small text-muted">Honest and transparent</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 mx-auto" data-aos="zoom-in" data-aos-delay="500">
                <div class="value-card text-center p-4">
                    <i class="fas fa-hands-helping fa-3x text-green mb-3"></i>
                    <h5 class="fw-bold">Striving for the Good of All</h5>
                    <p class="small text-muted">Community-focused approach</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Products & Projects -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-coffee text-white px-3 py-2 mb-3">
                <i class="fas fa-box-open me-2"></i>What We Make
            </span>
            <h2 class="display-5 fw-bold">Our Products & Projects</h2>
            <p class="lead text-muted">Premium coffee and sustainable agricultural initiatives</p>
        </div>

        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="<?php echo SITE_URL; ?>/assets/images/products/fortune.jpg"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="Fortune Coffee"
                        loading="lazy"
                        style="object-fit: cover; height: 450px; width: 100%;">
                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-coffee text-white px-4 py-3 fs-6">
                            <i class="fas fa-award me-2"></i>Flagship Product
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h3 class="display-6 fw-bold mb-4">
                    <i class="fas fa-coffee text-coffee me-3"></i>Fortune Coffee
                </h3>
                <p class="lead mb-4">
                    Our signature brand registered under number 80020002031803, representing excellence in Ugandan coffee.
                </p>
                <p class="mb-4">
                    Fortune Coffee comprises both ground and whole bean roasted coffee that has received
                    resounding reception in the market. Through value addition, we provide much-needed jobs
                    for youth in the region while offering farmers the opportunity to enjoy their home-grown
                    coffee and connect with their heritage and efforts. We partner with CURAD in Kabanyoro
                    for processing and packing.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">100% Arabica & Robusta</h6>
                                <small class="text-muted">Premium blend varieties</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Organic Certified</h6>
                                <small class="text-muted">Chemical-free farming</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Ethically Sourced</h6>
                                <small class="text-muted">Fair trade practices</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Freshly Roasted</h6>
                                <small class="text-muted">Maximum flavor retention</small>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-coffee btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Shop Fortune Coffee
                </a>
            </div>
        </div>

        <!-- Other Projects -->
        <div class="row g-4 mt-4">
            <div class="col-12 text-center mb-4" data-aos="fade-up">
                <h3 class="h2 fw-bold">Other Agricultural Projects</h3>
                <p class="text-muted">Diversifying for sustainable growth and community impact</p>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 project-card">
                    <div class="card-body p-4">
                        <div class="project-icon mb-3">
                            <i class="fas fa-seedling fa-3x text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Coffee Mother Garden & Nursery</h5>
                        <p class="text-muted mb-3">
                            We've established a coffee mother garden with coffee lines KR-1 to KR-7, serving
                            as a source of quality, certified, and improved coffee planting materials for
                            smallholder farmers and youth.
                        </p>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><i class="fas fa-leaf text-success me-2"></i>KR-1 to KR-7 coffee lines</li>
                            <li class="mb-2"><i class="fas fa-leaf text-success me-2"></i>Free seedlings for youth (half acre)</li>
                            <li class="mb-2"><i class="fas fa-leaf text-success me-2"></i>Subsidized costs for others</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 project-card">
                    <div class="card-body p-4">
                        <div class="project-icon mb-3">
                            <i class="fas fa-spa fa-3x text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Honey Production</h5>
                        <p class="text-muted mb-3">
                            Collaborating with smallholder coffee farmers to venture into honey production
                            and related products, providing additional income streams and improving livelihoods.
                        </p>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i>Integrated with coffee farming</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i>Sustainable income source</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i>Market access provided</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100 project-card">
                    <div class="card-body p-4">
                        <div class="project-icon mb-3">
                            <i class="fas fa-tree fa-3x text-coffee"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Macadamia Nut Production</h5>
                        <p class="text-muted mb-3">
                            Integrating coffee and macadamia cultivation where macadamia provides shade for
                            coffee trees and enhances soil quality, creating multiple income streams for farmers.
                        </p>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><i class="fas fa-heart text-coffee me-2"></i>Shade provision for coffee</li>
                            <li class="mb-2"><i class="fas fa-heart text-coffee me-2"></i>Soil quality enhancement</li>
                            <li class="mb-2"><i class="fas fa-heart text-coffee me-2"></i>Diversified income</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The KDC Difference -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-coffee text-white px-3 py-2 mb-3">
                <i class="fas fa-star me-2"></i>Why Choose Us
            </span>
            <h2 class="display-5 fw-bold">The KDC Difference</h2>
            <p class="lead text-white-50">What sets us apart in the competitive world of coffee production</p>
        </div>

        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <div class="position-relative">
                    <img src="<?php echo SITE_URL; ?>/assets/images/products/coffeeprocessing.jpg"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="Coffee processing"
                        loading="lazy"
                        style="object-fit: cover; height: 500px; width: 100%;">
                    <!-- Stats Overlay -->
                    <div class="position-absolute bottom-0 start-0 m-4">
                        <div class="card bg-white text-dark border-0 shadow-lg" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.95) !important;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-users text-white fa-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 fw-bold text-success">500+</h4>
                                        <small class="text-muted">Farmers Trained</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <div class="pe-lg-4">
                    <div class="difference-item mb-4 p-4 bg-white bg-opacity-10 rounded-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-coffee rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-route text-white fa-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Working Farm Model (WFM)</h5>
                                <p class="mb-0 text-white-50">We take charge of smallholder farmers through training in agronomic practices, farming inputs, and extension services, establishing a 20-acre model coffee farm as a center for training and excellence.</p>
                            </div>
                        </div>
                    </div>

                    <div class="difference-item mb-4 p-4 bg-white bg-opacity-10 rounded-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user-graduate text-white fa-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Youth-Centered Approach</h5>
                                <p class="mb-0 text-white-50">We actively train and employ young people, creating opportunities in agriculture and building the next generation of farmers.</p>
                            </div>
                        </div>
                    </div>

                    <div class="difference-item mb-4 p-4 bg-white bg-opacity-10 rounded-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-leaf text-white fa-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Climate-Smart Agriculture</h5>
                                <p class="mb-0 text-white-50">Promoting environmentally friendly agricultural production practices that protect our environment and ensure sustainability for future generations.</p>
                            </div>
                        </div>
                    </div>

                    <div class="difference-item p-4 bg-white bg-opacity-10 rounded-3">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-hands-helping text-white fa-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Market Linkages & Fair Prices</h5>
                                <p class="mb-0 text-white-50">We solve market access problems by purchasing coffee from smallholders at competitive prices, marketing as green beans and processed Fortune Coffee on domestic and international markets.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-coffee text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Join Our Journey</h2>
        <p class="lead mb-4">
            Experience the difference that passion, quality, and community make in every cup
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Shop Our Coffee
            </a>
            <a href="<?php echo SITE_URL; ?>/pages/contact.php" class="btn btn-outline-light btn-lg">
                <i class="fas fa-envelope me-2"></i>Get in Touch
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>