<?php
/**
 * 手机号验证类
 * @author shezz
 * @date 2014-12-23
 */
class PhoneNumberValidator extends CValidator {

	//简单粗暴的形式验证
// 	public $pattern='/^[\d]{11}$/';
	public $pattern='/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/';
	
	protected function validateAttribute($object,$attribute) {
		$value = $object->$attribute;
		if($this->isEmpty($value)) {
			return false;
		}
		if(!$this->validateValue($value)) {
			$message = $this->message !==null ? $this->message:Yii::t('yii','{attribute} 格式错误.');
			$this->addError($object, $attribute, $message);
		}
	}
	
	public function validateValue($value) {
		return preg_match($this->pattern, $value);
	}
}