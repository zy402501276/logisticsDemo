<?php
class Banner extends BaseModel {
	public static function getTableName() {
		return 'Banner';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}