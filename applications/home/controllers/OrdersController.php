<?php

/**
 * 订单模块控制器
 * @author zhangye
 * @time 2017年11月2日18:48:283
 */
class OrdersController extends Controller{

    /**
     * 新增货物类型-自定义
     */
    CONST ADD_TYPE_COSTOME = 1;
    /**
     * 新增货物类型-模板
     */
    CONST ADD_TYPE_MODEL = 2;

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
     * 新增，修改订单
     * @time 2017年11月2日18:51:47
     */
    public function actionEdit(){

        $id = request('id');
        $orderObj = Orders::model()->findByPk($id);
        $model = new OrdersForm();
        $model->attributes = $orderObj;

        $goodsId  = request('goodsId');
        $freGoods = array();
        if(!empty($goodsId)){
            $result = Goods::model()->findByPk($goodsId);
            $freGoods = array($result);
        }
        $again = request('again',0);
        if($again){
            $goodsIds = OrderGoods::model()->getByGoodsId($id);
            foreach ($goodsIds as $value){
                $result = Goods::model()->findByPk($value);
                $freGoods[] = $result;
            }
        }
        if($_POST){
            $service = OrdersService::getInstance();
            $result = $service->addOrder($_REQUEST,$model);
            if($result['state'] == 1){
                user()->setFlash('message', '修改成功');
                $this->redirect('/Orders/list');
            }
        }
        if(!empty($model->startTime)){
            $model->startDay = date('Y-m-d',strtotime($model->startTime));
            $model->startT = date('H:m',strtotime($model->startTime));
            $model->endT = date('H:m',strtotime($model->endTime));
        }
        if(!empty($model->deliveryTime)){
            $model->delivertDay = date('Y-m-d',strtotime($model->deliveryTime));
            $model->deliverT = date('H:m',strtotime($model->deliveryTime));
        }

        $goodsArr = Goods::getGoodsArr();//货物下拉框
        $goodsTypeArr = GoodsType::getGoodsTypeArr();//货物类型下拉框
        $palletsNum = PalletNum::getPalletNumArr();//托盘个数下拉框
        $timeArr = Orders::getTime();//时间


        $this->render('edit',compact(array('model','goodsModel','goodsArr','goodsTypeArr','palletsNum','timeArr','freGoods')));
    }

    /**
     * 物流单列表
     * @time 2017年11月3日13:50:41
     */
    public function actionList(){
        $model = new OrdersForm();
        if (!empty($_GET['OrdersForm'])) {
            $model->attributes = $_GET['OrdersForm'];
        }
        $model->page = request('page', 1);
        $data = $model->search();
        $vo = $data['datas'];
        $pager = $data['pager'];
        $userInfo = User::model()->findByPk(user()->getId());
        $this->render('list', compact(array('model', 'vo', 'pager', 'userInfo')));
    }
    /**
     * 异步获取路线状况
     * @time 2017年11月6日17:51:06
     */
    public function actionGetRouterInfo(){
        $routerId = request('routerId');
        $routerModel = Router::model()->findByPk($routerId);
        $this->renderPartial('chooseRouter',compact(array('routerModel')));
    }

    /**
     * 异步获取每条路线的接收人
     * @time 2017年11月8日10:46:54
     */
    public function actionAjaxGetReceiver(){
        $routerId = request('routerId');
        $routerInfo = RouterInfo::model()->getInfoByRouterId($routerId);
        $this->renderPartial('receiver', compact(array('routerInfo')));
    }


    /**
     * 异步新增货物
     */
    public function actionAjaxAddGoods(){
        $type = request('type',1);
        $modelId = request('modelId');


        $goodsArr = Goods::getGoodsArr();//货物下拉框
        $goodsTypeArr = GoodsType::getGoodsTypeArr();//货物类型下拉框
        $palletsNum = PalletNum::getPalletNumArr();//托盘个数下拉框

        $goodsInfo = Goods::model()->findByPk($modelId);
        $model = new GoodsForm();
        $model->attributes = $goodsInfo;

        $this->renderPartial('addGoodsModel',compact(array('model','goodsArr','goodsTypeArr','palletsNum')));
        $this->outputScript();
    }

    /**
     * 物流单详情
     * @time 2017年11月14日13:36:41
     */
    public function actionDetail(){
        $id = request('id');
        if(empty($id)){
            return false;
        }
        $orderInfo = Orders::model()->findByPk($id);
        $routerInfo = Router::model()->findByPk($orderInfo['routerId']);
        $vehicleArray = RouterVehicle::model()->getVehicleByRouterId($orderInfo['routerId']);
        $receivers = OrderReceiver::model()->getTransState($id);
        $goods = OrderGoods::model()->getByOrderId($id);
        $vehicleDetail = OrderVehicle::model()->findDriverByOrder($id);

        $this->render('detail',compact('orderInfo','routerInfo','vehicleArray','receivers','goods','vehicleDetail'));
    }

    /**
     * 催单
     * @time 2017年11月24日09:58:30
     */
    public function actionRemind(){
        $id = request('id');
        Orders::model()->updateByPk($id,array('isRemind'=>Orders::REMIND_YES));
        user()->setFlash('message', '催单成功');
        $this->redirect('/Orders/list');
    }
}