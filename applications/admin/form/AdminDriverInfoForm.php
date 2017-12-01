<?php
class AdminDriverInfoForm extends DriverInfoBaseForm {
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
              array('idcard', 'identityCartValidate'),
        );
        return CMap::mergeArray($rules, $childRules);
        
    }
    /**
     * 验证身份证号码是否正确
     * @param type $identityCart 手机号码
     * @return boolean true 正确 false 错误
     */
    public function identityCartValidate($attribute,$params) {
//        $item = DriverInfo::model()->findIdCardRow($this->$attribute);
//        if($item){
//            $this->addError($attribute, '身份证号已存在!');
//            return false;
//        }
        if (!$this->$attribute) {
            return true;
        }
        Yii::import('ext.validator.IdentityCardValidator');
        $identityCardValidator = new IdentityCardValidator();
        if (!$identityCardValidator->validateValue($this->$attribute)) {
            $this->addError($attribute, '身份证号不正确!');
            return false;
           
        }
        return true;
    }
}

