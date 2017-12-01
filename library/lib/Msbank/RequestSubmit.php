<?php
/**
 * 民生银行市场通接口请求帮助类
 * @author shezz
 */
require dirname(__FILE__).'/sm2_utils.function.php';

class RequestSubmit {
	
	private static $info = null;
	public $params = array();
	
	function __construct() {
		if (is_null(self::$info)) {
			$this->params = param('msbank');
			self::$info = sadkInitializeByParam(dirname(__FILE__).'/configs/'.$this->params['smFileName'], $this->params['privatePassword'], dirname(__FILE__).'/configs/'.$this->params['cerFileName']);
		}
	}
	
	/**
	 * 建立请求，以表单HTML形式构造（默认）
	 * @param $transInput 请求参数数组
	 *        	通用输入信息
	 * @param $paramArray 请求参数数组
	 *        	业务输入信息
	 * @param $method 提交方式。两个值可选：post、get
	 * @param $button_name 确认按钮显示文字
	 * @return 提交表单HTML文本
	 */
	public function buildRequestForm($transInput, $paramArray, $service, $method = 'post', $button_name = '确认') {
                Yii::log("Post{ ParamArray: ".getDump($paramArray)."; TransInput: ". getDump($transInput) ."; Service: ". getDump($service)." }", CLogger::LEVEL_PROFILE, 'msbankInterface');
		$cipherTxt = $this->generateCipher($transInput, $paramArray);
		$sHtml = "<form id='netTradeSubmit' name='netTradeSubmit' action='".$service."' method='".$method."'>";
		$sHtml .= "<input type='hidden' name='context' value='".$cipherTxt."'/>";
		$sHtml .= "<input type='submit' value='".$button_name."'></form>";
		$sHtml .= "<script>document.forms['netTradeSubmit'].submit()</script>";
		return $sHtml;
	}

	/**
	 * 建立ajax请求
	 * @return Ambigous <mixed, multitype:string >
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月27日
	 */
	public function buildAjaxRequestForm($transInput, $paramArray, $url) {
                Yii::log("Ajax{ ParamArray: ".getDump($paramArray)."; TransInput: ". getDump($transInput) ."; Url: ". getDump($url)." }", CLogger::LEVEL_PROFILE, 'msbankInterface');
		$data = array (
			'context'=>$this->generateCipher($transInput, $paramArray)
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	/**
	 * 解密数据
	 * @param string $cipherText 密文
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月26日
	 */
	public function sadkDecrypt($cipherText) {
		return sadkDecrypt($cipherText);
	}
	
	/**
	 * 验证签名
	 * @param string $sourceMessage 签名消息
	 * @param string $signedData  签名数据
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月26日
	 */
	public function sadkVerify($sourceMessage, $signedData) {
		return sadkVerify($sourceMessage, $signedData);
	}

	/**
	 * 生成密文
	 * @param array $transInput 通用参数
	 * @param array $paramArray 业务参数
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月27日
	 */
	private function generateCipher($transInput, $paramArray) {
		$bodyArray = array('transInput'=>$transInput);
		while (list ($key, $val) = each($paramArray)) {
			$bodyArray[$key] = $val;
		}
		$bodyJson = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);
		$sign = sadkSign($bodyJson);
		$contextArray = array("body"=>(string)$bodyJson, "sign"=>(string)$sign);
		$contextJson = json_encode($contextArray, JSON_UNESCAPED_SLASHES);
		return sadkEncrypt($contextJson);
	}
	
	/**
	 * 测试加签加密验签解密方法 */
	public function testPhpKit($transInput, $paramArray) {
		$currentDir = dirname(__FILE__);
		echo "=============  商户端  =============<br/>";
		echo "=============step 1  初始化工具包=============<br/>";
		$custPrivatePath = $currentDir.'/configs/5002_production.sm2';
		$custPrivatePassword = "123123";
		$cmbcPublicPath = $currentDir.'/configs/tbank.cer';
		$info = sadkInitializeByParam($custPrivatePath, $custPrivatePassword, $cmbcPublicPath);
// 		$encryptBody = 'This is plain A';
// 		$cipherText = sadkEncrypt($encryptBody);
// 		echo $cipherText;
// 		exit;
		
		$cipherText = 'MIHyBgoqgRzPVQYBBAIDoIHjMIHgAgECMYGdMIGaAgECgBSCIqABSBTTY9pEMqK9uHRpZBjebTANBgkqgRzPVQGCLQMFAARwBaKx40liqUxDN8ghrxdUpCUoQzChljXc799uWnGzLMpsZ/MOGNk1FIxFsPqH2SZVY2EY22T83KkORUR0e+yOTxkXjcJUISPoINbSlSe0QF7EWOE2eqSeWjzqgcfegzOvArXYtR5mU0UFO6XBK36RljA7BgoqgRzPVQYBBAIBMBsGByqBHM9VAWgEEKVNQoQuL9iN0rGpVDA/CmyAEMSoQuxpNzWMFlAeElLdZv0=';
		$sourceData = $this->sadkDecrypt($cipherText);
		echo "明文:".$sourceData."<br/>";
		exit;
		
		echo "反初始化状态码:".$info."<br/>";
		$info = sadkInitializeByParam($custPrivatePath, $custPrivatePassword, $cmbcPublicPath);
		echo "初始化状态码:".$info."<br/>";

		echo "=============step 2  生成签名=============<br/>";
		$bodyArray = array('transInput'=>$transInput);
		while (list ($key, $val) = each($paramArray)) {
			$bodyArray[$key] = $val;
		}
		$signBody = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);
		echo "signBody:".$signBody."<br/>";
		$sign = sadkSign($signBody);
		echo "签名值:".$sign."<br/>";
		
		echo "=============step 3  生成密文=============<br/>";
		$contextArray = array("body"=>$signBody, "sign"=>(string)$sign);
		$encryptBody = json_encode($contextArray, JSON_UNESCAPED_SLASHES);
		$encryptBody = 'This is plain A';
		echo "encryptBody:".$encryptBody."<br/>";
		$cipherText = sadkEncrypt($encryptBody);
		echo "密文:".$cipherText."<br/>";

		echo "=============  银行端  =============<br/>";
		echo "=============step 1  重新初始化工具包=============<br/>";
		$info = sadkUninitialize();
		echo "反初始化状态码:".$info."<br/>";
		$cmbcPrivatePath = $currentDir.'/configs/cmbc.sm2';
		$cmbcPrivatePassword = "111111";
		$custPublicPath = $currentDir.'/configs/5002.cer';
		$info = sadkInitializeByParam($cmbcPrivatePath, $cmbcPrivatePassword, $custPublicPath);
		echo "初始化状态码:".$info."<br/>";

		echo "=============step 2  验证签名=============<br/>";
		echo "签名值:".$sign."<br/>";
		echo "验证结果:".sadkVerify($signBody, $sign)."<br/>";

		echo "=============step 3  解密=============<br/>";
		$cipherText = 'MIHyBgoqgRzPVQYBBAIDoIHjMIHgAgECMYGdMIGaAgECgBSCIqABSBTTY9pEMqK9uHRpZBjebTANBgkqgRzPVQGCLQMFAARwBaKx40liqUxDN8ghrxdUpCUoQzChljXc799uWnGzLMpsZ/MOGNk1FIxFsPqH2SZVY2EY22T83KkORUR0e+yOTxkXjcJUISPoINbSlSe0QF7EWOE2eqSeWjzqgcfegzOvArXYtR5mU0UFO6XBK36RljA7BgoqgRzPVQYBBAIBMBsGByqBHM9VAWgEEKVNQoQuL9iN0rGpVDA/CmyAEMSoQuxpNzWMFlAeElLdZv0=';
		echo "密文:".$cipherText."<br/>";
		$sourceData = sadkDecrypt($cipherText);
		echo "明文:".$sourceData."<br/>";

		$info = sadkUninitialize();
		echo "反初始化状态码:".$info."<br/>";
	} /**/
	
	/**
	 * 更新证书, 在线上服务器运行中证书有更新, 则先执行次方法更新证书
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月23日
	 */
	public function reloadSadk() {
		sadkUninitialize();
	}
}