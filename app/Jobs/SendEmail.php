<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendEamilMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $datas=[];
    protected $users;
    public function __construct($data,$user)
    {
        $this -> datas = $data;
        $this -> users = $user;

    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $datas = $this->datas;
        $users = $this->users;
        Mail::send("student.email",compact('datas'),function($message) use($datas,$users){
            $message->from($datas['from'], $users->first_name.'.'.$users->last_name)
            ->to($datas['email'])
            ->subject($datas['subject']);
        }); 
    }
}
