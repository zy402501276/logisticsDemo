<?php
class Address extends BaseModel {

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

	public static function getTableName() {
		return 'Address';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 获取收货人完整地址
     * @author zhangye
     * @time 2017年11月3日13:31:34
     * @param $addressId\
     * @return string
     */
	public function getDetailAddress($addressId){
        $addressInfo = Address::model()->findByPk($addressId);
        $region = Areas::model()->getAreaName($addressInfo['procvinceId'],$addressInfo['cityId'],$addressInfo['areaId']);
        return $region.' '.$addressInfo['address'];
    }

    /**
     * 模糊搜索地址
     * @time 2017年11月8日16:48:12
     * @author zhangye
     * @param $detail
     */
    public function getAddress($detail){
        $criteria = new CDbCriteria();
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->compare('userId',user()->getId());
        $criteria->compare('detail',$detail,true);
        return self::model()->query($criteria, 'queryAll');
    }
	
}