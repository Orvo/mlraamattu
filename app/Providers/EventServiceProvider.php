<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use App\ValidSession;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();

        $events = $this->app[Dispatcher::class];

        $events->listen('auth.login', function ($user, $remember) {
            $fingerprint = ValidSession::generateFingerprint(request());
            ValidSession::makeSession($fingerprint);
        });

        $events->listen('auth.logout', function ($user) {
            $fingerprint = ValidSession::generateFingerprint(request());
            $session = ValidSession::findSession($fingerprint);

            if ($session) {
                $session->delete();
            }
        });
    }
}

