# Fix Team Page 500 Error on Production

## Problem
The team page is showing HTTP ERROR 500 because:
1. The `team_members` table was just created
2. Production is still using local database credentials (port 3308, localhost)

## Solution Steps

### Step 1: Update Production Config
Go to Hostinger hPanel → File Manager → `public_html/config/`

**Option A (Recommended):**
1. Rename `config.php` to `config.local.php` (backup)
2. Rename `config.production.php` to `config.php`
3. Edit the new `config.php` and update these values:
   ```php
   define('DB_NAME', 'u497172593_kdc'); // Your actual database name
   define('DB_USER', 'u497172593_kdc'); // Your actual database username
   define('DB_PASS', 'your_actual_password'); // Your actual database password
   ```

**Option B (Quick Fix):**
Edit `config.php` directly and change:
```php
// FROM:
define('DB_HOST', 'localhost');
define('DB_PORT', '3308');
define('DB_NAME', 'kdc_website');
define('DB_USER', 'root');
define('DB_PASS', 'Today123');

// TO:
define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); // Standard MySQL port
define('DB_NAME', 'u497172593_kdc'); // Your Hostinger database name
define('DB_USER', 'u497172593_kdc'); // Your Hostinger database username
define('DB_PASS', 'your_actual_password'); // Your Hostinger database password
```

Also update:
```php
define('SITE_URL', 'https://kiihabwemidevtcompany.com'); // Remove http://localhost
```

### Step 2: Verify Database Table
The `team_members` table is now created in your production database. Verify by:
1. Go to hPanel → Databases → phpMyAdmin
2. Select your database
3. Check if `team_members` table exists
4. Run: `DESCRIBE team_members;` to confirm structure

### Step 3: Test the Pages
After updating config:
1. Visit: https://kiihabwemidevtcompany.com/pages/team.php (public page - should show empty but no error)
2. Visit: https://kiihabwemidevtcompany.com/pages/admin/team.php (admin page - after login)

### Step 4: Add Team Members
Once the pages load without errors:
1. Login to admin panel
2. Click "Team Members" in sidebar
3. Add your team members with photos

## Expected Result
- Team page loads without 500 error
- Shows empty state if no members added yet
- Admin panel allows adding/editing team members
