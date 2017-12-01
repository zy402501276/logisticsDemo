<?php
class AdminVehicleInfoForm extends VehicleInfoBaseForm {
    public $drivesName;
    public function search() {
		$model = new VehicleInfo();
		
		if (!$this->criteria) {
			$this->criteria = new CDbCriteria();
			$this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
			$this->criteria->limit = $this->size;
			$this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
                        $this->criteria->compare('licenseNumber',$this->licenseNumber);
                        $this->criteria->compare('vehicleType',$this->vehicleType);
                        $this->criteria->compare('deliveryStatus',$this->deliveryStatus);
                        if ($this->drivesName) {
                            $item = Drives::model()->findDrivesNameRow($this->drivesName);
                            if ($item) {
//                                $dId = UtilsHelper::extractColumnFromArray($item, "dId");
                                $this->criteria->compare("dId", $item["dId"]);
                            } else {
                                $this->criteria->compare("dId", "-1");
                            }
                        }
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
