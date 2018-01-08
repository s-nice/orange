<?php
/**
 * 管理设置模块
 * @author zhangpeng
 *
 */
namespace Company\Controller;
use Think\Log;
use Think\Controller;
import('Factory', LIB_ROOT_PATH . 'Classes/');

class TestController extends BaseController
{
	private $rows = 20;
	public function _initialize()
	{
		parent::_initialize();
	}

	/**
	 * 查看日志类
	 */
	public function log(){
		$logFile = C('LOG_PATH').date('y_m_d').'.log';
		echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($logFile);
		if(file_exists($logFile)){
			echo '文件存在';
		}else{
			echo '文件不存在';
		}
		echo file_get_contents($logFile);
	}
	
	/**
	 * 查看session信息类
	 */
	public function session(){
		$session = session(MODULE_NAME);
		echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($session,1);exit;
	}
	
}