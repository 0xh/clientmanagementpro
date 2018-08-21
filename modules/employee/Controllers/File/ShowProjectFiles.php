<?php

namespace Modules\Employee\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class ShowProjectFiles extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }
    
    public function __invoke($projectID)
    {
        // We Can View All Upload Related to this Project An Employee Can Access
        return File::with('uploadable')->where('project_id',$projectID->id)->get();
    }
}
