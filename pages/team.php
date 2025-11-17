<?php

/**
 * Team Page - Kiihabwemi Development Company Ltd
 */
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'Our Team - ' . SITE_NAME;
$pageDescription = 'Meet the dedicated team behind Kiihabwemi Development Company Ltd - passionate professionals driving sustainable coffee farming and community development.';
$pageKeywords = 'KDC team, board members, management, coffee experts Uganda';

// Fetch team members from database
try {
    // Get board members
    $boardMembers = fetchAll($pdo, "SELECT * FROM team_members WHERE category = 'board' AND status = 'active' ORDER BY display_order ASC");
    
    // Get management team
    $managementTeam = fetchAll($pdo, "SELECT * FROM team_members WHERE category = 'management' AND status = 'active' ORDER BY display_order ASC");
    
    // Get partners
    $partners = fetchAll($pdo, "SELECT * FROM team_members WHERE category = 'partner' AND status = 'active' ORDER BY display_order ASC");
} catch (PDOException $e) {
    error_log("Error fetching team members: " . $e->getMessage());
    $boardMembers = [];
    $managementTeam = [];
    $partners = [];
}
?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Our Team</h1>
                <p class="lead mb-0">The People Behind Our Success</p>
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Team</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Team Introduction -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-4">Meet Our Dedicated Team</h2>
                <p class="lead text-muted">
                    At Kiihabwemi Development Company Ltd, our success is built on the expertise, 
                    dedication, and passion of our team members. From our board of directors to our 
                    field coordinators, every member plays a crucial role in transforming lives through 
                    sustainable agriculture.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Board Members -->
<?php if (!empty($boardMembers)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-coffee text-white px-3 py-2 mb-3">
                <i class="fas fa-users-cog me-2"></i>Leadership
            </span>
            <h2 class="display-5 fw-bold">The Board</h2>
            <p class="lead text-muted">Guiding our strategic vision and governance</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($boardMembers as $index => $member): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                    <div class="card border-0 shadow-sm h-100 team-card">
                        <div class="card-body text-center p-4">
                            <div class="team-image-wrapper mb-3">
                                <?php if (!empty($member['photo_url'])): ?>
                                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($member['photo_url']); ?>" 
                                         alt="<?php echo e($member['name']); ?>"
                                         class="rounded-circle img-fluid shadow"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-coffee d-flex align-items-center justify-content-center mx-auto shadow"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-white"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h5 class="fw-bold mb-2"><?php echo e($member['name']); ?></h5>
                            <p class="text-coffee fw-semibold mb-3"><?php echo e($member['position']); ?></p>
                            <?php if (!empty($member['bio'])): ?>
                                <p class="text-muted small mb-0"><?php echo e($member['bio']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Management Team -->
<?php if (!empty($managementTeam)): ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-success text-white px-3 py-2 mb-3">
                <i class="fas fa-user-tie me-2"></i>Operations
            </span>
            <h2 class="display-5 fw-bold">Management Team</h2>
            <p class="lead text-muted">Driving daily operations and excellence</p>
        </div>

        <div class="row g-4">
            <?php foreach ($managementTeam as $index => $member): ?>
                <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                    <div class="card border-0 shadow-sm h-100 team-card">
                        <div class="card-body text-center p-4">
                            <div class="team-image-wrapper mb-3">
                                <?php if (!empty($member['photo_url'])): ?>
                                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($member['photo_url']); ?>" 
                                         alt="<?php echo e($member['name']); ?>"
                                         class="rounded-circle img-fluid shadow-sm"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                         style="width: 120px; height: 120px;">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h6 class="fw-bold mb-1"><?php echo e($member['name']); ?></h6>
                            <p class="text-success small fw-semibold mb-2"><?php echo e($member['position']); ?></p>
                            <?php if (!empty($member['bio'])): ?>
                                <p class="text-muted small mb-0"><?php echo e(truncateText($member['bio'], 100)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Partners -->
<?php if (!empty($partners)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                <i class="fas fa-handshake me-2"></i>Collaboration
            </span>
            <h2 class="display-5 fw-bold">Our Partners</h2>
            <p class="lead text-muted">Working together for greater impact</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($partners as $index => $partner): ?>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                    <div class="card border-0 shadow-sm h-100 partner-card text-center p-4">
                        <?php if (!empty($partner['photo_url'])): ?>
                            <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo e($partner['photo_url']); ?>" 
                                 alt="<?php echo e($partner['name']); ?>"
                                 class="img-fluid mb-3 mx-auto"
                                 style="max-height: 100px; width: auto;">
                        <?php endif; ?>
                        <h5 class="fw-bold mb-2"><?php echo e($partner['name']); ?></h5>
                        <?php if (!empty($partner['position'])): ?>
                            <p class="text-warning fw-semibold mb-3"><?php echo e($partner['position']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($partner['bio'])): ?>
                            <p class="text-muted small"><?php echo e($partner['bio']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action -->
<section class="py-5 bg-coffee text-white">
    <div class="container text-center" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Join Our Journey</h2>
        <p class="lead mb-4">
            Interested in working with us or partnering with KDC?
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?php echo SITE_URL; ?>/pages/contact.php" class="btn btn-light btn-lg">
                <i class="fas fa-envelope me-2"></i>Get in Touch
            </a>
            <a href="<?php echo SITE_URL; ?>/pages/about.php" class="btn btn-outline-light btn-lg">
                <i class="fas fa-info-circle me-2"></i>Learn More About Us
            </a>
        </div>
    </div>
</section>

<style>
.team-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
}

.partner-card {
    transition: transform 0.3s ease;
}

.partner-card:hover {
    transform: scale(1.05);
}
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
