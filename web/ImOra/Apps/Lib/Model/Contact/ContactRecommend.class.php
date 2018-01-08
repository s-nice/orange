<?php
namespace Model\Contact;
use \Think\Model;
use Model\WebService;

class ContactRecommend extends WebService
{
	private $dbObj = null;
	public function __construct(){
		parent::__construct();
		
	}
	/**
	 * 获取推荐历史记录
	 * @param unknown $param
	 * @return multitype:NULL \Think\mixed
	 */
    public function getRecHistoryList($param=array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : ' ORDER BY id DESC';
    	if(!empty($param['starttime'])){//开始时间
    		$where[] = 'recommend_time >= "%s"';
    		$whereValues[] = $param['starttime'];
    	}
    	if(!empty($param['endtime'])){ //结束时间
    		$where[] = 'recommend_time <= "%s"';
    		$whereValues[] = $param['endtime'];
    	}
    	if ($where) {
    		$where = join(' AND ', $where);
    		$where = vsprintf($where, $whereValues);
    		$whereStr = ' WHERE ' . $where;
    	}
    	$this->_getDbModel();
    	$sql = "SELECT  id,recommend_time as rec_time,recommend_number as rec_num, recommended_number as reced_num FROM `account_basic_recommend` as rec".
    		" {$whereStr} {$sortStr} limit {$param['start']},{$param['rows']}";
    	$list = $this->dbObj->query($sql);
    	$sql_numfound = "SELECT  count(id) as total FROM `account_basic_recommend` as rec {$whereStr}";
    	$rstNumfound = $this->dbObj->query($sql_numfound); //查询总记录数
    	return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
    
    /**
     * 获取推荐详情列表->推荐人
     */
    public function getRecDetailUserList($param=array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	if(isset($param['recommend_id'])){//开始时间
    		$where[] = 'redetail.recommend_id = "%d"';
    		$whereValues[] = $param['recommend_id'];
    	}
    	if(isset($param['type'])){//开始时间
    		$where[] = 'redetail.type = "%d"';
    		$whereValues[] = $param['type'];
    	}
    	if ($where) {
    		$whereStr = join(' AND ', $where);
    		$whereStr = 'WHERE '.vsprintf($whereStr, $whereValues);
    	}
    	
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : '';
    	$this->_getDbModel();
    	$fields = "distinct(basic.user_id) user_id,
					basic.mobile,
					detail.real_name,
    				detail.isbinding,
    				basic.last_find_time,
    				basic.use_num,
					private.province AS region,
			  		private.city ,
					IF (category.type=1,category.name,'')  AS industry,
					vcardinfo.TITLE AS position ";
    	$sqlBasic = "SELECT %s FROM account_basic_recommend_detail as redetail
				INNER JOIN  `account_basic_detail` AS detail  ON redetail.user_id = detail.user_id 
				LEFT JOIN account_basic AS basic ON detail.user_id = basic.user_id
				LEFT JOIN contact_card_vcardinfo as vcardinfo  ON  vcardinfo.card_id = detail.card_id
				LEFT JOIN account_basic_category_map AS catmap ON  catmap.account_id=detail.user_id
				LEFT JOIN account_basic_category  AS category ON  catmap.category_id=category.category_id
    			LEFT JOIN province_city_code  AS private ON  detail.city_code=private.prefecture_code  {$whereStr} {$sortStr} ";
    	   $limitCond = " LIMIT {$param['start']},{$param['rows']}";
    	$sql = sprintf($sqlBasic,$fields);
    	$list = $this->dbObj->query($sql.$limitCond);
    	$sql_numfound = sprintf($sqlBasic, 'count(basic.user_id) as total');
    	$rstNumfound = $this->dbObj->query($sql_numfound);
    	return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
    
    /**
     * 获取推荐详情列表->推荐名片
     * @param unknown $param
     * @return multitype:NULL \Think\mixed
     */
    public function getRecDetailVcardList($param=array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	if(isset($param['recommend_id'])){//开始时间
    		$where[] = 're.id = "%d"';
    		$whereValues[] = $param['recommend_id'];
    	}
    	$whereStr = $this->_getWhereStr($where, $whereValues);
    	 
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : '';
    	$this->_getDbModel();
        $fields = " FN as contact_name,ORG as vorg, TITLE as vtitle, CELL as mobile, uuid,num ";
        $sqlBasic = "select %s from contact_card_vcardinfo as a INNER JOIN ".
				"(select uuid,count(uuid) as num from contact_card ".
					'where status="active" AND public ="all"'.  
				"AND   uuid in (select card_id from account_basic_recommend as re LEFT JOIN account_basic_recommend_detail as rede ON re.id=rede.recommend_id {$whereStr}) GROUP BY md5_value) ".
				"as b ON a.card_id=b.uuid ";
        $limitCond = " LIMIT {$param['start']},{$param['rows']} ";
        $sql = sprintf($sqlBasic,$fields);
    	$list = $this->dbObj->query($sql.$limitCond); 
    	$sql_numfound = sprintf($sqlBasic,' count(*) as total');
    	$rstNumfound = $this->dbObj->query($sql_numfound);
    	return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
    
    /**
     * 弹出层中  ->  获取推荐人脉用户列表
     */
    public function getRecPersonList($param=array())
    {   //echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($param,1);exit;
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : '';
    	if(!empty($param['mobile'])){//用户手机号
    		$where[] = 'basic.mobile like "%s"';
    		$whereValues[] = '%'.$param['mobile'].'%';
    	}
    	if(!empty($param['real_name'])){ //姓名
    		$where[] = 'detail.real_name like "%s"';
    		$whereValues[] = '%'.$param['real_name'].'%';
    	}
    	if(!empty($param['region'])){ //区域
    		$where[] = ' detail.city_code in (%s)';
    		$whereValues[] = $param['region'];
    	}
    	if(!empty($param['industry'])){ //行业
    		$where[] = 'category.type=1 AND category.category_id in (%s)';
    		$whereValues[] = $param['industry'];
    	}
    	if(!empty($param['title'])){ //职位
    		$where[] = 'vcardinfo.TITLE like "%s"';
    		$whereValues[] = '%'.$param['title'].'%';
    	}
    	if ($where) {
    		$where = join(' AND ', $where);
    		$where = vsprintf($where, $whereValues);
    		$whereStr = ' WHERE ' . $where;
    	}
		$this->_getDbModel();
		if($param['dataTotolNumAnsy'] != '1'){
			$fileds = " basic.user_id,
						basic.mobile,
						detail.real_name,
	    				detail.isbinding,
	    				basic.last_find_time,
	    				basic.use_num,
						private.province AS region,
				  		private.city ,
						IF (category.type=1,category.name,'--')  AS industry,
						vcardinfo.TITLE AS position ";
	    	$sqlBasic ="SELECT %s	FROM `account_basic_detail` AS detail 
					LEFT JOIN account_basic AS basic ON detail.user_id = basic.user_id 
					LEFT JOIN contact_card_vcardinfo as vcardinfo  ON  vcardinfo.card_id = detail.card_id 
					LEFT JOIN account_basic_category_map AS catmap ON  catmap.account_id=detail.user_id 
					LEFT JOIN account_basic_category  AS category ON  catmap.category_id=category.category_id 
	    			LEFT JOIN province_city_code  AS private ON  detail.city_code=private.prefecture_code". 
					"   {$whereStr} {$sortStr} ";
	    	$limitCond = " limit {$param['start']},{$param['rows']} ";
	    	$sql = str_replace('%s',$fileds,$sqlBasic);
	    	$list = $this->dbObj->query($sql.$limitCond);
	    	return array('list'=>$list);
		}else{
			if($where){
				$sql_numfound = str_replace('%s', ' count(*) as total',$sqlBasic);
			}else{
				$sql_numfound = "SELECT sum(num) as total FROM account_basic_detail_sum";
			}
			$rstNumfound = $this->dbObj->query($sql_numfound);
			return array('numfound'=>$rstNumfound[0]['total']);
		}
    }
    
    /**
     * 弹出层中  ->  获取被推荐名片列表
     * @param unknown $param
     */
    public function getRecedCardList($param = array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereReg = $whereValuesReg = array();
    	$whereInd = $whereValuesInd = array();
    	$whereFun = $whereValuesFun = array();
    	$whereStr = $whereRegStr = $whereIndStr = $whereFunStr = '';
    	//$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : '';
    	if(!empty($param['mobile'])){//用户手机号
    		$where[] = 'CELL like "%s"';
    		$whereValues[] = '%'.$param['mobile'].'%';
    	}
    	if(isset($param['real_name'])){ //姓名
    		$where[] = 'FN like "%s"';
    		$whereValues[] = '%'.$param['real_name'].'%';
    	}
    	if(!empty($param['region'])){ //区域
    		$whereReg[] = ' cityM_code in (%s)';
    		$whereValuesReg[] = $param['region'];
    		$whereRegStr = $this->_getWhereStr($whereReg, $whereValuesReg);
    		$whereRegStr = 'AND   uuid in (SELECT card_id FROM card_city'.$whereRegStr.")";
    	}
    	if(!empty($param['industry'])){ //行业
    		$whereInd[] = 'ind2_code in (%s)';
    		$whereValuesInd[] = $param['industry'];
    		$whereIndStr = $this->_getWhereStr($whereInd, $whereValuesInd);
    		$whereIndStr = 'AND uuid in (SELECT card_id FROM card_industry'.$whereIndStr.")";
    	}
    	if(!empty($param['position'])){ //职能
    		$whereFun[] = 'func_code in (%s)';
    		$whereValuesFun[] = $param['position'];
    		$whereFunStr = $this->_getWhereStr($whereFun, $whereValuesFun);
    		$whereFunStr = 'AND uuid in (SELECT card_id FROM card_function'.$whereFunStr.")";
    	}

    	$whereStr = $this->_getWhereStr($where, $whereValues);
    	$this->_getDbModel();
    	$sqlBasic = "SELECT   %s FROM contact_card_vcardinfo as a ".
    			"INNER JOIN (".
    			"select uuid,count(uuid) as num from contact_card ".
    			'where status="active" AND public ="all" '.
    			$whereRegStr .
    			$whereIndStr .
    			$whereFunStr  ."GROUP BY md5_value".
    			") as b ON a.card_id=b.uuid".$whereStr;
    	if($param['dataTotolNumAnsy'] != '1'){
    	 		//1：个人注册， public: off非共享名片
	    	 $fileds = " FN as contact_name, ORG as vorg, TITLE as vtitle,CELL as mobile,uuid as vcard_id, num ";
	    	 $limitCond = " LIMIT {$param['start']},{$param['rows']}";
	    	 $sql = str_replace('%s', $fileds,$sqlBasic);
	    	 $list = $this->dbObj->query($sql.$limitCond);
	    	 return array('list'=>$list);
    	}else{
    		$sql_numfound = str_replace('%s',' count(*) as total ',$sqlBasic);
    		$rstNumfound = $this->dbObj->query($sql_numfound);
    		return array('numfound'=>$rstNumfound[0]['total']);
    	}
    	//return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
    /**
     * 获取拼接好的where字符串条件
     */
    private function _getWhereStr($where, $whereValues)
    {
    	$whereStr = '';
    	if ($where) {
    		$where = join(' AND ', $where);
    		$where = vsprintf($where, $whereValues);
    		$whereStr = ' WHERE ' . $where;
    	}
    	return $whereStr;
    }
    
    /**
     * 获取数据库连接对象
     * @param number $num
     * @param string $dbCfgName
     */
    private function _getDbModel($num=1, $dbCfgName='APPADMINDB')
    {
    	static $flag = false;
    	if(!$flag){
    		$model = new Model();
    		$model->db($num, $dbCfgName);
    		$this->dbObj = $model;
    		$flag = true;
    	}
    }
    /**
     * 添加人脉推荐
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, unknown, int> >
     */
    public function addRecData($params = array())
    {
    	// web service 
    	$webServiceRootUrl = C('API_CONTACT_RECOMMEND_ADD');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    
    /**
     * 企业用户->获取被授权用户列表
     * @param unknown $param
     * @return multitype:NULL \Think\mixed
     */
    public function getEntAuthUser($param=array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : ' ORDER BY a.id DESC';
    	if(!empty($param['bizid'])){//企业id
    		$where[] = 'a.biz_id >= "%s"';
    		$whereValues[] = $param['bizid'];
    	}
    	if(!empty($param['begintime'])){//开始时间
    		$where[] = 'a.auhor_time >= "%s"';
    		$whereValues[] = $param['begintime'];
    	}
    	if(!empty($param['endtime'])){ //结束时间
    		$where[] = 'a.auhor_time <= "%s"';
    		$whereValues[] = $param['endtime'].' 23:59:59';
    	}
    	if(!empty($param['mobile'])){//用户手机号
    		$where[] = 'a.mobile = "%s"';
    		$whereValues[] = $param['mobile'];
    	}
    	if(!empty($param['realname'])){ //姓名
    		$where[] = 'a.name like "%s"';
    		$whereValues[] = '%'.$param['realname'].'%';
    	}
    	if(!empty($param['accountType'])){ //账号类型
    		$where[] = 'c.isbinding = %d';
    		$whereValues[] = $param['accountType'];
    	}
    	if ($where) {
    		$where = join(' AND ', $where);
    		$where = vsprintf($where, $whereValues);
    		$whereStr = ' WHERE ' . $where;
    	}
		$this->_getDbModel();
		$fileds = " a.biz_id AS bizid,a.name,a.auhor_time as auhortime,c.shared,c.login_time as logintime,a.mobile,b.bad_num as badnum,b.praise_num as proisenum,c.violate_count as asviolatecount,c.isbinding,d.status AS state ";
    	$sqlBasic ="SELECT %s FROM account_biz_employee AS a 
					LEFT JOIN account_basic_detail_extend AS b ON a.user_id = b.user_id 
					LEFT JOIN account_basic_detail AS c ON c.user_id = a.user_id
					LEFT JOIN account_basic AS d ON d.user_id=a.user_id
    				{$whereStr} {$sortStr}";
    	$limitCond = " limit {$param['start']},{$param['rows']} ";
    	$sql = str_replace('%s',$fileds,$sqlBasic);
    	$list = $this->dbObj->query($sql.$limitCond);
    	$sql_numfound = str_replace('%s', ' count(*) as total',$sqlBasic);
    	$rstNumfound = $this->dbObj->query($sql_numfound);
    	return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
}

