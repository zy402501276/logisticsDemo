<?php
class DynamicBaseForm extends BaseForm {
	public $id;
	public $title;
	public $url;
	public $creatTime;
	public $state;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('title, url', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('url', 'length', 'max'=>150),
			array('creatTime', 'safe'),
			array('creatTime, state', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'title' => Yii::t('app', '标题'),
			'url' => Yii::t('app', '链接地址'),
			'creatTime' => Yii::t('app', '创建时间'),
			'state' => Yii::t('app', '状态 1[有效] 0[无效]'),
		);
	}
	
	public function save() {
		$model = new Dynamic();
		if (!$this->id) {
			return $model->save(array(
				'title' => $this->title,
				'url' => $this->url,
				'creatTime' => $this->creatTime,
				'state' => $this->state,
			));
		} else {
			$model->updateByPk($this->id, array(
				'title' => $this->title,
				'url' => $this->url,
				'creatTime' => $this->creatTime,
				'state' => $this->state,
			));
		}
	}

	public function search() {
		$model = new Dynamic();
		
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