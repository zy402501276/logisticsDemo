<?php

class CompanyInfoForm extends CompanyInfoBaseForm{
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('orgNum,companyUsername,companyIdCard','required','message' => '{attribute}不能为空'),
            array('creatTime', 'default','value'=> date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($childRules,$rules);
    }

}