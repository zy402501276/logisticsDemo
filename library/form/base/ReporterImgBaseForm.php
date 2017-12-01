<?php
class ReporterImgBaseForm extends BaseForm {
	public $id;
	public $rId;
	public $img;
	public $createTime;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('rId', 'length', 'max'=>11),
			array('img', 'length', 'max'=>60),
			array('createTime', 'safe'),
			array('rId, img, createTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', '照片表主键'),
			'rId' => Yii::t('app', '报告-关联reporter表主键'),
			'img' => Yii::t('app', '图片'),
			'createTime' => Yii::t('app', '新增时间'),
		);
	}
	
	public function save() {
		$model = new ReporterImg();
		if (!$this->id) {
			return $model->save(array(
				'rId' => $this->rId,
				'img' => $this->img,
				'createTime' => $this->createTime,
			));
		} else {
			$model->updateByPk($this->id, array(
				'rId' => $this->rId,
				'img' => $this->img,
				'createTime' => $this->createTime,
			));
		}
	}

	public function search() {
		$model = new ReporterImg();
		
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