<?php 

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\File;
use Ramsey\Uuid\Uuid;
use App\Repositories\ImagesMimeType;
use Illuminate\Validation\Rule;

class TaskImageUploader extends BaseController {

    protected $request;

    protected $file;

    public function __construct (Request $request, File $file)
    {
        $this->request = $request;
        $this->file = $file;
    }
    public function upload($job) 
    {
        $validator = \Validator::make($this->request->all(), [
            'image' => [
                'required',
                'mimes:jpeg,bmp,png',
                'max:10000'
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()],409);
        }
        $this->prepareFile($job);
        
        if($this->uploaded($job))
        {
            $this->attachProject($job);
            $this->uploadedBy();
            $this->ownsByTenant();
        }
        $url = '/'. $this->file->path . $this->file->filename . '.' .$this->file->extension;
        return response()->json(['url' => $url,'description' => $this->file->name],200);
    }

    private function getBucket()
    {
        $mime = $this->request->file('image')->getClientMimeType();
        if(in_array($mime,ImagesMimeType::all())){
            return 'jobs';
        }
    }

    private function prepareFile($job)
    {
        $file = $this->request->file('image');
        $alt = $this->request->alt;
        $this->file->name = $alt ? $alt : $file->getClientOriginalName();
        $this->file->filename = Uuid::uuid1()->toString();
        $this->file->mime_type = $file->getClientMimeType();
        $this->file->extension = $file->getClientOriginalExtension();
        $this->file->size = $file->getClientSize();
        $this->file->path = 'storage/'. $this->getBucket().'/' .$job->id . '/';
    }

    private function attachProject($job)
    {
        $project = $job->campaign->project;
        $project->files()->save($this->file);
    }

    private function uploadedBy()
    {
        $this->getAuth()->canUploadFiles()->save($this->file);
    }

    private function ownsByTenant()
    {
        $this->getTenant()->files()->save($this->file);
    }

    private function getAllMimes()
    {
        $mime = array();
        $mime = array_merge($mime,ImagesMimeType::all());
        return 'mimetypes:'.implode(', ', $mime);
    }

    private function uploaded($job)
    {
        $storage_path = storage_path('app/public/'.$this->getBucket().'/'.$job->id);
        $file = $this->request->file('image');
        return $file->move($storage_path, $this->file->filename . '.' . $this->file->extension);
    }

}