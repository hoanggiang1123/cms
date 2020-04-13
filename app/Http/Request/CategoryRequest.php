<?php
namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest {
    private $table = 'hgcms_categories';

    public function authoirize() {
        return true;
    }
    public function rules() {
        $id = $this->id;
        
        return [
            'name' => 'bail|required|min:5',
            'slug' => "bail|required|unique:$this->table,slug,$id",
            'status' => 'bail|in:active,inactive',
            'ishome' => 'bail|in:yes,no',
        ];
    }
}