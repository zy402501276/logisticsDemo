<?php
/**
 * 主页逻辑控制器
 * @author zhangye
 * @time 2017年11月1日19:12:25
 */
class IndexController extends Controller {
    public function actionIndex(){
        $reUrl = request('reUrl');
        if (!$reUrl) {
            $reUrl = urlencode(isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"]."/index/index" : "/index/index");
        }
        $this->layout = false;
        $this->render('index', compact("model", "reUrl"));
    }

    /**
     * 登录
     */
    public function actionLogin() {
        if (Yii::app()->user->getId()) {
            $this->redirect("/User/List");
        }
        $model = new AdminForm();
        if(isset($_POST["AdminForm"])){
            $model->attributes = $_POST['AdminForm'];
            $userInfo = $model->checkUserLogin();
            if ($userInfo) {
                user()->setId($userInfo["adminId"]);
                user()->setName($userInfo["username"]);
                $this->redirect("/UserDemand/List");
            }
            $model->addError("username", "账户名或密码错误");
        }
        $this->layout = false;
        $this->render('login',compact(array("model")));
    }

    /**
     * 登出
     */
    public function actionLogout() {
        user()->clearStates();
        user()->logout(true);
        app()->request->cookies->clear();
        $this->redirect('/index/index');
    }

    /**
     * 用户第一次进入生成utoken并阅读协议
     * @return bool
     */
    public function actionRegisterUtoken(){
        $userId =  user()->getId();
        if(empty($userId)){
            //todo 提示错误
            return false;
        }
        $userInfo = User::model()->findByPk($userId);
        if(!empty($userInfo)){
            if(empty($userInfo['utoken'])){
                $model = new UserBaseForm();
                $model->attributes = $userInfo;
                $model->utoken = User::generateToken();
                if($model->validate()){
                    $model->save();
                    //todo跳转下一页
                }else{
                    //todo提示失败
                }
            }else{
                //todo跳转到下一页
            }

        }else{
            //todo 跳转首页进行注册
        }

    }

    /**
     * 通行证登录接口
     */
    public function actionUserSystem() {
        $type = UnionLogin::TYPE_PCB_PASSPORT;
        $code = request("code");
        $reUrl = base64_decode($code);
        if(Yii::app()->request->isPostRequest) {
            $service = new UnionLoginService();
            $unionResult = $service->index(UnionLogin::TYPE_PCB_PASSPORT, $_POST, $type, $reUrl);
            if($unionResult['state']){
                $userInfo = $unionResult["userInfo"];
                $this->setLoginInfo($userInfo);
                $url = url("manage/index");
                if(!User::checkFirst()){
                    $url=url("/manage/declare");
                }
            }else{
                echo "登录失败";
                app()->end();
            }
            echo '<script stype="text/javascript">window.opener.location.href="'.$url.'";window.close();</script>';
            app()->end();
        }
    }



}
