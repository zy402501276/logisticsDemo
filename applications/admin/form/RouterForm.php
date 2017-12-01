<?php

class RouterForm extends RouterBaseForm {

    public $companyName;
    public $vehicleState;
    
    public function search() {
        $model = new Router();

        $this->criteria = new CDbCriteria();
        $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
        $this->criteria->limit = $this->size;
        $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
        $this->criteria->compare('id', $this->id);
        $this->criteria->compare('userId', $this->userId);
        $this->criteria->compare('type', $this->type);

        return parent::search();
    }

    
}
