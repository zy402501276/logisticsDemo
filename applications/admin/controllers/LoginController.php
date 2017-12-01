<?php

class LoginController extends CController {
    /**
     * 登录
     */
    public function actionLogin() {
        if (Yii::app()->user->getId()) {
            $this->redirect("/index/index");
        }
        $model = new AdminForm();
        if(isset($_POST["AdminForm"])){
            $model->attributes = $_POST['AdminForm'];
            $userInfo = $model->checkUserLogin();
            if ($userInfo) {
                user()->setId($userInfo["adminId"]);
                user()->setName($userInfo["username"]);
                $this->redirect("/index/index");
            }
            $model->addError("username", "账户名或密码错误");
        }
        $this->layout = '//layouts/empty';
        $this->render('login',compact(array("model")));
    }

    /**
     * 退出
     */
    public function actionLogout() {
        user()->clearStates();
        user()->logout(true);
        app()->request->cookies->clear();
        $this->redirect('/login/login');
    }
}

