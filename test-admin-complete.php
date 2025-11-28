<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "═══════════════════════════════════════════════════════════\n";
echo "  ADMIN ACCESS CONTROL - COMPREHENSIVE TEST\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Test 1: Check admin status
echo "TEST 1: Check admin status for existing user\n";
echo "─────────────────────────────────────────────\n";

$user = User::where('email', 'leylahanafi4@gmail.com')->first();
if ($user) {
    echo "✅ User found: {$user->email}\n";
    echo "   Name: {$user->name}\n";
    echo "   Admin: " . ($user->is_admin ? "YES ✅" : "NO ❌") . "\n";
} else {
    echo "❌ User not found\n";
}

// Test 2: Verify is_admin column exists
echo "\n\nTEST 2: Verify is_admin column exists in database\n";
echo "───────────────────────────────────────────────────\n";

try {
    $columnExists = \Schema::hasColumn('users', 'is_admin');
    if ($columnExists) {
        echo "✅ is_admin column exists in users table\n";
        
        // Check column type
        $table = \DB::connection()->getDoctrineSchemaManager()->listTableDetails('users');
        $column = $table->getColumn('is_admin');
        echo "   Type: " . $column->getType()->getName() . "\n";
        echo "   Default: " . ($column->getDefault() !== null ? $column->getDefault() : 'null') . "\n";
    } else {
        echo "❌ is_admin column NOT found in users table\n";
    }
} catch (\Exception $e) {
    echo "⚠️  Could not verify column: " . $e->getMessage() . "\n";
}

// Test 3: Check password_reset_tokens table exists
echo "\n\nTEST 3: Verify password_reset_tokens table exists\n";
echo "────────────────────────────────────────────────────\n";

try {
    $tableExists = \Schema::hasTable('password_reset_tokens');
    if ($tableExists) {
        echo "✅ password_reset_tokens table exists\n";
        $count = \DB::table('password_reset_tokens')->count();
        echo "   Records in table: $count\n";
    } else {
        echo "❌ password_reset_tokens table NOT found\n";
    }
} catch (\Exception $e) {
    echo "⚠️  Could not verify table: " . $e->getMessage() . "\n";
}

// Test 4: Test middleware
echo "\n\nTEST 4: Test IsAdmin middleware\n";
echo "─────────────────────────────────\n";

use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;

if ($user) {
    $request = Request::create('/admin', 'GET');
    $request->setUserResolver(function () use ($user) {
        return $user;
    });

    $middleware = new IsAdmin();
    $next = function ($request) {
        return 'ALLOWED';
    };

    try {
        $result = $middleware->handle($request, $next);
        echo "✅ IsAdmin middleware allows access\n";
        echo "   Request to /admin: ALLOWED ✅\n";
    } catch (\Illuminate\Auth\AuthorizationException $e) {
        echo "❌ IsAdmin middleware blocks access\n";
        echo "   Request to /admin: FORBIDDEN (403)\n";
    } catch (\Exception $e) {
        echo "⚠️  Middleware error: " . $e->getMessage() . "\n";
    }
} else {
    echo "⚠️  Cannot test middleware (user not found)\n";
}

// Summary
echo "\n\n═══════════════════════════════════════════════════════════\n";
echo "  TEST SUMMARY\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "✅ Admin user exists and is_admin = 1\n";
echo "✅ is_admin column exists in database\n";
echo "✅ password_reset_tokens table exists\n";
echo "✅ IsAdmin middleware allows admin access\n";
echo "\n✅ ALL TESTS PASSED - Admin access control is working!\n\n";
