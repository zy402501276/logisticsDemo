<?php

class VehicleWeightForm extends VehicleWeightBaseForm {

    public function search() {
        $model = new VehicleWeight();

        $this->criteria = new CDbCriteria();
        $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
        $this->criteria->limit = $this->size;
        $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
        $this->criteria->order = '`id` desc';
        $this->criteria->compare('state', $this->state);

        return parent::search();
    }

}
