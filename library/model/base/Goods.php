<?php
class Goods extends BaseModel {
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 是否为常用 - 是
     */
    CONST ISFREQUENCE_YES = 1;
    /**
     * 是否为常用 - 否
     */
    CONST ISFREQUENCE_NO = 0;

    /**
     * 是否有温度需求 - 是
     */
    CONST ISUSING_YES = 1;
    /**
     * 是否有温度需求 - 否
     */
    CONST ISUSING_NO = 0;
    /**
     * 是否为模板 - 是
     */
    CONST ISMODEL_YES = 1;
    /**
     * 是否为模板 - 否
     */
    CONST ISMODEL_NO = 0;




	public static function getTableName() {
		return 'Goods';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}


    /**
     * 获取货物数组
     * @time 2017年9月8日16:05:33
     * @author zhangye
     */
    public static function getGoodsArr($goods = '', $echoString = false){
        $criteria = new CDbCriteria();
        $criteria->compare('state',SELF::STATE_ON);
        $criteria->compare('userId',user()->getId());
        $criteria->compare('isModel',SELF::ISMODEL_YES);
        $criteria->select = 'id,goodsName';
        $array = self::model()->query($criteria, 'queryAll');
        if(!empty($array)){
            foreach ($array as $key => $value){
                $itemArr[$value['id']] = $value['goodsName'];
            }
            return parent::getState($itemArr, $goods, $echoString);
        }else{
            return array();
        }
    }

    /**
     * 返回货物体积
     * @time 2017年11月8日13:25:48
     * @param $goodsId int GOODS表主键id
     * @return string
     */
    public function getGoodsVolumn($goodsId){
        $info = SELF::model()->findByPK($goodsId);
        if(!empty($info)){
            return $info['goodsLength'].'X'.$info['goodsWidth'].'X'.$info['goodsHeight'];
        }
        return '';
    }
    /**
     * 返回货物温度
     * @time 2017年11月8日13:25:48
     * @param $goodsId int GOODS表主键id
     * @return string
     */
    public function getGoodsTemp($goodsId){
        $info = SELF::model()->findByPK($goodsId);
        if($info['isUsing'] == SELF::ISUSING_YES){
            return $info['lowestC'].'-'.$info['highestC'];
        }
        return '-';
    }

    /**
     * 获取用户常用货物
     * @time 2017年11月13日18:38:24
     * @author zhangye
     */
    public function getFreGoods($limit){
        $criteria = new CDbCriteria();
        $criteria->compare('userId',user()->getId());
        $criteria->compare('isFrequence',SELF::ISFREQUENCE_YES);
        if(!empty($limit)){
            $criteria->limit = $limit;
        }
        $criteria->compare('state',SELF::STATE_ON);
        return SELF::model()->query($criteria,'queryAll');
    }
}