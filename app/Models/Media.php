<?php
namespace App\Models;
use App\Models\Admin;

class Media extends Admin {

    protected $table = 'hgcms_image';
    public $timestamps = false;
    protected $fillable = ['filename','filesize','alt','description','caption','title'];
    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->folderUpload = 'media';
    }
    public function listItem($params,$options) {
        $result = null;
        if($options['task'] == 'list-item-api') {
            $result = self::select('id','title','filesize','filename','alt','description','caption')->orderBy('id','desc')->paginate(30);
        }
        return $result;
    }
    
    public function saveImages($thumbObj,$folder){
        $res = null;
        $this->folderUpload = $folder;
        $fileSize = $thumbObj->getSize();
        $fileName = $this->uploadThumb($thumbObj);
        if($fileName) {
            $title = explode('.',$fileName);
            $data = [
                'title' => $title[0],
                'filename' => $folder.'/'.$fileName,
                'filesize' => (string) $fileSize,
                'caption' => null,
                'description' => null,
                'alt' => null

            ];
            $res = self::firstOrCreate($data);
        }
        return $res;
    }
    public function saveItems($params, $options) {
        if($options['task'] == 'admin-save-item') {
            return self::where('id',(int) $params['id'])->update([
                    $params['field'] => $params['fieldValue']
            ]);
        }
    }
    public function deleteItem($id) {
        $thumbObj = self::select('filename')->where('id',$id)->first();
        $this->deleteThumb($thumbObj->filename);
        return self::destroy($id);
    }
}