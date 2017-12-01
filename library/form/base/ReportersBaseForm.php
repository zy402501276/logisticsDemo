<?php
class ReportersBaseForm extends BaseForm {
	public $id;
	public $orderId;
	public $dId;
	public $address;
	public $longitude;
	public $latitude;
	public $desc;
	public $type;
	public $cTime;
	public $state;
	public $reply;
	public $rTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('type, state', 'numerical', 'integerOnly'=>true),
			array('orderId, dId', 'length', 'max'=>11),
			array('address', 'length', 'max'=>40),
			array('longitude, latitude', 'length', 'max'=>20),
			array('desc, reply', 'length', 'max'=>100),
			array('cTime, rTime', 'safe'),
			array('orderId, dId, address, longitude, latitude, desc, type, cTime, state, reply, rTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '异常报告表主键id'),
			'orderId' => Yii::t('app', '订单-关联order表主键'),
			'dId' => Yii::t('app', '司机-关联driver表主键'),
			'address' => Yii::t('app', '当前位置'),
			'longitude' => Yii::t('app', '经度'),
			'latitude' => Yii::t('app', '纬度'),
			'desc' => Yii::t('app', '描述'),
			'type' => Yii::t('app', '状态类型[1开始运输 |2 到达途径点 | 3验收完成 | 4异常]'),
			'cTime' => Yii::t('app', '报告时间'),
			'state' => Yii::t('app', '状态[1未确认 | 2已确认]'),
			'reply' => Yii::t('app', '回复'),
			'rTime' => Yii::t('app', '回复时间'),
		);
	}
	
	public function save() {
		$model = new Reporters();
		if (!$this->id) {
			return $model->save(array(
				'orderId' => $this->orderId,
				'dId' => $this->dId,
				'address' => $this->address,
				'longitude' => $this->longitude,
				'latitude' => $this->latitude,
				'desc' => $this->desc,
				'type' => $this->type,
				'cTime' => $this->cTime,
				'state' => $this->state,
				'reply' => $this->reply,
				'rTime' => $this->rTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'orderId' => $this->orderId,
				'dId' => $this->dId,
				'address' => $this->address,
				'longitude' => $this->longitude,
				'latitude' => $this->latitude,
				'desc' => $this->desc,
				'type' => $this->type,
				'cTime' => $this->cTime,
				'state' => $this->state,
				'reply' => $this->reply,
				'rTime' => $this->rTime,
			));
		}
	}

	public function search() {
		$model = new Reporters();
		
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