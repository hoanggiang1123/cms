<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class Role extends Admin 
{
    protected $table = 'hgcms_group';

    public function listItems($params,$options) 
    {
        if($options['task'] == 'admin-list-items') 
        {
            return self::select('id','name')->get();
        }
    }
}