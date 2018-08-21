<?php

namespace App\Traits\Methods;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NormalizerException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait NormalizerMethod
{
    public static function normalize($modelOrID) : Model
    {
        if ($modelOrID instanceof Model) {
            return $modelOrID;
        }

        try{
            return self::find($modelOrID);
        }catch(ModelNotFoundException $e){
            throw $e;
        }

        if($modelOrID instanceof Collection) {

            throw NormalizerException::collectionException($modelOrID);
        }
    }

}