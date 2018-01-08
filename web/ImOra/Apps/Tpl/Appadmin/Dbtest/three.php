<layout name="../Layout/Layout" />
<style>
.appadmin_section_right{ height:2100px;}
</style>
<div id="js_data" style="height:300px;">
/* 数据库切换例子(\Model\DB\MoreDbTest<br />
 * 利用TP的构造函数来切换连接数据库的配置文件,实现整个类文件连接指定的数据库<br />
 * @author jiyl<br />
 * <br />
 * 目前公共配置文件中公共数据库的配置信息,指向的是信息统计数据库，<br />
 * 而企业后台和运营后台的各自的数据库配置信息，存在各自模块下的配置文件中，<br />
 * 暂定名字分别是C('COMPANYDB')和C('APPADMINDB')<br />
 * <br />
 * 	1.编写的类中只会应用到统计信息数据库时,tp的构造函数可以省略不写，数据库会默认指向信息统计数据库<br />
 * 		类如：Model\Statistics\CardsStat<br />
 *  2.编写的类中只会应用到企业后台(运营后台)数据库时，需要替换公共的统计信息数据库配置：<br />
 *  	增加tp的构造函数,如下：<br />
 *  	public function _initialize() {<br />
			$this->connection = C('COMPANYDB');<br />
			//$this->connection = C('APPADMINDB');<br />
		}<br />
 *  3.编写的类中只会应用到企业后台(运营后台)数据库时，需要替换公共的统计信息数据库配置：<br />
 *  	增加tp的构造函数,如下：<br />
 *  	public function _initialize() {<br />
			$this->connection = C('COMPANYDB');<br />
			//$this->connection = C('APPADMINDB');<br />
		}<br />
 *  4.编写的类中会同时应用到企业后台、运营后台、统计信息数据库时，根据应用次数的多少可以分为两种情况：<br />
 *  	情况一：公共配置文件中的统计信息配置运用次数较多,tp构造函数省略不写,或不做任何处理<br />
 *  	public function _initialize() {<br />
			// null<br />
		}<br />
			-- 获取公共统计信息方法<br />
			public function getdata(){<br />
				$sql = 'select * from table';<br />
				$statInfo = $this->query($sql);<br />
			}<br />
			-- 获取公共统计信息和企业后台(运营后台)信息方法<br />
			public function getdata(){<br />
				// 统计信息<br />
				$sql = 'select * from table';<br />
				$statInfo = $this->query($sql);<br />
				// 企业后台（运营后台）信息<br />
				$sql = 'select * from table';<br />
	 			$this->db(1,'COMPANYDB');<br />
	 			//$this->db(1,'APPADMINDB');<br />
	 			$Info = $this->query($sql);<br />
			}<br />
			-- 同时获取公共统计信息、企业后台 、运营后台 三个数据库信息方法<br />
			（注意：三个配置信息需要同时放到公共的配置文件中，目前结构没有）<br />
			public function getdata(){<br />
				// 统计信息<br />
				$sql = 'select * from table';<br />
				$statInfo = $this->query($sql);<br />
				// 企业后台信息<br />
				$sql = 'select * from table';<br />
	 			$this->db(1,'COMPANYDB');<br />
	 			$companyInfo = $this->query($sql);
	 			// 运营后台信息<br />
				$sql = 'select * from table';<br />
	 			$this->db(2,'APPADMINDB');<br />
	 			$appadminInfo = $this->query($sql);<br />
			}<br />
 * 		情况二：企业后台(运营后台）数据库信息运用次数较多时，<br />
 * 				tp构造函数来修改默认连接，但是切换回公共数据库配置时需要应用到另一个公共配置，暂定为C(EMPTYDB)<br />
 *  	public function _initialize() {<br />
			$this->connection = C('COMPANYDB');<br />
			//$this->connection = C('APPADMINDB');<br />
		}<br />
			-- 获取企业后台(运营后台)信息方法<br />
			public function getdata(){<br />
				$sql = 'select * from table';<br />
				$Info = $this->query($sql);<br />
			}<br />
			-- 获取企业后台(运营后台)信息和公共统计信息方法<br />
			public function getdata(){<br />
				// 企业后台（运营后台）信息<br />
				$sql = 'select * from table';<br />
	 			$Info = $this->query($sql);<br />
	 			// 统计信息<br />
	 			$this->db(1,'EMPTYDB');<br />
				$sql = 'select * from table';<br />
				$statInfo = $this->query($sql);<br />
			}<br />
			-- 同时获取企业后台 、运营后台、公共统计信息 三个数据库信息方法<br />
			（注意：三个配置信息需要同时放到公共的配置文件中，目前结构没有）<br />
			public function getdata(){<br />
				// 企业后台信息<br />
				$sql = 'select * from table';<br />
	 			$companyInfo = $this->query($sql);<br />
	 			// 公共统计信息<br />
	 			$this->db(1,'EMPTYDB');<br />
	 			$statInfo = $this->query($sql);<br />
	 			// 运营后台信息<br />
				$sql = 'select * from table';<br />
	 			$this->db(2,'APPADMINDB');<br />
	 			$appadminInfo = $this->query($sql);<br />
			}
</div>