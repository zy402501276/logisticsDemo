<?php
/**
 * 地址逻辑service层
 * @author zhangye
 * @time 2017年11月1日19:51:003
 */
class AddressService {
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
     * 新增一条地址
     * @time 2017年11月1日19:51:45
     * @param $request array
     * @param $model  OBJ AddressForm的对象
     * @return array
     */
    public function addAddress($request,$model){
        $tranSaction = Yii::app()->db->beginTranSaction();
        try{
            $addressData = $request['AddressForm'];
            if(!empty($addressData['provinceId']) && !empty($addressData['cityId']) && !empty($addressData['areaId'])){
                $model->provinceId = $addressData['provinceId'];
                $model->cityId = $addressData['cityId'];
                $model->areaId = $addressData['areaId'];
                $model->detail = Areas::model()->getAreaName($model->provinceId,$model->cityId, $model->areaId).' '.trim($addressData['address']);
            }
            if(!empty($request['location_map'])){
                $location = explode(",",$request['location_map']);
                $model->longitude = $location[0];
                $model->latitude = $location[1];
            }
            if(!empty($addressData['address'])){
                $model->address = trim($addressData['address']);
            }
            if(!empty($addressData['companyName'])){
                $model->companyName = trim($addressData['companyName']);
            }
            if(!empty($addressData['tag'])){
                $model->tag = trim($addressData['tag']);
            }
            $model->userId = user()->getId();

            if($model->validate()){
                $model->save();
                $modelId = Yii::app()->db->getLastInsertID();
                if($modelId == 0){
                    $modelId = $model->id;
                }
            }else{
                throw new Exception($model->getFirstError());
            }
            //todo处理联系人信息
            $oldArray =  Receiver::model()->getIdByAddressId($modelId);
            if(!empty($oldArray)){
                $request['name'] = array_filter($request['name']);
                for($i = 0 ; $i< sizeof($request['name']);$i++){
                    $model = new ReceiverForm();
                    if(isset($request['ids'][$i])) {
                        $receiverInfo = Receiver::model()->findByPk($request['ids'][$i]);
                        $model->attributes = $receiverInfo;
                        $model->updateTime = date('Y-m-d H:i:s');
                    }else{
                        $receiverInfo = '';
                        $model->attributes = $receiverInfo;
                        $model->createTime = date('Y-m-d H:i:s');
                        $model->updateTime = date('Y-m-d H:i:s');
                    }
                    $model->name = $request['name'][$i];
                    $model->companyPhone = $request['companyPhone'][$i];
                    $model->areaCode = $request['areaCode'][$i];
                    $model->mobile = $request['mobile'][$i];
                    $model->job = $request['job'][$i];
                    $model->gender = $request['gender'][$i];
                    $model->state = Receiver::STATE_ON;
                    $model->addressId = $modelId;
                    if($model->validate()){
                        $model->save();
                    }else{
                        throw new Exception($model->getFirstError());
                        break;
                    }
                }
                $deleteArr = array_diff($oldArray,$request['ids']);
                if(!empty($deleteArr)){
                    foreach ($deleteArr as $value){
                        Receiver::model()->updateByPk($value,array('state'=> 0,'updateTime' => date('Y-m-d H:i:s')));
                    }
                }
            }else{
                $receiverArr = sizeof($request['name']);
                for ($i = 0; $i < $receiverArr;$i++ ){
                    if(empty($request['name'][$i])){
                        continue;
                    }
                    $model = new ReceiverForm();
                    $model->name         = $request['name'][$i];
                    $model->companyPhone = $request['companyPhone'][$i];
                    $model->areaCode     = $request['areaCode'][$i];
                    $model->mobile       = $request['mobile'][$i];
                    $model->gender       = $request['gender'][$i];
                    $model->job          = $request['job'][$i];
                    $model->addressId    = $modelId;
                    $model->state        = Receiver::STATE_ON;
                    $model->createTime   = date('Y-m-d H:i:s');
                    $model->updateTime   = date('Y-m-d H:i:s');

                    if($model->validate()){
                        $model->save();
                    }else{
                        throw new Exception($model->getFirstError());
                        break;
                    }
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