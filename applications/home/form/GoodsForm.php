<?php
class GoodsForm extends GoodsBaseForm{
    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            array('goodsName,goodsWeight,goodsLength,goodsWidth,goodsHeight,palletSize','required','message' => '{attribute}不能为空','on' => 'add'),
            array('goodsName','checkGoodsName','on'=>'add'),
            array('goodsWeight,goodsLength,goodsWidth,goodsHeight','checkAll','on'=>'add'),
            array('state','default','value' => Goods::STATE_ON),
            array('isFrequence','default','value' => Goods::ISFREQUENCE_NO),
            array('isModel','default','value' => Goods::ISMODEL_NO),
            array('isUsing','default','value' => Goods::ISUSING_NO),
            array('createTime,updateTime','default','value' => date('Y-m-d H:i:s')),
        );
        return CMap::mergeArray($childRules,$rules);
    }

    /**
     * 验证单商品体积长,宽，高  重量  价格
     */
    public function checkAll($attribute, $params) {
        $reg = '/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/';
        if (preg_match($reg, $this->{$attribute})) {
            return true;
        } else {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . '必须是大于0的数');
            return false;
        }
    }

    /**
     * 验证货物名称
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function checkGoodsName($attribute,$params){
        if (!$this->$attribute) {
            return true;
        }
        if (preg_match('/[^0-9a-zA-Z一-龥]/u', $this->$attribute)) {
            $this->addError($attribute, '货物名称不能有特殊符号');
        }
        return true;
    }


    public function search() {
        $model = new Goods();
        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
            if(!empty($this->goodsName)){
                $this->criteria->compare('goodsName',$this->goodsName,true);
            }
            $this->criteria->compare('userId',user()->getId());
            $this->criteria->compare('state',Goods::STATE_ON);
            $this->criteria->limit = $this->size;
            $this->criteria->offset = $model->getLimitOffset($this->page, $this->size);
        }
        $datas = $model->query(array(
            'list' => $this->criteria,
            'count' => 'SELECT FOUND_ROWS()'
        ), array(
            'list' => 'queryAll',
            'count' => 'queryScalar'
        ));
        $pager = new CPagination($datas['count']);
        $pager->setPageSize($this->size);

        return array('datas' => $datas['list'], 'pager' => $pager);
    }
}

