<?php

namespace App\Providers;

use App\Events\UserActivityLogged;
use App\Listeners\HandleUserActivityLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{ protected $listen = [
    UserActivityLogged::class => [
        HandleUserActivityLog::class,
    ],
];

public function boot()
{
    parent::boot();
}
}
