<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
class LogUserLogoutTime
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        // config(['app.timezone' => 'Asia/Manila']);
        // $user = $event->user;

        // if ($user && $user->role == 'employee') {
        //     try {
        //         // Log the logout event
        //         activity()
        //             ->performedOn($user)
        //             ->causedBy($user)
        //             ->inLog($user->email)
        //             ->withProperties([
        //                 'Login' =>Carbon::now(),
        //             ])
        //             ->event('logout')
        //             ->log('The ' . $user->name . ' has been logged out');
        //     } catch (\Exception $e) {
        //         Log::error('Error logging activity: ' . $e->getMessage());
        //         Log::error($e);
        //     }
        // }
    }
}
