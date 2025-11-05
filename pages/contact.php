<?php

/**
 * Contact Page - Kiihabwemi Development Company Ltd
 */
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';

$pageTitle = 'Contact Us - ' . SITE_NAME;
$pageDescription = 'Get in touch with Kiihabwemi Development Company Ltd. We\'re here to answer your questions about our premium coffee and community programs.';
$pageKeywords = 'contact KDC, coffee inquiry, Uganda coffee contact, get in touch';



// Handle form submission
$formSuccess = false;
$formErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        $formErrors[] = 'Invalid form submission. Please try again.';
    } else {
        // Sanitize and validate inputs
        $name = sanitizeInput($_POST['name'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $subject = sanitizeInput($_POST['subject'] ?? '');
        $message = sanitizeInput($_POST['message'] ?? '');

        // Validation
        if (empty($name) || strlen($name) < 2) {
            $formErrors[] = 'Please enter a valid name (minimum 2 characters).';
        }

        if (empty($email) || !isValidEmail($email)) {
            $formErrors[] = 'Please enter a valid email address.';
        }

        if (empty($subject) || strlen($subject) < 3) {
            $formErrors[] = 'Please enter a subject (minimum 3 characters).';
        }

        if (empty($message) || strlen($message) < 10) {
            $formErrors[] = 'Please enter a message (minimum 10 characters).';
        }

        // If no errors, save to database
        if (empty($formErrors)) {
            try {
                $sql = "INSERT INTO messages (name, email, subject, message, created_at) 
                        VALUES (:name, :email, :subject, :message, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                ]);

                $formSuccess = true;

                // Clear form data
                $_POST = [];
            } catch (PDOException $e) {
                error_log("Contact form error: " . $e->getMessage());
                $formErrors[] = 'An error occurred. Please try again later.';
            }
        }
    }
}

// Generate CSRF token
$csrfToken = generateCSRFToken();
?>

<!-- Page Header -->
<section class="page-header bg-coffee text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Contact Us</h1>
                <p class="lead">We'd love to hear from you!</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card text-center h-100 p-4 bg-light rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Our Location</h5>
                    <p class="mb-0">
                        Kiihabwemi<br>
                        Uganda, East Africa
                    </p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card text-center h-100 p-4 bg-light rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Phone & WhatsApp</h5>
                    <p class="mb-2">
                        <a href="tel:+<?php echo WHATSAPP_NUMBER; ?>" class="text-decoration-none text-dark">
                            +<?php echo WHATSAPP_NUMBER; ?>
                        </a>
                    </p>
                    <p class="mb-0">
                        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" class="btn btn-success btn-sm" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-info-card text-center h-100 p-4 bg-light rounded shadow-sm">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-envelope fa-3x text-coffee"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Email Address</h5>
                    <p class="mb-0">
                        <a href="mailto:info@kdc-coffee.com" class="text-decoration-none text-dark">
                            info@kdc-coffee.com
                        </a><br>
                        <a href="mailto:sales@kdc-coffee.com" class="text-decoration-none text-dark">
                            sales@kdc-coffee.com
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 fw-bold mb-4">Send Us a Message</h2>

                <?php if ($formSuccess): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Thank you!</strong> Your message has been sent successfully. We'll get back to you soon.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($formErrors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($formErrors as $error): ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="contact-form" id="contactForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Your Name <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="<?php echo e($_POST['name'] ?? ''); ?>"
                            required
                            minlength="2"
                            maxlength="100">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?php echo e($_POST['email'] ?? ''); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control"
                            id="subject"
                            name="subject"
                            value="<?php echo e($_POST['subject'] ?? ''); ?>"
                            required
                            minlength="3"
                            maxlength="200">
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control"
                            id="message"
                            name="message"
                            rows="6"
                            required
                            minlength="10"
                            maxlength="1000"><?php echo e($_POST['message'] ?? ''); ?></textarea>
                        <div class="form-text">Minimum 10 characters</div>
                    </div>

                    <button type="submit" class="btn btn-coffee btn-lg w-100">
                        <i class="fas fa-paper-plane me-2"></i>Send Message
                    </button>
                </form>
            </div>

            <!-- Map and Additional Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-6 fw-bold mb-4">Find Us</h2>

                <!-- Embedded Map - Kiihabwemi LC, Buhimba Town Council, Kikuube District -->
                <div class="map-container mb-4 rounded overflow-hidden shadow">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63722.5!2d31.2667!3d1.0167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMDEnMDAuMSJOIDMxwrAxNicwMC4xIkU!5e0!3m2!1sen!2sug!4v1699122000000!5m2!1sen!2sug"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Business Hours -->
                <div class="bg-light p-4 rounded shadow-sm mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-clock text-coffee me-2"></i>Business Hours
                    </h5>
                    <table class="table table-borderless mb-0 small">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Monday - Friday:</td>
                                <td class="text-end">8:00 AM - 6:00 PM</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Saturday:</td>
                                <td class="text-end">9:00 AM - 4:00 PM</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Sunday:</td>
                                <td class="text-end">Closed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Quick Contact -->
                <div class="bg-coffee text-white p-4 rounded shadow-sm">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-headset me-2"></i>Need Immediate Assistance?
                    </h5>
                    <p class="mb-3">Our team is available on WhatsApp for quick responses!</p>
                    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=Hello%20KDC!%20I%20need%20assistance"
                        class="btn btn-light w-100" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Chat with Us Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-6 fw-bold">Frequently Asked Questions</h2>
            <p class="lead text-muted">Quick answers to common questions</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How can I place an order?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can place orders through our website by adding products to your cart and checking out via WhatsApp,
                                or by contacting us directly through phone or email.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                What are your delivery options?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer delivery across Uganda. Free delivery is available within Kampala.
                                For other regions, delivery fees apply based on location. Contact us for specific rates.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Do you accept bulk orders?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We welcome bulk orders and offer special pricing for large quantities.
                                Contact us directly to discuss your requirements and receive a customized quote.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Is your coffee organic?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, all our coffee is 100% organic, grown without chemical fertilizers or pesticides.
                                We use sustainable farming practices to ensure the highest quality while protecting the environment.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>