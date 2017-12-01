<?php
class ReceiverBaseForm extends BaseForm {
	public $id;
	public $name;
	public $companyPhone;
	public $areaCode;
	public $mobile;
	public $job;
	public $gender;
	public $addressId;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('gender, state', 'numerical', 'integerOnly'=>true),
			array('name, companyPhone, mobile', 'length', 'max'=>20),
			array('areaCode, job', 'length', 'max'=>10),
			array('addressId', 'length', 'max'=>11),
			array('createTime, updateTime', 'safe'),
			array('name, companyPhone, areaCode, mobile, job, gender, addressId, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '收货人主键id'),
			'name' => Yii::t('app', '姓名'),
			'companyPhone' => Yii::t('app', '公司固话'),
			'areaCode' => Yii::t('app', '区号'),
			'mobile' => Yii::t('app', '联系电话'),
			'job' => Yii::t('app', '职务'),
			'gender' => Yii::t('app', '性别[1男 | 2女 | 3保密]'),
			'addressId' => Yii::t('app', '地址-关联address主键'),
			'state' => Yii::t('app', '状态[1启用 | 0禁用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new Receiver();
		if (!$this->id) {
			return $model->save(array(
				'name' => $this->name,
				'companyPhone' => $this->companyPhone,
				'areaCode' => $this->areaCode,
				'mobile' => $this->mobile,
				'job' => $this->job,
				'gender' => $this->gender,
				'addressId' => $this->addressId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'name' => $this->name,
				'companyPhone' => $this->companyPhone,
				'areaCode' => $this->areaCode,
				'mobile' => $this->mobile,
				'job' => $this->job,
				'gender' => $this->gender,
				'addressId' => $this->addressId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Receiver();
		
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