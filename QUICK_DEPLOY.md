# QUICK DEPLOYMENT CHECKLIST
## Kiihabwemi Development Company Ltd → Hostinger
**Domain:** https://kiihabwemidevtcompany.com

---

## PHASE 1: HOSTINGER SETUP (30 minutes)

### Database Setup
- [ ] Login to hPanel (https://hpanel.hostinger.com)
- [ ] Go to: **Databases → MySQL Databases**
- [ ] Create database (note the name: `u[userid]_kdc`)
- [ ] **SAVE CREDENTIALS:**
  - DB Name: ________________
  - DB User: ________________
  - DB Pass: ________________

### Email Setup
- [ ] Go to: **Emails → Email Accounts**
- [ ] Create: `info@kiihabwemidevtcompany.com`
- [ ] Create: `noreply@kiihabwemidevtcompany.com`
- [ ] **SAVE SMTP PASSWORD:** ________________

### SSL Certificate
- [ ] Go to: **Security → SSL**
- [ ] Verify SSL is active (should be automatic)
- [ ] Enable "Force HTTPS"

---

## PHASE 2: FILE PREPARATION (15 minutes)

### Update Configuration
- [ ] Open: `config/config.production.php`
- [ ] Update DB_NAME with your database name
- [ ] Update DB_USER with your database username
- [ ] Update DB_PASS with your database password
- [ ] Update SMTP_USERNAME with noreply email
- [ ] Update SMTP_PASSWORD with email password
- [ ] Save file

### Rename Config (Choose ONE method)
**Method A:** Rename file
- [ ] Rename `config.production.php` to `config.php`
- [ ] Backup original `config.php` as `config.local.php`

**Method B:** Update includes (advanced)
- [ ] Keep both config files
- [ ] Update all `require_once` to use `config.production.php`

---

## PHASE 3: UPLOAD FILES (20 minutes)

### Via File Manager
- [ ] Login to hPanel
- [ ] Go to: **Files → File Manager**
- [ ] Navigate to `public_html`
- [ ] **DELETE** all default files (index.html, etc.)
- [ ] Click **Upload**
- [ ] Upload ALL files from `coffee_farm` folder
- [ ] Wait for upload to complete
- [ ] Verify folders exist:
  - [ ] /assets
  - [ ] /config
  - [ ] /includes
  - [ ] /pages
  - [ ] /logs
  - [ ] Files: index.php, .htaccess, robots.txt, sitemap.php

### Set Permissions
- [ ] Right-click `/logs` → Permissions → 777
- [ ] Right-click `/assets/images/products` → Permissions → 755
- [ ] All other directories: 755
- [ ] All files: 644

---

## PHASE 4: DATABASE IMPORT (10 minutes)

### Export from Local (MySQL Workbench)
- [ ] Open MySQL Workbench
- [ ] Connect to port 3308
- [ ] Server → Data Export
- [ ] Select: `kdc_website`
- [ ] Export to: `database_export.sql`
- [ ] Start Export

### Import to Hostinger
- [ ] hPanel → **Databases → phpMyAdmin**
- [ ] Select your database (u[userid]_kdc)
- [ ] Click **Import** tab
- [ ] Choose file: `database_export.sql` (or `database_structure.sql`)
- [ ] Click **Go**
- [ ] **WAIT** for "Import successful" message

### Verify Import
- [ ] Click database name in left sidebar
- [ ] Verify 6 tables exist:
  - [ ] products
  - [ ] users
  - [ ] orders
  - [ ] order_items
  - [ ] messages
  - [ ] settings

---

## PHASE 5: TESTING (15 minutes)

### Frontend Tests
Visit: https://kiihabwemidevtcompany.com

- [ ] Homepage loads (no errors)
- [ ] HTTPS works (green padlock)
- [ ] Navigation menu works
- [ ] About page displays
- [ ] Shop page displays
- [ ] Community page displays
- [ ] Contact page displays
- [ ] Images load correctly
- [ ] Mobile responsive works

### Admin Panel Tests
Visit: https://kiihabwemidevtcompany.com/pages/admin/login

- [ ] Admin login page loads
- [ ] Login with credentials:
  - Username: `admin`
  - Password: (from database or change it)
- [ ] Dashboard loads
- [ ] Can view products
- [ ] Can add new product
- [ ] Image upload works
- [ ] Can view messages
- [ ] **CHANGE ADMIN PASSWORD IMMEDIATELY**

### Contact Form Test
- [ ] Go to Contact page
- [ ] Submit test message
- [ ] Check admin panel → Messages
- [ ] Verify message appears

---

## PHASE 6: SEO SETUP (20 minutes)

### Google Search Console
- [ ] Visit: https://search.google.com/search-console
- [ ] Add property: `https://kiihabwemidevtcompany.com`
- [ ] Choose verification method: HTML tag
- [ ] Copy verification code
- [ ] Add to `config/config.php`:
  ```php
  define('GOOGLE_SITE_VERIFICATION', 'paste_here');
  ```
- [ ] Click Verify
- [ ] Submit sitemap: `https://kiihabwemidevtcompany.com/sitemap.php`

### Google Analytics
- [ ] Visit: https://analytics.google.com
- [ ] Create property: Kiihabwemi Development Company Ltd
- [ ] Get Measurement ID (G-XXXXXXXXXX)
- [ ] Update in `config/config.php`:
  ```php
  define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX');
  ```
- [ ] Test tracking (visit site, check real-time)

### Test Sitemap
- [ ] Visit: https://kiihabwemidevtcompany.com/sitemap.php
- [ ] Verify XML displays correctly
- [ ] Check products are listed

---

## PHASE 7: FINAL CHECKS (10 minutes)

### Security
- [ ] Try accessing: https://kiihabwemidevtcompany.com/config/config.php
  - Should show: Access Denied or 403
- [ ] Try accessing: https://kiihabwemidevtcompany.com/includes/db_connect.php
  - Should show: Access Denied or 403
- [ ] Verify HTTP redirects to HTTPS
- [ ] Test admin logout/login

### Performance
- [ ] Test page load speed: https://pagespeed.web.dev
- [ ] Enter: https://kiihabwemidevtcompany.com
- [ ] Aim for 80+ score
- [ ] Fix any critical issues shown

### Mobile
- [ ] Test on mobile phone
- [ ] Check WhatsApp link works
- [ ] Test navigation menu
- [ ] Test product images

---

## PHASE 8: CONTENT POPULATION

### Products
- [ ] Add 5-10 products minimum
- [ ] Include:
  - Clear product names
  - Accurate descriptions
  - High-quality images (compressed)
  - Correct prices in UGX
  - Stock quantities
- [ ] Mark featured products (2-3)

### Images
- [ ] Upload hero images
- [ ] Upload product images (WebP format recommended)
- [ ] Upload about page images
- [ ] Upload community page images
- [ ] Verify all images display correctly

---

## PHASE 9: LAUNCH ANNOUNCEMENT

### Social Media Setup
- [ ] Create Facebook Business Page
- [ ] Create Instagram Business Profile
- [ ] Create Twitter/X account
- [ ] Update URLs in `config/config.php`

### Announcement Posts
- [ ] Prepare launch post with website link
- [ ] Share on Facebook
- [ ] Share on Instagram
- [ ] Share on Twitter
- [ ] WhatsApp Business status
- [ ] Local business groups

### Google Business
- [ ] Create/claim Google Business Profile
- [ ] Add business info
- [ ] Add website link
- [ ] Upload photos
- [ ] Post announcement

---

## POST-LAUNCH (First Week)

### Daily
- [ ] Check for new orders
- [ ] Respond to messages
- [ ] Monitor analytics

### End of Week 1
- [ ] Review Google Analytics
- [ ] Check Search Console for errors
- [ ] Test all forms again
- [ ] Backup database
- [ ] Update any content issues

---

## TROUBLESHOOTING QUICK FIXES

**500 Error:**
1. Check .htaccess file
2. Set file permissions: 644
3. Check PHP error log in hPanel

**Database Connection Failed:**
1. Verify config.php credentials
2. Check DB_HOST = 'localhost'
3. Test in phpMyAdmin

**Images Not Showing:**
1. Check file paths in code
2. Verify image upload permissions (755)
3. Re-upload images via FTP

**Contact Form Not Working:**
1. Check SMTP settings
2. Verify email exists in Hostinger
3. Check spam folder

**SSL/HTTPS Issues:**
1. Clear browser cache
2. Enable Force HTTPS in hPanel
3. Wait 10 minutes for SSL to activate

---

## SUPPORT RESOURCES

**Hostinger Support:**
- Live Chat: 24/7 in hPanel
- Knowledge Base: support.hostinger.com

**Website Issues:**
- Check PHP error logs: hPanel → Files → Error Log
- Check Apache error logs: hPanel → Advanced → Error Log

---

## ✅ DEPLOYMENT COMPLETE!

**Live Website:** https://kiihabwemidevtcompany.com

**Admin Panel:** https://kiihabwemidevtcompany.com/pages/admin/login

**Next Steps:**
1. Monitor for first 48 hours
2. Gather customer feedback
3. Optimize based on analytics
4. Regular content updates

---

**Deployed:** ___ / ___ / 2025

**Status:** ☐ Testing  ☐ Live  ☐ Issue

**Notes:**
_________________________________________________
_________________________________________________
_________________________________________________
