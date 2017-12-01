<?php

/**
 * 公司信息模块控制器
 * @time 2017年11月16日10:49:24
 * @author zhangye
 */
class CompanyController extends Controller {

    public function init() {
        parent::init();
        if (!user()->getId()) {
            $this->redirect("/index/index");
        }
        if (!User::checkFirst()) {
            $this->redirect("/manage/declare");
        }
    }

    /**
     * 认证信息
     * @time 2017年11月16日10:50:04
     */
    public function actionAuth() {
        $companyMsg = Company::model()->findByUserId(user()->getId());
        if (!empty($companyMsg)) {
            $auth = $companyMsg['isAuth'];
        } else {
            $auth = '';
        }
        $obj = CompanyInfo::model()->findCId($companyMsg['cId']);
        $model = new CompanyInfoForm();
        $model->attributes = $obj;
        $log = AdminLog::model()->findLogAll($companyMsg['cId'], AdminLog::COMPANY_ISAUTH);
        $log = end($log);
        if (Yii::app()->request->isPostRequest) {
            if (!empty($_FILES["CompanyInfoForm"]["tmp_name"]["busLiceUrl"])) {
                $imgUrl = UtilsHelper::uploadFile($model, "busLiceUrl", param("goodsPath"));
                $model->busLiceUrl = $imgUrl;
            }
            $service = CompanyService::getInstance();
            $result = $service->editAuth($model, $_POST);
            user()->setFlash('message', $result['message']);
            if ($result['state']) {
                $this->redirect("/company/auth");
            }
        }
        $this->render('companyAuth', compact('model', 'auth', 'log'));
    }

    /**
     * 公司基本信息
     * @time 2017年11月16日11:09:08
     */
    public function actionCompanyInfo() {
        $obj = Company::model()->findByUserId(user()->getId());
        $type = request('type', 0); //1 修改页面，0展示页面
        $detail = '';
        $model = new CompanyForm();
        $model->attributes = $obj;
        if ($_POST) {
            $type = 1;
            $service = CompanyService::getInstance();
            $result = $service->editCompany($model, $_POST);
            if ($result['state'] == 1) {
                user()->setFlash('message', '修改成功');
                $this->redirect("/company/companyInfo");
            }
        }
        if (!empty($obj)) {
            $detail .= Areas::model()->getAreaName($model->provinceId, $model->cityId, $model->areaId);
        }
        if (empty($obj) || $type == 1) {
            $this->render('editCompany', compact(array('model', 'detail')));
        } else {
            $data = $model->attributes;
            $this->render('company', compact(array('data')));
        }
    }

}
