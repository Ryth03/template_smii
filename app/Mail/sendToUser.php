<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendToUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $form;
    protected $detail;
    protected $comment;
    
    public function __construct($user, $form, $detail, $comment)
    {
        $this->user = $user;
        $this->form = $form;
        $this->detail = $detail;
        $this->comment = $comment;
    }

    public function build(){
        return $this->view('emails.sendToUser')
                    ->subject("Your form has been ".$this->form->status)
                    ->with([
                        'form' => $this->form, 
                        'detail' => $this->detail,
                        'comment' => $this->comment,
                        'user' => $this->user
                    ]);
    }
}
