<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class TestResetPassword extends Command
{
    protected $signature = 'reset-test {email}';
    protected $description = 'Test password reset functionality';

    public function handle()
    {
        $email = $this->argument('email');

        // Get or create user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->info("Creating test user: $email");
            $user = User::create([
                'name' => 'Test User',
                'email' => $email,
                'password' => Hash::make('oldpassword123'),
                'email_verified_at' => now(),
            ]);
            $this->info("✅ User created with ID: {$user->id}");
        } else {
            $this->info("✅ User found: {$user->name}");
        }

        $oldHash = $user->password;
        $this->line("Old password hash: " . substr($oldHash, 0, 30) . "...\n");

        // Generate reset token
        $this->info("Generating password reset token...");
        $token = Password::createToken($user);
        $this->info("✅ Token generated\n");

        // Show reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);
        $this->info("Reset URL:");
        $this->line("<href=$resetUrl>$resetUrl</>");
        $this->line('');

        // Simulate password reset
        $newPassword = 'newpassword123';
        $this->info("Simulating password reset submission...");
        $this->info("New password: $newPassword\n");

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

        if ($status === Password::PASSWORD_RESET) {
            $this->info("✅ Password reset successful!");
        } else {
            $this->error("❌ Password reset failed: $status");
            return 1;
        }

        $this->line('');

        // Verify password in database
        $user->refresh();
        $newHash = $user->password;

        $this->info("Verifying password change in database...");
        if (Hash::check($newPassword, $newHash)) {
            $this->info("✅ New password verified in database!");
            $this->line("New password hash: " . substr($newHash, 0, 30) . "...\n");
        } else {
            $this->error("❌ Password verification failed!");
            return 1;
        }

        // Check token was deleted
        $remainingToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->value('token');

        if ($remainingToken === null) {
            $this->info("✅ Reset token was deleted from database");
        } else {
            $this->warn("⚠️ Reset token still in database (should be deleted)");
        }

        $this->line("\n" . str_repeat('=', 60));
        $this->info("PASSWORD RESET TEST COMPLETED SUCCESSFULLY!");
        $this->line(str_repeat('=', 60) . "\n");

        $this->table(
            ['Property', 'Value'],
            [
                ['User', $user->name],
                ['Email', $user->email],
                ['Old Hash', substr($oldHash, 0, 30) . '...'],
                ['New Hash', substr($newHash, 0, 30) . '...'],
                ['Password Changed', Hash::check($newPassword, $newHash) ? 'Yes ✅' : 'No ❌'],
                ['Token Deleted', $remainingToken === null ? 'Yes ✅' : 'No ❌'],
            ]
        );

        return 0;
    }
}
