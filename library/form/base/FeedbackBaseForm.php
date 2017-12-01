<?php
class FeedbackBaseForm extends BaseForm {
	public $id;
	public $userId;
	public $content;
	public $createTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('userId, content, createTime', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>150),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'userId' => Yii::t('app', '用户id'),
			'content' => Yii::t('app', '反馈内容'),
			'createTime' => Yii::t('app', '反馈时间'),
		);
	}
	
	public function save() {
		$model = new Feedback();
		if (!$this->id) {
			return $model->save(array(
				'userId' => $this->userId,
				'content' => $this->content,
				'createTime' => $this->createTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'userId' => $this->userId,
				'content' => $this->content,
				'createTime' => $this->createTime,
			));
		}
	}

	public function search() {
		$model = new Feedback();
		
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