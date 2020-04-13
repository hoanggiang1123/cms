<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use DB;
class Category extends Admin {
    protected $table = 'hgcms_categories';

    public $timestamps = false;

    protected $fillable = ['name','slug','ordering','thumb','parent_id','status','seotitle','seodes','seokey','content','ishome','display'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted     = ['_token','id'];
    }

    public function posts() {
        return $this->hasMany('App\Models\Post','category_id','id');
    }   

    public function listItems($params, $options) 
    {
        $result = null;

        if($options['task'] == 'admin-list-items') 
        {

            $query = self::select('id','name','slug','status','thumb','ishome','display','ordering');

            if($params['filter']['status'] !== 'all') 
            {
                $query->where('status', '=',$params['filter']['status']);
            }

            if($params['filter']['ishome'] !== null && $params['filter']['ishome'] !== 'all') 
            {
                $query->where('ishome',$params['filter']['ishome']);
            }

            if($params['filter']['display'] !== null && $params['filter']['display'] !== 'all') 
            {
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

    public function countItems($params,$options) 
    {
        $result = null;

        if($options['task'] == 'admin-count-items-by-status') {

            $query = self::select(DB::raw('status, COUNT(id) as count'));

            if($params['filter']['ishome'] !== null && $params['filter']['ishome'] !== 'all') 
            {
                $query->where('ishome',$params['filter']['ishome']);
            }

            if($params['filter']['display'] !== null && $params['filter']['display'] !== 'all') 
            {
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

            $category = self::create($params);
        }

        if($options['task'] == 'edit-item') {

            self::where('id',$params['id'])->update($this->prepareParams($params));
        }
    }

    public function deleteItems($params,$options) 
    {

        if($options['task'] == 'delete-item') {

            $ids = array_wrap($params['id']);

            self::destroy($ids);

            if(count($ids) > 0)
            {
                foreach($ids as $id) 
                {
                    $posts = \App\Models\Post::where('category_id',$id)->get();

                    if(count($posts) > 0)
                    {
                        foreach($posts as $post)
                        {
                            $post->category()->dissociate();
                        }
                    }
                }
            }
        }
    }
    
    public function getItems($params,$options) 
    {
        $result = null;

        if($options['task'] = 'item-by-id') {

            $result = self::select('id', 'name', 'content', 'slug','status', 'ishome','display','ordering','thumb','seotitle','seokey','seodes')
                    ->where('id',(int)$params['id'])
                    ->first();
        }

        return $result;
    }
}