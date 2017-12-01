<?php
/**
 * 支付宝生成RSA公用逻辑层
 * @author zhangye
 * @time 2017年9月28日14:11:17
 */
class AliPayService {

	/**
	 * 生成支付宝RSA签名
	 * @param 加入签名的参数
     * @return string
	 */
	public function createSign($data,$login = false){
		
		$dataArr = $this->argSort($data);
		if(!$dataArr){
			return false;
		}
		$signStr = $this->createLinkstring($dataArr);
		if(!$signStr){
			return false;
		}
		$sign = $this->rsaSign($signStr);

		if(!$sign){
			return false;
		}
        $sign = urlencode($sign);
		if($login){
            return $signStr.'&sign='.$sign;
        }

		return $sign;

	}


	/**
     * 对数组排序
     * @param $para  array排序前的数组
     * @return 排序后的数组
     */
    private function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * @return 拼接完成以后的字符串
     */
    private function createLinkstring($para) {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    /**
     * 生成签名
     * @param $data 加入签名的字串
     * @return string
     */
    private function rsaSign($data) {
         $str = file_get_contents(ROOT_PATH.'/doc/rsa.txt');
         $res = openssl_get_privatekey($str);
         openssl_sign($data, $sign, $res,OPENSSL_ALGO_SHA256);
         openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }
}