<?php
class CompanyBaseForm extends BaseForm {
	public $cId;
	public $companyName;
	public $companyShortName;
	public $contactPhone;
	public $contactName;
	public $provinceId;
	public $cityId;
	public $areaId;
	public $adress;
	public $state;
	public $isAuth;
	public $creatTime;
	public $userId;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('companyName, companyShortName, contactPhone, contactName', 'required'),
			array('provinceId, cityId, areaId, state, isAuth, userId', 'numerical', 'integerOnly'=>true),
			array('companyName, companyShortName, adress', 'length', 'max'=>50),
			array('contactPhone', 'length', 'max'=>11),
			array('contactName', 'length', 'max'=>20),
			array('creatTime', 'safe'),
			array('provinceId, cityId, areaId, adress, state, isAuth, creatTime, userId', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'cId' => Yii::t('app', '公司ID'),
			'companyName' => Yii::t('app', '公司名称'),
			'companyShortName' => Yii::t('app', '公司简称'),
			'contactPhone' => Yii::t('app', '公司电话'),
			'contactName' => Yii::t('app', '公司联系人'),
			'provinceId' => Yii::t('app', '省'),
			'cityId' => Yii::t('app', '市'),
			'areaId' => Yii::t('app', '区'),
			'adress' => Yii::t('app', '详细地址'),
			'state' => Yii::t('app', '公司状态 1[正常] 0[关闭]'),
			'isAuth' => Yii::t('app', '审核状态 0[未提交审核] 1[审核中] 2[审核通过] -1[审核不通过]'),
			'creatTime' => Yii::t('app', '创建时间'),
			'userId' => Yii::t('app', '用户-关联user表主键'),
		);
	}
	
	public function save() {
		$model = new Company();
		if (!$this->cId) {
			return $model->save(array(
				'companyName' => $this->companyName,
				'companyShortName' => $this->companyShortName,
				'contactPhone' => $this->contactPhone,
				'contactName' => $this->contactName,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'adress' => $this->adress,
				'state' => $this->state,
				'isAuth' => $this->isAuth,
				'creatTime' => $this->creatTime,
				'userId' => $this->userId,
			));
		} else {
			$model->updateByPk($this->cId, array(
				'companyName' => $this->companyName,
				'companyShortName' => $this->companyShortName,
				'contactPhone' => $this->contactPhone,
				'contactName' => $this->contactName,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'adress' => $this->adress,
				'state' => $this->state,
				'isAuth' => $this->isAuth,
				'creatTime' => $this->creatTime,
				'userId' => $this->userId,
			));
		}
	}

	public function search() {
		$model = new Company();
		
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