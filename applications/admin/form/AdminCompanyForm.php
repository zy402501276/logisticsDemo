<?php
class AdminCompanyForm extends CompanyBaseForm {
    public function search() {
		$model = new Company();
		
		if (!$this->criteria) {
			$this->criteria = new CDbCriteria();
			$this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
			$this->criteria->limit = $this->size;
			$this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
                        $this->criteria->compare('companyName',$this->companyName);
                        $this->criteria->compare('state',$this->state);
                        $this->criteria->compare('isAuth',$this->isAuth);
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
    
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            //修改用户资料
            array('contactPhone', 'checkMoblie','message'=> '公司电话格式错误'),
        );
        return CMap::mergeArray($rules, $childRules);
    }
    /**
     * 验证手机号码是否正确
     * @param type $phone 手机号码
     * @return boolean true 正确 false 错误
     */
    public function checkMoblie($attribute, $params) {
        if (!$this->$attribute) {
            return true;
        }
        Yii::import('ext.validator.PhoneNumberValidator');
        $phoneValidator = new PhoneNumberValidator();
        if (!$phoneValidator->validateValue($this->$attribute)) {
            $this->addError($attribute, $params["message"]);
            return false;
        }
        return true;
    }
}

