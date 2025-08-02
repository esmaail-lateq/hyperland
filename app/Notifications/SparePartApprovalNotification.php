<?php

namespace App\Notifications;

use App\Models\SparePart;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SparePartApprovalNotification extends Notification
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
                ->subject('تم الموافقة على قطعة الغيار')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تهانينا! تم الموافقة على قطعة الغيار الخاصة بك من قبل ' . $this->approvedBy->name . '.')
                ->line('تفاصيل قطعة الغيار:')
                ->line('- الاسم: ' . $this->sparePart->name)
                ->line('- الوصف: ' . ($this->sparePart->description ?: 'لا يوجد وصف'))
                ->action('عرض قطعة الغيار', route('spare-parts.show', $this->sparePart))
                ->line('قطعة الغيار متاحة الآن للعرض في الموقع.');
        }

        return (new MailMessage)
            ->subject('Spare Part Approved')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Congratulations! Your spare part has been approved by ' . $this->approvedBy->name . '.')
            ->line('Spare part details:')
            ->line('- Name: ' . $this->sparePart->name)
            ->line('- Description: ' . ($this->sparePart->description ?: 'No description'))
            ->action('View Spare Part', route('spare-parts.show', $this->sparePart))
            ->line('The spare part is now available for viewing on the website.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'spare_part_approved',
            'spare_part_id' => $this->sparePart->id,
            'spare_part_name' => $this->sparePart->name,
            'spare_part_description' => $this->sparePart->description,
            'approved_by' => $this->approvedBy->name,
            'approved_by_id' => $this->approvedBy->id,
            'message_ar' => 'تم الموافقة على قطعة الغيار "' . $this->sparePart->name . '" من قبل ' . $this->approvedBy->name,
            'message_en' => 'Spare part "' . $this->sparePart->name . '" has been approved by ' . $this->approvedBy->name,
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
            'type' => 'App\\Notifications\\SparePartApprovalNotification',
        ]);
    }
}
