<?php

class VehicleLength extends BaseModel {

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;

    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    public static function getTableName() {
        return 'VehicleLength';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取配置项信息
     * @time 2017年11月6日18:38:15
     * @author zhangye
     */
    public static function getInfo($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $criteria->compare('state', SELF::STATE_ON);
        $res = SELF::model()->query($criteria, 'queryRow');
        return $res['name'];
    }

    /**
     * 获取车辆长度类型数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getTypeArr($type = '', $echoString = false) {
        $criteria = new CDbCriteria();
        $criteria->compare('state', SELF::STATE_ON);
        $criteria->select = 'id,name';
        $array = self::model()->query($criteria, 'queryAll');
        foreach ($array as $key => $value) {
            $itemArr[$value['id']] = $value['name'];
        }
        return parent::getState($itemArr, $type, $echoString);
    }

    /**
     * 根据名字查找
     * @param type $name
     */
    public function findByName($name, $state = self::STATE_ON) {
        $criteria = new CDbCriteria();
        $criteria->compare('name', $name);
        $criteria->compare('state', $state);
        return self::model()->query($criteria, 'queryRow');
    }

}
