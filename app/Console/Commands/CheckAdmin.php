<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckAdmin extends Command
{
    protected $signature = 'check:admin {email?}';
    protected $description = 'Check admin status for a user or list all admins';

    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            // Check specific user
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("❌ User '$email' not found");
                return 1;
            }

            $isAdmin = $user->is_admin ?? false;
            
            $this->info("\nUser: {$user->name}");
            $this->info("Email: {$user->email}");
            $this->info("is_admin: " . ($isAdmin ? "✅ Yes (1)" : "❌ No (0)"));
            
            if (!$isAdmin) {
                $this->warn("\nThis user is NOT admin. Making them admin...");
                $user->is_admin = true;
                $user->save();
                $this->info("✅ User is now admin!");
            }
            
            return 0;
        } else {
            // List all admins
            $admins = User::where('is_admin', true)->get();
            
            if ($admins->isEmpty()) {
                $this->warn("❌ No admin users found!");
                $this->info("\nTo make a user admin, run:");
                $this->line("php artisan check:admin user@example.com");
                return 1;
            }

            $this->info("\n✅ Admin Users (" . $admins->count() . "):\n");
            
            foreach ($admins as $admin) {
                $this->line("• {$admin->name} ({$admin->email})");
            }

            return 0;
        }
    }
}
