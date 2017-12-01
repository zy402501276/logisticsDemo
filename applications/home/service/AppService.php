<?php

/**
 * APP逻辑层父类
 * @author  zhangye
 * @time    2017年7月28日
 */
class AppService {


   /**
    * 拼接URL
    * @time 2017年7月28日
    * @param string $baseURL 目标URL地址
    * @param array  $keysArr 参数数组
    * @return string         拼接后的URL  
    */
    public function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();

        foreach ($keysArr as $key => $value) {
            $valueArr[] = "$key=$value";
        }

        $keyStr = implode("&", $value);
        $combined .= ($keyStr);

        return $combined ;
    }

    /**
     * 通过GET请求
     * @time 2017年7月28日
     * @param string $url       目标URL
     * @param array  $keysArr   参数数组
     * @return string           返回的资源内容
     */
    public function get($url, $keysArr){
        $combined = $this->combineURL($url,$keysArr);
        
        if(!empty($combined)){
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($ch,CURLOPT_URL,$url);
            $response = curl_exec($ch);
            curl_close($ch);

        }else{
            return array("state" => FALSE, "msg" => "combined error");
        }

        if(empty($response)){
          return array("state" => FALSE, "msg" => "链接有错误");
        }

        return json_decode($response,true);
    }

    /**
     * 通过POST请求
     * @time 2017年7月28日
     * @param string $url     目标URL
     * @param array  $keysArr 参数数组
     * @return string
     */
    public function post($url ,$keysArr ){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch,CURLOPT_POST,TRUE);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$keysArr);
        curl_setopt($ch,CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
    }



}