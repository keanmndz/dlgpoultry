<?php

namespace DLG\Mail;

use Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = 'admin@dlgpoultry.com';
        $subject = 'Request for Password Reset';
        $name = 'DLG Farms Admin';

        return $this->view('admin.sendtoken')
                    ->from($address, $name)
                    ->replyTo('keziah.mendoza97@gmail.com', $name)
                    ->subject($subject);
    }
}
