<?php
class CarTypeBaseForm extends BaseForm {
	public $id;
	public $name;
	public $state;
	public $createTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('name', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('createTime', 'safe'),
			array('state, createTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', '驾照类型'),
			'state' => Yii::t('app', '状态 1[有效] 0[无效]'),
			'createTime' => Yii::t('app', '创建时间'),
		);
	}
	
	public function save() {
		$model = new CarType();
		if (!$this->id) {
			return $model->save(array(
				'name' => $this->name,
				'state' => $this->state,
				'createTime' => $this->createTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'name' => $this->name,
				'state' => $this->state,
				'createTime' => $this->createTime,
			));
		}
	}

	public function search() {
		$model = new CarType();
		
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