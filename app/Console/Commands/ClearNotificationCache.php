<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class ClearNotificationCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:clear-cache {--user-id= : Clear cache for specific user} {--type= : Clear cache for specific notification type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear notification rate limiting cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        $type = $this->option('type');
        
        $config = config('notifications');
        $prefix = $config['cache_prefix'] ?? 'notification_rate_limit';
        
        if ($userId) {
            // Clear cache for specific user
            if ($type) {
                $key = "{$prefix}:{$userId}:{$type}";
                Cache::forget($key);
                $this->info("Cleared cache for user {$userId}, type {$type}");
            } else {
                // Clear all types for this user
                $types = array_keys($config['rate_limit'] ?? []);
                foreach ($types as $notificationType) {
                    $key = "{$prefix}:{$userId}:{$notificationType}";
                    Cache::forget($key);
                }
                $this->info("Cleared all notification cache for user {$userId}");
            }
        } else {
            // Clear all notification cache
            $types = array_keys($config['rate_limit'] ?? []);
            $users = User::all();
            
            $bar = $this->output->createProgressBar($users->count() * count($types));
            $bar->start();
            
            foreach ($users as $user) {
                foreach ($types as $notificationType) {
                    $key = "{$prefix}:{$user->id}:{$notificationType}";
                    Cache::forget($key);
                    $bar->advance();
                }
            }
            
            $bar->finish();
            $this->newLine();
            $this->info("Cleared all notification cache for all users");
        }
        
        return 0;
    }
} 