# Deployment Checklist - Admin Access & File Storage

## Status: ✅ READY FOR PRODUCTION

All features tested and working on local environment. Follow these steps to deploy on shared hosting.

---

## 1. DATABASE MIGRATIONS (CRITICAL)

Run on hosting:
```bash
cd /home/username/public_html
php artisan migrate
```

**What gets created:**
- ✅ `users` table with `is_admin` boolean column
- ✅ `password_reset_tokens` table for password reset functionality
- ✅ All other application tables

**To verify:**
```bash
php artisan migrate:status
# Should show all migrations as "Ran"
```

---

## 2. ADMIN USER ACCESS

After migrations run, promote admin users:

```bash
# List all admin users
php artisan check:admin

# Promote specific user to admin
php artisan check:admin your-admin-email@example.com
```

**Expected output:**
```
User: Your Admin Name
Email: your-admin-email@example.com
is_admin: ❌ No (0)

This user is NOT admin. Making them admin...
✅ User is now admin!
```

**Verify admin can access dashboard:**
- Login to site with admin account
- Navigate to `/admin` route
- Should load admin dashboard without 403 error

---

## 3. FILE STORAGE (IMAGE UPLOADS)

### Option A: Using symlink (recommended)

```bash
# Via cPanel Terminal or SSH
cd /home/username/public_html
ln -s /home/username/storage/app/public storage
```

### Option B: Copy storage folder

1. Upload `storage_public.zip` (3.4 MB) to `/home/username/public_html` via cPanel File Manager
2. Extract to `storage/` directory
3. Verify files appear at `/admin/products`, `/profile` pages with images

**Test image loading:**
- Upload review photo
- Upload product image
- Upload profile photo
- Verify images display on product/profile pages

---

## 4. EMAIL CONFIGURATION

Update `.env` on hosting:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="App Name"
```

**Important:** 
- Use Gmail app-specific password, NOT account password
- Enable 2-factor auth on Gmail account first
- Generate app password at: https://myaccount.google.com/apppasswords

**Test email sending:**
```bash
php artisan mail:test your-email@example.com
```

---

## 5. PASSWORD RESET

Test password reset flow:

1. Navigate to `/forgot-password`
2. Enter admin email address
3. Check email for reset link
4. Click link and reset password
5. Login with new password

**Verify it works:**
- Token should be stored in `password_reset_tokens` table
- Password should be hashed and saved in `users` table
- Old password should not work anymore

---

## 6. VITE BUILD ASSETS

If using Vite for frontend assets:

```bash
# On local development
npm run build

# Upload generated public/build folder to hosting
# Or set up CI/CD pipeline to auto-build
```

**Verify:**
- CSS/JS files load in production
- No 404 errors for assets
- Styles and scripts work correctly

---

## 7. CACHE & OPTIMIZATION

Clear caches after deployment:

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
```

---

## 8. ENVIRONMENT & SECURITY

**Verify on hosting:**

```bash
# 1. Check .env is loaded
php artisan config:get MAIL_MAILER
# Should output: smtp

# 2. Check database connection
php artisan tinker --execute="echo DB::connection()->getDatabaseName();"

# 3. Verify storage permissions
# public/storage directory should be writable
# storage/logs should be writable
```

**Security checklist:**
- ✅ `.env` file is NOT in public_html
- ✅ `.env` is in Git .gitignore
- ✅ `storage/` and `bootstrap/cache/` are writable
- ✅ Production mode enabled: `APP_ENV=production`
- ✅ Debug mode disabled: `APP_DEBUG=false`

---

## QUICK REFERENCE: Key Commands

```bash
# Run migrations
php artisan migrate

# Check/promote admin
php artisan check:admin your-email@example.com

# List all admins
php artisan check:admin

# Clear caches
php artisan cache:clear && php artisan view:clear

# Test mail
php artisan mail:test your-email@example.com

# Check status
php artisan migrate:status
php artisan tinker
```

---

## TROUBLESHOOTING

### Problem: "403 Forbidden" on `/admin`
**Solution:** Run `php artisan check:admin your-admin-email@example.com`

### Problem: Images not showing after upload
**Solution:** Create symlink: `ln -s /path/to/storage/app/public /path/to/public_html/storage`

### Problem: Emails not sending
**Solution:** 
1. Verify `.env` Gmail credentials
2. Check Gmail app-specific password (not account password)
3. Run `php artisan mail:test your-email@example.com`

### Problem: Password reset link not working
**Solution:**
1. Run `php artisan migrate` to ensure `password_reset_tokens` table exists
2. Check email was sent successfully
3. Verify link contains token parameter: `/reset-password?token=xxx`

### Problem: Can't run artisan commands on hosting
**Solution:**
1. Contact hosting support to enable SSH/Terminal access
2. Use cPanel Terminal or SSH client
3. Verify PHP version: `php -v` (should be 8.1+)

---

## DEPLOYMENT SUMMARY

✅ **To deploy:**
1. Run: `php artisan migrate`
2. Run: `php artisan check:admin admin@example.com`
3. Create symlink or upload storage files
4. Configure `.env` for Gmail SMTP
5. Test: admin access, image uploads, password reset

✅ **Expected results:**
- Admin dashboard loads at `/admin`
- Images display on product/profile pages
- Password reset emails arrive and work
- All user features functional

---

**Date:** November 28, 2025  
**Status:** ✅ All tests passed, ready for production deployment
