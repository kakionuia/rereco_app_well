<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Create test user
$user = User::firstOrCreate(
    ['email' => 'leylahanafi4@gmail.com'],
    [
        'name' => 'Admin User',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
        'is_admin' => true,
    ]
);

echo "User created/found: " . $user->email . " (Admin: " . ($user->is_admin ? 'YES' : 'NO') . ")\n";
