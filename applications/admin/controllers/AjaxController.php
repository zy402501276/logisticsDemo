<?php
class AjaxController extends CController {

    /**
     * 根据父ID获取子城市列表
     * @author shezz
     * @email zhangxz@pcbdoor.com
     * @date 2015年9月8日
     */
    public function actionGetChildArea() {
        $id = request('pid');
        $return = Areas::getSelectByPid($id);
        echo CJSON::encode($return);
        app()->end();
    }

    
}
    