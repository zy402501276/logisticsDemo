<?php
class AdminForm extends AdminBaseForm {
    /**
     * 验证帐号登录
     */
    public function checkUserLogin() {
        
        $item = Admin::model()->findUserName($this->username);
        if (!$item) {
            return false;
        }
        if (Admin::generatePassword($this->password) != $item["password"] || Admin::STATUS_VALID != $item["accountState"]) {
            return false;
        }
        return $item;
    }


}