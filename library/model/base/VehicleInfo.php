<?php
class VehicleInfo extends BaseModel {
        /**
        * 车辆状态--正常
        */
        CONST STATE_YES = 1;
        /**
         * 车辆状态--停用
         */
        CONST STATE_OFF = 0;
        
        /**
        * 配送状态--待接单
        */
        CONST DELIVERYSTATUS_IDLE = 0;
        /**
        * 配送状态--待配送
        */
        CONST DELIVERYSTATUS_NOING = 1;
        /**
        * 配送状态--运输中
        */
        CONST DELIVERYSTATUS_ING = 2;
        /**
        * 配送状态--已配送
        */
        CONST DELIVERYSTATUS_SUCCESS = 3;
        /**
         * 配送状态--异常
         */
        CONST DELIVERYSTATUS_ERROR = -1;
	public static function getTableName() {
		return 'VehicleInfo';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        
        /**
        * 获取车辆状态数组
        */
        public static function getStateAll($vehicleType = "") {
            $stateArr = array(
               self::STATE_YES => "正常",
               self::STATE_OFF => "停用",
            );
            return parent::getState($stateArr, $vehicleType);
        }
        
        /**
        * 获取配送状态数组
        */
        public static function getDeliveryStatusAll($vehicleType = "") {
            $stateArr = array(
               self::DELIVERYSTATUS_IDLE => "待接单",
               self::DELIVERYSTATUS_NOING => "待配送",
               self::DELIVERYSTATUS_ING => "运输中",
               self::DELIVERYSTATUS_SUCCESS => "已配送",
               self::DELIVERYSTATUS_ERROR => "异常",
            );
            return parent::getState($stateArr, $vehicleType);
        }
        
        /**
        * 
        * @param type $driverName  根据司机姓名查询
        * @return type
        */
       public function findAll() {
           $criteria = new CDbCriteria();
           return self::model()->query($criteria, 'queryAll');
       }
	
}