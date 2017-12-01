<?php
class AddressBaseForm extends BaseForm {
	public $id;
	public $userId;
	public $provinceId;
	public $cityId;
	public $areaId;
	public $address;
	public $detail;
	public $companyName;
	public $tag;
	public $longitude;
	public $latitude;
	public $state;
	public $createTime;
	public $updateTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('companyName', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('userId, provinceId, cityId, areaId', 'length', 'max'=>11),
			array('address, companyName', 'length', 'max'=>40),
			array('detail', 'length', 'max'=>60),
			array('tag, longitude, latitude', 'length', 'max'=>20),
			array('createTime, updateTime', 'safe'),
			array('userId, provinceId, cityId, areaId, address, detail, tag, longitude, latitude, state, createTime, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '地址表主键id'),
			'userId' => Yii::t('app', '用户id'),
			'provinceId' => Yii::t('app', '省级id'),
			'cityId' => Yii::t('app', '市级id'),
			'areaId' => Yii::t('app', '区id'),
			'address' => Yii::t('app', '详细地址'),
			'detail' => Yii::t('app', '完整地址'),
			'companyName' => Yii::t('app', '公司名称'),
			'tag' => Yii::t('app', '标签'),
			'longitude' => Yii::t('app', '经度'),
			'latitude' => Yii::t('app', '纬度'),
			'state' => Yii::t('app', '状态[1启用 | 0禁用]'),
			'createTime' => Yii::t('app', '创建时间'),
			'updateTime' => Yii::t('app', '最后更新时间'),
		);
	}
	
	public function save() {
		$model = new Address();
		if (!$this->id) {
			return $model->save(array(
				'userId' => $this->userId,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'address' => $this->address,
				'detail' => $this->detail,
				'companyName' => $this->companyName,
				'tag' => $this->tag,
				'longitude' => $this->longitude,
				'latitude' => $this->latitude,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'userId' => $this->userId,
				'provinceId' => $this->provinceId,
				'cityId' => $this->cityId,
				'areaId' => $this->areaId,
				'address' => $this->address,
				'detail' => $this->detail,
				'companyName' => $this->companyName,
				'tag' => $this->tag,
				'longitude' => $this->longitude,
				'latitude' => $this->latitude,
				'state' => $this->state,
				'createTime' => $this->createTime,
				'updateTime' => $this->updateTime,
			));
		}
	}

	public function search() {
		$model = new Address();
		
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