<?php
class CarType extends BaseModel {
        /**
        * 状态 -- 有效
        */
        CONST STATE_VALID = 1;

        /**
        * 状态 -- 无效
        */
        CONST STATE_INVALID = 0;
	public static function getTableName() {
		return 'CarType';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        
        /**
        * 获取状态数组
        */
        public static function getStateAll($state = "") {
            $stateArr = array(
               self::STATE_VALID => "有效",
               self::STATE_INVALID => "无效",
            );
            return parent::getState($stateArr, $state);
        }
        
        /**
        * 
        * @param type $state
        * @return type
        */
       public function findStateAll() {
           $criteria = new CDbCriteria();
           $criteria->compare('state', carType::STATE_VALID);
           return self::model()->query($criteria, 'queryAll');
       }
	
}