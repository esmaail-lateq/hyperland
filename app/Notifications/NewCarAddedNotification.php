<?php

namespace App\Notifications;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCarAddedNotification extends Notification
{
    use Queueable;

    public $car;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
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
                ->subject('تم إضافة سيارة جديدة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم إضافة سيارة جديدة إلى المنصة.')
                ->line('🚗 تفاصيل السيارة الجديدة:')
                ->line('• السيارة: ' . $this->car->title)
                ->line('• الماركة: ' . $this->car->make)
                ->line('• الموديل: ' . $this->car->model)
                ->line('• السنة: ' . $this->car->year)
                ->line('• السعر: ' . number_format($this->car->price) . ' ريال')
                ->action('عرض السيارة الجديدة', url('/cars/' . $this->car->id))
                ->line('انقر للاطلاع على مزيد من التفاصيل');
        }

        return (new MailMessage)
            ->subject('New Car Added')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new car has been added to the platform.')
            ->line('🚗 New Car Details:')
            ->line('• Car: ' . $this->car->title)
            ->line('• Brand: ' . $this->car->make)
            ->line('• Model: ' . $this->car->model)
            ->line('• Year: ' . $this->car->year)
            ->line('• Price: ' . number_format($this->car->price) . ' SAR')
            ->action('View New Car', url('/cars/' . $this->car->id))
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
            'type' => 'new_car_added',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'car_price' => $this->car->price,
            'message_ar' => 'تم إضافة سيارة جديدة ' . $this->car->title . '، انقر للاطلاع على مزيد من التفاصيل',
            'message_en' => 'New car ' . $this->car->title . ' has been added, click to view more details',
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
            'type' => 'App\\Notifications\\NewCarAddedNotification',
        ]);
    }
} 