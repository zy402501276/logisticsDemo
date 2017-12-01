<?php
class MenuBaseForm extends BaseForm {
	public $id;
	public $title;
	public $pId;
	public $state;
	public $sort;
	public $controller;
	public $action;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('state', 'numerical', 'integerOnly'=>true),
			array('title, controller, action', 'length', 'max'=>20),
			array('pId, sort', 'length', 'max'=>11),
			array('title, pId, state, sort, controller, action', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'id'),
			'title' => Yii::t('app', '标题'),
			'pId' => Yii::t('app', '父级Id'),
			'state' => Yii::t('app', '状态[1启用 |0禁用]'),
			'sort' => Yii::t('app', '排序'),
			'controller' => Yii::t('app', '控制器名'),
			'action' => Yii::t('app', '方法名'),
		);
	}
	
	public function save() {
		$model = new Menu();
		if (!$this->id) {
			return $model->save(array(
				'title' => $this->title,
				'pId' => $this->pId,
				'state' => $this->state,
				'sort' => $this->sort,
				'controller' => $this->controller,
				'action' => $this->action,
			));
		} else {
			$model->updateByPk($this->id, array(
				'title' => $this->title,
				'pId' => $this->pId,
				'state' => $this->state,
				'sort' => $this->sort,
				'controller' => $this->controller,
				'action' => $this->action,
			));
		}
	}

	public function search() {
		$model = new Menu();
		
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