<?php
/**
 * 路线模块控制器层
 * @author zhangye
 * @time 2017年11月2日13:14:42
 */
class RouterController extends Controller{
    public function init() {
        parent::init();
        if(!user()->getId()) {
            $this->redirect("/index/index");
        }
        if(!User::checkFirst()){
            $this->redirect("/manage/declare");
        }
    }

    /**
     * 新增/修改线路
     * @time 2017年11月2日13:14:06
     */
    public function actionEditRouter(){
        $id = request('id');
        $router = Router::model()->findByPk($id);
        $model = new RouterForm();
        $model->attributes = $router;
        if($_POST){
            $service = RouterService::getInstance();
            $result = $service->addRouter($_REQUEST,$model);
            if($result['state'] == 1){
                //todo返回列表页
                user()->setFlash('message', '修改成功');
                $this->redirect("/router/RouterList");
            }
        }
        $this->render('edit',compact(array('model')));
    }
    /**
     * 车辆列表
     * @time 2017年11月9日19:52:42
     */
    public function actionVehicleList(){
        $routerId = request('id');
        $vehicleArr = RouterVehicle::model()->getVehicleByRouterId($routerId);

        if(!empty($vehicleArr)){
            $this->renderPartial('vehicleList',compact('vehicleArr'));
        }
    }

    /**
     * 添加运输货车
     * @time 2017年11月2日15:02:13
     */
    public function actionAddVehicle(){
        $type = request('type');
        $weight = request('weight');
        $length = request('length');
        $routerId = request('id');

        $check = RouterVehicle::model()->findVehicle($type,$length,$weight,$routerId);
        if(!$check){
            echo json_encode(array('code'=> 0,'message'=>'无法添加重复车型'));exit;
        }
        $router = Router::model()->findByPk($routerId);

        $model = new RouterVehicleForm();
        $model->type = $type ;
        $model->length = $length;
        $model->weight = $weight;
        $model->routerId = $routerId;
        $model->routerName = RouterInfo::model()->getRouterName($routerId);
        $model->routerDesc = Router::getRouterType($router['type']);

        if($model->validate()){
            $model->save();
        }else{
            echo json_encode(array('code'=> 0,'message'=>'添加错误')) ;exit;
        }
        //$model = $model->attributes;
        echo json_encode($this->renderPartial('addVehicle',compact('model'), true));exit;
    }

    /**
     * 删除运输货车
     * @time 2017年11月9日19:26:52
     */
        public function actionDelVehicle(){
        $id = request('id');
        RouterVehicle::model()->updateByPk($id,array('state'=>RouterVehicle::STATE_OFF,'updateTime'=>date('Y-m-d H:i:s')));

    }

    /**
     * 线路列表
     * @time 2017年11月2日16:19:56
     */
    public function actionRouterList(){
        $model = new RouterForm();
        if(!empty($_GET['RouterForm'])){
            $model->attributes = $_GET['RouterForm'];
        }
        $data = $model->search();
        $vo = $data['datas'];
        $pager = $data['pager'];

        $typeArr = VehicleType::getTypeArr();//车辆类型
        $lengthArr = VehicleLength::getTypeArr();//车辆长度类型
        $weightArr = VehicleWeight::getTypeArr();//车辆重量类型

        $this->render('list',compact(array('model','vo','pager','typeArr','lengthArr','weightArr')));
    }

    /**
     * 新增线路-线路搜索界面
     * @time 2017年11月3日17:02:10
     */
    public function actionSearchAddress(){
        $detail = request('detail');
        $result = Address::model()->getAddress($detail);
        if(!empty($result)){
            $this->renderPartial('searchRouter',compact('result'));
            $this->outputScript();
        }
        return true;
    }

    /**
     * 添加路线
     * @time 2017年11月9日10:00:40
     */
    public function actionAddRouter(){
        $id = request('id');
        $type = request('type',1);
        $result = Address::model()->findByPk($id);
        if(!empty($result)){
            $this->renderPartial('routerInfo',compact('result','type'));
            $this->outputScript();
            app()->end();
        }
        app()->end();
    }

    /**
     * 车辆类型列表
     * @time 2017年11月2日16:24:073
     */
    public function actionRouterInfoList(){
        $routerId = request('routerId');
        $routerVehicle = RouterVehicle::model()->getVehicleByRouterId($routerId);
    }

    /**
     * 删除路线
     * @time 2017年11月2日16:31:55
     */
    public function actionDelRouter(){
        $routerId = request('id');
        Router::model()->updateByPk($routerId,array('state'=>Router::STATE_OFF,'updateTime'=>date('Y-m-d H:i:s')));
        echo json_encode(array("state"=>1)); exit;
    }

    /**
     * 确认价格、删除车辆
     * @time 2017年11月2日16:58:18
     */
    public function actionDelRouterVehicle(){
        $vehicleId = request('id');
        $operate = request('operate');
        $vehicleInfo = RouterVehicle::model()->findByPk($vehicleId);
        switch ($operate){
            case 'del':
                if(empty($vehicleInfo) || isset($vehicleInfo['costState']) != RouterVehicle::COST_UNCHECK ){
                    echo json_encode(array("state"=>1,"message"=>'无法删除该车辆')); exit;
                }
                RouterVehicle::model()->updateByPk($vehicleId,array('state'=>RouterVehicle::STATE_OFF,'updateTime'=>date('Y-m-d H:i:s')));
                echo json_encode(array("state"=>1)); exit;
                break;
            case 'check';
                RouterVehicle::model()->updateByPk($vehicleId,array('costState'=>RouterVehicle::COST_CHECKED,'updateTime'=>date('Y-m-d H:i:s')));
                echo json_encode(array("state"=>1)); exit;
        }

    }

    /**
     * 重新报价
     * @time 2017年11月2日17:08:48
     */
    public function actionRefreshCost(){
        $vehicleId = request('id');
        $reason = request('reason');
        $vehicleInfo = RouterVehicle::model()->findByPk($vehicleId);
        if($_GET){
            $model = new RouterVehicleForm();
            $model->attributes = $vehicleInfo;
            $model->costState = RouterVehicle::COST_REFRESH;
            $model->costAdvice = $reason;
            $model->updateTime = date('Y-m-d H:i:s');
            if($model->validate()){
                $model->save();
            }else{
                echo json_encode(array("state"=>0)); exit;
            }
        }
        echo json_encode(array("state"=>1)); exit;
    }
}