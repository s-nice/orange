<?php
namespace Demo\Controller;

use Think\Log;
use Demo\Controller\Base\WxBaseController;

use Classes\GFunc;
import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class ConnectScannerController extends WxBaseController
{

	//get请求方式
	const METHOD_GET  = 'get';
	//post请求方式
	const METHOD_POST = 'post';
    protected $webSerivce = null;
    private $_unCallMethods = array (
            '__construct',
            '__set',
            'get',
            '__get',
            '__isset',
            '__call',
            '__destruct',
            '_initialize',
    );

    public function __construct()
    {
       parent::__construct();
        $options = array('decodeResponseMode' => \Request::DECODE_MODE_ARRAY,
                         'logger'             => 'trace',
                   );
        $this->wechatRequest =  $this->getWechatRequester()
                                     ->setOptions($options);
    }

    protected function _initialize()
    {
        $reflectionClass = new \ReflectionClass($this);
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        $hasLink = true;
        $links = '';
        foreach ($methods as $_method) {
            if (in_array(strtolower($_method->getName()), array('listener'))) {
                return;
            }
            $methodName = $_method->getName();
            if (in_array($methodName, $this->_unCallMethods)) {
                continue;
            }
            $methodComment = $_method->getDocComment(); //获取方法注释
            preg_match('/\/\*([^@]*)@/us', (string)$methodComment, $match);
            if (!$match) {
                preg_match('/\/\*(.*)\*\//us', (string)$methodComment, $match);
            }

            if (strtolower($methodName)==strtolower(ACTION_NAME)) {
                $hasLink = $hasLink && strpos($methodComment, '@noLink')===false;
            }

            if ($match && isset($match[1])) {
                $match = trim($match[1], "* \r\n");
                $match = explode("\n", $match);
                $methodComment = $methodName . '('.$match[0] . ')';
            } else {
                $methodComment = $methodName;
            }

            $links .= '<a href="'.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.$methodName).'">' . trim($methodComment, " \r\n*"). '</a>' . "<br/>\n";

        }
        return;
        if ($hasLink) {
            echo $links;
            echo '<hr/>';
        }
    }

    /**
     * 获取wechat请求实例
     * @return \WechatRequester
     */
    protected function getWechatRequester ()
    {
    	$appId     = C('Wechat.AppID');
    	$appSecret = C('Wechat.AppSecret');
    	$token     = C('Wechat.Token');
    	$requesterClient = new \Request($appId, $appSecret, $token);
    	return $requesterClient;
    }
    
    public function sendM(){
        echo 33;die;
    }

    

    
    //显示二维码的页面
    public function qrCode(){
    	$this->_weixinAuthBase('qrCode', 'Wechat');
    	if(empty($this->session['userid'])){
    		$params = array('wechatid'=> $this->session['openid']);
    		$res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
    		if(!empty($res['data']['wechats'])){
    			$userid = $res['data']['wechats'][0]['userid'];
    		}else{
    			$this->saveWxUserInfo(array('FromUserName'=>$this->session['openid']));
    			$userid = $this->session['userid'];
    		}
    		$this->session['userid'] = $userid;
    		session(MODULE_NAME,$this->session);
    	}else{
    		$userid = $this->session['userid'];
    	}
    	$this->assign('userid', $userid);//用户id
    	$this->display('qrCode');
    }
    
    public function qrCodeAdmin(){
    	$this->display('qrCode');
    }
    
    //获取生成的二维码
    public function getQrCode(){
    	include_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";//引入PHP QR库文件
    	//$value = U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/wxBindScanner', array('userid'=>$this->session['userid']), true, true, true);
    	$value = json_encode(array('userid'=>$this->session['userid'],'sourceType'=>'wechat'));
    	$errorCorrectionLevel = "L";
    	$matrixPointSize = "3";
    	$margin = 1; //参数$margin表示二维码周围边框空白区域间距值
    	\QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize,$margin);
    	exit;
    }
    
    //显示启动关联扫描仪页面
    public function startScan()
    {
    	$this->_weixinAuthInfo('startScan', 'Wechat');
    	$params = array('wechatid'=> $this->session['openid']);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
    	$scanName = '';
    	if(!empty($res['data']['wechats'])){
    		$scanName = $res['data']['wechats'][0]['scannerinfo'];
    	}
    	$this->assign('scanName', $scanName); //扫描仪名称
    	 
    	//网页调用照片
    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    	$signPackage = $jssdk->GetSignPackage();
    	$this->assign('signPackage', $signPackage);
    	$this->assign('openid',$this->session['openid']);
    	$this->assign('type',$this->getAppName());
    
    	$this->display('startScan');
    }
    
    //实时显示正在扫描的名片（仅有名片）
    public function showScanningVcard(){
    	//$cardid = I('get.cardid',''); //名片id
    	$batchid = I('get.batchid',''); //批次id
    	//$openid = 'Ua5394a5073246a0c6e6935e1885e42b7';
        $openid = $this->getOpenId('showScanningVcard', 'ConnectScanner',array('batchid'=>$batchid));
        if(IS_AJAX){
            $page = intval(I('get.page',1));
    		$cardid = I('get.cardid',0);
            $page = max($page,1);		
            $params = array();
            $params['wechatid'] = $openid;
            $params['sort'] = 'cardid asc';
            $params['start'] = 0;     
            //$params['new'] = 1;
            $params['startid'] = $cardid.','; //起始名片id
            $params['upway']   = 2;
            $params['batchid'] = $batchid;//批次id
    		$params['rows'] = $page==1?666:5;
    		$params['fields'] = 'cardid,picpatha,picpathb,picture,batchid';
    		
    		$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCardByBatch', array('params'=>$params));
    		$list = array();
    		if($res['status'] == 0){
    			if(!empty($res['data']['wechats'])){
    				$list = $res['data']['wechats'];
    			}
    		}
    		$result = array('status'=>$res['status'],'data'=>array('list'=>$list,'numfound'=>count($list),'count'=>$res['data']['count']));
    		$this->ajaxReturn($result);
    	}else{
            $share = I('get.share',0);
            $this->assign('share',$share);
    		$this->assign('openid', $openid);
    		$this->assign('batchid',$batchid);
    		$this->display('showScanningVcard');
    	}
    }

    //根据订单号查询微信支付详情
    public function getOrderDetail(){
        if(IS_AJAX){
            $orderid = I('post.orderid','');
            if($orderid){
                $openid = $this->session['openid'];
                $params['wechatid'] = $openid;
                $params['orderid'] = $orderid;
                $res = \AppTools::webService('\Model\WeChat\WeChat', 'getOrderDetail', array('params'=>$params));
                $paystatus = 1;
                if($res['status']==0){
                    $paystatus = $res['data']['status'];
                }
                $this->ajaxReturn(array('status'=>0,'paystatus'=>$paystatus));
            }
        }

    }

    //生成订单
    public function setOrder(){
        if(IS_AJAX){
            require_once WEB_ROOT_DIR . 'WxpayAPI/lib/WxPay.Api.php';
            require_once WEB_ROOT_DIR . 'WxpayAPI/example/WxPay.JsApiPay.php';
            $openId = I('post.openid','');
            $batchid = I('post.batchid','');
            //echo 333;die;
            $re = \AppTools::webService('\Model\WeChat\WeChat', 'setOrder', array('params'=>array('openid'=>$openId,'batchid'=>$batchid,'dec'=>'名片扫描','price'=>'0.01')));

            /*$input = new \WxPayUnifiedOrder();
            $input->SetBody("test");
            $input->SetAttach("test");
            $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
            $input->SetTotal_fee("1");
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag("test");
            $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $order = \WxPayApi::unifiedOrder($input);*/

            if(($re['status']==0)&&($re['data']['orderid'])){
                $order = $re['data'];
                $orderid = $order['orderid'];
                $tools = new \JsApiPay();
                $jsApiParameters = $tools->GetJsApiParameters($order);
                $this->ajaxReturn(array('status'=>0,'jsApiParameters'=>$jsApiParameters,'orderid'=>$orderid));
            }
        }
        $this->ajaxReturn(array('status'=>1,'msg'=>'支付异常'));
    }

    public function showImgCard(){
        $this->display('showScanningVcard');
    }

    
    /**
     * 显示扫描名片订单信息（支付）
     */
    public function showOrderInfo(){
    	$orderId = I('orderId','wx20170728094422da9abf795d0288186768'); //订单id
        $openid = $this->getOpenId('showOrderInfo', 'ConnectScanner',array('orderId'=>$orderId));
        if(!$orderId){
            exit('订单ID不能为空');
        }
        $params['wechatid'] = $openid;
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	$this->_weixinAuthInfo('showOrderInfo', 'ConnectScanner');
    	//网页调用照片
    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);

    	$signPackage = $jssdk->GetSignPackage();
    	$this->assign('signPackage', $signPackage);
    	$orderId  = 'fsfdsfsdf';//订单id
    	$signPackPay = $jssdk->getPaySignPackage($orderId);
    	//$signPackPay['orderId'] = $orderId;
    	$this->assign('signPackagePay',$signPackPay);  //支付包  	
    	
    	$signPackPayJssdk = $jssdk->getPaySignJssdk($orderId);
    	//$signPackPayJssdk['orderId'] = $orderId;
    	$this->assign('signJssdk',$signPackPayJssdk);  //支付包
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($signPackPayJssdk,1);exit;
    	
    	//$this->assign('info',$info);
    	$this->display('showOrderInfo');
    }
    
    /**
     * 显示扫描名片订单列表
     */
    public  function showOrderList(){
    	$openid = I('openid'); //微信id
        $params['wechatid'] = $openid;
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	$this->assign('list', $list);
    	$this->display('showOrderInfo');
    }
    
    /**
     * 根据参数生成公众号二维码显示页面,这个页面好像没有用了
     */
    public function showPublicQrCode(){
    	$this->display();
    }


    //扫描仪名称密码获取二维码页面
    public function verifyScanner(){
    	//DevTest    	Imora_Scanner_12
        if(IS_AJAX){
            $name = trim(I('post.name','')); //前端输入的扫描仪名称+密码
            $character = I('character', '1'); //默认生成永久二维码
            if($this->checkScannerPass()){
                $info = $this->getQRByName($name, $character);
                $this->ajaxReturn(array('status'=>$info['status'],'msg'=>$info['msg'],'url'=>$info['url']));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'密码错误'));
        }else{
            $cookie = cookie('Oradt_Scanner_QR_Login');
            if (!empty($cookie)) {
                $this->assign('login',$cookie);
            } else {
                $this->assign('login','');
            }
            $this->display('verifyScanner');
        }
    }

    // 扫描仪生成二维码账户登录验证
    public function verifyScannerLogin(){
        $user = I('account');
        $password = I('password');
        if ($user == C('SCANNER_QR_ADMIN') && $password == C('SCANNER_QR_ADMIN_PASSWORD')) {
            cookie('Oradt_Scanner_QR_Login', C('SCANNER_QR_ADMIN'),1800);
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }
    //验证扫描仪密码
    private function checkScannerPass(){
        $cookie = cookie('Oradt_Scanner_QR_Login');
        if (empty($cookie)) {
            return false;
        }
        return true;
    }
    //根据扫描仪名称获取二维码
    private function getQRByName($name, $character){
        $dbQr = \AppTools::webService('\Model\WeChat\WeChat', 'wechatGetQrs', array('params'=>array('device_sn'=>$name)));
        
        if ($dbQr['data']['numfound'] > 0 && !empty($dbQr['data']['data'][0]['ticket'])) {
            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.@$dbQr['data']['data'][0]['ticket'];
            return array('status'=>0,'msg'=>'','url'=>$url);
        }
        $token = $this->getAcessToken(0,'getQRByName根据扫描仪名称获取二维码');
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $scene = array();
        $scene['scene_str'] = C("SCANNER_QR_PREFIX").$name;
        $postArr = array(
            'action_name'=>'QR_LIMIT_STR_SCENE', //QR_LIMIT_STR_SCENE
            'action_info'=>array(
                'scene'=>$scene,
                ),
            );
        if ($character == '0') {
            $postArr['expire_seconds'] = 2592000;
            $postArr['action_name'] = 'QR_STR_SCENE';
        }
        $postJson = json_encode($postArr);
        $res = $this->exec($url,$postJson,'POST');

        $info = json_decode($res,true);
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." ddddddddddddd \r\n<pre>".''.var_export($info,true));
        $status = 0;
        $msg = $url = '';
        if(empty($info['ticket'])){
        	$status = $info['errcode'];
        	$msg = $info['errmsg'];
        }else{
        	$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.@$info['ticket'];
            if ($character) { // 如果是永久性的二维码，则存入数据库
                $this->saveQrToDb('scene_str',$name,$info);
            }
        }
        
        return array('status'=>$status,'msg'=>$msg,'url'=>$url);
    }
    /**
     * 存入永久性二维码
     */
    function saveQrToDb($type,$scene_value,$info){
        $params['uuid'] = explode('/q/', $info['url'])[1]; //获取返回的参数
        $params['ticket'] = $info['ticket'];
        $params['scene_type'] = 'scene_str';
        $params['scene_value'] = $scene_value;
        $params['device_type'] = '1';
        $params['device_sn'] = $scene_value;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'wechatSaveQrs', array('params'=>$params));
    }
    /**
     * 显示扫描所有的种类，名片、卡、纸张等
     */
    public  function showScanAll(){
        $batchid = I('get.batchid',''); //批次id
        $catagoryId = I('catagoryId',0);//分类id
        $page = I('get.p',1);
        $openid = $this->getOpenId('showScanAll', 'ConnectScanner',array('batchid'=>$batchid,'catagoryId'=>$catagoryId,'p'=>$page));
        $rows = 5;
        $start = ($page-1)*$rows;
        $params = array('wechatid'=>$openid);
        $params['rows'] = $rows;
        $params['start'] = $start;
        if($catagoryId){
           $params['type'] = $catagoryId;
        }
        $params['sort'] = 'createdtime desc';
        if(!$catagoryId){
            $params['sort'] = 'createdtime desc';
        }
        
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params)); //getWechatResourceAll
        //p($res);die;
        $totalPage = ceil($res['data']['numfound']/$rows);
        //echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($res,1);exit;
        $list = $res['data']['list']?$res['data']['list']:array();

        $this->assign('totalPage', $totalPage); //总记录数
        if(IS_AJAX){
            $this->ajaxReturn(array('status'=>$res['status'],'data'=>$list,'currPage'=>$totalPage,'batchid'=>$batchid));
        }else{
            $tags = array();
            $resTags = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatTags', array('params'=>array('status'=>0))); //getWechatResourceAll
            if(isset($resTags['data']['numfound'])&&($resTags['data']['numfound'])){
                $tags = $resTags['data']['list'];
            }
            $this->assign('cataSet', $tags); //分类
            $this->assign('totalPage', $totalPage); //当前页码数
            $this->assign('list', $list);
            $this->assign('batchid',$batchid);
            $this->display('showScanAll');
        }
    }

    /**
     * 任意扫 列表搜索
     */
    public  function showSweepAll(){


        $this->_authBase('showSweepAll', 'Wechat'); //微信基本授权操作

        $result = $this->_getCardList();
        $res = $result['res'];
        $keywordarr = $result['keywordarr'];
        if(IS_AJAX){
            $res = $this->fetch('listitem');
            $this->ajaxReturn($res);
        }else{
            $tags = array();
            if(I('keyword','')!='' && !empty($res)) {
                foreach ($res as $val) {
                    foreach($val['label'] as $vals){
                        if(!empty($vals) && !in_array($vals,$tags) && !in_array($vals,$keywordarr)) $tags[] = $vals;
                    }
                }
            }

            $this->assign('cataSet', $tags); //分类

            isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
            $this->assign('datanumber', $res['data']['numfound']);
            $this->assign('keyword', $result['keyword']);
            $this->assign('openid', $result['openid']);

            //网页调用照片
            if ($this->userAgent == 'weixin'){
                $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
                $signPackage = $jssdk->GetSignPackage();
                $this->assign('signPackage', $signPackage);
                $this->display('showSweepAll');
            } else {
                $this->display('showSweepAll');
            }
        }
    }

    public  function showSweepMore(){
        $batchid = I('get.batchid',''); //批次id
        $catagoryId = I('catagoryId',0);//分类id
        $page = I('get.p',1);
        $openid = $this->getOpenId('showSweepMore', 'ConnectScanner',array('batchid'=>$batchid,'catagoryId'=>$catagoryId,'p'=>$page));
        $rows = 5;
        $start = ($page-1)*$rows;
        $params = array('wechatid'=>$openid);
        $params['rows'] = $rows;
        $params['start'] = $start;
        if($catagoryId){
            $params['type'] = $catagoryId;
        }
        $params['sort'] = 'createdtime desc';
        if(!$catagoryId){
            $params['sort'] = 'createdtime desc';
        }

        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params)); //getWechatResourceAll

        $totalPage = ceil($res['data']['numfound']/$rows);

        $list = $res['data']['list']?$res['data']['list']:array();

        $this->assign('totalPage', $totalPage); //总记录数
        if(IS_AJAX){
            $this->ajaxReturn(array('status'=>$res['status'],'data'=>$list,'currPage'=>$totalPage,'batchid'=>$batchid));
        }
    }

    /**
     * 任意扫搜索列表
     */
    public function listAnySweep(){

    	$this->_authBase('listAnySweep', 'Wechat'); //微信基本授权操作
    
    	$result = $this->_getCardList();
    	$res = $result['res'];
    	if(IS_AJAX){
    		$res = $this->fetch('listitem');
    		$this->ajaxReturn($res);
    	}else{
    		isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
    		$this->assign('datanumber', $res['data']['numfound']);
    		$this->assign('keyword', $result['keyword']);
    		$this->assign('openid', $result['openid']);
    		//$this->assign('type', $type);
    	//	$this->assign('typekwds',$typekwds);
    
    		//网页调用照片
    		if ($this->userAgent == 'weixin'){
    			$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    			$signPackage = $jssdk->GetSignPackage();
    			$this->assign('signPackage', $signPackage);
    			$this->display('listAnySweep');
    		} else {
    			$this->display('listAnySweep');
    		}
    	}
    }
    public function autocompleteWord(){
        $params['kwds'] = I('post.searchword');
        $params['wechatid'] = I('openid','')?I('openid'):$this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'autocompleteM', array('params'=>$params));
        if(IS_AJAX){
            $this->ajaxReturn($res['data']['lists']);
        }else{
            return $res['data']['lists'];
        }

    }
    protected function _getCardList(){
    	$params = array();
    	$rows = 10;
    	$keyword = urldecode(I('keyword',''));//搜索关键字
        $keywordarr = explode(' ',$keyword);
    	$page = I('get.page',1);
    	$start = ($page-1)*$rows;
    	$openid = I('openid','')?I('openid'):$this->session['openid'];
    	 
    	$this->session['openid'] = $openid;
    	session(MODULE_NAME,$this->session);

    	$params['kwds'] = $keyword;
    	$openid && $params['wechatid'] = $openid;
    	//empty($keyword) && $params['sort'] = 'createdtime desc';
    	$params['rows'] = $rows;
    	$params['start'] = $start;
    
    	$logPath = C('LOG_PATH');
    	if(!is_dir($logPath)){
    		$flag = mkdir($logPath,0777,true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$logStartTime = microtime(true);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params));
    	$wechats = empty($res['data']['list'])?array():$res['data']['list'];
    	$wechatsList = $wechats;//$this->analyShowVcard($wechats,false,false);
    	if($res['status'] == 0 && $res['data']['numfound'] !=0){
    		$this->assign('list',$wechatsList);
    	}else{
    		$this->assign('list',array());
    	}
    	$totalPage = ceil($res['data']['numfound']/$rows);
    	$this->assign('totalPage', $totalPage); //总记录数
    	$this->assign('currPage', $page); //当前页码数
    	$this->assign('rows', $rows);
    	$this->assign('openid', $this->session['openid']);
    	$this->assign('sysType', $this->getAppName());
    	return array('keyword'=>$keyword,'openid'=>$openid,'res'=>$wechatsList,'keywordarr'=>$keywordarr);
    }
    
    //实时显示正在任意扫的图片
    public function realtimeScanningAll(){
        $cardid = I('get.cardid',''); //名片id
        $batchid = I('get.batchid',''); //批次id
        $openid = $this->getOpenId('realtimeScanningAll', 'ConnectScanner',array('cardid'=>$cardid,'batchid'=>$batchid));
        if(IS_AJAX){
           /* $page = I('get.page',1);
            $params = array();
            $params['wechatid'] = $openid;
            $params['sort'] = 'createdtime asc';
            $params['start'] = 0;
            $params['rows'] = $page==1?PHP_INT_MAX:5;
            $params['new'] = 1;
            $params['startid'] = $cardid; //起始名片id
            $params['upway']   = 1;*/
            //$params['fields'] = 'cardid,picpatha';
            
            //$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params));
            $params['batchid']   = $batchid;
            $params['wechatid'] = $openid;
            $params['status'] = 0;
            $params['rows'] = PHP_INT_MAX;
            $params['sort'] = 'numfound desc;type asc';
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getCardsByTag', array('params'=>$params));
            
            $list = array();
            //$newcardid = 0;
            //print_r($res);die;
            if($res['status'] == 0){
                if(!empty($res['data']['list'])){
                    $list = $res['data']['list'];
                    //krsort($list);
                    //$list = array_values($list);
                    //$newcardid = $list[0]['id'];
                }
            }
            $list = $this->dealTags($list);
            $result = array('status'=>$res['status'],'data'=>array('list'=>$list,'numfound'=>count($list)));
            $this->ajaxReturn($result);
        }else{
            $this->assign('openid', $openid);
            $this->assign('cardid', $cardid);
            $this->assign('batchid', $batchid);
            $this->display('realtimeScanningAll');
        }
    }

    //处理卡片分类数组，过滤掉numfound为0的,加入链接
    private function dealTags($list){
        $arr = array();
        foreach ($list as $key => $value) {
            if(!$value['numfound']){
                break;
            }
            $value['url'] = U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/showCardByTag', array('type'=>$value['type'],'batchid'=>$batchid), true, true, true);
            $arr[$key] = $value;
        }
        return $arr;
    }

    public function showCardByTag(){
        $batchid = I('batchid','');
        $type = I('get.type',0);
        $page = I('get.p',1);
        $openid = $this->getOpenId('showCardByTag', 'ConnectScanner',array('type'=>$type,'batchid'=>$batchid,'p'=>$page));
        $rows = 5;
        $start = ($page-1)*$rows;
        $params = array('wechatid'=>$openid);
        $params['rows'] = $rows;
        $params['start'] = $start;
        $params['type'] = $type;
        $params['sort'] = 'createdtime desc';
        $params['batchid'] = $batchid;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params)); //getWechatResourceAll
        //p($res);die;
        $totalPage = ceil($res['data']['numfound']/$rows);
        //echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($res,1);exit;
        $list = $res['data']['list']?$res['data']['list']:array();

        $this->assign('totalPage', $totalPage); //总记录数
        if(IS_AJAX){
            $this->ajaxReturn(array('status'=>$res['status'],'data'=>$list,'currPage'=>$totalPage,'batchid'=>$batchid));
        }else{
            //$tags = array();
            $tag = '';
            $resTags = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatTags', array('params'=>array('status'=>0,'id'=>$type))); //getWechatResourceAll
            if(isset($resTags['data']['list'][0]['tag'])){
                $tag = $resTags['data']['list'][0]['tag'];
            }
            $this->assign('tag', $tag); //分类
            $this->assign('type', $type); //分类
            $this->assign('totalPage', $totalPage); //当前页码数
            $this->assign('list', $list);
            $this->assign('batchid',$batchid);
            $this->display('showCardByTag');
        }
    }

    //绑定用户页面如果绑定显示已绑定，未绑定完成绑定操作
    public function bindingPhone(){
        $openid = $this->getOpenId('bindingPhone', 'ConnectScanner',array());
        $ifBind = 0;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>array('wechatid'=>$openid))); //
        //p($res);die;
        if(!empty($res['data']['wechats'][0]['accountid'])){
            $ifBind = 1;
            $mobile = $res['data']['wechats'][0]['mobile'];
            $realname = $res['data']['wechats'][0]['realname'];
            $this->assign('mobile',$mobile);
            $this->assign('realname',$realname);
        }
        //如果未绑定
        if(!$ifBind){
            //查看session中是否存有验证码发送时间
            $currentTime = time();
            $time = $this->session['sendCodeTime'];
            //echo $currentTime.'<br />'.$time;die;
            if($time&&(($currentTime-$time)<60)){
                $canSend = 0;
                $leftTime = 60-($currentTime-$time);
                //echo $leftTime;die;
                $this->assign('leftTime',$leftTime);
            }else{
                $canSend = 1;
            }
            $this->assign('canSend',$canSend);
        }
        $this->assign('ifBind',$ifBind);
        $this->display('bindingPhone');
    }
    
    public function sendCode(){
        if(IS_AJAX){
            $mobile = I('post.mobile','');
            if($mobile){
                $res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWechatSms', array('params'=>array('mobile'=>$mobile))); 
                if(!empty($res['data']['messageid'])){
                    $time = time();
                    $this->session['sendCodeTime'] = $time;
                    $this->session['messageid'] = $res['data']['messageid'];
                    session(MODULE_NAME,$this->session);
                    $this->ajaxReturn(array('status'=>0));
                }elseif($res['status']=='999020'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'橙脉中无此用户'));
                }
            }else{
                $this->ajaxReturn(array('status'=>1));
            }
        }
        $this->ajaxReturn(array('status'=>1));
    }


    //绑定提交
    public function bindPost(){
        //echo 123;die;
        if(IS_AJAX){
            $code = I('post.code','');
            $mobile = I('post.mobile','');
            if($code&&$mobile){
                $messageid = $this->session['messageid'];
                $openid = $this->session['openid'];
                $params['wechatid'] = $openid;
                $params['mobile'] = $mobile;
                $params['messageid'] = $messageid;
                $params['code'] = $code;
                $res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWechat', array('params'=>$params));
                if($res['status']=='999011'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'验证码错误'));
                }elseif($res['status']=='999004'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'绑定失败，请重新发送验证码'));
                }elseif($res['status']=='0'){
                    $this->ajaxReturn(array('status'=>0));
                }elseif($res['status']=='999005'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败，您已绑定'));
                }elseif($res['status']=='999010'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'验证码错误，请重新发送'));
                }elseif($res['status']=='999023'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败，此橙脉用户已绑定'));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1));
    }

    public function href(){
        $this->display('href');
    }





    /**
     * 新任意扫 名片列表 | 日期分组
     */
    public  function showSweepScannerCard(){
        $this->assign('menu','one');
        $params = array();
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getCardListM', array('params'=>$params));

        $paramst = array();
        $paramst['wechatid'] = $this->session['openid'];
        $datelist = \AppTools::webService('\Model\WeChat\WeChat', 'getCardDateTimeM', array('params'=>$paramst));

        $datalist = array();
        foreach($datelist['data']['list'] as $val){
            $datalist[$val['currentdate']] = array();
            foreach($res['data']['list'] as $key=>$vals){
                if($vals['currentdate'] == $val['currentdate']) array_push($datalist[$val['currentdate']],$vals);
            }
        }

        $this->assign('cardlist',$datalist);
        $this->assign('datelist',$datelist['data']['list']);

        //获取搜索历史
        $searchhistory = $this->searchHistory();
        $this->assign('historylist',$searchhistory['data']['list']);

        //$this->_authBase('showSweepScannerCard', 'ConnectScanner'); //微信基本授权操作

        $this->display('SweepScannerCard/cardlist');
    }

    /*
     * 名片列表 | 日期列表展开
     * */
    public function showSweepScannerCardList(){

    }

    //快捷方式
    public function showSweepShortCut(){
        $this->assign('menu','three');
        echo '策划中...';
    }

    /**
     * 新任意扫 分类列表
     */
    public  function showSweepScannerCardGroupList(){
        $this->assign('menu','two');
        $params = array();
        $params['wechatid'] = $this->session['openid'];
        $params['rows'] = 900000;
        $params['start'] = 0;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getSweepGroupListM', array('params'=>$params));
        $this->assign('grouplistdata',$res['data']);
        //获取搜索历史
        $searchhistory = $this->searchHistory();
        $this->assign('historylist',$searchhistory['data']['list']);

        $this->_authBase('showSweepScannerCardGroupList', 'ConnectScanner'); //微信基本授权操作

        $this->display('SweepScannerCard/grouplist');

    }

    /**
     * 新任意扫 新建分类
     */
    public  function showSweepScannerCardAddGroup(){
        $params = array();
        $params['classname'] = I('post.classname');
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'addSweepGroupM', array('params'=>$params));
        $this->ajaxReturn($res);
    }

    /**
     * 新任意扫 删除分类
     */
    public  function showSweepScannerCardDelGroup(){
        $params = array();
        $params['classid'] = json_encode(explode(',',I('post.classid')));
        $params['type'] = 'del';
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'delSweepGroupM', array('params'=>$params));
        $this->ajaxReturn($res);
    }

    /**
     * 新任意扫 分类名片列表
     */
    public  function showSweepScannerCardGroupCardList(){
        $this->assign('menu','two');
        $this->_authBase('showSweepScannerCardGroupCardList', 'ConnectScanner'); //微信基本授权操作
        $params = array();
        $params['wechatid'] = $this->session['openid'];
        $params['classid'] = I('get.gid','');
        $params['type'] = I('get.type','custom');
        $params['rows'] = 900000;
        $params['start'] = 0;
        $title = urldecode(I('get.title','名片列表'));

        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getGroupCardlistM', array('params'=>$params));

        $this->assign('cardlist',$res['data']['list']);
        $this->assign('datanumb',$res['data']['numfound']);
        $this->assign('classid',$params['classid']);
        $this->assign('title',$title);

        //文件夹列表
        $paramss['wechatid'] = $this->session['openid'];
        $paramss['rows'] = 900000;
        $paramss['start'] = 0;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getSweepGroupListM', array('params'=>$paramss));
        $this->assign('grouplist',$res['data']['custom']['list']);
        //获取搜索历史
        $searchhistory = $this->searchHistory();
        $this->assign('historylist',$searchhistory['data']['list']);

        $this->display('SweepScannerCard/groupcardlist');

    }

    /**
     * 新任意扫 删除文件
     */
    public  function showSweepScannerCardDel(){
        $params = array();
        $params['id'] = rtrim(I('post.fileid'),',');
        $params['id'] = json_encode(explode(',',$params['id']));
        $params['classid'] = I('post.cid','');
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'delSweepFileM', array('params'=>$params));
        $this->ajaxReturn($res);
    }

    /*添加到文件夹*/
    public function addToGroup(){
        $params = array();
        $params['id'] = rtrim(I('post.fileid'),',');
        $params['id'] = json_encode(explode(',',$params['id']));
        $params['classid'] = I('post.gid');
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'addToGroupM', array('params'=>$params));
        $this->ajaxReturn($res);

    }
    /*搜索结果页*/
    public function searchPage(){
        $this->assign('menu','one');
        $params = array();
        $params['rows'] = 900000;
        $params['start'] = 0;
        $params['kwds'] = urldecode(I('get.kwd',''));
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'searchM', array('params'=>$params));
        $this->assign('cardlist',$res['data']['list']);
        $this->assign('datanumb',$res['data']['numfound']);
        $this->assign('searchword',$params['kwds']);
        //获取搜索历史
        $searchhistory = $this->searchHistory();
        $this->assign('historylist',$searchhistory['data']['list']);
        //文件夹列表
        $paramss['wechatid'] = $this->session['openid'];
        $paramss['rows'] = 900000;
        $paramss['start'] = 0;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getSweepGroupListM', array('params'=>$paramss));
        $this->assign('grouplist',$res['data']['custom']['list']);

        $this->display('SweepScannerCard/searchpage');

    }
    /*搜索历史*/
    public function searchHistory($type=0){
        $params = array();
        $params['rows'] = 5;
        $params['start'] = 0;
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'searchHistoryM', array('params'=>$params));
        if($type==1){
            $this->ajaxReturn($res);
        }else{
            return $res;
        }

    }

    /*删除搜索历史*/
    public function delSearchHistory(){
        $params = array();
        $delid = I('post.id','');
        $delid!=''? $params['id'] = json_encode(explode(',',$delid)) :'';
        $params['type'] = I('post.type','custom');
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'delSearchHistoryM', array('params'=>$params));
        $this->ajaxReturn($res);
    }





}

/* EOF */
