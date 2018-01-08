<?php
namespace Classes;
/**
 * 缓存redis处理类
 * @author zhangpeng
 */
class CacheRedis{
	protected  static $redis = null;
	protected static $instance = null; //单例对象
	protected static $mysql = null;
	
	/**
	 * 获取redis单例对象
	 * @return \Redis
	 */
	public static function getRedis(){
		if(self::$redis === null){
			self::connect();
		}
		return self::$redis;
	}

	/**
	 * 获取redis单例对象
	 * @return \Redis
	 */
	public static function getMysql(){
		if(self::$mysql === null){
			self::connectDb();
		}
		return self::$mysql;
	}
	
	/**
	 * 获取缓存单例对象
	 * @return \Classes\CacheRedis
	 */
	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
			self::connect();
			self::connectDb();
		}
		return self::$instance;
	}
	
	/**
	 * 连接到redis数据库
	 */
	public static function connect(){
		if(!class_exists('Redis')){
			\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".' client redis extended not exists');
			return false;
		}else{
			self::$redis = new \Redis();
			self::$redis->connect(C('WX_REDIS_HOST'),C('WX_REDIS_PORT'));
			\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".''.var_export('Connect Redis '.self::$redis->ping(),true),'INFO');
			return true;
		}
	}
	
	/**
	 * 测试redis的连通性
	 */
	public static function ping(){
		$p = false;
		if(self::connect()){
			$p = self::$redis->ping() == '+PONG';
			self::$redis->close();
		}
		return $p;
	}

	/**
	 * 测试mysql的连通性
	 */
	public static function pingDb(){
		self::connectDb();
		if(self::$mysql == false) {
			$p = false;
		} else {
			$p = true;
		}
		self::closeDb(false,self::$mysql);
		return $p;
	}

	/**
	 * 设置字符串缓存
	 * @param unknown $key    键名 
	 * @param unknown $value  键值
	 * @param number $expire  有效期 单位秒
	 */
	public function set($key, $value,$expire=0){
		if($expire>0){
			return self::$redis->setex($key,$expire, $value);
		}else{
			return self::$redis->set($key, $value);
		}		
	}
	
	/**
	 * 获取字符串缓存
	 * @param unknown $key
	 */
	public function get($key){
		return self::$redis->get($key);
	}
	
	public function delete($key){
		return self::$redis->delete($key);
	}

	/**
	 * 得到一个key的有效期
	 * @param unknown $key
	 */
	public function ttl($key){
		return self::$redis->ttl();
	}
	
	/**
	 * （消息队列）发布消息到通道中
	 */
	public function publish($name,$value){
		return self::$redis->publish($name, $value);
	}
	
	/**
	 * （消息队列）从通道中获取消息
	 */
	public function subscribe($name, $callbackFn){
		return self::$redis->subscribe(array($name), $callbackFn);
	}
	
	public function callback($redis, $channerName, $message){
		echo $channerName."==>".$message.PHP_EOL;
	}

	/**
	 * 往队列里存入记录
	 */
	public function rPush($key, $value){
		return self::$redis->rPush($key, $value);
	}

	/**
	 * 取出队列中的记录
	 */
	public function lPop($key){
		return self::$redis->lPop($key);
	}

	/**
	 * 获取队列长度
	 */
	public function lLen($key){
		return self::$redis->lLen($key);
	}

	/**
	 * 关闭redis链接
	 */
	public function close(){
		return self::$redis->close();
	}

	/**
	 * 往队列中存入记录
	 */
	public static function insertList($name, $info = array()){
		self::connect();
		$flag = self::$redis->rPush($name,json_encode($info));
		//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(self::$redis->getKeys('*'));
		//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($name,$flag,self::$redis->lPop($name));
    	self::$redis->close();
	}

	/**
	 * 连接数据库
	 */
	public static function connectDb()
	{
		self::$mysql = mysql_connect(C('WX_REDIS_DB_HOST'), C('WX_REDIS_DB_USER'), C('WX_REDIS_DB_PASS'));
    	if (!self::$mysql) {
        	\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".''.var_export('Could not connect:'.mysql_error(),true),'INFO');
    	}
	}

	/**
	 * 插入数据库数据
	 */
	public function insertDb($link,$db,$sql)
	{
		mysql_select_db($db, $link);
	    $sql = rtrim($sql,",").";";
	    $res = mysql_query($sql);
	    if(!$res){
	    	\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".''.var_export('Could not insertDb:'.mysql_error(),true),'INFO');
	    }
	    return $res;
	}

	/**
	 * 释放连接
	 */
	public function closeDb($query,$link)
	{
		// 释放连接
		if (!is_bool($query)) {
			mysql_free_result($query);
		} else {
			\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".''.var_export('Could not freeResults:'.mysql_error(),true),'INFO');
		}
    	mysql_close($link);
	}
} 