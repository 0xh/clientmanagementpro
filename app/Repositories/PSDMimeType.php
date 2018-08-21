<?php 

namespace App\Repositories;

class PSDMimeType {

    public static function all()
    {
        return [
            'image/vnd.adobe.photoshop',
            'application/x-photoshop',
            'application/photoshop',
            'application/psd',
            'image/psd'
        ];
    }

}