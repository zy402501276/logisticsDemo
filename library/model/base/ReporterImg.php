<?php
class ReporterImg extends BaseModel {
	public static function getTableName() {
		return 'ReporterImg';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}