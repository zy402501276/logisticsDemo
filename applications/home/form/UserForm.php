<?php
class UserForm extends UserBaseForm{
	   public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('email,mobile','required','message' => '{attribute}不能为空','on'=>'add'),
            array('mobile', 'checkMoblie','message'=> '格式错误','on'=>'add'),
            array('email', 'checkEmailValidate','message'=> '格式错误','on'=>'add'),
            array('isFirst', 'default','value'=> User::FIRSY_NO,'on'=>'register'),
            array('state,verifyState', 'default','value'=> User::STATE_ON,'on'=>'register'),
            array('createTime,updateTime', 'default','value'=> date('Y-m-d H:i:s'),'on'=>'register'),
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
    /**
     * 验证邮箱地址是否正确
     * @param string $email 邮箱地址
     * @return boolean true 正确 false 错误
     */
    public  function checkEmailValidate($attribute, $params) {
        if (!$this->$attribute) {
            return true;
        }
        $pattern = "/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/";
        if (!empty($this->$attribute) && preg_match($pattern, $this->$attribute)) {
            return true;
        }
        $this->addError($attribute, $params["message"]);
        return false;
    }
}