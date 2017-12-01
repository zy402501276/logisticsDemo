<?php
/**
 * 商城联合登录逻辑层
 * @aurhor dean
 * @date 2017-06-21
 */
class UnionLoginService {
    /**
     * 联合登录入口方法
     * @param type $type 联合登录类型
     * @param type $returnData 返回数据
     * @param type $reType 返回跳转类型 
     * @param type $reUrl 返回跳转连接
     * @return type
     */
    public function index($type, $returnData, $reType, $reUrl) {
        if($type == UnionLogin::TYPE_PCB_PASSPORT) {
            return $this->checkIsBind($returnData, $reType, $reUrl);
        }
    }
    /**
     * 验证是否绑定帐号
     */
    public function checkIsBind($returnData, $reType, $reUrl) {
        $authTime = $returnData["authTime"];
        $authCode = $returnData["authCode"];
        $userName = McryptHelper::mcryptDencrypt($returnData["userName"]);
//        if(time() - $authTime > 300) {
//            user()->setFlash('message', "对不起，授权已过期，请重新授权登录。");
//            user()->setFlash('reUrl', urldecode("/index/login?type={$reType}&reUrl=".$reUrl));
//            return array("state" => 0, "reUrl" => 'index/success');
//        }
        $onlyItem = UnionLogin::model()->findInfoByOnlyCode($authCode, UnionLogin::TYPE_PCB_PASSPORT);
        //todo保存头像
        user()->setState("avatar", $returnData['avatar']);
        if(!$onlyItem) {
            $addUnionLoginResult = $this->addUnionLogin(UnionLogin::TYPE_PCB_PASSPORT, $userName, $authCode);
            if(!$addUnionLoginResult["state"]) {
                user()->setFlash('message', $addUnionLoginResult["message"]);
                return array("state" => 0);
            }
            $addUser = $this->addUser($addUnionLoginResult["unionId"],$returnData);
            if(!$addUser['state']){
                return array("state" => 0);
            }
            $userInfo = User::model()->findByPk($addUser['id']);
            return array("state" => 1, "userInfo" => $userInfo);

        }
        if($onlyItem["userId"]) {
            $userInfo = User::model()->findByPk($onlyItem["userId"]);
            return array("state" => 1, "userInfo" => $userInfo);
        }
    }
    
    /**
     * 添加新的联合登录记录
     * @param type $type 联合登录类型
     * @param type $userName 登录名
     * @param type $onlyCode 唯一标识
     * @return type
     */
    private function addUnionLogin($type, $userName, $onlyCode) {
        $model = new UnionLoginForm();
        $model->name = $userName;
        $model->type = $type;
        $model->onlyCode = $onlyCode;
        if($unionId = $model->save()) {
            return array("state" => 1, "unionId" => $unionId);
        }
        return array("state" => 0, "message" => $model->getFirstError() );
    }

    /**
     *  创建用户
     * @param $unionId
     * @param $returnData
     * @return array
     */
    public function addUser($unionId,$returnData){
        $model = new UserForm();
        $model->name =  McryptHelper::mcryptDencrypt($returnData["userName"]);
//        $model->mobile = base64_decode($returnData["mobile"]);
//        $model->email = McryptHelper::mcryptDencrypt($returnData["email"]);
        $model->pId = McryptHelper::mcryptDencrypt($returnData["userId"]);
        $model->scenario = 'register';
        if($model->validate()){
            $id = $model->save();
            UnionLogin::model()->updateByPk($unionId,array('userId'=>$id));
            return array("state" => 1, "id" => $id);
        }
        return array("state" => 0, "message" => $model->getFirstError() );
    }
}
