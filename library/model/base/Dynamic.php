<?php
class Dynamic extends BaseModel {
        /**
        * 状态 -- 有效
        */
        CONST STATE_YES = 1;

        /**
        * 状态 -- 无效
        */
        CONST STATE_NO = 0;
	public static function getTableName() {
		return 'Dynamic';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        /**
        * 获取状态数组
        */
        public static function getStateAll($state = "") {
            $stateArr = array(
               self::STATE_YES => "有效",
               self::STATE_NO => "无效",
            );
            return parent::getState($stateArr, $state);
        }
        
        /**
        * 
        * @return type
        */
       public function findAll() {
           $criteria = new CDbCriteria();
           $criteria->order = 'id desc';
           return self::model()->query($criteria, 'queryAll');
       }
	
}