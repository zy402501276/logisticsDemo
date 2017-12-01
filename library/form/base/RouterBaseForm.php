<?php
class RouterBaseForm extends BaseForm {
	public $id;
	public $userId;
	public $name;
	public $type;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('type, state', 'numerical', 'integerOnly'=>true),
			array('userId', 'length', 'max'=>11),
			array('name', 'length', 'max'=>20),
			array('createTime, updateTime', 'safe'),
			array('userId, name, type, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '路线表主键id'),
			'userId' => Yii::t('app', '用户-关联user表主键'),
			'name' => Yii::t('app', '路线名称'),
			'type' => Yii::t('app', '路况类型[1 高速 | 2 普通 | 3不限制]'),
			'state' => Yii::t('app', '状态[1正常|0禁用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new Router();
		if (!$this->id) {
			return $model->save(array(
				'userId' => $this->userId,
				'name' => $this->name,
				'type' => $this->type,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'userId' => $this->userId,
				'name' => $this->name,
				'type' => $this->type,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Router();
		
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