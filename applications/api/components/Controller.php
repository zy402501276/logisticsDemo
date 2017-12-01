<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    protected $deviceNo ;//设备号（learncloud配置的）
    protected $deviceName ;//iPhone  Andorid
    protected $utoken;//用户令牌
    protected $appKey;//设备唯一码
    /**
     * API注册接口
     * @time 2017年7月24日
     */
    public function __construct(){
        if(!empty(request('appKey'))){
            $this->deviceNo = request('appKey');
        }
        if(!empty(request('deviceName'))){
            $this->deviceName = request('deviceName');
        }
        if(!empty(request('utoken'))){
            $this->utoken = request('utoken');
        }
        if(!empty(request('appKey'))){
            $this->appKey = request('appKey');
        }
    }

    /**
     *  返回设备的属性
     * @author zhangye
     * @time 2017年8月23日
     * @param $device
     * @return property
     */
    public function getDevice($device){
        if($device == 'deviceNo'){
            return $this->deviceNo;
        }elseif($device == 'deviceName'){
            return $this->deviceName;
        }
    }


	public function init(){
		parent::init();
	}
	
	public function run($actionID) {
		if (preg_match("/_/", $actionID)) {
			//优化接口, 将下划线形式的url转化(例如:add_goods_views转化成addGoodsViews)
			$actionID = UtilsHelper::convertUnderlineToCamelCase($actionID);
		}
		
		//优化action, 一些无逻辑的空action, 则直接render页面, 不需要在新建一个空的action方法
		if( !method_exists($this,'action'.$actionID) && strcasecmp($actionID,'s') ) {
			$view = "/$this->id/$actionID";
			if ($this->getViewFile($view) !== false) {
				$this->layout = '//layouts/main';
				$this->render($view);
				return true;
			}
		}
		
		$this->validateRequest();
		parent::run($actionID);
	}
	
	/**
	 * 输入接口信息
	 * @param number or array $code 
	 * @param string $msgInfo
	 * @author shezz
	 * @date 2014-8-12
	 */
	public function output($code, $msgInfo = null) {
		$data = array('code' => '','message' => '', 'obj' => null);
		if (ErrorCodeHelper::isDefined($code)) {
			$message = ErrorCodeHelper::getError($code);
			$data['code'] = $code;
			if (is_array($msgInfo)) {
				$data = CMap::mergeArray($data, $msgInfo);
			}
		} elseif (is_array($code)) {
			$data = CMap::mergeArray($data, $code);
		} else {
			$message = ErrorCodeHelper::getError($code);
			if (is_array($msgInfo)) {
				$data = CMap::mergeArray($data, $msgInfo);
			}
		}
		$data['code'] = (string)(UtilsHelper::checkArrayIsDefinedVar($data, 'code') ? $data['code'] : 1);
		$data['message'] = (string)(UtilsHelper::checkArrayIsDefinedVar($data, 'message') ? $data['message'] : (ErrorCodeHelper::isDefined($code) ? ErrorCodeHelper::getError($code) : ErrorCodeHelper::getError(1)));
        $this->addLog($data);
		echo jsonEncode($data);
		app()->end();
	}
    /**
     * base64加密后输出
     * @author zhangye
     * @param $code
     * @param null $msgInfo
     */
    public function outputEx($code, $msgInfo = null) {
        $data = array('code' => '','message' => '', 'obj' => null);
        if (ErrorCodeHelper::isDefined($code)) {
            $message = ErrorCodeHelper::getError($code);
            $data['code'] = $code;
            if (is_array($msgInfo)) {
                $data = CMap::mergeArray($data, $msgInfo);
            }
        } elseif (is_array($code)) {
            $data = CMap::mergeArray($data, $code);
        } else {
            $message = ErrorCodeHelper::getError($code);
            if (is_array($msgInfo)) {
                $data = CMap::mergeArray($data, $msgInfo);
            }
        }
        $data['code'] = (string)(UtilsHelper::checkArrayIsDefinedVar($data, 'code') ? $data['code'] : 1);
        $data['message'] = (string)(UtilsHelper::checkArrayIsDefinedVar($data, 'message') ? $data['message'] : (ErrorCodeHelper::isDefined($code) ? ErrorCodeHelper::getError($code) : ErrorCodeHelper::getError(1)));
        $this->addLog($data);
        echo base64_encode(jsonEncode($data));
        app()->end();
    }
	//记录请求日志
	private function addLog($returnData) {
		$config = param('apiConfig');
		if ($config['saveApiRequesetSwitch']) {
			Yii::log("\n".'url: '.$this->route."\n".getDump($_GET)."\n".getDump($_POST)."\ncallback: ".getDump($returnData), CLogger::LEVEL_INFO, 'request');
		}
	}

	/**
	 * 验证请求 
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2016年1月13日
	 */
	private function validateRequest() {
		$config = param('apiConfig');
		if ($config['apiRequestValidate']) {
			$params = null;
			//获取请求参数
			if(app()->request->getIsPostRequest()) {
				$params = $_POST;
			} else {
				$params = $_GET;
			}
                        if(isset($_FILES)) {
                            $fileParams = array_keys($_FILES);
                            $a = array();
                            foreach ($fileParams as $v) {
                                $a[$v] = "";
                            }
                            $params = array_merge($params, $a);
                        }
			//验证token, token不参与加密
			$token = isset($params['token']) ? $params['token'] : 0;
			if (empty($token)) {
				$this->output(-9999);
			}
			unset($params['token']);
			
			//接口版本号不参与加密
			if (isset($params['v'])) {
				unset($params['v']);
			}
			//如果请求不带参数, 则使用固定字符串
			if (empty($params)) {
				$params = array('token' => '', 'v' => '');
			}
			ksort($params);
			$str = '';
			foreach ($params as $key => $v) {
				$str .= $key & $config['salt'];
			}
			$newToken = UtilsHelper::get16Md5($str);
                        Yii::log("\n".'params: '.getDump($params)."\n"."newToken：".$newToken."\n"."str：".$str, CLogger::LEVEL_INFO, 'request');
			if ($newToken == $token) {
				return true;
			}
			$this->output(-9999);
		}
	}


    /**
     * 获取用户信息
     */
    public function getUserInfo($utoken){
        $url = SHOP_URL . '/Ajax/getUtokenInfo/utoken/' . $utoken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return jsonDecode($data);

    }
    /**
     * 商城数据库获取用户信息
     * @param string utoken 用户令牌
     * @Author zhangye
     * @Time 2017年4月20日
     * @return $data
     */
    public function getUserInfomation($utoken){
        $url = MALL_URL . '/Interior/FindUserInfo/utoken/' . $utoken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return jsonDecode($data);
    }
    /**
     * 获取手机标识
     */
    public function getByPhoneKey($userId,$phoneKey){
        $url = SHOP_URL . '/Ajax/getByPhoneKey/userId/' . $userId.'/phoneKey/'.$phoneKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return jsonDecode($data);
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
    /**
     * 添加手机端操作日志、
     * @author zhangye
     * @time 2017年8月22日
     * @param int $type                操作类型
     * @param int $dataId              user表主键ID
     * @param string $operatorName     操作人名称
     * @param string $operatorDecript  操作描述
     * @param string $deviceNo         设备号  (测试用test代替)
     * @param string $deivceName       设备名 默认为iPhone
     */
    public function addMobileLog($type, $dataId, $operatorName = '',$operatorDecript,$deviceNo = 'test',$deivceName = OperationLog::DEVICE_IPHONE) {
        $model = new OperationLogBaseForm();
        $model->type = $type;
        $model->dataId = $dataId;
        $model->ip = $_SERVER["REMOTE_ADDR"];
        $model->operatorType = OperationLog::OPERATOR_TYPE_USER;
        $model->operatorId = $dataId;
        $model->operatorName = $operatorName;
        $model->operatorDecript = $operatorDecript;
        $model->equipmentType = OperationLog::EQUIPMENTTYPE_MOBILE;
        $model->deviceNo = $deviceNo;
        $model->deviceModel = '';
        $model->deviceName = $deivceName;
        if($deivceName == 'iPhone'){
            $model->operatingSystem = OperationLog::OS_IOS;
        }else{
            $model->deviceName = 'android';
            $model->operatingSystem = OperationLog::OS_ANDROID;
        }
        $model->createTime = date("Y-m-d H:i:s");
        $model->save();
    }

    /**
     * 获取用户基本信息
     * @author zhangye
     * @time 2017年8月31日
     * @param $string utoken 用户令牌
     * @return array
     */
    public  function userInfo($utoken){
        if(empty($utoken)){
            $this->output(array('code'=> 0,'message'=>'参数错误'));
        }
        $userInfo = User::model()->findByUtoken($utoken);
        if(empty($userInfo)){
            $this->output(array('code'=> 0,'message'=>'参数错误'));
        }
        return $userInfo;
    }

    /**
     * 判断是否唯一登录
     * @author zhangye
     * @time 2017年10月16日14:13:42
     */
    public function checkLoginInfo(){
        $utoken = $this->utoken;
        $phoneKey = $this->appKey;
        if($utoken){
            $buyItem = User::model()->findByUtoken($utoken);
            if (empty($buyItem)) {
                $this->output(0);
            }
            $userId = $buyItem["id"];
            if($phoneKey) {
                $appKeyItem = UserAppKey::model()->findByUserIdAndKey($userId, $phoneKey);
                if(!$appKeyItem) {
                    echo CJSON::encode(array("code" => -9, "message" => "您的帐号在新的设备上登录，请重新登录！"));
                    app()->end();
                }
            }
        }
        return true;
    }
}