<?php
class VehicleInfoBaseForm extends BaseForm {
	public $id;
	public $dId;
	public $typeId;
	public $weightId;
	public $lengthId;
	public $licenseNumber;
	public $vehiclePhoto;
	public $vehicleType;
	public $deliveryStatus;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('dId, typeId, weightId, lengthId, licenseNumber, createTime', 'required'),
			array('dId, typeId, weightId, lengthId, vehicleType, deliveryStatus', 'numerical', 'integerOnly'=>true),
			array('licenseNumber', 'length', 'max'=>20),
			array('vehiclePhoto', 'length', 'max'=>60),
			array('updateTime', 'safe'),
			array('vehiclePhoto, vehicleType, deliveryStatus, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '车辆信息表主键id'),
			'dId' => Yii::t('app', '关联司机dId'),
			'typeId' => Yii::t('app', '车辆类型'),
			'weightId' => Yii::t('app', '车辆吨位(吨)'),
			'lengthId' => Yii::t('app', '车辆长度(米)'),
			'licenseNumber' => Yii::t('app', '车牌号码'),
			'vehiclePhoto' => Yii::t('app', '车辆照片'),
			'vehicleType' => Yii::t('app', '车辆状态[1正常 | 0无法使用]'),
			'deliveryStatus' => Yii::t('app', '配送状态'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new VehicleInfo();
		if (!$this->id) {
			return $model->save(array(
				'dId' => $this->dId,
				'typeId' => $this->typeId,
				'weightId' => $this->weightId,
				'lengthId' => $this->lengthId,
				'licenseNumber' => $this->licenseNumber,
				'vehiclePhoto' => $this->vehiclePhoto,
				'vehicleType' => $this->vehicleType,
				'deliveryStatus' => $this->deliveryStatus,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'dId' => $this->dId,
				'typeId' => $this->typeId,
				'weightId' => $this->weightId,
				'lengthId' => $this->lengthId,
				'licenseNumber' => $this->licenseNumber,
				'vehiclePhoto' => $this->vehiclePhoto,
				'vehicleType' => $this->vehicleType,
				'deliveryStatus' => $this->deliveryStatus,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new VehicleInfo();
		
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