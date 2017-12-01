<?php

class UserAgentHelper {

    /**
     * 获取用户代理信息
     */
    public static function getUserAgent() {
        $ua = array(
            'deviceNo' => '',
            'deviceType' => '',
            'deviceName' => '',
            'deviceModel' => '',
            'operatingSystem' => '',
            'ip' => $_SERVER["REMOTE_ADDR"]
        );
        $agent = $_SERVER['HTTP_USER_AGENT'];
//        $browserArr = array('MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera', '360SE', 'MicroMessenger', 'QQBrowser', 'QQ', 'UCBrowser', 'Weibo');
//        foreach ($browserArr as $b) {
//            if (preg_match('/' . $b . '/i', $agent)) {
//                $ua['browserName'] = $b;
//                if (in_array($b, array('MSIE'))) {
//                    $ua['browserVersion'] = self::getBrowserVersion($agent, $b, ' ');
//                } else {
//                    $ua['browserVersion'] = self::getBrowserVersion($agent, $b);
//                }
//                break;
//            }
//        }

        $osArr = array(
            'Windows NT 5.1' => 'Windows XP',
            'Windows NT 5.2' => 'Windows XP',
            'Windows NT 6.1' => 'Windows 7',
            'Windows NT 6.2' => 'Windows 8',
            'Windows NT 6.3' => 'Windows 8.1',
            'Windows NT 6.4' => 'Windows 10',
            'Windows NT 10.' => 'Windows 10',
            'iPhone OS' => 'IOS',
            'Mac OS' => 'Mac OS',
            'Android' => 'Android'
        );

        foreach ($osArr as $osk => $os) {
            if (preg_match('/' . $osk . '/i', $agent)) {
                $ua['operatingSystem'] = $os;
                if ($osk == 'iPhone OS') {
                    $ua['deviceName'] = 'iPhone';
                }
                if ($osk == 'Android') {
                    $ua['deviceName'] = 'android';
                }
                break;
            }
        }

        if (preg_match('/Mobile/i', $agent)) {
            if (preg_match('/pad/i', $agent)) {
                $ua['equipmentType'] = OperationLog::EQUIPMENTTYPE_PAD;
            } else {
                $ua['equipmentType'] = OperationLog::EQUIPMENTTYPE_MOBILE;
            }
        } else {
            $ua['equipmentType'] = OperationLog::EQUIPMENTTYPE_PC;
            $ua['deviceName'] = 'PC';
        }

        return $ua;
    }


}
