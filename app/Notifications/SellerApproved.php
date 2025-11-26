<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $seller;

    /**
     * Create a new notification instance.
     */
    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Selamat! Akun Penjual Anda Telah Disetujui')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Selamat! Registrasi Anda sebagai penjual di platform kami telah disetujui.')
            ->line('**Informasi Toko:**')
            ->line('Nama Toko: ' . $this->seller->nama_toko)
            ->line('Email: ' . $notifiable->email)
            ->line('Status: Aktif')
            ->line('')
            ->line('Akun Anda sekarang sudah aktif dan Anda dapat mulai berjualan.')
            ->action('Login ke Dashboard', url('/login'))
            ->line('Terima kasih telah bergabung dengan kami!')
            ->salutation('Salam, Tim ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'seller_id' => $this->seller->id,
            'status' => 'approved',
        ];
    }
}
