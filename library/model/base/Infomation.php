<?php

class Infomation extends BaseModel {

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;

    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 是否查看 -未查看
     */
    CONST ISREAD_NO = 0;

    /**
     * 是否查看 -已查看
     */
    CONST ISREAD_YES = 1;

    /**
     * 类型 - 系统消息
     */
    CONST TYPE_SYSTEM = 1;

    public static function getTableName() {
        return 'Infomation';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 根据用户id查找用户
     * @param $utoken string 用户令牌
     * @return array|mixed|null
     */
    public function findByUserId($userId, $isRead = '') {
        $criteria = new CDbCriteria();
        $criteria->compare('userId', $userId);
        $criteria->compare('state', SELF::STATE_ON);
        $criteria->compare('isRead', $isRead);
        return SELF::model()->query($criteria, 'queryAll');
    }

    /**
     * 获取货物数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getNewsArr($state = '', $echoString = false) {
        $array = array(
            SELF::ISREAD_NO => '未读',
            SELF::ISREAD_YES => '已读',
        );
        return parent::getState($array, $state, $echoString);
    }

}
