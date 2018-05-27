<?php

namespace DLG\Notifications;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HealthUpdate extends Notification
{
    use Queueable;

    public $update;

    public function __construct($update)
    {
        $this->update = $update;
    }

    /**
     * Get the notification's delivery channels.
     */

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'update' => $this->update,
            'user' => Auth::user(),
            'time' => Carbon::now()->toDateTimeString()
        ];
    }

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'update' => $this->update,
    //         'user' => $notifiable,
    //         'time' => Carbon::now()->toDateTimeString()
    //     ]);
    // }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
