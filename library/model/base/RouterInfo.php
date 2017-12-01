<?php
class RouterInfo extends BaseModel {

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 线路类型-起点
     */
    CONST ROUTER_BEGIN = 1;
    /**
     * 线路类型-途径点
     */
    CONST ROUTER_MIDDLE = 2;
    /**
     * 线路类型-终点
     */
    CONST ROUTER_FINISH = 3;



	public static function getTableName() {
		return 'RouterInfo';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

    /**
     * 删除原有的路线途径点
     * @author zhangye
     * @time 2017年11月2日13:48:01
     * @param $routerId int  router表主线id
     * @return array
     */
	public function deleteOldRouter($routerId){
        if(empty($routerId)){
            return true;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('routerId',$routerId);
        $result =  SELF::model()->query($criteria,'queryAll');
        if(!empty($result)){
            foreach ($result as $key => $value){
                RouterInfo::model()->deleteByPk($value['id']);
            }
        }
        return true;
    }

    /**
     * 获取路线名
     * @author zhangye
     * @time 2017年11月2日15:29:50
     * @param $routerId int router表主键
     * @return string
     */
    public  static function getRouterName($routerId){
        $area = '';
        $criteria = new CDbCriteria();
        $criteria->compare('routerId',$routerId);
        $criteria->compare('type',SELF::ROUTER_BEGIN);
        $begin = SELF::model()->query($criteria,'queryRow');
        $area = $begin['tag'];
        $criteria2 = new CDbCriteria();
        $criteria2->compare('routerId',$routerId);
        $criteria2->compare('type',SELF::ROUTER_FINISH);
        $finish = SELF::model()->query($criteria2,'queryRow');
        $area .= '>>'.$finish['tag'];
        return $area;
    }

    /**
     * 获取起始点名
     * @author zhangye
     * @time 2017年11月3日11:05:33
     * @param $routerId
     * @param int $type
     * @return mixed
     */
    public static function getRouterPoint($routerId,$type = SELF::ROUTER_BEGIN){
        switch($type){
            case SELF::ROUTER_BEGIN:
                $criteria = new CDbCriteria();
                $criteria->compare('routerId',$routerId);
                $criteria->compare('type',SELF::ROUTER_BEGIN);
                $begin = SELF::model()->query($criteria,'queryRow');
                $addressInfo = Address::model()->findByPk($begin['addressId']);
                if(empty($addressInfo)){
                    return "";
                }

                return $addressInfo['detail'];
            case SELF::ROUTER_FINISH;
                $criteria = new CDbCriteria();
                $criteria->compare('routerId',$routerId);
                $criteria->compare('type',SELF::ROUTER_FINISH);
                $begin = SELF::model()->query($criteria,'queryRow');
                $addressInfo = Address::model()->findByPk($begin['addressId']);
                if(empty($addressInfo)){
                    return "";
                }
                return $addressInfo['detail'];
        }
        
        
    }

    /**
     * 根据routerId获取
     * @param $routerId
     * @return mixed
     */
    public function getInfoByRouterId($routerId){
        $criteria = new CDbCriteria();
        $criteria->compare('routerId',$routerId);
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->order = 'sort asc';
        return SELF::model()->query($criteria,'queryAll');
    }
    /**
     * 根据routerId获取途径点
     * @param $routerId
     * @return mixed
     */
    public function getRouterInfoByRouterId($routerId){
        $criteria = new CDbCriteria();
        $criteria->compare('routerId',$routerId);
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->compare('type',SELF::ROUTER_MIDDLE);
        $criteria->order = 'sort asc';
        return SELF::model()->query($criteria,'queryAll');
    }

    /**
     * 根据routerId获取该地点装货信息
     * @param $routerId int 线路id
     */
    public function getRouterDetail($routerId,$orderId,$type = SELF::ROUTER_BEGIN){
        $criteria = new CDbCriteria();
        $criteria->select = 'SQL_CALC_FOUND_ROWS *';
        $criteria->compare('routerId',$routerId);
        $criteria->join = "LEFT JOIN `Receiver` AS `r` ON(`r`.addressId = `t`.addressId)   
                           LEFT JOIN `OrderReceiver` AS `ore` ON(`ore`.receiverId = `r`.id)";////收货人表左联 订单收货人左联
        $criteria->compare('orderId',$orderId);
        $criteria->compare('type',$type);//路线类型
        if($type == SELF::ROUTER_MIDDLE){
            return SELF::model()->query($criteria,'queryAll');
        }
        return SELF::model()->query($criteria,'queryRow');
    }
}