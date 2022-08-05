<?php

namespace App\Jobs;

use App\Mail\NotifyEmail;
use App\Mail\ResetPassword;
use App\Mail\VerifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $data)
    {
        $this->data = $data;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        if($data['type'] == "verify"){
            $mailable = new VerifyMail($data['name'], $data['link']);
            Mail::to($data['email'])->send($mailable);
        }
        if($data['type'] == "reset_password"){
            $mailable = new ResetPassword($data['link']);
            Mail::to($data['email'])->send($mailable);
        }
        if($data['type'] == "notify"){
            $mailable = new NotifyEmail($data['subject'], $data['content']);
            Mail::to($data['to'])->cc($data['cc'])->bcc($data['bcc'])->send($mailable);
            }
    }
}
