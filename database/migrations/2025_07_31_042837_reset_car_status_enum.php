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
        // First, temporarily change the column to VARCHAR to avoid enum constraints
        DB::statement("ALTER TABLE cars MODIFY COLUMN status VARCHAR(50)");
        
        // Update existing status values to new ones
        DB::statement("UPDATE cars SET status = 'available_in_yemen' WHERE status = 'approved'");
        DB::statement("UPDATE cars SET status = 'pending_approval' WHERE status = 'pending'");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        
        // Set any unknown statuses to pending_approval
        DB::statement("UPDATE cars SET status = 'pending_approval' WHERE status NOT IN ('available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'pending_approval', 'admin_approved', 'rejected', 'sold')");
        
        // Now change to the new enum with all statuses including admin_approved
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'pending_approval', 'admin_approved', 'rejected', 'sold') DEFAULT 'pending_approval'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the original enum values
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'sold') DEFAULT 'pending'");
        
        // Revert the status values
        DB::statement("UPDATE cars SET status = 'approved' WHERE status = 'available_in_yemen'");
        DB::statement("UPDATE cars SET status = 'pending' WHERE status = 'pending_approval'");
        DB::statement("UPDATE cars SET status = 'rejected' WHERE status = 'rejected'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
    }
};
