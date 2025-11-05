<?php

/**
 * Reusable Functions
 * Kiihabwemi Development Company Ltd
 */

/**
 * Sanitize input data
 */
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate CSRF token
 */
function generateCSRFToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format price in UGX
 */
function formatPrice($amount)
{
    return 'UGX ' . number_format($amount, 0, '.', ',');
}

/**
 * Generate SEO-friendly URL slug
 */
function generateSlug($string)
{
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

/**
 * Validate image upload
 */
function validateImage($file)
{
    $errors = [];

    // Check if file was uploaded
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "File upload error.";
        return $errors;
    }

    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        $errors[] = "File size exceeds " . (MAX_FILE_SIZE / 1048576) . "MB limit.";
    }

    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
        $errors[] = "Invalid file type. Only JPEG, PNG, and WebP allowed.";
    }

    return $errors;
}

/**
 * Upload image file
 */
function uploadImage($file, $uploadDir)
{
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('product_', true) . '.' . $extension;
    $destination = $uploadDir . $filename;

    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }

    return false;
}

/**
 * Check if user is logged in (admin)
 */
function isLoggedIn()
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirect to URL
 */
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

/**
 * Get current page name
 */
function getCurrentPage()
{
    return basename($_SERVER['PHP_SELF'], '.php');
}

/**
 * Generate meta description
 */
function truncateText($text, $length = 160)
{
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

/**
 * Escape output for HTML
 */
function e($string)
{
    if ($string === null || $string === '') {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate WhatsApp order message
 */
function generateWhatsAppMessage($cartItems, $total)
{
    $message = "Hello KDC! I want to order:%0A%0A";

    foreach ($cartItems as $item) {
        $message .= "- " . urlencode($item['name']) . " (" . urlencode($item['weight']) . ") x" . $item['quantity'] . "%0A";
    }

    $message .= "%0ATotal: UGX " . number_format($total, 0, '.', ',');

    return "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . $message;
}

/**
 * Check session timeout
 */
function checkSessionTimeout()
{
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        return true;
    }
    $_SESSION['last_activity'] = time();
    return false;
}

/**
 * Get products from database
 */
function getProducts($pdo, $limit = null)
{
    $sql = "SELECT * FROM products WHERE stock_quantity > 0 AND status = 'active' ORDER BY created_at DESC";
    if ($limit) {
        $sql .= " LIMIT :limit";
    }

    try {
        $stmt = $pdo->prepare($sql);
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Get Products Error: " . $e->getMessage());
        return [];
    }
}

/**
 * Get single product by ID
 */
function getProductById($pdo, $id)
{
    $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Get Product Error: " . $e->getMessage());
        return false;
    }
}
