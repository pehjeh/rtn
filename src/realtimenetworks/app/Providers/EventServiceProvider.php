<?php

namespace App\Providers;

use App\Models\MatchModel;
use App\Models\MatchParameters;
use App\Models\Player;
use App\Observers\MatchObserver;
use App\Observers\ParameterObserver;
use App\Observers\PlayerObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Player::observe(PlayerObserver::class);
        MatchParameters::observe(ParameterObserver::class);
        MatchModel::observe(MatchObserver::class);
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
