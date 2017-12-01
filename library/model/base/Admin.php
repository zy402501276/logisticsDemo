<?php
class Admin extends BaseModel {
        /**
        * 状态 -- 有效
        */
        CONST STATUS_VALID = 1;

        /**
        * 状态 -- 无效
        */
        CONST STATUS_INVALID = 0;
	public static function getTableName() {
		return 'Admin';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	/**
        * 通过管理员名称获取用户信息
        * @param type $username
        * @return type
        */
        public function findUserName($username) {
            $criteria = new CDbCriteria();
            $criteria->compare('username', $username);
            return self::model()->query($criteria, 'queryRow');
        }

       /**
        * 生成密码
        * @param type $password
        * @return type
        */
        public static function generatePassword($password) {
            return md5($password);
        }
}