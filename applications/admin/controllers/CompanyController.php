<?php
class CompanyController extends Controller{
    public function actionIndex(){
        $model = new AdminCompanyForm();
        if(isset($_GET["AdminCompanyForm"])) {
            $model->attributes = $_GET["AdminCompanyForm"];
        }
        if (isset($_GET['page'])) {
            $model->page = $_GET['page'];
        }
        $dataProvider = $model->search();
        $datas = $dataProvider["datas"];
        $pager = $dataProvider["pager"];
        $this->render('index',compact("model","datas","pager"));
    }
    
    /**
     * 企业新增OR修改
     */
    public function actionEdit(){
        $cId = request("cId");
        $reUrl = user()->getFlash('reUrl');
        if(!$reUrl) {
            $reUrl = "/compant/index";
        }
        if(isset($_SERVER["HTTP_REFERER"])) {
            if(!strpos($_SERVER["HTTP_REFERER"], 'compant/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        $model = new AdminCompanyForm;
        if($cId){
            $item = Company::model()->findByPk($cId);
            $model->attributes = $item;
        }
        if(isset($_POST["AdminCompanyForm"])){
            $model->attributes = $_POST["AdminCompanyForm"];
            if(!$cId){
               $model->isAuth = Company::ISAUTH_NOT; 
            }
            $model->state = Company::STATE_ON;
            $model->creatTime = date("Y-m-d H:i:s");
            if($model->validate()){
                $model->save();  
                user()->setFlash('message',$cId ? "修改企业信息成功":"新增企业信息成功");
                $this->redirect("/company/index");
            }
        }
        $this->render('edit',compact("model","cId"));
    }
    
    /**
     * 修改企业状态
     */
    public function actionUpdateState(){
        $cId = request("cId");
        $state = request("state");
        Company::model()->updateByPk($cId, array("state" => $state));
        echo jsonEncode(array("state" => 1, "message" => "修改企业状态成功"));
        app()->end();
    }
    
    /**
     * 企业认证信息
     */
    public function actionCompanyInfo(){
        $cId = request("cId");
        $reUrl = user()->getFlash('reUrl');
        if(!$reUrl) {
            $reUrl = "/compant/index";
        }
        if(isset($_SERVER["HTTP_REFERER"])) {
            if(!strpos($_SERVER["HTTP_REFERER"], 'compant/index')) {
                $reUrl = $_SERVER["HTTP_REFERER"];
            }
        }
        user()->setFlash('reUrl', $reUrl);
        $model = new AdminCompanyInfoForm;
        if($cId){
            $item = CompanyInfo::model()->findCId($cId);
            $companyItem = Company::model()->findByPk($cId);
            $model->attributes = $item;
            $logItem = AdminLog::model()->findLogAll($cId,AdminLog::COMPANY_ISAUTH);
        }
        if(isset($_POST["AdminCompanyInfoForm"])){
            $model->attributes = $_POST["AdminCompanyInfoForm"];
            if(isset($_FILES["AdminCompanyInfoForm"]["tmp_name"]["busLiceUrl"]) && $_FILES["AdminCompanyInfoForm"]["tmp_name"]["busLiceUrl"] != "") {
                $model->busLiceUrl = UtilsHelper::uploadFile($model, "busLiceUrl", param("drivesPath"));
            }
            $model->cId = $cId;
            $model->creatTime = date("Y-m-d H:i:s");
            if($model->validate()){
                $model->save();
                if($companyItem["isAuth"] != Company::ISAUTH_ING && $companyItem["isAuth"] != Company::ISAUTH_PASS && $companyItem["isAuth"] == Company::ISAUTH_NOT){
                    Company::model()->updateByPk($cId,array('isAuth'=>Company::ISAUTH_ING));
                    AdminLogService::addOperateLog($cId, AdminLog::COMPANY_ISAUTH,"待审核");
                }
               
                user()->setFlash('message',$item ? "修改企业认证信息成功":"新增企业认证信息成功");
                $this->redirect("/company/index");
            }
        }
        $this->render("companyInfo",compact("model","cId","item","logItem","companyItem"));
    }
    
    /**
     * 企业审核通过
     */
    public function actionPass(){
        $cId = request("cId");
        Company::model()->updateByPk($cId, array("isAuth" => Company::ISAUTH_PASS));
        AdminLogService::addOperateLog($cId, AdminLog::COMPANY_ISAUTH,"企业审核通过");
        echo jsonEncode(array("state" => 1, "message" => "企业审核通过"));
        app()->end();
    }
    
    /**
     * 企业审核不通过
     */
    public function actionNoPass(){
        $cId = request("cId");
        $remark = request("remark");
        Company::model()->updateByPk($cId, array("isAuth" => Company::ISAUTH_NOPASS));
        AdminLogService::addOperateLog($cId, AdminLog::COMPANY_ISAUTH,"企业审核不通过",$remark);
        echo jsonEncode(array("state" => 1, "message" => "企业审核不通过"));
        app()->end();
    }
    
}
