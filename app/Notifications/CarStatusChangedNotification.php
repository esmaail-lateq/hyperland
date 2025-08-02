<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarStatusChangedNotification extends Notification
{
    use Queueable;

    public $car;
    public $newStatus;
    public $oldStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, string $newStatus, string $oldStatus = null)
    {
        $this->car = $car;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
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
                ->subject('تم تحديث حالة السيارة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم تحديث حالة السيارة الخاصة بك.')
                ->line('🚗 تفاصيل التحديث:')
                ->line('• السيارة: ' . $this->car->title)
                ->line('• الحالة الجديدة: ' . $this->getStatusDisplayName($this->newStatus))
                ->action('عرض تفاصيل السيارة', url('/cars/' . $this->car->id))
                ->line('انقر للاطلاع على مزيد من التفاصيل');
        }

        return (new MailMessage)
            ->subject('Car Status Updated')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your car status has been updated.')
            ->line('🚗 Update Details:')
            ->line('• Car: ' . $this->car->title)
            ->line('• New Status: ' . $this->getStatusDisplayName($this->newStatus))
            ->action('View Car Details', url('/cars/' . $this->car->id))
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
            'type' => 'car_status_changed',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'new_status' => $this->newStatus,
            'old_status' => $this->oldStatus,
            'new_status_display' => $this->getStatusDisplayName($this->newStatus),
            'message_ar' => 'تم تحديث حالة السيارة ' . $this->car->title . ' إلى ' . $this->getStatusDisplayName($this->newStatus) . '، انقر للاطلاع على مزيد من التفاصيل',
            'message_en' => 'Car status for ' . $this->car->title . ' has been updated to ' . $this->getStatusDisplayName($this->newStatus) . ', click to view more details',
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
            'type' => 'App\\Notifications\\CarStatusChangedNotification',
        ]);
    }

    /**
     * Get status display name.
     */
    private function getStatusDisplayName(string $status): string
    {
        $statusMap = [
            'available' => 'متوفر الآن',
            'at_customs' => 'متوفر الآن في المنافذ الجمركية',
            'in_transit' => 'قيد النقل',
            'purchased' => 'تم الشراء',
            'sold' => 'تم البيع'
        ];

        return $statusMap[$status] ?? $status;
    }
} 