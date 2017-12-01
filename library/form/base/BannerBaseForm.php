<?php
class BannerBaseForm extends BaseForm {
	public $id;
	public $location;
	public $startTime;
	public $endTime;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('location, state', 'numerical', 'integerOnly'=>true),
			array('startTime, endTime, createTime, updateTime', 'safe'),
			array('location, startTime, endTime, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'banner表主键'),
			'location' => Yii::t('app', '位置[1 顶部]'),
			'startTime' => Yii::t('app', '开始时间'),
			'endTime' => Yii::t('app', '截止时间'),
			'state' => Yii::t('app', '状态[1 正常 | 0禁用]'),
			'createTime' => Yii::t('app', '创建时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
		);
	}
	
	public function save() {
		$model = new Banner();
		if (!$this->id) {
			return $model->save(array(
				'location' => $this->location,
				'startTime' => $this->startTime,
				'endTime' => $this->endTime,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'location' => $this->location,
				'startTime' => $this->startTime,
				'endTime' => $this->endTime,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Banner();
		
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