<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Post;
use DB;

class Term extends Admin {

    protected $table = 'hgcms_terms';

    public $timestamps = false;

    protected $fillable = ['title','slug','taxonomy','ordering','thumb','parent','status','seotitle','seodes','seokey','content','ishome','display'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->fieldSearchAccepted = ['id', 'title'];
        $this->crudNotAccepted     = ['_token','id'];
    }

    public function listTerms($params,$options) {
        $result = null;

        if($options['task'] =='admin-list-terms') {
            $tag = [];
            $cat = [];

            $results = self::select('id','title','taxonomy')->get()->toArray();
    
            foreach($results as $res) {

                if($res['taxonomy'] == 'category') {

                    $cat[] = $res;
                } else if($res['taxonomy'] == 'tag') {

                    $tag[] = $res;
                }
            }

            $result['category'] = $cat;
            $result['tag'] = $tag;
        }

        if($options['task'] == 'admin-list-taxonomy') {
            
            $result = self::select('id','title')->where('taxonomy',$params['taxonomy'])->get()->toArray();
        }

        return $result;
    }

    public function listItems($params, $options) {
        $result = null;

        if($options['task'] == 'admin-list-items') {
            $query = self::select('id', 'title', 'status', 'thumb', 'ishome', 'display', 'ordering')
                            ->where('taxonomy',$params['taxonomy']);

            if($params['filter']['status'] !== 'all') {
                $query->where('status', '=',$params['filter']['status']);
            }
            
            if($params['filter']['ishome'] != '' && $params['filter']['ishome'] != '0') {
                $query->where('ishome',$params['filter']['ishome']);
            }

            if($params['filter']['display'] != '' && $params['filter']['display'] != '0') {
                $query->where('display',$params['filter']['display']);
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

            $query = self::select(DB::raw('status, COUNT(id) as count'))
                            ->where('taxonomy',$params['taxonomy']);

            if($params['filter']['ishome'] != '' && $params['filter']['ishome'] != '0') {
                $query->where('ishome',$params['filter']['ishome']);
            }

            if($params['filter']['display'] != '' && $params['filter']['display'] != '0') {
                $query->where('display',$params['filter']['display']);
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

        if($options['task'] == 'change-ishome') {
            $status = $params['ishome'] == 'yes' ? 'no' :'yes';

            self::where('id','=',$params['id'])->update(['ishome' =>$status]);
        }

        if($options['task'] =='change-status-multi') {

            return self::whereIn('id', $params['ids'])->update(['status' => $params['status']]);
        }

        if($options['task'] =='change-ishome-multi') {

            return self::whereIn('id', $params['ids'])->update(['ishome' => $params['ishome']]);
        }

        if($options['task'] =='change-display') {

            foreach($params['cball'] as $key => $value) {

                self::where('id', (int) $value)->update(['display' => $params['display'][$key]]);
            }
        }

        if($options['task'] =='change-ordering') {

            foreach($params['cball'] as $key => $value) {

                self::where('id', (int) $value)->update(['ordering' => $params['ordering'][$key]]);
            }
        }

        if($options['task'] == 'add-item') {

            $res = self::insert($this->prepareParams($params));
        }

        if($options['task'] == 'edit-item') {
            
            $res = self::where('id',$params['id'])->update($this->prepareParams($params));

            if($res) {
                $this->editTaxonomyFromPost($params['id'],$params['taxonomy']);
            }
        }
    }

    public function deleteItems($params,$options) {

        if($options['task'] == 'delete-item') {

            self::destroy($params['id']);

            $taxonomy = $params['taxonomy'];

            if(is_array($params['id'])) {
                
                foreach($params['id'] as $id) {

                    $this->removeTaxonomyFromPost($id,$taxonomy);
                }

            } else {

                $this->removeTaxonomyFromPost($params['id'],$taxonomy);
            }
        }
    }
    
    public function getItems($params,$options) {
        $result = null;

        if($options['task'] = 'item-by-id') {

            $result = self::select('id', 'title', 'content', 'slug','status', 'ishome','display','ordering','thumb','seotitle','seokey','seodes')
                    ->where('id',(int)$params['id'])
                    ->first();
        }

        return $result;
    }

    public function removeTaxonomyFromPost($id,$taxonomy) {
        $search = '"id":'. (int) $id;

        $postModel = new Post();
        $posts = $postModel::select('id',"$taxonomy")->whereRaw("LOCATE('$search',$taxonomy)")->get();
        
        if(count($posts) > 0) {
            
            foreach($posts as $post) {
                
                $tax = $post->{$taxonomy};
                
                if($tax !== null && $tax !== '') {
                    $taxArr = json_decode($tax, true);

                    $newtax = [];
                    foreach($taxArr as $item) {
                        if($item['id'] != $id) {
                            $newtax[] = $item;
                        }
                    }
                    
                    if(count($newtax) == 0) {
                        $newtax = NULL;
                    } else {
                        $newtax = json_encode($newtax);
                    }
                    

                    $postModel->where('id',$post['id'])->update(["$taxonomy" => $newtax]);

                }
                
            }
        }
    }

    public function editTaxonomyFromPost($id,$taxonomy) {
        $search = '"id":'. (int) $id;

        $postModel = new Post();
        $posts = $postModel::select('id',"$taxonomy")->whereRaw("LOCATE('$search',$taxonomy)")->get();

        $currentTax = self::where('id',$id)->first();

        if(count($posts) > 0) {

            foreach($posts as $post) {
                $tax = $post->{$taxonomy};
                if($tax !== null && $tax !== '') {
                    $taxArr = json_decode($tax, true);

                    foreach($taxArr as $key => $item) {
                        if($item['id'] == $id) {
                            $taxArr[$key]['title'] = $currentTax->title;
                        }
                    }

                    $taxArr = json_encode($taxArr);

                    $postModel->where('id',$post['id'])->update(["$taxonomy" => $taxArr]);
                }
            }
        }

    }
}