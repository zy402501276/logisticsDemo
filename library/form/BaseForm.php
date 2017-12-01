<?php

/**
 * form基类
 * @author Administrator
 */
class BaseForm extends CFormModel {

    /**
     * 批量赋值方法
     *
     * @param mixed $values        	
     * @param boolean $safeOnly
     *        	是否安全赋值
     */
    public function setAttributes($values, $safeOnly = false) {
        parent::setAttributes($values, $safeOnly);
    }

    /**
     * 从错误列表里获取第一个错误信息
     */
    public function getFirstError() {
        $err = $this->getErrors();
        $err = array_pop($err);
        return is_array($err) ? array_pop($err) : '';
    }

    /**
     * 验证手机号
     *
     * @param unknown $attribute        	
     * @param unknown $params        	
     * @author shezz
     *         @email zhangxz@pcbdoor.com
     *         @date 2015年10月22日
     */
    public function checkMobilesPhones($attribute, $params) {
        $pattern = '/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/';
        if (empty($this->{$attribute}) || preg_match($pattern, $this->{$attribute})) {
            return true;
        } else {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '格式错误');
            return false;
        }
    }

    /**
     * 验证QQ号
     *
     * @param unknown $attribute        	
     * @param unknown $params        	
     * @author guob
     *         @email zhangxz@pcbdoor.com
     *         @date 2015年10月21日
     */
    public function checkQq($attribute, $params) {
        $reg = '/^\d{5,15}$/';
        if (preg_match($reg, $this->{$attribute})) {
            return true;
        } else {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '格式错误');
            return false;
        }
    }

    /**
     * 验证联系方式是否手机或者固话 
     * @param type $attribute
     * @param type $params
     * @return boolean
     */
    public function checkPhone($attribute, $params) {
        $phone = '/^(\d{2,5}-\d{7,8}(-\d{1,})?)|(13\d{9})|(159\d{8})$/';  //固话
        $mphone = '/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/';   //手机
        if (preg_match($phone, $this->{$attribute}) || preg_match($mphone, $this->{$attribute})) {
            return true;
        } else {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '格式错误');
            return false;
        }
    }

    /**
     * 验证邮箱
     * @param type $attribute
     * @param type $params
     * @return boolean
     */
    public function checkEmail($attribute, $params) {
        //$email = '/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
        $email = '/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/';
        if (preg_match($email, $this->{$attribute})) {
            return true;
        } else {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '格式错误');
            return false;
        }
    }

    /**
     * 获取错误列表
     *
     * @author shezz
     *         @date 2014-8-12
     */
    public function getErrorList($errors) {
        $e = array();
        foreach ($errors as $k => $v) {
            $e [] = $v;
        }
        return $e;
    }

    /**
     * 获取异步表单验证错误提示数据 
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年11月21日
     */
    public function getAjaxTipsErrors() {
        $errors = $this->getErrors();
        $result = array();
        foreach ($errors as $attr => $errs) {
            $result[CHtml::activeId($this, $attr)] = $errs;
        }
        return CJSON::encode($result);
    }

    /**
     * 根据配置的rules数组生成验证类
     * @param array $rule 规则数组 demo:  array('storeId', 'required')
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年11月21日
     */
    public function createValidatorByRules($rule = array()) {
        return CValidator::createValidator($rule[1], $this, $rule[0], array_slice($rule, 2));
    }

}
