<?php
class Orders extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 是否延迟--是
     */
    CONST DELAY_YES = 1;
    /**
     * 是否延迟--否
     */
    CONST DELAY_NO = 0;

    /**
     * 时间范围-今天
     */
    CONST TIME_DAY = 1;
    /**
     * 时间范围-今天
     */
    CONST TIME_WEEK = 2;
    /**
     * 时间范围-今天
     */
    CONST TIME_MONTH = 3;
    /**
     * 样式-配送
     */
    CONST CSS_DISPATCHING = 'dispatching';
    /**
     * 样式-异常
     */
    CONST CSS_ABNORMAL = 'abnormal';
    /**
     * 样式-已签收
     */
    CONST CSS_ACCEPTANCE = 'acceptance';
    /**
     * 样式-运输
     */
    CONST CSS_TRANSPORTATION = 'transportation';

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

    /**
     * 搜索方式-最近时间
     */
    CONST SEARCH_LATER = 1;
    /**
     * 搜索方式-最早时间
     */
    CONST SEARCH_FORMER = 2;
    /**
     * 搜索方式-价格高低
     */
    CONST SEARCH_COST = 3;
    /**
     * 催单-否
     */
    CONST REMIND_NO = 0;
    /**
     * 催单-是
     */
    CONST REMIND_YES = 1;


    /**
     * 时间
     */
    CONST TIME_000  = '00:00';
    CONST TIME_030  = '00:30';
    CONST TIME_100  = '01:00';
    CONST TIME_130  = '01:30';
    CONST TIME_200  = '02:00';
    CONST TIME_230  = '02:30';
    CONST TIME_300  = '03:00';
    CONST TIME_330  = '03:30';
    CONST TIME_400  = '04:00';
    CONST TIME_430  = '04:30';
    CONST TIME_500  = '05:00';
    CONST TIME_530  = '05:30';
    CONST TIME_600  = '06:00';
    CONST TIME_630  = '06:30';
    CONST TIME_700  = '07:00';
    CONST TIME_730  = '07:30';
    CONST TIME_800  = '08:00';
    CONST TIME_830  = '08:30';
    CONST TIME_900  = '09:00';
    CONST TIME_1000 = '10:00';
    CONST TIME_1030 = '10:30';
    CONST TIME_1100 = '11:00';
    CONST TIME_1130 = '11:30';
    CONST TIME_1200 = '12:00';
    CONST TIME_1230 = '12:30';
    CONST TIME_1300 = '13:00';
    CONST TIME_1330 = '13:30';
    CONST TIME_1400 = '14:00';
    CONST TIME_1430 = '14:30';
    CONST TIME_1500 = '15:00';
    CONST TIME_1530 = '15:30';
    CONST TIME_1600 = '16:00';
    CONST TIME_1630 = '16:30';
    CONST TIME_1700 = '17:00';
    CONST TIME_1730 = '17:30';
    CONST TIME_1800 = '18:00';
    CONST TIME_1830 = '18:30';
    CONST TIME_1900 = '19:00';
    CONST TIME_1930 = '19:30';
    CONST TIME_2000 = '20:00';
    CONST TIME_2030 = '20:30';
    CONST TIME_2100 = '21:00';
    CONST TIME_2130 = '21:30';
    CONST TIME_2200 = '22:00';
    CONST TIME_2230 = '22:30';
    CONST TIME_2300 = '23:00';
    CONST TIME_2330 = '23:30';


	public static function getTableName() {
		return 'Orders';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
    /**
     * 生成订单编号
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年9月23日
     */
    public static function generateOrderSn() {
        return date('ymdH') . substr(microtime(), 2, 6) . str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
    }

    public static function getTime( $time = '', $echoString = false){
        $array = array(
                    SELF::TIME_000  => SELF::TIME_000 ,
                    SELF::TIME_030  => SELF::TIME_030 ,
                    SELF::TIME_100  => SELF::TIME_100 ,
                    SELF::TIME_130  => SELF::TIME_130,
                    SELF::TIME_200  => SELF::TIME_200,
                    SELF::TIME_230  => SELF::TIME_230,
                    SELF::TIME_300  => SELF::TIME_300,
                    SELF::TIME_330  => SELF::TIME_330,
                    SELF::TIME_400  => SELF::TIME_400,
                    SELF::TIME_430  =>  SELF::TIME_430,
                    SELF::TIME_500  => SELF::TIME_500,
                    SELF::TIME_530  => SELF::TIME_530,
                    SELF::TIME_600  => SELF::TIME_600,
                    SELF::TIME_630  => SELF::TIME_630,
                    SELF::TIME_700  => SELF::TIME_700,
                    SELF::TIME_730  => SELF::TIME_730,
                    SELF::TIME_800  => SELF::TIME_800,
                    SELF::TIME_830  => SELF::TIME_830,
                    SELF::TIME_900  => SELF::TIME_900,
                    SELF::TIME_1000 => SELF::TIME_1000,
                    SELF::TIME_1030 => SELF::TIME_1030,
                    SELF::TIME_1100 => SELF::TIME_1100,
                    SELF::TIME_1130 => SELF::TIME_1130,
                    SELF::TIME_1200 => SELF::TIME_1200,
                    SELF::TIME_1230 => SELF::TIME_1230,
                    SELF::TIME_1300 => SELF::TIME_1300,
                    SELF::TIME_1330 => SELF::TIME_1330,
                    SELF::TIME_1400 => SELF::TIME_1400,
                    SELF::TIME_1430 => SELF::TIME_1430,
                    SELF::TIME_1500 => SELF::TIME_1500,
                    SELF::TIME_1530 => SELF::TIME_1530,
                    SELF::TIME_1600 => SELF::TIME_1600,
                    SELF::TIME_1630 => SELF::TIME_1630,
                    SELF::TIME_1700 => SELF::TIME_1700,
                    SELF::TIME_1730 => SELF::TIME_1730,
                    SELF::TIME_1800 => SELF::TIME_1800,
                    SELF::TIME_1830 => SELF::TIME_1830,
                    SELF::TIME_1900 => SELF::TIME_1900,
                    SELF::TIME_1930 => SELF::TIME_1930,
                    SELF::TIME_2000 => SELF::TIME_2000,
                    SELF::TIME_2030 => SELF::TIME_2030,
                    SELF::TIME_2100 => SELF::TIME_2100,
                    SELF::TIME_2130 => SELF::TIME_2130,
                    SELF::TIME_2200 => SELF::TIME_2200,
                    SELF::TIME_2230 => SELF::TIME_2230,
                    SELF::TIME_2300 => SELF::TIME_2230,
                    SELF::TIME_2330 => SELF::TIME_2330,
        );

        return parent::getState($array, $time, $echoString);
    }

    /**
     * 根据用户Id查找订单
     * @time 2017年11月13日13:32:45
     * @author zhangye
     * @param $userId
     */
    public function findByUserId($userId){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',$userId);
        $criteria->compare('state',SELF::STATE_ON);
        return SELF::model()->query($criteria,'queryAll');
    }

    /**
     * 获取用户物流总车次
     * @time 2017年11月13日16:54:10
     * @author zhangye
     */
    public function getTransTimes($type = 1,$isLate = 0 ){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',user()->getId());
        $criteria->join = "LEFT JOIN `OrderVehicle` AS `ov` ON (`t`.id = `ov`.orderId)  ";
        $criteria->compare('state',SELF::STATE_ON);
        if(!empty($type)){
            switch ($type){
                case SELF::TIME_DAY:
                    $beginTime = date('Y-m-d 00:00:00');
                    $endTime = date('Y-m-d 23:59:59');
                    break;
                case SELF::TIME_WEEK:
                    $time = '1' == date('w') ? strtotime('Monday') : strtotime('last Monday');
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', strtotime('Sunday', time()));
                    break;
                case SELF::TIME_MONTH:
                    $beginTime = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', time()), '1', date('Y', time())));
                    $endTime = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', time()), date('t', time()), date('Y', time())));
                    break;
            }
            $criteria->addBetweenCondition('endTime',$beginTime,$endTime);
        }
        $result = SELF::model()->query($criteria,'queryAll');
        return sizeof($result);
    }
    /**
     * 获取用户物流总车次
     * @time 2017年11月13日16:54:10
     * @author zhangye
     */
    public function getSumWeight($type = 1){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',user()->getId());
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->select = "sum(sumWeight)";
        if(!empty($type)){
            switch ($type){
                case SELF::TIME_DAY:
                    $beginTime = date('Y-m-d 00:00:00');
                    $endTime = date('Y-m-d 23:59:59');
                    break;
                case SELF::TIME_WEEK:
                    $time = '1' == date('w') ? strtotime('Monday') : strtotime('last Monday');
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', strtotime('Sunday', time()));
                    break;
                case SELF::TIME_MONTH:
                    $beginTime = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', time()), '1', date('Y', time())));
                    $endTime = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', time()), date('t', time()), date('Y', time())));
                    break;
            }
            $criteria->addBetweenCondition('endTime',$beginTime,$endTime);
        }
        $result = SELF::model()->query($criteria,'queryRow');
        return $result['sum(sumWeight)'];
    }
    /**
     * 获取用户订单
     * @time 2017年11月13日16:54:10
     * @author zhangye
     */
    public function getSumOrders($type = 1){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',user()->getId());
        $criteria->compare('state',SELF::STATE_ON);
        if(!empty($type)){
            switch ($type){
                case SELF::TIME_DAY:
                    $beginTime = date('Y-m-d 00:00:00');
                    $endTime = date('Y-m-d 23:59:59');
                    break;
                case SELF::TIME_WEEK:
                    $time = '1' == date('w') ? strtotime('Monday') : strtotime('last Monday');
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', strtotime('Sunday', time()));
                    break;
                case SELF::TIME_MONTH:
                    $beginTime = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', time()), '1', date('Y', time())));
                    $endTime = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', time()), date('t', time()), date('Y', time())));
                    break;
            }
            $criteria->addBetweenCondition('endTime',$beginTime,$endTime);
        }
        $result = SELF::model()->query($criteria,'queryAll');
        return sizeof($result);
    }

    /**
     * 获取用户物流总车次
     * @time 2017年11月13日16:54:10
     * @author zhangye
     */
    public function getLateTimes($type = 1 ){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',user()->getId());
        $criteria->join = "LEFT JOIN `OrderVehicle` AS `ov` ON (`t`.id = `ov`.orderId)  ";
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->compare('islate',SELF::DELAY_YES);
        if(!empty($type)){
            switch ($type){
                case SELF::TIME_DAY:
                    $beginTime = date('Y-m-d 00:00:00');
                    $endTime = date('Y-m-d 23:59:59');
                    break;
                case SELF::TIME_WEEK:
                    $time = '1' == date('w') ? strtotime('Monday') : strtotime('last Monday');
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', strtotime('Sunday', time()));
                    break;
                case SELF::TIME_MONTH:
                    $beginTime = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', time()), '1', date('Y', time())));
                    $endTime = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', time()), date('t', time()), date('Y', time())));
                    break;
            }
            $criteria->addBetweenCondition('endTime',$beginTime,$endTime);
        }
        $result = SELF::model()->query($criteria,'queryAll');
        return sizeof($result);
    }

    /**
     * 获取运输数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getStateArr($state = '', $echoString = false){
        $array = array(
            SELF::LOGISTICS_WAIT => SELF::CSS_DISPATCHING,
            SELF::LOGISTICS_TRANS =>SELF::CSS_TRANSPORTATION,
            SELF::LOGISTICS_SIGN => SELF::CSS_ACCEPTANCE,
            SELF::LOGISTICS_EXCEPTION => SELF::CSS_ABNORMAL,
        );
        return parent::getState($array, $state, $echoString);
    }

    /**
     * 搜索方式
     * @time 2017年11月14日16:39:23
     */
    public static function searchType($state = '', $echoString = false){
        $array = array(
            SELF::SEARCH_LATER => '最近时间',
            SELF::SEARCH_FORMER =>'最早时间',
            SELF::SEARCH_COST => '按价格从高到低',
        );
        return parent::getState($array, $state, $echoString);
    }
}