<?php

namespace App\Providers;

use App\Events\AnnouncementCreated;
use App\Listeners\SendAnnouncementNotification;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        AnnouncementCreated::class => [
            SendAnnouncementNotification::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Employee::observe(EmployeeObserver::class);
    }
}
