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
        
        return [
            'title' => 'bail|required|min:5',
            'slug' => "bail|required|unique:$this->table,slug,$id",
            'content' =>'bail|required|min:5',
            'status' => 'bail|in:active,inactive',
        ];
    }
}