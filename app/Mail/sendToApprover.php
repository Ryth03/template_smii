<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendToApprover extends Mailable
{
    use Queueable, SerializesModels;

    protected $form;
    protected $detail;
    protected $role;
    
    public function __construct($form, $detail, $role)
    {
        $this->form = $form;
        $this->detail = $detail;
        $this->role = $role;
    }

    public function build(){
        return $this->from(config('mail.from.address'), 'PT Sinar Meadow - HSE')
                    ->view('emails.sendToApprover')
                    ->subject("A new form needs your ".($this->form->status === "In Review" ? 'review' : 'approval'))
                    ->with([
                        'form' => $this->form, 
                        'detail' => $this->detail,
                        'role' => $this->role
                    ]);
    }
}
