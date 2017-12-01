<?php
class PalletNum extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

	public static function getTableName() {
		return 'palletNum';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
    /**
     * 获取托盘数量数组
     * @time 2017年11月6日13:24:51
     * @author zhangye
     */
    public static function getPalletNumArr($num = '', $echoString = false){
        $criteria = new CDbCriteria();
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->select = 'id,num';
        $array = self::model()->query($criteria, 'queryAll');
        foreach ($array as $key => $value){
            $itemArr[$value['id']] = $value['num'];
        }
        return parent::getState($itemArr, $num, $echoString);
    }
}