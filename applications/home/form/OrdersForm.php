<?php

class OrdersForm extends OrdersBaseForm{
    /**
     * 时间范围-今天
     */
    CONST TIME_DAY = 1;
    /**
     * 时间范围-今天
     */
    CONST TIME_WEEK = 2;
    /**
     * 时间范围-今天
     */
    CONST TIME_MONTH = 3;

    public $startDay ;//装货日期
    public $startT;//装货时间
    public $endT;//完成时间
    public $delivertDay;//到达日期
    public $deliverT;//到达时间
    public $timeType; //时间范围
    public $dataReport = false;//数据报表

    public $searchType;//搜索方式



    public function search() {
        $model = new Orders();

        if (!$this->criteria) {
            $this->criteria = new CDbCriteria();
            $this->criteria->select = 'SQL_CALC_FOUND_ROWS *';
            $this->criteria->compare('userId',user()->getId());
            if(!empty($this->orderState)){
                $this->criteria->compare('orderState',$this->orderState);
            }
            if(!empty($this->searchType)){
                if($this->searchType == Orders::SEARCH_LATER){
                    $this->criteria->order = 'createTime desc';
                }
                if($this->searchType == Orders::SEARCH_FORMER){
                    $this->criteria->order = 'createTime asc';
                }
                if($this->searchType == Orders::SEARCH_COST){
                    $this->criteria->order = 'sumCost asc';
                }
            }
            if(!empty($this->startTime) && !empty($this->endTime)){
                $this->criteria->addBetweenCondition('endTime',date('Y-m-d H:i:s',strtotime($this->startTime)),date('Y-m-d H:i:s',strtotime($this->endTime)));
            }

            if(!empty($this->timeType)){
                switch ($this->timeType){
                    case SELF::TIME_DAY:
                        $beginTime = date('Y-m-d 00:00:00');
                        $endTime = date('Y-m-d 23:59:59');
                        break;
                    case SELF::TIME_WEEK:
                        $time = '1' == date('w') ? strtotime('Monday') : strtotime('last Monday');
                        $beginTime = date('Y-m-d 00:00:00', $time);
                        $endTime = date('Y-m-d 23:59:59', strtotime('Sunday', time()));
                        break;
                    case SELF::TIME_MONTH:
                        $beginTime = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', time()), '1', date('Y', time())));
                        $endTime = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', time()), date('t', time()), date('Y', time())));
                        break;
                }
                $this->criteria->addBetweenCondition('endTime',$beginTime,$endTime);
            }
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


    public function rules() {
        $rules = parent::rules();
        $childRules = array(
            //array('routerId,startTime,endTime,deliveryTime,orderNumber','message' => '{attribute}不能为空','on' => 'add'),
            array('sumWeight,sumVolumn','checkAll','on' => 'add'),
            array('state,orderState','default','value' => Orders::STATE_ON,'on'=>'add'),
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

}