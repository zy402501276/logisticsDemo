<?php

/**
 * 线路(报价)管理
 */
class RouterController extends Controller {

    public function actionIndex() {
        $model = new RouterForm();
        if (isset($_GET['RouterForm'])) {
            $model->attributes = $_GET['RouterForm'];
        }
        if (!empty($_GET['RouterForm']['companyName'])) {
            $company = Company::model()->findByName($_GET['RouterForm']['companyName']);
            if($company){
                $userId = UtilsHelper::extractColumnFromArray($company, 'userId');
                $model->userId = $userId;
            }else{
                $model->userId = 0;
            }
        }
        if (!empty($_GET['RouterForm']['vehicleState'])) {
            $vehicle = RouterVehicle::model()->findByCostState($_GET['RouterForm']['vehicleState']);
            if($vehicle){
                $routerId = UtilsHelper::extractColumnFromArray($vehicle, 'routerId');
                $model->id = $routerId;
            }else{
                $model->id = 0;
            }
        }
        $data = $model->search();
        $list = $data['datas'];
        $pager = $data['pager'];
        $vehicleList = array();
        $companyList = array();
        $infoList = array();
        if ($list) {
            $ids = UtilsHelper::extractColumnFromArray($list, 'id');
            $vehicleList = RouterVehicle::model()->getVehicleByRouterId($ids);
            $vehicleList = $vehicleList ? UtilsHelper::groupByKey($vehicleList, 'routerId', TRUE) : array();
            $userIds = UtilsHelper::extractColumnFromArray($list, 'userId');
            $companyList = Company::model()->findByUserIds($userIds);
            $companyList = $companyList ? UtilsHelper::groupByKey($companyList, 'userId') : array();
            $infoList = RouterInfo::model()->getInfoByRouterId($ids);
            $infoList = $infoList ? UtilsHelper::groupByKey($infoList, 'routerId', TRUE) : array();
        }
        $this->render('index', compact('model', 'list', 'pager', 'vehicleList', 'companyList', 'infoList'));
    }

    public function actionCost() {
        $id = request('id');
        $vehicleList = RouterVehicle::model()->getVehicleByRouterId($id);
        $this->renderPartial("_cost", compact('vehicleList'));
        $this->outputScript();
        app()->end();
    }

    public function actionConfirmCost() {
        $costArr = request('cost');
        if ($costArr) {
            foreach ($costArr as $k => $c) {
                if ($c) {
                    RouterVehicle::model()->updateByPk($k, array('cost' => $c, 'costState' => RouterVehicle::COST_CHECK));
                }
            }
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

}
