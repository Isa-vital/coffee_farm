# HOSTINGER PRODUCTION DEPLOYMENT GUIDE
## Kiihabwemi Development Company Ltd
**Domain:** https://kiihabwemidevtcompany.com


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
