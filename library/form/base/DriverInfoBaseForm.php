<?php
class DriverInfoBaseForm extends BaseForm {
	public $id;
	public $dId;
	public $idcard;
	public $idcardUrl;
	public $idcardOtherUrl;
	public $driveNumber;
	public $driveAge;
	public $drivetype;
	public $driverLicUrl;
	public $authRemark;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('dId, idcard, idcardUrl, idcardOtherUrl, driveNumber, driveAge, drivetype, driverLicUrl', 'required'),
			array('dId, driveAge, drivetype', 'numerical', 'integerOnly'=>true),
			array('idcard', 'length', 'max'=>18),
			array('idcardUrl, idcardOtherUrl, driverLicUrl', 'length', 'max'=>64),
			array('driveNumber', 'length', 'max'=>50),
			array('authRemark', 'length', 'max'=>150),
			array('authRemark', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'dId' => Yii::t('app', '关联司机ID'),
			'idcard' => Yii::t('app', '身份证号'),
			'idcardUrl' => Yii::t('app', '手持证件照(正面)'),
			'idcardOtherUrl' => Yii::t('app', '手持证件照(反面)'),
			'driveNumber' => Yii::t('app', '驾驶证号码'),
			'driveAge' => Yii::t('app', '司机驾龄(年) '),
			'drivetype' => Yii::t('app', '驾照类型'),
			'driverLicUrl' => Yii::t('app', '驾驶照图片'),
			'authRemark' => Yii::t('app', '证认审核备注'),
		);
	}
	
	public function save() {
		$model = new DriverInfo();
		if (!$this->id) {
			return $model->save(array(
				'dId' => $this->dId,
				'idcard' => $this->idcard,
				'idcardUrl' => $this->idcardUrl,
				'idcardOtherUrl' => $this->idcardOtherUrl,
				'driveNumber' => $this->driveNumber,
				'driveAge' => $this->driveAge,
				'drivetype' => $this->drivetype,
				'driverLicUrl' => $this->driverLicUrl,
				'authRemark' => $this->authRemark,
			));
		} else {
			$model->updateByPk($this->id, array(
				'dId' => $this->dId,
				'idcard' => $this->idcard,
				'idcardUrl' => $this->idcardUrl,
				'idcardOtherUrl' => $this->idcardOtherUrl,
				'driveNumber' => $this->driveNumber,
				'driveAge' => $this->driveAge,
				'drivetype' => $this->drivetype,
				'driverLicUrl' => $this->driverLicUrl,
				'authRemark' => $this->authRemark,
			));
		}
	}

	public function search() {
		$model = new DriverInfo();
		
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