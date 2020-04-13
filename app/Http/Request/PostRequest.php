<?php
namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest {
    private $table = 'hgcms_post';

    public function authoirize() {
        return true;
    }
    public function rules() {
        $id = $this->id;
        $slug = "bail|required|unique:$this->table,slug";
        if(!empty($id))
        {
            $slug .= ",$id";
        }

        return [
            'name' => 'bail|required|min:5',
            'slug' => $slug,
            'content' =>'bail|required|min:5',
            'status' => 'bail|in:active,inactive',
        ];
    }
}