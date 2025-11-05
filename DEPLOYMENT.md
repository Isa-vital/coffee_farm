# KDC Coffee Website - Deployment Checklist

## ✅ Pre-Deployment Checklist

### 1. Database Setup
- [ ] Import `database.sql` into MySQL/MariaDB
- [ ] Verify all tables are created successfully
- [ ] Update database credentials in `config/config.php`
- [ ] Create non-root database user with appropriate permissions
- [ ] Test database connection

### 2. Configuration
- [ ] Update `SITE_URL` in `config/config.php` to production URL
- [ ] Change `WHATSAPP_NUMBER` to actual business number
- [ ] Set `DISPLAY_ERRORS` to `0` in `config/config.php`
- [ ] Update `SESSION_TIMEOUT` if needed
- [ ] Configure error logging path

### 3. Security
- [ ] Change default admin username and password
- [ ] Generate strong password (16+ characters)
- [ ] Enable HTTPS (SSL certificate installed)
- [ ] Update `.htaccess` to force HTTPS (uncomment lines)
- [ ] Set `session.cookie_secure` to `1` in config
- [ ] Review file permissions (644 for files, 755 for directories)
- [ ] Remove or protect `database.sql` file
- [ ] Ensure `config/` is not web-accessible

### 4. File Permissions (Linux/Mac)
```bash
chmod 644 config/config.php
chmod 644 .htaccess
chmod 755 assets/images/products/
chmod 755 logs/
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

### 5. Images
- [ ] Add company logo to `assets/images/logo.png`
- [ ] Add favicon `assets/images/favicon.png`
- [ ] Upload all product images to `assets/images/products/`
- [ ] Optimize all images (compress to <500KB each)
- [ ] Verify all image paths in code are correct
- [ ] Add Open Graph image `assets/images/og-image.jpg`

### 6. Content Updates
- [ ] Update company contact email addresses
- [ ] Update phone number in footer and contact page
- [ ] Update social media links in footer
- [ ] Update Google Maps embed coordinates in contact.php
- [ ] Review and update all page content
- [ ] Add actual product data to database

### 7. SEO Configuration
- [ ] Get Google Analytics 4 measurement ID
- [ ] Update GA4 tracking code in `includes/header.php`
- [ ] Get Google Search Console verification code
- [ ] Update verification meta tag in `includes/header.php`
- [ ] Update `sitemap.xml` with production URL
- [ ] Submit sitemap to Google Search Console
- [ ] Submit sitemap to Bing Webmaster Tools
- [ ] Verify robots.txt is accessible

### 8. Performance
- [ ] Enable Apache modules: mod_deflate, mod_expires, mod_headers
- [ ] Test GZIP compression is working
- [ ] Verify browser caching headers
- [ ] Run Google PageSpeed Insights test
- [ ] Optimize and minify CSS/JS files (optional)
- [ ] Enable CDN for static assets (optional)

### 9. Testing
- [ ] Test all navigation links
- [ ] Test all forms (contact form, admin login)
- [ ] Test shopping cart functionality
- [ ] Test WhatsApp checkout links
- [ ] Test on mobile devices (responsive design)
- [ ] Test on different browsers (Chrome, Firefox, Safari, Edge)
- [ ] Test admin panel access and features
- [ ] Verify email validation works
- [ ] Test 404 error page (create if needed)
- [ ] Check for broken images or links

### 10. Backup
- [ ] Create database backup
- [ ] Create full file system backup
- [ ] Document backup procedures
- [ ] Set up automated backup schedule
- [ ] Test restore procedure

### 11. Monitoring
- [ ] Set up uptime monitoring (UptimeRobot, etc.)
- [ ] Configure error log monitoring
- [ ] Set up Google Analytics
- [ ] Configure Google Search Console
- [ ] Set up website health checks

### 12. Documentation
- [ ] Update README.md with production details
- [ ] Document admin procedures
- [ ] Create user guide for admin panel
- [ ] Document backup and restore procedures
- [ ] Document troubleshooting steps

## 🚀 Deployment Steps

### For Shared Hosting (cPanel/Plesk)

1. **Upload Files**
   ```
   - Use FTP/SFTP or File Manager
   - Upload all files to public_html or www directory
   - Maintain directory structure
   ```

2. **Create Database**
   ```
   - Use phpMyAdmin or MySQL Database Wizard
   - Create database: kdc_website
   - Create database user with all privileges
   - Import database.sql
   ```

3. **Update Configuration**
   ```
   - Edit config/config.php with production details
   - Update SITE_URL
   - Update database credentials
   ```

4. **Test Website**
   ```
   - Visit homepage
   - Test all functionality
   - Check error logs
   ```

### For VPS/Dedicated Server

1. **Install LAMP Stack**
   ```bash
   # Ubuntu/Debian
   sudo apt update
   sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql
   
   # Enable required modules
   sudo a2enmod rewrite
   sudo a2enmod headers
   sudo a2enmod expires
   sudo systemctl restart apache2
   ```

2. **Configure Apache**
   ```bash
   # Edit virtual host configuration
   sudo nano /etc/apache2/sites-available/kdc-coffee.conf
   
   # Enable site
   sudo a2ensite kdc-coffee
   sudo systemctl reload apache2
   ```

3. **Setup SSL**
   ```bash
   # Using Let's Encrypt
   sudo apt install certbot python3-certbot-apache
   sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
   ```

4. **Clone Repository**
   ```bash
   cd /var/www/
   git clone <repository-url> kdc-coffee
   cd kdc-coffee
   ```

5. **Import Database**
   ```bash
   mysql -u root -p
   CREATE DATABASE kdc_website;
   exit;
   mysql -u root -p kdc_website < database.sql
   ```

## 📋 Post-Deployment

### Immediately After Launch
- [ ] Verify website is accessible
- [ ] Test all critical functions
- [ ] Monitor error logs for first 24 hours
- [ ] Check Google Analytics tracking
- [ ] Test contact form email delivery
- [ ] Verify WhatsApp links work

### First Week
- [ ] Monitor website performance
- [ ] Check for any errors or issues
- [ ] Review analytics data
- [ ] Optimize based on user behavior
- [ ] Gather user feedback

### Ongoing Maintenance
- [ ] Weekly: Review error logs
- [ ] Weekly: Check for security updates
- [ ] Monthly: Database optimization
- [ ] Monthly: Backup verification
- [ ] Quarterly: Content updates
- [ ] Quarterly: Security audit

## 🔒 Security Best Practices

### Regular Tasks
- [ ] Update PHP and MySQL regularly
- [ ] Monitor security advisories
- [ ] Review access logs for suspicious activity
- [ ] Change admin passwords quarterly
- [ ] Keep backups offsite
- [ ] Test restore procedures monthly

### Hardening
- [ ] Disable PHP functions: exec, shell_exec, system
- [ ] Hide PHP version in headers
- [ ] Implement rate limiting for login attempts
- [ ] Use strong session security
- [ ] Enable Web Application Firewall (WAF)
- [ ] Implement Content Security Policy (CSP)

## 📞 Emergency Contacts

**Technical Issues:**
- Web Host Support: [Your hosting support contact]
- Developer: [Your contact]
- Database Admin: [DBA contact]

**Business Issues:**
- KDC Management: info@kdc-coffee.com
- WhatsApp: +256700000000

## 🔄 Rollback Plan

If deployment fails:

1. **Database Rollback**
   ```bash
   mysql -u root -p kdc_website < backup_YYYYMMDD.sql
   ```

2. **Files Rollback**
   ```bash
   # Restore from backup
   tar -xzf backup_files_YYYYMMDD.tar.gz
   ```

3. **DNS Rollback**
   - Point DNS back to old server
   - Wait for TTL to expire (usually 1-24 hours)

## ✨ Success Criteria

Deployment is successful when:
- [ ] All pages load without errors
- [ ] Shopping cart works correctly
- [ ] WhatsApp checkout functions properly
- [ ] Contact form submits successfully
- [ ] Admin panel is accessible and functional
- [ ] Website loads in <3 seconds
- [ ] Mobile responsive design works
- [ ] SSL certificate is valid
- [ ] No console errors in browser
- [ ] Google Analytics is tracking

## 📝 Notes

- Keep this checklist updated with each deployment
- Document any issues encountered during deployment
- Update procedures based on lessons learned

---

**Last Updated:** November 3, 2025  
**Version:** 1.0.0  
**Deployed By:** _____________  
**Deployment Date:** _____________
