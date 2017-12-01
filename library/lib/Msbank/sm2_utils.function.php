<?php
$environment = getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'local';
switch ($environment) {
	case 'production':
		$incFile = 'Java.production.inc';
		break;
	case 'test':
		$incFile = 'Java.test.inc';
		break;
	default:
                $incFile = 'Java.local.inc';
		break;
}
require dirname(__FILE__).'/configs/'.$incFile;

/**
 * 初始化
 * 该方法需要在其他方法调用之前调用，且只能调用一次，
 * 本方法会初始化java的工具包实例，工具包程序会维护一个全局实例。
 */
function sadkInitialize() {
	try {
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->Initialize(dirname(__FILE__).'/configs/demo.properties');
		return $ret;
	} catch (Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 带参数的初始化
 * 该方法初始化的效果和调用配置文件初始化的效果完全相同，同样也只能初始化一次。
 * 输入“用户私钥文件路径”，“用户私钥密码”，“民生公钥证书路径”三个参数即可执行初始化操作，
 * 注意路径参数是lajp服务端所在位置的相对路径。
 * @param $privatePath
 * @param $privatePassword
 * @param $publicPath
 */
function sadkInitializeByParam($privatePath, $privatePassword, $publicPath) {
	try {
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->Initialize($privatePath, $privatePassword, $publicPath);
		return $ret;
	} catch (Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 反初始化
 * 因为初始化方法只能调用一次，如果有证书更新的情况可以先调用该方法，然后再调用初始化方法即可。
 */
function sadkUninitialize() {
	try {
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->Uninitialize();
		return $ret;
	} catch (Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 签名数据
 * @param $base64Plain
 */
function sadkSign($base64Plain) {
	try {
		//对数据进行PKCS#7带原文签名
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->P1SignMessage($base64Plain);
		return $ret;
	} catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 加密数据
 * @param $base64Plain
 */
function sadkEncrypt($base64Plain) {
	try {
		//对数据进行加密
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->EncryptMessage($base64Plain);
		return $ret;
	} catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 签名加密
 * @param $base64Plain
 */
function sadkSignAndEncrypt($base64Plain) {
	try {
		//对数据进行PKCS#7带原文签名
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->SignAndEncryptMessage($base64Plain);
		return $ret;
	}
	catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 解密数据
 * @param $cipherText
 * @return mixed
 */
function sadkDecrypt($cipherText) {
	try {
		//验证签名
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->DecryptMessage($cipherText);
		return $ret;
	} catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}

/**
 * 验证签名
 * @param $signedData
 * @return mixed
 */
function sadkVerify($sourceMessage, $signedData) {
	try {
		//验证签名
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->P1VerifyMessage($sourceMessage, $signedData);
		return $ret;
	} catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
		return false;
	}
}

/**
 * 解密和验证签名
 * @param $base64Encode
 * @return mixed
 */
function sadkDecryptAndVerify($base64Encode) {
	try {
		//解密和验证签名
		$decryptKit = java("cfca.sadk.cmbc.tools.php.PHPDecryptKit");
		$ret = $decryptKit->DecryptAndVerifyMessage($base64Encode);
		return $ret;
	} catch(Exception $e) {
		Yii::log(getDump($e), CLogger::LEVEL_ERROR);
	}
}
?>