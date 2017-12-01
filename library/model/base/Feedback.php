<?php
class Feedback extends BaseModel {
	public static function getTableName() {
		return 'Feedback';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}