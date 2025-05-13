<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PembayaranStatusNotifikasi extends Notification
{
    private $paymentDetails;

    public function __construct($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    public function via($notifiable)
    {
        return ['database']; // Menyimpan notifikasi di database
    }

    public function toDatabase($notifiable)
    {
        return [
            'jumlah_pembayaran' => $this->paymentDetails['jumlah_pembayaran'],
            'tanggal_jatuh_tempo' => $this->paymentDetails['tanggal_jatuh_tempo'],
            'status_pinjaman' => $this->paymentDetails['status_pinjaman'],
            'tagihan' => $this->paymentDetails['tagihan'],
        ];
    }
}
