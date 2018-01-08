<?php
namespace Demo\Controller;

use Think\Log;
use Classes\LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Classes\LINE\LINEBot;
use Classes\LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Classes\LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use Classes\LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use Classes\LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use Classes\LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use Classes\LINE\LINEBot\Response;
use Classes\LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use Classes\LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use Classes\LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use Classes\LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use Classes\LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use Demo\Controller\Base\SocialController;
use Classes\LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use Classes\LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;

class LineController extends SocialController{
    
	//网页登录信息
    public $LOGIN_CHANEL_ID = '1529492355';
    public $LOGIN_SECRET    = '2eb615b3cacbeef89e3d4fe4a93cc181';
    public $LOGIN_REDIRECT  = 'https://linetest.oradt.com/demo/line/loginRedirect';
    
    //回复信息
    public $MSG_CHANEL_ID    = '1529465562';
    public $MSG_SECRET       = '746de8e2836ac7d7721b557d06775ee8';
    public $MSG_ACCESS_TOKEN = 'EwBbu0gnE/6GaoLx/QNr9ZwaakSWCkC533xqB+WBSQ71qFL4K2jQVIJO9UVAaK7A4XwnJbhn9ggYwVu3Ehcfllk01Sy1FepEeBCv3CKd5ZqDPX6FK7GqEa3sJi2oc8VmkLl01YxgF/a2qi0ybrGR0gdB04t89/1O/w1cDnyilFU=';
    
    public $BOT = '';
    public $EVENT = '';
    
    public $POSTBACK_SET_MY_CARD = 'POSTBACK_SET_MY_CARD';
     
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
	    //echo $this->uiLang;
	    //echo WEB_SERVICE_ROOT_URL_WECHAT;
	    //print_r($_SESSION);
	    //print_r($_SERVER);
		//echo 'index';
		//echo generate_password(32);
		//print_r($_SESSION[MODULE_NAME]);
	}
	
	/**
	 * 创建bot
	 */
	private function _createBot(){
	    $httpClient = new CurlHTTPClient($this->MSG_ACCESS_TOKEN);
	    $args = array('channelSecret'=>$this->MSG_SECRET);
	    $this->BOT = new LINEBot($httpClient, $args);
	}
	
	/**
	 * 保存用户信息
	 */
	private function _saveUserInfo(){
	    $userId = $this->EVENT['source']['userId'];
	    $this->_getProfile($userId);
	    $rst = array(
	        'openid'     =>$userId,
	        'nickname'   =>$_SESSION[MODULE_NAME]['displayName'],
	        'headimgurl' =>$_SESSION[MODULE_NAME]['pictureUrl']
	    );
	    $params = array('wechatid'=> $userId, 'info'=> json_encode($rst));
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWxUserInfo', array('params'=>$params));
	    if($res['status'] != 0){
	        $this->_replyText($this->translator->str_line_save_userinfo_fail);
	        Log::write('api绑定Line信息失败:'.print_r($res,1));
	    }
	}
	
	/**
	 * event回调方法
	 */
	public function webhook(){
	    $post = $GLOBALS['HTTP_RAW_POST_DATA'];
	    $data = json_decode($post, true);
	    
	    if (empty($data['events'])) {
	        $this->_errorOut('webhook event error'.$post);
	    }
	    
	    $this->_createBot();
	    
	    for ($i = 0; $i < count($data['events']); $i++) {
	        $this->EVENT = $data['events'][$i];
	        if ($this->EVENT['type'] == 'message'){
	            $this->_webhookMessage();
	        } else if($this->EVENT['type'] == 'follow'){
	            //$this->_replyText('好友~');
	            $this->_saveUserInfo();
	        } else if($this->EVENT['type'] == 'postback'){
	            $this->_postback();
	        }
	    }
	}
	
	/**
	 * 处理postback事件
	 */
	private function _postback(){
	    $data = json_decode($this->EVENT['postback']['data'], true);
	    if ($data['type'] == $this->POSTBACK_SET_MY_CARD){
	        if (empty($data['cardid'])){
	            //$this->_pushText('操作结束');
	            $this->_cardAnalysisResult($data['cardid']);
	            return;
	        }
	        //设置为【我的名片】
	        $params['cardid']   = $data['cardid'];
	        $params['isself']   = 1;
	        $params['wechatid'] = $this->EVENT['source']['userId'];
	        $result = \AppTools::webService('\Model\WeChat\WeChat','editCardDetail',array('params'=>$params));
	        if ($result['status'] == 0){
	            $this->_pushText($this->translator->str_line_set_success);
	            $this->_cardAnalysisResult($data['cardid']);
	        } else {
	            Log::write('99999-'.json_encode($result));
	            $this->_replyText($this->translator->str_line_set_fail);
	        }
	    }
	}
	
	/**
	 * 过滤不搜索的关键字
	 * @param str $keyword
	 * @return bool
	 */
	private function _skipKeywords($keyword){
	    return in_array($keyword, array('マニュアル'));
	}
	
	/**
	 * 根据关键字，搜索相关名片
	 * @param unknown $keyword
	 */
	private function _searchCard($keyword){
	    $keyword = trim($keyword);
	    if ($this->_skipKeywords($keyword)) {
	        return;
	    }
	    $params['kwds'] = $keyword;
	    $params['wechatid'] = $this->EVENT['source']['userId'];
	    $params['rows'] = 5;
	    //$params['buystatus']  = 2; //'购买状态1、未购买2、购买
	    
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
	    
	    if (empty($res['data']['wechats'])) {
	        $this->_replyText($this->translator->str_line_card_none);
	    }
	    
	    $wechat = A('Wechat');
	    $info = $wechat->analyShowVcard($res['data']['wechats']);
	    $columnTemplateBuilders = array();
	    for ($i = 0; $i < count($info); $i++) {
	        $tmp = $info[$i];
	        $url = U(MODULE_NAME.'/Wechat/wDetailZp', array("cardid"=>$tmp['cardid']), false, true);
	        $name = $tmp['front']['FN'][0];
    	    empty($name) && $name = '-';
    	    $company = $tmp['front']['ORG'][0];
    	    empty($company) && $company = '-';
	        $actionBuilders = array(
	            new UriTemplateActionBuilder($this->translator->str_line_show, $url),
	        );
	        $thumbnailImageUrl = $tmp['smallpicture'];
	        $columnTemplateBuilders[] = new CarouselColumnTemplateBuilder($name, $company, $thumbnailImageUrl, $actionBuilders);
	    }
	    $templateBuilder = new CarouselTemplateBuilder($columnTemplateBuilders);
	    $builder = new TemplateMessageBuilder($this->translator->str_line_card_none, $templateBuilder);
	    $this->BOT->pushMessage($this->EVENT['source']['userId'], $builder);
	}
	
	/**
	 * 解析消息类型事件
	 * @param arr $evt
	 * @param obj $bot
	 */
	private function _webhookMessage(){
	    if ($this->EVENT['message']['type'] == 'text') {
	        $text = strtolower($this->EVENT['message']['text']);
	        /*
	        if ($text=='111'){
	            //TODO DELETE
	            $linkUri =  U(MODULE_NAME.'/ConnectScanner/showScanningVcard','', false, true)."?cardid=".$newcardid."&openid=".$openid.'&batchid='.$batchid;
	            $baseUrl = "https://linetest.oradt.com/demo/line/image/result5";
	            $altText = "result";
	            $baseSizeBuilder = new BaseSizeBuilder(1040, 1040);
	             
	            $areaBuilder = new AreaBuilder(0, 0, 1040, 1040);
	            $imagemapActionBuilders = new ImagemapUriActionBuilder($linkUri, $areaBuilder);
	            $bulder = new ImagemapMessageBuilder($baseUrl, $altText, $baseSizeBuilder, array($imagemapActionBuilders));
	            $response = $this->BOT->pushMessage($this->EVENT['source']['userId'], $bulder);
	            die;
	        }*/
	        if ($this->_skipKeywords($text)) {
	            return;
	        }
	        if (!$this->_bindScannerBegin($text)){
	            //$this->_searchCard($text);
	            $this->_replyText($this->translator->str_line_no_scanner);
	        }
	    } else if($this->EVENT['message']['type'] == 'image'){
	        $file = $this->_getMessageContent('image');
            $image = new \ZBarCodeImage($file);
            $scanner = new \ZBarCodeScanner();
            $barcode = $scanner->scan($image);
            
            $flag = true;
            if (!empty($barcode)) {
                //$this->_replyText(json_encode($barcode));
                foreach ($barcode as $code) {
                    //printf("Found type %s barcode with data %s\n", $code['type'], $code['data']);
                    if ($this->_bindScannerBegin($code['data'])){
                        //$this->_replyText($code['data']);
                        $flag = false;
                    }
                }
            }
            //$this->_replyText('no code');
            if ($flag) {
                $this->_cardAnalysis($file);
            }
	    } else if($this->EVENT['message']['type'] == 'audio'){
	        $file = $this->_getMessageContent('audio');
	        //$this->_replyText('音频文件已经获取');
	    } else {
	        //$this->_replyText('暂不支持该消息类型');
	    }
	}
	
	/**
	 * 名片识别成功后的图文推送
	 * @param str $cardid
	 */
	private function _cardAnalysisResult($cardid){
	    $params['cardid'] = $cardid;
	    $params['wechatid'] = $this->EVENT['source']['userId'];
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
	    
	    $wechat = A('Wechat'); //调用line授权
	    $info = $wechat->analyShowVcard($res['data']['wechats'])[0];
	    $name    = $info['front']['FN'][0];
	    empty($name) && $name = '-';
	    $company = $info['front']['ORG'][0];
	    empty($company) && $company = '-';
	    $url = U(MODULE_NAME.'/Wechat/wDetailZp', array("cardid"=>$info['cardid']), false, true);
	    
	    $actionBuilders = array(
	        new UriTemplateActionBuilder($this->translator->str_line_show, $url),
	    );
	    $thumbnailImageUrl = $info['smallpicture'];
	    $templateBuilder = new ButtonTemplateBuilder($name, $company, $thumbnailImageUrl, $actionBuilders);
	    $builder = new TemplateMessageBuilder($this->translator->str_line_card_scan_success, $templateBuilder);
	    $this->BOT->pushMessage($this->EVENT['source']['userId'], $builder);
	}
	
	/**
	 * 解析名片
	 * @param unknown $file
	 */
	private function _cardAnalysis($filename){
	    $userId = $this->EVENT['source']['userId'];
	    $params['picpatha']   = $filename;
	    $params['wechatid']   = $userId;
	    $params['languagelt'] = 6;
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'wechatSave2', array('params'=>$params));
	    //Log::write('66666'.json_encode($res));
	    
	    if ($res['status'] != 0){
	        if ($res['status']==999021){
	            $msg = $this->translator->str_line_scan_fail_direction;
	        } else {
	            $msg = $res['msg'];
	        }
	        unlink($filename);
	        $this->_replyText($msg);
	    }
	    unlink($filename);
	    
	    $cardid = $res['data']['cardid'];
	    
	    //查找我的名片是否存在
	    $params = array();
	    $params['isself'] = 1;
	    $params['wechatid'] = $userId;
	    
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
	    //Log::write('88888'.json_encode($res));
	    if (!empty($res['data']['numfound'])){
	        $this->_cardAnalysisResult($cardid);
	    } else {
	        $no  = array('type'=>$this->POSTBACK_SET_MY_CARD);
	        $yes = array('type'=>$this->POSTBACK_SET_MY_CARD, 'cardid'=>$cardid);
	        $actionBuilders = array(
	            new PostbackTemplateActionBuilder($this->translator->str_line_no, json_encode($no)),
	            new PostbackTemplateActionBuilder($this->translator->str_line_yes, json_encode($yes)),
	        );
	        $templateBuilder = new ConfirmTemplateBuilder($this->translator->str_line_is_set_mycard, $actionBuilders);
	        $builder = new TemplateMessageBuilder($this->translator->str_line_is_set_mycard, $templateBuilder);
	        $this->BOT->pushMessage($userId, $builder);
	        return;
	    }
	}
	
	/**
	 * 根据消息ID，获取文件
	 * @param str $type (image,audio)
	 */
	private function _getMessageContent($type){
	    $response = $this->BOT->getMessageContent($this->EVENT['message']['id']);
	    if ($response->isSucceeded()) {
	        $filename = C('UPLOAD_PATH').generate_password(32);
	        if ($type == 'audio'){
	            $filename .= '.m4a';
	        } else {
	            $filename .= '.jpg';
	        }
	        file_put_contents($filename, $response->getRawBody());
	        return $filename;
	    } else {
	        //error_log($response->getHTTPStatus() . ' ' . $response->getRawBody());
	        $this->_replyText($response->getHTTPStatus() . ' ' . $response->getRawBody());
	    }
	}
	
	/**
	 * 通过userId获取用户信息
	 * @param unknown $userId
	 */
	private function _getProfile($userId){
	    $response = $this->BOT->getProfile($userId);
	    if ($response->isSucceeded()) {
	        $profile = $response->getJSONDecodedBody();
	        $this->_setProfileToSession($profile);
	    } else {
	        $this->_replyText($this->translator->str_line_no_profile);
	    }
	}
	
	/**
	 * 回复信息
	 * @param unknown $text
	 */
	private function _replyText($text){
	    $messageBuilder = new TextMessageBuilder($text);
	    $this->BOT->replyMessage($this->EVENT['replyToken'], $messageBuilder);
	}
	
	/**
	 * 推送信息
	 * @param unknown $text
	 */
	private function _pushText($text){
	    $messageBuilder = new TextMessageBuilder($text);
	    $this->BOT->pushMessage($this->EVENT['source']['userId'], $messageBuilder);
	}
	
	/**
	 * 把用户信息写入session
	 * @param unknown $profile
	 */
	private function _setProfileToSession($profile){
	    $_SESSION[MODULE_NAME]['userId']      = $profile['userId'];
	    $_SESSION[MODULE_NAME]['displayName'] = $profile['displayName'];
	    $_SESSION[MODULE_NAME]['pictureUrl']  = $profile['pictureUrl'];
	    $_SESSION[MODULE_NAME]['openid']      = $profile['userId'];
	}
	
	/**
	 * Line用到的图片
	 */
	public function image(){
	    $size = end(explode('/', $_SERVER['REQUEST_URI']));
	    header('Content-type: image/jpg');
	    echo file_get_contents('line/result5.png');
	}
	
	/**
	 * 接收扫描仪推送消息方法
	 */
	public function linePushMessage(){
	    $this->_createBot();
	    $type    = I('type','text'); //推送类型:text文本，image:图片,默认text
	    $openid  = I('openid'); //微信id
	    $bulder  = '';
	    
	    Log::write('linePushMessage-params'.json_encode($_REQUEST));
	    if($type == 'fixedimage'){
	        $batchid = I('batchid'); //批次id
	        
	        //推送固定图片消息
	        $params = array();
	        $params['wechatid'] = $openid;
	        $params['start'] = 0;
	        $params['rows']  = 1;
	        $params['new']   = 1;
	        $params['sort']  = 'cardid desc';
	        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
	        $newcardid = empty($res['data']['wechats'])?0:$res['data']['wechats'][0]['cardid'];
	        
	        //图文消息链接
	        $linkUri =  U(MODULE_NAME.'/ConnectScanner/showScanningVcard','', false, true)."?cardid=".$newcardid."&openid=".$openid.'&batchid='.$batchid;
	        $baseUrl = "https://linetest.oradt.com/demo/line/image/result5";
	        $altText = "result";
	        $baseSizeBuilder = new BaseSizeBuilder(1040, 1040);
	        
	        $areaBuilder = new AreaBuilder(0, 0, 1040, 1040);
	        $imagemapActionBuilders = new ImagemapUriActionBuilder($linkUri, $areaBuilder);
	        $bulder = new ImagemapMessageBuilder($baseUrl, $altText, $baseSizeBuilder, array($imagemapActionBuilders));
	    } else {
	        $text   = I('text',$this->translator->str_line_scan_finish);//消息文案
	        $text   = htmlspecialchars_decode($text);
	        $bulder = new TextMessageBuilder($text);
	    }
	    
	    $response = new Response('', '');
	    $response = $this->BOT->pushMessage($openid, $bulder);
	    $json = $response->getJSONDecodedBody();
	    if (empty($json)) {
	        echo json_encode(array('status'=>0));
	    } else {
	        echo $response->getRawBody();
	    }
	}
	
	/**
	 * 开始绑定扫描仪
	 * @param unknown $code
	 */
	private function _bindScannerBegin($code, $file=''){
	    $text = strtolower(trim($code));
	    if (!preg_match("/^\\d{8}$/", $text)){
	        return false;
	    }
	    
	    $scanners = array(
	        '08112345' => array(
	            'scannerID' => 'iX500-A0WB007177',
	            'scannerPW' => '7177'
	        ),
	        '08100001' => array(
	            'scannerID' => 'iX500-A0WB019877',
	            'scannerPW' => '9877'
	        ),
	    );
	    
	    if (is_array($scanners[$text])){
	        $scannerID = $scanners[$code]['scannerID'];
	        $scannerPW = $scanners[$code]['scannerPW'];
	        $rst = $this->_bindScanner($scannerID, $scannerPW, $this->EVENT['source']['userId'], 'line');
	        if ($rst == 0) {
	            !empty($file) && \GFile::delfile($file);
	            $this->_replyText($text.$this->translator->str_line_bind_success);
	            return true;
	        }
	    }
	    /*
	    if ($text == '08112345') {
	        $scannerID = 'iX500-A0WB007177';
	        $scannerPW = '7177';
	        $rst = $this->_bindScanner($scannerID, $scannerPW, $this->EVENT['source']['userId'], 'line');
	        if ($rst == 0) {
	            !empty($file) && \GFile::delfile($file);
	            $this->_replyText($text.$this->translator->str_line_bind_success);
	            return true;
	        }
	    }*/
	    //$this->_replyText($code.'绑定失败');
	    return false;
	}
	
	/**
	 * 绑定扫描仪
	 * @param unknown $scannerID
	 * @param unknown $scannerPW
	 * @param unknown $userId
	 * @param unknown $platform
	 */
	private function _bindScanner($scannerID, $scannerPW, $userId, $platform){
	    $status = 1;
	    $this->_getProfile($userId);
	    if (empty($_SESSION[MODULE_NAME]['userId'])) {
	        return $status;
	    }
	    
	    $params = array('wechatid'=> $userId, 'scannerinfo'=> $scannerID.$scannerPW);
	    $res = \AppTools::webService('\Model\WeChat\WeChat', 'bindWxUserInfo', array('params'=>$params));
	    if($res['status'] == 0){
	        $time = time();
	        $params = array('wechatid'=> $userId);
	        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
	        if(!empty($res['data']['wechats'])){
	            $wechats = $res['data']['wechats'][0];
	            $wxInfo = json_decode($wechats['wechatinfo'],true);
	            $deviceid = $wechats['scannerinfo'];//扫描仪设备id
	            $commandInfo = array(
    				'nickname'	 => $_SESSION[MODULE_NAME]['displayName'],
    				'headimgurl' => $_SESSION[MODULE_NAME]['pictureUrl'],
    				'wechatid'   => $userId,
    				'status'     => 1, //1:绑定扫描仪，2：启动扫描仪  3：停止扫描仪 4：退出扫描仪 5:(取消关注公众号时退出扫描仪),6:任意扫描
    				'time'       => $time,
    				'publictype' => $platform //公众号来源:line weixin
	            );
	            $params = array('deviceid'=> $deviceid,'info'=>json_encode($commandInfo));
	            //Log::write('-------##扫描名片#改变扫描仪状态:'.var_export($params,true));
	            $res = \AppTools::webService('\Model\WeChat\WeChat', 'startScannerOpera', array('params'=>$params));
	            $status = $res['status'];
	        }
	        return $status;
	    }
	    return $status;
	}
	
	/**
	 * 授权登录
	 */
	public function login(){
	    $state = rand(1, 99999);
	    $_SESSION[MODULE_NAME]['state'] = $state;
	    //print_r($_SESSION);die;
	    header("Location: https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={$this->LOGIN_CHANEL_ID}&redirect_uri=".urlencode($this->LOGIN_REDIRECT)."&state={$state}");
	}
	
	/**
	 * 错误输出+保存日志
	 * @param str or arr $msg
	 */
	private function _errorOut($msg){
	    if (is_array($msg)) {
	        $msg = print_r($msg, true);
	    }
	    Log::write('Line-ERROR--：'.$msg);die;
	}
	
	/**
	 * 授权登录回调
	 */
	public function loginRedirect(){
	    //echo 'redirect';
	    //print_r($_SESSION);die;
	    if ($_GET['errorCode']) {
	        $this->_errorOut($_GET);
	    }
	    
	    //验证state是否匹配
	    if ($_GET['state'] != $_SESSION[MODULE_NAME]['state']) {
	        echo 'different state code!'.$_SESSION[MODULE_NAME]['state'];
	        $this->_errorOut('different state code!');
	    }
	    unset($_SESSION[MODULE_NAME]['state']);
	    
	    $code = $_GET['code'];
	    $token = $this->_getAccessToken($code);
	    $_SESSION[MODULE_NAME]['token'] = $token;
	    
	    $curl = new CurlHTTPClient($token['access_token']);
	    $response = $curl->get('https://api.line.me/v2/profile');
	    $response = json_decode($response->getRawBody(), true);
	    if (empty($response)) {
	        $this->_errorOut('no login info!');
	    }
	    
	    $this->_setProfileToSession($response);  
	    
	    if(!empty($_SESSION[MODULE_NAME]['urlRedirect'])){
	    	redirect($_SESSION[MODULE_NAME]['urlRedirect']);
	    } 
	}
	
	/**
	 * 发送post请求（获取access_token）
	 * @param string $url
	 * @param array $post_data post
	 * @return string
	 */
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
	        $this->_errorOut($msg);
	    }
	    curl_close($ch);
	    return $data;
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
	    $response = json_decode($response, true);
	    if (empty($response['access_token'])) {
	        $this->_errorOut('no access_token!');
	    }
	    return $response;
	}
	
}
/* EOF */
