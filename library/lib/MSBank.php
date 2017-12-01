<?php
/**
 * 民生银行市场通接口类
 * @author shezz
 */
class MSBank {

	/**
	 * 请求协议类型  http / https
	 */
	private $requestType = 'http';
	/**
	 * 请求方式,  同步, app请求: json, 异步请求 :html
	 */
	private $requestMethod = 'json';
	/**
	 * 交易渠道PC:00,IOS:01,ANDROID:02
	 */
	private $channel = '00';
	
	private $params = array();
	private static $request = null;
	
	/**
	 * 开户接口编码 
	 */
	private $createAccountNo = 'CNP_T000001';
	/**
	 * 查询帐户编码 
	 */
	private $queryAccountNo = 'CNP_Q000001';
	/**
	 * 对私银行在线编码
	 */
	private $bindPriAccountNo = 'CNP_T000003';
	/**
	 * 对公帐户线下绑定编码
	 */
	private $bindAccountNo = 'CNP_T000002';
	/**
	 * 银行卡绑定信息查询编码
	 */
	private $cardBindInfoQueryNo = 'CNP_Q000003';
	/**
	 * 客户线上充值编码
	 */
	private $rechargeOnLineNo = 'CNP_T000012';
	/**
	 * 客户发起销户编码
	 */
	private $cancleFundAccByCustNo = 'CNP_T000011';
	/**
	 * 客户提现编码
	 */
	private $withdrawCashApplyByCustNo = 'CNP_T000004';
	/**
	 * 客户提现确认编码
	 */
	private $withdrawCashConfirmNo = 'CNP_T000005';
	/**
	 * 资金明细查询编码
	 */
	private $fundsDetailQueryNo = 'CNP_Q000002';
	/**
	 * 平台发起交易编码
	 */
	private $transApplyByPlatformNo = 'CNP_T000007';
	/**
	 * 客户间发起转账编码
	 */
	private $transferByClientNo = 'CNP_T000006';
	/**
	 * 商户余额查询编码 
	 */
	private $merchantBalanceQueryNo = 'CNP_Q000005';
	/**
	 * 文件下载编码
	 */
	private $fileDownLoadNo = 'CNP_F000001';
	/**
	 * 交易结果通知编码
	 */
	private $transactionResultNotifyNo = 'CNP_N000003';
	/**
	 * 文件生成通知编码
	 */
	private $fileDownLoadNotifyNo = 'CNP_N000001';
	/**
	 * 客户发起银行卡解除绑定编码
	 */
	private $unbindCardOnLineNo = 'CNP_T000017';
	/**
	 * 交易状态查询编码
	 */
	private $exSerialStatusQueryNo = 'CNP_Q000004';
	/**
	 * 平台发起撤销交易编码
	 */
	private $cancelApplyByPlatformNo = 'CNP_T000014';
	
	/**
	 * 客户发起交易编码
	 */
	private $transApplyByCustNo = 'CNP_T000021';
	/**
	 * 请求成功返回代码
	 */
	private $successReturnCode = '0000';
	
	/**
	 * 开户类型
	 */
	CONST CREATE_ACCOUNT_TYPE = 1;
	/**
	 * 绑定银行卡类型
	 */ 
	CONST BIND_ACCOUNT_TYPE = 2;
	/**
	 * 客户线上充值类型
	 */
	CONST RECHARGE_ONLINE = 3;
	/**
	 * 客户提现类型
	 */
	CONST CLIENT_WITHDRAW = 4;
	/**
	 * 客户之间转账类型
	 */
	CONST TRANSFER_CLIENT = 5;
	/**
	 * 平台发起交易类型
	 */
	CONST TRANSFER_PLATFORM = 6;
	/**
	 * 解绑银行卡类型
	 */
	CONST UNBIND_ACCOUNT = 7;
	/**
	 * 支付服务费类型
	 */
	CONST PAY_SERVICE = 8;
	/**
	 * 资金冻结类型
	 */
	CONST FREEZE_FUND = 9;
        /**
         * 销户类型
         */
	CONST CANCEL_ACCOUNT_TYPE = 10;
        /**
         * 取消订单退款类型
         */
        CONST CANCEL_RERURN = 11;
        
	public function __construct() {
		require dirname(__FILE__).'/Msbank/RequestSubmit.php';
		if (is_null(self::$request)) {
			self::$request = new RequestSubmit();
		}
		$this->requestMethod = 'html';
		$this->requestType = self::$request->params['httpPrefix'];
		$this->channel = '00';
		$this->params = self::$request->params;
	}
	
	//------------------------------------业务相关接口开始------------------------------------
	/**
	 * 客户发起开户接口
	 * @param BuyerBankAccountBaseForm $form
	 *  需赋值参数: usrId, idType, clientType 如果是企业开户, 则还需要再加reprIdType
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月23日
	 */
	public function createAccount(BuyerBankAccountBaseForm $form) {
		$paramArray = array(
			"clientType"	=> (string)$form->clientType,
		    	"clientName"	=> (string)$form->clientName,
		    	"idType"	=> (string)$form->idType,
		    	"idCode"	=> (string)$form->idCode,
		    	"taxNo"	=> (string)$form->taxNo,
		    	"bisCode"	=> (string)$form->bisCode,
		    	"reprName"	=> (string)$form->reprName,
		    	"reprIdType"	=> (string)$form->reprIdType,
		    	"reprIdCode"	=> (string)$form->reprIdCode,
		    	"actorName"	=> (string)$form->actorName,
// 		    	"actorIdType"	=> (string)$form->actorIdType,
		    	"actorIdCode"	=> (string)$form->actorIdCode,
		    	"mobile"	=> (string)$form->mobile,
		    	"email"	=> (string)$form->email
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'orderId' => $this->generateOrderId(self::CREATE_ACCOUNT_TYPE),
			'transCode' => $this->createAccountNo,
			'usrId' => (string)$form->usrId,
			'notifyUrl' => $this->params['createAccountByCustNotifyUrl'],
			'returnUrl' => $this->params['createAccountByCustReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['createAccountByCust'].$this->requestMethod, "post", "确认");
	}

	/**
	 * 账户信息查询
	 * @param BuyerBankAccountBaseForm $form
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月27日
	 */
	public function queryAccount($bankAcc, $userId) {
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'fundAcc' => (string)$bankAcc,
			'transCode' => (string)$this->queryAccountNo,
			'usrId' => (string)$userId,
		)), array(), $this->requestType.$this->params['gateway'].$this->params['queryAccount'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return array();
	}
	
	/**
	 * 绑定银行卡
	 * @param string $bankAcc 银行卡号
	 * @param int $userId 用户ID
	 * @param int $type 绑定类型, 1对私绑定, 0对公绑定
	 * @param int $bindMode 绑定方式, 0-提现绑卡 1-充值绑卡
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月28日
	 */
	public function bindAccount($bankAcc, $userId, $type = 1, $bindMode = 0) {
		$url = $type == 1 ? 'bindPriAccount' : 'bindAccount';
                $transCode = $type == 1 ? $this->bindPriAccountNo : $this->bindAccountNo;
		return self::$request->buildRequestForm($this->getTransInput(array(
			'fundAcc' => (string)$bankAcc,
			'transCode' => (string)$transCode,
			'usrId' => (string)$userId,
			'notifyUrl' => $this->params['bindAccNotifyUrl'],
			'returnUrl' => $this->params['bindAccReturnUrl'],
			'orderId' => $this->generateOrderId(self::BIND_ACCOUNT_TYPE),
		)), array('bindMode' => (string)$bindMode), $this->requestType.$this->params['gateway'].$this->params[$url].$this->requestMethod);
	}
	
	/**
	 * 银行卡绑定信息查询
	 * @param String $bankAcc 银行卡号 输入则查询指定卡号绑定信息,不输则返回账号项下全部绑定银行卡信息
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月14日
	 */
	public function cardBindInfo($fundAcc, $bankAcc = "") {
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'fundAcc' => $fundAcc,
			'transCode' => $this->cardBindInfoQueryNo,
		)), array("bankAcc" => $bankAcc), $this->requestType.$this->params['gateway'].$this->params['cardBindInfoQuery'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return array();
	}
	
	/**
	 * 客户线上充值
	 * @param string $orderId 订单ID
	 * @param string $amount 充值金额
	 * @param string $bankAcc 充值虚拟帐户
	 * @param string $userId 用户ID
	 * @param int  $accoutType 帐户类型, 1[个人], 0[对公]
	 * @param string $bankNo 支付银行编号
	 * @param string $bindBankAcc 绑定实体银行帐户
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月29日
	 */
	public function rechargeOnLine($orderId, $amount, $bankAcc, $userId, $accoutType, $bankNo, $bindBankAcc = '') {
		switch ($accoutType) {
			case 1:
				//个人充值
				$rechargeFlag = '1';
				break;
			case 0:
				//对公充值
				$rechargeFlag = '1';
				break;
			default:
				return false;
		}
//                $rechargeFlag = '1';
//                $accoutType = "0";
		$paramArray = array(
			'amt' => (string)$amount,
			'bankNo' => $bankNo,
			'rechargeFlag' => (string)$rechargeFlag,
			'rechargeType' => (string)$accoutType,
			'bankAcc' => (string)$bindBankAcc
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->rechargeOnLineNo,
			'fundAcc' => (string)$bankAcc,
			'usrId' => (string)$userId,
			'orderId' => $orderId,
			'notifyUrl' => $this->params['clientRechargeNotifyUrl'],
			'returnUrl' => $this->params['clientRechargeOlReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['rechargeOnLine'].$this->requestMethod);
	}
	
	/**
	 * 销户
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月29日
	 */
	public function cancleFundAccByCust($bankAcc, $userId) {
		$paramArray = array(
			'operFlag' => '0'
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->cancleFundAccByCustNo,
			'fundAcc' => (string)$bankAcc,
			'usrId' => (string)$userId,
			'orderId' => $this->generateOrderId(self::CANCEL_ACCOUNT_TYPE), 
			'notifyUrl' => $this->params['cancelFundNotifyUrl'],
			'returnUrl' => $this->params['cancelFundReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['cancleFundAccByCust'].$this->requestMethod);
	}

	/**
	 * 提现接口
	 * @param string $orderId 订单ID
	 * @param string $bankAcc 虚拟帐户
	 * @param int $userId 用户ID
	 * @param float $amount 提现金额
	 * @param string $bankNo 银行编码
	 * @param string $realBankAcc 实体帐户
	 * @param int $operFlag 提现类别 0-提现申请  2-实时放款 
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月2日
	 */
	public function withdrawCashApplyByCust($orderId, $bankAcc, $userId, $amount, $bankNo, $realBankAcc, $operFlag = '2') {
		$paramArray = array(
			'amt' => (string)$amount,
			'bankNo' => (string)$bankNo,
			'bankAcc' => (string)$realBankAcc,
			'operFlag' => (string)$operFlag
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->withdrawCashApplyByCustNo,
			'fundAcc' => (string)$bankAcc,
			'usrId' => (string)$userId,
			'orderId' => $orderId,
			'notifyUrl' => $this->params['withdrawNotifyUrl'],
			'returnUrl' => $this->params['withdrawReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['withdrawCashApplyByCust'].$this->requestMethod);
	}
	
	/**
	 * 提现确认接口
	 * @param string $assoSerial 提现申请返回的银行流水号
	 * @param int  $userId 用户ID
	 * @param string $bankAcc 用户虚拟帐户
	 * @param float $amount 提现金额
	 * @param string $bankNo  绑定银行编号
	 * @param string $realBankAcc 绑定银行帐户
	 * @param string $operFlag 1-确认 3-撤销  4-垫资提现（可提现余额不足则从平台垫资账号出差额）
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月3日
	 
	public function withdrawCashConfirm($assoSerial, $userId, $bankAcc, $amount, $bankNo, $realBankAcc, $operFlag = '1') {
		$paramArray = array(
			'assoSerial' => (string)$assoSerial,
			'amt' => (string)$amount,
			'bankNo' => (string)$bankNo,
			'bankAcc' => (string)$realBankAcc,
			'operFlag' => (string)$operFlag
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->withdrawCashConfirmNo,
			'fundAcc' => (string)$bankAcc,
			'usrId' => (string)$userId,
			'orderId' => $this->generateOrderId(self::CLIENT_WITHDRAW),
			'notifyUrl' => $this->params['withdrawConfirmNotifyUrl'],
			'returnUrl' => $this->params['withdrawConfirmReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['withdrawCashConfirm'].$this->requestMethod);
	}*/
	
	/**
	 * 资金明细查询
	 * @param string $bankAcc 银行虚拟帐户
	 * @param int $userId 用户ID
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月29日
	 */
	public function fundsDetailQuery($bankAcc, $page = 1, $size = 20, $startDate = '', $endDate = '') {
		$paramArray = array(
			'startDate' => (string)$startDate,
			'endDate' => (string)$endDate,
			'currentPage' => (string)$page,
			'pageSize' => (string)$size,
		);
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->fundsDetailQueryNo,
			'fundAcc' => (string)$bankAcc,
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['fundsDetailQuery'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return array();
	}
	
	/**
	 * 客户之间发起转账
	 * @param string $orderId 订单ID
	 * @param float $amount 转账金额 
	 * @param string $payAccount 付款帐户
	 * @param int $userId 付款用户ID
	 * @param string $receAccount 收款帐户
	 * @param string $receName 收款人名称
	 * @param int $frozenFlag 是否冻结资金, 1是, 0否
	 * @param string $summary  交易备注
	 * @param string $businCode 业务类别 306-客户转账 , 307-订单支付 , 308-公益捐款
	 * 
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月2日
	 */
	public function transferByClient($orderId, $amount, $payAccount, $userId, $receAccount, $receName, $frozenFlag = 1, $summary = '订单支付', $businCode = '307') {
		$paramArray = array(
			'businCode' =>  (string)$businCode,
			'amt' => (string)$amount,
			'targFundAcc' => (string)$receAccount,
			'otherAccName' => (string)$receName,
			'summary' => (string)$summary,
			'frozenFlag' => (string)$frozenFlag,
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->transferByClientNo,
			'fundAcc' => (string)$payAccount,
			'usrId' => (string)$userId,
			'orderId' => $orderId,
			'notifyUrl' => $this->params['payNotifyUrl'],
			'returnUrl' => $this->params['payReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['transferByClient'].$this->requestMethod);
	}
	
	
	/**
	 * 客户发起交易
	 * @param string $orderId 订单ID
	 * @param float $amount 转账金额 
	 * @param string $payAccount 付款帐户
	 * @param int $userId 付款用户ID
	 * @param string $receAccount 收款帐户
	 * @param string $receName 收款人名称
	 * @param int $frozenFlag 是否冻结资金, 1是, 0否
	 * @param string $feeCode 费用代码 001-充值手续费 002-提现手续费 201-托管费 014 - 开店服务费
	 * @param string $summary  交易备注
	 * @param string $businCode  305-客户缴费  391-客户发红包
	 * 
	 * @return 提交表单HTML文本
	 */
	public function transApplyByCust($orderId,$amount, $payAccount, $userId, $receAccount, $receName, $frozenFlag = 0, $feeCode = '001',$summary = '支付店铺服务费', $businCode = '305') {
		$paramArray = array(
				'businCode' =>  (string)$businCode,
				'amt' => (string)$amount,
				'targFundAcc' => (string)$receAccount,
				'otherAccName' => (string)$receName,
				'summary' => (string)$summary,
				'frozenFlag' => (string)$frozenFlag,
				'feeCode' => (string)$feeCode
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
				'transCode' => $this->transApplyByCustNo,
				'fundAcc' => (string)$payAccount,
				'usrId' => (string)$userId,
				'orderId' => $orderId,
				'notifyUrl' => $this->params['payNotifyUrl'],
				'returnUrl' => $this->params['payReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['transApplyByCust'].$this->requestMethod);
	}
	/**
	 * 发起交易
	 * @param float $amount 交易金额
	 * @param string $buyerAccount 买家市场通帐户 
	 * @param int $userId 买家用户ID
	 * @param string $sellerAccount 卖家市场通帐户
	 * @param int $businCode 交易编码  106[资金冻结], 107[资金解冻]
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月31日
	 */
	public function transApplyByPlatform($amount, $buyerAccount, $userId, $sellerAccount, $businCode = '106') {
		$paramArray = array(
			'businCode' => (string)$businCode,
			'payFundAcc' => (string)$buyerAccount,
			'amt' => (string)$amount,
			'targFundAcc' => (string)$sellerAccount
		);
//		return self::$request->buildRequestForm($this->getTransInput(array(
//			'transCode' => $this->transApplyByPlatformNo,
//			'fundAcc' => (string)$this->params['account'],
//			'usrId' => (string)$userId,
//			'orderId' =>$this->generateOrderId(self::TRANSFER_PLATFORM),
//			'notifyUrl' => $this->params['payNotifyUrl'],
//			'returnUrl' => $this->params['payReturnUrl'],
//		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['transApplyByPlatform'].$this->requestMethod);
                $data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->transApplyByPlatformNo,
			'fundAcc' => (string)$this->params['account'],
			'usrId' => (string)$userId,
			'orderId' =>$this->generateOrderId(self::TRANSFER_PLATFORM),
			'notifyUrl' => $this->params['payNotifyUrl'],
			'returnUrl' => $this->params['payReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['transApplyByPlatform'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return $data;
	}
	
	/**
	 * 商户余额查询
	 * @param int $accAttr 查询帐户类型
	 * 	1-商户充值账户      
		2-商户费用账户      
		5-商户风险互助金账户
		6-商户利息账户      
		7-商户市场活动账户  
		A-商户托管结算户    
		B-商户自有结算账户
		C-商户备付金结算账户
		D-商户中转账户
		E-商户保证金
	 * @param int $currentPage 查询当前页数
	 * @param int $pageSize  查询每页记录数
	 * @return mixed
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月6日
	 */
	public function merchantBalanceQuery($accAttr, $currentPage = 1, $pageSize = 15) {
		$paramArray = array(
			'accAttr' => (string)$accAttr,
			'currentPage' => (string)$currentPage,
			'pageSize' => (string)$pageSize,
		);
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->merchantBalanceQueryNo,
			'fundAcc' => (string)$this->params['account'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['merchantBalanceQuery'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return $data;
	}
	
	/**
	 * 文件下载
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月9日
	 */
	public function fileDownLoad($fileToken, $segmentIndex = "0") {
		$paramArray = array(
			'fileToken' => (string)$fileToken,
			'segmentIndex' => $segmentIndex,
		);
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->fileDownLoadNo,
			'fundAcc' => $this->params['account'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['fileDownLoad'].'json');
                $data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return $data;
	}
        
        /**
         * 文件下载后返回加密数据串
         * @param type $paramArray  业务数组
         * @return type
         * @author dean
         */
        public function fileDownLoadReturn($paramArray) {
            $transInput = $this->getTransInput(array(
			'transCode' => $this->fileDownLoadNo,
			'fundAcc' => $this->params['account'],
		));
            $bodyArray = array('transInput'=>$transInput);
            while (list ($key, $val) = each($paramArray)) {
                    $bodyArray[$key] = $val;
            }
            $signBody = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);
            $sign = sadkSign($signBody);
            $contextArray = array("body"=>$signBody, "sign"=>(string)$sign);
            $encryptBody = json_encode($contextArray, JSON_UNESCAPED_SLASHES);
            $cipherText = sadkEncrypt($encryptBody);
            return $cipherText;
        }
	
	/**
	 * 交易结果通知
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月9日
	 */
	public function transactionResultNotify() {
		
	}
	
	/**
	 * 文件生成通知
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月9日
	 */
	public function fileDownLoadNotify($fileName, $fileToken, $fileDate, $fileAllSegments) {
            $paramArray = array(
                    'fileName' => (string)$fileName,
                    'fileToken' => (string)$fileToken,
                    'fileDate' => (string) $fileDate,
                    'fileAllSegments'=> $fileAllSegments,
            );
            $data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
                    'transCode' => $this->fileDownLoadNotifyNo,
                    'fundAcc' => $this->params['account'],
            )), $paramArray, $this->requestType.$this->params['gateway'].$this->params['fileDownLoadNotify'].'json');
            return  CJSON::decode($data);
	}
        
        /**
	 * 文件生成通知 -- 我们通知CMBC
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月9日
	 */
	public function platformFileGenerateNotify($fileName, $fileToken, $fileDate, $fileAllSegments) {
            $paramArray = array(
                    'fileName' => (string)$fileName,
                    'fileToken' => (string)$fileToken,
                    'fileDate' => (string) $fileDate,
                    'fileAllSegments'=> $fileAllSegments,
            );
            $data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
                    'transCode' => $this->fileDownLoadNotifyNo,
                    'fundAcc' => $this->params['account'],
            )), $paramArray, $this->requestType.$this->params['gateway'].$this->params['platformFileGenerateNotify'].'json');
            return  CJSON::decode($data);
	}
	
	/**
	 * 解除绑定银行卡
	 * @param int $userId 用户ID
	 * @param string $bankNo 绑定的银行编码
	 * @param string $bankAcc 虚拟帐户号
	 * @param string $bankAcc 实体银行卡号
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月11日
	 */
	public function unbindCardOnLine($userId, $bankNo, $bankAcc, $bindBankAcc) {
		$paramArray = array(
			'bankNo' => (string)$bankNo,
			'bankAcc' => (string)$bindBankAcc,
		);
		return self::$request->buildRequestForm($this->getTransInput(array(
			'transCode' => $this->unbindCardOnLineNo,
			'fundAcc' => (string)$bankAcc,
			'usrId' => (string)$userId,
			'orderId' =>$this->generateOrderId(self::UNBIND_ACCOUNT),
			'notifyUrl' => $this->params['unbindCardOnLineNotifyUrl'],
			'returnUrl' => $this->params['unbindCardOnLineReturnUrl'],
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['unbindCardOnLine'].$this->requestMethod);
	}
	
	/**
	 * 交易状态查询
	 * @param string $orderId  交易订单ID
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月12日
	 */
	public function exSerialStatusQuery($orderId) {
		$paramArray = array(
			'assoSerial' => (string)$orderId,
		);
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->exSerialStatusQueryNo,
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['exSerialStatusQuery'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return $data;
	}
	
	/**
	 * 平台发起撤销交易
	 * @param string $assoSerial  要撤销的交易流水号
	 * @param float $amt 交易金额
	 * @return mixed
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月13日
	 */
	public function cancelApplyByPlatform($assoSerial, $amt) {
		$paramArray = array(
			'amt' => (string)$amt,
			'assoSerial' => (string)$assoSerial,
		);
		$data = self::$request->buildAjaxRequestForm($this->getTransInput(array(
			'transCode' => $this->cancelApplyByPlatformNo,
			'notifyUrl' => $this->params['cancelApplyByPlatformNotifyUrl'],
			'returnUrl' => $this->params['cancelApplyByPlatformReturnUrl'],
                        'orderId' => $this->generateOrderId(self::CANCEL_RERURN),
		)), $paramArray, $this->requestType.$this->params['gateway'].$this->params['cancelApplyByPlatform'].'json');
		$data = CJSON::decode($data);
		if (isset($data['retCode']) && isset($data['context']) && $data['retCode'] == $this->successReturnCode) {
			$data = $this->decryptContent($data['context']);
			if ($this->validateSign($data)) {
				return CJSON::decode($data['body']);
			}
		}
		return $data;
	}
	//------------------------------------业务相关接口结束------------------------------------
	
	/**
	 * 重新加载sdk证书
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月2日
	 */
	public function reloadSDK() {
		return self::$request->reloadSadk();
	}
	
	/**
	 * 获取银行编号
	 * @param int $bankNo 银行编号
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月15日
	 */
	public function getBankNo($bankNo = '') {
		$banks = array(
			'00' => array('bankName' => '民生银行', 'logo' => ''),
			'01' => array('bankName' => '工商银行', 'logo' => ''),
			'02' => array('bankName' => '中国银行', 'logo' => ''),
			'03' => array('bankName' => '建设银行', 'logo' => ''),
			'04' => array('bankName' => '农业银行', 'logo' => ''),
			'05' => array('bankName' => '交通银行', 'logo' => ''),
			'06' => array('bankName' => '招商银行', 'logo' => ''),
			'07' => array('bankName' => '兴业银行', 'logo' => ''),
			'08' => array('bankName' => '中信银行', 'logo' => ''),
			'09' => array('bankName' => '广大银行', 'logo' => ''),
			'10' => array('bankName' => '平安银行', 'logo' => ''),
			'11' => array('bankName' => '华夏银行', 'logo' => ''),
			'12' => array('bankName' => '邮储银行', 'logo' => ''),
			'13' => array('bankName' => '北京银行', 'logo' => ''),
			'14' => array('bankName' => '广发银行', 'logo' => ''),
			'15' => array('bankName' => '浦发银行', 'logo' => ''),
			'16' => array('bankName' => '浙商银行', 'logo' => ''),
			'17' => array('bankName' => '徽商银行', 'logo' => ''),
			'19' => array('bankName' => '江苏银行', 'logo' => ''),
			'20' => array('bankName' => '上海银行', 'logo' => ''),
			'21' => array('bankName' => '南京银行', 'logo' => ''),
			'22' => array('bankName' => '杭州银行', 'logo' => ''),
			'23' => array('bankName' => '苏州银行', 'logo' => ''),
			'24' => array('bankName' => '宁波银行', 'logo' => ''),
			'25' => array('bankName' => '温州银行', 'logo' => ''),
			'26' => array('bankName' => '台州银行', 'logo' => ''),
			'27' => array('bankName' => '包商银行', 'logo' => ''),
			'28' => array('bankName' => '哈尔滨银行', 'logo' => ''),
			'29' => array('bankName' => '渤海银行', 'logo' => ''),
			'30' => array('bankName' => '东亚银行', 'logo' => ''),
			'31' => array('bankName' => '上海农商行', 'logo' => ''),
			'32' => array('bankName' => '北京农商行', 'logo' => ''),
		);
		return isset($banks[$bankNo]) ? $banks[$bankNo] : $banks; 
	}

	/**
	 *  解密民生银行返回数据
	 * @param string $cipherText 密文
	 * @return mixed
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月26日
	 */
	public function decryptContent($cipherText) {
		return CJSON::decode(self::$request->sadkDecrypt($cipherText));
	}
        
        /**
         * 加密数据
         * @param array $transArr 通用数组
         * @param array $paramArray 业务数组
         * @return type
         * @author dean
         */
        public function encryptionContent($transArr, $paramArray) {
                $transInput = $this->getTransInput($transArr);
                return self::$request->generateCipher($transInput, $paramArray);
        }
        
        /**
         * 生成签名
         * @param array $transInput 通用数组
         * @param array $paramArray 业务数组
         * @return type
         * @author dean
         */
        public function setSign($transInput, $paramArray) {
            $bodyArray = array('transInput'=>$transInput);
            while (list ($key, $val) = each($paramArray)) {
                    $bodyArray[$key] = $val;
            }
            $signBody = json_encode($bodyArray, JSON_UNESCAPED_SLASHES);
            $sign = sadkSign($signBody);
            return $sign;
        }
	
	/**
	 * 验证签名是否有效
	 * @param string $sign
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月26日
	 */
	public function validateSign($cipherText) {
                $context = CJSON::decode($cipherText['body']);
                Yii::log("回调参数：".getDump($context), CLogger::LEVEL_PROFILE, 'msbank');
		return self::$request->sadkVerify($cipherText['body'], $cipherText['sign']);
	}
	
	/**
	 * 获取请求参数
	 * @param array $data
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月14日
	 */
	private function getTransInput($data = array()) {
		$param = param('msbank');
		$_data = array(
			'version' => '01',
			'orderId' => '',
			'secuNo' => (string)$param['secuNo'],
			'transCode' => '',
			'usrId' => '',
			'fundAcc' => $param['account'],
			'priDomain' => '',
			'notifyUrl' => '',
			'returnUrl' => '',
			'transDate' => date('Ymd'),
			'transTime' => date('His'),
			'remark' => '',
			'reserve1' => '',
			'reserve2' => '',
 			'channel' => $this->channel,
// 			'branchNo' => '',
// 			'operNo' => '',
		);
		return CMap::mergeArray($_data, $data);
	}

	/**
	 * 生成16位订单编号
	 * @return mixed
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年10月29日
	 */
	public function generateOrderId($type) {
		$types = array(
			self::CREATE_ACCOUNT_TYPE => 'CA',
			self::BIND_ACCOUNT_TYPE => 'BA',
			self::RECHARGE_ONLINE => 'RO',
			self::CLIENT_WITHDRAW => 'WC',
			self::TRANSFER_CLIENT => 'TC',
			self::TRANSFER_PLATFORM => 'TP',
			self::UNBIND_ACCOUNT => 'UA',
			self::PAY_SERVICE => 'PS',
			self::FREEZE_FUND => 'FF',
                        self::CANCEL_ACCOUNT_TYPE => 'XH',
                        self::CANCEL_RERURN => 'CR'
		);	
		$orderId = str_replace('.', '', microtime(true));
		$orderId = isset($types[$type]) ? $types[$type].str_pad($orderId, 14, '0', STR_PAD_RIGHT) : '';
		return $orderId;
	}

	/**
	 * 验证返回请求数据是否成功
	 * @param array $context 接口返回数据
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月10日
	 */
	public function validateReturnDataIsSuccess($context) {
		if (isset($context['transOutput']) && isset($context['transOutput']['code']) && $context['transOutput']['code'] == $this->successReturnCode) {
			return true;
		}
		return false;
	}
}