<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing status values to new ones
        DB::statement("UPDATE cars SET status = 'available_in_yemen' WHERE status = 'approved'");
        DB::statement("UPDATE cars SET status = 'pending_approval' WHERE status = 'pending'");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        
        // Then change the enum values
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'pending_approval', 'rejected', 'sold') DEFAULT 'pending_approval'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the enum values
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'sold') DEFAULT 'pending'");
        
        // Revert the status values
        DB::statement("UPDATE cars SET status = 'approved' WHERE status = 'available_in_yemen'");
        DB::statement("UPDATE cars SET status = 'pending' WHERE status = 'pending_approval'");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
    }
};
