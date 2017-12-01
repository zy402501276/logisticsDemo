<?php
class DriverInfo extends BaseModel {
        /**
        * 司机驾龄 -- 1年
        */
        CONST DRIVEAGE_ONE = 1;
        /**
        * 司机驾龄 -- 2年
        */
        CONST DRIVEAGE_TWO = 2;
        /**
        * 司机驾龄 -- 3年
        */
        CONST DRIVEAGE_THREE = 3;
        /**
        * 司机驾龄 -- 4年
        */
        CONST DRIVEAGE_FOUR = 4;
        /**
        * 司机驾龄 -- 5年
        */
        CONST DRIVEAGE_FIVES = 5;
        /**
        * 司机驾龄 -- 6年
        */
        CONST DRIVEAGE_SIX = 6;
        /**
        * 司机驾龄 -- 7年
        */
        CONST DRIVEAGE_SEVEN = 7;
        /**
        * 司机驾龄 -- 8年
        */
        CONST DRIVEAGE_EIGHT = 8;
        /**
        * 司机驾龄 -- 9年
        */
        CONST DRIVEAGE_NINE = 9;
        /**
        * 司机驾龄 -- 10年
        */
        CONST DRIVEAGE_TEN = 10;
        
       
        /**
        * 驾照类型 -- A1
        */
        CONST TYPE_A = 1;
        /**
        * 驾照类型 -- A2
        */
        CONST TYPE_A2 = 2;
        /**
        * 驾照类型 -- A3
        */
        CONST TYPE_A3 = 3;
        /**
        * 驾照类型 -- B1
        */
        CONST TYPE_B= 4;
        /**
        * 驾照类型 -- B2
        */
        CONST TYPE_B2= 5;
        /**
        * 驾照类型 -- C1
        */
        CONST TYPE_C= 6;
        /**
        * 驾照类型 -- C2
        */
        CONST TYPE_C2= 7;
	public static function getTableName() {
		return 'DriverInfo';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        
        /**
        * 获取司机驾龄数组
        */
        public static function getDrivesAgeAll($driveAge = "") {
            $stateArr = array(
                self::DRIVEAGE_ONE => "1年",
                self::DRIVEAGE_TWO => "2年",
                self::DRIVEAGE_THREE => "3年",
                self::DRIVEAGE_FOUR => "4年",
                self::DRIVEAGE_FIVES => "5年",
                self::DRIVEAGE_SIX => "6年",
                self::DRIVEAGE_SEVEN => "7年",
                self::DRIVEAGE_EIGHT => "8年",
                self::DRIVEAGE_NINE => "9年",
                self::DRIVEAGE_TEN => "10年",
            );
            return parent::getState($stateArr, $driveAge);
        }
        
        /**
        * 获取驾照类型数组
        */
        public static function getDrivesTypeAll($drivetype = "") {
            $stateArr = array(
                self::TYPE_A => "A1",
                self::TYPE_A2 => "A2",
                self::TYPE_A3 => "A3",
                self::TYPE_B => "B",
                self::TYPE_B2 => "B2",
                self::TYPE_C => "C",
                self::TYPE_C2 => "C2",
            );
            return parent::getState($stateArr, $drivetype);
        }
        
        /**
        * 
        * @param type $idcard  根据身份证号码查找
        * @return type
        */
       public function findIdCardRow($idcard) {
           $criteria = new CDbCriteria();
           $criteria->compare('idcard', $idcard);
           return self::model()->query($criteria, 'queryRow');
       }
       
       /**
        * 
        * @param type $idcard  根据关联司机ID查找
        * @return type
        */
       public function findDId($dId) {
           $criteria = new CDbCriteria();
           $criteria->compare('dId', $dId);
           return self::model()->query($criteria, 'queryRow');
       }
       
	
}