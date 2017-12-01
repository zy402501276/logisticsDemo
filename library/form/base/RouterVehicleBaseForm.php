<?php
class RouterVehicleBaseForm extends BaseForm {
	public $id;
	public $type;
	public $length;
	public $weight;
	public $routerId;
	public $cost;
	public $costState;
	public $costAdvice;
	public $routerName;
	public $routerDesc;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('type, length, weight, routerId', 'required'),
			array('costState', 'numerical', 'integerOnly'=>true),
			array('type, length, weight, routerId, state', 'length', 'max'=>11),
			array('cost, costAdvice, routerDesc', 'length', 'max'=>20),
			array('routerName', 'length', 'max'=>40),
			array('createTime, updateTime', 'safe'),
			array('cost, costState, costAdvice, routerName, routerDesc, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'type' => Yii::t('app', '类型-关联车辆类型表主键'),
			'length' => Yii::t('app', '长度-关联车辆长度表主键'),
			'weight' => Yii::t('app', '重量-关联车辆吨位表主键'),
			'routerId' => Yii::t('app', '线路-关联router表主键'),
			'cost' => Yii::t('app', '报价'),
			'costState' => Yii::t('app', '报价状态[1未报价 |2已报价 | 3已确定 | 4 申请重新报价]'),
			'costAdvice' => Yii::t('app', '重新申请报价'),
			'routerName' => Yii::t('app', '线路信息'),
			'routerDesc' => Yii::t('app', '路况信息'),
			'state' => Yii::t('app', '状态[1启用| 0禁止]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new RouterVehicle();
		if (!$this->id) {
			return $model->save(array(
				'type' => $this->type,
				'length' => $this->length,
				'weight' => $this->weight,
				'routerId' => $this->routerId,
				'cost' => $this->cost,
				'costState' => $this->costState,
				'costAdvice' => $this->costAdvice,
				'routerName' => $this->routerName,
				'routerDesc' => $this->routerDesc,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'type' => $this->type,
				'length' => $this->length,
				'weight' => $this->weight,
				'routerId' => $this->routerId,
				'cost' => $this->cost,
				'costState' => $this->costState,
				'costAdvice' => $this->costAdvice,
				'routerName' => $this->routerName,
				'routerDesc' => $this->routerDesc,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new RouterVehicle();
		
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