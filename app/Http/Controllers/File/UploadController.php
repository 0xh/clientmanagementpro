<?php 

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\File;
use Ramsey\Uuid\Uuid;
use App\Repositories\DocMimeType;
use App\Repositories\ImagesMimeType;
use App\Repositories\PSDMimeType;
use Illuminate\Validation\Rule;

class UploadController extends BaseController {

    protected $request;

    protected $file;

    public function __construct (Request $request, File $file)
    {
        $this->request = $request;
        $this->file = $file;
    }
    public function multiple_upload($project) 
    {
        $validator = \Validator::make($this->request->all(), [
            'file' => [
                'required',
                'mimes:jpeg,bmp,png,psd,pdf,ppt,pptx,doc,docx,dotx,xls,txt,odt',
                'max:10000'
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()],409);
        }
        $this->prepareFile();
        
        if($this->uploaded())
        {
            $this->attachProject($project);
            $this->uploadedBy();
            $this->ownsByTenant();
        }

        return response()->json(['success' => true]);
    }

    private function getBucket()
    {
        $mime = $this->request->file('file')->getClientMimeType();
        if(in_array($mime,DocMimeType::all())){
            return 'docs';
        }
        elseif(in_array($mime,ImagesMimeType::all())){
            return 'images';
        }
        elseif(in_array($mime,PSDMimeType::all())){
            return 'psd';
        }else {
            return 'files';
        }
    }

    private function prepareFile()
    {
        $file = $this->request->file('file');
        $this->file->name = $file->getClientOriginalName();
        $this->file->filename = Uuid::uuid1()->toString();
        $this->file->mime_type = $file->getClientMimeType();
        $this->file->extension = $file->getClientOriginalExtension();
        $this->file->size = $file->getClientSize();
        $this->file->path = 'storage/'. $this->getBucket().'/';
    }

    private function attachProject($project)
    {
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
        $mime = array_merge($mime,DocMimeType::all());
        $mime = array_merge($mime,ImagesMimeType::all());
        $mime = array_merge($mime,PSDMimeType::all());
        return 'mimetypes:'.implode(', ', $mime);
    }

    private function uploaded()
    {
        $storage_path = storage_path('app/public/'.$this->getBucket());
        $file = $this->request->file('file');
        return $file->move($storage_path, $this->file->filename . '.' . $this->file->extension);
    }

}