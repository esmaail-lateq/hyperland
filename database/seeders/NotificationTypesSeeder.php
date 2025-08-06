<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationTypes = [
            [
                'name' => 'car_added',
                'display_name_ar' => 'إضافة سيارة جديدة',
                'display_name_en' => 'New Car Added',
                'description_ar' => 'إشعار عند إضافة سيارة جديدة تحتاج للمراجعة',
                'description_en' => 'Notification when a new car is added and needs review',
            ],
            [
                'name' => 'car_approval',
                'display_name_ar' => 'موافقة على السيارة',
                'display_name_en' => 'Car Approval',
                'description_ar' => 'إشعار عند الموافقة على السيارة',
                'description_en' => 'Notification when a car is approved',
            ],
            [
                'name' => 'car_rejection',
                'display_name_ar' => 'رفض السيارة',
                'display_name_en' => 'Car Rejection',
                'description_ar' => 'إشعار عند رفض السيارة',
                'description_en' => 'Notification when a car is rejected',
            ],
            [
                'name' => 'car_sold',
                'display_name_ar' => 'بيع السيارة',
                'display_name_en' => 'Car Sold',
                'description_ar' => 'إشعار عند بيع السيارة',
                'description_en' => 'Notification when a car is sold',
            ],
            [
                'name' => 'spare_part_added',
                'display_name_ar' => 'إضافة قطع غيار',
                'display_name_en' => 'Spare Part Added',
                'description_ar' => 'إشعار عند إضافة قطع غيار جديدة',
                'description_en' => 'Notification when new spare parts are added',
            ],
            [
                'name' => 'spare_part_approval',
                'display_name_ar' => 'موافقة على قطع الغيار',
                'display_name_en' => 'Spare Part Approval',
                'description_ar' => 'إشعار عند الموافقة على قطع الغيار',
                'description_en' => 'Notification when spare parts are approved',
            ],
            [
                'name' => 'spare_part_rejection',
                'display_name_ar' => 'رفض قطع الغيار',
                'display_name_en' => 'Spare Part Rejection',
                'description_ar' => 'إشعار عند رفض قطع الغيار',
                'description_en' => 'Notification when spare parts are rejected',
            ],
        ];

        foreach ($notificationTypes as $type) {
            \App\Models\NotificationType::updateOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
