<?php

class AjaxController extends CController {


    /**
     * 获取城市
     * @author chenbt
     */
    public function actionGetCity() {
        $pId = request('pId');
        if (!is_numeric($pId)) {
            app()->end();
        }
        $data = Areas::model()->findAllByParentId($pId);
        if(!$data){
            app()->end();
        }
        $json = UtilsHelper::packKeyAndValueFromArray($data, 'aId', 'areaName');
        echo CJSON::encode($json);
        app()->end();
    }

    /**
     * 获取用户名
     */
    public function actionGetUserId(){
        $userName = request('userName');
        if($userName){
            $userInfo = User::model()->findInfoByUserName($userName);
            if($userInfo){
                $userId = $userInfo['id'];
                echo json_encode(array('state' => 1, 'userId' => $userId));
            }else{
                echo json_encode(array('state' => 0));
            }
        }else{
            echo json_encode(array('state' => 0));
        }
        exit;
    }

    
     /**
     * 获取验证码图片
     * @param string moduleName 模块名称
     *
     * @reutrn 直接输出图片
     * @author shezz
     * @date 2015-1-23
     */
    public function actionGetVerifyCode() {
        $moduleName = request('moduleName');
        $service = new VerifyCodeService();
        $service->outputImageVerifyCode($moduleName);
    }
}
