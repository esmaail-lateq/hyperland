<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove dealer-related fields (only if they exist)
            if (Schema::hasColumn('users', 'dealer_name')) {
                $table->dropColumn('dealer_name');
            }
            if (Schema::hasColumn('users', 'dealer_description')) {
                $table->dropColumn('dealer_description');
            }
            if (Schema::hasColumn('users', 'dealer_address')) {
                $table->dropColumn('dealer_address');
            }
            if (Schema::hasColumn('users', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back dealer-related fields
            $table->enum('type', ['user', 'dealer'])->default('user')->after('password');
            $table->string('dealer_name')->nullable()->after('avatar');
            $table->text('dealer_description')->nullable()->after('dealer_name');
            $table->string('dealer_address')->nullable()->after('dealer_description');
            $table->string('slug')->nullable()->unique()->after('dealer_address');
        });
    }
};
