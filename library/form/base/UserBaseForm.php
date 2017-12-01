<?php
class UserBaseForm extends BaseForm {
	public $id;
	public $name;
	public $licenseCode;
	public $companyName;
	public $companyPhone;
	public $mobile;
	public $contacts;
	public $gender;
	public $address;
	public $email;
	public $licenseUrl;
	public $verifyState;
	public $verifyAdvice;
	public $state;
	public $utoken;
	public $isFirst;
	public $createTime;
	public $updateTime;
	public $pId;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('gender, verifyState, state, isFirst', 'numerical', 'integerOnly'=>true),
			array('name, companyName, companyPhone, mobile', 'length', 'max'=>20),
			array('licenseCode, address, email', 'length', 'max'=>40),
			array('contacts', 'length', 'max'=>10),
			array('licenseUrl', 'length', 'max'=>60),
			array('verifyAdvice', 'length', 'max'=>30),
			array('utoken', 'length', 'max'=>32),
			array('pId', 'length', 'max'=>11),
			array('createTime, updateTime', 'safe'),
			array('name, licenseCode, companyName, companyPhone, mobile, contacts, gender, address, email, licenseUrl, verifyState, verifyAdvice, state, utoken, isFirst, createTime, updateTime, pId', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '用户id'),
			'name' => Yii::t('app', '用户名'),
			'licenseCode' => Yii::t('app', '企业组织代码'),
			'companyName' => Yii::t('app', '公司名'),
			'companyPhone' => Yii::t('app', '联系固话'),
			'mobile' => Yii::t('app', '手机号'),
			'contacts' => Yii::t('app', '联系人'),
			'gender' => Yii::t('app', '性别[1男 | 2女 | 3保密]'),
			'address' => Yii::t('app', '公司地址'),
			'email' => Yii::t('app', '用户邮箱'),
			'licenseUrl' => Yii::t('app', '营业执照图片链接'),
			'verifyState' => Yii::t('app', '审核状态[1未提交审核 | 2 审核中 | 3审核通过 | 4审核失败]'),
			'verifyAdvice' => Yii::t('app', '审核意见'),
			'state' => Yii::t('app', '用户状态[1 正常 | 0禁用]'),
			'utoken' => Yii::t('app', '唯一码'),
			'isFirst' => Yii::t('app', '是否同意[1  同意 | 0不同意 ]'),
			'createTime' => Yii::t('app', '创建时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
			'pId' => Yii::t('app', '用户中心user表主键id'),
		);
	}
	
	public function save() {
		$model = new User();
		if (!$this->id) {
			return $model->save(array(
				'name' => $this->name,
				'licenseCode' => $this->licenseCode,
				'companyName' => $this->companyName,
				'companyPhone' => $this->companyPhone,
				'mobile' => $this->mobile,
				'contacts' => $this->contacts,
				'gender' => $this->gender,
				'address' => $this->address,
				'email' => $this->email,
				'licenseUrl' => $this->licenseUrl,
				'verifyState' => $this->verifyState,
				'verifyAdvice' => $this->verifyAdvice,
				'state' => $this->state,
				'utoken' => $this->utoken,
				'isFirst' => $this->isFirst,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'pId' => $this->pId,
			));
		} else {
			$model->updateByPk($this->id, array(
				'name' => $this->name,
				'licenseCode' => $this->licenseCode,
				'companyName' => $this->companyName,
				'companyPhone' => $this->companyPhone,
				'mobile' => $this->mobile,
				'contacts' => $this->contacts,
				'gender' => $this->gender,
				'address' => $this->address,
				'email' => $this->email,
				'licenseUrl' => $this->licenseUrl,
				'verifyState' => $this->verifyState,
				'verifyAdvice' => $this->verifyAdvice,
				'state' => $this->state,
				'utoken' => $this->utoken,
				'isFirst' => $this->isFirst,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'pId' => $this->pId,
			));
		}
	}

	public function search() {
		$model = new User();
		
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