<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class Permision extends Admin 
{
    protected $table = 'hgcms_permision';
    
    public function listItems($params,$options) 
    {
        if($options['task'] == 'admin-list-items-with-permision') 
        {
            if($params) {
                $ids = explode(',', $params);
                return self::whereIn('id',$ids)->get()->pluck('name')->toArray();
            }
        }
    }
}