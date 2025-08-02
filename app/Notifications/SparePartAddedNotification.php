<?php

namespace App\Notifications;

use App\Models\SparePart;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SparePartAddedNotification extends Notification
{
    use Queueable;

    public $sparePart;
    public $addedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparePart $sparePart, User $addedBy)
    {
        $this->sparePart = $sparePart;
        $this->addedBy = $addedBy;
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
                ->subject('تم إضافة قطعة غيار جديدة تحتاج للمراجعة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم إضافة قطعة غيار جديدة من قبل ' . $this->addedBy->name . ' وتحتاج لمراجعتك.')
                ->line('تفاصيل قطعة الغيار:')
                ->line('- الاسم: ' . $this->sparePart->name)
                ->line('- الوصف: ' . ($this->sparePart->description ?: 'لا يوجد وصف'))
                ->action('مراجعة قطع الغيار', url('/unified-cars'))
                ->line('يرجى مراجعة قطعة الغيار والموافقة عليها أو رفضها.');
        }

        return (new MailMessage)
            ->subject('New Spare Part Added - Requires Review')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new spare part has been added by ' . $this->addedBy->name . ' and requires your review.')
            ->line('Spare part details:')
            ->line('- Name: ' . $this->sparePart->name)
            ->line('- Description: ' . ($this->sparePart->description ?: 'No description'))
            ->action('Review Spare Parts', url('/unified-cars'))
            ->line('Please review the spare part and approve or reject it.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'spare_part_added',
            'spare_part_id' => $this->sparePart->id,
            'spare_part_name' => $this->sparePart->name,
            'spare_part_description' => $this->sparePart->description,
            'added_by' => $this->addedBy->name,
            'added_by_id' => $this->addedBy->id,
            'message_ar' => 'تم إضافة قطعة غيار جديدة "' . $this->sparePart->name . '" من قبل ' . $this->addedBy->name,
            'message_en' => 'New spare part "' . $this->sparePart->name . '" has been added by ' . $this->addedBy->name,
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
            'type' => 'App\\Notifications\\SparePartAddedNotification',
        ]);
    }
} 