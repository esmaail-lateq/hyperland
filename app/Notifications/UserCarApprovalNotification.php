<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCarApprovalNotification extends Notification
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
                ->subject('✅ تم قبول إعلان سيارتك!')
                ->greeting('أهلاً وسهلاً ' . $notifiable->name . '! 🎉')
                ->line('تهانينا! تم قبول إعلان سيارتك من قبل ' . $this->approvedBy->name . '.')
                ->line('🚗 تفاصيل السيارة المقبولة:')
                ->line('• العنوان: ' . $this->car->title)
                ->line('• الماركة: ' . $this->car->make)
                ->line('• الموديل: ' . $this->car->model)
                ->line('• السنة: ' . $this->car->year)
                ->line('• السعر: ' . number_format($this->car->price) . ' ريال')
                ->action('عرض إعلان السيارة', url('/cars/' . $this->car->id))
                ->line('🎯 الآن يمكن للعملاء رؤية سيارتك والاتصال بك!')
                ->line('💡 نصيحة: تأكد من الرد على استفسارات العملاء بسرعة لزيادة فرص البيع!')
                ->line('نتمنى لك التوفيق في البيع! 🚀');
        }

        return (new MailMessage)
            ->subject('✅ Your Car Listing Has Been Approved!')
            ->greeting('Hello ' . $notifiable->name . '! 🎉')
            ->line('Congratulations! Your car listing has been approved by ' . $this->approvedBy->name . '.')
            ->line('🚗 Approved Car Details:')
            ->line('• Title: ' . $this->car->title)
            ->line('• Brand: ' . $this->car->make)
            ->line('• Model: ' . $this->car->model)
            ->line('• Year: ' . $this->car->year)
            ->line('• Price: ' . number_format($this->car->price) . ' SAR')
            ->action('View Car Listing', url('/cars/' . $this->car->id))
            ->line('🎯 Now customers can see your car and contact you!')
            ->line('💡 Tip: Make sure to respond to customer inquiries quickly to increase sales chances!')
            ->line('Good luck with your sale! 🚀');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'user_car_approval',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'car_brand' => $this->car->make,
            'car_model' => $this->car->model,
            'car_year' => $this->car->year,
            'car_price' => $this->car->price,
            'approved_by' => $this->approvedBy->name,
            'approved_by_id' => $this->approvedBy->id,
            'message_ar' => '✅ تهانينا! تم قبول إعلان سيارتك "' . $this->car->title . '" من قبل ' . $this->approvedBy->name,
            'message_en' => '✅ Congratulations! Your car listing "' . $this->car->title . '" has been approved by ' . $this->approvedBy->name,
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
            'type' => 'App\\Notifications\\UserCarApprovalNotification',
        ]);
    }
} 