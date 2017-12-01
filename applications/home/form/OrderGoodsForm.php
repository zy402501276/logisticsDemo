<?php

class OrderGoodsForm extends OrderGoodsBaseForm{
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('isFrequence','default','value' => Goods::ISFREQUENCE_NO),
            array('isModel','default','value' => Goods::ISMODEL_NO),
            array('isUsing','default','value' => Goods::ISUSING_NO),
            array('createTime,updateTime','default','value' => date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($childRules,$rules);
    }
}