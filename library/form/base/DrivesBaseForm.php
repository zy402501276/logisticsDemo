<?php
class DrivesBaseForm extends BaseForm {
	public $dId;
	public $driverName;
	public $contactNumber;
	public $emergencyContact;
	public $emergencyNumber;
	public $driveImg;
	public $provinceId;
	public $cityId;
	public $areaId;
	public $address;
	public $dState;
	public $authState;
	public $createTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('driverName, contactNumber, emergencyContact, emergencyNumber, driveImg', 'required'),
			array('provinceId, cityId, areaId, dState, authState', 'numerical', 'integerOnly'=>true),
			array('driverName, emergencyContact', 'length', 'max'=>20),
			array('contactNumber, emergencyNumber', 'length', 'max'=>11),
			array('driveImg, address', 'length', 'max'=>50),
			array('createTime', 'safe'),
			array('provinceId, cityId, areaId, address, dState, authState, createTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'dId' => Yii::t('app', 'ID'),
			'driverName' => Yii::t('app', '司机姓名'),
			'contactNumber' => Yii::t('app', '联系电话'),
			'emergencyContact' => Yii::t('app', '紧急联系人'),
			'emergencyNumber' => Yii::t('app', '紧急联系电话'),
			'driveImg' => Yii::t('app', '司机照片'),
			'provinceId' => Yii::t('app', '省'),
			'cityId' => Yii::t('app', '市'),
			'areaId' => Yii::t('app', '区'),
			'address' => Yii::t('app', '详细地址'),
			'dState' => Yii::t('app', '司机状态,1[启用],-1[停用]'),
			'authState' => Yii::t('app', '司机认证状态 0[待审核] 1[审核通过] -1[审核失败]'),
			'createTime' => Yii::t('app', '创建时间'),
		);
	}
	
	public function save() {
		$model = new Drives();
		if (!$this->dId) {
			return $model->save(array(
				'driverName' => $this->driverName,
				'contactNumber' => $this->contactNumber,
				'emergencyContact' => $this->emergencyContact,
				'emergencyNumber' => $this->emergencyNumber,
				'driveImg' => $this->driveImg,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'address' => $this->address,
				'dState' => $this->dState,
				'authState' => $this->authState,
				'createTime' => $this->createTime,
			));
		} else {
			$model->updateByPk($this->dId, array(
				'driverName' => $this->driverName,
				'contactNumber' => $this->contactNumber,
				'emergencyContact' => $this->emergencyContact,
				'emergencyNumber' => $this->emergencyNumber,
				'driveImg' => $this->driveImg,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'address' => $this->address,
				'dState' => $this->dState,
				'authState' => $this->authState,
				'createTime' => $this->createTime,
			));
		}
	}

	public function search() {
		$model = new Drives();
		
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