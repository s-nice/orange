<?php
/*
 * 在线客服接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\Custom;
use Model\WebService;
class Custom extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 普通账号
	 */ 
	public function account($params = array(),$crudMethod = 'R')
	{
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
        $response = $this->request(C('API_ACCOUNT'), $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	
	/**
	 * 获取好友信息
	 * @param unknown $params
	 * @param string $crudMethod
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, int, unknown> >
	 */
	public function getFriend($params = array(),$crudMethod = 'R')
	{
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		// 发送http请求
		$response = $this->request(C('API_CUSTOM_FRIEND'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
	
		return $response;
	}
	
	/**
	 * 获取虚拟客服
	 * @param unknown $params
	 * @param string $crudMethod
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, int, unknown> >
	 */
	public function getVrCustomer($params = array(),$crudMethod = 'R')
	{
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		// 发送http请求
		$response = $this->request(C('API_GET_VR_CUSTOM'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
	
		return $response;
	}
	
	/**
	 * 获取历史聊天记录
	 * @param $contactid 联系人ID
	 * @return array
	 */
	public function historyInfo($imid,$vr_clientid,$page=1,$nindex=0,$sequence=null,$startOffset=0)
	{
		$rows = 8;
		$start = ($page-1)*$rows;
		$webServiceRootUrl = C('API_SNS_TALKLOG');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		//$fileds = 'sequence,type,imid,content,datetime,nindex,isread,issend'; ,'fields'=>$fileds
		// 设置请求参数
		$params = array('clientid'=>$imid,'act'=>'getlog','rows'=>$rows,'start'=>$start+$startOffset,'sort'=>'datetime DESC','customerid'=>$vr_clientid);
		$nindex && $params['nindex'] = $nindex;
		$sequence && $params['sequence'] = $sequence;
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$response = parseApi($response);
		//echo __FILE__.' Line:'.__LINE__.'<pre>',print_r($response,1);exit;
		return $response;
	}

	/**
	 * 获取已经回复的好友(接口好像还有点问题，查询不出来数据)
	 * @param unknown $param
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, unknown, int> >
	 */
	public function getReply($param)
	{
		$webServiceRootUrl = C('API_SNS_TALKLOG');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		//$fileds = 'sequence,type,imid,content,datetime,nindex,isread,issend';
		// 设置请求参数
		$params = array();
		$params['act'] = 'getreply';
		$params['clientid'] = $param['vr_clientid'];
		isset($param['start']) && $params['start']=$param['start'];
		isset($param['rows']) && $params['rows']=$param['rows'];
		!empty($param['mobile']) && $params['mobile'] = $param['mobile'];
		!empty($param['datetime']) && $params['datetime'] = $param['datetime'];
		!empty($param['sort']) && $params['sort'] = $param['sort'];
		//!empty($param['acceptor']) && $params['acceptor'] = $param['acceptor'];
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$response = parseApi($response);
		return $response;
	}
	
	/**
	 * 获取咨询用户数
	 * @param unknown $param
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, int, unknown> >
	 */
	public function getAskNumber($param)
	{
		$webServiceRootUrl = C('API_SNS_TALKLOG');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		$params = array();
		$params['act'] = 'askcustomer';
		$params['clientid'] = $param['vr_clientid'];
		isset($param['start']) && $params['start']=$param['start'];
		isset($param['rows']) && $params['rows']=$param['rows'];
		//$params['sender'] = 7839;
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
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
	
	/**
	 * zend webservice上传文件
	 * @param unknown $url  请求服务器地址
	 * @param unknown $filePath 本地文件路径
	 */
	public function fileUploadWs($urlUpload,$filePath)
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 发送http请求
		$this->setCRUD($crudMethod);
		$httpClient = $this->getHttpClient();
		$httpClient->setUri ( $urlUpload );
		$httpClient->setEncType ( \Zend\Http\Client::ENC_FORMDATA );
		$httpClient->setFileUpload ( $filePath,  \Appadmin\Controller\WebChat::FILE_FIELD_NAME );
		$httpResponse = $httpClient->setMethod ( $this->httpMethod )->send();
		$response = $httpResponse->getBody ();
		//是否开启记录日志
		if(C('WEB_SOCKET.START_LOG')){
			$logPath = C('LOG_PATH').'SnsBinaryFile/';
			if(!is_dir($logPath)){
				mkdir($logPath,0777,true);
			}
			$logPath .= date('y_m_d').'.log';
			$logInfo = array('param: '=>func_get_args(),' result: '=>$response);
			\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'二进制文件上传返回结果： '.var_export($logInfo,true),
			\Think\Log::INFO,'',$logPath);
		}
		/* echo __FILE__.' Line:'.__LINE__.'<pre>',print_r(func_get_args(),1);
		 var_dump($response);exit;	 */
		return $response;
	}
	
	/**
	 * 表情信息
	 */
	public function facesInfo()
	{
		$faces = array(
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f001.png','tags'=>'f001'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f002.png','tags'=>'f002'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f003.png','tags'=>'f003'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f004.png','tags'=>'f004'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f005.png','tags'=>'f005'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f006.png','tags'=>'f006'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f007.png','tags'=>'f007'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f008.png','tags'=>'f008'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f009.png','tags'=>'f009'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f010.png','tags'=>'f010'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f011.png','tags'=>'f011'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f012.png','tags'=>'f012'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f013.png','tags'=>'f013'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f014.png','tags'=>'f014'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f015.png','tags'=>'f015'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f016.png','tags'=>'f016'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f017.png','tags'=>'f017'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f018.png','tags'=>'f018'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f019.png','tags'=>'f019'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f020.png','tags'=>'f020'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f021.png','tags'=>'f021'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f022.png','tags'=>'f022'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f023.png','tags'=>'f023'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f024.png','tags'=>'f024'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f025.png','tags'=>'f025'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f026.png','tags'=>'f026'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f027.png','tags'=>'f027'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f028.png','tags'=>'f028'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f029.png','tags'=>'f029'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f031.png','tags'=>'f031'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f032.png','tags'=>'f032'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f033.png','tags'=>'f033'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f034.png','tags'=>'f034'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f035.png','tags'=>'f035'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f036.png','tags'=>'f036'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f037.png','tags'=>'f037'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f038.png','tags'=>'f038'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f039.png','tags'=>'f039'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f040.png','tags'=>'f040'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f041.png','tags'=>'f041'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f042.png','tags'=>'f042'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f043.png','tags'=>'f043'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f044.png','tags'=>'f044'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f045.png','tags'=>'f045'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f046.png','tags'=>'f046'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f047.png','tags'=>'f047'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f048.png','tags'=>'f048'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f049.png','tags'=>'f049'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f050.png','tags'=>'f050'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f051.png','tags'=>'f051'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f052.png','tags'=>'f052'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f053.png','tags'=>'f053'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f054.png','tags'=>'f054'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f055.png','tags'=>'f055'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f056.png','tags'=>'f056'),
				array('url'=>__ROOT__.'/js/jsExtend/expression/js/plugins/exp/img/f057.png','tags'=>'f057')
	
		);
		return $faces;
	}
	
	/**
	 * 获取个人信息
	 * @param unknown $param
	 */
	public function getPersonInfo($param)
	{
		$webServiceRootUrl = C('API_ACCOUNT');
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$response = $this->request($webServiceRootUrl, $crudMethod, $param);
		$response = parseApi($response);
		return $response;
	}
}
