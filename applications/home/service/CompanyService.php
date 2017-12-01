<?php

/**
 * 公司模块逻辑层
 * @time 2017年11月16日14:05:46
 * @author zhangye
 */
class CompanyService {

    private static $_instance = null; //声明一个实例来进行统一访问

    private function __construct() {
        
    }

//防止初始化

    private function __clone() {
        
    }

//防止克隆
    //内部产生一个实例
    public static function getInstance() {
        if (is_null(SELF::$_instance) || !isset(SELF::$_instance)) {
            SELF::$_instance = new SELF();
        }
        return SELF::$_instance;
    }

    /**
     * 修改公司信息
     * @time 2017年11月16日14:05:20
     */
    public function editCompany($model, $request) {
        $tranSaction = Yii::app()->db->beginTranSaction();
        try {
            $data = $request['CompanyForm'];
            if (!empty($data['provinceId']) && !empty($data['cityId']) && !empty($data['areaId'])) {
                $model->provinceId = $data['provinceId'];
                $model->cityId = $data['cityId'];
                $model->areaId = $data['areaId'];
                $model->adress = $data['adress'];
            }
            if (!empty($data['companyName'])) {
                $model->companyName = $data['companyName'];
            }
            if (!empty($data['companyShortName'])) {
                $model->companyShortName = $data['companyShortName'];
            }
            if (!empty($data['contactPhone'])) {
                $model->contactPhone = $data['contactPhone'];
            }
            if (!empty($data['contactName'])) {
                $model->contactName = $data['contactName'];
            }
            if (empty($model->cId)) {
                $model->userId = user()->getId();
            }
            $model->scenario = 'add';
            if ($model->validate()) {
                $model->save();
            } else {
                throw new Exception($model->getFirstError());
            }
            $tranSaction->commit();
            return ['state' => 1, 'message' => '修改成功'];
        } catch (Exception $e) {
            $tranSaction->rollBack();
            return ['state' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * 修改公司认证
     * @time 2017年11月16日15:45:51
     */
    public function editAuth($model, $request) {
        $tranSaction = Yii::app()->db->beginTranSaction();

        try {
            $data = $request['CompanyInfoForm'];

            if (!empty($data['orgNum'])) {
                $model->orgNum = $data['orgNum'];
            }
            if (!empty($data['companyUsername'])) {
                $model->companyUsername = $data['companyUsername'];
            }
            if (!empty($data['companyIdCard'])) {
                $model->companyIdCard = $data['companyIdCard'];
            }
            $company = Company::model()->findByUserId(user()->getId());
            if (!$company) {
                throw new Exception('请先填写公司基本信息');
            }
            if (empty($model->id)) {
                $model->cId = $company['cId'];
            }
            if ($model->validate()) {
                $model->save();
                Company::model()->updateByPk($company['cId'], array('isAuth' => Company::ISAUTH_ING));
            } else {
                throw new Exception($model->getFirstError());
            }
            $tranSaction->commit();
            return ['state' => 1, 'message' => '提交成功，请等待审核'];
        } catch (Exception $e) {
            $tranSaction->rollBack();
            return ['state' => 0, 'message' => $e->getMessage()];
        }
    }

}
