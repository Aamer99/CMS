<?php

namespace App\Jobs;

use App\Mail\otpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendOtpMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $data;
   
    public function __construct($data)
    {
        $this->data = $data;
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to("aamer@test.com")->send(new otpMail("12345"));
    }
}
