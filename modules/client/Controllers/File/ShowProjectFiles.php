<?php

namespace Modules\Client\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class ShowProjectFiles extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }
    
    public function __invoke($projectID)
    {
        // we have the current instance of project...
        // we just select all files related to this project
        $this->getAuth();
        return File::with('uploadable')->where('project_id',$projectID->id)->get();
        // for editing and deleting it should only be done by the one who upload or by the admin.
    }
}
