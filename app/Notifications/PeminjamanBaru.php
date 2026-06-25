<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PeminjamanBaru extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'loan_id' => $this->loan->id,
            'message' => 'Mahasiswa ' . $this->loan->borrower_name . ' meminjam alat.',
            // Route ini harus sesuai dengan route detail di sisi admin
            'url' => route('admin.loans.show', $this->loan->id), 
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Ada peminjaman baru dari ' . $this->loan->borrower_name,
            'receipt' => $this->loan->receipt_number,
        ]);
    }
}