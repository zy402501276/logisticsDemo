<?php
class GoodsBaseForm extends BaseForm {
	public $id;
	public $goodsName;
	public $goodsType;
	public $goodsWeight;
	public $goodsLength;
	public $goodsWidth;
	public $goodsHeight;
	public $isUsing;
	public $highestC;
	public $lowestC;
	public $pallets;
	public $palletSize;
	public $desc;
	public $isFrequence;
	public $isModel;
	public $modelName;
	public $userId;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('goodsName', 'required'),
			array('isUsing, isFrequence, isModel, state', 'numerical', 'integerOnly'=>true),
			array('goodsName, goodsWeight, highestC, lowestC, desc, modelName', 'length', 'max'=>20),
			array('goodsType, userId', 'length', 'max'=>11),
			array('goodsLength, goodsWidth, goodsHeight, pallets, palletSize', 'length', 'max'=>10),
			array('createTime, updateTime', 'safe'),
			array('goodsType, goodsWeight, goodsLength, goodsWidth, goodsHeight, isUsing, highestC, lowestC, pallets, palletSize, desc, isFrequence, isModel, modelName, userId, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '货物表主键id'),
			'goodsName' => Yii::t('app', '货物名称'),
			'goodsType' => Yii::t('app', '货物类型-关联goodsTypes表主键'),
			'goodsWeight' => Yii::t('app', '重量'),
			'goodsLength' => Yii::t('app', '长'),
			'goodsWidth' => Yii::t('app', '宽'),
			'goodsHeight' => Yii::t('app', '高'),
			'isUsing' => Yii::t('app', '温度要求[1启用 | 0 禁用]'),
			'highestC' => Yii::t('app', '最高温'),
			'lowestC' => Yii::t('app', '最低温'),
			'pallets' => Yii::t('app', '托盘个数'),
			'palletSize' => Yii::t('app', '托盘尺寸'),
			'desc' => Yii::t('app', '备注'),
			'isFrequence' => Yii::t('app', '是否常用[1是| 0 否]'),
			'isModel' => Yii::t('app', '是否模板[1是| 0 否]'),
			'modelName' => Yii::t('app', '模板名'),
			'userId' => Yii::t('app', '用户-关联user表主键'),
			'state' => Yii::t('app', '状态[1 正常 | 0禁用]'),
			'createTime' => Yii::t('app', '新增时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new Goods();
		if (!$this->id) {
			return $model->save(array(
				'goodsName' => $this->goodsName,
				'goodsType' => $this->goodsType,
				'goodsWeight' => $this->goodsWeight,
				'goodsLength' => $this->goodsLength,
				'goodsWidth' => $this->goodsWidth,
				'goodsHeight' => $this->goodsHeight,
				'isUsing' => $this->isUsing,
				'highestC' => $this->highestC,
				'lowestC' => $this->lowestC,
				'pallets' => $this->pallets,
				'palletSize' => $this->palletSize,
				'desc' => $this->desc,
				'isFrequence' => $this->isFrequence,
				'isModel' => $this->isModel,
				'modelName' => $this->modelName,
				'userId' => $this->userId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'goodsName' => $this->goodsName,
				'goodsType' => $this->goodsType,
				'goodsWeight' => $this->goodsWeight,
				'goodsLength' => $this->goodsLength,
				'goodsWidth' => $this->goodsWidth,
				'goodsHeight' => $this->goodsHeight,
				'isUsing' => $this->isUsing,
				'highestC' => $this->highestC,
				'lowestC' => $this->lowestC,
				'pallets' => $this->pallets,
				'palletSize' => $this->palletSize,
				'desc' => $this->desc,
				'isFrequence' => $this->isFrequence,
				'isModel' => $this->isModel,
				'modelName' => $this->modelName,
				'userId' => $this->userId,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Goods();
		
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