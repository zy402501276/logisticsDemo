<?php
class Receiver extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;
    /**
     * 性别-未选择
     */
    CONST GENDER_UNKNOW = 0;
    /**
     * 性别-男
     */
    CONST GENDER_MALE = 1;
    /**
     * 性别-女
     */
    CONST GENDER_FEMALE = 2;

	public static function getTableName() {
		return 'Receiver';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 根据地址ID查找收货人
     * @param $addressId
     * @return mixed
     */
	public function findByAddressId($addressId){
	    if(empty($addressId)){
	        return array();
        }
	    $criteria = new CDbCriteria();
	    $criteria->compare('addressId',$addressId);
        $criteria->compare('state',SELF::STATE_ON);
	    return SELF::model()->query($criteria,'queryAll');
    }

    /**
     * 获取收货人id数组
     * @param $addressId
     * @return mixed
     */
    public function getIdByAddressId($addressId){
        $criteria = new CDbCriteria();
        $criteria->compare('addressId',$addressId);
        $criteria->compare('state',SELF::STATE_ON);
        $res = SELF::model()->query($criteria,'queryAll');
        $array = array();
        foreach ($res as $key => $value){
            $array[] = $value['id'];
        }
        return $array;
    }

    /**
     * 获取收货人下拉框
     * @time 2017年11月8日09:24:07
     * @author zhangye
     */
    public static function getReceiverArr($addressId, $receiver = '', $echoString = false){
        $criteria = new CDbCriteria();
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->compare('addressId',$addressId);
        $criteria->select = 'id,name';
        $array = self::model()->query($criteria, 'queryAll');
        $itemArr = array();
        foreach ($array as $key => $value){
            $itemArr[$value['id']] = $value['name'];
        }

        return parent::getState($itemArr, $receiver, $echoString);
    }

    /**
     * 根据receiverId查找地址信息
     * @author zhangye
     * @time 2017年11月14日14:24:17
     * @param $id
     * @return mixed
     */
    public function gerAddressInfo($id){
        $obj = SELF::model()->findByPk($id);
        return Address::model()->findByPk($obj['addressId']);
    }
    /**
     * 获取性别
     * @time 2017年11月8日09:24:07
     * @author zhangye
     */
    public static function getGender($receiver = '', $echoString = false){
        $itemArr = array(SELF::GENDER_UNKNOW => '未知',SELF::GENDER_MALE => '先生',SELF::GENDER_FEMALE=>'女士');
        return parent::getState($itemArr, $receiver, $echoString);
    }
}