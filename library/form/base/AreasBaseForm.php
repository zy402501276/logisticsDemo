<?php
class AreasBaseForm extends BaseForm {
	public $aId;
	public $areaName;
	public $areaInitial;
	public $pId;
	public $deep;
	public $sort;
	public $isHot;
	public $aState;
	public $regionalId;
	public $isOpen;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('areaName, areaInitial', 'required'),
			array('deep, sort, isHot, aState, regionalId, isOpen', 'numerical', 'integerOnly'=>true),
			array('areaName', 'length', 'max'=>50),
			array('areaInitial, pId', 'length', 'max'=>10),
			array('pId, deep, sort, isHot, aState, regionalId, isOpen', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'aId' => Yii::t('app', '主键ID'),
			'areaName' => Yii::t('app', '地区名称'),
			'areaInitial' => Yii::t('app', '地区首字母'),
			'pId' => Yii::t('app', '父ID'),
			'deep' => Yii::t('app', '地区层级'),
			'sort' => Yii::t('app', '排序'),
			'isHot' => Yii::t('app', '是否热门城市, 1[是],0[否]'),
			'aState' => Yii::t('app', '状态,1[有效],0[有效]'),
			'regionalId' => Yii::t('app', '所属地域'),
			'isOpen' => Yii::t('app', '是否开通'),
		);
	}
	
	public function save() {
		$model = new Areas();
		if (!$this->aId) {
			return $model->save(array(
				'areaName' => $this->areaName,
				'areaInitial' => $this->areaInitial,
				'pId' => $this->pId,
				'deep' => $this->deep,
				'sort' => $this->sort,
				'isHot' => $this->isHot,
				'aState' => $this->aState,
				'regionalId' => $this->regionalId,
				'isOpen' => $this->isOpen,
			));
		} else {
			$model->updateByPk($this->aId, array(
				'areaName' => $this->areaName,
				'areaInitial' => $this->areaInitial,
				'pId' => $this->pId,
				'deep' => $this->deep,
				'sort' => $this->sort,
				'isHot' => $this->isHot,
				'aState' => $this->aState,
				'regionalId' => $this->regionalId,
				'isOpen' => $this->isOpen,
			));
		}
	}

	public function search() {
		$model = new Areas();
		
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