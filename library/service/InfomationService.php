<?php

class InfomationService {

    /**
     * 新增消息
     * @param type $userId 用户id
     * @param type $title 标题
     * @param type $content 内容
     * @param type $type 消息类型
     * @return type
     */
    public function add($userId, $title, $content, $type = Infomation::TYPE_SYSTEM) {
        $model = new InfomationBaseForm();
        $model->userId = $userId;
        $model->title = $title;
        $model->content = $content;
        $model->type = $type;
        $model->state = Infomation::STATE_ON;
        $model->createTime = now();
        $model->updateTime = now();
        $model->isRead = Infomation::ISREAD_NO;
        if ($model->validate()) {
            return $model->save();
        }
    }

}
