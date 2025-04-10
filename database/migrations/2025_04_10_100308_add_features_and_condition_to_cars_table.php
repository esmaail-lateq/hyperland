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
        Schema::table('cars', function (Blueprint $table) {
            // Features
            $table->boolean('has_air_conditioning')->default(false);
            $table->boolean('has_leather_seats')->default(false);
            $table->boolean('has_navigation')->default(false);
            $table->boolean('has_parking_sensors')->default(false);
            $table->boolean('has_parking_camera')->default(false);
            $table->boolean('has_heated_seats')->default(false);
            $table->boolean('has_bluetooth')->default(false);
            $table->boolean('has_led_lights')->default(false);
            
            // Condition
            $table->enum('condition', ['new', 'used', 'for_parts'])->default('used');
            $table->integer('owners_count')->nullable();
            $table->boolean('has_service_history')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Features
            $table->dropColumn('has_air_conditioning');
            $table->dropColumn('has_leather_seats');
            $table->dropColumn('has_navigation');
            $table->dropColumn('has_parking_sensors');
            $table->dropColumn('has_parking_camera');
            $table->dropColumn('has_heated_seats');
            $table->dropColumn('has_bluetooth');
            $table->dropColumn('has_led_lights');
            
            // Condition
            $table->dropColumn('condition');
            $table->dropColumn('owners_count');
            $table->dropColumn('has_service_history');
        });
    }
};
