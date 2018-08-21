<?php 

namespace App\Repositories;

class ImagesMimeType {

    public static function all()
    {
        return [
            'image/gif',
            'image/png',
            'image/jpeg',
            'image/bmp',
            'image/webp'
        ];
    }

}