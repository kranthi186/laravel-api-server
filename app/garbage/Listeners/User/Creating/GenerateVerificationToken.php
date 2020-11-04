<?php

namespace App\Listeners\User\Creating;

use App\Events\User\Creating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class GenerateVerificationToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Creating  $event
     * @return void
     */
    public function handle(Creating $event)
    {
        $user = $event->user;
        $user->token = Str::random(80);
    }
}
