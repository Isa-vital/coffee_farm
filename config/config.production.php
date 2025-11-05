<?php

/**
 * Production Configuration
 * Kiihabwemi Development Company Ltd
 * Domain: https://kiihabwemidevtcompany.com
 */

// Error Reporting - DISABLED for production
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');

// Timezone
date_default_timezone_set('Africa/Kampala');

// Database Configuration - UPDATE THESE WITH YOUR HOSTINGER DETAILS
define('DB_HOST', 'localhost'); // Usually 'localhost' for Hostinger
define('DB_PORT', '3306'); // Standard MySQL port
define('DB_NAME', 'u123456789_kdc'); // Your Hostinger database name (format: u[user_id]_dbname)
define('DB_USER', 'u123456789_kdc'); // Your Hostinger database username
define('DB_PASS', 'YourSecurePassword123!'); // Your Hostinger database password
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'Kiihabwemi Development Company Ltd');
define('SITE_TAGLINE', 'Your Trusted Agribusiness Partner');
define('SITE_URL', 'https://kiihabwemidevtcompany.com'); // Production domain - NO TRAILING SLASH
define('SITE_EMAIL', 'info@kiihabwemidevtcompany.com');
define('SUPPORT_EMAIL', 'support@kiihabwemidevtcompany.com');

// Contact Information
define('COMPANY_ADDRESS', 'Buhimba Town Council, Kikuube District, Bunyoro Region, Uganda');
define('COMPANY_PHONE', '+256 779 767 250');
define('WHATSAPP_NUMBER', '256779767250');
define('COMPANY_EMAIL', 'info@kiihabwemidevtcompany.com');

// Business Information
define('COMPANY_REGISTRATION', 'Fortune Coffee Registration: 80020002031803');
define('COMPANY_ESTABLISHED', '2018');
define('COMPANY_INCORPORATED', '2019');

// Social Media Links
define('FACEBOOK_URL', 'https://facebook.com/kiihabwemi');
define('TWITTER_URL', 'https://twitter.com/kiihabwemi');
define('INSTAGRAM_URL', 'https://instagram.com/kiihabwemi');
define('LINKEDIN_URL', 'https://linkedin.com/company/kiihabwemi');

// Security Settings
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes in seconds

// File Upload Settings
define('UPLOAD_MAX_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
define('UPLOAD_DIR', __DIR__ . '/../assets/images/uploads/');

// Pagination
define('PRODUCTS_PER_PAGE', 12);
define('ORDERS_PER_PAGE', 20);

// Currency
define('CURRENCY', 'UGX');
define('CURRENCY_SYMBOL', 'UGX');

// Email Configuration (for Hostinger SMTP)
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');
define('SMTP_USERNAME', 'noreply@kiihabwemidevtcompany.com'); // Create this email in Hostinger
define('SMTP_PASSWORD', 'YourEmailPassword123!'); // Email password
define('SMTP_FROM_EMAIL', 'noreply@kiihabwemidevtcompany.com');
define('SMTP_FROM_NAME', 'Kiihabwemi Development Company Ltd');

// Google Analytics & SEO
define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX'); // Replace with your actual GA4 ID
define('GOOGLE_SITE_VERIFICATION', 'YOUR_VERIFICATION_CODE'); // Get from Google Search Console
define('FACEBOOK_PIXEL_ID', ''); // Optional: Add Facebook Pixel ID

// Payment Gateway (for future implementation)
define('PAYMENT_MODE', 'live'); // 'test' or 'live'
define('MOBILE_MONEY_ENABLED', true);

// Cache Settings
define('ENABLE_CACHE', true);
define('CACHE_DURATION', 3600); // 1 hour

// Maintenance Mode
define('MAINTENANCE_MODE', false); // Set to true to enable maintenance page

// SSL/HTTPS Enforcement
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    if (!headers_sent()) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
        exit;
    }
}
