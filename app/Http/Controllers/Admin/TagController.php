<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term as MainModel;
use App\Http\Request\TermRequest as MainRequest;

class TagController extends Controller {
    private $pathViewController = 'admin.pages.tag.';
    private $model;
    private $params = [];
    private $controllerName = 'tag';
    private $pageInfo = [];
   
    public function __construct() {
        $this->pageInfo['page-title'] = 'Tag Management';
        $this->model = new MainModel();
        $this->params['pagination']['totalItemsPerPage'] = 6;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
       
        $this->pageInfo['page-name'] = 'list';
        $this->pageInfo['add'] = 'yes';

        $this->params['taxonomy'] = $this->controllerName;
        
        $this->params['filter']['status'] = ($request->filter_status == null)? 'all': $request->filter_status;
        $this->params['search']['field'] = $request->search_field;
        $this->params['search']['value'] = $request->search_value;
        $this->params['filter']['ishome'] = $request->filter_ishome;
        $this->params['filter']['display'] = $request->filter_display;
        $this->params['pagination']['page'] = $request->page;

        $items = $this->model->listItems($this->params,['task' => 'admin-list-items']);
        $statusFilters = $this->model->countItems($this->params,['task' => 'admin-count-items-by-status']);

        return view($this->pathViewController. 'index', [
            'pageInfo' => $this->pageInfo,
            'items' => $items,
            'statusFilters'=>$statusFilters,
            'params' => $this->params,
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
        $params = [];
        $task = 'add';

        $this->pageInfo['page-name'] = 'Add';
        $this->pageInfo['add'] = 'no';

        if($request->id !== null) {
            $task = 'edit';
            $params['id'] = $request->id;
            $item = $this->model->getItems($params,['task'=>'item-by-id']);
        }

        return view($this->pathViewController.'form', [
            'pageInfo' => $this->pageInfo,
            'item' => $item,
            'task' => $task
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
        $params['taxonomy'] = 'tag';
        
        $this->model->deleteItems($params,['task'=>'delete-item']);

        return redirect()->back()->with('hgcms_notify','Item is Deleted');
    }
    public function deletes(Request $request) {
       $params = [];
       $params['id'] = $request->cball;
       $params['taxonomy'] = 'tag';

       $this->model->deleteItems($params,['task'=>'delete-item']);

       return redirect()->back()->with('hgcms_notify','Item is Deleted');
    }
    public function save(MainRequest $request) {

        if($request->method() == 'POST') {
            $params = $request->all();
            $params['taxonomy'] = 'tag';
            
            $task = 'add-item';
            $notify = 'Add Item Successfully';

            if($params['id'] !== null) {
                $task = 'edit-item';
                $notify = 'Edit Item Successfully';
            }

            $this->model->saveItems($params,['task' => $task]);

            if($task == 'add-item') return redirect()->route($this->controllerName)->with('hgcms_notify',$notify);
            return redirect()->back()->with('hgcms_notify',$notify);
        }
    }

    public function ishome(Request $request) {
        $params['id'] = $request->id;
        $params['ishome'] = $request->ishome;

        $this->model->saveItems($params,['task'=>'change-ishome']);

        return redirect()->back()->with('hgcms_notify','Change Is Home Successful');
    }

    public function ishomese(Request $request) {
        $params = [];
        $params['ids'] = $request->cball;
        $params['ishome'] =  $request->ishome;

        $res = $this->model->saveItems($params,['task' =>'change-ishome-multi']);

        return redirect()->back()->with('hgcms_notify',"$res items change IsHome Successful");
    }

    public function display(Request $request) {
        $res = $this->model->saveItems($request->all(),['task' =>'change-display']);

        return redirect()->back()->with('hgcms_notify',"$res Items Change Display Successful");
    }

    public function ordering(Request $request) {
        $res = $this->model->saveItems($request->all(),['task' =>'change-ordering']);

        return redirect()->back()->with('hgcms_notify',"$res Items Change Ordering Successful");
    }
   
}