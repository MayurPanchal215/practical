<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class EventNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $events = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ids   = $this->events->pluck('id');
        $users = User::whereHas('events', function($query) use($ids){
           $query->whereIn('id',$ids);
        })->get();
        foreach ($users as $user) {
            $getEvent = Event::whereHas('users', function($query) use($ids) {
                $query->whereIn('id',$ids);
            })->get();
            $to_email = $user->email;
            $mailres  = Mail::send('emails.sendmail', ['eventData' => $getEvent],function ($message) use ($to_email) {
                $message->from("mayurpanchal215@gmail.com","Mayur Panchal");
                $message->subject("Event Notification");
                $message->to($to_email);
            });
        }
    }
}
