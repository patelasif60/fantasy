<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * @var token
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($emailDetails)
    {
        $email = str_replace('%40', '@', rawurlencode($emailDetails->email));

        $link = Str::finish(config('app.url'), '/').'password/reset/'.$this->token.'?email='.$email;

        return ( new MailMessage )
          ->subject('Fantasy League Password Reset')
          //->line('You are receiving this email because we received a password reset request for your account.')
          //->action('Reset Password', $link)
          //->line('If you did not request a password reset, no further action is required.');
          ->view('emails.auth.lost_password', compact('link', 'emailDetails'));
    }
}
