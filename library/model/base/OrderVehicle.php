<?php
class OrderVehicle extends BaseModel {
	public static function getTableName() {
		return 'OrderVehicle';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 根据订单ID查找司机信息
     * @time 2017年11月13日14:36:38
     * @author zhangy
     * @param $orderId
     */
	public function findDriverByOrder($orderId){
        $criteria = new CDbCriteria();
        $criteria->select = '`D`.*,`DI`.* ,`VI`.*';
        $criteria->join = "LEFT JOIN `VehicleInfo`as VI ON(`t`.vehicleInfoId = `VI`.id) 
                           LEFT JOIN `Drives` AS `D` ON (`VI`.dId = `D`.dId) 
                           LEFT JOIN `DriverInfo` AS `DI` ON (`D`.dId = `DI`.dId)";
        $criteria->compare('orderId',$orderId);
        return SELF::model()->query($criteria,'queryAll');
    }
    /**
     * 根据订单ID查找信息
     * @time 2017年11月13日14:36:38
     * @author zhangy
     * @param $orderId
     */
    public function findByOrder($orderId){
        $criteria = new CDbCriteria();
        $criteria->compare('orderId',$orderId);
        return SELF::model()->query($criteria,'queryAll');
    }

}