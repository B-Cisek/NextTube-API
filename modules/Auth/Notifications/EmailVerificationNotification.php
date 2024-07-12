<?php

namespace Modules\Auth\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;

class EmailVerificationNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $frontendUrl = Config::get('auth.frontend_url');
        $backendUrl = Config::get('app.url') . '/api';
        $verificationUrl = str_replace($backendUrl, $frontendUrl, $this->verificationUrl($notifiable));

        return (new MailMessage)
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email Address', $verificationUrl)
                    ->line('If you did not create an account, no further action is required.');
    }
}
