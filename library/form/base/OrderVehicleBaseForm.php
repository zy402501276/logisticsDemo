<?php
class OrderVehicleBaseForm extends BaseForm {
	public $id;
	public $orderId;
	public $vehicleInfoId;
	public $islate;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('orderId', 'required'),
			array('islate', 'numerical', 'integerOnly'=>true),
			array('orderId, vehicleInfoId', 'length', 'max'=>11),
			array('createTime, updateTime', 'safe'),
			array('vehicleInfoId, islate, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '车辆-订单表主键'),
			'orderId' => Yii::t('app', '订单-关联order表主键'),
			'vehicleInfoId' => Yii::t('app', '具体车辆-关联vehicleInfo主键'),
			'islate' => Yii::t('app', '是否延迟[1 是| 0 否]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new OrderVehicle();
		if (!$this->id) {
			return $model->save(array(
				'orderId' => $this->orderId,
				'vehicleInfoId' => $this->vehicleInfoId,
				'islate' => $this->islate,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'orderId' => $this->orderId,
				'vehicleInfoId' => $this->vehicleInfoId,
				'islate' => $this->islate,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new OrderVehicle();
		
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