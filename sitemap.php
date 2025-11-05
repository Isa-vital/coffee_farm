<?php

/**
 * Sitemap Generator
 * Kiihabwemi Development Company Ltd
 * Generates XML sitemap for search engines
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db_connect.php';

header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <!-- Homepage -->
    <url>
        <loc><?php echo SITE_URL; ?>/</loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- About Page -->
    <url>
        <loc><?php echo SITE_URL; ?>/pages/about.php</loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Shop Page -->
    <url>
        <loc><?php echo SITE_URL; ?>/pages/shop.php</loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Community Page -->
    <url>
        <loc><?php echo SITE_URL; ?>/pages/community.php</loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Contact Page -->
    <url>
        <loc><?php echo SITE_URL; ?>/pages/contact.php</loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <?php
    // Fetch all active products
    try {
        $stmt = $pdo->query("SELECT slug, updated_at, image_url FROM products WHERE status = 'active' ORDER BY created_at DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $lastmod = $product['updated_at'] ? date('Y-m-d', strtotime($product['updated_at'])) : date('Y-m-d');
            $imageUrl = SITE_URL . '/assets/images/products/' . $product['image_url'];
    ?>
            <!-- Product: <?php echo htmlspecialchars($product['slug']); ?> -->
            <url>
                <loc><?php echo SITE_URL; ?>/product/<?php echo htmlspecialchars($product['slug']); ?></loc>
                <lastmod><?php echo $lastmod; ?></lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.8</priority>
                <?php if (!empty($product['image_url'])): ?>
                    <image:image>
                        <image:loc><?php echo htmlspecialchars($imageUrl); ?></image:loc>
                        <image:title><?php echo htmlspecialchars($product['slug']); ?></image:title>
                    </image:image>
                <?php endif; ?>
            </url>
    <?php
        }
    } catch (PDOException $e) {
        // Log error but continue generating sitemap
        error_log('Sitemap generation error: ' . $e->getMessage());
    }
    ?>

</urlset>