<?php

class FeedbackForm extends FeedbackBaseForm {

    public function search() {
        $model = new Feedback();

        $this->criteria = new CDbCriteria();
        $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
        $this->criteria->limit = $this->size;
        $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);

        return parent::search();
    }

}
