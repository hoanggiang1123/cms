<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $table            = 'hgcms_user';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;
        $task   = $this->task;

        $condAvatar   = '';
        $condUserName = '';
        $condEmail    = '';
        $condPass     = '';
        $condLevel    = '';
        $condStatus   = '';
        $condFullname = '';
        $condCurrentPass = '';
       
        switch ($task) {
            case 'add':
                $condUserName   = "bail|required|between:5,100|unique:$this->table,username";
                $condEmail      = "bail|required|email|unique:$this->table,email";
                $condFullname   = 'bail|required|min: 5';
                $condPass       = 'bail|required|between:5,100';
                $condStatus     = 'bail|in:active,inactive';
                //$condLevel      = 'bail|in:admin,member';
                $condAvatar     = 'bail|required|image|max:500';
                break;
            case 'edit':
                //$condUserName   = "bail|required|between:5,100|unique:$this->table,username,$id"; 
                $condFullname   = 'bail|required|min: 5';
                $condAvatar     = 'bail|image|max:500';
                $condStatus     = 'bail|in:active,inactive';
                $condEmail      = "bail|required|email|unique:$this->table,email,$id";
                break;
            case 'change-password':
                //$condCurrentPass = 'bail|required|between:5,100';
                $condPass = 'bail|required|between:5,100|confirmed';
                break;
            case 'change-level':
                $condLevel = '';
                break;
            default:
                break;
        }
        

        return [
            'username' => $condUserName,
            'email'    => $condEmail,
            'name' => $condFullname,
            'status'   => $condStatus,
            'current_password' => $condCurrentPass,
            'password' => $condPass,
            'level'    => $condLevel,
            'thumb'   => $condAvatar
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'Name không được rỗng',
            // 'name.min'      => 'Name :input chiều dài phải có ít nhất :min ký tứ',
        ];
    }
    public function attributes()
    {
        return [
            // 'description' => 'Field Description: ',
        ];
    }
}
