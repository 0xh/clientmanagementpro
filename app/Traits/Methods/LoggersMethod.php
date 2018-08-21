<?php

namespace App\Traits\Methods;

use Spatie\Activitylog\Models\Activity;

trait LoggersMethod
{
    public static function getLogs($id)
    {
        $subject =  self::find($id);
        return Activity::forSubject($subject)->get();
    }

    public static function firstLog($id)
    {
        $subject =  self::find($id);
        return Activity::forSubject($subject)->get()->first();
    }

    public static function lastLog($id)
    {
        $subject =  self::find($id);
        return Activity::forSubject($subject)->get()->last();
    }

}