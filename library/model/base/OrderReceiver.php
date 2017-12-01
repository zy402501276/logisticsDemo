<?php
class OrderReceiver extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 物流状态-待收货
     */
    CONST LOGISTICS_WAIT = 1;
    /**
     * 物流状态-运输中
     */
    CONST LOGISTICS_TRANS = 2;
    /**
     * 物流状态-已签收
     */
    CONST LOGISTICS_SIGN = 3;
    /**
     * 物流状态-异常
     */
    CONST LOGISTICS_EXCEPTION = 4;


	public static function getTableName() {
		return 'OrderReceiver';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}


    /**
     * 删除旧的联系人
     * @param orderId $
     * @return bool
     */
	public function deleteOldReceiver($orderId){
        if(empty($orderId)){
            return true;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
        $result =  SELF::model()->query($criteria,'queryAll');
        if(!empty($result)){
            foreach ($result as $key => $value){
                OrderReceiver::model()->updateByPk($value['id'],array('state'=>SELF::STATE_OFFM,'updateTime'=>date('Y-m-d H:i:s')));
            }
        }
        return true;
    }

    /**
     * 获取运输状态
     * @param $orderId
     */
    public function getTransState($orderId){
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
         return  SELF::model()->query($criteria,'queryAll');
    }


    /**
     * 获取运输数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getGoodsArr($state = '', $echoString = false){
        $array = array(
            SELF::LOGISTICS_WAIT => '待收货',
            SELF::LOGISTICS_TRANS => '运输中',
            SELF::LOGISTICS_SIGN => '已签收',
            SELF::LOGISTICS_EXCEPTION => '异常',
        );
        return parent::getState($array, $state, $echoString);
    }

}