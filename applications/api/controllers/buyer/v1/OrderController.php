<?php
/**
 * API——订单控制器
 * @time 2017年11月30日09:54:15
 * @author zhangye
 */
class OrderController extends Controller{

    /**
     * 列表
     * @time 2017年11月30日09:55:17
     */
    public function actionList(){
        $orderState = request('oState');
        $model = new ApiOrdersForm();
        $model->page = request('page', 1);
        $model->orderState = $orderState;
        $model->size = 10;//每页数量
        $data = $model->search();
        $vo = $data['datas'];//订单原始数据
        $pager = $data['pager'];//分页信息
        $result = array();
        foreach ($vo as $key => $value){
            //获取途径点
            $routerInfo = RouterInfo::model()->getRouterInfoByRouterId($value['routerId']);
            $middleArr = array();
            if(!empty($routerInfo)){
                foreach ($routerInfo as $k => $val){
                    $middleArr[] = array('address'=>$val['addressName']);
                }
            }

            //货物名称
            $goodsInfo = OrderGoods::model()->getByOrderId($value['id']);
            $goodsArr = array();
            if(!empty($goodsInfo)){
                foreach ($goodsInfo as $k => $val){
                    $goodsArr[] =array('goods'=> $val['goodsName']);
                }
            }
            $result[] = array(
                                'orderId'      => $value['id'],//订单id
                                'orderNumber'  => $value['orderNumber'],//订单号
                                'orderState'   => OrderReceiver::getGoodsArr($value['orderState']),//订单状态
                                'startRouter'  => $value['startRouter'],//起始点
                                'endRouter'    => $value['endRouter'],//终点
                                'middleRouter' => $middleArr,//途径点
                                'goodsArr'     => $goodsArr,
                                'time'         => $value['distributeTime'],//派单时间
                             );
        }
        $this->output(array('code'=> 1 ,'obj'=>$result));
    }

    /**
     * 订单详情
     * @time 2017年11月30日17:28
     */
    public function actionOrderInfo(){
        $id = request('id');
        if(empty($id)){
            $this->output(array('code'=>0,'message'=>'id为空'));
        }
        $orderInfo = Orders::model()->findByPK($id);//订单数据
        if(empty($orderInfo)){
            $this->output(array('code'=>0,'message'=>'订单不存在'));
        }
        $routerBegin = RouterInfo::model()->getRouterDetail($orderInfo['routerId'],$orderInfo['id'],RouterInfo::ROUTER_BEGIN); //获取起点信息
        $routerFinish = RouterInfo::model()->getRouterDetail($orderInfo['routerId'],$orderInfo['id'],RouterInfo::ROUTER_FINISH); //获取终点信息
        $routerMiddle = RouterInfo::model()->getRouterDetail($orderInfo['routerId'],$orderInfo['id'],RouterInfo::ROUTER_MIDDLE); //获取途径点信息
        $middleArr = array();
        if(!empty($routerMiddle)){
            foreach ($routerMiddle as $key => $value){
                $middleArr[] = array('address'=>$value['addressName'],'receiver'=>$value['name'].'('.Receiver::getGender($value['gender']).')'.$value['mobile']);
            }
        }

        $goodsArr = OrderGoods::model()->getByOrderId($orderInfo['id']);//货物信息
        $orderGoods = array();
        if(!empty($goodsArr)){
            foreach ($goodsArr as $key => $value){
                $orderGoods[] = array(
                                'ordergoodsId' => $value['id'],//OrderGoods表主键id
                                'goodsName'    => $value['goodsName'],//货物名
                                'goodsType'    => GoodsType::getGoodsTypeArr($value['goodsType']),//货物类型
                                'goodsWeight'  => $value['goodsWeight'],//货物重量
                                'goodsVolumn'  => $value['goodsLength'].'x'.$value['goodsWidth'].'x'.$value['goodsHeight'],//体积
                                'pallets'      => $value['pallet'],//托盘个数
                                'palletSize'   => $value['palletSize'],//托盘大小
                                'temperature'  => $value['isUsing']?$value['lowestC'].'℃~'.$value['highestC'].'℃':"",//温度要求
                                );
            }
        }
        $result = array(
                        'id'             => $orderInfo['id'],//订单id
                        'orderNumber'    => $orderInfo['orderNumber'],//订单号
                        'distributeTime' => $orderInfo['distributeTime']?$orderInfo['distributeTime']:'',//派单时间
                        'orderState'     => OrderReceiver::getGoodsArr($orderInfo['orderState']),//订单状态
                        'startArea'      => $routerBegin['addressName'],//装货地址
                        'startReceiver'  => $routerBegin['name'].'('.Receiver::getGender($routerBegin['gender']).')'.$routerBegin['mobile'],//起点收货人信息
                        'startTime'      => $orderInfo['startTime'],//装货时间
                        'endTime'        => $orderInfo['endTime'],//完成时间
                        'middleArea'     => $middleArr,//途径点信息
                        'endArea'        => $routerFinish['addressName'],//终点地址
                        'endReceiver'    => $routerFinish['name'].'('.Receiver::getGender($routerFinish['gender']).')'.$routerFinish['mobile'],//终点联系人信息
                        'deliveryTime'   => $orderInfo['deliveryTime'], //预计到达时间
                        'orderGoods'     => $orderGoods,//货物信息
                    );

        $this->output(array('code'=> 1 ,'obj'=>$result));
    }

}