<?php

namespace DLG\Mail;

use Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $lname;
    public $fname;
    public $pass;

    public function __construct($data)
    {
        $this->lname = $data['lname'];
        $this->fname = $data['fname'];
        $this->pass = $data['pass'];
    }
    
    public function build()
    {
        $address = 'admin@dlgpoultry.com';
        $subject = 'Hello from DLG Poultry Farms!';
        $name = 'DLG Farms Admin';

        return $this->view('admin.sendpw')
                    ->from($address, $name)
                    ->replyTo('keziah.mendoza97@gmail.com', $name)
                    ->subject($subject);
    }
}
