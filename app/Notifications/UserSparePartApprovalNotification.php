<?php

namespace App\Notifications;

use App\Models\SparePart;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSparePartApprovalNotification extends Notification
{
    use Queueable;

    public $sparePart;
    public $approvedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparePart $sparePart, User $approvedBy)
    {
        $this->sparePart = $sparePart;
        $this->approvedBy = $approvedBy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $locale = app()->getLocale();
        
        if ($locale === 'ar') {
            return (new MailMessage)
                ->subject('✅ تم قبول إعلان قطعة الغيار!')
                ->greeting('أهلاً وسهلاً ' . $notifiable->name . '! 🎉')
                ->line('تهانينا! تم قبول إعلان قطعة الغيار من قبل ' . $this->approvedBy->name . '.')
                ->line('🔧 تفاصيل قطعة الغيار المقبولة:')
                ->line('• الاسم: ' . $this->sparePart->name)
                ->line('• الوصف: ' . ($this->sparePart->description ?: 'لا يوجد وصف'))
                ->action('عرض إعلان قطعة الغيار', url('/spare-parts/' . $this->sparePart->id))
                ->line('🎯 الآن يمكن للعملاء رؤية قطعة الغيار والاتصال بك!')
                ->line('💡 نصيحة: تأكد من تحديث معلومات الاتصال لسهولة التواصل مع العملاء!')
                ->line('نتمنى لك التوفيق في البيع! 🚀');
        }

        return (new MailMessage)
            ->subject('✅ Your Spare Part Listing Has Been Approved!')
            ->greeting('Hello ' . $notifiable->name . '! 🎉')
            ->line('Congratulations! Your spare part listing has been approved by ' . $this->approvedBy->name . '.')
            ->line('🔧 Approved Spare Part Details:')
            ->line('• Name: ' . $this->sparePart->name)
            ->line('• Description: ' . ($this->sparePart->description ?: 'No description'))
            ->action('View Spare Part Listing', url('/spare-parts/' . $this->sparePart->id))
            ->line('🎯 Now customers can see your spare part and contact you!')
            ->line('💡 Tip: Make sure to update your contact information for easy communication with customers!')
            ->line('Good luck with your sale! 🚀');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'user_spare_part_approval',
            'spare_part_id' => $this->sparePart->id,
            'spare_part_name' => $this->sparePart->name,
            'spare_part_description' => $this->sparePart->description,
            'approved_by' => $this->approvedBy->name,
            'approved_by_id' => $this->approvedBy->id,
            'message_ar' => '✅ تهانينا! تم قبول إعلان قطعة الغيار "' . $this->sparePart->name . '" من قبل ' . $this->approvedBy->name,
            'message_en' => '✅ Congratulations! Your spare part listing "' . $this->sparePart->name . '" has been approved by ' . $this->approvedBy->name,
        ];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): array
    {
        return array_merge($this->toArray($notifiable), [
            'id' => $this->id,
            'type' => 'App\\Notifications\\UserSparePartApprovalNotification',
        ]);
    }
} 