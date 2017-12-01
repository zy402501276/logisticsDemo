<?php
/**
 * model基类
 * @author shezz
 * @date 2014-8-11
 */
class BaseModel extends CModel {

	private $db = null;
	
	public function attributeNames(){}
	
	public static function model($className=__CLASS__) {
		return new $className;
	}

	public function __construct($db = '') {
		if (empty($db)) {
			$this->db = Yii::app()->db;
		} else {
			$this->db = Yii::app()->{$db};
		}
	}
	
	/**
	 * 获取表默认值
	 * 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年2月27日
	 */
	public function loadDefaultValues() {
		$builder = $this->db->getCommandBuilder();
		$schema = $builder->getSchema();
		$tableModel = $schema->getTable(get_class($this));
		$attributes = array();
		foreach ($tableModel->columns as $key => $values) {
			if (!is_null($values->defaultValue)) {
				$attributes[$key] = $values->defaultValue;
			}
		}
		return $attributes;
	}
	
	/**
	 * 开启事务
	 * @author shezz
	 * @date 2014-7-30
	 */
	public function beginTransaction() {
		$transaction = $this->db->beginTransaction();
		return $transaction;
	}

	/**
	 * 根据主键删除数据
	 * @param string $tableName 表名
	 * @param mixed $primaryValue 主键值    id 或者  array(ids)
	 * @param string $primaryKey 主键名
	 * @author shezz
	 * @date 2014-8-12
	 */
	public function deleteByPk($pk) {
		$tableName = get_class($this);
		$pkName = $this->getTablePk($tableName);
		if (!$pkName) {
			return false;
		}
		
		if( !is_array($pk) ) {
			$pk = array($pk);
		}
		$primaryValue = implode(',', $pk);
		$sql = "DELETE FROM `$tableName` WHERE $pkName IN($primaryValue)";
		
		return $this->query($sql, 'execute', false);
	}
	
	/**
	 * 根据主键获取数据
	 * @author shezz
	 * @date 2014-8-12
	 */
	public function findByPk($pk) {
		$tableName = get_class($this);
		$pkName = $this->getTablePk($tableName);
		if (!$pkName) {
			return false;
		}
		$sql = 'SELECT * FROM `'.$tableName.'` WHERE `'.$pkName.'` = "'.$pk.'"';
		return $this->query($sql, 'queryRow');
	}
	
	/**
	 * 根据主键数组获取数据
	 * @param array $pks
	 */
	public function findByPks($pks) {
		$tableName = get_class($this);
		$pkName = $this->getTablePk($tableName);
		if (!$pkName) {
			return false;
		}
		if (!is_array($pks)) {
			$pks = array($pks);
		}
		$pks = array_filter($pks);
		if (empty($pks)) {
			return array();
		}
		$sql = 'SELECT * FROM `'.$tableName.'` WHERE `'.$pkName.'` IN('.implode(',', $pks).')';
		return $this->query($sql, 'queryAll');
	}
	
	/**
	 * 根据主键更新记录
	 * @author shezz
	 * @date 2014-10-8
	 */
	public function updateByPk($pk, $data) {
		$pkName = $this->getTablePk(get_class($this));
		return $this->update($data, '`'.$pkName.'` IN('.(is_array($pk) ? implode(',', $pk) : $pk).')');
	}
	
	/**
	 * 新增记录
	 * @author shezz
	 * @date 2014-9-4
	 */
	public function save($data) {
		return $this->insert($data);
	}

	/**
	 * 批量插入数据
	 * @param array $data 插入的数据, 必须是二维数组
	 * @author shezz
	 * @date 2014-9-15
	 */
	public function batchSave($data) {
		$firstKey = key($data);
		if ( !is_array($data) ) {
			return false;
		}
		if ( !is_array($data[$firstKey]) ) {
			return false;
		}
		//处理sql
		$column = array();
		$values = array();
		foreach ($data[0] as $columnName => $v) {
			$column[] = '`'.$columnName.'`';
		}
		foreach ($data as $d) {
			$tmp = array();
			foreach ($d as $v) {
				$tmp[] = "'".$v."'";
			}
			$values[] = '('.implode(',', $tmp).')';
		}
		$sql = 'INSERT INTO `'.get_class($this).'`('.implode(',', $column).') VALUES'.implode(',', $values);
		return $this->query($sql, 'execute', false);
	}
	
	/**
	 * 写sql
	 * @author shezz
	 * @date 2014-10-13
	 */
	public function insert($data = array()) {
		$command = $this->db->createCommand();
		$command->insert(get_class($this), $data);
		
		//记录日志
		$this->addSqlLog($command->getText()."\n".CVarDumper::dumpAsString($data));
		return $this->db->lastInsertID;
	}
	
	/**
	 * 更新sql
	 * @author shezz
	 * @date 2014-10-13
	 */
	public function update($data = array(), $where = '') {
		$command = $this->db->createCommand();
		$rows = $command->update(get_class($this), $data, $where);
		
		//记录日志
		$this->addSqlLog($command->getText()."\n".CVarDumper::dumpAsString($data));
		return $rows;
	}
	
	/**
	 * 读sql
	 * @param string or array $sql	需要执行的SQL语句
	 * @param string or array 		$method SQL语句执行方法
	 * @param boolean $cache 		是否启用缓存
	 * @param integer $time			缓存时间 单位：秒
	 * 
	 * @return array
	 */
	public function query($sqls, $method, $cache = false, $time = 600) {
		if( !is_array($sqls) ) {
			$sqls = array($sqls);
			$method = array($method);
		}
		
		foreach ($sqls as &$s) {
			if ($s instanceof CDbCriteria) {
				$s = $this->getSqlFromCriteria($s);
			}
		}
		
		isset(Yii::app()->params['useCache']) ? $memcacheSwitch = Yii::app()->params['useCache'] : $memcacheSwitch = false;

		//缓存读取
		if ($cache && $memcacheSwitch) {
			$rs = $this->getCache($sqls);
			if( $rs ) {
				return $rs;
			}
		}

		//db读取
		$rs = array();
		foreach ($sqls as $key => $sql) {
			$rs[$key] = $this->getData($sql, $method[$key]);
		}

		//写入缓存
		if($cache && $memcacheSwitch) {
			$this->setCache($sqls, $rs, $time);
		}
		return count($rs) > 1 ? $rs : current($rs);
	}
	
	/**
	 * 获取分页offset数值
	 * @author shezz
	 * @date 2014-9-4
	 */
	public static function getLimitOffset($page, $size) {
		return max($page - 1, 0) * $size;
	}
	
	/**
	 * 获取状态
	 * @param array $data  定义的状态数组
	 * @param string $status 数组中对应的状态值
	 * @param boolean $returnString 是否强制输出字符串 
	 * @return 数组或者数组中的某一个元素
	 *  
	 * @descript 如果数组中对应的状态值存在, 则直接返回值, 如果不存在, 则直接返回整个定义的数组
	 */
	public static function getState(array $data, $status = '', $echoString = false) {
		if (isset($data[$status])) {
			return $data[$status];
		}
		if ($echoString) {
			return $status;
		}
		return $data;
	}
	
	
	
	/**
	 * 获取缓存的key
	 * @author shezz
	 * @date 2014-8-11
	 */
	private function getCacheKey($key) {
		if( is_array($key) ) {
			$keys = '';
			foreach($key as $k) {
				$keys .= $k;
			}
			$key = $keys;
		}
		if (empty($key)) {
			return false;
		}
		return 'sql_'.substr(md5($key),8,16);
	}
	
	/**
	 * 设置缓存
	 * @param string key  缓存键
	 * @param mixed data 缓存值
	 * @param int cacheTime 缓存时间
	 * @author shezz
	 * @date 2014-8-11
	 */
	private function setCache($key, $data, $cacheTime) {
		$key = $this->getCacheKey($key);
		if( is_array($data) && count($data) == 1 ) {
			$data = array_shift($data);
		}
		Yii::app()->cache->set($key, $data, $cacheTime);
	}
	
	/**
	 * 读取缓存
	 * @author shezz
	 * @date 2014-8-11
	 */
	private function getCache($key) {
		$key = $this->getCacheKey($key);
		return Yii::app()->cache->get($key);
	}
	
	/**
	 * 数据获取
	 * @param string $sql		SQL语句
	 * @param string $method	数据库操作方法
	 * @param boolean $cache	是否Cache
	 * @param integer $time		缓存时间
	 * @return array
	 */
	private function getData($sql, $method) {
		$this->addSqlLog($sql);
		$command = $this->db->createCommand($sql);
		$command->prepare();
		return $command->$method();
	}
	
	/**
	 * 获取一个表的主键
	 * @author shezz
	 * @date 2014-10-8
	 */
	private function getTablePk($tableName) {
		$builder = $this->db->getCommandBuilder();
		$schema = $builder->getSchema();
		$tableModel = $schema->getTable($tableName);
		
		if ($tableModel->primaryKey) {
			return $tableModel->primaryKey;
		} else {
			return false;
		}
	}

	/**
	 * 根据criteria对象生成sql查询语句
	 * @param CDBCriteria $criteria
	 * @author shezz
	 * @date 2014-10-23
	 */
	private function getSqlFromCriteria($criteria) {
		$command = $this->db->getSchema()->getCommandBuilder()->createFindCommand(get_class($this), $criteria);
		$keys = array_keys($criteria->params);
		$values = array_values($criteria->params);
		
		foreach ($values as $k => &$v) {
			$v = '"'.$v.'"';
		}
		krsort($keys);
		krsort($values);
		
		return str_replace($keys, $values, $command->getText());
	}
	
	/**
	 * 记录sql日志
	 * @author shezz
	 * @date 2014-10-8
	 */
	private function addSqlLog($info) {
		$log = isset(Yii::app()->params['sqlLog']) ? Yii::app()->params['sqlLog'] : false;
		if($log) {
			Yii::log($info, CLogger::LEVEL_PROFILE, 'sql');
		}
	}
}