<?php
class AdminLog extends BaseModel {
        /**
         * 企业认证
         */
        CONST COMPANY_ISAUTH = 1;
	public static function getTableName() {
		return 'AdminLog';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        
        /**
        * @param type $id  关联ID
        * @param type $type  类型
        * @return type
        */
       public function findLogAll($id,$type) {
           $criteria = new CDbCriteria();
           $criteria->compare('id', $id);
           $criteria->compare('type', $type);
           return self::model()->query($criteria, 'queryAll');
       }
	
}