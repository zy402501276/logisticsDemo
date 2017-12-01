<?php
class KuaiDi100 {
    private $AppKey = '9c86cb2dfb05630a';
    /**
     * 快递公司Code
     */
    public $companyCode;
    /**
     * 快递单号
     */
    public $shippingSn;
    /**
     * 返回数据类型
     * 0：返回json字符串， 
     * 1：返回xml对象， 
     * 2：返回html对象， 
     * 3：返回text文本。 
     * 默认为json字符串
     */
    public $show = 0;
    /**
     * 返回信息数量： 
     * 1:返回多行完整的信息， 
     * 0:只返回一行信息。 
     * 默认为返回多行数据
     */
    public $muti = 1;
    /**
     * 排序： 
     * desc：按时间由新到旧排列， 
     * asc：按时间由旧到新排列。 
     * 默认为desc 由新到旧排列
     */
    public $order = "desc";
    
    /**
     * 获取物流信息
     * @return array array();
     */
    public function findLogistics() {
        $url ='http://api.kuaidi100.com/api?id='.$this->AppKey.'&com='.$this->companyCode.'&nu='.$this->shippingSn.'&show='.$this->show.'&muti='.$this->muti.'&order='.$this->order;
        if (function_exists('curl_init') == 1){
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt ($curl, CURLOPT_HEADER,0);
            curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
            curl_setopt ($curl, CURLOPT_TIMEOUT,5);
            $get_content = curl_exec($curl);
            curl_close ($curl);
        }else{
            require dirname(__FILE__).'/Logistics/KuaiDi100/snoopy.php';
            $snoopy = new snoopy();
            $snoopy->referer = 'http://www.google.com/';//伪装来源
            $snoopy->fetch($url);
            $get_content = $snoopy->results;
        }
        return CJSON::decode($get_content);
    }
}

