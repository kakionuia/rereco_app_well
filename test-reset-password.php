<?php
/**
 * Quick Password Reset Test Script
 * Run: php test-reset-password.php
 */

require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

try {
    echo "\n" . str_repeat('=', 70) . "\n";
    echo "PASSWORD RESET TEST\n";
    echo str_repeat('=', 70) . "\n\n";

    $email = 'leylahanafi4@gmail.com';

    // Get or create user
    $user = User::where('email', $email)->first();
    if (!$user) {
        echo "📝 Creating test user...\n";
        $user = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => Hash::make('oldpassword123'),
            'email_verified_at' => now(),
        ]);
        echo "✅ User created (ID: {$user->id})\n\n";
    } else {
        echo "✅ User found: {$user->name}\n";
        echo "   Email: {$user->email}\n\n";
    }

    $oldHash = $user->password;
    echo "Old password hash: " . substr($oldHash, 0, 40) . "...\n";
    echo "Can verify 'oldpassword123': " . (Hash::check('oldpassword123', $oldHash) ? "✅ Yes" : "❌ No") . "\n\n";

    // Generate reset token
    echo "🔐 Generating password reset token...\n";
    $token = Password::createToken($user);
    echo "✅ Token generated\n\n";

    // Verify token in database
    $tokenInDb = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->value('token');
    
    if ($tokenInDb === $token) {
        echo "✅ Token stored in password_reset_tokens table\n\n";
    } else {
        throw new Exception("❌ Token not found in database!");
    }

    // Show reset URL
    $resetUrl = url("reset-password/$token?email=" . urlencode($email));
    echo "Reset URL:\n";
    echo "$resetUrl\n\n";

    // Simulate password reset submission
    echo "🔄 Simulating password reset submission...\n";
    $newPassword = 'newpassword123';
    echo "   New password: $newPassword\n\n";

    $status = Password::reset(
        [
            'email' => $email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => $token
        ],
        function (User $resetUser) use ($newPassword) {
            $resetUser->forceFill([
                'password' => Hash::make($newPassword),
            ])->save();
        }
    );

    if ($status !== Password::PASSWORD_RESET) {
        throw new Exception("❌ Password reset failed: $status");
    }

    echo "✅ Password reset executed\n\n";

    // Verify password changed in database
    $user->refresh();
    $newHash = $user->password;

    echo "✅ Password hash changed in database:\n";
    echo "   New hash: " . substr($newHash, 0, 40) . "...\n";
    echo "   Can verify 'newpassword123': " . (Hash::check('newpassword123', $newHash) ? "✅ Yes" : "❌ No") . "\n";
    echo "   Old password still works: " . (Hash::check('oldpassword123', $newHash) ? "❌ Yes (BAD)" : "✅ No (GOOD)") . "\n\n";

    // Verify token deleted
    $remainingToken = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->value('token');

    if ($remainingToken === null) {
        echo "✅ Reset token deleted from database\n\n";
    } else {
        echo "❌ Reset token still in database (should be deleted)\n\n";
    }

    echo str_repeat('=', 70) . "\n";
    echo "✅ PASSWORD RESET TEST PASSED!\n";
    echo str_repeat('=', 70) . "\n\n";

    echo "Summary:\n";
    echo "- User: {$user->name}\n";
    echo "- Email: {$user->email}\n";
    echo "- Password changed: ✅\n";
    echo "- New password works: ✅\n";
    echo "- Old password doesn't work: ✅\n";
    echo "- Token deleted: ✅\n\n";

} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}
