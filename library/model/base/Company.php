<?php

class Company extends BaseModel {

    /**
     * 企业状态 -- 正常
     */
    CONST STATE_ON = 1;

    /**
     * 企业状态 -- 关闭
     */
    CONST STATE_CLOSE = 0;

    /**
     * 审核状态 -- 未提交审核
     */
    CONST ISAUTH_NOT = 0;

    /**
     * 审核状态 -- 审核中
     */
    CONST ISAUTH_ING = 1;

    /**
     * 审核状态 -- 审核通过
     */
    CONST ISAUTH_PASS = 2;

    /**
     * 审核状态 -- 审核不通过
     */
    CONST ISAUTH_NOPASS = -1;

    public static function getTableName() {
        return 'company';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取企业状态数组
     */
    public static function getStateAll($state = "") {
        $stateArr = array(
            self::STATE_ON => "正常",
            self::STATE_CLOSE => "关闭",
        );
        return parent::getState($stateArr, $state);
    }

    /**
     * 获取审核状态数组
     */
    public static function getIsAuthAll($isAuth = "") {
        $stateArr = array(
            self::ISAUTH_NOT => "未提交审核",
            self::ISAUTH_ING => "审核中",
            self::ISAUTH_PASS => "审核通过",
            self::ISAUTH_NOPASS => "审核不通过",
        );
        return parent::getState($stateArr, $isAuth);
    }

    /**
     * 
     * @param type 
     * @return type
     */
    public function findAll() {
        $criteria = new CDbCriteria();
        return self::model()->query($criteria, 'queryAll');
    }

    /**
     * 根据用户ID查询
     * @time 2017年11月16日11:30:01
     * @author zhangy
     * @param $userId
     * @return mixed
     */
    public function findByUserId($userId) {
        $crtiteria = new CDbCriteria();
        $crtiteria->compare('userId', $userId);
        return SELF::model()->query($crtiteria, 'queryRow');
    }

    /**
     * 根据多个用户ID查询
     * @time 2017年11月16日11:30:01
     * @author zhangy
     * @param $userIds
     * @return mixed
     */
    public function findByUserIds($userIds) {
        $crtiteria = new CDbCriteria();
        $crtiteria->compare('userId', $userIds);
        return SELF::model()->query($crtiteria, 'queryAll');
    }

    /**
     * 根据用户名查询
     * @param type $name
     * @return type
     */
    public function findByName($name) {
        $crtiteria = new CDbCriteria();
        $crtiteria->compare('companyName', $name, true);
        return SELF::model()->query($crtiteria, 'queryAll');
    }
}
