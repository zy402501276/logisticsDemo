<?php
/**
 * 地址逻辑service层
 * @author zhangye
 * @time 2017年11月1日19:51:003
 */
class UserService extends AppService {
    private static $_instance = null; //声明一个实例来进行统一访问

    private function __construct(){}  //防止初始化

    private function __clone(){}  //防止克隆

    //内部产生一个实例
    public static function getInstance(){
        if(is_null(SELF::$_instance) || !isset(SELF::$_instance)){
            SELF::$_instance = new SELF();
        }
        return SELF::$_instance;
    }

    /**
     * 新增用户信息
     * @time 2017年11月15日14:44:08
     * @param $request array
     * @return array
     */
    public function editUser($request,$model){
        $tranSaction = Yii::app()->db->beginTranSaction();
        try{
            $data = $request['UserForm'];
            if(!empty($data['email'])){
                $model->email = $data['email'];
            }
            if(!empty($data['mobile'])){
                $model->mobile = $data['mobile'];
            }
            $model->scenario = 'add';
            if($model->validate()){
                $model->save();
            }else{
                throw new Exception($model->getFirstError());
            }
            $tranSaction->commit();
            return ['state' => 1 ,'message'=>'修改成功'];
        }catch (Exception $e){
            $tranSaction->rollBack();
            return ['state' => 0 ,'message'=>$e->getMessage()];
        }
    }

    /**
     * 获取用户中心信息
     * @time 2017年11月20日14:53:24
     */
    public function getUserInfo($id){
        $keysArr = array(
            'id' => $id,
        );
        $url = US_API."/api/getUserInfo?v=1";
        $res = $this->post($url,$keysArr);
        return $res;
    }
}