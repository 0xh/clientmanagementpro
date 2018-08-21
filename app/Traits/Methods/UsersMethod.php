<?php

namespace App\Traits\Methods;

trait UsersMethod
{
   public static function findByEmail($email)
    {
        return self::whereEmail($email)->firstOrFail();
    }

    public static function findByUsername($username)
    {
    return self::whereUsername($username)->firstOrFail();
    }
}