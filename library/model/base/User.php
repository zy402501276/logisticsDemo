<?php
class User extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;
    /**
     * 是否第一次进入该系统--是
     */
    CONST FIRST_YES = 1;
    /**
     * 是否第一次进入该系统--否
     */
    CONST FIRSY_NO = 0;



	public static function getTableName() {
		return 'User';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 根据用户utoken查找用户
     * @param $utoken string 用户令牌
     * @return array|mixed|null
     */
	public function findByUtoken($utoken){
        $criteria = new CDbCriteria();
        $criteria->compare('utoken',$utoken);
        $criteria->compare('state',SELF::STATE_ON);
        return SELF::model()->query($criteria,'queryRow');
    }
    /**
     * 根据用户passportId查找用户
     * @param $utoken string 用户令牌
     * @return array|mixed|null
     */
//    public function findByPId($passportId){
//        $criteria = new CDbCriteria();
//        $criteria->compare('userId',$passportId);
//        return SELF::model()->query($criteria,'queryRow');
//    }

    /**
     * 确认用户是否第一次进入系统
     * @author zhangy
     * @time 2017年11月20日09:37:55
     */
    public static function checkFirst(){
        $criteria = new CDbCriteria();
        $criteria->compare('id',user()->getId());
        $result = SELF::model()->query($criteria,'queryRow');
        return $result['isFirst'];
    }
}