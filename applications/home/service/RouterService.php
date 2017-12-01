<?php
/**
 * 路线逻辑service层
 * @author zhangye
 * @time 2017年11月2日13:21:59
 */
class RouterService {
    private static $_instance = null; //声明一个实例来进行统一访问

    private function __construct(){}  //防止初始化

    private function __clone(){}  //防止克隆

    //内部产生一个实例
    public static function getInstance(){
        if(is_null(SELF::$_instance) || !isset(SELF::$_instance)){
            SELF::$_instance = new SELF();
        }
        return SELF::$_instance;
    }

    /**
     * 新增一条路线
     * @time 2017年11月2日13:22:55
     * @param $request array
     * @param $model  OBJ RouterForm的对象
     * @return array
     */
    public function addRouter($request,$model){
        $tranSaction = Yii::app()->db->beginTranSaction();
        try{

            $routerDatas = $request['RouterForm'];
            if(!empty($routerDatas['name'])){
                $model->name = trim($routerDatas['name']);
            }
            if(!empty($request['type'])){
                $model->type = $request['type'];
            }
            if(!empty($model->id)){
                $model->updateTime = date('Y-m-d H:i:s');
            }else{
                $model->createTime = $model->updateTime = date('Y-m-d H:i:s');
            }
            $model->userId = user()->getId();
//            $model->scenario = 'add';

            if($model->validate()){
                $model->save();
            }else{
                throw new Exception($model->getFirstError());
            }
            $routerId  = Yii::app()->db->getLastInsertID();
            //todo处理线路排序
            //删除原先的路线
            RouterInfo::model()->deleteOldRouter($routerId);
            $dataSize = sizeof($request['addressId']);

            for($i = 0;$i< $dataSize ;$i++){
                $model = new RouterInfoForm();
                $model->routerId = $routerId;
                if($i == 0){
                    $model->type = RouterInfo::ROUTER_BEGIN;
                }elseif($i == $dataSize-1){
                    $model->type =  RouterInfo::ROUTER_FINISH;
                }else{
                    $model->type = RouterInfo::ROUTER_MIDDLE;
                }
                $model->addressId = $request['addressId'][$i];
                $model->routerName = $routerDatas['name'];
                $addressInfo = Address::model()->findByPk($request['addressId'][$i]);
                $model->tag = $addressInfo['tag'];
                $model->addressName = $addressInfo['detail'];
                $model->sort = $i+1;
                if($model->validate()){
                    $model->save();
                }else{
                    throw new Exception($model->getFirstError());
                    break;
                }
            }

            $tranSaction->commit();
            return ['state' => 1 ,'message'=>'修改成功'];
        }catch (Exception $e){
            $tranSaction->rollBack();
            return ['state' => 0 ,'message'=>$e->getMessage()];
        }
    }
}