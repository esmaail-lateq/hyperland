<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تحديث المستخدمين الحاليين
        $users = User::all();
        
        foreach ($users as $user) {
            // تحديد الدور الجديد بناءً على البيانات القديمة
            $newRole = 'public_user'; // افتراضي
            
            // إذا كان المستخدم admin في النظام القديم
            if (isset($user->is_admin) && $user->is_admin) {
                $newRole = 'admin';
            }
            // إذا كان المستخدم dealer في النظام القديم
            elseif (isset($user->type) && $user->type === 'dealer') {
                $newRole = 'sub_admin';
            }
            
            // تحديث المستخدم
            $user->update([
                'role' => $newRole,
                'status' => 'active'
            ]);
        }
        
        // إزالة الأعمدة القديمة
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('is_admin');
            });
        }
        
        if (Schema::hasColumn('users', 'type')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('type');
            });
        }
        
        if (Schema::hasColumn('users', 'dealer_name')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('dealer_name');
            });
        }
        
        if (Schema::hasColumn('users', 'dealer_description')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('dealer_description');
            });
        }
        
        if (Schema::hasColumn('users', 'dealer_address')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('dealer_address');
            });
        }
        
        $this->command->info('تم تحديث أدوار المستخدمين بنجاح!');
    }
} 