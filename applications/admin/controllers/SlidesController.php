<?php
class SlidesController extends Controller{
    public function actionIndex(){
        $model= new AdminSlidesForm();
        if(isset($_GET["AdminSlidesForm"])) {
            $model->attributes = $_GET["AdminSlidesForm"];
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
     * 广告管理新增OR修改
     */
    public function actionEdit(){
        $id = request("id");
        $model= new AdminSlidesForm();
        $reUrl = user()->getFlash('reUrl');
        if(!$reUrl) {
            $reUrl = "/slides/index";
        }
        if(isset($_SERVER["HTTP_REFERER"])) {
            if(!strpos($_SERVER["HTTP_REFERER"], 'slides/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        if($id){
            $item = Slides::model()->findByPk($id);
            $model->attributes = $item;
        }
        if(isset($_POST["AdminSlidesForm"])){
            $model->attributes = $_POST["AdminSlidesForm"];
            $model->creatTime = date("Y-m-d H:i:s");
            if(isset($_FILES["AdminSlidesForm"]["tmp_name"]["url"]) && $_FILES["AdminSlidesForm"]["tmp_name"]["url"] != "") {
                $model->url = UtilsHelper::uploadFile($model, "url", param("drivesPath"));
            }
            if($model->validate()){
                $model->save();
                user()->setFlash('message', $id ? "修改公告管理信息成功" : "添加公告管理信息成功");
                $this->redirect("/slides/index");
            }
        }
        $this->render('edit',compact("model","id","temp"));
    }
    
}
