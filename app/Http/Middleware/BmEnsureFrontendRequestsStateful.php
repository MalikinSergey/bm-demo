<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class BmEnsureFrontendRequestsStateful extends EnsureFrontendRequestsAreStateful
{
    /**
     * Configure secure cookie sessions.
     *
     * @return void
     */
    protected function configureSecureCookieSessions()
    {
        config([
            'session.http_only' => true,
            'session.same_site' => 'none', // changed from 'lax'
        ]);
    }
}
