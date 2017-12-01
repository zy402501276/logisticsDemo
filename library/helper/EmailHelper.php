<?php

/**
 * 发送邮件帮助类
 */
class EmailHelper {

    /**
     * 公司名
     */
    public static $sign = '开门通行证';
    private static $email = null;

    /**
     * 注册验证码获取
     * @param type $email
     * @param type $code 验证码
     */
    public static function sendRegisterCode($email, $code) {
        $title = self::$sign . "注册验证码获取";
        $message = '<li>尊敬的用户:感谢您的注册，您的验证码为<font color="red">' . $code . '</font>，若非本人操作请忽略</li>';
        $message .= '<li>本邮件由系统发送，请勿回复！</li>';
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 登录验证码获取
     * @param type $email
     * @param type $code 验证码
     */
    public static function sendLoginCode($email,$username, $code) {
        $title = self::$sign . "登录验证码获取";
        $message = '<li>尊敬的'. $username .',感谢您的登录，您的验证码为<font color="red">' . $code . '</font>，若非本人操作请忽略</li>';
        $message .= '<li>本邮件由系统发送，请勿回复！</li>';
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 发送重置密码验证码
     * @param type $email 邮箱
     * @param type $code 验证码
     * @param type $userName 用户名
     * @author dean
     */
    public static function sendResetPwdVerifyCode($email,$username, $code) {
        $title = self::$sign . "会员修改密码验证";
        $message = '<li>尊敬的'. $username .',您正在申请修改账户密码，本次操作验证码为：<font color="red">' . $code . '</font>，十分钟内有效。</li>';
        $message .= '<li>若非本人操作，请留意账户安全。</li>';
        $content = self::setEmailContent($message);
        self::sendEmail($email, $title, $content);
    }

    /**
     * 注册成功提醒
     * @param type $email
     * @param type $username
     * @param type $telephone 客服电话
     * @param type $url 首页
     */
    public static function sendRegisterSucc($email, $username, $telephone = '0755-8386-7266', $url = SHOP_URL) {
        $title = '欢迎成为' . self::$sign . '会员';
        $message = '<li>尊敬的' . $username . '，恭喜您成为我们的会员!点击访问<font color="#08a8ff">' . $url . '</font></li>';
//        $message .= '<li>恭喜您成为我们的会员!点击访问<font color="#08a8ff">' . $url . '</font></li>';
        $telephone && $message .= "<li>若有疑问请致电：<font color='#08a8ff'>{$telephone}</font>，感谢您的支持。</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 敏感操作身份验证
     * @param type $email 邮箱
     * @param type $username 用户名
     * @param type $code 验证码
     */
    public static function sendAuthentication($email, $username, $code) {
        $title = self::$sign . "身份验证码获取";
        $message = '<li>尊敬的' . $username . '，您正在进行身份验证，验证码为<font color="red">' . $code . '</font>，若非本人操作请忽略</li>';
//        $message .= '<li>您正在进行身份验证，验证码为<font color="red">' . $code . '</font>，若非本人操作请忽略</li>';
        $message .= '<li>本邮件由系统发送，请勿回复！</li>';
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 异地登录提醒
     * @param type $email
     * @param type $username
     * @param type $address 登录地址
     * @param type $ip 登录ip
     * @param type $url 修改密码链接
     * @param type $telephone 客服电话
     */
    public static function sendRemoteLogin($email, $username, $address, $ip, $url, $telephone = '0755-8386-7266') {
        $title = self::$sign . '异地登录提醒';
        $message = '<li>尊敬的' . $username . '，我们识别到您在{$address}登录，登录IP：{$ip}，若非本人操作，请及时修改密码<font color="#08a8ff">{$url}</font>。</li>';
//        $message .= "<li>我们识别到您在{$address}登录，登录IP：{$ip}，若非本人操作，请及时修改密码<font color='#08a8ff'>{$url}</font>。";
        $telephone && $message .= "<li>若有疑问请致电：<font color='#08a8ff'>{$telephone}</font>，感谢您的支持。</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 绑定邮箱成功提醒
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendBindMailbox($email, $username) {
        $title = self::$sign . '邮箱绑定成功提醒';
        $message = '<li>尊敬的' . $username . '，您的邮箱已成功绑定开门账户中心。本邮件由系统发送，请勿回复！</li>';
//        $message .= "<li>您的邮箱已成功绑定开门账户中心。本邮件由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 用户设置密保问题成功提醒
     * @param type $email 邮箱
     * @param type $username 用户名
     * @param type $telephone 客服电话
     */
    public static function sendSetSecurity($email, $username, $telephone = '0755-8386-7266') {
        $title = self::$sign . '用户设置密保问题成功';
        $message = '<li>尊敬的' . $username . '，您的密保问题已设置成功，请您牢记密保答案。若有疑问，请致电：{$telephone}</li>';
//        $message .= "<li>您的密保问题已设置成功，请您牢记密保答案。若有疑问，请致电：{$telephone} </li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title, $content);
    }

    /**
     * 用户未通过个人身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendIdentityNoPass($email, $username) {
        $title = self::$sign . '用户未通过个人身份认证';
        $message = '<li>尊敬的' . $username . '，很遗憾您的个人身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>很遗憾您的个人身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title, $content);
    }

    /**
     * 用户通过个人身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendIdentityPass($email, $username) {
        $title = self::$sign . '用户通过个人身份认证';
        $message = '<li>尊敬的' . $username . '，恭喜您！您的个人身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>恭喜您！您的个人身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email, $title,$content);
    }

    /**
     * 用户未通过企业身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendCompanyNoPass($email, $username) {
        $title = self::$sign . '用户未通过企业身份认证';
        $message = '<li>尊敬的' . $username . '，很遗憾您的企业身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>很遗憾您的企业身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title, $content);
    }

    /**
     * 用户通过企业身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendCompanyPass($email, $username) {
        $title = self::$sign . '用户通过企业身份认证';
        $message = '<li>尊敬的' . $username . '，恭喜您！您的企业身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>恭喜您！您的企业身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title,$content);
    }

    /**
     * 用户未通过个体户身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendEmployedNoPass($email, $username) {
        $title = self::$sign . '用户未通过个体户身份认证';
        $message = '<li>尊敬的' . $username . '，很遗憾您的个体户身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>很遗憾您的个体户身份认证信息未通过审核，请您及时修改认证信息后重新提交审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title,$content);
    }

    /**
     * 用户通过个体户身份认证审核
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendEmployedPass($email, $username) {
        $title = self::$sign . '用户通过个体户身份认证';
        $message = '<li>尊敬的' . $username . '，恭喜您！您的个体户身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>恭喜您！您的个体户身份认证信息已通过审核。本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title, $content);
    }
    
    /**
     * 管理员重置密码
     * @param type $email 邮箱
     * @param type $username 用户名
     */
    public static function sendRestPwd($email, $username,$pwd) {
        $title = self::$sign . '重置密码';
        $message = '<li>尊敬的' . $username . '，您已向后台申请重置密码，新密码为:'.$pwd.',请勿向他人泄漏，并尽快使用新密码登录修改！本邮箱由系统发送，请勿回复！</li>';
//        $message .= "<li>您已向后台申请重置密码，新密码为:".$pwd.",请勿向他人泄漏，并尽快使用新密码登录修改！本邮箱由系统发送，请勿回复！</li>";
        $content = self::setEmailContent($message);
        return self::sendEmail($email,$title, $content);
    }

    /**
     * 发送邮件
     * @param array or string $receiver  收件人邮箱
     * @param string $title 邮件标题
     * @param string $content 邮件内容
     * @param array $attachments 邮件附件, 文件路径
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年9月21日
     */
    public static function sendEmail($receiver, $title, $content, $attachments = array()) {
        self::initEmail();
        // self::$email->AltBody = '';
        $body = $content;
        $subject = $title;
        self::$email->Subject = $subject;
        self::$email->MsgHTML($body);
        $receiver = is_array($receiver) ? $receiver : array($receiver);
        self::$email->clearAddresses();
        foreach ($receiver as $r) {
            self::$email->AddAddress($r, '');
        }
        if ($attachments) {
            foreach ($attachments as $a) {
                self::$email->AddAttachment($a);
            }
        }
        if (!self::$email->Send()) {
            return self::$email->ErrorInfo;
        } else {
            return 1;
        }
    }

    /**
     * 初始化邮件
     * @param string $sender 发件人昵称
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年9月21日
     */
    private static function initEmail($sender = '开门通行证') {
        if (self::$email) {
            return self::$email;
        }
        Yii::import('ext.push.phpmailer.PHPMailer');
        self::$email = new PHPMailer();
        $params = param('emailPushParam');
        self::$email->Username = $params['username'];
        self::$email->Password = $params['password'];
        self::$email->SetFrom($params['username'], $sender);
        // SMTP 服务器
        self::$email->Host = $params['smtp'];
        //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        self::$email->CharSet = "utf-8";
        // 设定使用SMTP服务
        self::$email->IsSMTP();
        // 启用SMTP调试功能, 1 = errors and messages, 2 = messages only
        // self::$email->SMTPDebug  = 1;
        // 启用 SMTP 验证功能
        self::$email->SMTPAuth = true;
        // 安全协议，可以注释掉
        self::$email->SMTPSecure = "tls"; //ssl
        // SMTP服务器的端口号
        self::$email->Port = 25;
        // self::$email->AddReplyTo($params['username'], $sender);
    }

    /**
     * 设置邮件内容页面
     * @param type $message 邮件内容
     * @return type
     * @author dean
     */
    private static function setEmailContent($message) {
         $html = '<!DOCTYPE html>';
        $html .= '<html>';
        $html .= '<head lang="en">';
        $html .= '<meta charset="UTF-8">';
        $html .= '<title>开门网邮箱验证</title>';
        $html .= '</head>';
        $html .= '<style>';
        $html .= 'body{margin:0;padding:0;background:#ddd}';
        $html .= 'li{list-style:none;line-height:25px;color: #666;font-size: 12px;}';
        $html .= 'li a{color: #0079ce;text-decoration: underline;}';
        $html .= 'li font{color: #0caa79;}';
        $html .= 'b{padding-left:5px;color:#00CC00;font-weight:700}';
        $html .= 'em{color:#FF0000;padding-left:5px;font-weight:700;font-style:normal}';
        $html .= 'p{margin: 0;font-size: 12px;color: #666;}';
        $html .= 'p a{text-decoration: underline;}';
        $html .= '</style>';
        $html .= '<body>';
        $html .= '<table cellspacing="0" cellpadding="0" border="0" width="730" style="margin:0 auto;color:#111;font:14px/26px \'微软雅黑\',\'宋体\',Arail; border:1px solid #f2f2f2">';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td style="height:46px;background-color:#0aaa78;padding:15px 0 15px 33px;">';
        $html .= '<a target="_blank" href="">';
        $html .= '<img width="441" height="62" style="border:none;" src="' . UtilsHelper::getUploadImages('/home/images/email_logo.png') . '">';
        $html .= '</a>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr style="background-color:#fff;">';
        $html .= '<td style="padding:0 43px">';
        $html .= '<div style="padding-top:10px">';
        $html .= '<ul style="padding-left: 0;">';
        $html .= $message;
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '<div style="background:#fff;padding:15px 0">';
        $html .= '<h2 style="font-size:18px;font-weight:700;margin:0 0 10px 0;">关于开门网</h2>';
        $html .= '<p style="font-size:13px;font-weight:300;margin:0 0 8px 0;line-height:25px;word-wrap:break-word;word-break:break-all">';
        $html .= '公司成立于2014年6月24日，首轮融资1500万元，由28位PCB行业内的企业家 共同发起。开门网自成立起，一直秉持着“互联网+”的理念，致力于通过”互联网+”的方式重构PCB产业链，为处于PCB供应链各个环节的PCB企业提供 全方位的产品在线交易服务、生产经营管理服务、品牌公关营销服务、金融服务、人力资源服务等，助力国内PCB产业链下的企业转型升级，提升行业竞争力，走 出国门，走向世界。';
        $html .= '</p>';
        $html .= '<p style="font-size:13px;font-weight:300;margin:0 0 8px 0;line-height:25px;word-wrap:break-word;word-break:break-all">';
        $html .= '目前，开门网（PCBDoor.com）电商平台已经成功上线运营，并依托该平台快速发展了约1400家PCB行业内的企业级会员，在行业内已经小有名气。依托现有平台，公司也正在积极探索基于交易平台的招标采购、拼客联盟、询价采购、物流服务、融资保理、人力银行等特色的增值服务，为解决PCB行业内 企业遇到的产品交易价格不透明、采购成本高、招人难、融资难等问题奠定了坚实的基础。';
        $html .= '</p>';
        $html .= '<div style="font-size:13px;font-weight:300;margin:0 0 8px 0;line-height:25px;word-wrap:break-word;word-break:break-all">';
        $html .= '<div><strong>企业文化：</strong>专业、创新、拥抱变化</div>';
        $html .= '<div><strong>企业核心价值观：</strong>诚信、共赢、以人为本</div>';
        $html .= '<div><strong>企业发展目标：</strong>构建一个专业化的工业互联网综合服务平台。集众人之智慧，集众人之所长，充分利用互联网的无国界和大数据技术，并辅以包括金融在内的配套服务，实现工业产业的重构和资源重组，打造集商品交易、物流仓储、金融等于一体的一流工业互联网服务平台。</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr style="background-color:#fff;">';
        $html .= '<td style="padding: 0 43px;">';
        $html .= '<div style="width: 100%;background: url(' . UtilsHelper::getUploadImages('/home/images/email_erweima.jpg') . ') no-repeat center;height: 208px;border: 1px solid #F2F2F2;">';
        $html .= '<div style="padding:50px 0 0 30px;">';
        $html .= '<h2 style="margin: 0;font-weight: normal;font-size: 24px;">扫描右侧<font style="color: #0caa79">二维码</font>，</h2>';
        $html .= '<p style="line-height: 20px;text-transform:uppercase;color: #999;">Scan the qr code on the right side,</p>';
        $html .= '<div style="font-size: 16px;color: #666;margin-top: 5px;">即可通过<font style="color: #0caa79">开门网微信服务号</font>，</div>';
        $html .= '<div style="font-size: 16px;color: #666;">更快捷的掌握<font style="color: #0caa79">行业动态、最新活动、特惠商品等一手资源</font>。</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr style="background-color:#fff;">';
        $html .= '<td style="padding:0 43px;padding-bottom: 50px;">';
        $html .= '<div style="font-size: 12px;color: #999;line-height: 25px;padding:18px 0;border-bottom: 1px solid #ededed;">';
        $html .= '本邮件是由开门网用户注册系统自动发出，请勿直接回复！';
        $html .= '如有任何问题可与我们联系，我们将尽快为您解答。';
        $html .= '</div>';
        $html .= '<div style="margin-top: 10px;">';
        $html .= '<p style="line-height:25px;color: #999;font-size: 12px;margin: 0;">如有任何问题，可以与我们联系，我们将尽快为你解答。</p>';
        $html .= '<p style="line-height:25px;color: #999;font-size: 12px;margin: 0;">电话：<a href="javascript:;">0755-83867266</a>，QQ:<a href="javascript:;">7123089622</a></p>';
        $html .= '</div>';
        $html .= '<div style="color: #666;float: right;margin-top: 20px;">为保证邮箱正常接收，请将<a href="javascript:;" style="text-decoration: underline;color: #1270b3;">info@pcbdoor.com</a>添加进你的通讯录</div>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</body>';
        $html .= '</html>';
        return $html;
//        $html = $message;
//        return $html;
    }

}
