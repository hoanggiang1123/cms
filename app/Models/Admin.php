<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Term;
use DB;
class Admin extends Model {
    protected $folderUpload = '';
    protected $fieldSearchAccepted = [];
    protected $crudNotAccepted     = [];

    public function transformCateogry($catNames) {
        $categories = [];

        if(count($catNames) > 0) {
            foreach($catNames as $category) {
                $catArr = explode(',',$category);
                $categories[] = [
                    'id' => (int) $catArr[0],
                    'title' => $catArr[1]
                ];
            }
        }

        return $categories;
    }

    public function transformTag($taxes) {

        if($taxes !== null && $taxes !== '') {
            $taxes = explode(',',$taxes);

            $termModel = new Term();
            
            $res = [];
            foreach($taxes as $tax) {
                $slug = Str::slug(trim($tax),'-');
                
                $result = $termModel->select('id','title')
                                        ->where('taxonomy','tag')
                                        ->where('slug', $slug)
                                        ->first();

                if($result == null) {
                    $res[] = $termModel->create([
                        'slug'=>  $slug,
                        'title' => trim($tax),
                        'taxonomy' => 'tag'
                    ]);
                    
                } else {

                    $res[] = $result;
                }
                
            }

            $return = [];
            if(count($res) > 0) {
                foreach($res as $item) {
                    $return[] = ['id' => $item->id, 'title' => $item->title];
                }
            }

            return $return;
        }

        return [];
    }

    public function prepareParams($params){

        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }
    public function increaseCountForTerms($categories,$tags) {
        $terms = array_merge($categories,$tags);

        $termModel = new Term();

        foreach($terms as $term) {
            $termModel::where('id',$term['id'])->increment('count');
        }
    }

    public function decreaseCountForTerms($params) {
        $ids = $params['id'];

        $termModel = new Term();

        if(is_array($ids)) {

            foreach($ids as $id) {

                $termModel::where('id',(int) $id)->decrement('count');
            }
        } else {

            $termModel::where('id',(int) $ids)->decrement('count');
        }
    }

    public function decreaseCountTerm($terms) {
        $termModel = new Term();

        foreach($terms as $term) {

            $termModel::where('id',$term['id'])->decrement('count');
        }
    }

    public function increaseCountTerm($terms) {
        $termModel = new Term();

        foreach($terms as $term) {

            $termModel::where('id',$term['id'])->increment('count');
        }
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