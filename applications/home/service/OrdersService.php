<?php
/**
 * 订单逻辑service层
 * @author zhangye
 * @time 2017年11月2日13:21:59
 */
class OrdersService {
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
     * 新增订单
     * @time 2017年11月2日13:22:55
     * @param $request array
     * @param $model  OBJ OrdersForm的对象
     * @return array
     */
    public function addOrder($request,$model){
        $tranSaction = Yii::app()->db->beginTranSaction();
        try{
            $orderDatas = $request['OrdersForm'];
            if(!empty($orderDatas['routerId'])){
                $model->routerId = $orderDatas['routerId'];
                $model->startRouter = RouterInfo::getRouterPoint($orderDatas['routerId']);
                $model->endRouter = RouterInfo::getRouterPoint($orderDatas['routerId'],RouterInfo::ROUTER_FINISH);
            }
            if(!empty($orderDatas['startT']) && !empty($orderDatas['startDay'])){
               $startTime = $orderDatas['startDay'].' '.$orderDatas['startT'];
               $model->startTime = date('Y-m-d H:i:s',strtotime($startTime));
            }
            if(!empty($orderDatas['endT']) && !empty($orderDatas['startDay'])){
                $endTime = $orderDatas['startDay'].' '.$orderDatas['endT'];
                $model->endTime = date('Y-m-d H:i:s',strtotime($endTime));
            }
            if(!empty($orderDatas['delivertDay']) && !empty($orderDatas['deliverT'])){
                $deliveryTime = $orderDatas['delivertDay'].' '.$orderDatas['deliverT'];
                $model->deliveryTime = date('Y-m-d H:i:s',strtotime($deliveryTime));
            }
            if(!empty($model->id)){
                $model->updateTime = date('Y-m-d H:i:s');
            }else{
                $model->createTime = $model->updateTime = date('Y-m-d H:i:s');
                $model->orderNumber = Orders::generateOrderSn();
            }
            $model->orderState = Orders::LOGISTICS_WAIT;

            $sumvolumn = '';//总体积
            $sumweight = '';//总重量


            $model->sumWeight = $sumweight;
            $model->sumVolumn = $sumvolumn;

            $model->userId = user()->getId();
            $model->state = Orders::STATE_ON;
            $model->arrivaled = $request['area'][0];
            $receiverName = Receiver::model()->findByPk($request['receivers'][0]);
            $model->receiver = $receiverName['name'] ;
            $model->isRemind = Orders::REMIND_NO;
            if($model->validate()){
                $model->save();
                $modelId = Yii::app()->db->getLastInsertID();
            }else{
                throw new Exception($model->getFirstError());
            }
            //处理新增的需求
            if(isset($request['custome_goodsName'])){
                $size = sizeof($request['custome_goodsName']);
                for($i = 0 ;$i <$size ; $i++){
                    $orderGoods = new OrderGoodsForm();

                    if($request['custome_id'][$i]>0){
                        $orderGoods->goodsId = $request['custome_id'][$i];
                    }
                    $orderGoods->orderId = $modelId;
                    $orderGoods->goodsName = $request['custome_goodsName'][$i];
                    $orderGoods->goodsType = $request['custome_type'][$i];
                    $orderGoods->goodsWeight = $request['custome_weight'][$i];//


                    $orderGoods->goodsWidth = $request['custome_width'][$i];
                    $orderGoods->goodsLength = $request['custome_length'][$i];
                    $orderGoods->goodsHeight = $request['custome_height'][$i];

                    $sumweight += $request['custome_weight'][$i];
                    $sumvolumn += $request['custome_width'][$i]*$request['custome_length'][$i]*$request['custome_height'][$i];

                    if($request['custome_hiddenC'][$i] >0){
                        $orderGoods->highestC = $request['custome_high'][$i];
                        $orderGoods->lowestC = $request['custome_low'][$i];
                        $orderGoods->isUsing = Goods::ISUSING_YES;
                    }
                    $orderGoods->pallet = $request['custome_pallet'][$i];
                    $orderGoods->palletSize = $request['custome_Size'][$i];

                    $orderGoods->desc = $request['custome_desc'][$i];
                    //$orderGoods->modelName = $request['custome_modelName'][$i];
                   //    $orderGoods->isModel = Goods::ISMODEL_NO;

                    if($request['custome_hiddenFrequence'][$i]>0){
                        $orderGoods->isFrequence = Goods::ISFREQUENCE_YES;
                    }else{
                        $orderGoods->isFrequence = Goods::ISFREQUENCE_NO;
                    }

                    if($request['custome_hiddenModel'][$i] >0){
                        $orderGoods->modelName = $request['custome_modelName'][$i];
                        $orderGoods->isModel = Goods::ISMODEL_YES;
                    }else{
                        $orderGoods->isModel = Goods::ISMODEL_NO;
                    }

                    $orderGoods->createTime = $orderGoods->updateTime = date('Y-m-d H:i:s');

                    if($orderGoods->validate()){
                        $orderGoods->save();
                        $orderGoodsId = Yii::app()->db->getLastInsertID();
                    }else{
                        throw new Exception($orderGoods->getFirstError());
                    }

                    if($request['custome_hiddenModel'][$i] >0){
                        //todo写入goods表
                        $goodsModel = new GoodsForm();
                        $goodsModel->goodsName = $request['custome_goodsName'][$i];
                        $goodsModel->goodsType = $request['custome_type'][$i];
                        $goodsModel->goodsWeight = $request['custome_weight'][$i];
                        $goodsModel->goodsLength = $request['custome_length'][$i];
                        $goodsModel->goodsWidth = $request['custome_width'][$i];
                        $goodsModel->goodsHeight = $request['custome_height'][$i];
                        if(isset($request['custome_C'][$i])){
                            $goodsModel->isUsing = Goods::ISUSING_YES;
                            $goodsModel->highestC = $request['custome_high'][$i];
                            $goodsModel->lowestC = $request['custome_low'][$i];
                        }
                        $goodsModel->pallets = $request['custome_pallet'][$i];
                        $goodsModel->palletSize = $request['custome_Size'][$i];
                        $goodsModel->desc = $request['custome_desc'][$i];
                        $goodsModel->modelName = $request['custome_modelName'][$i];
                        $goodsModel->isModel = Goods::ISMODEL_YES;
                        $goodsModel->userId = user()->getId();
                        if(isset($request['custome_isFrequence'][$i])){
                            $goodsModel->isFrequence = Goods::ISFREQUENCE_YES;
                        }else{
                            $goodsModel->isFrequence = Goods::ISFREQUENCE_NO;
                        }
                        $goodsModel->createTime = $goodsModel->updateTime = date('Y-m-d H:i:s');
                        if($goodsModel->validate()){
                            $goodsModel->save();
                            $id = Yii::app()->db->getLastInsertID();
                            OrderGoods::model()->updateByPk($orderGoodsId,array('goodsId'=>$id));
                        }else{
                            throw new Exception($goodsModel->getFirstError());
                        }
                    }
                }
            }
            Orders::model()->updateByPk($modelId,array('sumWeight'=>$sumweight,'sumVolumn'=>$sumvolumn));

            //处理修改的需求
            if(isset($request['customed_goodsName'])){
                $size = sizeof($request['customed_goodsName']);
                for($i = 0 ;$i <$size ; $i++){
                    $ordrGoodsObj = OrderGoods::model()->findByPk($request['customed_id'][$i]);
                    $orderGoods = new OrderGoodsForm();
                    $orderGoods->attributes = $ordrGoodsObj;
                    $orderGoods->goodsName = $request['customed_goodsName'][$i];
                    $orderGoods->goodsType = $request['customed_type'][$i];
                    $orderGoods->goodsWeight = $request['customed_weight'][$i];
                    $orderGoods->goodsWidth = $request['customed_width'][$i];
                    $orderGoods->goodsLength = $request['customed_length'][$i];
                    $orderGoods->goodsHeight = $request['customed_height'][$i];

                    $sumweight += $request['customed_weight'][$i];
                    $sumvolumn += $request['customed_width'][$i]*$request['customed_length'][$i]*$request['customed_height'][$i];


                    if(isset($request['customed_C'][$i])){
                        $orderGoods->highestC = $request['customed_high'][$i];
                        $orderGoods->lowestC = $request['customed_low'][$i];
                    }
                    $orderGoods->pallet = $request['customed_pallet'][$i];
                    $orderGoods->palletSize = $request['customed_Size'][$i];

                    $orderGoods->desc = $request['customed_desc'][$i];
                    $orderGoods->modelName = $request['customed_modelName'][$i];
                    $orderGoods->isModel = Goods::ISMODEL_YES;

                    if(isset($request['customed_isFrequence'][$i])){
                        $orderGoods->isFrequence = Goods::ISFREQUENCE_YES;
                    }else{
                        $orderGoods->isFrequence = Goods::ISFREQUENCE_NO;
                    }
                    $orderGoods->updateTime = date('Y-m-d H:i:s');

                    if($orderGoods->validate()){
                        $orderGoods->save();
                    }else{
                        throw new Exception($orderGoods->getFirstError());
                    }
                }
            }

            //todo处理联系人
            if(isset($request['receivers'])){
                $size = sizeof($request['receivers']);
                OrderReceiver::model()->deleteOldReceiver($modelId);

                for($i= 0; $i<$size ; $i++){
                    $receiverModel = new OrderReceiverForm();
                    $receiverModel->orderId = $modelId;
                    $receiverModel->receiverId = $request['receivers'][$i];
                    $receiverInfo = Receiver::model()->findByPk($request['receivers'][$i]);
                    $receiverModel->receiver = $receiverInfo['name'];
                    //$receiverModel->area = Address::model()->getDetailAddress($receiverInfo['addressId']);
                    $receiverModel->area = $request['area'][$i];
                    if($receiverModel->validate()){
                        $receiverModel->save();
                    }else{
                        throw new Exception($receiverModel->getFirstError());
                    }
                }
            }

            //todo发送信息
            $infoService = new InfomationService();
            $infoService->add(user()->getId(),'您有新的订单',"有新的订单生成！订单号: $model->orderNumber");

            $tranSaction->commit();
            return ['state' => 1 ,'message'=>'修改成功'];
        }catch (Exception $e){
            $tranSaction->rollBack();
            return ['state' => 0 ,'message'=>$e->getMessage()];
        }
    }

}