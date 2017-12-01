<?php

/**
 * 用户信息管理模块控制器
 * @author zhangye
 * @time 2017年11月13日10:48:08
 */
class ManageController extends Controller{
            public function init() {
                parent::init();
                    if(!user()->getId()) {
                        $this->redirect("/index/index");
                    }
            }

    /**
     * 管理页
     * @time 2017年11月13日10:48:38
     */
    public function actionIndex(){
        $userInfo = User::model()->findByPk(user()->getId());
        $infomation = Infomation::model()->findByUserId(user()->getId(),Infomation::ISREAD_NO);

        $model = new OrdersForm(); //物流清单
        $model->timeType = OrdersForm::TIME_DAY;
        
        //查询公告
        $dynamicItem  = Dynamic::model()->findAll();

        $datas = $model->search();
        $data = $datas['datas'];
        //数据汇总
        $transTimes = Orders::model()->getTransTimes();
        $sumWeight = Orders::model()->getSumWeight();
        $sumOrders = Orders::model()->getSumOrders();
        $sumlates = Orders::model()->getLateTimes();

        //常用货物
        $goodsArray = Goods::model()->getFreGoods(4);

        //广告
        $slidesList = Slides::model()->findAll();
        $slidesList = $slidesList ? UtilsHelper::groupByKey($slidesList, 'pos') : array();
        $this->render('index',compact('userInfo','infomation','data','transTimes','sumWeight','sumOrders','sumlates','goodsArray','dynamicItem', 'slidesList'));
    }

    /**
     * 物流单
     * @time 2017年11月13日15:00:14
     */
    public function actionOrderList(){
        $type = request('type',1);
        $model = new OrdersForm();
        $model->timeType = $type;
        $datas = $model->search();
        $data = $datas['datas'];
        $this->renderPartial('ordersList',compact('data'));
    }
    /**
     * 物流单
     * @time 2017年11月13日15:00:14
     */
    public function actionDataList(){
        $type = request('type',1);
        $transTimes = Orders::model()->getTransTimes($type);
        $sumWeight = Orders::model()->getSumWeight($type);
        $sumOrders = Orders::model()->getSumOrders($type);
        $sumlates = Orders::model()->getLateTimes($type);

        $transTimes = $transTimes?$transTimes:0;
        $sumWeight = $sumWeight?$sumWeight:0;
        $sumOrders = $sumOrders?$sumOrders:0;
        $sumlates = $sumlates?$sumlates:0;
        echo json_encode(array('transTimes'=>$transTimes,'sumWeight'=>$sumWeight,'sumOrders'=>$sumOrders,'sumlates'=>$sumlates));exit;
    }
    /**
     * 用户首次登入进入改业
     * @time 2017年11月20日09:21:38
     */
    public function actionDeclare(){
        $company = Company::model()->findByUserId(User()->getId());
        $model = new CompanyForm();
        $model->attributes = $company;
        $detail = '';
        if (!empty($company)) {
            $detail .= Areas::model()->getAreaName($model->provinceId, $model->cityId, $model->areaId);
        }
        if($_POST){
            $service = CompanyService::getInstance();
            $result = $service->editCompany($model, $_POST);
            if($result['state']){
                $user = User::model()->findByPk(user()->getId());
                $service = UserService::getInstance();
                $res = $service->getUserInfo($user['pId']);
                if($res['code']){
                    User::model()->updateByPk(user()->getId(),array('isFirst'=>User::FIRST_YES,'email'=>$res['obj']['email'],'mobile'=>$res['obj']['mobile'],'updateTime'=>date('Y-m-d H:i:s')));
                }else{
                    User::model()->updateByPk(user()->getId(),array('isFirst'=>User::FIRST_YES,'updateTime'=>date('Y-m-d H:i:s')));
                }
                $this->redirect("/manage/index");
            }
        }
        $this->render('enterprise',compact(array('model','detail')));
    }

}