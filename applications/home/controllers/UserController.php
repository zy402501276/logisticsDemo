<?php

/**
 * 用户模块控制器
 * @time 2017年11月16日16:57:07
 * @author zhangye
 */
class UserController extends Controller{
    public function init() {
        parent::init();
        if(!user()->getId()) {
            $this->redirect("/index/index");
        }
        if(!User::checkFirst()){
            $this->redirect("/manage/declare");
        }
    }

    /**
     * 修改邮箱和手机
     * @time 2017年11月16日16:57:28
     */
    public function actionEdit(){
        $info = User::model()->findByPk(user()->getId());
        $model = new UserForm();
        $model->attributes = $info;
        if($_POST){
            $service = UserService::getInstance();
            $result = $service->editUser($_REQUEST,$model);
            if($result['state']){
                //todo返回列表页
                user()->setFlash('message', '修改成功');
            }
        }
        $this->render('edit',compact(array('model')));
    }

}