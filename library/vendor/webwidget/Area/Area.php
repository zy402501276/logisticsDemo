<?php
/**
 * demo
$this->widget('ext.webwidget.Area.Area', array(
 * 'provinceName' => CHtml::activeName($model, 'provinceId'),  //记录省id的隐藏域名称
    'cityName' => CHtml::activeName($model, 'cityId'),  //记录市id的隐藏域名称
    'areaName' => CHtml::activeName($model, 'areaId'),  //记录区id的隐藏域名称
 *  'provinceValue' => $model['provinceId'],  //省id的值
    'cityValue' => $model['cityId'], //市id的值
    'areaValue' => $model['areaId'], //区id的值
    'deep' => 2,    //需要查询几级 默认3
    'textName' => 'pppppp'  //显示名称的text名称
));
 */
class Area extends CInputWidget {

    public $provinceName;
    public $cityName;
    public $areaName = '';
    public $deep = 3;
    public $textName;
    public $divStyle = '';
    public $provinceValue;
    public $cityValue;
    public $areaValue;
    public function run() {
        $provinceList = MemcacheHelper::get("provinceList");
        if(!$provinceList){
            $data = Areas::model()->findProvince();
            $provinceList = array();
            if ($data) {
                foreach ($data as $val) {
                    switch (true) {
                        case $val['areaInitial'] >= 'A' && $val['areaInitial'] <= 'G':
                            $provinceList['A-G'][] = $val;
                            break;
                        case $val['areaInitial'] >= 'H' && $val['areaInitial'] <= 'K':
                            $provinceList['H-K'][] = $val;
                            break;
                        case $val['areaInitial'] >= 'L' && $val['areaInitial'] <= 'S':
                            $provinceList['L-S'][] = $val;
                            break;
                        default:
                            $provinceList['T-Z'][] = $val;
                            break;
                    }
                }
            }
            MemcacheHelper::set("provinceList", $provinceList, 3600);
        }
        $this->render('area', array(
            "provinceName" => $this->provinceName,
            "cityName" => $this->cityName,
            "areaName" => $this->areaName,
            "data" => $provinceList,
            "deep" => $this->deep,
            "textName" => $this->textName,
            "divStyle" => $this->divStyle,
            "provinceValue" => $this->provinceValue,
            "cityValue" => $this->cityValue,
            "areaValue" => $this->areaValue,
        ));
    }
}
