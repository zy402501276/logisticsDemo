<?php

class IndexController extends Controller {

    public function actionIndex() {
        $vehicleInfo = VehicleInfo::model()->findAll();
        $vehicleNum = count($vehicleInfo);
        $countService = new CountService();
        $idleItem = $countService->countCars(VehicleInfo::DELIVERYSTATUS_IDLE); //待接单  
        $ingNum = $countService->countCars(VehicleInfo::DELIVERYSTATUS_ING); //运输中
        $errorNum = $countService->countCars(VehicleInfo::DELIVERYSTATUS_ERROR); //异常
        $drivesInfo = Drives::model()->findAll();
        $drivesNum = count($drivesInfo);
        $validNum = $countService->countDrives(Drives::DSTATE_VALID); //启用 
        $invalidNum = $countService->countDrives(Drives::DSTATE_INVALID); //停用 
        $companyInfo = Company::model()->findAll();
        $companyNum = count($companyInfo);
        $passNum = $countService->countCompany(Company::ISAUTH_PASS); //通过 
        $noPassNum = $countService->countCompany(Company::ISAUTH_NOPASS); //不通过 
        $ingNum = $countService->countCompany(Company::ISAUTH_ING); //审核中
        $this->render('index', compact("vehicleNum", "idleItem", "ingNum", "errorNum", "drivesNum", "validNum", "invalidNum", "companyNum", "passNum", "noPassNum", "ingNum"));
    }

}
