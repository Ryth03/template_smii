<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendReminderToUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $form;
    protected $detail;

    public function __construct($user, $form, $detail)
    {
        $this->user = $user;
        $this->form = $form;
        $this->detail = $detail;
    }

    public function build(){
        return $this->view('emails.sendReminderToUser')
                    ->subject("Reminder of your Work Permit")
                    ->with([
                        'form' => $this->form, 
                        'detail' => $this->detail,
                        'user' => $this->user
                    ]);
    }
}
