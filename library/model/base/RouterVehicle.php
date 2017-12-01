<?php

class RouterVehicle extends BaseModel {

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;

    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 报价状态-未报价
     */
    CONST COST_UNCHECK = 1;

    /**
     * 报价状态-已报价
     */
    CONST COST_CHECK = 2;

    /**
     * 报价状态-已确认
     */
    CONST COST_CHECKED = 3;

    /**
     * 报价状态-申请重新报价
     */
    CONST COST_REFRESH = 4;

    public static function getTableName() {
        return 'RouterVehicle';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 根据路线id获取车辆列表
     * @param $routerId
     */
    public function getVehicleByRouterId($routerId) {
        $criteria = new CDbCriteria();
        $criteria->compare('routerId', $routerId);
        $criteria->compare('state', SELF::STATE_ON);
        return SELF::model()->query($criteria, 'queryAll');
    }

    /**
     * 获取报价状态数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getCostStateArr($state = '', $echoString = false) {
        $itemArr = array(
            SELF::COST_UNCHECK => '未报价',
            SELF::COST_CHECK => '已报价',
            SELF::COST_CHECKED => '已确认',
            SELF::COST_REFRESH => '申请重新报价',
        );

        return parent::getState($itemArr, $state, $echoString);
    }

    /**
     * 根据报价状态搜索
     * @param type $costState
     * @return type
     */
    public function findByCostState($costState) {
        $criteria = new CDbCriteria();
        $criteria->compare('costState', $costState);
        $criteria->compare('state', SELF::STATE_ON);
        return SELF::model()->query($criteria, 'queryAll');
    }

    /**
     * 查重
     * @author zhangy
     * @time 2017年11月23日14:17:00
     * @param  $type int 车辆类型 ; $length int 长度;$weight int 宽; $routerId int router表主键
     * @return bool
     */
    public function findVehicle($type,$length,$weight,$routerId){
        $criteria = new CDbCriteria();
        $criteria->compare('type', $type);
        $criteria->compare('length', $length);
        $criteria->compare('weight', $weight);
        $criteria->compare('routerId', $routerId);
        $criteria->compare('state', SELF::STATE_ON);
        $res = SELF::model()->query($criteria, 'queryAll');
        if(!empty($res)){
            return false;
        }else{
            return true;
        }
    }

}
