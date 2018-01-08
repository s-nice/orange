<?php
/*
 * 普通账号 相关接口
 * @author zhangpeng <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\AccountBiz;
use Model\WebService;
class AccountBiz extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获取企业账户资料
	 * @param
	 * @return array
	 */
	public function bizAccount($params = array()){
		// web service 接口路径
		$webServiceRootUrl = C('API_ACCOUNTBIZ_COMPANY_GETBIZ');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result['data']['accountbizs']?$result['data']['accountbizs'][0]:array();
	}
	
	/**
	 * 企业文章
	 * @param array $params
	 * @param string $crudMethod
	 * @return array
	 */
	public function article($params = array(),$crudMethod = 'R'){
	    switch ($crudMethod){
	        case 'R':
	            // 设置请求方法为 删除
	            $crudMethod = parent::OC_HTTP_CRUD_R;
	            break;
	        case 'C':
	            // 设置请求方法为 新建
	            $crudMethod = parent::OC_HTTP_CRUD_C;
	            break;
	        case 'D':
	            // 设置请求方法为 删除
	            $crudMethod = parent::OC_HTTP_CRUD_D;
	            break;
	        case 'U':
	            // 设置请求方法为 新建
	            $crudMethod = parent::OC_HTTP_CRUD_U;
	            break;
	        default:
	            $crudMethod = parent::OC_HTTP_CRUD_R;
	    }
	    $response = $this->request(C('API_ORADT_ARTICLE'), $crudMethod, $params);
	    return parseApi($response);
	}
	
	
	/**
	 * 发送邮箱验证信息
	 * @param
	 * @return boolean
	 */	
	public function sendemail($email,$content,$type,$emailcode=false,$title='')
	{
		// web service 接口路径
		$webServiceRootUrl = C('API_RESET_PASS_BY_MAIL');
		// 设置请求方法为 添加
		$crudMethod = parent::OC_HTTP_CRUD_C;
		//$content = '';//自定义邮箱提示 <{UUID}>
		//$content.="\r\n<a".$blank."href='".U($redirectUrl,array('username'=>$username,'uuid'=>'<{UUID}>'),true,false,true)."' style='text-decoration:underline;'>".U($redirectUrl,array('username'=>$username,'uuid'=>'<{UUID}>'),true,false,true).'</a>';
		$params = array(
				'title' => $title,
				'email'=>$email,
				'ip'=>get_client_ip(),
				'type'=>$type,
				'content'=>$content
		);
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		return  parseApi($response);
	}
	/**
	 * 忘记密码后修改密码操作
	 */
	public function forgetUpdatePwd($params=array())
	{
		$webServiceRootUrl = C('API_EDIT_PASS_BY_MAIL');
		// 设置请求方法为 添加
		$crudMethod = parent::OC_HTTP_CRUD_C;
		return parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
	}
	/**
	 * 登录后修改密码或邮箱
	 * @param unknown $params
	 * @return \ErrorCoder
	 */
	public function updatePwdOrMail($params=array())
	{
		$webServiceRootUrl = C('API_UPDATE_MAIL_OR_PWD');
		// 设置请求方法为 添加
		$crudMethod = parent::OC_HTTP_CRUD_C;
		return parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
	}
	
	public function sendEmail_bak($title,$email, $url, $redirectUrl, $type ='text',$content='')
	{
		$userInfo = session(GROUP_NAME);
		$username = $userInfo['username'];
		$url 	  = strtr($url,'@','/');
		$redirectUrl = strtr($redirectUrl,'@','/');
		////'http://'.$_SERVER['HTTP_HOST'].U('company/account/resetpwd')
		// web service 接口路径
		$webServiceRootUrl = rtrim(C('WEB_SERVICE_ROOT_URL'), '/') .'/'. $url;
		// 设置请求方法为 创建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		if($redirectUrl){
			/*$other_content = "尊敬的用户:\r\n\r\n
			 您注册北京橙鑫科技数据有限公司的企业用户注册成功，如非本人操作，请忽略此邮件。\r\n\r\n
			请立即验证邮箱，验证邮箱链接：验证邮箱\r\n\r\n
			如果上面的链接无法点击，您可以复制下面的地址，并粘贴到浏览器的地址栏中访问。\r\n";*/
			$blank = chr(32);
			$content.="\r\n<a".$blank."href='".U($redirectUrl,array('username'=>$username,'uuid'=>'<{UUID}>'),true,false,true)."' style='text-decoration:underline;'>".U($redirectUrl,array('username'=>$username,'uuid'=>'<{UUID}>'),true,false,true).'</a>';
		}else{
			$content='';
		}
		if('resetpasswd/email'==$url){
			$params = array('email'=>$email,'type'=>'biz','ip'=>get_client_ip(),'content'=>$content);
		}else{
			if($type == 'text'){
				$params = array('title'=>$title,'email'=>$email,'module'=>'accountbiz','content'=>$content);
			}else{
				$params = array('email'=>$email,'module'=>'accountbiz');
			}
		}
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		// 解析http 请求
		if ($response instanceof ErrorCoder) { // 请求错误。 错误处理
			$errorMessage = $response->getErrorDesc();
			$errorCode = $response->getErrorCode();
			return $errorMessage;
		} else {
			$userInfo = json_decode($response, true);
			if (!$userInfo['head']['status']) {
				return true ;
			}
			else{
				$err = new ErrorCoder;
				return   $err-> setErrorDesc($response);
			}
	
			//  return $response;
		}
	}
	
	/**
	 * 普通账号
	 */ 
	public function account($params = array(),$crudMethod = 'R')
	{
		// 设置请求头信息
		$headers = array();
		if(isset($params['headers'])){
			$headers=$params['headers'];
			unset($params['headers']);
		}
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			case 'U':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		//* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_ACCOUNT'), $crudMethod, $params,$headers);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	

	/**
	 * 获取头像
	 * @param array $params
	 * @return array
	 */
	public function headImage($params){
	    header('Content-type: png');
	    $webServiceRootUrl = C('API_ACCOUNT_AVATAR');
	    $crudMethod = parent::OC_HTTP_CRUD_R;
	    $response = $this->request($webServiceRootUrl, $crudMethod, $params);
	    $status = json_decode($response,true);
	    
	    if(empty($status) || (isset($status['head']['status']) && $status['head']['status'] == '1')){
	        echo file_get_contents($params['defaultHeadImg']);
	    }else{
	        $len = strlen($response);
	        header("Content-Length: $len");
	        echo $response;
	    }
	
	    return $response;
	}

	public function editep($params){
		if(isset($params['isemp'])){
			$webServiceRootUrl = C('API_UPDATE_MAIL_OR_PWD_EMP');
			unset($params['isemp']);
		}else{
			$webServiceRootUrl = C('API_UPDATE_MAIL_OR_PWD');
		}
		// 设置请求方法为POST
		$crudMethod = parent::OC_HTTP_CRUD_C;
		/*echo '<pre>';
		print_r($params);*/
		$result = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($result);
	}
	
	/**
	 * 获取企业认证情况
	 */
	public function getAuthInfo($params=array())
	{
		$webServiceRootUrl = C('API_ACCOUNTBIZ_AUTH_GET');
		// 设置请求方法为POST
		$crudMethod = parent::OC_HTTP_CRUD_R;
		/*echo '<pre>';
		 print_r($params);*/
		$result = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($result);
	}
	
	/**
	 * 修改企业认证状态: 2认证成功,3认证失败
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, int, unknown> >
	 */
	public function updateAuthStatus($params=array())
	{
		$webServiceRootUrl = C('API_ACCOUNTBIZ_AUTH_ADD');
		// 设置请求方法为POST
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$result = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($result);
	}
	/**
	 * 获取企业员工列表
	 */
	public function getAccountList($params=array()){
		$webServiceRootUrl = C('API_ACCOUNTBIZ_EMPLOYEE_GET');
		// 设置请求方法为POST
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$result = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($result);
	}
	
	/**
	 * 检测企业名称或企业邮箱是否存在
	 */
	public function existsAccount($params=array()){
		$webServiceRootUrl = C('API_ACCOUNT_DETECTION');
		// 设置请求方法为POST
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$result = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($result);
	}

    /**
     * 企业购买、续费授权 （$params['type']：5 购买、7续费）
     * @params
     * */
    public function buyAccredit($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/order/add';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 企业已购授权列表
     * @params
     * */
    public function accreditList($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/order/authorizelist';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /*
     * 判断是否支付成功（订单是否已支付）
     * */
    public function isPayOkM($params=array()){
        $crudMethod = parent::OC_HTTP_CRUD_R;
        //* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_PAYORDER_LIST'), $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    /**
     * 运营平台企业用户查询消费记录 
     */
    public function getExpensesRecord($param=array())
    {
    	$where = $whereValues = array(); //定义where查询条件存储变量
    	$whereStr = '';
    	$sortStr = isset($param['sort']) ? 'ORDER BY '.$param['sort'] : '';
    	if(!empty($param['starttime'])){//开始时间
    		$where[] = 'bizlog.create_time >= "%s"';
    		$whereValues[] = $param['starttime'];
    	}
    	if(!empty($param['endtime'])){ //结束时间
    		$where[] = 'bizlog.create_time <= "%s"';
    		$whereValues[] = $param['endtime'];
    	}
    	if(isset($param['consumption'])){ //消费类型
    		$where[] = 'bizlog.type =  %d';
    		$whereValues[] = $param['consumption'];
    	}
    	if(isset($param['expenses'])){ //支出类型
    		$where[] = 'bizorder.type = %d';
    		$whereValues[] = $param['expenses'];
    	}
    	if ($where) {
    		$where = join(' AND ', $where);
    		$where = vsprintf($where, $whereValues);
    		$whereStr = ' WHERE ' . $where;
    	}
    	$this->_getDbModel();
    	$sql = "SELECT SQL_CALC_FOUND_ROWS bizlog.type  as xiaofeitype, bizlog.biz_id, bizlog.price, bizlog.create_time, bizorder.type as zhichutype, bizorder.order_id, bizorder.bank
			 	FROM `biz_recharge_consume_log` as bizlog
				INNER JOIN biz_order as bizorder ON bizorder.order_id = bizlog.order_id".
    			" {$whereStr} {$sortStr} limit {$param['start']},{$param['rows']}";
    	$list = $this->dbObj->query($sql);
    	$sql_numfound = 'SELECT FOUND_ROWS() as total';
    	$rstNumfound = $this->dbObj->query($sql_numfound); //查询总记录数
    	return array('list'=>$list, 'numfound'=>$rstNumfound[0]['total']);
    }
    
    /**
     * 企业用户获取授权账号列表
     */
    public function getAuthAccount()
    {
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
    		$model = new \Think\Model();
    		$model->db($num, $dbCfgName);
    		$this->dbObj = $model;
    		$flag = true;
    	}
    }
    
    //批量更新会员卡有效期值
    public function batchUpdateMember()
    {
        $cardtypearr = array(1,2,3);
    	$this->_getDbModel(1,'APPADMINDB_IMPORT_145');
        //4,15,16,17,18
    	$sql = "select id,card_type,description,vcard from orange_membership_card where card_type in (1,2,3) ";
    	$rest = $this->dbObj->query($sql);
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(count($rest));
    	$newData = array();
    	$newSql = array();
    	if($rest){
    		foreach ($rest  as $key=>$val){
    			$id = $val['id'];
    			$vcard = json_decode($val['vcard'],1);
    			$text = $vcard['FRONT']['TEXT'];
                if(in_array($val['card_type'],$cardtypearr)){
                    foreach ($text as $k=>$v){
                        if($v['VALUE']['LABEL'] == 'VALID THRU'){

                                $newData[] = array('id'=>$val['id'],
                                    'card_type' => $val['card_type'],
                                    'name' => $val['description']
                                );
                                //546修改为530
                                $vcard['FRONT']['TEXT'][$k]['SIZE'] = '40';
                                $vcardJson = json_encode($vcard);
                                //更新数据
                                $sql_update = "update orange_membership_card set vcard='%s' where id=%d LIMIT 1";
                                $newSql[] = $sql_update;
                                $param = array();
                                $param[] = $vcardJson;
                                $param[] = $id;
                                $this->dbObj->execute($sql_update,$param);
                                continue;

                        }
                    }
                }
    		}
    	}
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(count($newSql));
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($newData,1);exit;
    //	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(join(';<br/>', $newSql));exit;
    	
    	

    }
    //批量更新会员卡中卡号为居中对齐
    public function batchUpdateCardNumber()
    {
        $cardtypearr = array(1,2,3);
    	$this->_getDbModel(1,'APPADMINDB_IMPORT_145');
        //cardtype 1,2,3 改为 4,15,16,17,18
    	$sql = "select id,card_type,description,vcard from orange_membership_card where card_type in (1,2,3)";
    	$rest = $this->dbObj->query($sql);
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(count($rest));
    	$newData = array();
    	$newSql = array();
    	if($rest){
    		foreach ($rest  as $key=>$val){
    			$id = $val['id'];
    			$vcard = json_decode($val['vcard'],1);
    			$text = $vcard['FRONT']['TEXT'];
                if(in_array($val['card_type'],$cardtypearr)){
                    foreach ($text as $k=>$v){
                        if($v['VALUE']['LABEL'] == '卡号'){
                            //if($v['ALIGN'] == 'CENTER'){
                                $newData[] = array('id'=>$val['id'],
                                    'card_type' => $val['card_type'],
                                    'name' => $val['description']
                                );
                                //$vcard['FRONT']['TEXT'][$k]['ALIGN'] = 'CENTER';
                                //$width = $vcard['FRONT']['TEXT'][$k]['WIDTH'];
                                $vcard['FRONT']['TEXT'][$k]['SIZE'] = 60; //页面排版修改为居中对齐"".(600-intval($width/2))
                                $vcardJson = json_encode($vcard);
                                //更新数据
                                $sql_update = "update orange_membership_card set vcard='%s' where id=%d LIMIT 1";
                                $param = array();
                                $param[] = $vcardJson;
                                $param[] = $id;
                                $this->dbObj->execute($sql_update,$param);
                                $newSql[] = $sql_update;
                                continue;
                            //}
                        }
                    }
                }
    		}
    	}
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(count($newData));
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(join(';<br/>', $newSql));exit;
    }
    
    //批量更新会员卡中模板名称
    public function batchUpdateTplName($nameList)
    {
    	$this->_getDbModel(1,'APPADMINDB_IMPORT_aws');
    	if(!$nameList){
    		exit('参数为空');
    	}

        if(0){
            //卡模板名称修改。
            foreach ($nameList as $key => $val){
                $select = "select id,description from orange_membership_card where description  = '$val[0]'";
                $res = $this->dbObj->query($select);
                if(!$res[0]['id']){
                    echo "----不存在-$key-$val[0]；\r\n";
                }
                //continue;
                //更新数据
                $sql_update = "update orange_membership_card set description='%s' where description='%s' LIMIT 1";
                $param = array();
                $param[] = $val[1];
                $param[] = $val[0];
                $this->dbObj->execute($sql_update,$param);

            }
        }
        //修改同步时间
        foreach ($nameList as $key => $val){
            $select = "select id,description,modify_time from orange_membership_card where description  = '$val[1]'";
            $res = $this->dbObj->query($select);

            if(!$res[0]['id']){
                echo "----不存在-$key-$val[0]；\r\n";
                continue;
            }
            $times = time();
            //continue;
            //更新数据
            $sql_update = "update orange_membership_card set modify_time='%d' where id='%d' LIMIT 1";
            $param = array();
            $param[] = $times;
            $param[] = $res[0]['id'];
            $this->dbObj->execute($sql_update,$param);

            //更新数据
            $sql_update_sync = "update common_system_sync_v2 set modify_time='%d' where module='m-0' and  module_id='%d' LIMIT 1";
            $params = array();
            $params[] = $times;
            $params[] = $res[0]['id'];
            $this->dbObj->execute($sql_update_sync,$params);


        }



    }

    public function batchUpdateData(){
        $cardtypearr = array(1,2,3,4,15,16,17,18,19);
        $this->_getDbModel(1,'APPADMINDB_IMPORT_aws');
        //cardtype 1,2,3 改为 4,15,16,17,18
        $sql = "select id,card_type,description,vcard from orange_membership_card where card_type in(1,2,3,4,15,16,17,18,19) order by id asc";
        $rest = $this->dbObj->query($sql);


        if($rest){
            foreach ($rest  as $key=>$val){
                $id = $val['id'];
                //断点
                /*if($id<1189){
                    break;
                }*/
                $vcard = json_decode($val['vcard'],1);

                //修改背景图url
                if(in_array($val['card_type'],array(1,2))){
                    $vcard['BACK']['TEMP']['BGURL'] = 'https://s3.cn-north-1.amazonaws.com.cn/oradt-moban/funback/yhk.png';//银行卡
                }elseif(in_array($val['card_type'],array(3,4))){
                    $vcard['BACK']['TEMP']['BGURL'] = 'https://s3.cn-north-1.amazonaws.com.cn/oradt-moban/funback/jd_hl.png';//酒店航旅
                }elseif(in_array($val['card_type'],array(15,16,17,18,19))){
                    $vcard['BACK']['TEMP']['BGURL'] = 'https://s3.cn-north-1.amazonaws.com.cn/oradt-moban/funback/hy_qt.png';//会员卡
                }

                if(in_array($val['card_type'],$cardtypearr)){
                    if(in_array($val['card_type'],array(15,16,17,18,19))){
                        $text = $vcard['BACK']['TEXT'];
                        foreach ($text as $k=>$v){
                            if($v['VALUE']['LABEL'] == '条形码'){
                                //修改条形码数据
                                $vcard['BACK']['TEXT'][$k]['WIDTH'] = 500;
                                $vcard['BACK']['TEXT'][$k]['HEIGHT'] = 80;
                                $vcard['BACK']['TEXT'][$k]['MINX'] = 580;
                                $vcard['BACK']['TEXT'][$k]['MINY'] = 592;
                            }
                        }
                    }

                    $times = time();

                    $vcardJson = json_encode($vcard);
                    //更新数据
                    $sql_update = "update orange_membership_card set vcard='%s',modify_time='%d'  where id=%d LIMIT 1";
                    $param = array();
                    $param[] = $vcardJson;
                    $param[] = $times;
                    $param[] = $id;
                    $this->dbObj->execute($sql_update,$param);

                    //更新数据
                    $sql_update_sync = "update common_system_sync_v2 set modify_time='%d' where module='m-0' and  module_id='%d' LIMIT 1";
                    $params = array();
                    $params[] = $times;
                    $params[] = $id;
                    $this->dbObj->execute($sql_update_sync,$params);

                }
            }
        }

    }

    //有效期关联属性修改
    public function batchUpdateDataValid(){
        $cardtypearr = array(1,2,3,4,15,16,17,18,19);
        $this->_getDbModel(1,'APPADMINDB_IMPORT_145');
        //cardtype 1,2,3 改为 4,15,16,17,18
        $sql = "select id,card_type,description,vcard from orange_membership_card where card_type in(1,2,3,4,15,16,17,18,19) order by id asc";
        $rest = $this->dbObj->query($sql);

        if($rest){
            foreach ($rest  as $key=>$val){
                $id = $val['id'];
                $vcard = json_decode($val['vcard'],1);

                if(in_array($val['card_type'],$cardtypearr)){
                    $text = $vcard['FRONT']['TEXT'];
                    foreach ($text as $k=>$v){
                        if($v['VALUE']['LABEL'] == 'VALID THRU(只展示)'){
                            //修改条形码数据
                            $vcard['FRONT']['TEXT'][$k]['VALUE']['CONTACT'] = 'VALID THRU';
                        }
                    }
                    $times = time();
                    $vcardJson = json_encode($vcard);
                    //更新数据
                    $sql_update = "update orange_membership_card set vcard='%s',modify_time='%d'  where id=%d LIMIT 1";
                    $param = array();
                    $param[] = $vcardJson;
                    $param[] = $times;
                    $param[] = $id;
                    $this->dbObj->execute($sql_update,$param);

                    //更新数据
                    $sql_update_sync = "update common_system_sync_v2 set modify_time='%d' where module='m-0' and  module_id='%d' LIMIT 1";
                    $params = array();
                    $params[] = $times;
                    $params[] = $id;
                    $this->dbObj->execute($sql_update_sync,$params);

                }
            }
        }

    }

    //卡类型属性修改
    public function batchUpdateDataCardProp(){
        $cardtypearr = array(1,2,3,4,15,16,17,18,19);
        $this->_getDbModel(1,'APPADMINDB_IMPORT_idc');
        //cardtype 1,2,3 改为 4,15,16,17,18
        $sql = "select id,card_type,description,vcard from orange_membership_card where card_type in(1,2,3,4,15,16,17,18,19) order by id asc";
        $rest = $this->dbObj->query($sql);

        if($rest){
            $vcard = '';
            $vcardJson = '';
            $i=0;
            foreach ($rest  as $key=>$val){
                $id = $val['id'];
                $i++;
                $vcard = json_decode($val['vcard'],1);
                if(in_array($val['card_type'],$cardtypearr)){
                    $text = $vcard['FRONT']['TEXT'];
                    foreach ($text as $k=>$v){
                        if($v['VALUE']['LABEL'] == '截止日期'){
                            //修改条形码数据
                            //$vcard['FRONT']['TEXT'][$k]['VALUE']['CONTACT'] = 'VALID THRU'

                        }
                    }
                    $times = time();
                    $vcardJson = json_encode($vcard);
                    //更新数据
                    $sql_update = "update orange_membership_card set vcard='%s',modify_time='%d'  where id=%d LIMIT 1";
                    $param = array();
                    $param[] = $vcardJson;
                    $param[] = $times;
                    $param[] = $id;
                    //$this->dbObj->execute($sql_update,$param);

                    //更新数据
                    $sql_update_sync = "update common_system_sync_v2 set modify_time='%d' where module='m-0' and  module_id='%d' LIMIT 1";
                    $params = array();
                    $params[] = $times;
                    $params[] = $id;
                    //$this->dbObj->execute($sql_update_sync,$params);

                }
            }
            echo $i;
        }

    }

    //发送邮件
    public function updateEmail($params){
        // web service 接口路径
        if(isset($params['isemp'])){
			$webServiceRootUrl = C('API_UPDATE_MAIL_OR_PWD_EMP');
			unset($params['isemp']);
			$params['empid'] = $params['bizid'];
			unset($params['bizid']);
		}else{
			$webServiceRootUrl = C('API_UPDATE_MAIL_OR_PWD');
		}
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        /*echo '<pre>';
        print_r($params);die;*/
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //检测邮箱是否使用
    public function checkMail($params){
        // web service 接口路径
		$webServiceRootUrl = C('API_APISTORE_CHECKMAIL');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }
}
