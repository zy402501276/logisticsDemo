<?php
class OrdersBaseForm extends BaseForm {
	public $id;
	public $routerId;
	public $userId;
	public $startTime;
	public $endTime;
	public $deliveryTime;
	public $orderNumber;
	public $tranCost;
	public $routerCost;
	public $serviceCost;
	public $sumCost;
	public $exceptionCost;
	public $startRouter;
	public $endRouter;
	public $sumWeight;
	public $sumVolumn;
	public $state;
	public $createTime;
	public $updateTime;
	public $orderState;
	public $arrivaled;
	public $receiver;
	public $isRemind;
	public $distributeTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('routerId', 'required'),
			array('state, orderState, isRemind', 'numerical', 'integerOnly'=>true),
			array('routerId, userId', 'length', 'max'=>11),
			array('orderNumber', 'length', 'max'=>40),
			array('tranCost, routerCost, serviceCost, sumCost, exceptionCost, sumWeight, sumVolumn', 'length', 'max'=>20),
			array('startRouter, endRouter', 'length', 'max'=>50),
			array('arrivaled', 'length', 'max'=>10),
			array('receiver', 'length', 'max'=>30),
			array('startTime, endTime, deliveryTime, createTime, updateTime, distributeTime', 'safe'),
			array('userId, startTime, endTime, deliveryTime, orderNumber, tranCost, routerCost, serviceCost, sumCost, exceptionCost, startRouter, endRouter, sumWeight, sumVolumn, state, createTime, updateTime, orderState, arrivaled, receiver, isRemind, distributeTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '订单表主键id'),
			'routerId' => Yii::t('app', '线路-关联router表主键'),
			'userId' => Yii::t('app', '用户-关联user表主键'),
			'startTime' => Yii::t('app', '装货时间日期'),
			'endTime' => Yii::t('app', '装货完成日期时间'),
			'deliveryTime' => Yii::t('app', '预达时间'),
			'orderNumber' => Yii::t('app', '订单号'),
			'tranCost' => Yii::t('app', '总运费'),
			'routerCost' => Yii::t('app', '沿途收费'),
			'serviceCost' => Yii::t('app', '服务费'),
			'sumCost' => Yii::t('app', '总费用'),
			'exceptionCost' => Yii::t('app', '异常收货费用'),
			'startRouter' => Yii::t('app', '出发地'),
			'endRouter' => Yii::t('app', '终点'),
			'sumWeight' => Yii::t('app', '总重量'),
			'sumVolumn' => Yii::t('app', '总体积'),
			'state' => Yii::t('app', '状态[1 正常 | 0禁用]'),
			'createTime' => Yii::t('app', '创建时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
			'orderState' => Yii::t('app', '收货状态[1待收货 | 2 运输中 |  3 已签收 | 4 异常]'),
			'arrivaled' => Yii::t('app', '目前到站'),
			'receiver' => Yii::t('app', '收货信息'),
			'isRemind' => Yii::t('app', '是否催单'),
			'distributeTime' => Yii::t('app', '派单时间'),
		);
	}
	
	public function save() {
		$model = new Orders();
		if (!$this->id) {
			return $model->save(array(
				'routerId' => $this->routerId,
				'userId' => $this->userId,
				'startTime' => $this->startTime,
				'endTime' => $this->endTime,
				'deliveryTime' => $this->deliveryTime,
				'orderNumber' => $this->orderNumber,
				'tranCost' => $this->tranCost,
				'routerCost' => $this->routerCost,
				'serviceCost' => $this->serviceCost,
				'sumCost' => $this->sumCost,
				'exceptionCost' => $this->exceptionCost,
				'startRouter' => $this->startRouter,
				'endRouter' => $this->endRouter,
				'sumWeight' => $this->sumWeight,
				'sumVolumn' => $this->sumVolumn,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'orderState' => $this->orderState,
				'arrivaled' => $this->arrivaled,
				'receiver' => $this->receiver,
				'isRemind' => $this->isRemind,
				'distributeTime' => $this->distributeTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'routerId' => $this->routerId,
				'userId' => $this->userId,
				'startTime' => $this->startTime,
				'endTime' => $this->endTime,
				'deliveryTime' => $this->deliveryTime,
				'orderNumber' => $this->orderNumber,
				'tranCost' => $this->tranCost,
				'routerCost' => $this->routerCost,
				'serviceCost' => $this->serviceCost,
				'sumCost' => $this->sumCost,
				'exceptionCost' => $this->exceptionCost,
				'startRouter' => $this->startRouter,
				'endRouter' => $this->endRouter,
				'sumWeight' => $this->sumWeight,
				'sumVolumn' => $this->sumVolumn,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
				'orderState' => $this->orderState,
				'arrivaled' => $this->arrivaled,
				'receiver' => $this->receiver,
				'isRemind' => $this->isRemind,
				'distributeTime' => $this->distributeTime,
			));
		}
	}

	public function search() {
		$model = new Orders();
		
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