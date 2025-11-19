<?php

/**
 * Header Include
 * Kiihabwemi Development Company Ltd
 */

require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch site settings from database
$siteSettings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch()) {
        $siteSettings[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $e) {
    error_log("Error fetching settings: " . $e->getMessage());
}

// Helper function to get setting with fallback
function getSetting($key, $default = '')
{
    global $siteSettings;
    return $siteSettings[$key] ?? $default;
}

// Set default page variables if not set
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? 'Premium coffee from Kiihabwemi Development Company Ltd. Supporting youth empowerment and sustainable farming in Uganda.';
$pageKeywords = $pageKeywords ?? 'coffee, Uganda coffee, premium coffee, Kiihabwemi, sustainable farming, arabica coffee';
$pageImage = $pageImage ?? SITE_URL . '/assets/images/og-image.jpg';
$currentPage = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Primary Meta Tags -->
    <title><?php echo e($pageTitle); ?></title>
    <meta name="title" content="<?php echo e($pageTitle); ?>">
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="<?php echo e($pageKeywords); ?>">
    <meta name="author" content="Kiihabwemi Development Company Ltd">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(SITE_URL . '/' . $currentPage . '.php'); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:image" content="<?php echo e($pageImage); ?>">
    <meta property="og:site_name" content="<?php echo e(SITE_NAME); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(SITE_URL . '/' . $currentPage . '.php'); ?>">
    <meta property="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta property="twitter:description" content="<?php echo e($pageDescription); ?>">
    <meta property="twitter:image" content="<?php echo e($pageImage); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/android-chrome-512x512.png">
    <link rel="manifest" href="<?php echo SITE_URL; ?>/assets/images/favicon_io/site.webmanifest">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(SITE_URL . '/' . $currentPage . '.php'); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">

    <!-- Google Analytics 4 -->
    <!-- Replace G-XXXXXXXXXX with your actual GA4 measurement ID -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>

    <!-- Google Search Console Verification -->
    <meta name="google-site-verification" content="YOUR_VERIFICATION_CODE">

    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?php echo e(SITE_NAME); ?>",
            "url": "<?php echo e(SITE_URL); ?>",
            "logo": "<?php echo e(SITE_URL); ?>/assets/images/logo.png",
            "description": "<?php echo e($pageDescription); ?>",
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "UG",
                "addressRegion": "Uganda"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+<?php echo WHATSAPP_NUMBER; ?>",
                "contactType": "Customer Service"
            },
            "sameAs": [
                "https://facebook.com/kiihabwemi",
                "https://twitter.com/kiihabwemi",
                "https://instagram.com/kiihabwemi"
            ]
        }
    </script>
</head>

<body>