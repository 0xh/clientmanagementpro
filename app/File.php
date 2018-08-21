<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\FileBuilder;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use FileBuilder;

    public static function boot()
    {
        parent::boot();
    
        self::deleted(function($file){
             $file = public_path($file->path).$file->filename.'.'.$file->extension;
             if(\File::isFile($file)){
                \File::delete($file);
             }
        });
    }
}
