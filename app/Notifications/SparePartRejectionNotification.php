<?php

namespace App\Notifications;

use App\Models\SparePart;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SparePartRejectionNotification extends Notification
{
    use Queueable;

    public $sparePart;
    public $rejectedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparePart $sparePart, User $rejectedBy)
    {
        $this->sparePart = $sparePart;
        $this->rejectedBy = $rejectedBy;
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
                ->subject('تم رفض قطعة الغيار')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('نأسف لإبلاغك بأن قطعة الغيار الخاصة بك قد تم رفضها من قبل ' . $this->rejectedBy->name . '.')
                ->line('تفاصيل قطعة الغيار:')
                ->line('- الاسم: ' . $this->sparePart->name)
                ->line('- الوصف: ' . ($this->sparePart->description ?: 'لا يوجد وصف'))
                ->action('عرض قطعة الغيار', route('spare-parts.show', $this->sparePart))
                ->line('يرجى مراجعة تفاصيل قطعة الغيار والتأكد من اكتمال جميع المعلومات المطلوبة.');
        }

        return (new MailMessage)
            ->subject('Spare Part Rejected')
            ->greeting('Hello ' . $notifiable->name)
            ->line('We regret to inform you that your spare part has been rejected by ' . $this->rejectedBy->name . '.')
            ->line('Spare part details:')
            ->line('- Name: ' . $this->sparePart->name)
            ->line('- Description: ' . ($this->sparePart->description ?: 'No description'))
            ->action('View Spare Part', route('spare-parts.show', $this->sparePart))
            ->line('Please review the spare part details and ensure all required information is complete.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'spare_part_rejected',
            'spare_part_id' => $this->sparePart->id,
            'spare_part_name' => $this->sparePart->name,
            'spare_part_description' => $this->sparePart->description,
            'rejected_by' => $this->rejectedBy->name,
            'rejected_by_id' => $this->rejectedBy->id,
            'message_ar' => 'تم رفض قطعة الغيار "' . $this->sparePart->name . '" من قبل ' . $this->rejectedBy->name,
            'message_en' => 'Spare part "' . $this->sparePart->name . '" has been rejected by ' . $this->rejectedBy->name,
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
            'type' => 'App\\Notifications\\SparePartRejectionNotification',
        ]);
    }
}
