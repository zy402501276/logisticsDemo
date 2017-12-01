<?php
class RouterInfoForm extends RouterInfoBaseForm{

    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('state','default','value' => RouterInfo::STATE_ON),
            array('createTime,updateTime','default','value' => date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($rules, $childRules);
    }


}