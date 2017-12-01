<?php
class RouterForm extends RouterBaseForm{


    public function search() {
        $model = new Router();

        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
            if(!empty($this->name)){
                $this->criteria->compare('name',$this->name,true);
            }
            $this->criteria->compare('userId',user()->getId());
            $this->criteria->compare('state',Router::STATE_ON);
            $this->criteria->limit = $this->size;
            $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
        }

        $datas = $model->query(array(
            'list' => $this->criteria,
            'count' => 'SELECT FOUND_ROWS()'
        ), array(
            'list' => 'queryAll',
            'count' => 'queryScalar'
        ));
        $pager = new CPagination($datas['count']);
        $pager->setPageSize($this->size);

        return array('datas' => $datas['list'], 'pager' => $pager);
    }


    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('name,type', 'required', "message" => "{attribute}不能为空", 'on' => 'add'),
            array('state','default','value'=>RouterInfo::STATE_ON),
            array('name', 'checkRouterName',  'on' => 'add'),

        );
        return CMap::mergeArray($childRules,$rules);
    }

    /**
     * 验证路线名称
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function checkRouterName($attribute,$params){
        if (!$this->$attribute) {
            return true;
        }
        if (preg_match('/[^0-9a-zA-Z一-龥]/u', $this->$attribute)) {
            $this->addError($attribute, '线路名称不能有特殊符号');
        }
        return true;
    }
}