<?php
class AdminCompanyInfoForm extends CompanyInfoBaseForm{
     public function rules() {
        $rules = parent::rules();
        $childRules = array(
              array('companyIdCard', 'identityCartValidate'),
        );
        return CMap::mergeArray($rules, $childRules);
        
    }
    /**
     * 验证法人身份证号是否正确
     * @param type $identityCart 手机号码
     * @return boolean true 正确 false 错误
     */
    public function identityCartValidate($attribute,$params) {
        if (!$this->$attribute) {
            return true;
        }
        Yii::import('ext.validator.IdentityCardValidator');
        $identityCardValidator = new IdentityCardValidator();
        if (!$identityCardValidator->validateValue($this->$attribute)) {
            $this->addError($attribute, '法人身份证号不正确!');
            return false;
           
        }
        return true;
    }
}