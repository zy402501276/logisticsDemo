<?php
Yii::setPathOfAlias('Pheanstalk', Yii::getPathOfAlias('ext.queue.pheanstalk'));
use Pheanstalk\Pheanstalk;
use Pheanstalk\PheanstalkInterface;

/**
 * 消息帮助类
 * @author shezz
 */
class QueenHelper {
        
	private static $beansTalks = null;	//BeansTalkd客户端, 需要依赖服务器端
	CONST TUBE_QUEEN_MESSAGE = 'messageQueen';
        /**
	 * 队列发送优先级, 0为最高, 4294967295为最低
	 */
	CONST PRIORITY_NOW = 0;
	/**
	 * 手机短信消息类型
	 */
	CONST MESSAGE_TYPE_MOBILE_MESSAGE = 1;
	/**
	 * 邮件消息类型 
	 */
	CONST MESSAGE_TYPE_EMAIL_MESSAGE = 2;
        /**
         * 超时任务队列
         */
        CONST MESSAGE_TYPE_TASK = 3;
    /**
     * 商品推送队列
     */
    CONST MESSAGE_TYPE_GOODS_MESSAGE = 4;
    /**
     * 新闻推送队列
     */
    CONST MESSAGE_TYPE_NEWS_MESSAGE = 5;
    /**
     * 解锁用户
     */
    CONST MESSAGE_TYPE_BUYER_LOCKING = 6;
	/**
	 * 获取beansTalks对象
	 * @return \Pheanstalk\Pheanstalk
	 *
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月6日
	 */
	private static function getBeansTalks() {
		$beanTalks = param('beanTalks');
		if (self::$beansTalks) {
			return self::$beansTalks;
		}
		self::$beansTalks = new Pheanstalk($beanTalks['localhost'], $beanTalks['port']);
		return self::$beansTalks;
	}

	/**
	 * 将发送的消息写入消息队列
	 * @param int $messageType 发送消息类型, 见类属性定义
	 * @param array $messageContent  发送消息数据
	 *   手机短信数组格式: array(
	 *   	'mobiles' => array(18664915258),
	 *   	'content' => '这是一条测试心细',
	 *   	'sendTime' => '2015-09-09 23:00:00', //发送时间, 如果为空则为立即发送
	 *   )
	 *   发送邮件数组格式: array(
	 *   	'receiver' => array('250121244@qq.com'),
	 *   	'title' => '邮件标题',
	 *   	'content' => '邮箱内容',
	 *   	'attachments' => array('附件地址'),
	 *   )
	 *   
	 * @param int $priority 优先级 0 -> 4294967295 之间
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月25日
	 */
	public static function sendMessage($messageType, $messageContent, $priority = PheanstalkInterface::DEFAULT_PRIORITY) {
		$data = array(
			'type' =>$messageType,
			'content' => $messageContent
		);
		return self::enQueen(self::TUBE_QUEEN_MESSAGE, $data, $priority);
	}
	
	/**
	 * 入队
	 * @param string $tube 队列名称
	 * @param array $element 队列数据对象
	 * @param int $priority 优先级 0 -> 4294967295 之间
	 *
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月6日
	 */
	public static function enQueen($tube, $element, $priority = PheanstalkInterface::DEFAULT_PRIORITY) {
		$element = is_array($element) ? serialize($element) : $element;
		return self::getBeansTalks()->putInTube($tube, $element, $priority);
	}
	
	/**
	 * 出队
	 * @param string $tube 队列名称
	 * @param int $timeout 等待时间, 如果timeout为0, 则对空时直接返回, 反之则在时间内等待元素入队, 如果等待时间内仍然没有元素入队, 则结束
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月6日
	 */
	public static function deQueen($tube, $timeout = null) {
		$job = self::getBeansTalks()->reserveFromTube($tube, $timeout);
		if (empty($job)) {
			return false;
		}
		$data = $job->getData();
		self::getBeansTalks()->delete($job);
		return $data;
	}
}