<?php

/**
 * Community Page - Kiihabwemi Development Company Ltd
 */

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'Community Impact - ' . SITE_NAME;
$pageDescription = 'Discover how Kiihabwemi Development Company empowers youth, supports farmers, and promotes sustainability in Ugandan coffee farming communities.';
$pageKeywords = 'community impact, youth empowerment, sustainable farming, farmer support, Uganda agriculture';

?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Our Community</h1>
                <p class="lead">Growing Together, Empowering Lives</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Community</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Community Impact Stats -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Our Impact in Numbers</h2>
            <p class="lead text-muted">Making a difference, one coffee bean at a time</p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="impact-stat p-4">
                    <i class="fas fa-users fa-3x text-coffee mb-3"></i>
                    <h3 class="display-4 fw-bold text-coffee">200+</h3>
                    <p class="lead">Youth Trained</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="impact-stat p-4">
                    <i class="fas fa-seedling fa-3x text-coffee mb-3"></i>
                    <h3 class="display-4 fw-bold text-coffee">500+</h3>
                    <p class="lead">Farmers Supported</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="impact-stat p-4">
                    <i class="fas fa-tree fa-3x text-coffee mb-3"></i>
                    <h3 class="display-4 fw-bold text-coffee">10,000+</h3>
                    <p class="lead">Trees Planted</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="impact-stat p-4">
                    <i class="fas fa-hand-holding-heart fa-3x text-coffee mb-3"></i>
                    <h3 class="display-4 fw-bold text-coffee">50+</h3>
                    <p class="lead">Communities Reached</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Youth Empowerment -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="<?php echo SITE_URL; ?>/assets/images/products/IMG-20251104-WA0026.jpg"
                    class="img-fluid rounded shadow"
                    alt="Youth in agriculture"
                    loading="lazy">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-5 fw-bold mb-4">Youth Empowerment</h2>
                <p class="lead mb-4">
                    We believe the future of agriculture lies in the hands of young people.
                    Facing unemployment challenges, youth receive free coffee seedlings to establish
                    half an acre of coffee, with comprehensive training and support.
                </p>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-graduation-cap text-coffee me-2"></i>Agribusiness Training</h5>
                    <p>Practical skills in modern farming techniques, business management, and entrepreneurship to help young farmers start their own agricultural enterprises.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-briefcase text-coffee me-2"></i>Employment through Value Addition</h5>
                    <p>Fortune Coffee processing creates much-needed jobs for youth in the region while building practical skills.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-seedling text-coffee me-2"></i>Free Seedling Program</h5>
                    <p>Youth farmers receive free quality coffee seedlings for half an acre to encourage participation in coffee farming and build sustainable livelihoods.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sustainable Farming -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2" data-aos="fade-left">
                <img src="<?php echo SITE_URL; ?>/assets/images/products/coffeeseedling.jpg"
                    class="img-fluid rounded shadow"
                    alt="Sustainable farming"
                    loading="lazy">
            </div>
            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <h2 class="display-5 fw-bold mb-4">Climate-Smart & Sustainable Practices</h2>
                <p class="lead mb-4">
                    Promoting environmentally friendly agricultural production practices to protect
                    the environment while ensuring productivity and profitability for generations to come.
                </p>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-leaf text-coffee me-2"></i>Climate-Smart Agriculture</h5>
                    <p>Practicing sustainable agriculture that adapts to climate change while maintaining productivity and environmental protection.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-recycle text-coffee me-2"></i>Soil Health & Biodiversity</h5>
                    <p>Environmentally friendly farming methods that protect soil health and biodiversity for sustainable crop production.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-tree text-coffee me-2"></i>Integrated Farming Systems</h5>
                    <p>Combining coffee with macadamia for shade, honey production for diversification, and other crops for household food security.</p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold"><i class="fas fa-users text-coffee me-2"></i>Community Resilience</h5>
                    <p>Building socio-economic resilience through diversified income sources and savings programs for enhanced household welfare.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Farmer Support -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="<?php echo SITE_URL; ?>/assets/images/products/fotunecoffeegrap.jpg"
                    class="img-fluid rounded shadow"
                    alt="Supporting local farmers"
                    loading="lazy">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-5 fw-bold mb-4">Farmer Empowerment through Working Farm Model</h2>
                <p class="lead mb-4">
                    The Working Farm Model (WFM) solves market access problems by providing training,
                    inputs, extension services, and guaranteed markets at competitive prices for smallholder farmers.
                </p>

                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-coffee me-2"></i>
                        <strong>Competitive Prices:</strong> Fair pricing for coffee through guaranteed market access
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-coffee me-2"></i>
                        <strong>Agronomic Training:</strong> Regular workshops on best farming practices and extension services
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-coffee me-2"></i>
                        <strong>Quality Planting Materials:</strong> Access to improved coffee seedlings from our mother garden (KR-1 to KR-7)
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-coffee me-2"></i>
                        <strong>Input Provision:</strong> Necessary farming inputs and support to improve productivity
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-coffee me-2"></i>
                        <strong>20-Acre Model Farm:</strong> Center for training and excellence in quality coffee production
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Community Programs -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Community Development Programs</h2>
            <p class="lead text-muted">Investing in the communities we serve</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-piggy-bank fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Village Savings & Loans</h4>
                    <p>
                        SACCO program promoting savings culture for socio-economic transformation. Members save
                        a portion of agricultural revenues each season, with access to affordable loans for next season's inputs.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-spa fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Honey Production</h4>
                    <p>
                        Collaborating with coffee farmers to venture into honey production and related products,
                        establishing sustainable income streams and improving overall well-being.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-tree fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Macadamia Integration</h4>
                    <p>
                        Integrating macadamia with coffee farming for shade provision, soil quality enhancement,
                        and diversified revenue streams at different intervals.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-link fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Market Linkages</h4>
                    <p>
                        Creating backward and forward linkages with suppliers and buyers, reducing price fluctuation
                        risks and providing opportunities for value addition and branding.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-graduation-cap fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Training & Capacity Building</h4>
                    <p>
                        Regular strategic savings, investment training, and agronomic practice sessions ensuring
                        medium and long-term socio-economic improvement for members.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="program-card h-100 p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-seedling fa-3x text-coffee mb-3"></i>
                    <h4 class="fw-bold mb-3">Model Coffee Farm</h4>
                    <p>
                        Our 20-acre model farm serves as a center for training excellence and quality coffee
                        cutting production, demonstrating best practices to the farming community.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Get Involved CTA -->
<section class="py-5 bg-coffee text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Join Our Mission</h2>
        <p class="lead mb-4">
            Every purchase supports our community programs. Together, we can make a lasting impact.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?php echo SITE_URL; ?>/pages/shop.php" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Shop & Support
            </a>
            <a href="<?php echo SITE_URL; ?>/pages/contact.php" class="btn btn-outline-light btn-lg">
                <i class="fas fa-hands-helping me-2"></i>Partner With Us
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>