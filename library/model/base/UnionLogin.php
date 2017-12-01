<?php
class UnionLogin extends BaseModel {
    /**
     * 联合类型 -- 开门通行证
     */
    const TYPE_PCB_PASSPORT = 1;

    public static function getTypeSelectData($type = "", $echoString = false) {
        $typeAll = array(
            self::TYPE_PCB_PASSPORT => "开门通行证",
        );
        return parent::getState($typeAll, $type, $echoString);
    }

    public static function getTableName() {
        return 'UnionLogin';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 根据唯一标识获取联合登录详情
     * @param type $onlyCode 唯一标识
     * @return type
     * @author dean
     */
    public function findInfoByOnlyCode($onlyCode, $type = self::TYPE_PCB_PASSPORT) {
        $criteria = new CDbCriteria();
        $criteria->compare('onlyCode', $onlyCode);
        $criteria->compare('type', $type);
        return self::model()->query($criteria, 'queryRow');
    }

}