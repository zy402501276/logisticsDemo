<?php

class Menu extends BaseModel {

    /**
     * 导航类型-父级标题
     */
    CONST TITLE_MAIN = 0;

    /**
     * 类型--路线
     */
    CONST STATE_ROUTER = 1;

    /**
     * 类型--用户
     */
    CONST STATE_USER = 2;

    /**
     * 类型--订单
     */
    CONST STATE_ORDER = 3;

    /**
     * 类型--反馈
     */
    CONST STATE_FEEDBACK = 4;
    
    /**
     * 导航栏类型-主标题
     */
    CONST TYPE_MAIN = 1;

    /**
     * 导航栏类型-副标题
     */
    CONST TYPE_VICE = 2;

    /**
     * 控制器名-manageMent
     */
    CONST CNAME_MANAGE = 'manage';

    public static function getTableName() {
        return 'Menu';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 输出导航栏
     * @time 2017年11月6日15:57:32
     * @author zhangye
     */
    public static function printMenu($pId = 0, $type = SELF::STATE_ROUTER) {

        $criteria = new CDbCriteria();
        $criteria->compare('state', $type);
        $criteria->compare('pId', $pId);
        $criteria->order = 'sort asc';
        return SELF::model()->query($criteria, 'queryAll');
    }

    /**
     * 根据控制器寻找主标题
     * @time 2017年11月6日16:58:51
     */
    public static function getMainTitle($cName) {
        $criteria = new CDbCriteria();
        $criteria->compare('controller', $cName);
        $criteria->compare('pId', 0);
        $res = SELF::model()->query($criteria, 'queryRow');
        return $res['title'];
    }

    /**
     * 根据控制器方法寻找主标题
     * @time 2017年11月6日16:58:51
     */
    public static function getViceTitle($cName, $aName) {
        $criteria = new CDbCriteria();
        $criteria->compare('controller', $cName);
        $criteria->compare('action', $aName);
        $res = SELF::model()->query($criteria, 'queryRow');
        return $res['title'];
    }

}
