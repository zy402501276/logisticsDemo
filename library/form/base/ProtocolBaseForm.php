<?php
class ProtocolBaseForm extends BaseForm {
	public $id;
	public $title;
	public $content;
	public $author;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('title', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('title, author', 'length', 'max'=>20),
			array('content', 'length', 'max'=>40),
			array('createTime, updateTime', 'safe'),
			array('content, author, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '协议表主键id'),
			'title' => Yii::t('app', '标题'),
			'content' => Yii::t('app', '协议'),
			'author' => Yii::t('app', '作者'),
			'state' => Yii::t('app', '状态[1 启用| 0禁用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new Protocol();
		if (!$this->id) {
			return $model->save(array(
				'title' => $this->title,
				'content' => $this->content,
				'author' => $this->author,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'title' => $this->title,
				'content' => $this->content,
				'author' => $this->author,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Protocol();
		
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