<?php

class CarsController extends Controller {

    public function actionIndex() {
        $model = new AdminVehicleInfoForm();
        if (isset($_GET["AdminVehicleInfoForm"])) {
            $model->attributes = $_GET["AdminVehicleInfoForm"];
        }
        if (isset($_GET['page'])) {
            $model->page = $_GET['page'];
        }
        $dataProvider = $model->search();
        $datas = $dataProvider["datas"];
        $pager = $dataProvider["pager"];
        $this->render('index', compact("model", "datas", "pager"));
    }

    /**
     * 新增车辆
     */
    public function actionEdit() {
        $id = request('id');
        $reUrl = user()->getFlash('reUrl');
        if (!$reUrl) {
            $reUrl = "/cars/index";
        }
        if (isset($_SERVER["HTTP_REFERER"])) {
            if (!strpos($_SERVER["HTTP_REFERER"], 'cars/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        $model = new AdminVehicleInfoForm();
        $typeItem = VehicleType::model()->getTypeArr();
        $weightItem = VehicleWeight::model()->getTypeArr();
        $lengthItem = VehicleLength::model()->getTypeArr();
        if ($id) {
            $item = VehicleInfo::model()->findByPk($id);
            $model->attributes = $item;
            $drivesItem = Drives::model()->findByPk($model["dId"]);
        }
        if (isset($_POST["AdminVehicleInfoForm"])) {
            $model->attributes = $_POST["AdminVehicleInfoForm"];
            if (!$id) {
                $model->dId = $_POST["dId"];
            }
            $model->deliveryStatus = VehicleInfo::DELIVERYSTATUS_IDLE;
            $model->vehicleType = VehicleInfo::STATE_YES;
            $model->createTime = date("Y-m-d H:i:s");
            if (isset($_FILES["AdminVehicleInfoForm"]["tmp_name"]["vehiclePhoto"]) && $_FILES["AdminVehicleInfoForm"]["tmp_name"]["vehiclePhoto"] != "") {
                $model->vehiclePhoto = UtilsHelper::uploadFile($model, "vehiclePhoto", param("drivesPath"));
            }
            if ($model->validate()) {
                $model->save();
                user()->setFlash('message', $id ? "修改车辆信息成功" : "新增车辆信息成功");
                $this->redirect("/cars/index");
            }
        }
        $this->render("edit", compact("model", "typeItem", "weightItem", "lengthItem", "id", "drivesItem"));
    }

    /**
     * 正常OR停用
     */
    public function actionUpdateState() {
        $vehicleType = request('vehicleType');
        $id = request('id');
        VehicleInfo::model()->updateByPk($id, array('vehicleType' => $vehicleType));
        user()->setFlash('message', "修改状态成功");
        $this->redirect("/cars/index");
    }

    /**
     * 查找司机
     */
    public function actionFindDrivrsName() {
        $drivesName = request("drivesName");
        $drivesItem = Drives::model()->findDrivesNameAll($drivesName);
        $dIdItem = VehicleInfo::model()->findAll();
        if ($dIdItem) {
            foreach ($dIdItem as $val) {
                $temp[] = $val["dId"];
            }
        } else {
            $temp[] = "";
        }
        if ($drivesItem) {
            foreach ($drivesItem as $key => $val) {
                if (in_array($val["dId"], $temp)) {
                    unset($drivesItem[$key]);
                }
            }
        }
        if ($drivesItem) {
            $html = '<span><i class="not-null">*</i>搜索结果：</span>';
            $html .='<select class="demo-select w20" name="AdminVehicleInfoForm[dId]" id="AdminVehicleInfoForm_dId">';
            $html .='<option value="">请选择</option>';
            foreach ($drivesItem as $val) {
                $html .='<option value=' . $val["dId"] . '>' . $val["driverName"] . '</option>';
            }
            $html .='</select>';
            $html .='<span class="sure-info" style="color:red"></span>';
        } else {
            $html = "";
        }
        echo $html;
    }

    /**
     * 驾照类型列表
     */
    public function actionCarsIndex() {
        $model = new AdminCarTypeForm();
        if (isset($_GET["AdminCarTypeForm"])) {
            $model->attributes = $_GET["AdminCarTypeForm"];
        }
        if (isset($_GET['page'])) {
            $model->page = $_GET['page'];
        }
        $model->state = CarType::STATE_VALID;
        $dataProvider = $model->search();
        $datas = $dataProvider["datas"];
        $pager = $dataProvider["pager"];
        $this->render('carsIndex', compact("model", "datas", "pager"));
    }

    /**
     * 新增OR修改驾照类型
     */
    public function actionCarsType() {
        $id = request("id");
        $model = new AdminCarTypeForm();
        if (isset($_POST["AdminCarTypeForm"])) {
            $model->attributes = $_POST["AdminCarTypeForm"];
            $model->state = CarType::STATE_VALID;
            $model->createTime = date("Y-m-d H:i:s");
            if ($model->validate()) {
                $model->save();
                user()->setFlash('message', $id ? "修改驾照类型信息成功" : "新增驾照类型信息成功");
                $this->redirect("/cars/carsIndex");
            }
        }
        $this->render('carsType', compact("model", "id"));
    }

    /**
     * 删除
     */
    public function actionDelCarsType() {
        $id = request("id");
        carType::model()->updateByPk($id, array('state' => carType::STATE_INVALID));
        echo jsonEncode(array("state" => 1, "message" => "删除成功"));
        app()->end();
    }

    /**
     * 车辆重量
     */
    public function actionWeight() {
        $model = new VehicleWeightForm();
        $model->state = VehicleWeight::STATE_ON;
        $model->size = -1;
        $data = $model->search();
        $list = $data['datas'];
        $pager = $data['pager'];
        $this->render('weight', compact('model', 'list', 'pager'));
    }

    /**
     * 新增重量
     */
    public function actionAddWeight() {
        if (Yii::app()->request->isPostRequest) {
            if (empty($_POST['name'])) {
                echo jsonEncode(array('state' => 0, 'msg' => '重量未填写'));
                app()->end();
            }
            $weight = VehicleWeight::model()->findByName($_POST['name']);
            if ($weight) {
                echo jsonEncode(array('state' => 0, 'msg' => '重量已存在'));
                app()->end();
            }
            $model = new VehicleWeightForm();
            $model->name = $_POST['name'];
            $model->state = VehicleWeight::STATE_ON;
            $model->createTime = now();
            $model->updateTime = now();
            if ($model->validate()) {
                $model->save();
                echo jsonEncode(array('state' => 1));
                app()->end();
            }
        }
    }

    /**
     * 删除重量
     */
    public function actionDelWeight() {
        $id = request('id');
        if ($id) {
            VehicleWeight::model()->updateByPk($id, array('state' => VehicleWeight::STATE_OFF));
        }
        $this->redirect("/cars/weight");
    }

    /**
     * 车辆长度
     */
    public function actionLength() {
        $model = new VehicleLengthForm();
        $model->state = VehicleLength::STATE_ON;
        $model->size = -1;
        $data = $model->search();
        $list = $data['datas'];
        $pager = $data['pager'];
        $this->render('length', compact('model', 'list', 'pager'));
    }

    /**
     * 新增长度
     */
    public function actionAddLength() {
        if (Yii::app()->request->isPostRequest) {
            if (empty($_POST['name'])) {
                echo jsonEncode(array('state' => 0, 'msg' => '重量未填写'));
                app()->end();
            }
            $weight = VehicleLength::model()->findByName($_POST['name']);
            if ($weight) {
                echo jsonEncode(array('state' => 0, 'msg' => '重量已存在'));
                app()->end();
            }
            $model = new VehicleLengthForm();
            $model->name = $_POST['name'];
            $model->state = VehicleLength::STATE_ON;
            $model->createTime = now();
            $model->updateTime = now();
            if ($model->validate()) {
                $model->save();
                echo jsonEncode(array('state' => 1));
                app()->end();
            }
        }
    }

    /**
     * 删除长度
     */
    public function actionDelLength() {
        $id = request('id');
        if ($id) {
            VehicleLength::model()->updateByPk($id, array('state' => VehicleLength::STATE_OFF));
        }
        $this->redirect("/cars/length");
    }

    /**
     * 车辆长度
     */
    public function actionType() {
        $model = new VehicleTypeForm();
        $model->state = VehicleType::STATE_ON;
        $model->size = -1;
        $data = $model->search();
        $list = $data['datas'];
        $pager = $data['pager'];
        $this->render('type', compact('model', 'list', 'pager'));
    }

    /**
     * 新增长度
     */
    public function actionAddType() {
        if (Yii::app()->request->isPostRequest) {
            if (empty($_POST['name'])) {
                echo jsonEncode(array('state' => 0, 'msg' => '类型未填写'));
                app()->end();
            }
            $weight = VehicleType::model()->findByName($_POST['name']);
            if ($weight) {
                echo jsonEncode(array('state' => 0, 'msg' => '类型已存在'));
                app()->end();
            }
            $model = new VehicleTypeForm();
            $model->name = $_POST['name'];
            $model->state = VehicleType::STATE_ON;
            $model->createTime = now();
            $model->updateTime = now();
            if ($model->validate()) {
                $model->save();
                echo jsonEncode(array('state' => 1));
                app()->end();
            }
        }
    }

    /**
     * 删除长度
     */
    public function actionDelType() {
        $id = request('id');
        if ($id) {
            VehicleType::model()->updateByPk($id, array('state' => VehicleType::STATE_OFF));
        }
        $this->redirect("/cars/type");
    }

}
