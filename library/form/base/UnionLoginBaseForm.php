<?php
class UnionLoginBaseForm extends BaseForm {
	public $id;
	public $name;
	public $onlyCode;
	public $type;
	public $userId;
	public $bindTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('name, onlyCode', 'required'),
			array('type, userId', 'numerical', 'integerOnly'=>true),
			array('name, onlyCode', 'length', 'max'=>64),
			array('bindTime', 'safe'),
			array('type, userId, bindTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', '联合登录名称'),
			'onlyCode' => Yii::t('app', '唯一标识'),
			'type' => Yii::t('app', '联合登录类型 1：开门通行证'),
			'userId' => Yii::t('app', '绑定用户ID'),
			'bindTime' => Yii::t('app', '绑定时间'),
		);
	}
	
	public function save() {
		$model = new UnionLogin();
		if (!$this->id) {
			return $model->save(array(
				'name' => $this->name,
				'onlyCode' => $this->onlyCode,
				'type' => $this->type,
				'userId' => $this->userId,
				'bindTime' => $this->bindTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'name' => $this->name,
				'onlyCode' => $this->onlyCode,
				'type' => $this->type,
				'userId' => $this->userId,
				'bindTime' => $this->bindTime,
			));
		}
	}

	public function search() {
		$model = new UnionLogin();
		
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