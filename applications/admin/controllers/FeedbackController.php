<?php

class FeedbackController extends Controller {

    public function actionIndex() {
        $model = new FeedbackForm();
        $model->page = request('page', 1);
        $data = $model->search();
        $list = $data['datas'];
        $pager = $data['pager'];
        $userList = array();
        $companyList = array();
        if ($list) {
            $userIds = UtilsHelper::extractColumnFromArray($list, 'userId');
            $userList = User::model()->findByPks($userIds);
            $userList = $userList ? UtilsHelper::groupByKey($userList, 'id') : array();
            $companyList = Company::model()->findByUserIds($userIds);
            $companyList = $companyList ? UtilsHelper::groupByKey($companyList, 'userId') : array();
        }
        $this->render('index', compact('list', 'pager', 'userList', 'companyList'));
    }

}
