<?php

namespace DLG\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActionApprovals extends Notification
{
    use Queueable;

    protected $approval;

    public function __construct($approval)
    {
        $this->approval = $approval;
    }

 
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'approval' => $this->approval,
            'user' => Auth::user(),
            'time' => Carbon::now()->toDateTimeString()
        ];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
