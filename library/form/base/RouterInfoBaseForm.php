<?php
class RouterInfoBaseForm extends BaseForm {
	public $id;
	public $routerId;
	public $type;
	public $addressId;
	public $routerName;
	public $tag;
	public $addressName;
	public $sort;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('routerId', 'required'),
			array('type, state', 'numerical', 'integerOnly'=>true),
			array('routerId, addressId, sort', 'length', 'max'=>11),
			array('routerName, addressName', 'length', 'max'=>40),
			array('tag', 'length', 'max'=>20),
			array('createTime, updateTime', 'safe'),
			array('type, addressId, routerName, tag, addressName, sort, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '详细路线表主键id'),
			'routerId' => Yii::t('app', '路线-关联router主键id'),
			'type' => Yii::t('app', '线路类型[1 起点 |2 途径点 | 3 终点]'),
			'addressId' => Yii::t('app', '地址-关联address主键di'),
			'routerName' => Yii::t('app', '线路名'),
			'tag' => Yii::t('app', '地址标签'),
			'addressName' => Yii::t('app', '地址详情'),
			'sort' => Yii::t('app', '排序'),
			'state' => Yii::t('app', '状态[1正常| 0 禁用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
		);
	}
	
	public function save() {
		$model = new RouterInfo();
		if (!$this->id) {
			return $model->save(array(
				'routerId' => $this->routerId,
				'type' => $this->type,
				'addressId' => $this->addressId,
				'routerName' => $this->routerName,
				'tag' => $this->tag,
				'addressName' => $this->addressName,
				'sort' => $this->sort,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'routerId' => $this->routerId,
				'type' => $this->type,
				'addressId' => $this->addressId,
				'routerName' => $this->routerName,
				'tag' => $this->tag,
				'addressName' => $this->addressName,
				'sort' => $this->sort,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new RouterInfo();
		
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