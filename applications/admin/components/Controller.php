<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $actionID;

    public function run($actionID) {
        //设置语言
        $lang = request('lang');
        if (!$lang) {
            $lang = user()->getState('lang');
            if (!$lang) {
                $lang = request('lang');
                $lang = $lang ? $lang : app()->request->getPreferredLanguage();
                user()->setState('lang', $lang);
            }
        }
        app()->setLanguage($lang);
        $this->actionID = $actionID;
        $this->checkIsLogin();
        if (preg_match("/_/", $actionID)) {
            //优化接口, 将下划线形式的url转化(例如:add_goods_views转化成addGoodsViews)
            $actionID = UtilsHelper::convertUnderlineToCamelCase($actionID);
        }

        //优化action, 一些无逻辑的空action, 则直接render页面, 不需要在新建一个空的action方法
        if (!method_exists($this, 'action' . $actionID) && strcasecmp($actionID, 's')) {
            $view = "/$this->id/$actionID";
            if ($this->getViewFile($view) !== false) {
                $this->layout = '//layouts/main';
                $this->render($view);
                return true;
            }
        }
//		$contro = Yii::app()->controller->id;
//		if(!$this->checkAuth($contro, $actionID)) {
//			echo "没有权限访问";exit;
//		}
        parent::run($actionID);
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
// 		$title = app()->name.' -- '.$title;
        parent::setPageTitle($title);
    }

    /**
     * 设置登录信息
     * @param array $userInfo 管理员账号信息
     * @author shezz
     * @date 2015-1-23
     */
    public function setLoginInfo($userInfo) {
        if (isset($userInfo) && is_array($userInfo)) {
            user()->setId($userInfo['adminId']);
            user()->setName($userInfo['username']);
            user()->setState("isSupper", $userInfo["isSupper"]);
        }
    }

    /**
     * 获取用户登录信息
     * @author shezz
     * @2015年1月27日
     */
    public function getLoginInfo($emptyToLogin = true) {
        $info = user()->getState('info');
        if (empty($info) && $emptyToLogin) {
            user()->setFlash('message', '由于您长时间未操作,请重新登录');
            $this->redirect('/login');
        }
        return $info;
    }

    /**
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
            $this->redirect(LOGISTICS_ADMIN_URL);
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
     * 检查是否有权限访问该控制器中方法
     * @param String $contro 控制器名称
     * @param String $actionId 方法名称
     * @return boolean true 可以访问 | false 没有权限
     */
    private function checkAuth($contro, $actionId) {
// 		return true;
        if (method_exists($contro . "Controller", "accessRules")) {
            $rules = $this->accessRules();
            $authList = Yii::app()->user->getState("authList");
            foreach ($rules as $key => $releVal) {
                if (!in_array($actionId, $releVal)) {
                    continue;
                }
                if ($key == "all") {
                    return true;
                }
                if (in_array($key, $authList)) {
                    Yii::app()->user->setState("selAuth", $key);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 下载方法
     * @param array $data
     * @author dean
     */
    public function download($title, $datas, $name = '') {
        Yii::import("ext.utils.PhpExcel.PHPExcel");
        //写入错误数据进excel导回给用户
        //输出表头
        $objPHPExcel = new PHPExcel();
        $sheet = array('0' => 'A', '1' => 'B', '2' => 'C', '3' => 'D', '4' => 'E', '5' => 'F', '6' => 'G', '7' => 'H', '8' => 'I', '9' => 'J', '10' => 'K', '11' => 'L');
        if (count($title)) {
            $obj = $objPHPExcel->setActiveSheetIndex(0);
            foreach ($title as $key => $title) {
                $obj->setCellValue($sheet[$key] . '1', $title);
            }
        }
        //输出内容
        foreach ($datas as $key => $data) {
            $obj2 = $objPHPExcel->setActiveSheetIndex(0);
            $data = array_values($data);
            foreach ($data as $k => $d) {
                $obj2->setCellValue($sheet[$k] . ($key + 2), $d);
            }
        }
        //Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $name . '.xlsx"');
        header('Cache-Control: max-age=0');
        //If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    /**
     * 提示与跳转
     * @param type $message 提示语
     * @param type $msgType 操作成功/失败
     * @param type $rUrl 返回链接
     */
    public function setMessageAndRedirect($message = "操作成功", $msgType = true, $rUrl = "") {
        $url = $rUrl ? $rUrl : Yii::app()->request->urlReferrer;
        if (strstr($url, SHOP_URL)) {
            $url = HOME_URL;
        }
        user()->setFlash('message', $message);
//        user()->setFlash('msgType', $msgType);
        $this->redirect($url);
    }
    
    /**
     * 添加操作日志
     * @param type $type 操作类型
     * @param type $dataId 关联数据ID
     * @param type $createTime 操作时间
     * @param type $operatorType 操作人类型
     * @param type $operatorId 操作人Id 
     * @param type $operatorName 操作人名称
     * @param type $operatorDecript 操作描述
     */
    public function addOperationLog($type, $dataId, $operatorType = OperationLog::OPERATOR_TYPE_USER, $operatorId = '', $operatorName = '',$operatorDecript) {
        $model = new OperationLogBaseForm();
        $ua = UserAgentHelper::getUserAgent();
        $model->attributes = $ua;
        $model->type = $type;
        $model->dataId = $dataId;
        $model->operatorType = $operatorType;
        $model->operatorId = $operatorId ? $operatorId : user()->getId();
        $model->operatorName = $operatorName ? $operatorName : user()->getName();
        $model->createTime = date("Y-m-d H:i:s");
        $model->ip = $_SERVER["REMOTE_ADDR"];
        $model->operatorDecript = $operatorDecript;
        $model->save();
    }
}
