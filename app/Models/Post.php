<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

use App\Models\Admin;
use App\Models\Media;
use App\Models\Tag;
use DB;

class Post extends Admin {

    protected $table = 'hgcms_post';

    public $timestamps = false;

    protected $fillable = ['id','name', 'content', 'slug','status', 'thumb', 'created', 'created_by', 'modified', 'modified_by','category_id','seotitle','seokey','seodes'];

    const CREATED_AT = 'created';

    const UPDATED_AT = 'modified';

    public function __construct(array $attributes = []) 
    {
        parent::__construct($attributes);
        $this->fieldSearchAccepted = ['id', 'name'];
        $this->crudNotAccepted     = ['_token','id','tags'];
        $this->folderUpload = 'post';
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','hgcms_post_tag','post_id','tag_id');
    }

    public function listItems($params, $options) 
    {
        $result = null;

        if($options['task'] == 'admin-list-items') {
            $query = self::select('id','name','slug','status','thumb','created','created_by','modified','modified_by','category_id')
                            ->with('category','tags');
            if($params['user']['level'] == 'Writer')
            {
                $query->where('created_by', '=',$params['user']['username']);
            }
            if($params['filter']['status'] !== 'all') 
            {
                $query->where('status', '=',$params['filter']['status']);
            }

            if($params['filter']['category'] != '' && $params['filter']['category'] != 0) 
            {
                $query->whereHas('category', function(Builder $q) use($params) {
                    $q->where('hgcms_categories.id',(int) $params['filter']['category']);
                });
            }

            if($params['filter']['tag'] != '' && $params['filter']['tag'] != 0) 
            {
                $query->whereHas('tags', function(Builder $q) use($params) {
                    $q->where('hgcms_tags.id',(int) $params['filter']['tag']);
                });
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

        if($options['task'] == 'admin-count-items-by-status') 
        {
            $query = self::select(DB::raw('status, COUNT(id) as count'));

            if($params['user']['level'] == 'Writer')
            {
                $query->where('created_by', '=',$params['user']['username']);
            }
            
            if($params['filter']['category'] != '' && $params['filter']['category'] != 0) 
            {
                $query->whereHas('category', function(Builder $q) use($params) {
                    $q->where('hgcms_categories.id',(int) $params['filter']['category']);
                });
            }

            if($params['filter']['tag'] != '' && $params['filter']['tag'] != 0) 
            {
                $query->whereHas('tags', function(Builder $q) use($params) {
                    $q->where('hgcms_tags.id',(int) $params['filter']['tag']);
                });
            }

            if($params['search']['value'] !== '') 
            {
                if($params['search']['field'] == 'all') 
                {
                    $query->where(function($query) use ($params) {

                        foreach($this->fieldSearchAccepted as $col) 
                        {
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

        if($options['task'] == 'add-item') 
        {
            $params['created'] = date('Y-m-d H:i:s');
            $params['created_by'] = 'danchoi';

            $post = self::create($params);

            if($post)
            {
                $category = $post->category;

                if($category) $category->increment('count');

                $post->createTag($params['tags']);
            }
        }

        if($options['task'] == 'edit-item') {
            
            $params['modified'] = date('Y-m-d H:i:s');
            $params['modified_by'] = 'admin';

            $post = self::where('id',$params['id'])->first();

            if($post->category_id !== (int) $params['category_id']) 
            {
                $category = $post->category;

                if($category) $category->decrement('count');
            }

            $tags = $post->tags;

            if(count($tags) > 0)
            {
                foreach($tags as $tag)
                {
                    $tag->decrement('count');
                }
                
                $post->tags()->detach();
            }

            self::where('id',$params['id'])->update($this->prepareParams($params)); 
            $post = self::find($params['id']);
            $category = $post->category;

            if($category)  $category->increment('count');

            $post->createTag($params['tags']);
        }
    }

    public function deleteItems($params,$options) {
       
        if($options['task'] == 'delete-item') 
        {
            $ids = array_wrap($params['id']);
            
            foreach($ids  as $id)
            {
                $post = self::find((int) $id);
                $category = $post->category;
                
                if($category)
                {
                    $category->count = $category->count - 1;
                    $category->save();
                }

                $tags = $post->tags;

                if(count($tags) > 0)
                {
                    foreach($tags as $tag) 
                    {
                        $tag->decrement('count');
                    }
                }

                $post->tags()->detach();

                $post->delete();
            }
        }
    }

    public function getItems($params,$options) {
        $result = null;

        if($options['task'] = 'item-by-id') {

            $result = self::select('id', 'name', 'content', 'slug','status', 'thumb', 'created', 'created_by', 'modified', 'modified_by','category_id','seotitle','seokey','seodes')->with('tags')
                    ->where('id',(int)$params['id'])
                    ->first();
        }

        return $result;
    }

    public function createTag($tags)
    {
        
        if($tags != null && $tags !== '') 
        {
            $tagArray = explode(',',$tags);
            $tagIds = [];
            foreach($tagArray as $tag) 
            {
                $tagModel = new Tag();
                $tagObj = $tagModel::where('slug',Str::slug($tag,'-'))->first();

                if($tagObj) 
                {
                    $tagIds[] = $tagObj->id;

                    $tagObj->increment('count');

                } else {
                    $newTag = $tagModel->firstOrCreate([
                        'name' => $tag,
                        'slug' => Str::slug($tag,'-')
                    ]);
                    $tagIds[] = $newTag->id;

                    $newTag->increment('count');
                }
            }

            $this->tags()->attach($tagIds);
        }   
    }
 }
