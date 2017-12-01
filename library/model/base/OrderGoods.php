<?php
class OrderGoods extends BaseModel {

    /**
     * 是否为常用 - 是
     */
    CONST ISFREQUENCE_YES = 1;
    /**
     * 是否为常用 - 否
     */
    CONST ISFREQUENCE_NO = 0;

    /**
     * 是否有温度需求 - 是
     */
    CONST ISUSING_YES = 1;
    /**
     * 是否有温度需求 - 否
     */
    CONST ISUSING_NO = 0;
    /**
     * 是否为模板 - 是
     */
    CONST ISMODEL_YES = 1;
    /**
     * 是否为模板 - 否
     */
    CONST ISMODEL_NO = 0;


    public static function getTableName() {
		return 'OrderGoods';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 根据物流单id查找
     * @author zhangy
     * @time 2017年11月14日11:07:44
     * @param $orderId
     * @return mixed
     */
	public static function getGoodsByOrderId($orderId){
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
        $result =  SELF::model()->query($criteria,'queryRow');
        $goodsName = '';
        if(!empty($result)){
            $goodsName = $result['goodsName'];
        }
        return $goodsName;
    }
    /**
     * 根据物流单id查找
     * @author zhangy
     * @time 2017年11月14日11:07:44
     * @param $orderId
     * @return mixed
     */
    public static function getByOrderId($orderId){
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
        return  SELF::model()->query($criteria,'queryAll');
    }


    /**
     * 根据物流单ID返回goods表主键id
     * @author zhangye
     * @time 2017年11月22日14:54:09
     */
    public static function getByGoodsId($orderId){
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
        $res = SELF::model()->query($criteria,'queryAll');
        $array = array();
        foreach ($res as $key => $value){
            $array[] = $value['goodsId'];
        }
        return $array;
    }
}