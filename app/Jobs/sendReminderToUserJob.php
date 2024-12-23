<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendReminderToUser;

class sendReminderToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $user;
    protected $form;
    protected $detail;

    public function __construct($user, $form, $detail)
    {
        $this->email = $user->email;
        $this->user = $user->name;
        $this->form = $form;
        $this->detail = $detail;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new sendReminderToUser($this->user, $this->form, $this->detail));
    }
}
