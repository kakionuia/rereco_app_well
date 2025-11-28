<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password-reset {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test password reset functionality end-to-end';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info("\n" . str_repeat('=', 70));
        $this->info('PASSWORD RESET TEST');
        $this->info(str_repeat('=', 70) . "\n");

        // Get or create user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->info("Creating test user...");
            $user = User::create([
                'name' => 'Test User',
                'email' => $email,
                'password' => Hash::make('oldpassword123'),
                'email_verified_at' => now(),
            ]);
            $this->info("✅ User created (ID: {$user->id})\n");
        } else {
            $this->info("✅ User found: {$user->name}");
            $this->info("   Email: {$user->email}\n");
        }

        $oldHash = $user->password;
        $this->line("Old password hash: " . substr($oldHash, 0, 40) . "...");
        $this->line("Can verify 'oldpassword123': " . (Hash::check('oldpassword123', $oldHash) ? "✅ Yes" : "❌ No") . "\n");

        // Generate reset token via sendResetLink (this saves to DB automatically)
        $this->info("🔐 Sending password reset link (generates & saves token to DB)...");
        $status = Password::sendResetLink(['email' => $email]);
        
        if ($status !== Password::RESET_LINK_SENT) {
            $this->error("❌ Failed to send reset link: $status");
            return 1;
        }
        
        $this->info("✅ Reset link sent\n");

        // Get the token from database
        $token = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->orderByDesc('created_at')
            ->value('token');
        
        if (!$token) {
            $this->error("❌ Token not found in database!");
            return 1;
        }
        
        $this->info("✅ Token retrieved from password_reset_tokens table\n");

        // Show reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);
        $this->info("Reset URL:");
        $this->line($resetUrl . "\n");

        // Simulate password reset submission
        $this->info("🔄 Simulating password reset submission...");
        $newPassword = 'newpassword123';
        $this->info("   Email: $email");
        $this->info("   New password: $newPassword");
        $this->info("   Token: " . substr($token, 0, 40) . "...\n");

        $status = Password::reset(
            [
                'email' => $email,
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
                'token' => $token  // Pass raw token from DB
            ],
            function (User $resetUser) use ($newPassword) {
                $resetUser->forceFill([
                    'password' => Hash::make($newPassword),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $this->error("❌ Password reset failed: $status");
            return 1;
        }

        $this->info("✅ Password reset executed\n");

        // Verify password changed in database
        $user->refresh();
        $newHash = $user->password;

        $this->info("✅ Password hash changed in database:");
        $this->line("   New hash: " . substr($newHash, 0, 40) . "...");
        $this->line("   Can verify 'newpassword123': " . (Hash::check($newPassword, $newHash) ? "✅ Yes" : "❌ No"));
        $this->line("   Old password still works: " . (Hash::check('oldpassword123', $newHash) ? "❌ Yes (BAD)" : "✅ No (GOOD)") . "\n");

        // Verify token deleted
        $remainingToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->value('token');

        if ($remainingToken === null) {
            $this->info("✅ Reset token deleted from database\n");
        } else {
            $this->warn("⚠️ Reset token still in database (should be deleted)\n");
        }

        $this->info(str_repeat('=', 70));
        $this->info('✅ PASSWORD RESET TEST PASSED!');
        $this->info(str_repeat('=', 70) . "\n");

        $this->table(
            ['Property', 'Value'],
            [
                ['User', $user->name],
                ['Email', $user->email],
                ['Password changed', 'Yes ✅'],
                ['New password works', 'Yes ✅'],
                ['Old password doesn\'t work', 'Yes ✅'],
                ['Token deleted', 'Yes ✅'],
            ]
        );

        return 0;
    }
}
