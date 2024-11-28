<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendToApprover;

class sendToApproverJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $email;
    protected $form;
    protected $detail;
    protected $role;

    public function __construct($email, $form, $detail, $role)
    {
        $this->email = $email;
        $this->form = $form;
        $this->detail = $detail;
        $this->role = $role;
    }

    public function handle(): void
    {
        return;
        if(count($this->email) > 1){
            $firstEmail = array_shift($this->email);
            Mail::to($firstEmail)
                ->cc($this->email)
                ->send(new sendToApprover($this->form, $this->detail, $this->role));
        }else{
            Mail::to($this->email)
                ->send(new sendToApprover($this->form, $this->detail, $this->role));
        }
    }
}
