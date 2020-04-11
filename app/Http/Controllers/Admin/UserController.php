<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as MainModel;
use App\Models\Role;
use App\Http\Request\UserRequest as MainRequest;

class UserController extends Controller {
    private $pathViewController = 'admin.pages.user.';
    private $model;
    private $params = [];
    private $controllerName = 'user';
    private $pageInfo = [];
   
    public function __construct() {
        $this->pageInfo['page-title'] = 'User Management';
        $this->model = new MainModel();
        $this->params['pagination']['totalItemsPerPage'] = 6;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $this->pageInfo['page-name'] = 'list';
        $this->pageInfo['add'] = 'yes';

        $this->params['filter']['status'] = ($request->filter_status == null)? 'all': $request->filter_status;
        $this->params['filter']['category'] = $request->filter_category;
        $this->params['filter']['tag'] = $request->filter_tag;
        $this->params['search']['field'] = $request->search_field;
        $this->params['search']['value'] = $request->search_value;
        $this->params['pagination']['page'] = $request->page;

        $items = $this->model->listItems($this->params,['task' => 'admin-list-items']);


        $statusFilters = $this->model->countItems($this->params,['task' => 'admin-count-items-by-status']);

        return view($this->pathViewController. 'index', [
            'pageInfo' => $this->pageInfo,
            'items' => $items,
            'statusFilters'=>$statusFilters,
            'params' => $this->params
        ]);
    }

    public function status(Request $request) {
        $params['id'] = $request->id;
        $params['status'] = $request->status;

        $this->model->saveItems($params,['task'=>'change-status']);

        return redirect()->back()->with('hgcms_notify','Change Status Successful');
    }

    public function form(Request $request) {
        $item = null;
        $roles = null;
        $params = [];
        $task = 'add';

        $this->pageInfo['page-name'] = 'Add';
        $this->pageInfo['add'] = 'no';
        $view = $this->pathViewController.'form' . '-' .$task;

        if($request->id !== null) {
            $this->pageInfo['page-name'] = 'Edit';
            $this->pageInfo['add'] = 'no';

            $task = 'edit';
            $params['id'] = $request->id;

            $item = $this->model->getItems($params,['task'=>'item-by-id']);

            $roleModel = new Role();
            $roles = $roleModel->listItems('',['task' =>'admin-list-items']);

            $view = $this->pathViewController.'form' . '-' .$task;
        }

        return view($view, [
            'pageInfo' => $this->pageInfo,
            'item' => $item,
            'task' => $task,
            'roles' => $roles
        ]);
    }

    public function statuses(Request $request) {
        $params = [];
        $params['ids'] = $request->cball;
        $params['status'] =  $request->status;

        $res = $this->model->saveItems($params,['task' =>'change-status-multi']);

        return redirect()->back()->with('hgcms_notify',"$res items change Status Successful");   
    }
    public function delete(Request $request) {
        $id = $request->id;
        $params = [];
        $params['id'] = $id;

        $this->model->deleteItems($params,['task'=>'delete-item']);

        return redirect()->back()->with('hgcms_notify','Item is Deleted');
    }

    public function deletes(Request $request) {
       $params = [];
       $params['id'] = $request->cball;

       $this->model->deleteItems($params,['task'=>'delete-item']);

       return redirect()->back()->with('hgcms_notify','Item is Deleted');
    }

    public function save(MainRequest $request) {
 
        if($request->method() == 'POST') {
            $params = $request->all();
            $task = 'add-item';
            $notify = 'Add User Successfully';

            if($params['id'] !== null) {
                $task = 'edit-item';
                $notify = 'Edit User Successfully';
            }

            $this->model->saveItems($params,['task' => $task]);
            if($task == 'add-item') return redirect()->route($this->controllerName)->with('hgcms_notify',$notify);
            return redirect()->back()->with('hgcms_notify',$notify);
        }
    }

    public function changePassword(MainRequest $request) {
        if($request->method() == 'POST') {
            $params = $request->all();
            $this->model->saveItems($params,['task'=>'change-password']);
            return redirect()->back()->with('hgcms_notify','Change password Successfull');
            
        }
    }

    public function level(MainRequest $request) {
        if($request->method() == 'POST') {
            $params = $request->all();
            $this->model->saveItems($params,['task'=>'change-level']);
            return redirect()->back()->with('hgcms_notify','Change password Successfull');
        }
    }
   
}