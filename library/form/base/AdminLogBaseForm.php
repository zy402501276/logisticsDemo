<?php
class AdminLogBaseForm extends BaseForm {
	public $logId;
	public $id;
	public $type;
	public $content;
	public $remark;
	public $createTime;
	public $adminName;
	public $ip;
	public $act;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('content', 'required'),
			array('id, type', 'numerical', 'integerOnly'=>true),
			array('content, remark', 'length', 'max'=>100),
			array('adminName', 'length', 'max'=>20),
			array('ip, act', 'length', 'max'=>15),
			array('createTime', 'safe'),
			array('id, type, remark, createTime, adminName, ip, act', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'logId' => Yii::t('app', '日志ID'),
			'id' => Yii::t('app', '关联ID'),
			'type' => Yii::t('app', '日志类型 1[企业认证]'),
			'content' => Yii::t('app', '日志内容'),
			'remark' => Yii::t('app', '备注'),
			'createTime' => Yii::t('app', '操作时间'),
			'adminName' => Yii::t('app', '管理员名称'),
			'ip' => Yii::t('app', '操作IP地址'),
			'act' => Yii::t('app', '操作路由'),
		);
	}
	
	public function save() {
		$model = new AdminLog();
		if (!$this->logId) {
			return $model->save(array(
				'id' => $this->id,
				'type' => $this->type,
				'content' => $this->content,
				'remark' => $this->remark,
				'createTime' => $this->createTime,
				'adminName' => $this->adminName,
				'ip' => $this->ip,
				'act' => $this->act,
			));
		} else {
			$model->updateByPk($this->logId, array(
				'id' => $this->id,
				'type' => $this->type,
				'content' => $this->content,
				'remark' => $this->remark,
				'createTime' => $this->createTime,
				'adminName' => $this->adminName,
				'ip' => $this->ip,
				'act' => $this->act,
			));
		}
	}

	public function search() {
		$model = new AdminLog();
		
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