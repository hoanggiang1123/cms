<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller {

    protected $model;
    public function __construct()
    {
        $this->model = new Media();
    }
    public function list() {
        $result = $this->model->listItem(null,['task' =>'list-item-api']);
        if($result !== null) {
            return response()->json(['result' => $result,'status' => 'ok']);
        } else {
            return response()->json(['result' => [],'status' => 'notok']);
        }
    }
    public function upload(Request $request) {
        $result = $this->model->saveImages($request->file,$request->folder);
        return response()->json(['data'=>$result,'status'=>'ok']);
    }
    public function save(Request $request) {
        $params = $request->all();
        $res = $this->model->saveItems($params,['task' => 'admin-save-item']);
        return response()->json([
            'result' => $res,
            'status' => 'ok'
        ]);
    }
    public function delete(Request $request) {
        $res = $this->model->deleteItem((int) $request->id);
        if($res) return response()->json(['result' => $res,'status' =>'ok']);
    }

}