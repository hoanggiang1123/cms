<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Models\Admin;
use App\Models\Media;
use DB;
use Illuminate\Support\Facades\Hash;

class User extends Admin {
    protected $table = 'hgcms_user';

    public $timestamps = false;

    public function __construct() {
        $this->fieldSearchAccepted = ['id', 'title'];
        $this->crudNotAccepted     = ['_token','id','task','old_thumb'];
        $this->folderUpload = 'user';
    }

    public function listItems($params, $options) {
        $result = null;

        if($options['task'] == 'admin-list-items') {
            $query = self::from('hgcms_user as u')->select('u.id','u.title', 'u.username','u.status', 'u.thumb','u.email','u.phone', 'g.title as level')
                        ->leftJoin('hgcms_group as g', 'u.group_id','=','g.id');

            if($params['filter']['status'] !== 'all') {
                $query->where('status', '=',$params['filter']['status']);
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

            $params['thumb'] = $this->folderUpload.'/'.$this->uploadThumb($params['thumb']);
            $params['password'] = bcrypt($params['password']);

            self::insert($this->prepareParams($params));
        }

        if($options['task'] == 'edit-item') {
            
            if(!empty($params['thumb'])) {
                $this->deleteThumb($params['old_thumb']);
                $params['thumb'] = $this->folderUpload.'/'.$this->uploadThumb($params['thumb']);
            } else {
                $params['thumb'] = $params['old_thumb'];
            }

           self::where('id',$params['id'])->update($this->prepareParams($params));
        }

        if($options['task'] == 'change-password') {
            self::where('id', $params['id'])->update(['password' =>bcrypt($params['password'])]);
        }
        if($options['task'] == 'change-level') {
            self::where('id', $params['id'])->update(['group_id' => $params['level']]);
        }
    }

    public function deleteItems($params,$options) {

        if($options['task'] == 'delete-item') {
            $res = self::destroy($params['id']);
        }
    }

    public function getItems($params,$options) {
        $result = null;

        if($options['task'] === 'auth-login') {

            $user = self::where('username',$params['username'])->first();
            if($user && Hash::check($params['password'], $user->password)) {
                $result = self::from('hgcms_user as u')
                            ->select('u.id','u.title', 'u.username','u.status', 'u.thumb','u.email','u.phone', 'g.title as level')
                            ->leftJoin('hgcms_group as g', 'u.group_id','=','g.id')
                            ->where('u.id',$user->id)
                            ->first();
            }
        }

        if($options['task'] === 'item-by-id') {

            $result = self::from('hgcms_user as u')
                            ->select('u.id','u.title', 'u.username','u.status', 'u.thumb','u.email','u.phone', 'g.title as level')
                            ->leftJoin('hgcms_group as g', 'u.group_id','=','g.id')
                            ->where('u.id',(int)$params['id'])
                            ->first();
        }

        return $result;
    }

 }
