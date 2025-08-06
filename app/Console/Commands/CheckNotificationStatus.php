<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\NotificationRateLimiter;

class CheckNotificationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:check-status {--user-id= : Check status for specific user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check notification rate limiting status for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found");
                return 1;
            }
            $users = collect([$user]);
        } else {
            $users = User::where('status', 'active')->whereNotNull('email_verified_at')->get();
        }
        
        $this->info("Checking notification status for " . $users->count() . " users");
        $this->newLine();
        
        $headers = ['User ID', 'Name', 'Role', 'Email', 'Car Status Changed', 'Car Sold', 'New Car', 'New Spare Part'];
        $rows = [];
        
        foreach ($users as $user) {
            $row = [
                $user->id,
                $user->name,
                $user->role,
                $user->email,
                $this->getNotificationStatus($user, 'car_status_changed'),
                $this->getNotificationStatus($user, 'car_sold'),
                $this->getNotificationStatus($user, 'new_car_added'),
                $this->getNotificationStatus($user, 'new_spare_part'),
            ];
            $rows[] = $row;
        }
        
        $this->table($headers, $rows);
        
        return 0;
    }
    
    private function getNotificationStatus($user, $type)
    {
        $currentCount = NotificationRateLimiter::getCurrentCount($user, $type);
        $remainingCount = NotificationRateLimiter::getRemainingCount($user, $type);
        $canSend = NotificationRateLimiter::canSendNotification($user, $type);
        
        if ($canSend) {
            return "{$currentCount}/{$remainingCount} (OK)";
        } else {
            return "{$currentCount}/{$remainingCount} (LIMIT)";
        }
    }
} 