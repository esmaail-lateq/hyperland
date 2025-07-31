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
        // First, change the column to VARCHAR to avoid ENUM constraints
        DB::statement("ALTER TABLE cars MODIFY COLUMN status VARCHAR(50)");
        
        // Update existing values to new expanded list
        DB::statement("UPDATE cars SET status = 'pending_approval' WHERE status = 'pending_approval'");
        DB::statement("UPDATE cars SET status = 'available_in_yemen' WHERE status = 'available_in_yemen'");
        DB::statement("UPDATE cars SET status = 'available_at_customs' WHERE status = 'available_at_customs'");
        DB::statement("UPDATE cars SET status = 'shipping_to_yemen' WHERE status = 'shipping_to_yemen'");
        DB::statement("UPDATE cars SET status = 'recently_purchased' WHERE status = 'recently_purchased'");
        DB::statement("UPDATE cars SET status = 'admin_approved' WHERE status = 'admin_approved'");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        
        // Set default for any unknown statuses
        DB::statement("UPDATE cars SET status = 'pending_approval' WHERE status NOT IN ('pending_approval', 'available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'admin_approved', 'rejected', 'sold')");
        
        // Now change back to ENUM with expanded list
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('pending_approval', 'available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'admin_approved', 'rejected', 'sold') DEFAULT 'pending_approval'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous ENUM values
        DB::statement("ALTER TABLE cars MODIFY COLUMN status VARCHAR(50)");
        DB::statement("UPDATE cars SET status = 'pending' WHERE status = 'pending_approval'");
        DB::statement("UPDATE cars SET status = 'approved' WHERE status IN ('available_in_yemen', 'admin_approved')");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'sold') DEFAULT 'pending'");
    }
}; 