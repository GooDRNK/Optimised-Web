<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\EmailVerification;
class SendVerificationEmail implements ShouldQueue
{
    protected $user;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public function __construct($user)
    {
        
        $this->user = $user;
    }


    public function handle()
    {
       
        $email = new EmailVerification($this->user);
            Mail::to($this->user->email)->send($email);
    }
}
