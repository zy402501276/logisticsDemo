<?php
class OrderReceiverForm extends OrderReceiverBaseForm{
    public function rules()
    {
        $rules = parent::rules();
        $childRules = array(

            array('state', 'default', 'value' => Goods::STATE_ON),
            array('getState', 'default', 'value' => OrderReceiver::LOGISTICS_WAIT),
            array('createTime,updateTime', 'default', 'value' => date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($childRules, $rules);
    }
}