<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User as MainModel;
use App\Http\Request\AuthLoginRequest as MainRequest;
use Illuminate\Http\Request;

class AuthController extends Controller {
    private $controllerName = 'auth';
    private $pathViewController = 'admin.pages.auth.';
    private $model;

    public function __construct()
    {   
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function login() {
        return view($this->pathViewController.'login');
    }
    
    public function postLogin(MainRequest $request)
    {
        if($request->method() == 'POST') {

            $params = $request->only('username','password');

            $res = $this->model->getItems($params, ['task' => 'auth-login']);
            
            if(!$res) return redirect()->route($this->controllerName.'/login')->withErrors('Acc or Pass not Correct');

            $request->session()->put('userInfo',$res);
            return redirect()->route('dashboard');
        }
    }

    public function logout(Request $request)
    {
        if($request->session()->has('userInfo')) $request->session()->pull('userInfo');
        return redirect()->route('dashboard');
    }

}