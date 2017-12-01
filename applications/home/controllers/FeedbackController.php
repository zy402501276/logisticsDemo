<?php

class FeedbackController extends Controller {

    public function init() {
        parent::init();
        if (!user()->getId()) {
            $this->redirect("/index/index");
        }
    }

    public function actionIndex() {
        $key = 'feedback';
        $model = new FeedbackForm();
        if (isset($_POST['FeedbackForm'])) {
            $captcha = new Captcha($key);
            $code = $captcha->getVerifyCode();
            $model->attributes = $_POST['FeedbackForm'];
            if (!isset($_POST["code"]) || strtolower($_POST["code"]) != strtolower($code)) {
                user()->setFlash('message', "验证码错误");
            } else if (!$_POST["FeedbackForm"]["content"]) {
                user()->setFlash('message', "未填写内容");
            } else {
                $model->userId = user()->getId();
                $model->createTime = now();
                if ($model->validate()) {
                    $model->save();
                    user()->setFlash('message', "谢谢您的反馈");
                    $this->redirect('/feedback/index');
                }
            }
        }
        $this->render('index', compact('model', 'key'));
    }

}
