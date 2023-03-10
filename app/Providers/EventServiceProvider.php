<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\GradeUpdated;
use App\Listener\SaveNotificationOnLog;
use App\Events\GradeUpdatedApi;
use App\Listener\SaveApiNotificationOnLog;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        GradeUpdated::class => [
            SaveNotificationOnLog::class,
        ],
        GradeUpdatedApi::class => [
            SaveApiNotificationOnLog::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
