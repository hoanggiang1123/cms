<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    private $pathViewController = 'admin.pages.dashboard.';
    private $pageInfo = [];
    private $controllerName = 'dashboard';
    
    public function __construct()
    {
        $this->pageInfo['page-title'] = 'DashBoard';
        view()->share('controllerName', $this->controllerName);
    }

    public function index() 
    {
        $this->pageInfo['page-name'] = 'Overall';
        $this->pageInfo['add'] = 'no';
        return view($this->pathViewController. 'index',[
            'pageInfo' => $this->pageInfo
        ]);
    }
}