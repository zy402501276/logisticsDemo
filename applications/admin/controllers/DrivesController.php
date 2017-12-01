<?php
class DrivesController extends Controller {

    public function actionIndex() {
        $model = new AdminDrivesForm();
        if(isset($_GET["AdminDrivesForm"])) {
            $model->attributes = $_GET["AdminDrivesForm"];
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
     * 新增OR修改司机
     */
    public function actionEdit(){
        $dId = request('dId');
        $reUrl = user()->getFlash('reUrl');
        if(!$reUrl) {
            $reUrl = "/drives/index";
        }
        if(isset($_SERVER["HTTP_REFERER"])) {
            if(!strpos($_SERVER["HTTP_REFERER"], 'drives/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        $model = new AdminDrivesForm();
        if($dId){
            $item = Drives::model()->findByPk($dId);
            $model->attributes = $item;
        }
      
        if(isset($_POST["AdminDrivesForm"])){
            $model->attributes = $_POST["AdminDrivesForm"];
            $drivesItem = Drives::model()->findAll();
            if(!$dId){
                if($drivesItem){
                    foreach($drivesItem as $val){
                        if($val["driverName"] == $model["driverName"]){
                            user()->setFlash('message', "重复司机信息");
                            $this->redirect("/drives/edit");
                        }
                    }
                }
            }
            if(isset($_FILES["AdminDrivesForm"]["tmp_name"]["driveImg"]) && $_FILES["AdminDrivesForm"]["tmp_name"]["driveImg"] != "") {
                $model->driveImg = UtilsHelper::uploadFile($model, "driveImg", param("drivesPath"));
            }
            $model->dState = Drives::DSTATE_VALID;
            $model->authState = Drives::AUTHSTATE_YES;
            if(!$dId){
               $model->createTime = date("Y-m-d H:i:s");
            }
            if($model->validate()){
                $model->save();  
                user()->setFlash('message', $dId ? "修改司机信息成功" : "添加司机信息成功");
                $this->redirect("/drives/index");
            }
        }
        $this->render("edit",compact('model',"dId"));
    }
    
    /**
     * 启用OR停用
     */
    public function actionUpdateState(){
        $dState = request('dState');
        $dId = request('dId');
        Drives::model()->updateByPk($dId,array('dState'=>$dState));
        user()->setFlash('message', "修改状态成功");
        $this->redirect("/drives/index");
    }
    
    /**
     * 司机认证信息
     */
    public function actionDrivesInfo(){
        $dId = request('dId');
        $model = new AdminDriverInfoForm();
        $typeItem = CarType::model()->findStateAll();
        if($typeItem){
            $carsArray = UtilsHelper::packKeyAndValueFromArray($typeItem, 'id', 'name');
        }else{
            $carsArray = array();
        }
        
        if($dId){
            $item = DriverInfo::model()->findDId($dId);
            $model->attributes = $item;
        }
        if(isset($_POST["AdminDriverInfoForm"])){
            $model->attributes = $_POST["AdminDriverInfoForm"];
            $model->dId = $dId;
            if(isset($_FILES["AdminDriverInfoForm"]["tmp_name"]["idcardUrl"]) && $_FILES["AdminDriverInfoForm"]["tmp_name"]["idcardUrl"] != "") {
                $model->idcardUrl = UtilsHelper::uploadFile($model, "idcardUrl", param("drivesPath"));
            }
            if(isset($_FILES["AdminDriverInfoForm"]["tmp_name"]["idcardOtherUrl"]) && $_FILES["AdminDriverInfoForm"]["tmp_name"]["idcardOtherUrl"] != "") {
                $model->idcardOtherUrl = UtilsHelper::uploadFile($model, "idcardOtherUrl", param("drivesPath"));
            }
            if(isset($_FILES["AdminDriverInfoForm"]["tmp_name"]["driverLicUrl"]) && $_FILES["AdminDriverInfoForm"]["tmp_name"]["driverLicUrl"] != "") {
                $model->driverLicUrl = UtilsHelper::uploadFile($model, "driverLicUrl", param("drivesPath"));
            }
            if($model->validate()){
                $model->save();  
                user()->setFlash('message', $item ? "修改司机认证信息成功" : "添加司机认证信息成功");
                $this->redirect("/drives/index");
            }
        }
        $this->render("drivesInfo",compact('model',"item","carsArray"));
    }
}

