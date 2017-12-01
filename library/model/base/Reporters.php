<?php
class Reporters extends BaseModel {
	public static function getTableName() {
		return 'Reporters';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}