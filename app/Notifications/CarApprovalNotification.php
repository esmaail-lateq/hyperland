<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarApprovalNotification extends Notification
{
    use Queueable;

    public $car;
    public $approvedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, User $approvedBy)
    {
        $this->car = $car;
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
                ->subject('تم الموافقة على سيارتك')
                ->greeting('مرحباً ' . $notifiable->name)
                ->line('تم الموافقة على سيارتك من قبل ' . $this->approvedBy->name . '.')
                ->line('تفاصيل السيارة:')
                ->line('- العنوان: ' . $this->car->title)
                ->line('- الماركة: ' . $this->car->make)
                ->line('- الموديل: ' . $this->car->model)
                ->line('- السنة: ' . $this->car->year)
                ->line('- السعر: ' . number_format($this->car->price) . ' ريال')
                ->action('عرض السيارة', url('/cars/' . $this->car->id))
                ->line('يمكنك الآن عرض السيارة في الموقع.');
        }

        return (new MailMessage)
            ->subject('Your Car Has Been Approved')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your car has been approved by ' . $this->approvedBy->name . '.')
            ->line('Car details:')
            ->line('- Title: ' . $this->car->title)
            ->line('- Brand: ' . $this->car->make)
            ->line('- Model: ' . $this->car->model)
            ->line('- Year: ' . $this->car->year)
            ->line('- Price: ' . number_format($this->car->price) . ' SAR')
            ->action('View Car', url('/cars/' . $this->car->id))
            ->line('You can now view the car on the website.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'car_approval',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'car_price' => $this->car->price,
            'approved_by' => $this->approvedBy->name,
            'approved_by_id' => $this->approvedBy->id,
            'message_ar' => 'تمت الموافقة على السيارة "' . $this->car->title . '" من قبل ' . $this->approvedBy->name,
            'message_en' => 'Car "' . $this->car->title . '" has been approved by ' . $this->approvedBy->name,
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
            'type' => 'App\\Notifications\\CarApprovalNotification',
        ]);
    }
}
