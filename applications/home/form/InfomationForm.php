<?php
class InfomationForm extends InfomationBaseForm{
    public function search() {
        $model = new Infomation();

        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
            $this->criteria->compare('userId',user()->getId());
            $this->criteria->compare('state',Infomation::STATE_ON);
            $this->criteria->limit = $this->size;
            $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
            $this->criteria->order = '`id` desc';
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
}