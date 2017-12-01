<?php

/**
 * 用户消息模块控制器
 * @author zhangye
 * @time 2017年11月23日11:35:45
 */
class InfomationController extends Controller {

    public function init() {
        parent::init();
        if (!user()->getId()) {
            $this->redirect("/index/index");
        }
        if (!User::checkFirst()) {
            $this->redirect("/manage/declare");
        }
    }

    /**
     * 用户消息模块
     * @time 2017年11月20日09:56:54
     */
    public function actionList() {
        $model = new InfomationForm();
        $model->page = request('page', 1);
        $model->size = 20;
        $data = $model->search();
        $vo = $data['datas'];
        $pager = $data['pager'];
        $this->render('newsList', compact('vo', 'pager'));
    }

    /**
     * 信息详情
     * @time 2017年11月20日15:24:42
     */
    public function actionDetail() {
        $id = request('id');
        $infomation = Infomation::model()->findByPk($id);
        Infomation::model()->updateByPk($id, array('isRead' => Infomation::ISREAD_YES));
        $this->render('newsDetail', compact("infomation"));
    }

    /**
     * 删除
     * @time 2017年11月20日17:21:31
     */
    public function actionDel() {
        $id = request('id');
        if ($id) {
            Infomation::model()->updateByPk($id, array('state' => Infomation::STATE_OFF));
            user()->setFlash('message', '删除成功');
            $this->redirect("/infomation/list");
        }
    }
    
    /**
     * 删除多个
     * @time 2017年11月20日17:21:31
     */
    public function actionDelAll() {
        $id = request('id');
        if (!empty($id)) {
            $idArr = explode(" ", $id);
            foreach ($idArr as $key => $value) {
                $value && Infomation::model()->updateByPk($value, array('state' => Infomation::STATE_OFF));
            }
            user()->setFlash('message', '删除成功');
        }
        $this->redirect("/infomation/list");
    }

    /**
     * 已读全部
     * @time 2017年11月20日17:21:42
     */
    public function actionReadAll() {
        $id = trim(request('id'));
        if (!empty($id)) {
            $idArr = explode(" ", $id);
            foreach ($idArr as $key => $value) {
                Infomation::model()->updateByPk($value, array('isRead' => Infomation::ISREAD_YES));
            }
        }
        $this->redirect("/infomation/list");
    }

    /**
     * 删除信息
     * @time 2017年11月23日16:07:51
     */
    public function actionDelOne(){
        $id = request('id');
        Infomation::model()->updateByPk($id, array('state' => Infomation::STATE_OFF));
        user()->setFlash('message', '删除成功');
        $this->redirect("/infomation/list");
    }
}
