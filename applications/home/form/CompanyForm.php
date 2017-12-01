<?php
class CompanyForm extends CompanyBaseForm{  
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('companyName,companyShortName,contactPhone,contactName','required','message' => '{attribute}不能为空','on'=>'add'),
            array('contactPhone', 'checkMoblie','message'=> '公司电话格式错误','on'=>'add'),
            array('state', 'default','value'=> Company::STATE_ON,'on'=>'add'),
            array('isAuth', 'default','value'=> Company::ISAUTH_NOT,'on'=> 'add'),
            array('creatTime', 'default','value'=> date('Y-m-d H:i:s'),'on'=> 'add'),
        );
        return CMap::mergeArray($childRules,$rules);
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