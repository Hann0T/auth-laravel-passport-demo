<?php

namespace App\Listener;

use App\Events\GradeUpdatedApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveApiNotificationOnLog
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
     * @param  \App\Events\GradeUpdatedApi  $event
     * @return void
     */
    public function handle(GradeUpdatedApi $event)
    {
        info('Grade was updated: ');
        info('from: ');
        info(print_r($event->prevGrade, true));
        info('to: ');
        info(print_r($event->newGrade, true));
        info('by: ');
        info(print_r($event->ip, true));
    }
}
