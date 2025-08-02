<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarAddedNotification extends Notification
{
    use Queueable;

    public $car;
    public $addedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, User $addedBy)
    {
        $this->car = $car;
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
                ->subject('تم إضافة سيارة جديدة تحتاج للمراجعة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم إضافة سيارة جديدة من قبل ' . $this->addedBy->name . ' وتحتاج لمراجعتك.')
                ->line('تفاصيل السيارة:')
                ->line('- العنوان: ' . $this->car->title)
                ->line('- الماركة: ' . $this->car->make)
                ->line('- الموديل: ' . $this->car->model)
                ->line('- السنة: ' . $this->car->year)
                ->line('- السعر: ' . number_format($this->car->price) . ' ريال')
                ->action('مراجعة السيارة', url('/unified-cars'))
                ->line('يرجى مراجعة السيارة والموافقة عليها أو رفضها.');
        }

        return (new MailMessage)
            ->subject('New Car Added - Requires Review')
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new car has been added by ' . $this->addedBy->name . ' and requires your review.')
            ->line('Car details:')
            ->line('- Title: ' . $this->car->title)
            ->line('- Brand: ' . $this->car->make)
            ->line('- Model: ' . $this->car->model)
            ->line('- Year: ' . $this->car->year)
            ->line('- Price: ' . number_format($this->car->price) . ' SAR')
            ->action('Review Car', url('/unified-cars'))
            ->line('Please review the car and approve or reject it.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'car_added',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'car_price' => $this->car->price,
            'added_by' => $this->addedBy->name,
            'added_by_id' => $this->addedBy->id,
            'message_ar' => 'تم إضافة سيارة جديدة "' . $this->car->title . '" من قبل ' . $this->addedBy->name,
            'message_en' => 'New car "' . $this->car->title . '" has been added by ' . $this->addedBy->name,
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
            'type' => 'App\\Notifications\\CarAddedNotification',
        ]);
    }
} 