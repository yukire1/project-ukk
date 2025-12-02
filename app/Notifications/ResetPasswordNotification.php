<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Password - Project Desa')
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
            ->line('**Kode Verifikasi Anda:**')
            ->line('')
            ->line('┌─────────────────────────────────┐')
            ->line('│  ' . strtoupper($this->token) . '  │')
            ->line('└─────────────────────────────────┘')
            ->line('')
            ->line('Kode ini berlaku selama 60 menit.')
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.')
            ->action('Atau Klik Link Ini', url('/verify-reset-token?email=' . urlencode($notifiable->email)))
            ->line('Hormat kami,')
            ->line('Tim Project Desa');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}