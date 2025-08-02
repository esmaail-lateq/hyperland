<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarRejectionNotification extends Notification
{
    use Queueable;

    public $car;
    public $rejectedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, User $rejectedBy)
    {
        $this->car = $car;
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
                ->subject('تم رفض إعلان السيارة')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('نأسف لإبلاغك بأن إعلان السيارة الخاص بك قد تم رفضه من قبل ' . $this->rejectedBy->name . '.')
                ->line('تفاصيل السيارة:')
                ->line('- العنوان: ' . $this->car->title)
                ->line('- الماركة: ' . $this->car->make)
                ->line('- الموديل: ' . $this->car->model)
                ->line('- السنة: ' . $this->car->year)
                ->action('عرض السيارة', route('cars.show', $this->car))
                ->line('يرجى مراجعة تفاصيل السيارة والتأكد من اكتمال جميع المعلومات المطلوبة.');
        }

        return (new MailMessage)
            ->subject('Car Listing Rejected')
            ->greeting('Hello ' . $notifiable->name)
            ->line('We regret to inform you that your car listing has been rejected by ' . $this->rejectedBy->name . '.')
            ->line('Car details:')
            ->line('- Title: ' . $this->car->title)
            ->line('- Brand: ' . $this->car->make)
            ->line('- Model: ' . $this->car->model)
            ->line('- Year: ' . $this->car->year)
            ->action('View Car', route('cars.show', $this->car))
            ->line('Please review the car details and ensure all required information is complete.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'car_rejected',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'rejected_by' => $this->rejectedBy->name,
            'rejected_by_id' => $this->rejectedBy->id,
            'message_ar' => 'تم رفض إعلان السيارة "' . $this->car->title . '" من قبل ' . $this->rejectedBy->name,
            'message_en' => 'Car listing "' . $this->car->title . '" has been rejected by ' . $this->rejectedBy->name,
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
            'type' => 'App\\Notifications\\CarRejectionNotification',
        ]);
    }
}
