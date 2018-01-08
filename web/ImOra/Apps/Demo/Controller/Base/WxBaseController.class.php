<?php
namespace Demo\Controller\Base;

use Think\Log;
use Classes\LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Appadmin\Controller\ProtocolController;

class WxBaseController extends SocialController{
    
	protected  $session = null; //定义session变量
    //get请求方式
    const METHOD_GET  = 'get';
    //post请求方式
    const METHOD_POST = 'post';
    public static $_APP_TYPE_WEIXIN = 1;
    public static $_APP_TYPE_LINE = 2;
    
    protected static $_INVALID_TOKEN_CODE = array('40001'=>'','41001'=>''); //token无效或缺失token参数
    
	public function __construct()
	{
		parent::__construct();
		$this->session =session(MODULE_NAME);
	}
	
	/**
	 * 把外部获取微信token的方法先转化为本地的方法
	 * @param int $flush 是否刷新缓存 0不刷新，非0刷新缓存
	 */
	public function getWxTokenToLocal($flush=0,$source='')
	{
		/* $url = C('GET_ORADT_WEIXIN_TOKEN_URL').U(MODULE_NAME.'/Wechat/getWxTokenForExternal',array('source'=>$source));
		Log::write('File:'.__FILE__.' LINE:'.__LINE__." #########@@@@@@@@@@@@@@@@@############ \r\n<pre>".''.var_export($url,true));
		$rstToken = $this->exec($url,array('flush'=>$flush,'tb'=>1));
		$rstToken = json_decode($rstToken,true);
		$this->session['access_token']   = $rstToken['access_token'];
		$this->session['expires_in']     = $rstToken['expires_in'];
		session(MODULE_NAME,$this->session);
		Log::write(' 内部通过外网获取token : '.print_r(array($this->session['access_token'],$this->session['expires_in']),1)); */
		$rstToken = getWxTokenToLocal($flush,$source);
		return $rstToken;
	}
	
	/**
	 * 网页授权回调
	 */
	protected function redirectAuth(){
		include_once 'jssdk.php';
		$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token";
		$params['appid'] = C('Wechat')['AppID'];
		$params['secret'] = C('Wechat')['AppSecret'];
		$params['code'] = I('code');
		$params['grant_type'] = 'authorization_code';
		$url .= '?'.http_build_query($params).'#wechat_redirect';
		$rst = json_decode($jssdk->httpGet($url), true);
		Log::write(' 基本授权信息 '.print_r($rst,1));
		if (!empty($rst['openid'])) {
			$wxtk = I('wxtk');
			$this->session['openid'] = $rst['openid'];
			$this->session['base_token'] = $rst['access_token'];
			$this->session['base_expires'] = $rst['expires_in'];
			$this->session['base_refresh_token'] = $rst['refresh_token'];
			session(MODULE_NAME,$this->session);
/* 			if($wxtk){
				$flush = 0;
				if(empty($this->session['access_token']) || empty($this->session['expires_in'])){
					$flush = 1;
				}
				$rstToken = $this->getWxTokenToLocal($flush,'redirectAuth网页授权回调');
				Log::write('回调请求url'.print_r(array($this->session['access_token'],$this->session['expires_in']),1));
			 }*/
			$callback = I('callback'); //要回调的方法名称
			$callback2 = I('callback2'); //要回调的参数名称
			$p = I('p'); //参数数据
			$p = urldecode($p);
			parse_str($p,$p);
			//Log::write('微信回调请求参数####'.print_r($p,1));
			$url = U("demo/$callback2/$callback",$p);
			redirect($url);
		}
	}
	
	/**
	 * 授权登录
	 */
	public function _authBase($methodName='wListZp', $controllName='Wechat',$params=array()){
	    if ($this->userAgent == 'line'){
	        $this->_lineAuthBase($methodName, $controllName, $params);
	    } else {
	        $this->_weixinAuthBase($methodName, $controllName, $params);
	    }
	}
	
    /**
     * 微信基本授权操作（仅用于获取微信openid）
     * @param $callback 授权后要回调的方法名称
     * @param $callback2 授权后要回调的controller名称
     * @param $params 授权后生成的url时，需要带的参数
     */
    protected function _weixinAuthBase($callback='wListZp', $callback2='wechat',$p=array())
    {
    	$t = I('t');
    	include_once 'jssdk.php';
    	if ((empty($this->session['openid']) ) && empty($t)){
    		$params = array();
    		$p = $p ? http_build_query($p) : '';
    		$urlCall = U(MODULE_NAME.'/Wechat/redirectAuth',array('callback'=>$callback,'callback2'=>$callback2,'p'=>$p),'',true);
    		$url = "https://open.weixin.qq.com/connect/oauth2/authorize";
    		$params['appid'] = C('Wechat')['AppID'];
    		$params['redirect_uri'] = $urlCall;//'http://dev.orayun.com/demo/wechat/redirectAuth.html';
    		$params['response_type'] = 'code';
    		$params['scope'] = 'snsapi_base';
    		$params['state'] = '123';
    		$url .= '?'.http_build_query($params).'#wechat_redirect';
    		redirect($url);
    		return;
    	}
    }
    
    /**
     * line授权及授权后跳转
     * @param $methodName 授权后要回调的方法名称
     * @param $controllName 授权后要回调的controller名称
     * @param $params 授权后生成的url时，需要带的参数
     */
    public function _lineAuthBase($methodName='wListZp', $controllName='Wechat',$params=array()){
    	if(empty($this->session['openid'])){
    	    $_SESSION[MODULE_NAME]['urlRedirect'] = U(MODULE_NAME.'/'.$controllName.'/'.$methodName, $params);;
    	    //print_r($_SESSION);die;
//     		$this->session['urlRedirect'] = U(MODULE_NAME.'/'.$controllName.'/'.$methodName, $params);
//     		session(MODULE_NAME,$this->session);
    		$line = A('Line'); //调用line授权
    		$line->login();
    		echo 222;
    		die;
    	}
    }
    
    //网页登录信息
/*     public $LOGIN_CHANEL_ID = '1529155912';
    public $LOGIN_SECRET    = 'c618e87922882eff3aa768a930a37ebf';
    public $LOGIN_REDIRECT  = 'https://linetest.oradt.com/demo/Wechat/lineRedirect'; */
/*     public $LOGIN_CHANEL_ID = '1529492355';
    public $LOGIN_SECRET    = '2eb615b3cacbeef89e3d4fe4a93cc181';
    public $LOGIN_REDIRECT  = 'https://linetest.oradt.com/Demo/Wechat/lineRedirect'; */
    public function lineRedirect(){
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__." 授权2 \r\n<pre>".'');
    	Log::write(' line授权信息 '.print_r($_GET,1));
    	
    	
    	
    	if ($_GET['errorCode']) {
    		Log::write('File:'.__FILE__.' LINE:'.__LINE__." line errorCode \r\n<pre>".''.var_export($_GET,true));
    	}
    	
    	//验证state是否匹配
    	if ($_GET['state'] != $this->session['state']) {
    		Log::write('File:'.__FILE__.' LINE:'.__LINE__." line different state code! \r\n<pre>".''.var_export($this->session,true));
    	}
    	
    	$code = $_GET['code'];
    	$token = $this->_getAccessToken($code);
    	
    	$response = $this->send_get('https://api.line.me/v2/profile', $token['access_token']);
    	$response = json_decode($response, true);
    	print_r($response);exit;
    	//###########
    	
    	
    	//出错的话
    	/* if ($_GET['errorCode']) {
    		print_r($_GET);die;
    	}
    	//验证state是否匹配
    	if ($_GET['state'] != $this->session['state']) {
    		echo 'different state code!';die;
    	}

    	$code = $_GET['code'];
    	$response = $this->_getAccessToken($code);
    	if (empty($response['access_token'])) {
    		print_r($response);die;
    	}
    	
    	log::write('File:'.__FILE__.' LINE:'.__LINE__." 授权3 \r\n<pre>".''.var_export($response,true));
    	
    	$response = $this->send_get('https://api.line.me/v2/profile', $response['access_token']);
    	$response = json_decode($response, true);
    	
    	$this->session['openid'] = $response['userId'];
    	$this->session['base_token'] = $response['access_token'];
    	session(MODULE_NAME,$this->session);
    	
    	$callback = I('callback'); //要回调的方法名称
    	$callback2 = I('callback2'); //要回调的参数名称
    	$p = I('p'); //参数数据
    	$p = urldecode($p);
    	parse_str($p,$p);
    	//Log::write('微信回调请求参数####'.print_r($p,1));
    	$url = U("demo/$callback2/$callback",$p);
    	redirect($url); */
    }
    
    public function _lineAuthBase_bak($callback='wListZp', $callback2='wechat',$p=array()){
    /* 	$chanel_id = $this->LOGIN_CHANEL_ID;
    	$p = $p ? http_build_query($p) : '';
    	$redirect_url = U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.$this->LOGIN_REDIRECT,array('callback'=>$callback,'callback2'=>$callback2,'p'=>$p));
    	$state = rand(1, 99999);
    	$this->session['state'] = $state;
    	session(MODULE_NAME,$this->session);
    	header("Location: https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={$chanel_id}&redirect_uri={$redirect_url}&state={$state}"); */
    	
    	$state = rand(1, 99999);
    	$this->session['state'] = $state;
    	session(MODULE_NAME,$this->session);
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__." 授权1 \r\n<pre>"."Location: https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={$this->LOGIN_CHANEL_ID}&redirect_uri=".urlencode($this->LOGIN_REDIRECT)."&state={$state}");
    	header("Location: https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={$this->LOGIN_CHANEL_ID}&redirect_uri=".urlencode($this->LOGIN_REDIRECT)."&state={$state}");
    }
    
    /**
     * 获取token
     * @param str $code
     */
    private function _getAccessToken($code){
    	$post_data = array(
    			'code' => $code,
    			'grant_type' => 'authorization_code',
    			'client_id' => $this->LOGIN_CHANEL_ID,
    			'client_secret' => $this->LOGIN_SECRET,
    			'redirect_uri' => $this->LOGIN_REDIRECT,
    	);
    	$response = $this->_doPost('https://api.line.me/v2/oauth/accessToken', $post_data);
    	return json_decode($response, true);
    }
    
    private function _doPost($remote_server, $post_data) {
    	$post_data = http_build_query($post_data);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $remote_server);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$data = curl_exec($ch);
    	if(empty($data)){
    		$msg = "CURL Error:".curl_error($ch);
    		curl_close($ch);
    		log::write('File:'.__FILE__.' LINE:'.__LINE__." line curl request \r\n<pre>".''.var_export($msg,true));
    	}
    	curl_close($ch);
    	return $data;
    }    
    
    public function send_get($url, $access_token) {
    	$headers = array(
    			"Authorization: Bearer $access_token",
    	);
    
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    	$data = curl_exec($curl);
    
    	if(empty($data)){
    		echo "CURL Error:".curl_error($curl);
    	}
    
    	//关闭URL请求
    	curl_close($curl);
    	//显示获得的数据
    	return $data;
    }
    
    /**************************************#########################**************************************************/
    //网页登录信息
    public $LOGIN_CHANEL_ID = '1529492355';
    public $LOGIN_SECRET    = '2eb615b3cacbeef89e3d4fe4a93cc181';
    public $LOGIN_REDIRECT  = 'https://linetest.oradt.com/demo/Wechat/loginRedirect';
    
    //回复信息
    public $MSG_CHANEL_ID    = '1529465562';
    public $MSG_SECRET       = '746de8e2836ac7d7721b557d06775ee8';
    public $MSG_ACCESS_TOKEN = 'EwBbu0gnE/6GaoLx/QNr9ZwaakSWCkC533xqB+WBSQ71qFL4K2jQVIJO9UVAaK7A4XwnJbhn9ggYwVu3Ehcfllk01Sy1FepEeBCv3CKd5ZqDPX6FK7GqEa3sJi2oc8VmkLl01YxgF/a2qi0ybrGR0gdB04t89/1O/w1cDnyilFU=';
    /**
     * 授权登录
     */
    public function login(){
    	$state = rand(1, 99999);
    	$_SESSION[MODULE_NAME]['state'] = $state;
    	header("Location: https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={$this->LOGIN_CHANEL_ID}&redirect_uri=".urlencode($this->LOGIN_REDIRECT)."&state={$state}");
    }    
    /**
     * 授权登录回调
     */
/*     public function loginRedirect(){
    	if ($_GET['errorCode']) {
    		//$this->_errorOut($_GET);
    		Log::write('File:'.__FILE__.' LINE:'.__LINE__." line errorCode \r\n<pre>".''.var_export($_GET,true));
    	}
    	 
    	//验证state是否匹配
    	if ($_GET['state'] != $_SESSION[MODULE_NAME]['state']) {
    		//$this->_errorOut('different state code!');
    		Log::write('File:'.__FILE__.' LINE:'.__LINE__." line errorCode \r\n<pre>".''.var_export('different state code!',true));
    	}
    	unset($_SESSION[MODULE_NAME]['state']);
    	 
    	$code = $_GET['code'];
    	$token = $this->_getAccessToken($code);
    	$_SESSION[MODULE_NAME]['token'] = $token;
    	 
    	$curl = new CurlHTTPClient($token['access_token']);
    	$response = $curl->get('https://api.line.me/v2/profile');
    	$response = json_decode($response->getRawBody(), true);
    	if (empty($response)) {
    		//$this->_errorOut('登录信息获取失败！');
    		Log::write('File:'.__FILE__.' LINE:'.__LINE__." line errorCode \r\n<pre>".''.var_export('登录信息获取失败！',true));
    	}
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($response);
    	 
    	$_SESSION[MODULE_NAME]['userId']      = $response['userId'];
    	$_SESSION[MODULE_NAME]['displayName'] = $response['displayName'];
    	$_SESSION[MODULE_NAME]['openid']      = $response['userId']; //为了与微信中变量名字保持一致
    } */
    
    /**
     * 微信给用户推送信息的授权操作
     * @param $callback 授权后要回调的方法名称
     * @param $callback2 授权后要回调的controller名称
     * @param $params 授权后生成的url时，需要带的参数
     */
    protected function _weixinAuthInfo($callback='wListZp', $callback2='wechat',$p=array())
    {
    	$t = I('t');
    	include_once 'jssdk.php';
    	if ((empty($this->session['access_token']) || empty($this->session['openid']) || $this->session['expires_in']-time()<=0 || $this->session['expires_in']-time()>=7200) && empty($t)){
    		Log::write('-- showUpload session 中有数据为空 或无效  $_SESSION '.var_export($this->session, 1));
    		Log::write('-- showUpload session 中有数据为空 或无##  '.var_export(array($this->session['expires_in'],time()),1));
    		$wxtk = 0;
    		if(empty($this->session['access_token']) || $this->session['expires_in']-time()<=0 || $this->session['expires_in']-time()>=7200){
    			$wxtk = 1;
    		}
    		$params = array();
    		$p = $p && join('&',$p);
    		$urlCall = U(MODULE_NAME.'/Wechat/redirectAuth',array('callback'=>$callback,'callback2'=>$callback2, 'wxtk'=>$wxtk,'p'=>$p),'',true);
    		$url = "https://open.weixin.qq.com/connect/oauth2/authorize";
    		$params['appid'] = C('Wechat')['AppID'];
    		$params['redirect_uri'] = $urlCall; //'http://dev.orayun.com/demo/wechat/redirectAuth.html';
    		$params['response_type'] = 'code';
    		$params['scope'] = 'snsapi_base';
    		$params['state'] = '123';
    		$url .= '?'.http_build_query($params).'#wechat_redirect';
    		redirect($url);
    		return;
    	}
    }
    
    /**
     * 获取要下载的app路径
     * @param string $type 要下载的类型：android 或 iso
     */
    protected function getAppName()
    {
    	$type='';
    	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    	$iphone = (strpos($agent, 'iphone')) ? true : false;
    	$ipad = (strpos($agent, 'ipad')) ? true : false;
    	$android = (strpos($agent, 'android')) ? true : false;
    	if($iphone || $ipad){//苹果设备
    		$type = 'ios';
    	}else if($android){
    		$type = 'android';
    	}else{
    		//var_dump('check telephone type fail');exit;
    		$type = 'android';
    	}
    	return $type;
    }


     /**
     * 发起一个get或post请求
     * @param $url 请求的url
     * @param int $method 请求方式
     * @param array $params 请求参数
     * @param array $extra_conf curl配置, 高级需求可以用, 如
     * $extra_conf = array(
     *    CURLOPT_HEADER => true,
     *    CURLOPT_RETURNTRANSFER = false
     * )
     * @return bool|mixed 成功返回数据，失败返回false
     * @throws Exception
     */
    public static function exec($url,  $params = array(), $method = self::METHOD_GET, $extra_conf = array())
    {
        //Log::write('-------exec $$$$$$$$$$$---- '.print_r(func_get_args(),1));
        $params = is_array($params)? http_build_query($params): $params;
        //如果是get请求，直接将参数附在url后面
        if(strtoupper($method) == strtoupper(self::METHOD_GET))
        {
            $url .= (strpos($url, '?') === false ? '?':'&') . $params;
        }

        //默认配置
        $curl_conf = array(
                CURLOPT_URL => $url,  //请求url
                CURLOPT_HEADER => false,  //不输出头信息
                CURLOPT_RETURNTRANSFER => true, //不输出返回数据
                CURLOPT_CONNECTTIMEOUT => 3, // 连接超时时间
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
        );

        //配置post请求额外需要的配置项
        if(strtoupper($method) == strtoupper(self::METHOD_POST))
        {
            //使用post方式
            $curl_conf[CURLOPT_POST] = true;
            //post参数
            $curl_conf[CURLOPT_POSTFIELDS] = $params;
        }

        //添加额外的配置
        foreach($extra_conf as $k => $v)
        {
            $curl_conf[$k] = $v;
        }

        $data = false;
        try
        {
            //初始化一个curl句柄
            $curl_handle = curl_init();
            //设置curl的配置项
            curl_setopt_array($curl_handle, $curl_conf);
            //发起请求
            $data = curl_exec($curl_handle);
            if($data === false)
            {
                throw new \Exception('CURL ERROR: ' . curl_error($curl_handle));
            }
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
        curl_close($curl_handle);

        return $data;
    }


    protected function getOpenId($action,$controller,$params=array()){
        if($this->session['openid']){
            return $this->session['openid'];
        }
        $openid = I('openid','');
        if(!$openid){
            $this->_weixinAuthBase($action,$controller,$params); //微信基本授权操作
        }else{
            $this->session['openid'] = $openid;
            session(MODULE_NAME,$this->session);
            return $openid;
        }
    }
    
    /**
     * 下载数据
     * @param array $statsList 数据源,例如：array( array('name'=>'张三','age'=>8,...))
     * @param array $headers   excel头,例如： array( 'name'=>'姓名','age'=>'年龄',...）
     * @param string $filename 文件名
     */
    protected function downloadStat (array $statsList, array $headers, $filename='Statistics',$isDownload=true,$email='')
    {
        /** Include PHPExcel */
        require_once LIB_ROOT_PATH . '3rdParty/PHPExcel/PHPExcel.php';
    
        $filename = strlen($filename) ? $filename : 'Stataistics';
    
        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();
    
        // Set document properties
        $objPHPExcel->getProperties()
        ->setCreator("Oradt ImOra")
        ->setLastModifiedBy("Oradt ImOra")
        ->setTitle("Oradt ImOra Statistics Document")
        ->setSubject("Oradt ImOra Statistics Document")
        ->setDescription("Oradt ImOra Statistics Document, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Oradt ImOra Statistics Document");
    
    
        // Add some data
        $workSheet = $objPHPExcel->setActiveSheetIndex(0);
        $startColAscii = ord('A'); // 表格起始位置ascii
        $colPos = 0;
        $rowPos = 1;
        foreach ($headers as $_v) {
            $cellName = chr($startColAscii+$colPos).$rowPos;
            $workSheet->setCellValue($cellName, $_v);
            $colPos++;
        }
        $keys = array_keys($headers);
        foreach ($statsList as $_stat) {
            $rowPos++;
            foreach ($keys as $_pos=>$_v) {
                $cellName = chr($startColAscii+$_pos).$rowPos;
                $_v = isset($_stat[$_v]) ? $_stat[$_v] : '';
                $workSheet->setCellValue($cellName, $_v.' ');
                //$workSheet->getColumnDimension($cellName)->setAutoSize(true); 
                $workSheet->getDefaultColumnDimension($cellName)->setWidth(30);
            }
        }
    
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Statistics');
    
    
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);  
        
        if($isDownload === true){
            //在浏览器中直接下载文件
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename*=utf-8\'\''.urlencode($filename).'.xlsx;');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output'); //直接下载文件
        }else{
            //保存文件到磁盘目录中
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //判断window与linux系统，处理中文名字乱码的问题
            if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
                $filename = mb_convert_encoding($filename, "GBK", "UTF-8"); //解决中文文件名乱码问题
            }
            //或$filePath = iconv('utf-8', "gb2312", $filePath);
            $objWriter->save($filename); //直接下载文件
            $data = array('email'=>$email,'filename'=>$filename);
            $res = $this->exportExecelByEmail($data);
            if($res){
               unlink($filename);
            }
            return $res;
        }       
        exit;
    }

    public function exportExecelByEmail($data){
        $email = $data['email'];
        $wechatid = $this->session['openid'];
        $nickname = $this->getWechatUserNickname($wechatid);
        $content= '&nbsp;&nbsp;';
        $content.= sprintf($this->translator->str_email_content_1, $nickname);
        $content.='<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;';
        $content.=$this->translator->str_email_content_2;
        $content.='<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;';
        $content.=$this->translator->str_email_content_3;
        $content.='<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;';
        $content.=$this->translator->str_email_content_4;
        $content.='<br/>&nbsp;&nbsp;&nbsp;&nbsp;<img width="60" hight="60" src="'.C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/imora_fuwuhao.jpg"><br/>&nbsp;&nbsp;';
        $content.=$this->translator->str_email_content_6;
        $content.='<br/><img width="60" hight="60" src="'.C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/ora.png">';
        $params = array(
                'title'   => $this->translator->str_email_content_7.date('Y-m-d',time()),
                'content' => $content,
                'fromsend' => $this->translator->str_email_content_6, //发件人姓名
                'sendurl' => $email, //收件人地址
                'enclosurename'=>$this->translator->str_email_content_7.date('Y-m-d',time()).'.xlsx',
                'wechatid'=>$wechatid,
        );
        if(!empty($data['filename'])){
            $params['enclosure'] = $data['filename'];
        }
        if(!empty($data['batchid'])){
            $params['batchid'] = $data['batchid'];
        }
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'sendExcel', array('params'=>$params));
        return $res;
    }
    
    /**
     * 生成vcard数据
     */
    public function bulidVcf($vcard,$uuid,$uid,$isReverse){
    	$arr = @json_decode($vcard, true);
    	$vcardInfo['front'] = isset($arr['front'])?$arr['front']:array();
    	$vcardInfo['back'] = isset($arr['back'])?$arr['back']:array();
    	$vcard = array();
    	foreach(array('front','back') as $v){
    		$arr = array();
    		isset($vcardInfo[$v]['name'][0]['value']) && $arr['name'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
    		isset($vcardInfo[$v]['name'][0]['value']) && $arr['fullname'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
    		isset($vcardInfo[$v]['mobile'][0]['value']) && $arr['mobilephone1'] = array('value'=> $vcardInfo[$v]['mobile'][0]['value']); // 手机
    		isset($vcardInfo[$v]['company'][0]['job'][0]['value']) && $arr['title'] = array('value'=>$vcardInfo[$v]['company'][0]['job'][0]['value'] ); // 职位
    		isset($vcardInfo[$v]['company'][0]['company_name'][0]['value']) && $arr['company'] = array('value'=>$vcardInfo[$v]['company'][0]['company_name'][0]['value']); // 公司
    		isset($vcardInfo[$v]['company'][0]['department'][0]['value']) && $arr['department'] = array('value'=>$vcardInfo[$v]['company'][0]['department'][0]['value']); // 部门
    		isset($vcardInfo[$v]['company'][0]['email'][0]['value']) && $arr['email1'] = array('value'=>$vcardInfo[$v]['company'][0]['email'][0]['value']); // 邮箱
    		isset($vcardInfo[$v]['company'][0]['address'][0]['value']) && $arr['address'] = array('value'=>$vcardInfo[$v]['company'][0]['address'][0]['value']); // 公司地址
    		isset($vcardInfo[$v]['company'][0]['web'][0]['value']) && $arr['web'] = array('value'=>$vcardInfo[$v]['company'][0]['web'][0]['value']); // 网址
    		isset($vcardInfo[$v]['company'][0]['fax'][0]['value']) && $arr['fax1'] = array('value'=>$vcardInfo[$v]['company'][0]['fax'][0]['value']); // 传真
    		isset($vcardInfo[$v]['company'][0]['telephone'][0]['value']) && $arr['officephone1'] = array('value'=>$vcardInfo[$v]['company'][0]['telephone'][0]['value']); // 电话
    		$vcard[$v] = $arr;
    	}
    	 
    	//组装名片vcf数据
    	if (!class_exists('CardOperator')) {
    		require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
    	}
    	$CardOperator = new \CardOperator();
    	// 不包含头像信息的vcf文件
        if($isReverse){
            $front = array();
            $back = $vcard['back'];
        }else{
            $front = $vcard['front'];
            $back = array();
        }
    	$vcardStr = $CardOperator->buildVcard($front,$back);
//    	$vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}.vcf";
        $filename = $isReverse?$uuid.'_':$uuid;
        $vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$filename}.vcf";
    	is_dir(C('CARD_DOWNLOAD_PATH')) || @mkdir(C('CARD_DOWNLOAD_PATH'),0777,true);
    	@file_put_contents($vcardUrl,$vcardStr);
    	 
    	// 包含头像信息的vcf文件
/*     	$photoDir = rtrim(C('CARD_DOWNLOAD_PATH'),'/').'/'.$uuid.'/';
    	is_dir($photoDir) || @mkdir($photoDir,0777,true);
    	$imgInfo = $this->getImageFromApi($uid, '/account/avatar', false);
    	if($imgInfo){
    		@file_put_contents($photoDir.$uuid.'.png',$imgInfo);
    		$vcard['front']['photo'] = array('value'=>$photoDir.$uuid.'.png');
    		$vcardStr = $CardOperator->buildVcard($vcard['front'],$vcard['back']);
    		$vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}_img.vcf";
    		@file_put_contents($vcardUrl,$vcardStr);
    	} */
    	return $vcardInfo;
    }

    /**生成单面vcard数据
     * @param $vcard
     * @param $uuid
     * @param $uid
     * @param bool $isReverse
     * @return mixed
     */
    public function bulidVcf2($vcard,$uuid,$uid,$isReverse=false){
        if (!class_exists('CardOperator')) {
            require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
        }
        $CardOperator = new \CardOperator();
        $arr = @json_decode($vcard, true);
        is_dir(C('CARD_DOWNLOAD_PATH')) || @mkdir(C('CARD_DOWNLOAD_PATH'),0777,true);
        $vcardInfo['front'] = isset($arr['front'])?$arr['front']:array();
        $vcardInfo['back'] = isset($arr['back'])?$arr['back']:array();
        $v = $isReverse?'back':'front';
        $vcard = array();
        $arr = array();
        isset($vcardInfo[$v]['name'][0]['value']) && $arr['name'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
        isset($vcardInfo[$v]['name'][0]['value']) && $arr['fullname'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
        isset($vcardInfo[$v]['mobile'][0]['value']) && $arr['mobilephone1'] = array('value'=> $vcardInfo[$v]['mobile'][0]['value']); // 手机
        isset($vcardInfo[$v]['company'][0]['job'][0]['value']) && $arr['title'] = array('value'=>$vcardInfo[$v]['company'][0]['job'][0]['value'] ); // 职位
        isset($vcardInfo[$v]['company'][0]['company_name'][0]['value']) && $arr['company'] = array('value'=>$vcardInfo[$v]['company'][0]['company_name'][0]['value']); // 公司
        isset($vcardInfo[$v]['company'][0]['department'][0]['value']) && $arr['department'] = array('value'=>$vcardInfo[$v]['company'][0]['department'][0]['value']); // 部门
        isset($vcardInfo[$v]['company'][0]['email'][0]['value']) && $arr['email1'] = array('value'=>$vcardInfo[$v]['company'][0]['email'][0]['value']); // 邮箱
        isset($vcardInfo[$v]['company'][0]['address'][0]['value']) && $arr['address'] = array('value'=>$vcardInfo[$v]['company'][0]['address'][0]['value']); // 公司地址
        isset($vcardInfo[$v]['company'][0]['web'][0]['value']) && $arr['web'] = array('value'=>$vcardInfo[$v]['company'][0]['web'][0]['value']); // 网址
        isset($vcardInfo[$v]['company'][0]['fax'][0]['value']) && $arr['fax1'] = array('value'=>$vcardInfo[$v]['company'][0]['fax'][0]['value']); // 传真
        isset($vcardInfo[$v]['company'][0]['telephone'][0]['value']) && $arr['officephone1'] = array('value'=>$vcardInfo[$v]['company'][0]['telephone'][0]['value']); // 电话
        $vcard = $arr;
        $vcardStr = $CardOperator->buildOneVcard($vcard);
        $filename = $isReverse?$uuid.'_':$uuid;
        $vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$filename}.vcf";
        @file_put_contents($vcardUrl,$vcardStr);
        return $vcardInfo;
    }
    /**
     * 获取图片
     */
    Public function getImageFromApi($imagePath, $apiurl, $echoImageOrNot = false)
    {
    	$imgurl = base64_encode($imagePath);
    	$imagePath = urldecode($imagePath);
    	$imageBinary = \AppTools::webService('\Model\WebService','getImageFromApi',array('imagePath'=>$imagePath,'apiurl'=>$apiurl));
    
    	if(strlen($imagePath) == 40){
    		$contentType='image/png';
    	} else {
    		$extName = strtolower(array_pop(explode('.', $imagePath)));
    		switch ($extName) {
    			case 'png':
    			case 'gif':
    			case 'jpg':
    				$contentType = 'image/' . $extName;
    				break;
    
    			case 'bmp':
    				$contentType = 'image/vnd.wap.wbmp';
    				break;
    
    			default:
    				break;
    		}
    	}
    
    	if(strlen($imageBinary)>100){
    		if ($echoImageOrNot) {
    			header('Content-type: ' . $contentType);
    			echo $imageBinary;
    
    			return true;
    		}
    
    		return $imageBinary;
    
    	} else {
    		return false;
    	}
    }

    /** 批量curl请求
     *  @param $url_arr=array(array('url'=>'www.baidu.com','data1'),array('url'=>'www.baidu.com',''));
     *  @param $method post or get
     */
    public function curlMulti($url_arr,$method,$timeOut = 5)
    {
        $mh = curl_multi_init();
        foreach ($url_arr as $i => $url)
        {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url['url']);
            if ((!empty($url['data'])) && ($method == 'post')) {
                curl_setopt($ch, CURLOPT_POST, 1);
                if (is_array($url['data']) && count($url['data']) > 0)   
                {  
                    curl_setopt($ch, CURLOPT_POST, count($url['data']));                  
                }  
                curl_setopt($ch, CURLOPT_POSTFIELDS, $url['data']);
            }
            if ($method == 'get') {
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_NOBODY, 0);
            } else if($method == 'post') {
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0");  
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut);// 超时 
            }
               
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_multi_add_handle($mh, $ch);
            $handleArr[$i] = $ch;
        }

        $running = 0;
        do {   
            curl_multi_exec($mh,$running);   
        } while($running > 0);

        $res = array();
        foreach($handleArr as $key => $url)
        {
            $res[$key] = curl_multi_getcontent($url);
        }

        foreach($handleArr as $key => $url)
        {
            curl_multi_remove_handle($mh, $handleArr[$key]); 
        }
        curl_multi_close($mh);
        return $res;
    }

    
    /**
     * POST请求
     * @param str $url
     * @param arr $post_data
     * @return arr
     */
    protected  function _post($url, $post_data){
    	$post_data = json_encode($post_data);
    	$url = C('NEWPAGE_API').$url;
    	Log::write("START--Wechat demo $url with params $post_data", 'INFO');
    
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    
    	$output = curl_exec($ch);
    	//echo $output;die;
    	Log::write("CONTENT--$output", 'INFO');
    	$arr = json_decode($output, true);
    	curl_close($ch);
    	Log::write("END--Wechat demo $url with params $post_data", 'INFO');
    	if (empty($arr)) {
    		echo '无法解析JSON数据';
    		echo $output;die;
    	}
    	return $arr;
    }

    
    protected function getAcessToken($flush=0,$source=''){
        $rstToken = $this->getWxTokenToLocal($flush,$source);
        return $rstToken['access_token'];
    }
    
    /**
     * 解析名片数据用于显示
     * @param array $list 列表数据
     * @param bool $showBack 是否解析名片反面数据
     * @param bool $isJson 是否解析vcard数据
     */
    public function analyShowVcard($list,$showBack=false,$isJson=true)
    {// vcardid=16452
    if($list){
    	foreach ($list as $key=>$val){
    		unset($list[$key]['ENG'],$list[$key]['DEPT'],$list[$key]['FN'],$list[$key]['TITLE'],$list[$key]['ORG'],$list[$key]['ADR'],$list[$key]['CELL'],$list[$key]['TEL'],$list[$key]['URL'],$list[$key]['EMAIL']);
    		$vcard = $val['vcard'] ? json_decode($val['vcard'],true) : array();

    		if(empty($val['vcard']) || (empty($vcard['front']) && empty($vcard['back']))){
    			continue;
    		}
    		//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($vcard,1);exit;
    		$front = $vcard['front']; //名片正面数据
    		$list[$key]['front'] = $this->_getVcardSingleData($front);
    		$back = array();
    		if($showBack==true && !empty($vcard['back'])){ //名片反面数据
    			$back = $this->_getVcardSingleData($vcard['back']);
    		}
    		$list[$key]['back'] = $back;
    	}
    }
    return $list;
    }
    /**
     * 解析名片单面数据,单独解析名片正面数据或反面数据，根据传递的数据源来决定
     * @param array $oneSideData 名片单面的数据
     * @return multitype:unknown multitype: multitype:unknown
     */
    public function _getVcardSingleData($oneSideData)
    {
    	$rst = array();
    	$ENG = $DEPT = $FN = $ORG = $ADR = $CELL = $TEL = $URL = $TITLE = $EMAIL = array();
    	$FN = $this->_getVcardValue($oneSideData,'name'); //人名
        $ENG = $this->_getVcardValue($oneSideData,'name', true); //人名
    	$TEL = $this->_getVcardValue($oneSideData,'mobile'); //手机
    	if(!empty($oneSideData['company'])){
    		foreach ($oneSideData['company'] as $company){
    			$ORG = $this->_getVcardValue($company,'company_name'); //公司名称
    			$ORG_ENG = $this->_getVcardValue($company,'company_name',true); //公司英文名
    			$ADR = $this->_getVcardValue($company,'address'); //地址
    			$ADR_ENG = $this->_getVcardValue($company,'address',true); //地址英文名
    			$CELL = $this->_getVcardValue($company,'telephone'); //电话
    			$URL = $this->_getVcardValue($company,'web'); //网址
    			$JOB = $this->_getVcardValue($company,'job'); //职位
    			$JOB_ENG = $this->_getVcardValue($company,'job',true); //职位英文名
    			$EMAIL = $this->_getVcardValue($company,'email'); //邮箱
                $DEPT = $this->_getVcardValue($company,'department'); //部门
                $DEPT_ENG = $this->_getVcardValue($company,'department',true); //部门英文名
    		}
    	}
    	$rst = array('FN' => $FN, //中文名字
                'ENG' => $ENG, //英文名字
    			'ORG' => $ORG,
    			'ADR' => $ADR,
    			'CELL' => $CELL,
    			'TEL' => $TEL,
    			'URL' => $URL,
    			'JOB' => $JOB,
    			'EMAIL' => $EMAIL,
                'DEPT' => $DEPT,
    			'ORG_ENG' => $ORG_ENG,
    			'ADR_ENG' => $ADR_ENG,
    			'JOB_ENG' => $JOB_ENG,
    			'DEPT_ENG' => $DEPT_ENG
    	);
    	//var_dump($rst);
    	return $rst;
    }
    
    /**
     * 获取名片json字符串中的value
     * param $dataSet 数据数组
     * param $jsonName 数据健名
     */
    public function _getVcardValue($dataSet,$jsonName, $englishname = false)
    {
    	$arrEng = array('name','job','department','company_name','address');
    	$rst = array();
    	if(isset($dataSet[$jsonName])){
    		foreach ($dataSet[$jsonName] as $dataElement){
               if (in_array($jsonName, $arrEng)) { //区分中英文
                    if($englishname) {
                        if ($dataElement['is_chinese'] == '0') { //英文
                            $rst[] = $dataElement['value'];
                        }
                    }else{
                        if (!isset($dataElement['is_chinese']) || $dataElement['is_chinese'] == '1') { //中文
                            $rst[] = $dataElement['value'];
                        }
                    }
                } else {
                    $rst[] = $dataElement['value'];
                }
    		}
    	}
    	return $rst;
    }

    /**
     * 根据微信的openid获取微信昵称
     *
     */
    protected function getWechatUserNickname($openid)
    {
        $params = array('wechatid'=> $openid);
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
        if(!empty($res['data']['wechats'])){
            $wechats = $res['data']['wechats'][0];
            $wxInfo = json_decode($wechats['wechatinfo'],true);
            return $wxInfo['nickname']; 
        }
        return "用户";
    }
    
    /**
     * 同步返回信息到微信客户端
     * @param string $xml
     * @param string $type sub:正常关注或者通过扫描仪关注,biz:通过企业二维码关注
     */
    protected function synchRtnMsgToWxClient($xml,$type='sub',$bizId=''){
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__." 同步推送给微信消息: \r\n<pre>".''.var_export(func_get_args(),true));
    	//推送关注消息
    	$time = time();
    	$msg = "<xml>
	    	<ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
	    	<FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
	    	<CreateTime>{$time}</CreateTime>
	    	<MsgType><![CDATA[text]]></MsgType>
	    	<Content><![CDATA[%s]]></Content>
    	</xml>";
    	//正常关注或者通过扫描仪关注入口
    	if($type == 'sub'){
    	   $keyword = "欢迎使用橙子名片识别服务!
☞ 拍       照 ：单张名片识别
    ☞ 扫       描 ：批量名片识别
☞ 一键导出：导出所有名片
☞ 名片搜索：语音模糊查找
☞ 我的名片：您的专属名片
☞ 人脉360：人脉关系透视
☞ 橙       橙：加好友更好服务您";
    	}else if($type == 'biz'){ //通过扫描企业二维码入口    	
    		$openid = $xml['FromUserName'];
    		$params = array('wechatid'=> $openid);
    		$res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
    		if(empty($res['data']['wechats']) || empty($res['data']['wechats'][0]['bizid'])){
    			if(empty($res['data']['wechats'])){
    				$baseToken = $this->getAcessToken(1,'saveWxUserInfoAgain保存用户基本信息到api中');
    				$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$baseToken}&openid={$openid}&lang=zh_CN";
    				
    				include_once 'jssdk.php';
    				$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    				$rst = json_decode($jssdk->httpGet($url),true);
    				$this->getWxUserInfoSave($xml, $openid, $rst); //保存微信用户信息到表中并推送消息给微信
    			}
    			$urlShowUpload = C('GET_ORADT_WEIXIN_TOKEN_URL').'/demo/CompanyExtend/bindEmployPage/bizId/'.$bizId.'/openid/'.$xml['FromUserName'];
    			$keyword = "<a href='$urlShowUpload'>员工绑定企业</a>";
    		}else{//已经绑定企业
    			$bizInfo = $this->getBizInfoByXId($bizId);
    			if( $bizInfo){
    				$bizName = $bizInfo['bizname'];
    				$bindedId = $res['data']['wechats'][0]['bizid'];
    				if($bizInfo['bizid'] == $bindedId){
    					$keyword = "你已经绑定企业:{$bizName},无需重复绑定";
    				}else{
    					$bInfo = $this->getBizInfoByXId($bindedId);
    					$bName = $bInfo['bizname'];
    					$urlShowUpload = C('GET_ORADT_WEIXIN_TOKEN_URL').'/demo/CompanyExtend/unbindEnt/bizId/'.$bizId.'/openid/'.$xml['FromUserName'].'/bindedId/'.$bindedId;
    					$keyword = "你已经绑定企业:{$bName}
点击<a href='$urlShowUpload'>立即解绑</a>";
    				}
    			}
    		}
        }
        echo sprintf($msg, $keyword);
    }
    
    /**
     * 根据id获取企业信息
     * @param mixed $id 企业id，既可以是整形id,也可以是字符串类型id
     */
    public function getBizInfoByXId($id){
    	$key = is_numeric($id)?'id':'bizid'; //根据传递的值类型自动判断查询传递的属性及值
    	$params = array($key=>$id);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getEntInfo', array('params'=>$params));
    	if($res['status'] == 0 && !empty($res['data']['list'])){
    		return $res['data']['list'][0];
    	}else{
    		return null;
    	}
    }
    
    /**
     * 获取场景二维码value值数组
     * @param unknown $key
     * @param string $seperator
     */
/*     public function getWxQrCodeArr($eventKey,$seperator=null){
    	$seperator = is_null($seperator)?substr(C('COMPANY_QR_PREFIX'),-3):$seperator;
    	$msgBody = str_replace('qrscene_', '', $eventKey); //企业id
    	$msgBodyArr = explode($seperator, $msgBody);
    	return $msgBodyArr;
    } */
    
	/**
	 * 开启微信消息代理到某个服务器
	 * @param string $proxyHost  要接受消息的服务器,例如：zp的为http://192.168.71.24 
	 * @param string $openid 要代理的微信openid,默认不传递代理所有微信用户，或者可以,分割传递多个微信openid
	 */
    public function openWxProxy($proxyHost='',$openid=null){
    	 if(!$proxyHost){
    	 	return true;
    	 }
    	 $arr = get_headers($proxyHost);
    	 //Log::write('File:'.__FILE__.' LINE:'.__LINE__."%%%%%%%%%%%:$proxyHost \r\n<pre>".''.preg_match('/200|302/',$arr[0]).var_export($arr,true));
    	 if(!preg_match('/(200)|(302)/',$arr[0])){
    	 	return false;
    	 }
    	 Log::write(' 进入代理模式判断处理--->公众号接收到的xml格式：'.$GLOBALS['HTTP_RAW_POST_DATA']);
    	 if(!empty($openid)){
    	 	$xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
    	 	if(in_array($xml['FromUserName'], $openid)){
    	 		$this->_startWxProxy($proxyHost,$xml['FromUserName']);
    	 	}
    	 }else{
    	 	$this->_startWxProxy($proxyHost);
    	 }
		
    }
    //代理发送具体操作
    private function _startWxProxy($proxyHost,$openid='All'){
    	$startTime = microtime(true); //开始时间
    	include_once 'jssdk.php';
    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    	$url = $proxyHost.'/demo/wechat/listener'; //代理地址中实际接收处理数据的服务器url路径
    	$header[] = "Content-type: text/xml";//定义content-type为xml
    	$header[] = "HTTP_USER_AGENT: ORADT-wx-test";
    	$rst = $jssdk->_curl($url, 'POST',$header,$GLOBALS['HTTP_RAW_POST_DATA']);
    	$endTime = microtime(true); //结束时间
    	$timeInterval = $endTime-$startTime;
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__."开启代理模式,代理地址:{$proxyHost},执行时间:{$timeInterval} 用户:{$openid}> \r\n<pre>".''.var_export($rst,true));
    	echo $rst;exit;
    }
    
    /**
     * 输出信息给微信客户端
     */
    public function printMsgToWxConsole($msgBody=array(),$exit=true)
    {
    	$type = $msgBody['type'];
    	$time = time();
    	switch ($type){
    		case 'text':
    			$keyword = $msgBody['content'];
    			$msg = "<xml>
	    			<ToUserName><![CDATA[{$msgBody['receiverId']}]]></ToUserName>
	    			<FromUserName><![CDATA[{$msgBody['senderId']}]]></FromUserName>
	    			<CreateTime>{$time}</CreateTime>
	    			<MsgType><![CDATA[text]]></MsgType>
	    			<Content><![CDATA[%s]]></Content>
    			</xml>";
    			echo sprintf($msg, $keyword);
    			break;
    		case 'image':
    			break;
    		default:
    	}
    	if($exit){
    		exit();
    	}
    }
}
/* EOF */
