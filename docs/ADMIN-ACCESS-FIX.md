# 403 Forbidden Fix - Admin Access Control

## Problem
When accessing `/admin` dashboard on hosting, users received **403 Forbidden** error despite having `is_admin` set in the database.

## Root Cause
The `IsAdmin` middleware (`app/Http/Middleware/IsAdmin.php`) checks the `$user->is_admin` boolean column. The error occurs when:
1. The `is_admin` column doesn't exist (migration not run)
2. The `is_admin` column exists but is `false` (0) for the user

## Solution
Created `CheckAdmin` Artisan command to verify and fix admin status.

### Command Usage

**List all admin users:**
```bash
php artisan check:admin
```

**Check and promote a specific user:**
```bash
php artisan check:admin your-email@example.com
```

### How It Works
The command:
- ✅ Checks if user exists in database
- ✅ Shows current `is_admin` status
- ✅ Auto-promotes user to admin if they exist but `is_admin = 0`
- ✅ Lists all current admin users if no email provided

### Steps to Fix on Hosting

1. **Ensure migrations are run:**
   ```bash
   php artisan migrate
   ```
   This creates/updates the `is_admin` column in the users table.

2. **Promote admin user:**
   ```bash
   php artisan check:admin admin@example.com
   ```
   This will show their current status and auto-set to admin if needed.

3. **Verify admin access:**
   ```bash
   php artisan check:admin
   ```
   Should list the admin user(s).

4. **Test in browser:**
   Navigate to `/admin` — should load dashboard without 403 error.

## Testing (Local)

The following tests were performed successfully:

### Test 1: Create User & Verify Non-Admin Status
```bash
php artisan check:admin
# Output: ❌ No admin users found!
```

### Test 2: Promote User to Admin
```bash
php artisan check:admin leylahanafi4@gmail.com
# Output: ✅ User is now admin!
```

### Test 3: List Admin Users
```bash
php artisan check:admin
# Output: ✅ Admin Users (1): • Admin User (leylahanafi4@gmail.com)
```

### Test 4: Test Middleware
- Created test script `test-admin-middleware.php`
- Verified IsAdmin middleware allows access when `is_admin = 1`
- **Result: ✅ Access ALLOWED to /admin**

## Files Modified

- `app/Console/Commands/CheckAdmin.php` — New command for checking/fixing admin status
- Removed duplicate migration: `0001_01_01_000003_create_password_reset_tokens_table.php` (already in base migration)

## Important Notes

- The `is_admin` column **must exist** in users table (created by migration `2025_11_01_000000`)
- The `is_admin` column **must be 1 (true)** for user to access `/admin` routes
- If migration hasn't run on hosting, the column won't exist and admin users can't access dashboard
- Always run `php artisan migrate` before promoting users

## Troubleshooting

**Still getting 403 after promoting?**
1. Verify column exists: `SELECT is_admin FROM users WHERE email='your-email@example.com';`
2. Verify migration ran: `php artisan migrate:status` (check `2025_11_01_000000` is "Ran")
3. Clear Laravel cache: `php artisan cache:clear`
4. Logout and login again (refresh user session)

**User not found in check:admin?**
- The user account must exist in database before promotion
- Check user exists: `SELECT * FROM users WHERE email='your-email@example.com';`
- If missing, user must register first via `/register` route
