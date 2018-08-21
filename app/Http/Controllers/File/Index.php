<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\File;

class Index extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function __invoke()
    {
        $tenant = $this->getTenant();
        $files = File::with('uploadable','project')->where('user_id',$tenant->id)->get();
        return view('tenant::files',['files' => $files]);
    }
}
