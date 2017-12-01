<?php
class AdminBaseForm extends BaseForm {
	public $adminId;
	public $username;
	public $password;
	public $isSupper;
	public $accountState;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('username, password', 'required'),
			array('accountState', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password', 'length', 'max'=>32),
			array('isSupper', 'length', 'max'=>11),
			array('isSupper, accountState', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'adminId' => Yii::t('app', '管理员ID'),
			'username' => Yii::t('app', '管理员名称'),
			'password' => Yii::t('app', '密码'),
			'isSupper' => Yii::t('app', '角色ID'),
			'accountState' => Yii::t('app', '账号状态,1[有效],0[无效]'),
		);
	}
	
	public function save() {
		$model = new Admin();
		if (!$this->adminId) {
			return $model->save(array(
				'username' => $this->username,
				'password' => $this->password,
				'isSupper' => $this->isSupper,
				'accountState' => $this->accountState,
			));
		} else {
			$model->updateByPk($this->adminId, array(
				'username' => $this->username,
				'password' => $this->password,
				'isSupper' => $this->isSupper,
				'accountState' => $this->accountState,
			));
		}
	}

	public function search() {
		$model = new Admin();
		
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