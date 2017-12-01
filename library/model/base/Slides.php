<?php
class Slides extends BaseModel {
        /**
        * 广告位置 -- 头部
        */
        CONST POS_HEADER = 1;

        /**
        * 广告位置 -- 底部左侧
        */
        CONST POS_FOOTER_LEFT = 2;
        /**
        * 广告位置 -- 底部右侧
        */
        CONST POS_FOOTER_RIGHT = 3;
	public static function getTableName() {
		return 'Slides';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        /**
        * 获取广告位置
        */
        public static function getStateAll($pos = "") {
            $stateArr = array(
               self::POS_HEADER => "头部",
               self::POS_FOOTER_LEFT => "底部左侧",
               self::POS_FOOTER_RIGHT => "底部右侧",
            );
            return parent::getState($stateArr, $pos);
        }
        
        /**
        * 
        * @param type $pos  根据广告位置查询
        * @return type
        */
       public function findPos($pos) {
           $criteria = new CDbCriteria();
           $criteria->compare('pos', $pos);
           return self::model()->query($criteria, 'queryRow');
       }
       
       
       public function findAll() {
           $criteria = new CDbCriteria();
           return self::model()->query($criteria, 'queryAll');
       }
	
}