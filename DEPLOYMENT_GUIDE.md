# HOSTINGER PRODUCTION DEPLOYMENT GUIDE
## Kiihabwemi Development Company Ltd
**Domain:** https://kiihabwemidevtcompany.com

---

## PRE-DEPLOYMENT CHECKLIST

### 1. HOSTINGER ACCOUNT SETUP
- [ ] Purchase hosting plan (Business or Premium recommended)
- [ ] Domain purchased/transferred: kiihabwemidevtcompany.com
- [ ] SSL certificate activated (free with Hostinger)
- [ ] Access hPanel dashboard

### 2. DATABASE SETUP ON HOSTINGER
1. Login to hPanel
2. Go to **Databases → MySQL Databases**
3. Click **"Create New Database"**
4. Database details to note:
   - Database Name: `u[your_user_id]_kdc` (e.g., u123456789_kdc)
   - Database Username: `u[your_user_id]_kdc`
   - Database Password: **Create a strong password**
   - Hostname: `localhost`
   - Port: `3306`
5. **IMPORTANT:** Save these credentials for config.production.php

### 3. EMAIL SETUP ON HOSTINGER
1. Go to **Emails → Email Accounts**
2. Create the following email addresses:
   - `info@kiihabwemidevtcompany.com` (main contact)
   - `noreply@kiihabwemidevtcompany.com` (system emails)
   - `support@kiihabwemidevtcompany.com` (optional)
3. Note SMTP credentials:
   - SMTP Host: `smtp.hostinger.com`
   - SMTP Port: `587` (TLS) or `465` (SSL)
   - Username: Full email address
   - Password: Email password

---

## DEPLOYMENT STEPS

### STEP 1: PREPARE FILES LOCALLY

#### 1.1 Update Configuration File
1. Open `config/config.production.php`
2. Update the following with your Hostinger details:

```php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456789_kdc'); // Your actual DB name from Hostinger
define('DB_USER', 'u123456789_kdc'); // Your actual DB username
define('DB_PASS', 'YourSecurePassword123!'); // Your actual DB password

// SMTP Configuration
define('SMTP_USERNAME', 'noreply@kiihabwemidevtcompany.com');
define('SMTP_PASSWORD', 'YourEmailPassword123!');

// Google Analytics
define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX'); // Get from Google Analytics
define('GOOGLE_SITE_VERIFICATION', 'YOUR_CODE'); // Get from Google Search Console
```

#### 1.2 Rename Configuration File
- Rename `config/config.production.php` to `config/config.php`
- **OR** update all `require_once` statements to use `config.production.php`

#### 1.3 Create Logs Directory
```
coffee_farm/
├── logs/
│   └── .htaccess (Deny from all)
```

Create `logs/.htaccess`:
```apache
Order deny,allow
Deny from all
```

---

### STEP 2: UPLOAD FILES TO HOSTINGER

#### Method 1: Using File Manager (Recommended for beginners)
1. Login to hPanel
2. Go to **Files → File Manager**
3. Navigate to `public_html` directory
4. **DELETE** default files (index.html, etc.)
5. Upload ALL files from `coffee_farm` folder:
   - Click **Upload** button
   - Select all files and folders
   - Wait for upload to complete
6. Verify all folders are present:
   - `/assets`
   - `/config`
   - `/includes`
   - `/pages`
   - `/logs`
   - `.htaccess`
   - `index.php`
   - `robots.txt`
   - `sitemap.php`

#### Method 2: Using FTP (Recommended for advanced users)
1. Get FTP credentials from hPanel → **Files → FTP Accounts**
2. Use FileZilla or similar FTP client:
   - Host: `ftp.kiihabwemidevtcompany.com`
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: `21`
3. Connect and upload all files to `/public_html/`

---

### STEP 3: IMPORT DATABASE

#### 3.1 Export Database Locally
1. Open MySQL Workbench
2. Connect to local database (port 3308)
3. Server → Data Export
4. Select `kdc_website` database
5. Export to Self-Contained File: `kdc_database.sql`
6. Include:
   - Create schema
   - Tables
   - Data (if you have sample products)

#### 3.2 Import to Hostinger
1. Login to hPanel
2. Go to **Databases → phpMyAdmin**
3. Select your database (u123456789_kdc)
4. Click **Import** tab
5. Choose file: `kdc_database.sql`
6. Click **Go**
7. Wait for success message

#### 3.3 Verify Import
```sql
-- Check tables exist
SHOW TABLES;

-- Expected tables:
-- - products
-- - users  
-- - orders
-- - order_items
-- - messages
-- - settings
```

---

### STEP 4: CREATE ADMIN ACCOUNT

1. Go to phpMyAdmin on Hostinger
2. Select `users` table
3. Click **Insert** tab
4. Add admin user:

```sql
INSERT INTO users (
    username, 
    email, 
    password, 
    full_name, 
    role, 
    status,
    created_at
) VALUES (
    'admin',
    'admin@kiihabwemidevtcompany.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    'Administrator',
    'admin',
    'active',
    NOW()
);
```

**IMPORTANT:** Change password immediately after first login!

---

### STEP 5: FILE PERMISSIONS

Set correct permissions via File Manager:
```
Directories: 755
Files: 644
Logs directory: 777 (for writing)
assets/images/products/: 755 (for uploads)
```

In File Manager:
1. Right-click folder → **Permissions**
2. Set as above

---

### STEP 6: TEST THE WEBSITE

#### 6.1 Frontend Testing
Visit: https://kiihabwemidevtcompany.com

Test pages:
- [ ] Homepage loads correctly
- [ ] About page displays company info
- [ ] Shop page shows products
- [ ] Community page loads images
- [ ] Contact form works
- [ ] Product details page works
- [ ] Images display properly

#### 6.2 Admin Panel Testing
Visit: https://kiihabwemidevtcompany.com/pages/admin/login

Test functions:
- [ ] Login works
- [ ] Dashboard displays stats
- [ ] Can add products
- [ ] Can upload images
- [ ] Can view orders
- [ ] Can view messages

#### 6.3 Security Testing
- [ ] HTTPS works (green padlock)
- [ ] HTTP redirects to HTTPS
- [ ] Admin area requires login
- [ ] Config files not accessible via URL
- [ ] Database connection works

---

### STEP 7: SEO & ANALYTICS SETUP

#### 7.1 Google Search Console
1. Visit: https://search.google.com/search-console
2. Add property: `https://kiihabwemidevtcompany.com`
3. Verify ownership (HTML tag method recommended)
4. Copy verification code to `config/config.php`:
   ```php
   define('GOOGLE_SITE_VERIFICATION', 'paste_code_here');
   ```
5. Submit sitemap: `https://kiihabwemidevtcompany.com/sitemap.php`

#### 7.2 Google Analytics 4
1. Visit: https://analytics.google.com
2. Create new property for website
3. Get Measurement ID (format: G-XXXXXXXXXX)
4. Update in `config/config.php`:
   ```php
   define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX');
   ```
5. Update in `includes/header.php` (line 88)

#### 7.3 Google Business Profile
1. Create/claim: https://business.google.com
2. Add business info:
   - Name: Kiihabwemi Development Company Ltd
   - Address: Buhimba Town Council, Kikuube District
   - Phone: +256 779 767 250
   - Website: https://kiihabwemidevtcompany.com
   - Category: Agricultural Cooperative

---

### STEP 8: SOCIAL MEDIA INTEGRATION

#### 8.1 Create Social Media Pages
- [ ] Facebook Business Page
- [ ] Instagram Business Profile
- [ ] Twitter/X Account
- [ ] LinkedIn Company Page

#### 8.2 Update URLs in Config
Edit `config/config.php`:
```php
define('FACEBOOK_URL', 'https://facebook.com/kiihabwemi');
define('TWITTER_URL', 'https://twitter.com/kiihabwemi');
define('INSTAGRAM_URL', 'https://instagram.com/kiihabwemi');
define('LINKEDIN_URL', 'https://linkedin.com/company/kiihabwemi');
```

#### 8.3 Open Graph Image
1. Create OG image (1200x630px) with company logo and tagline
2. Upload to `/assets/images/og-image.jpg`
3. Test with: https://developers.facebook.com/tools/debug/

---

### STEP 9: PERFORMANCE OPTIMIZATION

#### 9.1 Enable Hostinger Cache
1. hPanel → **Advanced → Cache Manager**
2. Enable LiteSpeed Cache
3. Configure:
   - Cache TTL: 1 hour
   - Mobile cache: Enabled
   - Browser cache: Enabled

#### 9.2 Image Optimization
- Use WebP format when possible
- Compress images before upload
- Recommended tool: TinyPNG.com

#### 9.3 CDN (Optional)
- Hostinger includes Cloudflare CDN
- Enable in hPanel → **Advanced → Cloudflare**

---

### STEP 10: BACKUP SETUP

#### 10.1 Automatic Backups
- Hostinger Premium/Business includes daily backups
- Verify in hPanel → **Files → Backups**

#### 10.2 Manual Backup Schedule
Weekly backups:
1. Database export via phpMyAdmin
2. File backup via File Manager or FTP
3. Store locally and in cloud (Google Drive/Dropbox)

---

## POST-DEPLOYMENT TASKS

### Immediate (First 24 hours)
- [ ] Change default admin password
- [ ] Test contact form (send test message)
- [ ] Upload all product images
- [ ] Add 5-10 products to shop
- [ ] Test checkout process
- [ ] Verify SSL certificate
- [ ] Check mobile responsiveness

### Week 1
- [ ] Submit sitemap to Google Search Console
- [ ] Submit sitemap to Bing Webmaster Tools
- [ ] Set up Google Business Profile
- [ ] Create social media posts announcing launch
- [ ] Monitor error logs: `/logs/php_errors.log`
- [ ] Test email delivery

### Month 1
- [ ] Review Google Analytics data
- [ ] Check Search Console for crawl errors
- [ ] Update products with real inventory
- [ ] Add customer testimonials
- [ ] Start blog/news section (optional)
- [ ] SEO audit using Google PageSpeed Insights

---

## TROUBLESHOOTING

### Issue: 500 Internal Server Error
**Solution:**
1. Check `.htaccess` file syntax
2. Verify file permissions (644 for files, 755 for folders)
3. Check PHP error logs in hPanel

### Issue: Database Connection Failed
**Solution:**
1. Verify credentials in `config/config.php`
2. Ensure database exists in phpMyAdmin
3. Check DB_HOST is 'localhost'

### Issue: Images Not Uploading
**Solution:**
1. Set `/assets/images/products/` permission to 755
2. Check PHP upload limits in hPanel
3. Verify max file size (5MB)

### Issue: HTTPS Not Working
**Solution:**
1. Force SSL in hPanel → **Advanced → Force HTTPS**
2. Check .htaccess HTTPS redirect rules
3. Clear browser cache

### Issue: Emails Not Sending
**Solution:**
1. Verify SMTP credentials in config
2. Use Hostinger SMTP (smtp.hostinger.com:587)
3. Check spam folder
4. Enable "Less secure apps" if using Gmail

---

## MAINTENANCE SCHEDULE

### Daily
- Monitor sales/orders
- Respond to contact form messages
- Check product inventory

### Weekly
- Review analytics
- Backup database
- Check for security updates
- Test contact form

### Monthly
- Full website backup
- Review and update products
- Check for broken links
- Update content/prices
- Security audit

---

## SUPPORT CONTACTS

### Hostinger Support
- Live Chat: 24/7 in hPanel
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

### Developer Support
- Website issues: Document in detail with screenshots
- Emergency: Check error logs first

---

## SECURITY BEST PRACTICES

1. **Strong Passwords**
   - Admin: Minimum 12 characters
   - Database: Minimum 16 characters
   - Use password manager

2. **Regular Updates**
   - PHP version (check Hostinger compatibility)
   - Security patches
   - Dependencies

3. **Monitoring**
   - Enable Hostinger security features
   - Monitor login attempts
   - Check logs regularly

4. **Backups**
   - Automated: Daily (Hostinger)
   - Manual: Weekly
   - Test restore: Monthly

---

## LAUNCH ANNOUNCEMENT

Once deployed, announce on:
- [ ] Website homepage banner
- [ ] All social media platforms
- [ ] Email to existing customers
- [ ] Local business directories
- [ ] Google Business Profile post
- [ ] WhatsApp Business status

---

## FINAL CHECKLIST BEFORE GOING LIVE

- [ ] All pages load without errors
- [ ] Mobile responsive design verified
- [ ] HTTPS enabled and working
- [ ] Contact form tested and receiving emails
- [ ] Admin panel secured
- [ ] Products added with images
- [ ] Google Analytics tracking
- [ ] Search Console sitemap submitted
- [ ] Social media links working
- [ ] Favicon displays correctly
- [ ] Database backed up
- [ ] Admin password changed from default
- [ ] Error logging enabled
- [ ] 404 page working
- [ ] Robots.txt configured
- [ ] Privacy policy added (if required)
- [ ] Terms and conditions added (if required)

---

**DEPLOYMENT DATE:** _______________
**DEPLOYED BY:** _______________
**VERIFIED BY:** _______________

---

## Congratulations! 🎉
Your website is now live at: **https://kiihabwemidevtcompany.com**
