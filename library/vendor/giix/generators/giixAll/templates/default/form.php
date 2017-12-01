<?php echo "<?php\n"; ?>
class <?php echo $formClass; ?> extends <?php echo $baseFormClass?> {
	<?php  foreach ($labels as $name => $label) {
			echo 'public $'.$name.";\n\t";
	} ?>
	
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
		);
	}
	
	public function attributeLabels() {
		return array(
<?php foreach($labels as $name=>$label): ?>
<?php if($label === null): ?>
			<?php echo "'{$name}' => null,\n"; ?>
<?php else: ?>
			<?php echo "'{$name}' => {$label},\n"; ?>
<?php endif; ?>
<?php endforeach; ?>
		);
	}
	
	public function save() {
		$model = new <?php echo $modelClass?>();
		if (!$this-><?php echo $pk?>) {
			return $model->save(array(
		<?php  foreach ($labels as $name => $label) {
				if ($name == $pk) continue;
				echo "\t\t".'\''.$name.'\' => $this->'.$name.",\n\t\t";
		} ?>
	));
		} else {
			$model->updateByPk($this-><?php echo $pk?>, array(
		<?php  foreach ($labels as $name => $label) {
				if ($name == $pk) continue;
				echo "\t\t".'\''.$name.'\' => $this->'.$name.",\n\t\t";
		} ?>
	));
		}
	}

	public function search() {
		$model = new <?php echo $modelClass?>();
		
		if (!$this->criteria) {
			$this->criteria = new CDbCriteria();
			$this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
			$this->criteria->limit = $this->size;
			$this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
		}
		
		$datas = $model->query(array(
			'list' => $this->criteria, 
			'count' => 'SELECT FOUND_ROWS()'
		), array(
			'list' => 'queryAll', 
			'count' => 'queryScalar'
		));
		$pager = new CPagination($datas['count']);
		$pager->setPageSize($this->size);
		
		return array('datas' => $datas['list'], 'pager' => $pager);
	}
}