<?php

namespace Modules\Evolutly\Configuration;

use Modules\Evolutly\Evolutly;
use Illuminate\Support\Facades\Auth;
use Modules\Evolutly\Contracts\InitialFrontendState;

trait ProvidesScriptVariables
{
    /**
     * Get the default JavaScript variables for Spark.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'csrfToken' => csrf_token(),
            'env' => config('app.env'),
            'api_endpoint' => config('app.domain').'/api',
            'domain' => config('app.domain'),
            'url' => config('app.url'),
            'state' => self::getState(),
        ];
    }

    protected static function getState()
    {
       return Evolutly::call(InitialFrontendState::class.'@forUser', [Auth::user()]);
    }
}
