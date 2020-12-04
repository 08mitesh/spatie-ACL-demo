<?php

namespace App\Listeners;

use App\Events\SendNotificationOnUserRegistration;
use App\Models\User;
use App\Notifications\NewUserNotificationToAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class SendNotificationOnUserRegistrationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendNotificationOnUserRegistration $event)
    {
        $administrators = User::whereHas('roles',function($q){
            $q->where('name','Admin');
        })->get();

        foreach($administrators as $administrator):
            // $administrator->notify(New NewUserNotificationToAdmin($user));
            FacadesNotification::send($administrator, new NewUserNotificationToAdmin($event->user));
        endforeach;
    }
}
