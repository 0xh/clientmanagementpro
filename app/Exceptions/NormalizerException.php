<?php

namespace App\Exceptions;

use Exception;

class NormalizerException extends Exception
{
    public static function collectionException($collection)
    {
        $class = get_class($collection->first());
        return new static('Please Provided An Intance Of '. $class . ' Instead');
    }
}
