# Kiihabwemi Development Company Ltd - Coffee Farm Ecommerce Website

![KDC Logo](assets/images/logo.png)

A professional, secure, and SEO-optimized ecommerce website for Kiihabwemi Development Company Ltd (KDC) to showcase premium Ugandan coffee products, promote agribusiness initiatives, and enable WhatsApp-based checkout.

## 🚀 Features

### Frontend
- **Responsive Design**: Built with Bootstrap 5 for mobile-first, responsive layouts
- **Modern UI/UX**: Smooth animations with AOS.js, intuitive navigation
- **Product Showcase**: Dynamic product listings with detailed pages
- **Shopping Cart**: Client-side cart management using localStorage
- **WhatsApp Checkout**: Seamless order placement via WhatsApp
- **SEO Optimized**: Meta tags, Schema.org markup, sitemap, and robots.txt

### Backend
- **Secure Database**: MySQL with PDO prepared statements
- **Admin Dashboard**: Manage products, view messages, and track orders
- **Contact Form**: Validated PHP form with CSRF protection
- **Session Management**: Secure admin authentication with auto-logout

### Security
- SQL injection prevention with PDO prepared statements
- XSS protection through input sanitization
- CSRF token validation
- Password hashing with Argon2ID
- Secure session handling
- .htaccess security rules

## 📋 Requirements

- **Web Server**: Apache 2.4+ (with mod_rewrite enabled)
- **PHP**: 7.4+ or 8.0+
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Extensions**: PDO, PDO_MySQL, mbstring, openssl

## 🛠️ Installation

### Step 1: Setup Files

1. Clone or download this repository to your XAMPP htdocs folder:
```bash
cd c:\xampp\htdocs\
git clone <repository-url> coffee_farm
```

Or simply extract the files to `c:\xampp\htdocs\coffee_farm\`

### Step 2: Database Setup

1. Start XAMPP and ensure Apache and MySQL are running

2. Open phpMyAdmin: `http://localhost/phpmyadmin`

3. Import the database:
   - Click "New" to create a database named `kdc_website`
   - Click "Import" tab
   - Choose file: `database.sql`
   - Click "Go"

4. Verify tables are created:
   - products
   - users
   - messages
   - cart_sessions
   - orders
   - activity_log

### Step 3: Configuration

1. Open `config/config.php`

2. Update database credentials if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'kdc_website');
define('DB_USER', 'root');
define('DB_PASS', '');
```

3. Update site URL (for production):
```php
define('SITE_URL', 'http://localhost/coffee_farm');
```

4. **IMPORTANT**: Update WhatsApp number:
```php
define('WHATSAPP_NUMBER', '256700000000'); // Replace with actual number
```

### Step 4: Admin Account

1. Default admin credentials:
   - **Username**: `admin`
   - **Password**: `Admin@123`

2. **CRITICAL**: Change the default password immediately!

3. To create a new admin user:
```php
$username = 'newadmin';
$password = 'YourSecurePassword';
$password_hash = password_hash($password, PASSWORD_ARGON2ID);

// Insert into database via phpMyAdmin or SQL
INSERT INTO users (username, email, password_hash, role) 
VALUES ('newadmin', 'admin@email.com', '$password_hash', 'admin');
```

### Step 5: File Permissions

Ensure proper permissions for uploads and logs:

**Windows (XAMPP):**
- Right-click folders → Properties → Security
- Give IUSR and IIS_IUSRS full control

**Linux/Mac:**
```bash
chmod 755 assets/images/products/
chmod 755 logs/
```

### Step 6: Testing

1. Access the website: `http://localhost/coffee_farm/`

2. Test pages:
   - Home: `http://localhost/coffee_farm/`
   - Shop: `http://localhost/coffee_farm/pages/shop.php`
   - Admin: `http://localhost/coffee_farm/pages/admin/login.php`

## 📁 Project Structure

```
coffee_farm/
├── assets/
│   ├── css/
│   │   └── custom.css
│   ├── js/
│   │   ├── main.js
│   │   └── cart.js
│   ├── images/
│   │   ├── products/
│   │   └── (logo, hero, etc.)
│   └── vendor/
├── config/
│   └── config.php
├── includes/
│   ├── db_connect.php
│   ├── functions.php
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
├── pages/
│   ├── about.php
│   ├── shop.php
│   ├── product.php
│   ├── cart.php
│   ├── community.php
│   ├── contact.php
│   └── admin/
│       ├── login.php
│       └── dashboard.php (to be added)
├── logs/
│   └── error.log
├── index.php
├── database.sql
├── sitemap.xml
├── robots.txt
├── .htaccess
└── README.md
```

## 🎨 Customization

### Branding

1. **Logo**: Replace `assets/images/logo.png` with your logo
2. **Colors**: Edit CSS variables in `assets/css/custom.css`:
```css
:root {
    --coffee-brown: #6F4E37;
    --coffee-light: #A67C52;
    --coffee-dark: #4B3621;
}
```

### Adding Products

**Via phpMyAdmin:**
```sql
INSERT INTO products (name, slug, description, price, image, stock, weight) 
VALUES (
    'Product Name',
    'product-name',
    'Product description here',
    25000,
    'product-image.jpg',
    100,
    '500g'
);
```

**Via Admin Panel:** (Once dashboard is complete)
- Login to admin
- Navigate to Products
- Click "Add New Product"

### Images

1. Product images should be:
   - Format: JPEG, PNG, or WebP
   - Size: Max 5MB
   - Dimensions: 800x800px recommended
   - Location: `assets/images/products/`

2. Optimize images before upload:
   - Use TinyPNG.com or similar
   - Compress without losing quality

## 🔒 Security Best Practices

### For Production

1. **Change Database Credentials**:
   - Use strong password for MySQL
   - Create separate database user (not root)

2. **Enable HTTPS**:
   - Get SSL certificate (Let's Encrypt)
   - Update `.htaccess` to force HTTPS

3. **Update config.php**:
```php
define('DISPLAY_ERRORS', 0);
ini_set('session.cookie_secure', 1); // HTTPS only
```

4. **Secure Admin**:
   - Change default admin credentials
   - Use strong passwords (16+ characters)
   - Enable 2FA (custom implementation)

5. **File Permissions**:
   - config.php: 644
   - .htaccess: 644
   - Folders: 755
   - PHP files: 644

6. **Regular Backups**:
```bash
# Database backup
mysqldump -u root -p kdc_website > backup_$(date +%Y%m%d).sql

# Files backup
tar -czf backup_files_$(date +%Y%m%d).tar.gz coffee_farm/
```

## 📊 SEO Optimization

### Google Analytics

1. Get GA4 measurement ID from analytics.google.com
2. Update in `includes/header.php`:
```javascript
gtag('config', 'G-XXXXXXXXXX'); // Your measurement ID
```

### Google Search Console

1. Get verification code
2. Update in `includes/header.php`:
```html
<meta name="google-site-verification" content="YOUR_CODE">
```

### Sitemap Submission

1. Submit sitemap: `http://yourdomain.com/sitemap.xml`
2. To Google Search Console
3. To Bing Webmaster Tools

## 🚀 Performance Optimization

### Enable Caching

Already configured in `.htaccess`. Verify Apache modules are enabled:
- mod_deflate (GZIP compression)
- mod_expires (Browser caching)
- mod_headers (Cache headers)

### Image Optimization

1. Use WebP format for better compression
2. Implement lazy loading (already included)
3. Use CDN for static assets (production)

### Minification

For production, minify CSS and JS:
```bash
# Install UglifyJS
npm install -g uglify-js

# Minify JavaScript
uglifyjs assets/js/main.js -o assets/js/main.min.js
uglifyjs assets/js/cart.js -o assets/js/cart.min.js
```

## 🛠️ Maintenance

### Database Maintenance

Run monthly:
```sql
OPTIMIZE TABLE products;
OPTIMIZE TABLE users;
OPTIMIZE TABLE messages;
OPTIMIZE TABLE orders;
```

### Log Management

Monitor error logs:
- Location: `logs/error.log`
- Rotate logs monthly
- Clear old entries

### Updates

1. Keep PHP updated
2. Update Bootstrap/libraries annually
3. Review security patches
4. Test thoroughly after updates

## 📱 WhatsApp Integration

### Setting Up

1. Update WhatsApp number in `config/config.php`:
```php
define('WHATSAPP_NUMBER', '256XXXXXXXXX');
```

2. Format: Country code + number (no + or spaces)
   - Example: 256700000000 (Uganda)

3. Test WhatsApp links work correctly

### Message Format

Cart checkout generates:
```
Hello KDC! I want to order:

- Premium Arabica Coffee (500g) x2
- Ground Coffee (500g) x1

Total: UGX 72,000

Please confirm my order. Thank you!
```

## 🐛 Troubleshooting

### Database Connection Error

**Error**: "We're experiencing technical difficulties"

**Solution**:
1. Check MySQL is running in XAMPP
2. Verify database credentials in `config/config.php`
3. Ensure database `kdc_website` exists

### Images Not Displaying

**Solution**:
1. Check image path is correct
2. Verify file exists in `assets/images/products/`
3. Check file permissions

### .htaccess Not Working

**Solution**:
1. Enable mod_rewrite in Apache
2. Edit `httpd.conf`, change `AllowOverride None` to `AllowOverride All`
3. Restart Apache

### Admin Login Fails

**Solution**:
1. Reset password via phpMyAdmin
2. Generate new hash:
```php
<?php
echo password_hash('NewPassword123', PASSWORD_ARGON2ID);
?>
```
3. Update in users table

## 📞 Support

For issues or questions:
- **Email**: info@kdc-coffee.com
- **WhatsApp**: +256700000000
- **Website**: http://kdc-coffee.com

## 📝 License

© 2025 Kiihabwemi Development Company Ltd. All rights reserved.

## 👨‍💻 Development

**Version**: 1.0.0  
**Last Updated**: November 3, 2025  
**Developed For**: Kiihabwemi Development Company Ltd

### Tech Stack
- HTML5, CSS3
- Bootstrap 5.3
- JavaScript ES6
- PHP 7.4+
- MySQL 5.7+
- AOS.js (animations)
- Font Awesome 6

---

**Note**: This is a production-ready application. Ensure all security configurations are properly set before deploying to a live server.
