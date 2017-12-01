<?php
class Protocol extends BaseModel {
	public static function getTableName() {
		return 'Protocol';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}