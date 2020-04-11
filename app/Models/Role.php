<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $table = 'hgcms_group';

    public function listItems($params,$options) {
        if($options['task'] == 'admin-list-items') {
            return self::select('id','title')->get();
        }
    }
}