<?php
namespace Model\DB;
use \Think\Model;
/**
 * 数据库切换例子
 * 利用TP的构造函数来切换连接数据库的配置文件,实现整个类文件连接指定的数据库
 * @author jiyl
 * 
 * 目前公共配置文件中公共数据库的配置信息,指向的是信息统计数据库，
 * 而企业后台和运营后台的各自的数据库配置信息，存在各自模块下的配置文件中，
 * 暂定名字分别是C('COMPANYDB')和C('APPADMINDB')
 * 
 * 	1.编写的类中只会应用到统计信息数据库时,tp的构造函数可以省略不写，数据库会默认指向信息统计数据库
 * 		类如：Model\Statistics\CardsStat
 *  2.编写的类中只会应用到企业后台(运营后台)数据库时，需要替换公共的统计信息数据库配置：
 *  	增加tp的构造函数,如下：
 *  	public function _initialize() {
			$this->connection = C('COMPANYDB');
			//$this->connection = C('APPADMINDB');
		}
 *  3.编写的类中只会应用到企业后台(运营后台)数据库时，需要替换公共的统计信息数据库配置：
 *  	增加tp的构造函数,如下：
 *  	public function _initialize() {
			$this->connection = C('COMPANYDB');
			//$this->connection = C('APPADMINDB');
		}
 *  4.编写的类中会同时应用到企业后台、运营后台、统计信息数据库时，根据应用次数的多少可以分为两种情况：
 *  	情况一：公共配置文件中的统计信息配置运用次数较多,tp构造函数省略不写,或不做任何处理
 *  	public function _initialize() {
			// null
		}
			-- 获取公共统计信息方法
			public function getdata(){
				$sql = 'select * from table';
				$statInfo = $this->query($sql);
			}
			-- 获取公共统计信息和企业后台(运营后台)信息方法
			public function getdata(){
				// 统计信息
				$sql = 'select * from table';
				$statInfo = $this->query($sql);
				// 企业后台（运营后台）信息
				$sql = 'select * from table';
	 			$this->db(1,'COMPANYDB');
	 			//$this->db(1,'APPADMINDB');
	 			$Info = $this->query($sql);
			}
			-- 同时获取公共统计信息、企业后台 、运营后台 三个数据库信息方法
			（注意：三个配置信息需要同时放到公共的配置文件中，目前结构没有）
			public function getdata(){
				// 统计信息
				$sql = 'select * from table';
				$statInfo = $this->query($sql);
				// 企业后台信息
				$sql = 'select * from table';
	 			$this->db(1,'COMPANYDB');
	 			$companyInfo = $this->query($sql);
	 			// 运营后台信息
				$sql = 'select * from table';
	 			$this->db(2,'APPADMINDB');
	 			$appadminInfo = $this->query($sql);
			}
 * 		情况二：企业后台(运营后台）数据库信息运用次数较多时，
 * 				tp构造函数来修改默认连接，但是切换回公共数据库配置时需要应用到另一个公共配置，暂定为C(EMPTYDB)
 *  	public function _initialize() {
			$this->connection = C('COMPANYDB');
			//$this->connection = C('APPADMINDB');
		}
			-- 获取企业后台(运营后台)信息方法
			public function getdata(){
				$sql = 'select * from table';
				$Info = $this->query($sql);
			}
			-- 获取企业后台(运营后台)信息和公共统计信息方法
			public function getdata(){
				// 企业后台（运营后台）信息
				$sql = 'select * from table';
	 			$Info = $this->query($sql);
	 			// 统计信息
	 			$this->db(1,'EMPTYDB');
				$sql = 'select * from table';
				$statInfo = $this->query($sql);
			}
			-- 同时获取企业后台 、运营后台、公共统计信息 三个数据库信息方法
			（注意：三个配置信息需要同时放到公共的配置文件中，目前结构没有）
			public function getdata(){
				// 企业后台信息
				$sql = 'select * from table';
	 			$companyInfo = $this->query($sql);
	 			// 公共统计信息
	 			$this->db(1,'EMPTYDB');
	 			$statInfo = $this->query($sql);
	 			// 运营后台信息
				$sql = 'select * from table';
	 			$this->db(2,'APPADMINDB');
	 			$appadminInfo = $this->query($sql);
			}
 */

class MoreDbTest extends Model
{
	// tp的构造函数
	public function _initialize() {
		$this->connection = C('APPADMINDB');
	}
     /**
      * 获得企业后台数据
      */
     public function getInfo()
     {
     	$sql = 'SELECT * FROM `account_basic` limit 5';
     	$info = $this->query($sql);
     	return array('info'=>$info);
	}
	/**
	 * 同时获得企业后台数据和统计数据
	 */
	public function getInfoAndStat()
	{
		$sql = 'SELECT * FROM `account_basic` limit 5';
		$info = $this->query($sql);
		$this->db(1,'EMPTYDB');		
		$sql = 'SELECT * FROM user_add_card limit 5';
		$stat = $this->query($sql);
		return array('info'=>$info,'stat'=>$stat);
	}
}
