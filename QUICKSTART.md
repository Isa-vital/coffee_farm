# KDC Coffee Website - Quick Setup Guide

## 🚀 Quick Start (5 Minutes)

### Step 1: Start XAMPP
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL**
3. Verify both are running (green indicators)

### Step 2: Create Database
1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click "New" on the left sidebar
3. Database name: `kdc_website`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"
6. Click "Import" tab
7. Choose file: `database.sql` (from project folder)
8. Click "Go" at the bottom
9. Wait for success message

### Step 3: Verify Installation
1. Open browser and go to: `http://localhost/coffee_farm/`
2. You should see the homepage!

### Step 4: Access Admin Panel
1. Go to: `http://localhost/coffee_farm/pages/admin/login.php`
2. Default credentials:
   - **Username:** `admin`
   - **Password:** `Admin@123`
3. **IMPORTANT:** Change password immediately!

### Step 5: Configure WhatsApp
1. Open `config/config.php`
2. Find line: `define('WHATSAPP_NUMBER', '256700000000');`
3. Replace with your WhatsApp number (format: country code + number, no spaces)
4. Example: `256701234567` for Uganda number

## ✅ Verification Checklist

After setup, verify these work:

- [ ] Homepage loads at `http://localhost/coffee_farm/`
- [ ] Shop page shows products
- [ ] Can add items to cart
- [ ] Admin login works
- [ ] Admin dashboard displays

## 🎨 Add Your Images

1. Prepare your images (see IMAGES.md for specifications)
2. Add to folders:
   - Logo: `assets/images/logo.png`
   - Products: `assets/images/products/`
   - Other images: `assets/images/`

## 📝 Customize Content

### Update Company Information

**File: `config/config.php`**
```php
define('SITE_NAME', 'Kiihabwemi Development Company Ltd');
define('SITE_TAGLINE', 'Premium Coffee from the Heart of Uganda');
define('WHATSAPP_NUMBER', 'YOUR_NUMBER_HERE');
```

### Update Contact Details

**File: `includes/footer.php`**
- Update address
- Update phone numbers
- Update email addresses
- Update social media links

## 🛠️ Common Issues & Solutions

### Issue 1: "Database Connection Error"
**Solution:**
1. Check MySQL is running in XAMPP
2. Verify database name is `kdc_website`
3. Check credentials in `config/config.php`

### Issue 2: Pages Not Found (404)
**Solution:**
1. Ensure files are in `c:\xampp\htdocs\coffee_farm\`
2. Enable mod_rewrite in Apache
3. Check `.htaccess` file exists

### Issue 3: Images Not Showing
**Solution:**
1. Check image files exist in correct folders
2. Verify image names match database entries
3. Check file permissions

### Issue 4: Admin Login Fails
**Solution:**
1. Reset password in phpMyAdmin:
   ```sql
   UPDATE users 
   SET password_hash = '$argon2id$v=19$m=65536,t=4,p=1$...' 
   WHERE username = 'admin';
   ```
2. Or create new admin user via phpMyAdmin

## 📱 Test Features

### Test Shopping Cart
1. Go to Shop page
2. Click "Add to Cart" on any product
3. View cart (icon in navigation)
4. Try checkout via WhatsApp

### Test Contact Form
1. Go to Contact page
2. Fill out form
3. Submit
4. Check messages in admin panel

### Test Admin Panel
1. Login to admin
2. Check dashboard statistics
3. View products list
4. View messages

## 🔐 Change Admin Password

### Method 1: Via PHP
1. Create file `change_password.php` in root folder:
```php
<?php
$new_password = 'YourNewSecurePassword123!';
$hash = password_hash($new_password, PASSWORD_ARGON2ID);
echo "New hash: " . $hash;
// Copy this hash and update in database
?>
```
2. Visit: `http://localhost/coffee_farm/change_password.php`
3. Copy the hash
4. Update in phpMyAdmin → users table
5. Delete `change_password.php` file

### Method 2: Via phpMyAdmin
1. Open phpMyAdmin
2. Select `kdc_website` database
3. Click on `users` table
4. Click "Edit" on admin row
5. In `password_hash` field, paste new hash
6. Click "Go"

## 📦 Add Products

### Via phpMyAdmin
1. Open phpMyAdmin
2. Select `kdc_website` → `products` table
3. Click "Insert" tab
4. Fill in product details:
   - name: Product name
   - slug: product-name (lowercase, hyphens)
   - description: Product description
   - price: 25000 (UGX, no commas)
   - image: product-image.jpg
   - stock: 100
   - weight: 500g
5. Click "Go"

### Image Naming
- Use lowercase
- Replace spaces with hyphens
- Example: `premium-arabica-coffee.jpg`

## 🌐 For Production Deployment

See **DEPLOYMENT.md** for complete checklist.

Quick checklist:
1. Change database password
2. Update SITE_URL in config
3. Set DISPLAY_ERRORS to 0
4. Enable HTTPS
5. Change admin password
6. Add real images
7. Update contact information
8. Test all features
9. Create backups

## 📚 Additional Resources

- **Full Documentation:** README.md
- **Deployment Guide:** DEPLOYMENT.md
- **Image Guide:** IMAGES.md
- **Database Schema:** database.sql

## 💡 Tips

1. **Development:** Keep DISPLAY_ERRORS = 1 for debugging
2. **Production:** Set DISPLAY_ERRORS = 0 for security
3. **Backups:** Export database weekly
4. **Images:** Optimize before upload (<500KB)
5. **Testing:** Test on mobile devices

## 🆘 Need Help?

If you encounter issues:

1. Check error logs: `logs/error.log`
2. Check Apache error log: `c:\xampp\apache\logs\error.log`
3. Check MySQL log: `c:\xampp\mysql\data\*.err`
4. Review README.md troubleshooting section
5. Contact developer

## ✨ You're Ready!

Your KDC Coffee website is now set up and ready for customization!

**Next Steps:**
1. Add your product images
2. Update company information
3. Customize colors and branding
4. Add real product data
5. Test all functionality
6. Prepare for production deployment

---

**Happy Selling! ☕**

*Kiihabwemi Development Company Ltd - Premium Coffee from the Heart of Uganda*
