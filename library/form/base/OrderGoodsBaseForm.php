<?php
class OrderGoodsBaseForm extends BaseForm {
	public $id;
	public $orderId;
	public $goodsId;
	public $goodsName;
	public $goodsType;
	public $goodsWeight;
	public $goodsLength;
	public $goodsWidth;
	public $goodsHeight;
	public $highestC;
	public $lowestC;
	public $pallet;
	public $palletSize;
	public $desc;
	public $modelName;
	public $isModel;
	public $isUsing;
	public $isFrequence;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('isModel, isUsing, isFrequence', 'numerical', 'integerOnly'=>true),
			array('orderId, goodsId', 'length', 'max'=>11),
			array('goodsName, modelName', 'length', 'max'=>20),
			array('goodsType, goodsWeight, goodsLength, goodsWidth, goodsHeight, highestC, lowestC, pallet, palletSize', 'length', 'max'=>10),
			array('desc', 'length', 'max'=>40),
			array('createTime, updateTime', 'safe'),
			array('orderId, goodsId, goodsName, goodsType, goodsWeight, goodsLength, goodsWidth, goodsHeight, highestC, lowestC, pallet, palletSize, desc, modelName, isModel, isUsing, isFrequence, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '订单货物表主键id'),
			'orderId' => Yii::t('app', '订单-关联order表主键'),
			'goodsId' => Yii::t('app', '货物-关联goods主键'),
			'goodsName' => Yii::t('app', '货物名称'),
			'goodsType' => Yii::t('app', '货物类型'),
			'goodsWeight' => Yii::t('app', '重量'),
			'goodsLength' => Yii::t('app', '货物长度'),
			'goodsWidth' => Yii::t('app', '宽'),
			'goodsHeight' => Yii::t('app', '高'),
			'highestC' => Yii::t('app', '最高温'),
			'lowestC' => Yii::t('app', '最低温'),
			'pallet' => Yii::t('app', '托盘个数'),
			'palletSize' => Yii::t('app', '托盘尺寸'),
			'desc' => Yii::t('app', 'Desc'),
			'modelName' => Yii::t('app', '模板名'),
			'isModel' => Yii::t('app', '是否模板[1是 | 0 否]'),
			'isUsing' => Yii::t('app', '是否模板[1是 | 0 否]'),
			'isFrequence' => Yii::t('app', '是否常用[1 常用 | 0 不常用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后修改时间'),
		);
	}
	
	public function save() {
		$model = new OrderGoods();
		if (!$this->id) {
			return $model->save(array(
				'orderId' => $this->orderId,
				'goodsId' => $this->goodsId,
				'goodsName' => $this->goodsName,
				'goodsType' => $this->goodsType,
				'goodsWeight' => $this->goodsWeight,
				'goodsLength' => $this->goodsLength,
				'goodsWidth' => $this->goodsWidth,
				'goodsHeight' => $this->goodsHeight,
				'highestC' => $this->highestC,
				'lowestC' => $this->lowestC,
				'pallet' => $this->pallet,
				'palletSize' => $this->palletSize,
				'desc' => $this->desc,
				'modelName' => $this->modelName,
				'isModel' => $this->isModel,
				'isUsing' => $this->isUsing,
				'isFrequence' => $this->isFrequence,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'orderId' => $this->orderId,
				'goodsId' => $this->goodsId,
				'goodsName' => $this->goodsName,
				'goodsType' => $this->goodsType,
				'goodsWeight' => $this->goodsWeight,
				'goodsLength' => $this->goodsLength,
				'goodsWidth' => $this->goodsWidth,
				'goodsHeight' => $this->goodsHeight,
				'highestC' => $this->highestC,
				'lowestC' => $this->lowestC,
				'pallet' => $this->pallet,
				'palletSize' => $this->palletSize,
				'desc' => $this->desc,
				'modelName' => $this->modelName,
				'isModel' => $this->isModel,
				'isUsing' => $this->isUsing,
				'isFrequence' => $this->isFrequence,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new OrderGoods();
		
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