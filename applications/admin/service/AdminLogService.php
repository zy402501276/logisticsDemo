<?php

class AdminLogService {
    /**
     * 添加操作日志
     * @param type $content 操作内容
     * @return boolean
     */
    public static function addOperateLog($id,$type,$content,$remark = '') {
        $model = new AdminLogBaseForm();
        $model->id = $id;
        $model->type = $type;
        $model->content = $content;
        $model->remark = $remark;
        $model->adminName = user()->getName();
        $model->createTime = date("Y-m-d H:i:s");
        $model->ip = Yii::app()->request->userHostAddress;
        if(!$model->validate()){
            return $model->getFirstError();
        }
        $model->save();
        return true;
    }
}
