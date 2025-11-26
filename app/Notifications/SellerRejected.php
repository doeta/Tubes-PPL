<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public $seller;
    public $rejectionReason;

    /**
     * Create a new notification instance.
     */
    public function __construct($seller, $rejectionReason)
    {
        $this->seller = $seller;
        $this->rejectionReason = $rejectionReason;
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
            ->subject('Informasi Penolakan Registrasi Penjual')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Terima kasih telah mendaftar sebagai penjual di platform kami.')
            ->line('Mohon maaf, kami harus memberitahukan bahwa registrasi Anda **belum dapat disetujui** saat ini.')
            ->line('')
            ->line('**Alasan Penolakan:**')
            ->line($this->rejectionReason)
            ->line('')
            ->line('**Informasi Toko yang Didaftarkan:**')
            ->line('Nama Toko: ' . $this->seller->nama_toko)
            ->line('Email: ' . $notifiable->email)
            ->line('')
            ->line('Anda dapat mendaftar kembali setelah melengkapi persyaratan yang disebutkan di atas.')
            ->action('Daftar Kembali', url('/register-seller'))
            ->line('Jika ada pertanyaan, silakan hubungi tim support kami.')
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
            'status' => 'rejected',
            'reason' => $this->rejectionReason,
        ];
    }
}
