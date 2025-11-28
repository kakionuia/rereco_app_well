<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;

// Get the admin user
$user = User::where('email', 'leylahanafi4@gmail.com')->first();

if (!$user) {
    echo "User not found\n";
    exit(1);
}

echo "Testing IsAdmin middleware...\n";
echo "User: " . $user->email . "\n";
echo "Is Admin: " . ($user->is_admin ? 'YES' : 'NO') . "\n";

// Create a mock request with the user authenticated
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
    echo "Middleware Result: $result\n";
    echo "✅ Access ALLOWED to /admin\n";
} catch (\Exception $e) {
    echo "❌ Middleware rejected access: " . $e->getMessage() . "\n";
}
