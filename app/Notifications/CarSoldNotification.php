<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarSoldNotification extends Notification
{
    use Queueable;

    public $car;
    public $soldBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car, User $soldBy)
    {
        $this->car = $car;
        $this->soldBy = $soldBy;
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
                ->subject('🎉 تم بيع سيارتك بنجاح!')
                ->greeting('تهانينا ' . $notifiable->name . '! 🎊')
                ->line('مبروك! تم بيع سيارتك بنجاح من قبل ' . $this->soldBy->name . '.')
                ->line('🚗 تفاصيل السيارة المباعة:')
                ->line('• العنوان: ' . $this->car->title)
                ->line('• الماركة: ' . $this->car->make)
                ->line('• الموديل: ' . $this->car->model)
                ->line('• السنة: ' . $this->car->year)
                ->line('• السعر: ' . number_format($this->car->price) . ' ريال')
                ->action('عرض تفاصيل البيع', url('/cars/' . $this->car->id))
                ->line('💡 نصيحة: يمكنك إضافة سيارات أخرى للبيع للحصول على المزيد من الأرباح!')
                ->line('شكراً لثقتك في منصتنا 🚀');
        }

        return (new MailMessage)
            ->subject('🎉 Your Car Has Been Sold Successfully!')
            ->greeting('Congratulations ' . $notifiable->name . '! 🎊')
            ->line('Great news! Your car has been sold successfully by ' . $this->soldBy->name . '.')
            ->line('🚗 Sold Car Details:')
            ->line('• Title: ' . $this->car->title)
            ->line('• Brand: ' . $this->car->make)
            ->line('• Model: ' . $this->car->model)
            ->line('• Year: ' . $this->car->year)
            ->line('• Price: ' . number_format($this->car->price) . ' SAR')
            ->action('View Sale Details', url('/cars/' . $this->car->id))
            ->line('💡 Tip: You can add more cars for sale to earn more profits!')
            ->line('Thank you for trusting our platform 🚀');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'car_sold',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'car_price' => $this->car->price,
            'sold_by' => $this->soldBy->name,
            'sold_by_id' => $this->soldBy->id,
            'message_ar' => 'تم بيع السيارة ' . $this->car->title . ' من قبل ' . $this->soldBy->name . '، انقر للاطلاع على مزيد من التفاصيل',
            'message_en' => 'Car ' . $this->car->title . ' has been sold by ' . $this->soldBy->name . ', click to view more details',
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
            'type' => 'App\\Notifications\\CarSoldNotification',
        ]);
    }
} 