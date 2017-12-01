<?php
class CompanyInfoBaseForm extends BaseForm {
	public $id;
	public $cId;
	public $orgNum;
	public $companyUsername;
	public $companyIdCard;
	public $busLiceUrl;
	public $creatTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('cId', 'required'),
			array('cId', 'numerical', 'integerOnly'=>true),
			array('orgNum, companyUsername, companyIdCard', 'length', 'max'=>20),
			array('busLiceUrl', 'length', 'max'=>64),
			array('creatTime', 'safe'),
			array('orgNum, companyUsername, companyIdCard, busLiceUrl, creatTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'cId' => Yii::t('app', '公司ID'),
			'orgNum' => Yii::t('app', '组织机构代码'),
			'companyUsername' => Yii::t('app', '公司法人姓名'),
			'companyIdCard' => Yii::t('app', '法人身份证号'),
			'busLiceUrl' => Yii::t('app', '营业执照扫描图'),
			'creatTime' => Yii::t('app', '创建时间'),
		);
	}
	
	public function save() {
		$model = new CompanyInfo();
		if (!$this->id) {
			return $model->save(array(
				'cId' => $this->cId,
				'orgNum' => $this->orgNum,
				'companyUsername' => $this->companyUsername,
				'companyIdCard' => $this->companyIdCard,
				'busLiceUrl' => $this->busLiceUrl,
				'creatTime' => $this->creatTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'cId' => $this->cId,
				'orgNum' => $this->orgNum,
				'companyUsername' => $this->companyUsername,
				'companyIdCard' => $this->companyIdCard,
				'busLiceUrl' => $this->busLiceUrl,
				'creatTime' => $this->creatTime,
			));
		}
	}

	public function search() {
		$model = new CompanyInfo();
		
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