<?php

class CountService {
    /**
     * 统计车辆信息数量
     * @param type $deliveryStatus 配送状态
     * @return type
     */
    public function countCars($deliveryStatus = '') {
        $model = new VehicleInfo();
        $criteria = new CDbCriteria();
        $criteria->select = 'count(*) as num';
        $criteria->compare("deliveryStatus", $deliveryStatus);
        $datas = $model->query(array(
                'count' => $criteria
        ), array(
                'count' => 'queryScalar'
        ));
        return $datas;
    }
    
    /**
     * 统计司机信息数量
     * @param type $dState 配送状态
     * @return type
     */
    public function countDrives($dState = '') {
        $model = new Drives();
        $criteria = new CDbCriteria();
        $criteria->select = 'count(*) as num';
        $criteria->compare("dState", $dState);
        $datas = $model->query(array(
                'count' => $criteria
        ), array(
                'count' => 'queryScalar'
        ));
        return $datas;
    }
    
    /**
     * 统计企业信息数量
     * @param type $isAuth 审核状态
     * @return type
     */
    public function countCompany($isAuth = '') {
        $model = new Company();
        $criteria = new CDbCriteria();
        $criteria->select = 'count(*) as num';
        $criteria->compare("isAuth", $isAuth);
        $datas = $model->query(array(
                'count' => $criteria
        ), array(
                'count' => 'queryScalar'
        ));
        return $datas;
    }
}
