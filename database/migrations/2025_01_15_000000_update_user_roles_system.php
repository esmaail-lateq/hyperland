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
            // إزالة العمود type القديم
            $table->dropColumn('type');
            
            // إضافة عمود role الجديد
            $table->enum('role', ['admin', 'sub_admin', 'public_user'])->default('public_user')->after('email');
            
            // إضافة عمود status للمستخدم
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إعادة العمود type
            $table->enum('type', ['user', 'dealer'])->default('user')->after('email');
            
            // إزالة الأعمدة الجديدة
            $table->dropColumn(['role', 'status']);
        });
    }
}; 