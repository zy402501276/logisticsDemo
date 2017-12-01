<?php
class ApiOrdersForm extends OrdersBaseForm{
    public $dId;
    /**
     * API列表页
     * @time 2017年11月29日16:34:51
     */
    public function search() {
        $model = new Orders();

        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
    //            $this->criteria->join = "LEFT JOIN `OrderVehicle` AS `OV` ON(`OV`.orderId = t.id)
    //                                     LEFT JOIN `VehicleInfo` AS `VI` ON(`OV`.vehicleInfoId = `VI`.id)
    //                                     LEFT JOIN `Drives` AS `D` ON (`D`.dId = `VI`.dId)";
    //            $this->criteria->compare('`D`.dId',$this->dId);
            $this->criteria->compare('orderState',$this->orderState);
            $this->criteria->compare('state',Orders::STATE_ON);
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
}