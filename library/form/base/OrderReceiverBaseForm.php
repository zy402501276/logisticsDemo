<?php
class OrderReceiverBaseForm extends BaseForm {
	public $id;
	public $orderId;
	public $receiverId;
	public $receiver;
	public $getTime;
	public $getState;
	public $area;
	public $exceptionDesc;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('orderId, receiverId', 'required'),
			array('getState, state', 'numerical', 'integerOnly'=>true),
			array('orderId, receiverId', 'length', 'max'=>11),
			array('receiver', 'length', 'max'=>10),
			array('area, exceptionDesc', 'length', 'max'=>40),
			array('getTime, createTime, updateTime', 'safe'),
			array('receiver, getTime, getState, area, exceptionDesc, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '订单-收货人主键id'),
			'orderId' => Yii::t('app', '订单-关联orders表主键'),
			'receiverId' => Yii::t('app', '收货人-关联receiver表主键'),
			'receiver' => Yii::t('app', '收货人名'),
			'getTime' => Yii::t('app', '收货时间'),
			'getState' => Yii::t('app', '收货状态[1待收货 | 2 已收货 | 3 发送异常]'),
			'area' => Yii::t('app', '收货地'),
			'exceptionDesc' => Yii::t('app', '运货异常说明'),
			'state' => Yii::t('app', '状态[1 正常 | 0禁用]'),
			'createTime' => Yii::t('app', '创建时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
		);
	}
	
	public function save() {
		$model = new OrderReceiver();
		if (!$this->id) {
			return $model->save(array(
				'orderId' => $this->orderId,
				'receiverId' => $this->receiverId,
				'receiver' => $this->receiver,
				'getTime' => $this->getTime,
				'getState' => $this->getState,
				'area' => $this->area,
				'exceptionDesc' => $this->exceptionDesc,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'orderId' => $this->orderId,
				'receiverId' => $this->receiverId,
				'receiver' => $this->receiver,
				'getTime' => $this->getTime,
				'getState' => $this->getState,
				'area' => $this->area,
				'exceptionDesc' => $this->exceptionDesc,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new OrderReceiver();
		
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