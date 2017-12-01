<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $actionID;
    public $controllerID;
    public $info = null;

    public function run($actionID) {
        $this->actionID = $actionID;
        $this->controllerID = $this->id;
        if (preg_match("/_/", $actionID)) {
            //优化接口, 将下划线形式的url转化(例如:add_goods_views转化成addGoodsViews)
            $actionID = UtilsHelper::convertUnderlineToCamelCase($actionID);
        }
        $this->setLayoutData();
        //优化action, 一些无逻辑的空action, 则直接render页面, 不需要在新建一个空的action方法
        if (!method_exists($this, 'action' . $actionID) && strcasecmp($actionID, 's')) {
            $view = "/$this->id/$actionID";
            if ($this->getViewFile($view) !== false) {
                $this->layout = '//layouts/main';
                $this->render($view);
                return true;
            }
        }
        parent::run($actionID);
    }

    /**
     * 渲染页面
     * (non-PHPdoc)
     * @see CController::render()
     */
    public function render($view, $data = array(), $return = false) {
        $render = request('render', 0);
        $fileName = request('fileName');
        $moduleName = request('moduleName');
        if ($render && $fileName && $moduleName) {
            $paths = param('htmlFilePath');
            if (isset($paths[$moduleName])) {
                //静态化页面
                $content = parent::render($view, $data, true);
                $filePath = $paths[$moduleName]['path'] . $paths[$moduleName]['controllerID'] . '/' . $fileName;
                UtilsHelper::generateHtml($content, $filePath);
                app()->end();
            }
        } else {
            return parent::render($view, $data, $return);
        }
    }

    /**
     * @param number or array $code
     * @param string $msgInfo
     * 输出结果
     * @demo:
     * 	$this->output(1);
     * 	$this->output(1, '收藏成功');
     * @author shezz
     * @date 2014-8-12
     */
    public function output($code, $msgInfo = null) {
        $data = array('returnCode' => '', 'info' => '', 'data' => '');
        //如果data传入的是一个code错误码, 则直接以错误结果返回
        if (ErrorCodeHelper::isDefined($code)) {
            $msg = ErrorCodeHelper::getError($code);
            if (is_array($msgInfo)) {
                $data = CMap::mergeArray($data, $msgInfo);
            }
        } elseif (is_array($code)) {
            $data = CMap::mergeArray($data, $code);
            $code = 1;
            $msg = ErrorCodeHelper::getError(1);
        } else {
            $msg = ErrorCodeHelper::getError($code);
        }
        $data['returnCode'] = (string) $code;
        $data['info'] = empty($data['info']) ? $msg : $data['info'];

        $this->addLog($data);
        $json = jsonEncode($data);
        echo $json;
        app()->end();
    }

    /**
     * 设置页面title
     * (non-PHPdoc)
     * @see CController::setPageTitle()
     */
    public function setPageTitle($title) {
        $title = $title ? $title . ' - ' . app()->name : app()->name;
        parent::setPageTitle($title);
    }

     /**
 * 设置用户登录信息
 * @param type $item
 */
    public function setLoginInfo($item)
    {
        user()->setId($item['id']);
        user()->setName($item['name']);

    }
    /**
     * 获取用户登录信息
     * @author shezz
     * @2015年1月27日
     */
    public function getLoginInfo() {
        $userInfo = app()->session['userInfo'];
        if (empty($userInfo)) {
            //跳转登录
            $this->redirect(SHOP_URL . '/login?reUrl=' . urlencode('http://' . $_SERVER['HTTP_HOST'] . app()->request->url));
        }
        return $userInfo;
    }

    /**
     *
     * 校验是否登录
     *
     * @author shezz
     * @email shezz@lexiangzuche.com
     * @date 2015年2月6日
     */
    public function checkIsLogin($redirect = true) {
        if (!user()->isGuest) {
            //非游客, 即登录
            return true;
        }
        if ($redirect) {
            $this->redirect('/index/login');
        }
        return false;
    }

    /**
     * 输出js
     *
     * @author shezz
     * @email shezz@lexiangzuche.com
     * @date 2015年3月17日
     */
    public function outputScript() {
        if (cs()->scripts) {
            foreach (cs()->scripts as $script) {
                foreach ($script as $key => $sc) {
                    echo CHtml::script($sc);
                }
            }
        }
    }

    //记录请求日志
    private function addLog($returnData) {
        $switch = param('apiConfig');
        if ($switch['saveApiRequesetSwitch']) {
            Yii::log("\n" . 'url: ' . $this->route . "\n" . getDump($_GET) . "\n" . getDump($_POST) . "\ncallback: " . getDump($returnData), CLogger::LEVEL_INFO, 'api');
        }
    }

    /**
     * 设置layout内的数据
     */
    private function setLayoutData() {
        $userInfo = app()->session['userInfo'];
        if($userInfo && !user()->getId()){
            user()->setId($userInfo['userId']);
            user()->setName($userInfo['username']);
            user()->setState('isAuth', $userInfo['isAuth']);
            user()->setState('avatar', $userInfo['avatar']);
            user()->setState('companyType', $userInfo['companyType']);
        }
    }

    /**
     * 提示与跳转
     * @param type $message 提示语
     * @param type $msgType 操作成功/失败
     * @param type $rUrl 返回链接
     */
    public function setMessageAndRedirect($message = "操作成功", $msgType = true, $rUrl = ""){
        $url = $rUrl ? $rUrl : Yii::app()->request->urlReferrer;
        if(strstr($url, SHOP_URL)){
            $url = HOME_URL;
        }
        user()->setFlash('message', $message);
        $msgType = $msgType ? 1 : 0;
        user()->setFlash('msgType', $msgType);
        $this->redirect($url);
    }
    
    /**
     * 获取用户信息
     * @param type $userId
     */
    public function getUserInfo($userId){
        $url = SHOP_URL . '/ajax/getBuyerInfoByErshou/buyerId/' . $userId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return jsonDecode($data);
        
    }
    
    /**
     * 验证缓存是否可用
     * @param type $key 缓存关键词
     * @param type $afterSecond 有效时间
     * @return boolean true 可用 false 不可用
     */
    private function checkLayoutCache($key, $afterSecond = 300) {
        if (MemcacheHelper::exists($key)) {
            $code = MemcacheHelper::get($key);
            if (isset($code['createTime']) && time() - $code['createTime'] < $afterSecond) {
                return true;
            }
        }
        return false;
    }
    
    
    

}
