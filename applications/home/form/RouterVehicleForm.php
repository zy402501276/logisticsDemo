<?php
class RouterVehicleForm extends RouterVehicleBaseForm{

    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('state','default','value' => RouterVehicle::STATE_ON),
            array('costState','default','value' => RouterVehicle::COST_UNCHECK),
            array('createTime,updateTime','default','value' => date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($rules, $childRules);
    }



}