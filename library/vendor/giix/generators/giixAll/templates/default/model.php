<?php echo "<?php\n"; ?>
class <?php echo $modelClass; ?> extends <?php echo $baseModelClass?> {
	public static function getTableName() {
		return '<?php echo $tableName?>';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
}