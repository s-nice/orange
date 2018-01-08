<?php
namespace Demo\Controller;

use Think\Log;
use Classes\GFunc;
use Demo\Controller\Base\WxBaseController;

import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class WechatController extends WxBaseController
{
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
        $this->session =session(MODULE_NAME);
        $options = array('decodeResponseMode' => \Request::DECODE_MODE_ARRAY,
                         'logger'             => 'trace',
                   );
        $this->wechatRequest =  $this->getWechatRequester()
                                     ->setOptions($options);
    }

    protected function _initialize()
    {
/*         $reflectionClass = new \ReflectionClass($this);
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
            $methodComment = $_method->getDocComment();
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
        } */
    }

    public function listener ()
    {
    	if (isset($_GET['echostr'])) {
    		echo $_GET['echostr'];
    		exit;
    	}
		//$this->runUseProxy(); //以代理模式代理到本地    	
        $xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
        Log::write(' 公众号接收到的xml格式：'.json_encode($xml));
        //$this->msgFromWxTest($xml);
        
        switch ($xml['MsgType']) {
        	case 'voice':
        	case 'text':
        		$this->fromWxMassage($xml);
        		break;
        	case 'image'://入口暂时拿掉了,暂时不用了
        		//$this->fromWxMsgImage($xml);
        		break;
        	case 'event':
        		if($xml['Event'] == 'subscribe'){//用户关注公众号事件
        			$this->bindScannerNew($xml); //注意这两个方法先后顺序，新流程  //$this->bindScanner($xml); //注意这两个方法先后顺序，老的流程
        		}else if($xml['Event'] == 'unsubscribe'){//取消关注事件
        			$this->_addUnsubscribeLog($xml['FromUserName']);
        			$status = $this->_pushInfoToAndroid($xml['FromUserName'],5,$xml['CreateTime'],'weixin');
        		}else if($xml['Event'] == 'SCAN'){//扫描事件
        			$this->bindScannerNew($xml);   //新的流程  //$this->bindScanner($xml); //老的流程
        		}else if($xml['Event'] == 'CLICK'){//自定义菜单点击事件
        			if($xml['EventKey'] == 'rselfmenu_0_2'){//开始任意扫
        				$status = $this->_pushInfoToAndroid($xml['FromUserName'],6,$xml['CreateTime'],'weixin');
        			}
        		}elseif($xml['Event'] == 'WifiConnected'){
        			$this->WifiConnected($xml);
        		}
        		break;        	
        	default:
        }
    }
    
/*     public function msgFromWxTest($xml)
    {
    	if(isset($xml['EventKey']) && in_array(str_replace(C('SCANNER_QRS_PREFIX'),'',$xml['EventKey']),array('iX500-A0WB0089968996','iX500-A0WB0090069006'))){
    		$xml['EventKey'] = str_replace(C('SCANNER_QRS_PREFIX'),'',$xml['EventKey']);
    		if(isset($xml['Event']) && $xml['Event'] == 'subscribe'){//用户关注公众号事件
    			$this->saveWxUserInfo($xml);
    			$this->bindScannerNew($xml); //注意这两个方法先后顺序
    		}else if($xml['Event'] == 'SCAN'){//扫描事件
    			$this->bindScannerNew($xml);
    		}
    		exit;
    	}else{
    		return true;
    	}
    } */


    //取消关注后添加日志记录
    private function _addUnsubscribeLog($openid){
        $params['open_id'] = $openid;
        $params['app_id'] = C('Wechat.AppID');
        \AppTools::webService('\Model\WeChat\WeChat', 'addUnsubscribeLog', array('params'=>$params));
    }
    
    public function runUseProxy()
    {
    	//开发调试时推送消息使用
    	if(C('WX_DEBUG_PROXY.PROXY_MSG') && strtolower(substr(PHP_OS, 0, 3)) != 'win'){
    		$this->openWxProxy(C('WX_DEBUG_PROXY.PROXY_ADDRESS'), C('WX_DEBUG_PROXY.USER_OPENID')); //代理模式参数
    	}
    }

    private function WifiConnected($xml){
    	$time = time();
        $msg = "<xml>
            <ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
            <CreateTime>{$time}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
            $keyword = "wifi连接成功";
            echo sprintf($msg, $keyword);
    }

    function _log($data, $type='INFO'){
    	$filename = 'logfile.txt';
    	if (is_array($data)){
    		$data = json_encode($data);
    	}
    	file_put_contents($filename, "$type--".$data."\r\n", FILE_APPEND);
    }
    
    //扫描后绑定扫描仪
    public function bindScannerNew($xml){
    	$this->saveWxUserInfo($xml); //保存微信用户信息
    	$scannerInfo = '';
    	if($xml['Event'] == 'subscribe'){
    		if(substr($xml['EventKey'],0,8) == 'qrscene_' ){ //场景二维码前缀
    			$scannerInfo = str_replace('qrscene_', '', $xml['EventKey']);
    		}
    	}else if($xml['Event'] == 'SCAN'){
    		$scannerInfo = $xml['EventKey'];
    	}
    	if($scannerInfo){
    		$this->saveScanInfo($scannerInfo,$xml['FromUserName'],$xml['CreateTime'],'weixin',$xml);
    	}
    }
    
    //保存绑定的扫描仪/企业ID信息,old
    public function saveScanInfo($scannerJsonInfo,$openid='',$time,$publicType,$xml){
    	Log::write('-------##绑定信息到微信用户输出: '.__FILE__.__LINE__.var_export(func_get_args(),true));
    	if(substr($scannerJsonInfo, 0,strlen(C('COMPANY_QR_PREFIX'))) == C('COMPANY_QR_PREFIX')){//带有企业ID参数
    		$bizId = str_replace(C('COMPANY_QR_PREFIX'), '', $scannerJsonInfo);
    		$params = array('wechatid'=> $openid, 'bizid'=> $bizId);
    		$this->synchRtnMsgToWxClient($xml,'biz',$params['bizid']);
    	}else{
    		$scannerDeviceId = str_replace(array(C('SCANNER_QR_PREFIX'),C('SCANNER_QRS_PREFIX'),C('COMPANY_QR_PREFIX')), '', $xml['EventKey']);
    		$scannerDeviceId = str_replace('qrscene_', '', $scannerDeviceId);
    		if(substr($scannerJsonInfo, 0,strlen(C('SCANNER_QRS_PREFIX'))) == C('SCANNER_QRS_PREFIX')){//新的流程
    			//Log::write('-------##new_111111111_绑定信息到微信用户输出: '.__FILE__.__LINE__.var_export(func_get_args(),true));
    			$params = array('wechatid'=> $openid, 'scannerid'=> $scannerDeviceId,'client_type'=>'wechat');
    			$res = \AppTools::webService('\Model\WeChat\WeChat', 'bindScannerInfo', array('params'=>$params));
    			if($res['status'] == '999033'){
    				$msgBody = array('type'=>'text', 'receiverId'=>$openid, 'senderId'=>$xml['ToUserName'],'content'=>'扫描仪正在被其他用户占用，请稍后再用');
    				$this->printMsgToWxConsole($msgBody);
    			}else if($res['status'] == '999038'){
    				$msgBody = array('type'=>'text', 'receiverId'=>$openid, 'senderId'=>$xml['ToUserName'],'content'=>'网络异常，扫描仪未连接成功');
    				$this->printMsgToWxConsole($msgBody);
    			}
    		}else/*  if(substr($scannerJsonInfo, 0,strlen(C('COMPANY_QR_PREFIX'))) == C('COMPANY_QR_PREFIX')) */{//老的流程
    			//Log::write('-------##old_222222222_绑定信息到微信用户输出: '.__FILE__.__LINE__.var_export(func_get_args(),true));
    			$params = array('wechatid'=> $openid, 'scannerinfo'=> $scannerDeviceId);
    			$res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWxUserInfo', array('params'=>$params));
    			if($res['status'] == 0 && !isset($params['bizid'])){
    				$this->_pushInfoToAndroid($openid, 1, $time, $publicType);
    			}
    			$res = \AppTools::webService('\Model\WeChat\WeChat', 'getPushHistory', array('params'=>array('deviceid'=>$scannerDeviceId,'isread'=>0,'sort'=>'datetime asc','rows'=>1)));
    			if($res['status'] == 0 && $res['data']['list']){
    				if($res['status']['list'][0]['datetime']+300000<microtime(true)){
	    				$msgBody = array('type'=>'text', 'receiverId'=>$openid, 'senderId'=>$xml['ToUserName'],'content'=>'网络异常，扫描仪未连接成功');
	    				$this->printMsgToWxConsole($msgBody);
    				}
    			}
    		}
    	}
    }

    public function redirectAuth()
    {
    	parent::redirectAuth();
    }

    /**
     * 用户向微信发送图片（例如：微信自定义菜单上传图片）
     * @param unknown $xml
     */
    public function fromWxMsgImage($xml){
        $time = time();
        $url  = $xml['PicUrl'];

        //文字消息
        $msg = "<xml>
            <ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
            <CreateTime>{$time}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>
        ";

        //图文消息
        $news = "<xml>
            <ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
            <CreateTime>{$time}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>1</ArticleCount>
            <Articles>
            <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>
            </Articles>
            </xml>
        ";

        $filepath = C('TMP_IMG_SAVE_PATH');
        if (!is_dir($filepath)){
            $flag = mkdir($filepath, 0777, true);
            if($flag == false){
            	Log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
            }
        }
        $filename = $filepath.md5($url).'.jpg';
        file_put_contents($filename, file_get_contents($url));
        //GFunc::delImgOrientation($filename);

        $params['picture'] = $filename;
        $params['wechatid'] = $xml['FromUserName'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'wechatSave', array('params'=>$params));

        if ($res['status']!=0) {
            echo sprintf($msg, '上传失败，请稍后再试');
            unlink($filename);//删除临时图片文件
            return;
        }

        $params = array();
        $params['cardid'] = $res['data']['cardid'];
        $params['wechatid'] = $xml['FromUserName'];
        //$params['fields'] = 'cardid, FN, ORG';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        //Log::write('88888'.json_encode($res));
        $list = $this->analyShowVcard($res['data']['wechats']);
        $info = $list[0];
        if (empty($info)) {
            echo sprintf($msg, '数据添加失败');
            unlink($filename);//删除临时图片文件
            return;
        }
        $companyArr = $info['front']['ORG'];
        $name = $info['front']['FN'];
        $news = sprintf($news, "$name[0]",@$companyArr[0], $info['picture'], U(MODULE_NAME.'/'.CONTROLLER_NAME.'/wDetailZp', array("cardid"=>$info['cardid']), false, true));
        //Log::write('789789'.$news);
        is_file($filename) && unlink($filename);//删除临时图片文件
        echo $news;
    }

    
    /**
     * 从微信获取并保存用户基本信息到api中
     */
    public function saveWxUserInfo($xml=''){
    	$baseToken = $this->getAcessToken(0,'saveWxUserInfo');
    	$openid    = $xml['FromUserName'];
    	$params = array('baseToken'=>$baseToken,'openid'=>$openid);
    	$rst = \AppTools::webService('\Model\WeChat\WeixinInterface', 'getUserInfo', array('params'=>$params));
    	//Log::write('File:'.__FILE__.' LINE:'.__LINE__." 结果： \r\n<pre>".''.var_export(array($params,$rst),true));
    	if(isset($rst['subscribe']) && $rst['subscribe'] == '1'){
			$this->getWxUserInfoSave($xml, $openid, $rst); //保存微信用户信息到表中并推送消息给微信
    	}
    }   
    /**
     * 获取微信用户消息并保存
     */
    public function getWxUserInfoSave($xml,$openid,$rst){
    	//Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取微信用户信息并保存 \r\n<pre>".''.var_export(func_get_args(),true));
    	$params = array('wechatid'=> $openid, 'info'=> json_encode($rst));
    	$bizId = '';
    	$scannerJsonInfo = $xml['EventKey'];
    	$scannerJsonInfo = str_replace('qrscene_', '', $scannerJsonInfo);
    	if(substr($scannerJsonInfo, 0,strlen(C('COMPANY_QR_PREFIX'))) == C('COMPANY_QR_PREFIX')){//带有企业ID参数
    		$bizId = str_replace(C('COMPANY_QR_PREFIX'), '', $scannerJsonInfo);
    	}
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWxUserInfo', array('params'=>$params));
    	if($res['status'] != 0){//绑定信息失败
    		Log::write('api绑定微信信息失败:'.print_r($res,1));
    	}else{
    		$this->session['userid'] = $res['data']['userid'];
    		session(MODULE_NAME,$this->session);
    	}
    	if($xml['Event'] == 'subscribe'){
    		$type = $bizId?'biz':'sub';//sub:正常关注或者通过扫描仪关注,biz:通过企业二维码关注
    		$this->synchRtnMsgToWxClient($xml,$type,$bizId);
    	}
    }
    
    /**
     * 获取微信token给外部使用
     */
    public function getWxTokenForExternal()
    {
    	$flag = (bool)I('get.flush',false); //是否刷新token，默认不刷新
    	$logPath = C('LOG_PATH');
    	if(!is_dir($logPath)){
    		mkdir($logPath,0777,true);
    	}
    	$logPath .= 'wx_token_'.date('y_m_d').'.log';
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'外部通过http获取微信token: '.var_export($_GET,true), Log::INFO,'',$logPath);
    	if(C('WX_TOKEN_SAVE_MODE') == 'redis'){
    		$rstToken = GFunc::getCustomMessageTokenFromRedis(C('Wechat')['AppID'], C('Wechat')['AppSecret'],7200,$flag);
    	}else{
    		$rstToken = GFunc::getCustomMessageToken(C('Wechat')['AppID'], C('Wechat')['AppSecret'],7200,$flag);
    	}    	
    	echo json_encode(array('access_token'=>$rstToken['access_token'], 'expires_in'=>$rstToken['expires_in']));
    }
    

    /**
     * 网页保存图片
     */
    public function saveImage(){
        $data = base64_decode(str_replace('data:image/jgp;base64,', '', I('data')));
        $filepath = C('TMP_IMG_SAVE_PATH');
        if (!is_dir($filepath)){
            $flag = mkdir($filepath, 0777, true);
            if($flag == false){
            	log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
            }
        }
       // $rstToken = $this->getWxTokenToLocal(0,'showUpload显示上传名片页面');
        $filename = $filepath.md5($data).'.jpg';
        file_put_contents($filename, $data);
        $openid = $this->session['openid']?$this->session['openid']:I('openid');
        Log::write('-------上传图片  vcard start  '.$openid);
        $params['isself']    = I('get.isself',0);
        $params['picpatha'] = $filename;
        $params['wechatid'] = $openid;
        $timeStart = microtime(true);
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'wechatSave2', array('params'=>$params));
        $timeEnd = microtime(true);
        Log::write('-------上传图片 单面 API耗费时间: '.($timeEnd-$timeStart));
        $res['status'] != 0 && Log::write('-------上传图片  vcard1API返回数据 '.var_export($res,1));
        unlink($filename);        
        $this->sendMsg($openid,$res);
        $res['status']==999021 && $res['msg'] = 'OCR识别不成功，请检查名片拍摄方向是否正确';
        echo json_encode($res);
    }
    /**
     * 网页保存图片
     */
    public function saveImage2(){
    	$filepath = C('TMP_IMG_SAVE_PATH');
    	if (!is_dir($filepath)){
    		$flag = mkdir($filepath, 0777, true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$params = array();
    	
    	$pica = base64_decode(str_replace('data:image/jgp;base64,', '', I('pica'))); //正面
    	$picbData = I('picb');
    	if($picbData){
    		$picb =  base64_decode(str_replace('data:image/jgp;base64,', '', $picbData)); //反面
    		$filename = $filepath.md5($picb).'.jpg';
    		file_put_contents($filename, $picb);
    		$params['picpathb'] = $filename;
    	}

    	$filename = $filepath.md5($pica).'.jpg';
    	file_put_contents($filename, $pica);
    	$params['picpatha']    = $filename;
    	$params['wechatid'] = $this->session['openid'];
    	Log::write('-------上传图片  vcard start  '.$this->session['openid']);
    	$timeStart = microtime(true);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'wechatSave2', array('params'=>$params));
    	$timeEnd = microtime(true);
    	Log::write('-------上传图片 双面 API耗费时间: '.($timeEnd-$timeStart));
    	//Log::write('-------上传图片  vcard end  '.$this->session['openid'].' cardid='.(isset($res['data']['cardid'])?$res['data']['cardid']:''));
    	unlink($filename);
    	$openid = $this->session['openid']?$this->session['openid']:I('openid');
    	$res['status']!=0 && Log::write('-------上传图片  vcard2API返回数据 '.var_export($res,1));
    	$this->sendMsg($openid,$res);
    	$res['status']==999021 && $res['msg'] = 'OCR识别不成功，请检查名片拍摄方向是否正确';
    	echo json_encode($res);
    }
	//上传名片后服务器端推送消息到客户
    public function sendMsg($openid,$res){
    	Log::write('-------上传图片  vcard 发送消息之前  '.$openid.' cardid='.(isset($res['data']['cardid'])?$res['data']['cardid']:''));
    	$msg = array(
    			'touser'  => $openid,
    			'msgtype' => 'text',
    			'text'    => array('content'=>'')
    		);
    	$json = '';
    	if($res['status']==999021){
    		$msg['text']['content'] = 'OCR识别不成功，请检查名片拍摄方向是否正确';
    		$json = \ConvertFormat::json_encode($msg);
    	}else if($res['status']!=0) {
		    $msg['text']['content'] = '上传失败，请稍后再试';
		    $json = \ConvertFormat::json_encode($msg);
    	}else{
    		$params = array();
    		$params['cardid'] = $res['data']['cardid'];
            $params['wechatid'] = $openid;
    		$resCardList = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    		$wechatsList = $this->analyShowVcard($resCardList['data']['wechats']);
            //记录数据日志
            \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');
            \Think\Log::write('params: '.var_export($wechatsList,true), \Think\Log::INFO,'');
            \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');
    		$info = $wechatsList[0];
    		if (empty($info)) {
    			$msg['text']['content'] = '上传失败，请稍后重试.';
    			$json = \ConvertFormat::json_encode($msg);
    		}else{
    			$picurl =  U(MODULE_NAME.'/'.CONTROLLER_NAME.'/wDetailZp', array("cardid"=>$info['cardid']), false, true);
    			$news = array(
    					'touser'=>$openid,
    					'msgtype' => 'news',
    					'news' => array(
    							'articles'=>array(
    									array(
    									'title' => $info['front']['FN'][0],
    									'description' => @$info['front']['ORG'][0],
    									'url' => $picurl,
    									'picurl' => $info['picture'])
    					))
    				);
    			$json = \ConvertFormat::json_encode($news);
                //记录数据日志
                \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');
                \Think\Log::write('params: '.var_export($news,true), \Think\Log::INFO,'');
                \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');
    		}
    	}
    	$token = $this->getAcessToken();
 /*    	if(empty($token)){
    		$token = $this->getAcessToken(1,'showUpload拍照上传名片');
    	} */
    	$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;
    	$rst = $this->exec($url,$json,'POST');
    	$rst = json_decode($rst,true);
    	static $index = 1;
    	Log::write($openid.'-------上传图片 推送消息给用户  微信接口返回:index='.$index.','.var_export($rst,true));
    	if(isset(self::$_INVALID_TOKEN_CODE[$rst['errcode']])){
    		$rstToken = $this->getAcessToken(1,'sendMsgAgain上传名片后服务器端推送消息到客户');
    		Log::write('-----------上传图片 后   生成新的token----------'.print_r($rstToken,1));
    		//$index = GFunc::getSendWxMsgIndex(); //判断推送消息的调用次数
    		if($index == 1){//失败后再次推送消息
    			$index++;
    			Log::write('-----------上传图片 后   第一次失败后，五分钟内再次推送消息----------'.$openid);
    			$this->sendMsg($openid,$res);
    		}
    	}
    }

    //微信输入框输入文本或语音直接推送消息
    public function fromWxMassage($xml){
    	$time = time();
    	$msg = "<xml>
    				<ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
    				<FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
    				<CreateTime>{$time}</CreateTime>
    				<MsgType><![CDATA[text]]></MsgType>
    				<Content><![CDATA[%s]]></Content>
    		   </xml>";
    	$keyword = '';
    	if($xml['MsgType'] == 'voice'){
    		$keyword = rtrim($xml['Recognition'],'。！？!?.');
    	}else if($xml['MsgType'] == 'text'){
    		$keyword = $xml['Content'] ;
    	}
    	$keyword = trim($keyword);
    	if(empty($keyword)){
    		echo sprintf($msg, '语音识别失败 ，搜索关键字为空');exit;
    	}
    	$max = 5; //最多显示图文数量
    	$params = array();
    	$params['kwds'] = trim($keyword);
    	$params['wechatid'] = $xml['FromUserName'];
    	$params['rows'] = $max;
    	//$params['buystatus']  = 2; //'购买状态1、未购买2、购买

    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	
    	if ($res['status']!=0) {
    		echo sprintf($msg, '无法识别，请稍后再试');
    	}else{
    		if($res['data']['numfound']==0){
    			echo sprintf($msg, '你搜索的关键字为：'.$keyword.'  未查询到数据');
    		}else{
    			$list = $this->analyShowVcard($res['data']['wechats']);
    			$max = count($list)>$max?$max:count($list);
    			$msg = " <xml>
    			<ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
    			<FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
    					<CreateTime>{$time}</CreateTime>
    					<MsgType><![CDATA[news]]></MsgType>
    					<Content><![CDATA[]]></Content>
    					<ArticleCount>{$max}</ArticleCount>
    					<Articles>
							%s
    					</Articles>
    					<FuncFlag>0</FuncFlag>
    					</xml>";
    			$content = '';
    			foreach ($list as $index=>$val){
    				if($index>$max){
    					break;
    				}
    				$url = U(MODULE_NAME.'/'.CONTROLLER_NAME.'/wDetailZp', array('cardid'=>$val['cardid']),true,true);
    				$picture = $index==0?$val['picture']:''; //-{$val['TITLE']
    				$content .="<item>
    						<Title><![CDATA[{$val['front']['FN'][0]}]]></Title>
    						<Description><![CDATA[]]>
    						</Description>
    					    <PicUrl><![CDATA[{$picture}]]></PicUrl>
    					<Url><![CDATA[{$url}]]></Url>
    					</item>";
    			}
    			echo  sprintf($msg,$content);
    		}
    	}
    }

    //公司跳转
    public function companyRedirect(){
    	$name = I('name','中国大唐集团公司'); //公司名称
    	$params = array('name'=>$name);

    	$api_url = 'http://api.tianyancha.com/services/v3/open/w/detail.json';
    	$params  = array('name'=>urldecode($name));
    	Log::write('天眼查--请求参数-- '.json_encode($params));
    	$result  = $this->exec($api_url,$params);
    	$res = json_decode(str_replace("\t", "    ", $result), true);
    	Log::write('天眼查结果  '.json_encode($res));
    	//$res     = json_decode($result,TRUE);//json 解析
    	$error   = $res['error_code'];
    	if (0 != $error) {
    		$content = array();
    	}
    	$content = isset($res['result'])?$res['result']:array();
    	$companyId = 0;
    	if($content){
    		$companyId = $content['baseInfo']['id'];
    		$tianyanurl = 'http://www.tianyancha.com/company/'.$companyId;
    		Log::write('tiany######cha= '.$tianyanurl);
    		redirect($tianyanurl);
    	}else{
    		//$tianyanurl = U(MODULE_NAME.'/Wechat/getCompanyInfo',array('test'=>1),'',true);
    		$tianyanurl = 'http://www.gsxt.gov.cn/index.html';
    		redirect($tianyanurl);
    	}
    }

    

    //企业详情页面
    public function getCompanyInfo()
    {
    	include_once 'Base/jssdk.php';
    	if (empty($this->session['openid'])){
    		$urlCall = U(MODULE_NAME.'/Wechat/redirectAuth',array('callback'=>'getCompanyInfo'),'',true);
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
    	if(I('test')){
    		$this->assign('data','');
    		$this->assign('openid', $this->session['openid']);
    		$this->assign('cardid', '');
    		$this->assign('type','');
    	}else{
    	//Log::write(ACTION_NAME.'-列表请求参数'.json_encode($_REQUEST));
    	$cardid = I('cardid',''); //名片id
    	$name = urldecode(I('name','中国大唐集团公司')); //公司名称
    	$params = array('name'=>$name);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getCompanyInfo', array('params'=>$params));
    	$data = empty($res['data']['content'])?'':json_decode(str_replace("\t", "    ", $res['data']['content']), true);
    	//Log::write('公司详情信息 ####： '.json_encode($data));
    	$this->assign('data',$data);
    	$this->assign('openid', $this->session['openid']);
    	$this->assign('cardid', $cardid);
    	$this->assign('type',$this->getAppName());
    	}
    	$this->display('companyInfo');
    }
    
    //人脉关系图
    public function relationChat($test=0){
    	$colorNodeCompany = '#46A2D2'; //公司节点颜色
    	$colorNodeHuman   = '#F67A52'; //人员节点颜色
    	$color2 = '#89C6DB'; //浅蓝色
    	$colorLink = array(
    			'参股'		=>'#F25A29', //参股  红色
    			'董事'		=> $color2, //
    			'董事长'		=> $color2, //
    			'执行董事' 		=> $color2, //
    			'执行（常务）董事' => $color2, //
    			'经理' 		=> $color2, //
    			'副董事长' 		=> $color2, //
    			'监事' 		=> $color2, //
    			'执行董事兼总..' => $color2, //
    			'法人' 		=> '#CCE198', // 浅蓝色
    	);
    	$colorSet = array('node'=>array(''));
    	$nodesJson = '[{"id":"2373842731","properties":{"name":"西安橙鑫数据\n科技有限公司","ntype":"s"},"labels":["Company"]},{"id":"1031370370","properties":{"name":"上海嘉禾影视娱乐管理咨询有限公司","ntype":"f"},"labels":["Company"]},{"id":"1776754159","properties":{"name":"伍克燕","ntype":"s"},"labels":["Human"]},{"id":"24478376","properties":{"name":"北京橙鑫数据科技有限公司","ntype":"s"},"labels":["Company"]},{"id":"2961003290","properties":{"name":"嘉禾国产电影发行（深圳）有限公司","ntype":"f"},"labels":["Company"]},{"id":"2314527770","properties":{"name":"北京橙源科技有限公司","ntype":"f"},"labels":["Company"]},{"id":"31125997","properties":{"name":"北京橙天嘉禾东方玫瑰影城管理有限公司","ntype":"f"},"labels":["Company"]},{"id":"571449905","properties":{"name":"景德镇橙天嘉禾金鼎影城有限责任公司","ntype":"f"},"labels":["Company"]},{"id":"2167607366","properties":{"name":"解秋生","ntype":"s"},"labels":["Human"]},{"id":"21452719","properties":{"name":"橙天嘉禾影城（中国）有限公司","ntype":"f"},"labels":["Company"]},{"id":"2345064858","properties":{"name":"橙鑫数据科技（香港）有限公司","ntype":"s"},"labels":["Company"]},{"id":"1339820299","properties":{"name":"常州幸福蓝海橙天嘉禾影城有限公司","ntype":"f"},"labels":["Company"]}]';
    	$links = '[{"startNode":"2167607366","id":"196282012","type":"SERVE","endNode":"2373842731","properties":{"labels":["执行董事兼总.."]}},{"startNode":"2167607366","id":"12254399","type":"OWN","endNode":"24478376","properties":{"labels":["法人"]}},{"startNode":"2167607366","id":"215476242","type":"INVEST_H","endNode":"2314527770","properties":{"labels":["参股"]}},{"startNode":"2167607366","id":"142023117","type":"SERVE","endNode":"2314527770","properties":{"labels":["执行董事"]}},{"startNode":"2167607366","id":"181244153","type":"SERVE","endNode":"1339820299","properties":{"labels":["副董事长"]}},{"startNode":"2345064858","id":"245743361","type":"INVEST_C","endNode":"24478376","properties":{"labels":["参股"]}},{"startNode":"21452719","id":"244498322","type":"INVEST_C","endNode":"1339820299","properties":{"labels":["参股"]}},{"startNode":"2167607366","id":"175995466","type":"SERVE","endNode":"571449905","properties":{"labels":["董事长"]}},{"startNode":"21452719","id":"229098414","type":"INVEST_C","endNode":"31125997","properties":{"labels":["参股"]}},{"startNode":"1776754159","id":"215476243","type":"INVEST_H","endNode":"2314527770","properties":{"labels":["参股"]}},{"startNode":"2167607366","id":"149890756","type":"SERVE","endNode":"1031370370","properties":{"labels":["董事长"]}},{"startNode":"1776754159","id":"182718172","type":"SERVE","endNode":"24478376","properties":{"labels":["监事"]}},{"startNode":"2167607366","id":"182718170","type":"SERVE","endNode":"24478376","properties":{"labels":["执行董事"]}},{"startNode":"1776754159","id":"162171790","type":"SERVE","endNode":"31125997","properties":{"labels":["董事长"]}},{"startNode":"2167607366","id":"159976507","type":"SERVE","endNode":"21452719","properties":{"labels":["董事"]}},{"startNode":"2167607366","id":"97603439","type":"OWN","endNode":"1031370370","properties":{"labels":["法人"]}},{"startNode":"1776754159","id":"15162914","type":"OWN","endNode":"31125997","properties":{"labels":["法人"]}},{"startNode":"1776754159","id":"159976510","type":"SERVE","endNode":"21452719","properties":{"labels":["董事"]}},{"startNode":"2167607366","id":"16726836","type":"OWN","endNode":"571449905","properties":{"labels":["法人"]}},{"startNode":"2167607366","id":"134913462","type":"SERVE","endNode":"2961003290","properties":{"labels":["董事"]}},{"startNode":"1776754159","id":"4007631","type":"OWN","endNode":"2961003290","properties":{"labels":["法人"]}},{"startNode":"2167607366","id":"142023118","type":"SERVE","endNode":"2314527770","properties":{"labels":["经理"]}},{"startNode":"1776754159","id":"134913463","type":"SERVE","endNode":"2961003290","properties":{"labels":["执行（常务）董事"]}},{"startNode":"2167607366","id":"97652537","type":"OWN","endNode":"2373842731","properties":{"labels":["法人"]}},{"startNode":"1776754159","id":"196282013","type":"SERVE","endNode":"2373842731","properties":{"labels":["监事"]}},{"startNode":"1776754159","id":"149890758","type":"SERVE","endNode":"1031370370","properties":{"labels":["董事"]}},{"startNode":"2167607366","id":"182718171","type":"SERVE","endNode":"24478376","properties":{"labels":["经理"]}},{"startNode":"24478376","id":"257502776","type":"INVEST_C","endNode":"2373842731","properties":{"labels":["参股"]}},{"startNode":"1776754159","id":"175995468","type":"SERVE","endNode":"571449905","properties":{"labels":["董事"]}},{"startNode":"1776754159","id":"181244148","type":"SERVE","endNode":"1339820299","properties":{"labels":["董事"]}},{"startNode":"2167607366","id":"51234553","type":"OWN","endNode":"2314527770","properties":{"labels":["法人"]}},{"startNode":"2167607366","id":"162171792","type":"SERVE","endNode":"31125997","properties":{"labels":["董事"]}}]';
    	$nodesArr = json_decode($nodesJson,true);
    	$linksArr = json_decode($links,true);
    	$nodes = $links = array(
    			//array('data'=>array('id'=>'2373842731','name'=>'西安橙鑫数据科技有限公司','label'=>'Company')),
    			//array('data'=>array('id'=>'1031370370','name'=>'上海嘉禾影视娱乐管理咨询有限公司','label'=>'Human')),
    	);
    	foreach ($nodesArr as $val){
    		$nodes[] = array('data'=>array('id'=>$val['id'], 'name'=>$val['properties']['name'],'label'=>$val['labels'][0]));
    	}
    	foreach ($linksArr as $val){
    		$color = isset($colorLink[$val['properties']['labels'][0]])?$colorLink[$val['properties']['labels'][0]]:$color2;
    		$links[] = array(
    				'data' => array('source'=>$val['startNode'], 'target'=>$val['endNode'],'relationship'=>$val['properties']['labels'][0]
    						,'color'=>$color),
    				'classes' => md5($colorLink[$val['properties']['labels'][0]])
    		);
    	}
    	$nodes = json_encode($nodes);
    	$links = json_encode($links);
    	$this->assign('nodes',$nodes);
    	$this->assign('links',$links);
    	$this->assign('type','zp');

    	!$test && $this->display('relationChat');
    }
    
    /**
     * 处理人脉关系图名字的长度问题
     */
    public function dealWithStrLen($str)
    {
    	//$str = '北京橙鑫数据科技有限公里数a';
    	//$place = (strlen($str) + mb_strlen($str,'UTF8'))/2; //计算占位符，一个英文是一个占位符，一个中文是两个占位符合 
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($place);
    	$len = mb_strlen($str,'UTF-8');
    }

    //个人信息页面
    public function personInfo()
    {
    	$this->_weixinAuthBase('personInfo', 'Wechat');
    	$cardid = I('cardid',''); //名片id
    	$name = urldecode(I('name','')); //公司名称

    	$params['cardid'] = $cardid;
        $params['wechatid'] = $this->session['openid'];
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	$wechatsList = $this->analyShowVcard($res['data']['wechats']);
    	$info = $res['data']['wechats'][0];
    	//!empty($info['FN']) && $info['FN'] = $info['FN'];

    	include_once 'Base/jssdk.php';
    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    	$url = C('DM_API_PERSONINFO').'/person/details'; //DM个人信息url
    	$timeStart = microtime(true);
    	Log::write('个人页面--请求参数-- '.json_encode($info));
    	Log::write('个人页面--请求url-- '.$url);
    	$rst = $jssdk->_curl($url, 'POST',array(),json_encode($info));
    	$timeEnd = microtime(true);
    	Log::write('个人页面--请求执行时间--########### dmtime test='.($timeEnd-$timeStart).I('name','').'  %%%%'.$name.' $$'.urlencode($name));
    	Log::write('个人页面--返回结果  '.var_export($rst,1));
    	if(empty($rst)){
    		//$nameArr = explode(',', $info['FN']);
    		$kwd = urlencode($wechatsList[0]['front']['FN'][0]);
    		$url = "https://www.baidu.com/s?wd={$kwd}";
    		redirect($url);exit;
    	}
    	$rst = json_decode(str_replace("\t", "    ", $rst), true);

    	if($rst){
    		foreach ($rst as $key=>$val){
    			if($key == 'dynamic'){
    				if($val){
    					foreach ($val as $k=>$v){
    						$rst[$key][$k] = empty($val) ? '' : json_decode(str_replace("\t", "    ", $v), true);
    					}
    				}
    			}else if ('img' == $key) {
                    $rst[$key]  = empty($val)?'':$val;
                }else{
    				$rst[$key] = empty($val) ? '' : json_decode(str_replace("\t", "    ", $val[0]), true);
    			}

    		}
    	}
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($rst,1);exit;
    	Log::write('个人页面返回结果'.json_encode($rst));
    	Log::write('个人页面返回结果'.print_r(json_encode($rst),1));
    	$this->assign('data',$rst);
    	$this->assign('openid', $this->session['openid']);
    	$this->assign('cardid', $cardid);
    	$this->assign('name', $name);
    	$this->display('personInfo');
    }


    /**
     * 个人名片列表页
     */
    public function wListZp(){
    	
    	$type = I('type',''); //来源于历史足迹的类型,1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份 
    	$typekwds = I('typekwds','',''); //类型相对应的关键字
    	$this->_authBase('wListZp', 'Wechat',array('type'=>$type,'typekwds'=>$typekwds)); //微信基本授权操作
		$result = $this->_getCardList($type,$typekwds);
		$res = $result['res'];
    	if(IS_AJAX){
            $res = $this->fetch('listitem');
    		$this->ajaxReturn($res);
    	}else{
            isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
    		$this->assign('datanumber', $res['data']['numfound']);
    		$this->assign('keyword', $result['keyword']);
    		$this->assign('openid', $result['openid']);
    		//$this->assign('isAndroid',$isSourceAndroid); //系统类型,android or ios
    		$this->assign('type', $type);
    		$this->assign('typekwds',$typekwds);
    		
    		//网页调用照片
    		if ($this->userAgent == 'weixin'){
    		    $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    		    $signPackage = $jssdk->GetSignPackage();
    		    $this->assign('signPackage', $signPackage);
    		    $this->display('wListZp');
    		} else {
    		    $this->display('wListZp');
    		}
    	}
    }
    protected function _getCardList($type='',$typekwds=''){
    	$params = array();
    	$rows = 10;
    	$keyword = urldecode(I('keyword',''));//搜索关键字
    	$page = I('get.page',1);
    	$start = ($page-1)*$rows;
    	$openid = I('openid','')?I('openid'):$this->session['openid'];
    	$this->session['openid'] = $openid;
    	session(MODULE_NAME,$this->session);
    	$params['kwds'] = $keyword;
    	$openid && $params['wechatid'] = $openid;
    	empty($keyword) && $params['sort'] = 'createdtime desc';
    	$params['rows'] = $rows;
    	$params['start'] = $start;
    	//$params['buystatus']  = 2; //'购买状态1、未购买2、购买
    	$params['isself'] = 0;
    	if(!empty($keyword)){
    		$type = $typekwds = '';
    	}
    	if($type && $typekwds){
    		$params['type'] = $type;
    		$params['typekwds'] = $typekwds;
    	}
    	 
    	$logPath = C('LOG_PATH');
    	if(!is_dir($logPath)){
    		$flag = mkdir($logPath,0777,true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$logStartTime = microtime(true);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	/*     	if(!empty($keyword)){
    	 $sendTime = ($getReqTime-floatval($sendReqTime));
    	$logEndTime = microtime(true);
    	$logInfo = array('time'=>number_format($logEndTime-$logStartTime,3,'.',''), 'start'=>$logStartTime,'end'=>$logEndTime, 'kwd'=>$keyword,'sendTime'=>$sendTime);
    	$logPath1 = $logPath.'search_'.date('y_m_d').'.log';
    	log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'搜索耗时时间 '.var_export($logInfo,true),
    			Log::INFO,'',$logPath1);
    	
    	$jsVoiceTime = I('time',0);
    	$logInfo = array('time'=>$jsVoiceTime, 'time2'=>I('time2',0), 'kwd'=>$keyword);
    	$logPath2 = $logPath . 'wxvoice_'.date('y_m_d').'.log';
    	log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'js 录音功能 '.var_export($_GET,true),
    			Log::INFO,'',$logPath2);
    	} */
    	$wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
    	$wechatsList = $this->analyShowVcard($wechats,false,false);
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
    	return array('keyword'=>$keyword,'openid'=>$openid,'res'=>$res);
    }
    public function getCards()
    {
        $params = array(
            'wechatid'=>'ofIP5vgCi_HZdeh8WkLwqhdzgYqM',
//            'wechatid'=>'ofIP5vhcYdgjJquZmViCHieBeju0',
//            'type'=>6,
//            'kwds'=>'张鑫',
//            'typekwds'=>'份资科厂',
        );
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        $wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
        $list = $this->analyShowVcard($wechats,false,false);
        dump($res);die;
//        dump($list);die;
    }
    //名片列表(line上)
    public function wListZpLine(){
    	log::write('File:'.__FILE__.' LINE:'.__LINE__." line test \r\n<pre>".'########aaaaa########');
    	$sendReqTime = I('sendReqTime',0); //发送请求时间
    	$getReqTime  = microtime(true);
    	 
    	$type = I('type',''); //来源于历史足迹的类型,1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份
    	$typekwds = I('typekwds','',''); //类型相对应的关键字
		$this->_lineAuthBase('wListZpLine', CONTROLLER_NAME, array('type'=>$type,'typekwds'=>$typekwds));  //line授权操作  	
    	$newSearch = I('newSearch','1'); //1表示新搜索,0旧的搜索
    	$params = array();
    	$rows = 10;
    	$keyword = urldecode(I('keyword',''));//搜索关键字
    	$page = I('get.page',1);
    	$start = ($page-1)*$rows;
    	$openid = I('openid','')?I('openid'):$this->session['openid'];
    	
    	$this->session['openid'] = $openid;
    	session(MODULE_NAME,$this->session);
    	 
    	$params['kwds'] = $keyword;
    	$openid && $params['wechatid'] = $openid;
    	empty($keyword) && $params['sort'] = 'createdtime desc';
    	$params['rows'] = $rows;
    	$params['start'] = $start;
    	//$params['buystatus']  = 2; //'购买状态1、未购买2、购买
    	if(!empty($keyword)){
    		$type = $typekwds = '';
    	}
    	if($type && $typekwds){
    		$params['type'] = $type;
    		$params['typekwds'] = $typekwds;
    	}
    	 
    	$logPath = C('LOG_PATH');
    	if(!is_dir($logPath)){
    		$flag = mkdir($logPath,0777,true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$logStartTime = microtime(true);
    	$params['apptype'] = self::$_APP_TYPE_LINE;
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	if(!empty($keyword)){
    		$sendTime = ($getReqTime-floatval($sendReqTime));
    		$logEndTime = microtime(true);
    		$logInfo = array('time'=>number_format($logEndTime-$logStartTime,3,'.',''), 'start'=>$logStartTime,'end'=>$logEndTime, 'kwd'=>$keyword,'sendTime'=>$sendTime);
    		$logPath1 = $logPath.'search_'.date('y_m_d').'.log';
    		log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'搜索耗时时间 '.var_export($logInfo,true),
    		Log::INFO,'',$logPath1);
    	
    		$jsVoiceTime = I('time',0);
    		$logInfo = array('time'=>$jsVoiceTime, 'time2'=>I('time2',0), 'kwd'=>$keyword);
    		$logPath2 = $logPath . 'wxvoice_'.date('y_m_d').'.log';
    		log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'js 录音功能 '.var_export($_GET,true),
    		Log::INFO,'',$logPath2);
    	}
    	$wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
    	$wechatsList = $this->analyShowVcard($wechats,false,false);
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
    	//Log::write('--------------#####################是否ajax请求-##########:'.print_r(IS_AJAX,1));
    	if(IS_AJAX){
    		$res = $this->fetch('listitem');
    		$this->ajaxReturn($res);
    	}else{
    		isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
    		$this->assign('datanumber', $res['data']['numfound']);
    		$this->assign('keyword', $keyword);
    		$this->assign('newSearch', $newSearch);
    		$this->assign('openid', $openid);
    		$this->assign('type', $type);
    		$this->assign('typekwds',$typekwds);
    			//网页调用照片
    			$this->display('wListZpLine');
    	}    	
    }
    /*
     * 名片批量分享
     */
    public function batchShareCard()
    {
        $wechatid = $this->session['openid'];
        if(IS_GET){
            $params = array(
                'wechatid' => $wechatid,
                'start'=>0,
                'type'=>6
            );
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
            $wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
            $wechatsList = $this->analyShowVcard($wechats,false,false);
            isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
            $this->assign('datanumber', $res['data']['numfound']);
            if($res['status'] == 0 && $res['data']['numfound'] !=0){
                $this->assign('list',$wechatsList);
            }else{
                $this->assign('list',array());
            }
            $this->assign('currentPage',10);
            $this->assign('search',0);
            $this->display('CompanyExtend/enjoyCard');
        }elseif(IS_POST){
            $keyword = I('keyword');
            $params = array(
                'wechatid' => $wechatid,
                'kwds'=>$keyword,
                'type'=>6
            );
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
            $wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
            $wechatsList = $this->analyShowVcard($wechats,false,false);
            $this->assign('keyword',$keyword);
            $this->assign('search',1);
            if($res['status'] == 0 && $res['data']['numfound'] !=0){
                $this->assign('list',$wechatsList);
            }else{
                $this->assign('list',array());
            }
            $this->display('CompanyExtend/enjoyCard');
        }
    }
    //名片批量分享操作
    public function batchShareCardHandle()
    {
        if(IS_AJAX){
            $cardid = I('post.cardid');
            $wechatid = $this->session['openid'];
//            $wechatid = 'ofIP5vqYG99MmxJ3iUvxZh-vOyDE';
            $res = $this->getBizid($wechatid);
            $bizid = isset($res['data']['wechats'][0]['bizid'])?$res['data']['wechats'][0]['bizid']:null;
            if(!empty($bizid)) {
                $params = array('wechatid' => $wechatid, 'bizid' => $bizid);
                $res = \AppTools::webService('\Model\WeChat\WeChat', 'checkIndent', array('params' => $params));
                if ($res['data']['enable'] === '1') {
                    $params = array(
                        'wechatid'=>$wechatid,
                        'cardid'=>$cardid,
                    );
                    $res = \AppTools::webService('\Model\WeChat\WeChat', 'batchCardShare', array('params'=>$params));
//                    dump($params);die;
                    if($res['status']===0){
                        $this->ajaxReturn(array('status'=>0));
                    }
                    elseif($res['status']===999005||$res['status']===800004){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'该名片已分享过'));
                    }
                    elseif($res['status']===999029){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'用户名片不存在'));
                    }
                    elseif($res['status']===999025){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'您还没有绑定企业'));
                    }
                    else{
                        $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败'));
                    }
                }
                elseif($res['data']['enable'] === '2'){
                    $this->ajaxReturn(array('status' => 1, 'msg' => '您还没有通过企业认证'));
                }
                elseif($res['data']['enable'] === '3'){
                    $this->ajaxReturn(array('status' => 1, 'msg' => '您处于离职状态，不能分享名片'));
                }else{
                    $this->ajaxReturn(array('status' => 1, 'msg' => ''));
                }

            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>'您还没有绑定企业'));
            }


        }
    }
    //加载名片
    public function ajaxGetCards()
    {
        if(IS_AJAX) {
            $current = I("post.current");
            $keyword = I('post.keyword');
            $isSearch = I('post.search');
            $params = array(
                'wechatid' => $this->session['openid'],
                'start' => $current,
                'kwds' => $keyword,
                'type' => 6
            );
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params' => $params));
            $wechats = empty($res['data']['wechats']) ? array() : $res['data']['wechats'];
            $wechatsList = $this->analyShowVcard($wechats, false, false);
            if ($res['status'] == 0 && $res['data']['numfound'] != 0) {
                $this->assign('list', $wechatsList);
                $html = $this->fetch('CompanyExtend/cardList');
                $this->ajaxReturn(array('status' => 0, 'html' => $html, 'current' => $current + 10));
            } else {
                $this->assign('list', array());
                $this->ajaxReturn(array('status' => 1));
            }

        }
    }
    //获取企业id
    public function getBizid($wechatid)
    {
        $params = array('wechatid'=> $wechatid);
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
        return $res;
    }
    /**
     * 名片详细页面->名片正面
     */
    public function wDetailZp(){
        $this->_authBase('wDetailZp', 'Wechat'); //微信基本授权操作
		$mess = $this->_detailData(true,'wDetailZp');
//        dump($mess);die;
        /*$fp = fopen(WEB_ROOT_DIR.'../Shell/vcardLog.txt', 'a+b');
        fwrite($fp, var_export($mess,ture));
        fclose($fp);*/
        if(!file_exists(WEB_ROOT_DIR.'../Public/temp/Cards/'.$mess['info']['uuid'].'.vcf')){
            $this->bulidVcf($mess['info']['vcard'], $mess['info']['uuid'], $mess['info']['wechatid']);
        }

        if ($mess['isMenu'] == '1') {
            //$this->display('wDetailZp');
            if(empty($mess['info'])){
                //网页调用照片
                $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
                $signPackage = $jssdk->GetSignPackage();
                $this->assign('signPackage', $signPackage);
                $this->assign('openid',$this->session['openid']);
                $this->assign('type',$this->getAppName());

                $this->display('detail/detail_nodata');
            }else{
                $this->display('detail/detail_self');
            }

        }else{
            $this->display('detail/detail_other');
            //$this->display('detailsCard');
        }
    }
    
    /**
     * 名片详情页面->名片反面
     */
    public function detailBack()
    {
        $mess = $this->_detailData(true,'detailBack');

        if(!file_exists(WEB_ROOT_DIR.'../Public/temp/Cards/'.$mess['info']['uuid'].'_.vcf')){
            $this->bulidVcf($mess['info']['vcard'], $mess['info']['uuid'], $mess['info']['wechatid'],true);
        }

        if ($mess['isMenu'] == '1') {
            $this->display('detail/detail_self_back');
        }else{
            $this->display('detail/detail_other_back');
        }

    	// $this->display('detailBack');
        //$this->display('detailsCardBack');
    }



    /**
     * 名片详情页面公共数据
     * param boolean $showBack
     */
    private function _detailData($showBack=true,$wxCallbackPage)
    {
    	$isSourceAndroid = I('android',''); //是否来源于android  1:是，0：不是
    	$isMenu = I('isMenu',0); //是否来源于自定义菜单，1：是，0：不是
    	$cardid = I('cardid'); //名片id
//     	if(!$isSourceAndroid){
//     		$this->_weixinAuthBase($wxCallbackPage, 'Wechat',array('isMenu'=>$isMenu,'cardid'=>$cardid)); //微信基本授权操作
//     	}
    	$params = array();
    	if($isMenu == '1'){
    		$params['isself'] = 1;
    		$params['wechatid'] = $this->session['openid'];
    	}else{
    		$params['cardid'] = $cardid;
            $params['wechatid'] = $this->session['openid'];
    	}

    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    	$wechatsList = $this->analyShowVcard($res['data']['wechats'],$showBack);
    	$info = $res['data']['numfound']==0?array():$wechatsList[0];
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($info,1);exit;
    	$this->assign('info', $info);
    	if(!$isSourceAndroid){
	    	//网页调用照片
	    	include_once 'Base/jssdk.php';
	    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
	    	$signPackage = $jssdk->GetSignPackage();
	    	$this->assign('signPackage', $signPackage);
    	}
    	$this->assign('isAndroid', $isSourceAndroid);
    	$this->assign('openid', $this->session['openid']);
    	$this->assign('cardid', $cardid?$cardid:$info['cardid']);
    	$this->assign('vcardid', $info['uuid']);
    	$this->assign('sysType', $this->getAppName());
    	$urlSource = '';
    	if(strpos($_SERVER['HTTP_REFERER'], 'wListZp')===false){
    		$urlSource = strpos($_SERVER['HTTP_REFERER'], 'showScanningVcard')===false?'':$_SERVER['HTTP_REFERER'];
    	}else{
    		$urlSource = $_SERVER['HTTP_REFERER'];
    	}
    	$this->assign('urlSource', $urlSource);
    	$this->assign('kwd',urldecode(I('kwd')));
    	$this->assign('isMenu', $isMenu);
        return array('info'=>$info, 'isMenu'=>$isMenu);
    }
    /*
   * 分享名片到企业(名片详情也单个分享）
   * */
    public function shareCardToComp(){
        $params = array();
        $params['wechatid'] = $this->session['openid'];
        $params['cardid'] = array(I('post.cid',''));
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'shareCardTocompM', array('params'=>$params));
        $this->ajaxReturn($res);
    }

    /**
     * 名片分类
     */
    public function cardClassify(){
        $this->display('cardClassify');
    }

    //获取经纬度
    public function getLocation(){//http://dev.orayun.com/
    	$address = urldecode(I('address'));
    	$url = 'http://api.map.baidu.com/geocoder/v2/';
    	$param = array('address'=>$address,'ak'=>'GNMfmaHWOLrt5HMqz4ofS1t1','callback'=>'getLocInfo','output'=>'json');
    	$rst = $this->exec($url,$param);

    	Log::write('--------------Location param-----------------'.print_r($param,1));
    	Log::write('--------------Location-----------------'.$rst);

    	$rst = str_replace('getLocInfo&&getLocInfo(', '', $rst);
    	$rst = rtrim($rst,')');

    	Log::write('--------------Location---------last--------'.$rst);
    	$rst = json_decode($rst,true);
        //百度地图坐标，转换为腾讯地图坐标
        $maplocation = $this->Convert_BD09_To_GCJ02($rst['result']['location']['lat'],$rst['result']['location']['lng']);
        $rst['result']['location']['lat'] = $maplocation['lat'];
        $rst['result']['location']['lng'] = $maplocation['lng'];
    	echo json_encode($rst);
    }

    //删除名片
    public function delCard(){
    	$cardid = urldecode(I('cardid'));
        $openid = $this->getOpenId('delCard','Wechat',array('cardid'=>urlencode($cardid)));
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'wxDelCard', array('params'=>array('cardid'=>$cardid,'wechatid'=>$openid)));
    	$this->ajaxReturn($res);
    }

    //显示上传名片页面
    public function showUpload($tplName='')
    {
    	$tplName = !empty($tplName)?$tplName:'showUpload';
    	$this->_weixinAuthBase($tplName, 'Wechat');
    	//网页调用照片
    	$jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
    	$signPackage = $jssdk->GetSignPackage();
    	$this->assign('signPackage', $signPackage);
    	$this->assign('openid',$this->session['openid']);
    	$this->assign('type',$this->getAppName());
    	$this->display($tplName);
    }
    //上传正反面测试
    public function showUploadSide()
    {
    	$this->showUpload('showUploadSide');
    }
    
    /**
     * 推送消息给企业用户
     */
    public function pushInfoToEntUser($bizId='',$openid=''){
    	//未绑定某个企业
    	if(!$this->validUserIsBindEnt()){
    		//http://dev.orayun.com/demo/Wechat/scannerPushInfo/type/fixedimage/openid/ofIP5vnq4H-Rjo7LhlLtMUIa-k2Y/text/aafddd
    		$_GET['type'] = 'bindEvtEnt';
    		$_GET['openid'] = $openid;
    		$_GET['bizId'] = $bizId;
    		$this->scannerPushInfo();
    	}
    }
    
    /**
     * 验证用户是否绑定某个企业
     */
    public function validUserIsBindEnt($bizId='',$openid=''){
    	$params = array('id'=>$bizId,'openid'=>$openid);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getEntInfoXXXXXXXXXXXXXXXXXXXXXXx', array('params'=>$params));
    	return false;
    }
    
    /**
     * 用户控制扫描仪状态：1:绑定扫描仪，2：启动扫描仪  3：停止扫描仪 4：退出扫描仪
     */
    public function changeScanOpera(){
    	$operaStatus = I('post.operaStatus',6); //1:绑定扫描仪，2：启动扫描仪  3：停止扫描仪 4：退出扫描仪
		$status = $this->_pushInfoToAndroid($this->session['openid'],$operaStatus,time(),'weixin');
    	$this->ajaxReturn(array('status'=>$status));
    }
    
    /**
     * 推送信息到android扫描仪（先调用api，然后api在传递消息给扫描仪）
     * @param unknown $openid  微信id
     * @param unknown $operaStatus 操作状态：1:绑定扫描仪，2：启动扫描仪  3：停止扫描仪 4：退出扫描仪 5:(取消关注公众号时退出扫描仪),6:任意扫描
     * @param unknown $time 时间
     * @param string $publicType 公众号类型：weixin or line
     * @return number
     */
    private function _pushInfoToAndroid($openid,$operaStatus,$time,$publicType='weixin'){
    	$params = array('wechatid'=> $openid);
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
    	$status = 1;
    	if(!empty($res['data']['wechats'])){
    		$wechats = $res['data']['wechats'][0];
    		$wxInfo = json_decode($wechats['wechatinfo'],true);
    		$deviceid = $wechats['scannerinfo'];//扫描仪设备id
    		$commandInfo = array(
    				'nickname'	=> $wxInfo['nickname'], //微信昵称
    				'headimgurl'=> $wxInfo['headimgurl'], //微信头像
    				'wechatid'  => $openid?$openid:$this->session['openid'], //微信id
    				'status'    => $operaStatus, //1:绑定扫描仪，2：启动扫描仪  3：停止扫描仪 4：退出扫描仪 5:(取消关注公众号时退出扫描仪),6:任意扫描
    				'time'      => $time,
    				'publictype'      => $publicType //公众号来源:line weixin
    		);
    		$params = array('deviceid'=> $deviceid,'info'=>json_encode($commandInfo));
    		Log::write('-------##扫描名片#改变扫描仪状态:'.var_export($params,true));
    		$res = \AppTools::webService('\Model\WeChat\WeChat', 'startScannerOpera', array('params'=>$params));
    		$status = $res['status'];
    	}
    	return $status;
    }
    
    //扫描仪给公众号推送消息
    //http://dev.orayun.com/demo/Wechat/scannerPushInfo/type/fixedimage/openid/ofIP5vnq4H-Rjo7LhlLtMUIa-k2Y/text/aafddd
    public function scannerPushInfo(){
    	$type = I('type','text'); //推送类型:text文本，image:图片,默认text
    	$text = I('text','扫描名片已结束','');//消息文案
    	$picture  = I('picture');//图片地址
    	$cardid = I('cardid');//名片id
    	$openid = I('openid','ofIP5vnuTl1UTMpiIu3pO4_mRQ90'); //微信id
    	$batchid = I('batchid'); //批次id
    	//$tokenInfo = $this->getWxTokenToLocal(0,$type.'::scannerPushInfo扫描仪给公众号推送消息::'.$text);
    	//$token = $tokenInfo['access_token'];
    	Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n外部推送消息传到参数：：<pre>".''.var_export($_GET,true));
    	$token = $this->getAcessToken(0,$type.'::scannerPushInfo扫描仪给公众号推送消息::'.$text);
    	$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;

    	$json = '';    	
    	//推送文本消息
    	if($type == 'text'){
    		$msg = array(
    				'touser'=>$openid,
    				'msgtype'=>$type,
    				'text'=>array('content'=>$text)
    		);
    		$json = \ConvertFormat::json_encode($msg);
    	}else if($type == 'image'){
    		//推送图文消息
    		$picurl =  U(MODULE_NAME.'/'.CONTROLLER_NAME.'/wDetailZp', array("cardid"=>$cardid), false, true);
    		$news = array(
    				'touser'=>$openid,
    				'msgtype' => 'news',
    				'news' => array(
    						'articles'=>array(
    								array(
    										//'title' => $info['front']['FN'][0],
    										//'description' => @$info['front']['ORG'][0],
    										'url' => $picurl,
    										'picurl' => $picture)
    						))
    		);
    		$json = \ConvertFormat::json_encode($news);
    	}else if($type == 'fixedimage'){
    		$scanType = I('scanType','vcard');//扫描类型：vcard:名片,all:任意扫
    		//推送固定图片消息
    		$params = array();
    		$params['wechatid'] = $openid;
    		$params['start'] = 0;
    		$params['rows'] = 1;
    		$params['new'] = 1;
    		if($scanType == 'vcard'){
    			$params['sort'] = 'cardid desc';
    			$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
    			$newcardid = empty($res['data']['wechats'])?0:$res['data']['wechats'][0]['cardid'];
    			//推送固定图片信息
                $picurl =  U(MODULE_NAME.'/ConnectScanner/showScanningVcard','', false, true)."?cardid=".$newcardid."&openid=".$openid.'&batchid='.$batchid;
    			$picture = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/weixin_push_image.jpg?t='.time();
    		}else if($scanType == 'all'){
    			$params['sort'] = 'id desc';
    			$res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatResourceAll', array('params'=>$params));
    			$newcardid = empty($res['data']['list'])?0:$res['data']['list'][0]['id'];
    			//推送固定图片信息
    			$picurl =  U(MODULE_NAME.'/ConnectScanner/realtimeScanningAll', '', false, true)."?cardid=".$newcardid."&openid=".$openid.'&batchid='.$batchid;
    			$picture = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/weixin_push_image.jpg?t='.time();
    		}else if($scanType == 'questionnaire'){//问卷调查，还缺图片
    			//推送固定图片信息
    			$picurl =  "https://www.wjx.cn/jq/16873200.aspx";
    			$picture = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/diaocha.jpg?t='.time();
    		}else if($scanType == 'bindEvtEnt'){
    			//绑定企业
    			$bizId = I('bizId','999'); //企业id
    			$picurl =  U(MODULE_NAME.'/CompanyExtend/bindEmployeePage','', false, true)."?bizId=".$bizId."&openid=".$openid;
    			$picture = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/diaocha.jpg?t='.time();
    		}
    		if($scanType == 'questionnaire'){
    			$news = array(
    					'touser'=>$openid,
    					'msgtype'=>'text',
    					'text'=>array('content'=>$text)
    			);
    		}elseif($scanType == 'vcard'){
                $picurl1 =  U(MODULE_NAME.'/ConnectScanner/showScanningVcard','', false, true)."?cardid=".$newcardid."&openid=".$openid.'&batchid='.$batchid.'&share=1';
                $picture = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/scanner_push_first.jpg?t='.time();
                $picture1 = C('GET_ORADT_WEIXIN_TOKEN_URL').'/images/default/scanner_push_second.png?t='.time();
    			$news = array(
    					'touser'=>$openid,
    					'msgtype' => 'news',
    					'news' => array(
    							'articles'=>array(
    									array(
    											'title' => empty($text)?'本次扫描的名片都在这里哦':$text,
    											'url' =>    $picurl,
    											'picurl' => $picture),
                                        array(
                                                'title' => '分享名片到公司',
                                                'url' =>    $picurl1,
                                                'picurl' => $picture1)
    							))
    			);
    		}else{
                $news = array(
                        'touser'=>$openid,
                        'msgtype' => 'news',
                        'news' => array(
                                'articles'=>array(
                                        array(
                                                'title' => empty($text)?'本次扫描的名片都在这里哦':$text,
                                                'url' =>    $picurl,
                                                'picurl' => $picture)
                                ))
                );
            }
    		$json = \ConvertFormat::json_encode($news);
    	}else if($type == 'image2'){
    		$msg = array(
    				'touser'=>$openid,
    				'msgtype'=>$type,
    				'image'=>array('media_id'=>'MEDIA_ID')
    		);
    		$json = \ConvertFormat::json_encode($msg);
    	}   	
    	$timeStart = microtime(true);
    	$rst = $this->exec($url,$json,'POST');
    	$rst = json_decode($rst,true);
    	Log::write($openid.' '.$text.'-------##扫描名片#结束，推送消息给用户:'.var_export($rst,true));
    	$timeEnd = microtime(true);
    	Log::write('-------###扫描仪给微信推送消息耗费时间 time_total: '.($timeEnd-$timeStart));
    	if(isset(self::$_INVALID_TOKEN_CODE[$rst['errcode']])){
    		Log::write($openid.'-------扫描名片推送消息 $$$$$ end refresh token');
    		$rstToken = $this->getAcessToken(1,'scannerPushInfoAgain扫描仪给公众号推送消息');
    		Log::write('-----------扫描名片推送消息 后   生成新的token----------'.print_r($rstToken,1));
    		//$index = GFunc::getSendWxMsgIndex(); //判断推送消息的调用次数
    		static $index = 1;
    		if($index == 1){//失败后再次推送消息
    			$index++;
    			Log::write('-----------扫描名片推送消息  后   第一次失败后，五分钟内再次推送消息----------'.$openid);
    			$this->scannerPushInfo($openid,$text);
    		}else{
    			$this->ajaxReturn(array('status'=>$rst['errcode'],'msg'=>'推送消息失败:'.$rst['errmsg']));
    		}
    	}else if($rst['errcode'] == 0){
    		$this->ajaxReturn(array('status'=>0,'msg'=>'推送消息成功'));
    	}else{
    		$this->ajaxReturn(array('status'=>$rst['errcode'],'msg'=>'推送消息失败:'.$rst['errmsg']));
    	}
    }
    
    public function wechatcardlist(){
        include_once 'Base/jssdk.php';
        $openid = $this->getOpenId('wechatcardlist','Wechat');
        $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage', $signPackage);

        $params['kwds'] = urldecode(I('kwd'));
        $params['sort'] = 'createdtime desc';
        $params['wechatid'] = $openid;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        $this->assign('list', $res['data']['wechats']);
        $this->display('wechatcardlist');
    }
    /**
     * 名片详细页面
     */
    public function webChatCardDetail(){
        $cardid = I('cardid');
        $openid = $this->getOpenId('webChatCardDetail','Wechat',array('cardid'=>$cardid));
        $params['cardid'] = $cardid;
        $params['wechatid'] = $openid;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        $info = $res['data']['wechats'][0];
        $this->assign('info', $info);
        $this->display('webchatdcardetail');
    }

    public function getVoiceWords(){
        $xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
        $wechatparams['FromUserName'] = $xml['FromUserName'];
        $wechatparams['ToUserName'] = $xml['ToUserName'];
        $wechatparams['createtime'] = time();
        $wechatparams['imgurl'] = 'https://oradtdev.s3.cn-north-1.amazonaws.com.cn/resource/2017/0328/PQ0hjedfym20170328132221.jpg';

        //根据语音识别结果，查询名片
        $params = array();
        $params['kwds'] = $this->cutStrs($xml['Recognition']);
        //$cardlist = $this->getVcardlist($params);
        Log::write('--------------voice save-----------------');
        Log::write(var_export($xml,true));
        Log::write('--------------voice save-----------------');
    }

    public function getVcardlist($params){
        $openid = $this->getOpenId('getVcardlist','Wechat');
        $params['sort'] = 'createdtime desc';
        $params['wechatid'] = $openid;
        $result = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        if ($result['status'] == 0 && $result['data']['numfound'] !== 0 ){
            $result = $result['data']['wechats'];
        }else{
            $result = array();
        }
        return $result;
    }
    public function returnNewsMsg($wechatparams){
        $msg = "<xml>
                <ToUserName><![CDATA[{$wechatparams['FromUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$wechatparams['ToUserName']}]]></FromUserName>
                <CreateTime>{$wechatparams['createtime']}</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                    <item>
                    <Title><![CDATA[{$wechatparams['title']}]]></Title>
                    <Description><![CDATA[{$wechatparams['title']}]]></Description>
                    <PicUrl><![CDATA[{$wechatparams['imgurl']}]]></PicUrl>
                    <Url><![CDATA[{$wechatparams['linkurl']}]]></Url>
                    </item>
                </Articles>
                </xml> ";
        return $msg;
    }
    public function returnMsg($wechatparams){
        $msg = "<xml>
                <ToUserName><![CDATA[{$wechatparams['FromUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$wechatparams['ToUserName']}]]></FromUserName>
                <CreateTime>{$wechatparams['createtime']}</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[{$wechatparams['content']}]]></Content>
                </xml>";
        return $msg;
    }
    public function cutStrs($str){
        $str  = mb_substr($str,0,(mb_strlen($str,'UTF-8')-1),'utf8');
        return $str;
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

    /**
     * 设置公众号菜单
     */
    public function setMenu ()
    {
        $menuJsonData = C('Wechat.menu');
        $result = $this->wechatRequest->setMenu($menuJsonData);
        echo print_r($result, true);
    }

    /**
     * 获取公众号菜单
     */
    public function getMenu ()
    {
        $result = $this->wechatRequest->getMenu();
        echo print_r($result, true);
    }

    /**
     * 获取素材总数
     */
    public function getMaterialCount ()
    {
        $result = $this->wechatRequest->getMaterialCount();

        echo print_r($result, true);
    }

    /**
     * 获取素材列表
     */
    public function getMaterialList ()
    {
        $type = I('type', 'image');
        $offset = I('offset' , 0);
        $count  = I('count', 20);
        $result = $this->wechatRequest->getMaterialListByType($type, $offset, $count);

        echo print_r($result, true);
    }

    /**
     * 添加摇一摇素材图片
     */
    public function addShakeArroundMaterial ()
    {
        if (! IS_POST || ! isset($_FILES['media'])) {
            $this->display('addShakeArroundMaterial');
            return;
        }
        $result = $this->wechatRequest->addShakeArroundMaterial($_FILES['media']['tmp_name'], 'icon');

        echo $result;
    }

    /**
     * 获取摇一摇申请状态
     * 返回说明 正常时的返回JSON数据包示例：
        {
            "data": {
                "apply_time": 1432026025,
                "audit_comment": "test",
                "audit_status": 1,
                "audit_time": 0
            },
            "errcode": 0,
            "errmsg": "success."
        }

     * 参数说明
     * 参数 	说明
        apply_time 	提交申请的时间戳
        audit_status 	审核状态。0：审核未通过、1：审核中、2：审核已通过；审核会在三个工作日内完成
        audit_comment 	审核备注，包括审核不通过的原因
        audit_time 	确定审核结果的时间戳；若状态为审核中，则该时间值为0
     */
    public function checkShakeArroundStatus ()
    {
        $result = $this->wechatRequest->checkShakeArroundStatus();

        echo $result;
    }

    /**
     * 申请开通摇一摇功能
     */
    public function applyShakeArround ()
    {
        if (! IS_POST) {
            $this->display('applyShakeArround');
            return;
        }

        $params = array(
            'name'          => I('post.name'),
            'phone_number'  => I('post.phone_number'),
            'email'         => I('post.email'),
            'industry_id'   => I('post.industry_id'),
            'qualification_cert_urls'         => I('post.qualification_cert_urls'),
            'apply_reason'  => I('post.apply_reason'),
        );
        $result = $this->wechatRequest->applyShakeArround($params);

        echo print_r($result, true);
    }

    /**
     * 申请摇一摇设备ID
     */
    public function applyShakeArroundDeviceId ()
    {
        $quantity     = I('quantity', 10);
        $apply_reason = I('quantity', '开发测试');
        $comment      = I('comment', null, 'strval');
        $poi_id       = I('poi_id', null, 'intval');
        $result = $this->wechatRequest->applyShakeArroundDeviceId($quantity, $apply_reason, $comment, $poi_id);

        echo print_r($result, true);
    }

    /**
     * 查看摇一摇设备ID申请状态
     */
    public function checkShakeArroundDeviceApplyStatus ()
    {
        $applyId       = I('applyId', 427104, 'intval');
        $result = $this->wechatRequest->checkShakeArroundDeviceApplyStatus ($applyId);

        echo $result;
    }

    /**
     * 获取摇一摇设备列表
     */
    public function getShakeArroundDeviceList ()
    {
        $applyId       = I('applyId', 427104, 'intval');
        $lastSeen      = I('lastSeen', 0, 'intval');
        $count         = I('count', 50, 'intval');
        $result = $this->wechatRequest->getShakeArroundDeviceList ($lastSeen, $count, $applyId);
        $deviceList = json_decode($result, true);
        $deviceList = $deviceList['data']['devices'];
        $lastDevice = array_pop($deviceList);


        echo '<a href="'
            . U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,
                array('applyId'=>$applyId, 'lastSeen'=>$lastDevice['device_id'], 'count'=>$count)
               )
            . '">下一页</a>';
        echo '<hr/>';
        echo '设备列表：';
        echo print_r($result, true);
    }

    /**
     * 添加摇一摇页面
     */
    public function addShakeArroundPage ()
    {
        if (! IS_POST) {
            $this->assign('form', array(
                    'legend' => '添加摇一摇页面',
                    'data'   => array (
                          array('label'  => '主标题',
                                'name'   => 'title',
                                'desc'   => '在摇一摇页面展示的主标题，不超过6个汉字或12个英文字母 '),
                          array('label'  => '副标题',
                                'name'   => 'description',
                                'desc'   => '在摇一摇页面展示的副标题，不超过7个汉字或14个英文字母  '),
                          array('label'  => '页面展示的图片URL',
                                'name'   => 'icon_url',
                                'desc'   => '在摇一摇页面展示的图片。图片需先上传至微信侧服务器，用“素材管理-上传图片素材”接口上传图片，返回的图片URL再配置在此处'),
                          array('label'  => '跳转URL',
                                'name'   => 'page_url',
                                'desc'   => '跳转URL '),
                          array('label'  => '备注信息',
                                'name'   => 'comment',
                                'desc'   => '页面的备注信息，不超过15个汉字或30个英文字母  '),
                    ),
                )
            );
            $this->display('commonForm');
            return;
        }

        $title       = I('post.title');
        $description = I('post.description');
        $icon_url    = I('post.icon_url');
        $page_url    = I('post.page_url');
        $comment     = I('post.comment');
        $result = $this->wechatRequest->addShakeArroundPage($title, $description, $icon_url, $page_url, $comment);

        echo print_r($result, true);
    }

    /**
     * 修改名片信息展示（编辑名片信息模板）
     * @return [type] [description]
     */
    public function showCardDetail(){
    	$isSourceAndroid = I('android',''); //是否来源于android  1:是，0：不是
    	$this->assign('android',$isSourceAndroid); //系统类型,android or ios
        if(IS_POST){//保存编辑信息
            $result = $this->editCardDetail();
            $this->assign('result',$result);
        }
        $cardid  = I('cardid'); //名片id
        $side = I('side','front'); //正面或反面
        $isBack = $side == 'back' ? true : false; //是否背面
        $openid = $this->getOpenId('showCardDetail','Wechat',array('android'=>$isSourceAndroid,'cardid'=>$cardid,'side'=>$side));
        $params = array();
        $params['cardid'] = $cardid;
        $params['wechatid'] = $openid;
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        $wechatsList = $this->analyShowVcard($res['data']['wechats'],$isBack);
        $info = $wechatsList[0];
        if(!empty($info[$side]['FN']) && $info[$side]['FN']){
            $info[$side]['FN'] = $info[$side]['FN'][0];
        }else{
        	$info[$side]['FN'] = '';
        }
        if(!empty($info[$side]['ORG']) && $info[$side]['ORG']){
            $info[$side]['ORG'] = $info[$side]['ORG'][0];
        }else{
        	$info[$side]['ORG'] = '';
        }
        if(!empty($info[$side]['ADR']) && $info[$side]['ADR']){
            $info[$side]['ADR'] = $info[$side]['ADR'][0];
        }else{
        	$info[$side]['ADR'] = '';
        }
		if(!empty($info[$side]['JOB']) && $info[$side]['JOB']){ //职位
			$info[$side]['JOB'] = $info[$side]['JOB'][0];
		}else{
			$info[$side]['JOB'] = '';
		}

        $this->assign('info',$info);
        $this->assign('side',$side); //正面或反面变量

        //网页调用照片
        include_once 'Base/jssdk.php';
        $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage', $signPackage);
        $this->assign('openid', $this->session['openid']);
        $this->assign('cardid', $cardid);
        $this->assign('sysType', $this->getAppName());
        $this->assign('rtnPage',$isBack?'detailBack':'wDetailZp');
        //$this->display('editCard');
        $this->display('detail/detail_edit');

    }
    /**
     * 修改名片信息保存
     * @return [type] [description]
     */
    public function editCardDetail(){
        $name = I('post.name','',''); //个人名称，单条信息
        $company = I('post.company','',''); //公司名称 单条信息
        $address = I('post.address','','');
        $mobile = I('post.mobile');
        $telphone = I('post.telphone');
        $url = I('post.url');
        $cardid = I('post.cardid');
        $side = I('post.side'); //名片正面或反面，front:正面,back:反面
		$job =I('post.job','','');//职位
        $email =I('post.email','');//职位
		$isself = I('post.isself',0); //是否为自己名片（默认0不是 1是）
        $newInfo = array();
        //获取修改之前的名片信息
        $params['cardid'] = $cardid;
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        $paramUpdate = array(
        		'name' => array($name),
        		'company_name' => array($company),
        		'address' => array($address),
        		'mobile' => $mobile,
        		'telephone' => $telphone,
        		'web' => $url,
			    'job' => $job,//职位
                'email'=>$email,
        );
		$vcardJson = $this->analyUpdateVcard($res['data']['wechats'][0]['vcard'],$paramUpdate,$side);
        $newInfo['cardid'] = $cardid;
        $newInfo['vcard'] = $vcardJson;
        $newInfo['isself'] = $isself;
        $newInfo['wechatid'] = $this->session['openid'];
        $result = \AppTools::webService('\Model\WeChat\WeChat','editCardDetail',array('params'=>$newInfo));
        if($result && $result['status']==0){
            return "success";
        }else{
            return "fail";
        }
    }

    /**
     * 中国正常GCJ02坐标---->百度地图BD09坐标
     * 腾讯地图用的也是GCJ02坐标
     * @param double $lat 纬度
     * @param double $lng 经度
     */
    public function Convert_GCJ02_To_BD09($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z =sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
        return array('lng'=>$lng,'lat'=>$lat);
    }

    /**
     * 百度地图BD09坐标---->中国正常GCJ02坐标
     * 腾讯地图用的也是GCJ02坐标
     * @param double $lat 纬度
     * @param double $lng 经度
     * @return array();
     */
    public function Convert_BD09_To_GCJ02($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng - 0.0065;
        $y = $lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array('lng'=>$lng,'lat'=>$lat);
    }
    
    //记录日志到后台
    public function jsLog(){
    	$logInfo = array();
    	if($_POST){
    		foreach ($_POST as $k=>$v){
    			$logInfo[$k] = $v;
    		}
    	}
    	$logPath = C('LOG_PATH');
    	if(!is_dir($logPath)){
    		$flag = mkdir($logPath,0777,true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$logPath .= 'voice_'.date('y_m_d').'.log';
    	log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".'js 录音功能 '.var_export($logInfo,true),
    	Log::INFO,'',$logPath);
    }
    
    
    
    /**
     * 保存修改后的数据到vcard json字符串中
     * @param String $vcardJson 名片数据json字符串
     * @param array $updatedParam 要修改的属性和值
     * @param string $side 是修改名片正面或反面数据
     */
    public function analyUpdateVcard($vcardJson,$updatedParam=array(),$side='front')
    {
    	$rst = array();
    	$vcardArr = json_decode($vcardJson,true);
    	$sideData    = $vcardArr[$side];
    	//$sysFileds = array('name','mobile','company_name','address','telephone','web'); //定义名片中有的所有属性,'email','fax','job'
    	$nameArr = isset($sideData['name'])?$sideData['name']:array(); //姓名
    	$mobileArr = isset($sideData['mobile'])?$sideData['mobile']:array(); //手机号
    	//$telephoneArr = isset($sideData['telephone'])?$sideData['telephone']:array(); //手机号
        $emailArray = isset($sideData['email'])?$sideData['email']:array(); //邮箱
    	$companyArr = isset($sideData['company'])?$sideData['company']:array(); //公司
    	//修改名字
    	if($nameArr){
    		foreach ($nameArr as $key=>$value){
    			if($key > 0){
    				break;
    			}
    			$nameArr[$key]['value'] = $updatedParam['name'][0];
    			$nameArr[$key]['is_changed'] = 1;
    		}
    	}else{
    		$nameArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2','is_chinese'=>1,'surname'=>'','given_name'=>'', 'value'=>$updatedParam['name'][0], 'title'=>'姓名');
    	}

    	//修改手机号
    	if($mobileArr){
    		foreach ($mobileArr as $key=>$value){
    			$mobileArr[$key]['value'] = $updatedParam['mobile'][$key];
    			$mobileArr[$key]['is_changed'] = 1;
    		}
    	}else{
    		$mobileArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['mobile'][0], 'title'=>'手机');
    	}

        //修改邮箱
        if($emailArray){
            foreach ($emailArray as $key=>$value){
                $emailArray[$key]['value'] = $updatedParam['email'][$key];
                $emailArray[$key]['is_changed'] = 1;
            }
        }else{
            $emailArray[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
        }
    	//修改公司相关信息
    	if($companyArr){
    		foreach ($companyArr as $key=>$company){
    			if($key>0){
    				break;
    			}
    			//公司名称信息修改
    			$company_nameArr = isset($company['company_name'])?$company['company_name']:array();
    			if($company_nameArr){
    				foreach ($company_nameArr as $k=>$v){
    					if($k > 0){
    						break;
    					}
    					$company_nameArr[$key]['value'] = $updatedParam['company_name'][0];
    				}
    			}else if(!empty($updatedParam['company_name'][0])){
    				$company_nameArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['company_name'][0], 'title'=>'公司');
    			}
    			$companyArr[$key]['company_name'] = $company_nameArr;
    			
    			//公司地址信息修改
    			$addressArr = isset($company['address'])?$company['address']:array();
    			if($addressArr){
    				foreach ($addressArr as $k=>$v){
    					if($k > 0){
    						break;
    					}
    					$addressArr[$key]['value'] = $updatedParam['address'][0];
    				}
    			}else if(!empty($updatedParam['address'][0])){
    				$addressArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['address'][0], 'title'=>'地址');
    			}
    			$companyArr[$key]['address'] = $addressArr;

				//公司职位修改
				$jobArr = isset($company['job'])?$company['job']:array();
				if($jobArr){
					foreach ($jobArr as $k=>$v){
						if($k > 0){
							break;
						}
						$jobArr[$key]['value'] = $updatedParam['job'][0];
					}
				}else if(!empty($updatedParam['job'][0])){
					$jobArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['job'][0], 'title'=>'职位');
				}
				$companyArr[$key]['job'] = $jobArr;

    			//修改电话号码
    			$telephoneArr = isset($company['telephone'])?$company['telephone']:array();
    			if($telephoneArr){
    				foreach ($telephoneArr as $k=>$v){
    					$telephoneArr[$k]['value'] = $updatedParam['telephone'][$k];
    				}
    			}else if(!empty($updatedParam['telephone'][0])){
    				$telephoneArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['telephone'][0], 'title'=>'电话');
    			}

    			$companyArr[$key]['telephone'] = $telephoneArr;

    			//修改网址
    			$webArr = isset($company['web'])?$company['web']:array();
    			if($webArr){
    				foreach ($webArr as $k=>$v){
    					$webArr[$k]['value'] = $updatedParam['web'][$k];
    				}
    			}else if(!empty($updatedParam['web'][0])){
    				$webArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['web'][0], 'title'=>'网址');
    			}
    			$companyArr[$key]['web'] = $webArr;

                //修改邮箱
                $emailArr = isset($company['email'])?$company['email']:array();
                if($emailArr){
                    foreach ($emailArr as $k=>$v){
                        $emailArr[$k]['value'] = $updatedParam['email'][$k];
                    }
                }else if(!empty($updatedParam['email'][0])){
                    $emailArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
                }
                $companyArr[$key]['email'] = $emailArr;

    		}
    	}else{//当公司信息为空时，直接补充一条信息
    		!empty($updatedParam['company_name'][0]) && $companyArr[0]['company_name'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['company_name'][0], 'title'=>'公司');
    		!empty($updatedParam['address'][0]) && $companyArr[0]['address'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['address'][0], 'title'=>'地址');
    		!empty($updatedParam['job'][0]) && $companyArr[0]['job'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['job'][0], 'title'=>'职位');
    		!empty($updatedParam['telephone'][0]) && $companyArr[0]['telephone'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['telephone'][0], 'title'=>'电话');
    		!empty($updatedParam['web'][0]) && $companyArr[0]['web'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['web'][0], 'title'=>'网址');
            !empty($updatedParam['email'][0]) && $companyArr[0]['email'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
    	}
    	$sideData['name'] = $nameArr;
    	$sideData['mobile'] = $mobileArr;
        $sideData['email'] = $emailArray;
    	$sideData['company'] = $companyArr;
    	$vcardArr[$side] = $sideData;
    	//log::write('File:'.__FILE__.' LINE:'.__LINE__." 修改后的信息格式为： \r\n<pre>".''.var_export($vcardArr,true));
    	return json_encode($vcardArr);
    }

    /**
     * 查询公司详细信息
     */
    public function companyComfirm(){
        $company = I('name','');
        $card_id = I('cardid','');
        $whether = I('whether','yes');
        $params = array('company' => urldecode($company),
                        'card_id' => $card_id,
                        'page_num'=> 1,
                        'whether' => $whether,
                    );
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取公司参数： \r\n<pre>".''.var_export($params,true));
        $data = $this->getCompany('/corporate_information_query_interface/corporate_information_query_interface_list/',$params);
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取公司列表结果： \r\n<pre>".''.var_export($data,true));
        $data = json_decode($data,TRUE);
        $this->assign('openid', $this->session['openid']);
        if($data){
            if($data['confim']==0){
                $page = $data['total_pages'];
                $companyList = $data['pageCount'];
                //查询数量1-50，跳转到公司列表（在页面中判断）
                $this->assign('page',$page);
                $this->assign('companyList',$companyList);
                $this->assign('cardid',$card_id);
                $this->assign('company',urldecode($company));
                $this->display('conpanyList');
            }
            //?什么时候会出现这种情况
            if($data['confim']==1){
                // $params2 = array('company'=>urldecode($company),'card_id'=>$card_id);
                // $result = $this->getCompany('/corporate_information_query_interface/corporate_information_query_interface_data/',$params);
                $this->assign('companyDetail',$data['company_info']);
                $this->assign('cardid',$card_id);
                $this->assign('company',urldecode($company));
                $list = $this->_getCompanyNews($company);
                $this->assign('newslist', $list);
                $this->display('companyIntro');
            }
        }else{
            $tianyanurl = 'http://www.gsxt.gov.cn/index.html';
            redirect($tianyanurl);
        }   
    }
    public function companyComfirm2(){
        $company = I('name','');
        $card_id = I('cardid','');
        $p = I('p',1);
        $whether = I('whether','yes');
        $params = array('company' => urldecode($company),
                        'card_id' => $card_id,
                        'page_num'=> $p,
                        'whether' => $whether,
                    );
        $data = $this->getCompany('/corporate_information_query_interface/corporate_information_query_interface_list/',$params);
        echo $data;
    }
    /**
     * 获取公司详情
     */
    public function showCompanyDetail(){
        $cardid = I('cardid','');
        $company = I('company','');
        $preCompany = I('preCompany',$company);
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取原公司： \r\n<pre>".''.var_export($preCompany,true));
        $params  =array('company' => urldecode($company),
                        'card_id' => $cardid,
                );
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取公司详细信息参数： \r\n<pre>".''.var_export($params,true));
        $rs = $this->getCompany('/corporate_information_query_interface/corporate_information_query_interface_data/',$params);
        Log::write('File:'.__FILE__.' LINE:'.__LINE__." 获取公司详细信息结果： \r\n<pre>".''.var_export($rs,true));
        $rs = json_decode($rs,TRUE);
        if($rs['confim']==1){
            $this->assign('companyDetail',$rs['company_info']);
            $this->assign('cardid',$cardid);
            $this->assign('company',urldecode($preCompany));
        }
        
        $rs = $this->_getCompanyNews($company);
        $this->assign('newslist', $rs);
        $this->display('companyIntro');
    }

    /**
     * 获取公司新闻
     * @param str $company
     * @return arr
     */
    private function _getCompanyNews($company){
        $params = array();
        $params['company_name'] = urldecode($company);
        $rs = $this->getCompany('/corporate_information_query_interface/company_news/', $params);
        $rs = json_decode($rs,TRUE);
        if (empty($rs)) {
            $rs = '';
        }
        return $rs;
    }
    
    /**
     * 获取公司信息
     * 1.获取公司详情
     * 2.获取公司列表
    */
    public function getCompany($url,$params){
        $params = json_encode($params);
        $url = C('NEWPAGE_API').$url;
        $rs = $this->exec($url,$params,'POST');
        return $rs;
    }
    
    
    /**
     * 名片导出列表页面
     */
    public function exportList(){
    	$type = I('type',''); //来源于历史足迹的类型,1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份
    	$typekwds = I('typekwds','',''); //类型相对应的关键字
    	$this->_weixinAuthBase('exportList', 'Wechat',array('type'=>$type,'typekwds'=>$typekwds)); //微信基本授权操作
    	
    	$result = $this->_getCardList($type,$typekwds);
    	$res = $result['res'];
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($res,1);exit;
    	if(IS_AJAX){
    		$res = $this->fetch('listitem');
    		$this->ajaxReturn($res);
    	}else{
    		isset($res['data']['numfound']) ? '':$res['data']['numfound']=0;
    		$this->assign('datanumber', $res['data']['numfound']);
    		$this->assign('keyword', $result['keyword']);
    		$this->assign('openid', $result['openid']);
    		$this->assign('type', $type);
    		$this->assign('typekwds',$typekwds);
    		$this->display('exportList');
    	}
    }
    /**
     * 名片导出到excel中
     */
    public function exportExcel(){
         $operaType = I('operaType','email'); //excel email vcard
         $cardis = I('cardids','');
         $params = array();
         $rows = 100;
         $keyword = urldecode(I('keyword',''));//搜索关键字
         $page = I('get.page',1);
         $start = ($page-1)*$rows;
         $openid = I('openid','')?I('openid'):$this->session['openid'];
         
         $params['kwds'] = $keyword;
         $openid && $params['wechatid'] = $openid;
         empty($keyword) && $params['sort'] = 'createdtime desc';
         $params['rows'] = $rows;
         $params['start'] = $start;
         //$params['buystatus']  = 2; //'购买状态1、未购买2、购买
         if(!empty($keyword)){
            $type = $typekwds = '';
         }
         if($type && $typekwds){
            $params['type'] = $type;
            $params['typekwds'] = $typekwds;
         }
         
         $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));

         $wechats = empty($res['data']['wechats'])?array():$res['data']['wechats'];
         if($operaType == 'vcard'){
            $vcardInfo= $wechats[0];
            $this->bulidVcf($vcardInfo['vcard'], $vcardInfo['cardid'], $vcardInfo['wechatid']);
         }else{
            $this->_vcardExcelTwoSide($wechats, C('UPLOAD_PATH').'vcardinfo.xlsx','wuzhou@oradt.com',true);
         }
     }
     
     //导出数据到excel,双面导出
     private function _vcardExcelTwoSide($wechats,$fileName='名片数据.xlsx',$email){
     	$wechatsList = $this->analyShowVcard($wechats,true,false);
     	$dataNew = array();
     	foreach ($wechatsList as $obj){
     		$tmp = array_merge_recursive ($obj['front'], $obj['back']);
     		if(!$tmp){
     			continue;
     		}
     		$info = $tmp;
     		foreach ($info as $key=>$arr){
     			$info[$key] = join(',', $arr);
     		}
     		$info['picture'] = $obj['picture'];
     		//$info['uuid'] = $obj['uuid'];
     		$info['createdtime'] = date('Y-m-d H:i:s',$obj['createdtime']);
     		$dataNew[] = $info;
     	}
     	//echo $fileName;die;
     	//$headers = $dataNew ? array_keys($dataNew[0]) : array();
     	$headers = array('FN'=>$this->translator->str_excel_header_1,'ENG'=>$this->translator->str_excel_header_2,
     			'ORG'=>$this->translator->str_excel_header_6,'ORG_ENG'=>$this->translator->str_excel_header_21,
     			'JOB'=>$this->translator->str_excel_header_3,'JOB_ENG'=>$this->translator->str_excel_header_22,
     			'CELL'=>$this->translator->str_excel_header_4,'TEL'=>$this->translator->str_excel_header_5,     			
     			'DEPT'=>$this->translator->str_excel_header_7,'DEPT_ENG'=>$this->translator->str_excel_header_23,
     			'ADR'=>$this->translator->str_excel_header_8,'ADR_ENG'=>$this->translator->str_excel_header_24,
     			'URL'=>$this->translator->str_excel_header_9,'EMAIL'=>$this->translator->str_excel_header_10,
     			'createdtime'=>$this->translator->str_excel_header_11/* ,'uuid'=>'名片ID' */); //,'picture'=>'图片地址'
     	$re = $this->downloadStat($dataNew, $headers,$fileName,false,$email);
     	return $re;
     }
     
     //导出数据到excel
     private function _vcardExcel($wechats,$fileName='名片数据.xlsx',$email,$isBack=false){
        $wechatsList = $this->analyShowVcard($wechats,$isBack,false);
        $dataNew = array();
        foreach ($wechatsList as $obj){
            $tmp = $obj['front'];
            if(!$tmp){
                continue;
            }
            $info = $tmp;
            foreach ($info as $key=>$arr){
                $info[$key] = join(',', $arr);
            }
            $info['picture'] = $obj['picture'];
            //$info['uuid'] = $obj['uuid'];
            $dataNew[] = $info;
        }
        //echo $fileName;die;
        //$headers = $dataNew ? array_keys($dataNew[0]) : array();
        $headers = array('FN'=>'姓名','ORG'=>'公司','ADR'=>'地址','CELL'=>'手机','TEL'=>'电话','URL'=>'网址',
                'JOB'=>'职位','EMAIL'=>'邮箱'/* ,'uuid'=>'名片ID' */); //,'picture'=>'图片地址'
        $re = $this->downloadStat($dataNew, $headers,$fileName,false,$email);
        return $re;
     }

     /**
      * 一键导出功能
      */
     public function oneKeyExport(){
        set_time_limit(1800);
        //$openid = 'oMxRRv8ugSXKLtugVjcooWCVIrmA';'oMxRRvxhs8cXiL9mJxAaZOQOWwuI';
        $openid = $this->getOpenId('oneKeyExport', 'Wechat',array());
        if(IS_AJAX){
            $email = I('post.email','');
            $batchid = I('post.batchid','');
            if(!$email){
                $this->ajaxReturn(array('status'=>1,'msg'=>$this->translator->str_result_my_email));
            }
            $params['isself'] = 0;
            $params['wechatid'] = $openid;
            $params['batchid'] = $batchid;
            $params['rows'] = 1;
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
            $count = isset($res['data']['numfound'])?$res['data']['numfound']:0;
            if(!$count){
                $this->ajaxReturn(array('status'=>1,'msg'=>$this->translator->str_result_empty));
            }
            if($count>C('EXPORT_EXCEL_COUNT')){
                $data = array('email'=>$email);
                if($batchid){
                    $data['batchid'] = $batchid;
                }
                $re = $this->exportExecelByEmail($data);
                $succ_msg = $this->translator->str_result_output_task_success;
            }else{
                $data = $this->getAllOtherCard($openid,$batchid);
                $filename = C('UPLOAD_PATH').$openid.date('YdmHis').'.xlsx';
                $re = $this->_vcardExcelTwoSide($data,$filename ,$email);
                $succ_msg = $this->translator->str_result_output_success;
            }
            if($re['status']==0){
                $this->ajaxReturn(array('status'=>0,'msg'=>$succ_msg));
            }else{
                $this->ajaxReturn(array('status'=>1,'msg'=>$this->translator->str_result_output_fail));
            }
        }else{
            $this->assign('openid',$openid);
            $this->display('oneKeyExport');
        }
     }
     
     /**
      * 分享到公司
      */
     public function shareToCompany(){
        if(IS_AJAX){
            $openid = I('post.openid','');
            $batchid = I('post.batchid','');
            //$batchid = '1504070152956';
            if($batchid&&$openid) {
                $params['wechatid'] = $openid;
                $re = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params' => $params));
                if (empty($re['data']['wechats'][0]['bizid'])) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '您还未绑定企业'));
                }
                $bizid = $re['data']['wechats'][0]['bizid'];
                $params['bizid'] = $bizid;
                $re = \AppTools::webService('\Model\WeChat\WeChat', 'checkIndent', array('params' => $params));
                if ($re['data']['enable'] == 2) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '您的绑定企业审核未通过'));
                }
                if ($re['data']['enable'] == 3) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '您已从企业离职'));
                }
                //print_r($re);die;
                unset($params['bizid']);
                $params['batchid'] = $batchid;

                $res = \AppTools::webService('\Model\WeChat\WeChat', 'cardShareToCompany', array('params' => $params));
                if (isset($res['status']) && ($res['status'] == 0)) {
                    $this->ajaxReturn(array('status' => 0, 'msg' => '分享成功'));
                } else {
                    $this->ajaxReturn(array('status' => 1, 'msg' => $res['msg']));
                }
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'分享失败'));
        }
     }

     //测试导出某个时间点数据使用
     public function oneKeyExportTest(){
     		$email = I('post.email','zhangpeng@oradt.com');
     		if(!$email){
     			$this->ajaxReturn(array('status'=>1,'msg'=>'请输入邮箱'));
     		}
     		$openids = 'oMxRRvyklJp1r8y1ucpEbJrJETQA
oMxRRv-2ZCIIedMakMAakRu0-zUE
oMxRRv5zdePz1Lys4bsJlqG1x5-g
oMxRRv4uK4XpsLm_JzLDt_INRm7g
oMxRRv-fRmvRVIzv_-rlDO0SpqXA
oMxRRv3MLHQiigIZArmDQ3tiE0Qs
oMxRRvwEyFLDfKIeK2dwqH-l_8dQ';
     		$openids = str_replace(array("\r\n","\n",' '), array(",",",",","),$openids);
     		set_time_limit(500);
     		$arr = explode(',', $openids);
     		$data  = array();
     		foreach ($arr as $one){
     			$tmp = $this->getAllOtherCard($one);
     			$data = array_merge($data,$tmp);
     		}
     		if(!sizeof($data)){
     			$this->ajaxReturn(array('status'=>1,'msg'=>'没有符合条件的名片'));
     		}
     		$filename = C('UPLOAD_PATH').$arr[0].'.xlsx';
     		$re = $this->_vcardExcel($data,$filename ,$email);
     		echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump();exit;
     }

     //循环获取用户下所有他人名片
     private function getAllOtherCard($openid,$batchid=''){
        $params['isself'] = 0;
        $params['wechatid'] = $openid;
        $params['batchid'] = $batchid;
        $params['rows'] = 1;
        $array = array();
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        if($res['status']!=0||!$res['data']['numfound']){
            return $array;
        }
        $numfound = $res['data']['numfound'];
        $pageSize = 50;
        $totalPage = ceil($numfound/$pageSize);
        for ($i=0; $i < $totalPage; $i++) { 
            $params['rows'] = $pageSize;
            $params['start'] = $i*$pageSize;
            $params['sort'] = 'createdtime desc';
            $r = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
            if(!isset($r['data']['wechats'])){
                break;
            }
            $array = array_merge($array,$r['data']['wechats']);
        }
        return $array;
     }

     public function wifitest(){
        /*$rstToken = $this->getWxTokenToLocal(0,'wifi测试');
        $array = array('pageindex'=>1,'pagesize'=>10);
        $url = 'https://api.weixin.qq.com/bizwifi/shop/list?access_token='.$rstToken['access_token'];
        $destination = C('LOG_PATH').date('y_m_d').'wz'.'.log';      
        Log::write($url,'ERR','',$destination);
        $res = $this->exec($url,$array,'post');
        Log::write(json_encode($res),'ERR','',$destination);
        var_dump($res);*/
        $this->display('wifitest');
     }
    public function mapShow(){

        $addr = I('get.addr','');
        $this->assign('addr',$addr);
        $this->assign('keys', 'QO8ugr8aYY6ULaYcRpWo9zPM');
        $this->display('detail/map_item');

    }
    public function test(){
        $this->display('test');
    }

    public function historyFile(){
        $openid = $this->getOpenId('historyFile', 'Wechat',array());
        $params['wechat_id'] = $openid;
        $params['fileds'] = 'enclosure,create_time';
        $list = array();
        $r = \AppTools::webService('\Model\WeChat\WeChat', 'getExportLog', array('params'=>$params));
        if(!empty($r['data']['data'])){
            $list = $r['data']['data'];
        }
        $this->assign('list',$list);
        $this->display('historyFile');
    }

    /**
     * 添加备注
     */
    public  function remarksAdd()
    {   $params = array();
        $params['ids'] = '165808';
        $params['type'] = 2;
        $params['comment'] = '赖晓利的名片';
        $params['wechatid'] = 'ofIP5vgCi_HZdeh8WkLwqhdzgYqM';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'remarksAdd', array('params'=>$params));
        dump($res);die;
    }

    /**
     * 编辑备注
     */
    public  function remarksEdit()
    {   $params = array();
        $params['id'] = 24;
        $params['wechatid'] = 'ofIP5vgCi_HZdeh8WkLwqhdzgYqM';
        $params['comment'] = '备注修改';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'remarksEdit', array('params'=>$params));
        dump($res);die;
    }

    /**
     * 删除备注
     */
    public  function remarksDel()
    {   $params = array();
        $params['ids'] = 22;
        $params['wechatid'] = 'ofIP5vgCi_HZdeh8WkLwqhdzgYqM';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'remarksDel', array('params'=>$params));
        dump($res);die;
    }

    /***
     * 获取备注
     */
    public  function remarksGet()
    {   $params = array();
        $params['id'] = '165808';
        $params['type'] = 2;
        $params['wechatid'] = 'ofIP5vgCi_HZdeh8WkLwqhdzgYqM';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'remarksGet', array('params'=>$params));
        dump($res);die;
    }
}
/* EOF */
