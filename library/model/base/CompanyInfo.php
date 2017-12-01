<?php
class CompanyInfo extends BaseModel {
	public static function getTableName() {
		return 'companyInfo';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
        /**
        * 
        * @param type $cId  根据关公司ID查找
        * @return type
        */
       public function findCId($cId) {
           $criteria = new CDbCriteria();
           if(!$cId){
               return false;
           }
           $criteria->compare('cId', $cId);
           return self::model()->query($criteria, 'queryRow');
       }
	
}