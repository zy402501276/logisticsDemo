<?php
class DynamicController extends Controller{
    public function actionIndex(){
        $model= new AdminDynamicForm();
        if(isset($_GET["AdminDynamicForm"])) {
            $model->attributes = $_GET["AdminDynamicForm"];
        }
        if (isset($_GET['page'])) {
            $model->page = $_GET['page'];
        }
        $dataProvider = $model->search();
        $datas = $dataProvider["datas"];
        $pager = $dataProvider["pager"];
        $this->render('index',compact("model","datas","pager"));
    }
    
     /**
     * 公告OR修改司机
     */
    public function actionEdit(){
        $id = request("id");
        $model= new AdminDynamicForm();
        $reUrl = user()->getFlash('reUrl');
        if(!$reUrl) {
            $reUrl = "/dynamic/index";
        }
        if(isset($_SERVER["HTTP_REFERER"])) {
            if(!strpos($_SERVER["HTTP_REFERER"], 'dynamic/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        if($id){
            $item = Dynamic::model()->findByPk($id);
            $model->attributes = $item;
        }
        if(isset($_POST["AdminDynamicForm"])){
            $model->attributes = $_POST["AdminDynamicForm"];
            $model->creatTime = date("Y-m-d H:i:s");
            $model->state = Dynamic::STATE_YES;
            if($model->validate()){
                $model->save();
                user()->setFlash('message', $id ? "修改公告管理信息成功" : "添加公告管理信息成功");
                $this->redirect("/dynamic/index");
            }
        }
        $this->render('edit',compact("model","id"));
    }
    
    /**
     * 删除公告
     */
    public function actionDel(){
        $id = request("id");
        Dynamic::model()->deleteByPk($id);
        echo jsonEncode(array("state" => 1, "message" => "删除公告管理成功"));
        app()->end();
    }
}
