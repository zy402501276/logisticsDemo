<?php
class Drives extends BaseModel {
        /**
        * 状态 -- 启用
        */
        CONST DSTATE_VALID = 1;

        /**
        * 状态 -- 停用
        */
        CONST DSTATE_INVALID = -1;
        
        /**
        * 司机认证状态 -- 待审核
        */
        CONST AUTHSTATE_ING = 0;
        /**
        * 司机认证状态 -- 审核通过
        */
        CONST AUTHSTATE_YES = 1;
        /**
        * 司机认证状态 -- 审核失败
        */
        CONST AUTHSTATE_NO = -1;
	public static function getTableName() {
		return 'Drives';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        
        /**
        * 获取状态数组
        */
        public static function getDstateAll($dState = "") {
            $stateArr = array(
               self::DSTATE_VALID => "启用",
               self::DSTATE_INVALID => "停用",
            );
            return parent::getState($stateArr, $dState);
        }
        
        /**
        * 获取认证状态数组
        */
        public static function getAuthStateAll($authState = "") {
            $stateArr = array(
               self::AUTHSTATE_ING => "待审核",
               self::AUTHSTATE_YES => "审核通过",
               self::AUTHSTATE_NO => "审核失败",
            );
            return parent::getState($stateArr, $authState);
        }
        
        /**
        * 
        * @param type 
        * @return type
        */
       public function findAll() {
           $criteria = new CDbCriteria();
           return self::model()->query($criteria, 'queryAll');
       }
       
       /**
        * 
        * @param type $driverName  根据司机姓名查询
        * @return type
        */
       public function findDrivesNameRow($driverName) {
           $criteria = new CDbCriteria();
           $criteria->compare('driverName', $driverName);
           return self::model()->query($criteria, 'queryRow');
       }
       
       /**
        * 
        * @param type $driverName  根据司机姓名查询
        * @return type
        */
       public function findDrivesNameAll($driverName) {
           $criteria = new CDbCriteria();
           $criteria->compare('driverName', $driverName,true);
           $criteria->compare('dState', Drives::DSTATE_VALID);
           return self::model()->query($criteria, 'queryAll');
       }
	
}