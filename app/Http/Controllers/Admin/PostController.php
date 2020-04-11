<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post as MainModel;
use App\Models\Term;
use App\Http\Request\PostRequest as MainRequest;

class PostController extends Controller {
    private $pathViewController = 'admin.pages.post.';
    private $model;
    private $params = [];
    private $controllerName = 'post';
    private $pageInfo = [];
   
    public function __construct() {
        $this->pageInfo['page-title'] = 'Post Management';
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

        $termModel = new Term();

        $statusFilters = $this->model->countItems($this->params,['task' => 'admin-count-items-by-status']);

        $terms = $termModel->listTerms('',['task' => 'admin-list-terms']);

        return view($this->pathViewController. 'index', [
            'pageInfo' => $this->pageInfo,
            'items' => $items,
            'statusFilters'=>$statusFilters,
            'params' => $this->params,
            'terms' => $terms
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
        $params['taxonomy'] = 'category';
        $task = 'add';

        $this->pageInfo['page-name'] = 'Add';
        $this->pageInfo['add'] = 'no';

        $termModel = new Term();

        $categories = $termModel->listTerms($params,['task' => 'admin-list-taxonomy']);

        if($request->id !== null) {
            $task = 'edit';
            $params['id'] = $request->id;
            $item = $this->model->getItems($params,['task'=>'item-by-id']);
        }

        return view($this->pathViewController.'form', [
            'pageInfo' => $this->pageInfo,
            'item' => $item,
            'categories' => $categories,
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
   
}