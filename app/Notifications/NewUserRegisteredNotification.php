<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class NewUserRegisteredNotification extends Notification implements ShouldQueue{

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $user
     * @return MailMessage
     */
    public function toMail(User $user): MailMessage {
        $token = $user->email_verification_token;
        $email = $user->email;
        return (new MailMessage)
            ->line('Thanks for registering! Please verify your email by clicking the button below.')
            ->action('Verify Your Email', url("http://127.0.0.1:8000/api/verify_email?email={$email}&token={$token}")) // TODO
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
