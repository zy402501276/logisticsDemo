<?php
/**
 * 货物逻辑service层
 * @author zhangye
 * @time 2017年11月2日17:32:13
 */
class GoodsService {
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
     * 新增/修改商品
     * @time 2017年11月2日13:22:55
     * @param $request array
     * @param $model  OBJ GoodsForm的对象
     * @return array
     */
    public function addGoods($request,$model){
        $tranSaction = Yii::app()->db->beginTranSaction();
        try{
            $goodsData = $request['GoodsForm'];
            $model->attributes = $goodsData;
            if(!empty($goodsData['isUsing'])){
                if(empty($goodsData['highestC'])){
                    $model->addError('highestC','最高温度不能为空');
                    throw new Exception($model->getError('highestC'));
                }
                if(empty($goodsData['lowestC'])){
                    $model->addError('lowestC','最低温度不能为空');
                    throw new Exception($model->getError('lowestC'));
                }
                $model->highestC = $goodsData['highestC'];
                $model->lowestC = $goodsData['lowestC'];
            }
            $model->modelName = $goodsData['modelName'];
            $model->isModel = Goods::ISMODEL_YES;
            if(!empty($model->id)){
                $model->updateTime = date('Y-m-d H:i:s');
            }else{
                $model->userId = user()->getId();
                $model->createTime = $model->updateTime = date('Y-m-d H:i:s');
            }
            $model->scenario = 'add';
            if($model->validate()){
                $model->save();
            }else{
                throw new Exception($model->getFirstError());
            }
            $tranSaction->commit();
            return ['state' => 1 ,'message'=>'修改成功'];
        }catch (Exception $e){
            $tranSaction->rollBack();
            return ['state' => 0 ,'message'=>$e->getMessage()];
        }
    }
}