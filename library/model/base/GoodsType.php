<?php
class GoodsType extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

	public static function getTableName() {
		return 'GoodsType';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 获取货物类型数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getGoodsTypeArr($type= '', $echoString = false){
        $criteria = new CDbCriteria();
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->select = 'id,name';
        $array = self::model()->query($criteria, 'queryAll');
        foreach ($array as $key => $value){
            $itemArr[$value['id']] = $value['name'];
        }
        return parent::getState($itemArr, $type, $echoString);
    }
	
}