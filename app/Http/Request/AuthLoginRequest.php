<?php
namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest {

    public function authoirize() {
        return true;
    }
    public function rules() {
        $id = $this->id;
        
        return [
            'username' => 'bail|required|min:5',
            'password' => "bail|required|between: 5,100"
        ];
    }
}