<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Admin extends Model {

    protected $folderUpload = '';

    protected $fieldSearchAccepted = [];

    protected $crudNotAccepted = [];

    public function prepareParams($params){

        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }

    public function uploadThumb($thumbObj) {
        $thumbName =  Str::random(10). '.'. $thumbObj->clientExtension();

        $thumbObj->storeAs($this->folderUpload, $thumbName, 'hgcms_storage_image' );

        return $thumbName;
    }
    
    public function deleteThumb($thumbName) {

        Storage::disk('hgcms_storage_image')->delete('/'. $thumbName);
    }
}