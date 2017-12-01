<?php

/**
 * 地址管理控制器
 * @time 2017年11月1日19:55:53
 * @author zhangye
 */
class AddressController extends Controller{
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
     * 新增地址
     * @time 2017年11月1日19:56:12
     */
    public function actionEdit(){
        $id = request('id');
        $addressObj = Address::model()->findByPk($id);
        $model = new AddressForm();
        $model->attributes = $addressObj;

        $detail = '';
        if(!empty($model->detail)){
           $detail .= Areas::model()->getAreaName($model->provinceId,$model->cityId,$model->areaId);
        }

        //收货人地址
        $receiverArr = Receiver::model()->findByAddressId($id);
        if($_POST){
            $service = AddressService::getInstance();
            $result = $service->addAddress($_REQUEST,$model);
            if($result['state'] == 1){
                //todo返回列表页
                user()->setFlash('message', '修改成功');
                $this->redirect("/address/list");
            }
        }
        $this->render('edit',compact('model','receiverArr','detail'));
    }

    /**
     * 地址列表页
     * @time 2017年11月2日11:13:02
     */
    public function actionList(){
        $model = new AddressForm();
        if(!empty($_GET['AddressForm'])){
            $model->attributes = $_GET['AddressForm'];
        }
        $model->page = request('page', 1);
        $data = $model->search();
        $vo = $data['datas'];
        $pager = $data['pager'];
        $this->render('list',compact(array('model','vo','pager')));
    }

    /**
     * 删除地址
     * @time 2017年11月2日11:37:55
     */
    public function actionDelAddress(){
        $id = request('id');
        $result = Address::model()->findByPk($id);
        if(empty($result)){
            user()->setFlash('message', '记录不存在');
            $this->redirect('/Address/List');
        }
        Address::model()->updateByPk($id,array('state'=>Address::STATE_OFF));
        user()->setFlash('message', '删除成功');
        $this->redirect('/Address/List');
    }

}