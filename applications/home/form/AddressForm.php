<?php
class AddressForm extends AddressBaseForm{
    public function search() {
        $model = new Address();
        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
            if(!empty($this->detail)){
                $this->criteria->compare('detail',$this->detail,true);
            }
            $this->criteria->compare('state',Address::STATE_ON);
            $this->criteria->compare('userId',user()->getId());
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
            array('state','default','value'=>Address::STATE_ON),
            array('createTime,updateTime','default','value'=>date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($childRules,$rules);
    }
}