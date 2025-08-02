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
            // Remove dealer-related fields
            $table->dropColumn([
                'type',
                'dealer_name',
                'dealer_description',
                'dealer_address',
                'slug'
            ]);
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
