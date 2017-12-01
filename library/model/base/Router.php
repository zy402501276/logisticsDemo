<?php
class Router extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 路况类型-高速
     */
    CONST TPYE_HIGHWAY = 1;
    /**
     * 路况类型-普通
     */
    CONST TPYE_NOMAL = 2;
    /**
     * 路况类型-不限制
     */
    CONST TPYE_ALL = 3;


	public static function getTableName() {
		return 'Router';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 获取路况类型
     */
    public static function getRouterType($type = '', $echoString = false) {
        $data = array(
            self::TPYE_HIGHWAY => '高速',
            self::TPYE_NOMAL => '普通',
            self::TPYE_ALL => '不限制',
        );
        return parent::getState($data, $type, $echoString);
    }
    /**
     * 获取路线类型数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getRouterArr($router = '', $echoString = false){
        $criteria = new CDbCriteria();
        $criteria->compare('t.state',SELF::STATE_ON);
        $criteria->compare('userId',user()->getId());
        $criteria->select = 't.id,name';
        $criteria->join = "LEFT JOIN `RouterVehicle`AS RV ON (`t`.id=`RV`.routerId)";
        $criteria->compare('RV.costState',RouterVehicle::COST_CHECKED);
        $array = self::model()->query($criteria, 'queryAll');
        if(!empty($array)){
            foreach ($array as $key => $value){
                $itemArr[$value['id']] = $value['name'];
            }
            return parent::getState($itemArr, $router, $echoString);
        }else{
            return array();
        }

    }

    /**
     * 获取用户一条路线类型数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getOneRouter(){
        $criteria = new CDbCriteria();
        $criteria->compare('t.state',SELF::STATE_ON);
        $criteria->compare('userId',user()->getId());
        $criteria->join = "LEFT JOIN `RouterVehicle`AS RV ON (`t`.id=`RV`.routerId)";
        $criteria->compare('RV.costState',RouterVehicle::COST_CHECKED);
        $array = self::model()->query($criteria, 'queryRow');
        return $array['id'];

    }

}