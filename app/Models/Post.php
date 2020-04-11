<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Models\Admin;
use App\Models\Media;
use DB;

class Post extends Admin {
    protected $table = 'hgcms_post';

    public $timestamps = false;

    const CREATED_AT = 'created';

    const UPDATED_AT = 'modified';

    public function __construct() {
        $this->fieldSearchAccepted = ['id', 'title'];
        $this->crudNotAccepted     = ['_token','category_name','tags','id'];
        $this->folderUpload = 'post';
    }

    public function listItems($params, $options) {
        $result = null;

        if($options['task'] == 'admin-list-items') {
            $query = self::select('id', 'title', 'content', 'status', 'thumb', 'created', 'created_by', 'modified', 'modified_by','category','tag');

            if($params['filter']['status'] !== 'all') {
                $query->where('status', '=',$params['filter']['status']);
            }

            if($params['filter']['category'] != '' && $params['filter']['category'] != 0) {
                $term_id = (int) $params['filter']['category'];
                $search = '"id":'. $term_id;

                $query->whereRaw("LOCATE('$search',category)");
            }

            if($params['filter']['tag'] != '' && $params['filter']['tag'] != 0) {
                $term_id = (int) $params['filter']['tag'];
                $search = '"id":'. $term_id;

                $query->whereRaw("LOCATE('$search',tag)");
            }

            if($params['search']['value'] !== '') {

                if($params['search']['field'] == 'all') {
                    $query->where(function($query) use ($params) {

                        foreach($this->fieldSearchAccepted as $col) {
                            $query->orWhere($col,'LIKE', "%{$params['search']['value']}%");
                        }
                    });

                } else if(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'],'LIKE', "%{$params['search']['value']}%");
                }
            }

            $result = $query->orderBy('id','desc')->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }
    public function countItems($params,$options) {
        $result = null;

        if($options['task'] == 'admin-count-items-by-status') {
            $query = self::select(DB::raw('status, COUNT(id) as count'));

            if($params['filter']['category'] != '' && $params['filter']['category'] != 0) {
                $term_id = (int) $params['filter']['category'];
                $search = '"id":'. $term_id;

                $query->whereRaw("LOCATE('$search',category)");
            }

            if($params['filter']['tag'] != '' && $params['filter']['tag'] != 0) {
                $term_id = (int) $params['filter']['tag'];
                $search = '"id":'. $term_id;

                $query->whereRaw("LOCATE('$search',tag)");
            }

            if($params['search']['value'] !== '') {

                if($params['search']['field'] == 'all') {
                    $query->where(function($query) use ($params) {

                        foreach($this->fieldSearchAccepted as $col) {
                            $query->orWhere($col,'LIKE', "%{$params['search']['value']}%");
                        }
                    });

                } else if(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'],'LIKE', "%{$params['search']['value']}%");
                }
            }

            $result = $query->groupBy('status')->get()->toArray();   
        }

        return $result;
    }
    public function saveItems($params, $options) {
        if($options['task'] == 'change-status') {
            $status = $params['status'] == 'active' ? 'inactive' :'active';

            self::where('id','=',$params['id'])->update(['status' =>$status]);
        }

        if($options['task'] =='change-status-multi') {

            return self::whereIn('id', $params['ids'])->update(['status' => $params['status']]);
        }

        if($options['task'] == 'add-item') {
            if(!isset($params['category_name'])) $params['category_name'] = [];

            $categories = $this->transformCateogry($params['category_name']);
            $tags = $this->transformTag($params['tags']);
            $params['category'] = count($categories) > 0 ? json_encode($categories) : null;
            $params['tag'] = count($tags) > 0 ? json_encode($tags) : null;
            $params['created'] = date('Y-m-d H:i:s');
            $params['created_by'] = 'admin';

            $res = self::insert($this->prepareParams($params));
            if($res) $this->increaseCountForTerms($categories,$tags);
        }

        if($options['task'] == 'edit-item') {
            $oldItem = $this->getItems($params,['task' => 'item-by-id']);
            $this->decreaseOldTerm($params,$oldItem);

            if(!isset($params['category_name'])) $params['category_name'] = [];
            $categories = $this->transformCateogry($params['category_name']);
            
            $tags = $this->transformTag($params['tags']);
            $params['category'] = count($categories) > 0 ? json_encode($categories) : null;
            $params['tag'] = count($tags) > 0 ? json_encode($tags) : null;

            if($params['thumb'] == null) $params['thumb'] = $oldItem->thumb;

            $params['modified'] = date('Y-m-d H:i:s');
            $params['modified_by'] = 'admin';

            $res = self::where('id',$params['id'])->update($this->prepareParams($params));
            if($res) $this->increaseCountForTerms($categories,$tags);
        }
    }

    public function deleteItems($params,$options) {

        if($options['task'] == 'delete-item') {
            $res = self::destroy($params['id']);

            if($res) $this-> decreaseCountForTerms($params);
        }
    }

    public function getItems($params,$options) {
        $result = null;

        if($options['task'] = 'item-by-id') {

            $result = self::select('id', 'title', 'content', 'slug','status', 'thumb', 'created', 'created_by', 'modified', 'modified_by','category','tag','seotitle','seokey','seodes')
                    ->where('id',(int)$params['id'])
                    ->first();
        }

        return $result;
    }

    public function decreaseOldTerm($params,$oldItem) {
        $categories = $oldItem->category;
        $tags = $oldItem->tag;

        $catArr = ($categories == null)? []: json_decode($categories,true);
        $tagArr = ($tags == null)? []: json_decode($tags,true);

        $terms = array_merge($catArr,$tagArr);

        if(count($terms) > 0) {
            $this->decreaseCountTerm($terms);
        }
    }
 }
