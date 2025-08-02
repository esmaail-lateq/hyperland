<?php

namespace App\Notifications;

use App\Models\SparePart;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSparePartAddedNotification extends Notification
{
    use Queueable;

    public $sparePart;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparePart $sparePart)
    {
        $this->sparePart = $sparePart;
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
                ->subject('تم إضافة قطعة غيار جديدة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم إضافة قطعة غيار جديدة إلى المنصة.')
                ->line('🔧 تفاصيل قطعة الغيار الجديدة:')
                ->line('• الاسم: ' . $this->sparePart->name)
                ->line('• الوصف: ' . ($this->sparePart->description ?: 'لا يوجد وصف'))
                ->action('عرض قطعة الغيار الجديدة', url('/spare-parts/' . $this->sparePart->id))
                ->line('انقر للاطلاع على مزيد من التفاصيل');
        }

        return (new MailMessage)
            ->subject('New Spare Part Added')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new spare part has been added to the platform.')
            ->line('🔧 New Spare Part Details:')
            ->line('• Name: ' . $this->sparePart->name)
            ->line('• Description: ' . ($this->sparePart->description ?: 'No description'))
            ->action('View New Spare Part', url('/spare-parts/' . $this->sparePart->id))
            ->line('Click to view more details');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_spare_part_added',
            'spare_part_id' => $this->sparePart->id,
            'spare_part_name' => $this->sparePart->name,
            'spare_part_description' => $this->sparePart->description,
            'message_ar' => 'تم إضافة قطعة غيار جديدة ' . $this->sparePart->name . '، انقر للاطلاع على مزيد من التفاصيل',
            'message_en' => 'New spare part ' . $this->sparePart->name . ' has been added, click to view more details',
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
            'type' => 'App\\Notifications\\NewSparePartAddedNotification',
        ]);
    }
} 