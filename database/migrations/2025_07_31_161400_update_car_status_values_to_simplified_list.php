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
        
        // Update existing values to new simplified list
        DB::statement("UPDATE cars SET status = 'available' WHERE status = 'available_in_yemen'");
        DB::statement("UPDATE cars SET status = 'at_customs' WHERE status = 'available_at_customs'");
        DB::statement("UPDATE cars SET status = 'in_transit' WHERE status = 'shipping_to_yemen'");
        DB::statement("UPDATE cars SET status = 'purchased' WHERE status = 'recently_purchased'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        
        // Set default for any unknown statuses
        DB::statement("UPDATE cars SET status = 'available' WHERE status NOT IN ('available', 'at_customs', 'in_transit', 'purchased', 'sold')");
        
        // Now change back to ENUM with simplified list
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available', 'at_customs', 'in_transit', 'purchased', 'sold') DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous ENUM values
        DB::statement("ALTER TABLE cars MODIFY COLUMN status VARCHAR(50)");
        DB::statement("UPDATE cars SET status = 'available_in_yemen' WHERE status = 'available'");
        DB::statement("UPDATE cars SET status = 'available_at_customs' WHERE status = 'at_customs'");
        DB::statement("UPDATE cars SET status = 'shipping_to_yemen' WHERE status = 'in_transit'");
        DB::statement("UPDATE cars SET status = 'recently_purchased' WHERE status = 'purchased'");
        DB::statement("UPDATE cars SET status = 'sold' WHERE status = 'sold'");
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('pending_approval', 'available_in_yemen', 'available_at_customs', 'shipping_to_yemen', 'recently_purchased', 'admin_approved', 'rejected', 'sold') DEFAULT 'pending_approval'");
    }
}; 