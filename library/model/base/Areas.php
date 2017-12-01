<?php
class Areas extends BaseModel {
	/**
	 * 省级
	 */
	CONST DEEP_PROVINCE = 1;
	/**
	 * 市级
	 */
	CONST DEEP_CITY = 2;
	/**
	 * 区级
	 */
	CONST DEEP_AREA = 3;
	/**
	 * 街道级
	 */
	CONST DEEP_STREET = 4;
	/**
	 * 地域急
	 */
	CONST DEEP_REGIONAL = 9;

	/**
	 * 有效
	 */
	CONST STATE_AVAIABLE = 1;
	/**
	 * 无效
	 */
	CONST STATE_DISABLED = 0;
    /**
     * 状态 -- 启用
     */
    const STATE_VALID = 1;

    /**
     * 状态 -- 弃用
     */
    const STATE_INVALID = 0;
	
	public static function getTableName() {
		return 'Areas';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function findAll($parentId = 0)
	{
		$sql = "select * from `".self::getTableName()."` where pId = {$parentId}";
		return $this->query($sql, "queryAll");
	}

	/**
	 * 根据父ID获取子地区列表
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月8日
	 */
	public static function getSelectByPid($pid = 0, $deep = '') {
		$data = self::model()->findByPidAndDeep($pid, $deep);
		return UtilsHelper::packKeyAndValueFromArray($data, 'aId', 'areaName');
	}

	/**
	 * 将地区数组数据打包成父子层级数据格式
	 * @param array $areas 地区数据列表
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年12月2日
	 */
	public static function packListForParentAndChildrens(Array $areas) {
		$data = array('province' => array(), 'city' => array());
		foreach ($areas as $a) {
			switch ($a['deep']) {
				case self::DEEP_PROVINCE:
					$data['province'][$a['aId']] = array();
					break;
				case self::DEEP_CITY:
					$data['city'][$a['aId']] = array();
					isset($data['province'][$a['pId']]) ? $data['province'][$a['pId']][] = $a['aId'] : $data['province'][$a['pId']] = array($a['aId']);
					break;
				case self::DEEP_AREA:
					isset($data['city'][$a['pId']]) ? $data['city'][$a['pId']][] = $a['aId'] : $data['city'][$a['pId']] = array($a['aId']);
					break;
			}
		}
		return $data;
	}
	
	/**
	 * 根据父ID查询列表
	 */
	public function findByPid($pid, $aState = Areas::STATE_AVAIABLE) {
		$criteria = new CDbCriteria();
		$criteria->compare('aState', $aState);
		$criteria->compare('pid', $pid);
		return $this->query($criteria, 'queryAll');
	}

	/**
	 * 根据地区等级编号查询地区列表
	 * @param int $deep
	 * @param int $aState
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月30日
	 */
	public function findByDeep($deep, $aState = Areas::STATE_AVAIABLE, $cache = true, $expireTime = 3600) {
		$criteria = new CDbCriteria();
		$criteria->compare('deep', $deep);
		$criteria->compare('aState', $aState);
		return $this->query($criteria, 'queryAll', $cache, $expireTime);
	}

	/**
	 * 根据父ID和地区层级编号查询地区列表
	 * @param array or int  $pid 父ID
	 * @param int $deep 层级编号
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年12月2日
	 */
	public function findByPidAndDeep($pid, $deep) {
		$criteria = new CDbCriteria();
		$criteria->compare('pId', $pid);
		if ($deep) {
			$criteria->compare('deep', $deep);
		}
                $criteria->compare('aState', Areas::STATE_AVAIABLE);
		return $this->query($criteria, 'queryAll');
	}

	/**
	 * 根据地区ID和地区层级获取数据列表
	 * @param int $pk 主键ID
	 * @param int $deep 地区层级
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年12月3日
	 */
	public function findByPkAndDeep($pk, $deep) {
		$criteria = new CDbCriteria();
		$criteria->compare('aId', $pk);
		if ($deep) {
			$criteria->compare('deep', $deep);
		}
		return $this->query($criteria, 'queryAll');
	}
        
        /**
         * 根据地区名称获取详情
         * @param type $areaName 地区名称
         * @return type
         */
        public function findInfoByAreaName($areaName , $deep = 0) {
                $sql = "SELECT * FROM `".self::getTableName()."` WHERE `areaName` = '{$areaName}'";
                if($deep){
                    $sql .= " and deep = {$deep}";
                }
                return $this->query($sql, "queryRow");
        }
        
        public function findAllByState($state = Areas::STATE_AVAIABLE) {
            $criteria = new CDbCriteria();
            $criteria->compare('aState', $state);
            return $this->query($criteria, 'queryAll');
        }
    /**
     * 根据省市区id获取全称
     * @param type $provinceId
     * @param type $cityId
     * @param type $areaId
     * @return string
     */
    public function getAreaName($provinceId, $cityId, $areaId){
        $data = $this->findByPks(array($provinceId, $cityId, $areaId));
        if(!$data || count($data) < 3){
            //return '未知';
            return '';
        }
        $address = '';
//        foreach($data as $d){
//            $address .= "-".$d['areaName'];
//        }
//        $address = substr($address,1);
        foreach($data as $d){
            $address .= " ".$d['areaName'];
        }
        $address = substr($address,1);
        return $address;
    }
    /**
     * 所有省份
     * @param type $pId
     * @param type $deep
     * @param type $regionalId
     * @return type
     */
    public function findProvince($pId = 0, $deep = 1, $regionalId = 0) {
        $criteria = new CDbCriteria();
        $criteria->compare('pId', $pId);
        $criteria->compare('deep', $deep);
        $criteria->addNotInCondition('regionalId', array($regionalId));
        $criteria->compare('aState', self::STATE_VALID);
        $criteria->order = 'areaInitial asc';
        return self::model()->query($criteria, 'queryAll');
    }

    public function findAllByParentId($parentId) {
        $sql = "SELECT * FROM `" . self::getTableName() . "` WHERE `pId` = '{$parentId}' AND  `aState` = " . self::STATE_VALID;
        return $this->query($sql, "queryAll");
    }
    /**
     * 获取省份
     * @param type $pId
     * @return type
     */
    public function getProvince($pId = 0) {
        $criteria = new CDbCriteria();
        $criteria->compare('pId', $pId);
        $res =  self::model()->query($criteria, 'queryRow');
        return $res['areaName'];
    }

    /**
     * 所有省份 - select标签
     * @time 2017年10月24日11:24:41
     * @param type $pId
     * @param type $deep
     * @param type $regionalId
     * @return type
     */
    public static function findProvinceSelect($pId = 0, $deep = 1, $regionalId = 0) {
        $criteria = new CDbCriteria();
        $criteria->compare('pId', $pId);
        $criteria->compare('deep', $deep);
        $criteria->addNotInCondition('regionalId', array($regionalId));
        $criteria->compare('aState', self::STATE_VALID);
        $criteria->order = 'areaInitial asc';
        $result =  self::model()->query($criteria, 'queryAll');
        $proviceArr = array();
        foreach ($result as $key => $value){
                $proviceArr[$value['aId']] = $value['areaName'];
        }
        return $proviceArr;
    }

    /**
 * 根据地区等级编号查询地区列表
 * @param int $deep
 * @param string $areaInitial
 * @author zhangye
 * @time 2017年10月26日10:09:43
 */
    public function findByDeepEx($deep,$areaInitial, $aState = Areas::STATE_AVAIABLE, $cache = true, $expireTime = 3600) {
        $criteria = new CDbCriteria();
        $criteria->select = 'aId as areaId,areaName,areaInitial';
        $criteria->compare('deep', $deep);
        $criteria->compare('areaInitial', $areaInitial);
        $criteria->compare('aState', $aState);
        $criteria->order = 'areaInitial asc ,sort asc';
        return $this->query($criteria, 'queryAll', $cache, $expireTime);
    }

    /**
     * 根据地区等级编号查询地区列表
     * @param int $deep
     * @param string $areaInitial
     * @author zhangye
     * @time 2017年10月26日10:09:43
     */
    public function findByDeepAndroid($deep, $aState = Areas::STATE_AVAIABLE, $cache = true, $expireTime = 3600) {
        $criteria = new CDbCriteria();
        $criteria->select = 'aId as areaId,areaName,areaInitial';
        $criteria->compare('deep', $deep);
        $criteria->compare('aState', $aState);
        $criteria->order = 'areaInitial asc ,sort asc';
        return $this->query($criteria, 'queryAll', $cache, $expireTime);
    }

}