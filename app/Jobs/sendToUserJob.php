<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendToUser;

class sendToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $form;
    protected $detail;
    protected $comment;

    public function __construct($email, $form, $detail, $comment)
    {
        $this->email = $email;
        $this->form = $form;
        $this->detail = $detail;
        $this->comment = $comment;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new sendToUser($this->form, $this->detail, $this->comment));
    }
}
