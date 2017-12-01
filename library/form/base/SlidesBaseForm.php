<?php
class SlidesBaseForm extends BaseForm {
	public $id;
	public $url;
	public $linkUrl;
	public $creatTime;
	public $pos;
		
	public $criteria;
	public $page = 1;
	public $size = 15;
	
	public function rules() {
		return array(
			array('url, pos', 'required'),
			array('pos', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>64),
			array('linkUrl', 'length', 'max'=>150),
			array('creatTime', 'safe'),
			array('linkUrl, creatTime', 'default', 'setOnEmpty' => true, 'value' => null),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'url' => Yii::t('app', '图片地址'),
			'linkUrl' => Yii::t('app', '链接地址'),
			'creatTime' => Yii::t('app', '创建时间'),
			'pos' => Yii::t('app', '广告位置 1[头部] 2[底部左侧] 3[底部右侧]'),
		);
	}
	
	public function save() {
		$model = new Slides();
		if (!$this->id) {
			return $model->save(array(
				'url' => $this->url,
				'linkUrl' => $this->linkUrl,
				'creatTime' => $this->creatTime,
				'pos' => $this->pos,
			));
		} else {
			$model->updateByPk($this->id, array(
				'url' => $this->url,
				'linkUrl' => $this->linkUrl,
				'creatTime' => $this->creatTime,
				'pos' => $this->pos,
			));
		}
	}

	public function search() {
		$model = new Slides();
		
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