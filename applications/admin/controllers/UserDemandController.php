<?php

/**
 * 需求处理控制器
 * @author zhangye
 * @time 2017年9月4日
 * @email zhangy@pcbdoor.com
 */
class UserDemandController extends Controller{


    /**
     * 列表页
     * @time  2017年9月11日10:29:51
     */
    public function actionList(){
        $model = new UserDemandForm();

        if(!empty($_GET['UserDemandForm'])){
            $model->attributes = $_GET['UserDemandForm'];
        }
        $data = $model->search();
        $vo = $data['datas'];
        //将收发货地改为市区
        foreach ($vo as $key => &$value){
            $value['loadMsg'] = $this->getCityMsg($value['loadMsg']);
            $value['unloadMsg'] = $this->getCityMsg($value['unloadMsg']);
        }
        $pager = $data['pager'];
        $this->render('index',compact(array('model','vo','pager')));
    }
    /**
     * 编辑需求
     * @time 2017年9月5日
     */
    public function actionCheckDemand(){
        $dId = request('dId');
        $demandObj = UserDemand::model()->findByPk($dId);
        if(empty($demandObj)){
            user()->setFlash('message', '需求不存在');
            $this->redirect('/UserDemand/List');
        }
        $userInfo = User::model()->findByPk($demandObj['userId']);
        $model = new UserDemandForm();
        $model->attributes = $demandObj;

        $load_pca = '';
        $unload_pca = '';
        //处理装货地址
        if(!empty($model->loadMsg)){
            $area = $this->dealLoadMsg($model->loadMsg,false);
            $load_pca = Areas::model()->getAreaName($area["0"],$area["1"],$area["2"]);
            $model->load_provinceId = $area["0"];
            $model->load_cityId = $area["1"];
            $model->load_areaId = $area["2"];
            $model->load_descArea = $this->dealLoadMsg($model->loadMsg,true);
        }
        //处理卸货地址
        if(!empty($model->unloadMsg)){
            $un_area = $this->dealLoadMsg($model->unloadMsg,false);
            $unload_pca = Areas::model()->getAreaName($un_area["0"],$un_area["1"],$un_area["2"]);
            $model->unload_provinceId = $un_area["0"];
            $model->unload_cityId = $un_area["1"];
            $model->unload_areaId = $un_area["2"];
            $model->unload_descArea = $this->dealLoadMsg($model->unloadMsg,true);
        }

        if(!empty($model->itemType)){
            $item = ItemType::model()->findByName($model->itemType);
            $model->itemType = $item['id'];
        }

        $imgArr = DemandImg::model()->findByDemandId($dId);
        $imgModel = new DemandImgForm();

        if(!empty($imgArr)){
            $i = 1;
            foreach ($imgArr as $key => $value){
                $img = 'img'.$i;
                $imgModel->$img = $value['imgUrl'];
                $i++;
            }
        }
        if($_POST){
            if (!empty($_FILES["DemandImgForm"]["tmp_name"]["img1"])) {
                //todo 更新img1图片
                $id = $imgArr[0];
                $imgUrl = UtilsHelper::uploadFile($imgModel, "img1", param("goodsPath"));
                DemandImg::model()->updateByPk($id['id'],array('imgUrl'=>$imgUrl,'createTime'=>date('Y-m-d H:i:s')));
            }
            if (!empty($_FILES["DemandImgForm"]["tmp_name"]["img2"])) {
                //todo 更新img2图片
                $id = $imgArr[1];
                $imgUrl = UtilsHelper::uploadFile($imgModel, "img2", param("goodsPath"));
                DemandImg::model()->updateByPk($id['id'],array('imgUrl'=>$imgUrl,'createTime'=>date('Y-m-d H:i:s')));
            }

            if (!empty($_FILES["DemandImgForm"]["tmp_name"]["img3"])) {
                //todo 更新img3图片
                $id = $imgArr[2];
                $imgUrl = UtilsHelper::uploadFile($imgModel, "img3", param("goodsPath"));
                DemandImg::model()->updateByPk($id['id'],array('imgUrl'=>$imgUrl,'createTime'=>date('Y-m-d H:i:s')));
            }
            $service = DemandService::getInstance();
            $result = $service->editDemand($_REQUEST,$model);
            if($result['state'] == 1){
                //todo 记录日志
                user()->setFlash('message', '修改成功');
                $this->redirect('/UserDemand/List');
            }
        }
        $this->render('edit',compact('model','imgModel','load_pca','unload_pca','area','userInfo'));
    }

    /**
     * 添加报价页
     * @time 2017年10月25日09:17:58
     */
    public function actionAddDemandPrice(){

        $dId = request('dId');
        $demandObj = UserDemand::model()->findByPk($dId);
        $userInfo = User::model()->findByPk($demandObj['userId']);

        $model = new UserDemandForm();
        $model->attributes = $demandObj;
        $model->loadMsg = $this->getCityMsg($model->loadMsg);
        $model->unloadMsg = $this->getCityMsg($model->unloadMsg);
        $imgArr = DemandImg::model()->findByDemandId($dId);
        $imgModel = new DemandImgForm();

        if(!empty($imgArr)){
            $i = 1;
            foreach ($imgArr as $key => $value){
                $img = 'img'.$i;
                $imgModel->$img = $value['imgUrl'];
                $i++;
            }
        }

        $vehicleModel = new VehicleForm();

        $costModel = Cost::model()->getCostByDId($dId);

        if($demandObj['demandState'] == UserDemand::DEMAND_CHECK){
            $this->render('checkDemand',compact(array('userInfo','model','imgModel','vehicleModel','costModel')));
        }elseif($demandObj['demandState'] == UserDemand::DEMAND_DELETE){

            $this->render('deleteDemand',compact(array('userInfo','model','imgModel','vehicleModel','costModel')));
        }
    }

    /**
     * 查询车辆
     * @time 2017年10月30日09:04:51
     */

    public function actionSearchDriver(){
        $length = request('length');
        $capacity = request('capacity');
        $type = request('type');
        $frequenceCity = request('frequenceCity');

        $model = new VehicleForm();
        if(!empty($length)){
            $model->length = $length;
        }
        if(!empty($capacity)){
            $model->capacity = $capacity;
        }
        if(!empty($type)){
            $model->type = $type;
        }
        if(!empty($frequenceCity)){
            $area = Areas::model()->findByPk($frequenceCity);
            $model->frequenceCity = $area['areaName'];
        }
        $data = $model->searchAjax();
        $vehicleData = $data['datas'];
        $this->renderPartial('searchPrice',compact(array('vehicleData')));
    }

    /**
     * 添加价格
     * @time 2017年10月30日09:05:03
     */
    public function actionAddPrice(){
        $tId = request('tId');
        $model = Vehicle::model()->getVehicleDetail($tId);
        $this->renderPartial('addPrice',compact(array('model')));
    }

    /**
     * 变更价格
     * @time 2017年10月30日09:05:28
     */
    public function actionChangePrice(){
        $dId = request('demandId');
        $demandObj = UserDemand::model()->findByPk($dId);

        if(empty($demandObj)){
            user()->setFlash('message', '该需求不存在');
            $this->redirect('/UserDemand/List');
        }

        if($_POST){
            $service = DemandService::getInstance();
            $result = $service->addPrice($_REQUEST);
            if($result['state'] == 1){
                //todo 记录日志

                user()->setFlash('message', '修改成功');
                $this->redirect('/UserDemand/List');
            }else{
                $this->redirect('/UserDemand/AddDemandPrice/dId/'.$dId);
            }
        }
    }

    /**
     * 生成运单详情
     * @time 2017年9月5日
     */
    public function actionTransportDetail(){
        $dId = request('dId');
        if(empty($dId)){
            return false;
        }
        $demandObj = UserDemand::model()->findByPk($dId);
        if(empty($demandObj)){
            return false;
        }
    }

    /**
     * 将地址字串专为地区Id
     * @time 2017年9月22日14:02:46
     * @return $array array 地区Id数组
     */
    private function dealLoadMsg($loadMsg,$isDesc = false){
        if(!$isDesc){
            $loadMsgArr = explode(' ',$loadMsg);
            array_pop($loadMsgArr);
            $deep = 1;
            $array = array();
            foreach ($loadMsgArr as $key => $value){
                $item =  Areas::model()->findInfoByAreaName($value,$deep);
                $array[] = $item['aId'];
                $deep++;
            }
            return $array;
        }else{
            $loadMsgArr = explode(' ',$loadMsg);
            $desc = array_pop($loadMsgArr);
            return $desc;
        }
    }

    /**
     * 获取市级信息
     * @time 2017年10月24日11:04:38
     */
    private function getCityMsg($cityMsg){
        $city = '';
        if(empty($cityMsg)){
            return $city;
        }
        $cityMsgArr = explode(' ',$cityMsg);
        //$item =  Areas::model()->findInfoByAreaName($cityMsgArr[1],2);
        $city = $cityMsgArr[1];
        return $city;
    }

    /**
     * 取消需求
     * @time 2017年10月26日15:44:29
     */
    public function actionDeleteDemand(){
        $dId = request('dId');
        $demandObj = UserDemand::model()->findByPk($dId);
        if(empty($demandObj)){
            user()->setFlash('message', '该需求不存在');
            $this->redirect('/UserDemand/AddDemandPrice/dId/'.$dId);
        }
        UserDemand::model()->updateByPk($dId,array('demandState'=>UserDemand::DEMAND_DELETE));
        user()->setFlash('message', '取消成功');
        $this->redirect('/UserDemand/List');
    }

}