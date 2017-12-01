<?php
class InfomationBaseForm extends BaseForm {
	public $id;
	public $title;
	public $content;
	public $type;
	public $userId;
	public $state;
	public $createTime;
	public $updateTime;
	public $isRead;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('type, state, isRead', 'numerical', 'integerOnly'=>true),
			array('title, content', 'length', 'max'=>20),
			array('userId', 'length', 'max'=>11),
			array('createTime, updateTime', 'safe'),
			array('title, content, type, userId, state, createTime, updateTime, isRead', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '信息表主键id'),
			'title' => Yii::t('app', '标题'),
			'content' => Yii::t('app', '内容'),
			'type' => Yii::t('app', '类型[1系统消息]'),
			'userId' => Yii::t('app', '用户id-关联user表主键'),
			'state' => Yii::t('app', '状态[1 启用 | 0禁止]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '更新时间'),
			'isRead' => Yii::t('app', '是否查看[1已查看 |0未查看]'),
		);
	}
	
	public function save() {
		$model = new Infomation();
		if (!$this->id) {
			return $model->save(array(
				'title' => $this->title,
				'content' => $this->content,
				'type' => $this->type,
				'userId' => $this->userId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'isRead' => $this->isRead,
			));
		} else {
			$model->updateByPk($this->id, array(
				'title' => $this->title,
				'content' => $this->content,
				'type' => $this->type,
				'userId' => $this->userId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'isRead' => $this->isRead,
			));
		}
	}

	public function search() {
		$model = new Infomation();
		
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