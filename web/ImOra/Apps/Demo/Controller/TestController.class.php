<?php
namespace Demo\Controller;

use Think\Log;
use Classes\GFunc;
use Demo\Controller\Base\WxBaseController;

import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
//import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class TestController extends WxBaseController
{

	//get请求方式
	const METHOD_GET  = 'get';
	//post请求方式
	const METHOD_POST = 'post';
	//private $session = null; //定义session变量
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

    public function listener ()
    {
    	if (isset($_GET['echostr'])) {
    		echo $_GET['echostr'];
    		exit;
    	}
    	
        $xml = (array) simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
        Log::write($GLOBALS['HTTP_RAW_POST_DATA']);
        Log::write(' 公众号接收到的xml格式：'.json_encode($xml));

        if ($xml['MsgType'] == 'image') {
/*             if ('ofIP5vqZUs5C5Y-AiJ11vgXp-K3g' == $xml['FromUserName']) {
                //吴州
                $this->wuzhou($xml);
            } else { */
                //崔盛辉
                $this->cuishenghui($xml);
            //}
        }
        if ($xml['MsgType'] == 'voice') {
            //张鹏
            $this->zhangpeng($xml);
        }else if($xml['MsgType'] == 'text'){
        	$this->zhangpeng($xml);
        }else if($xml['MsgType'] == 'event'){
        	if($xml['Event'] == 'subscribe'){
        		$this->saveWxUserInfo($xml);
        	}
        }

        die;
        exit($_GET['echostr']);

        /*
        $wechat = new WechatListener(TOKEN);
        $testHandler = new TestHandler();
        $wechat->setHandler(array('text'        => array($testHandler, 'handleText'),
                'subscribe'   => array($testHandler, 'handleSubscribe'),
                'click'   => array($testHandler, 'handleClick'),
        )
        )
        ->listen();
        */
    }

    //测试h5录音功能
    public function voice(){
    	$this->display('voice');
    }
    
    //测试滑动方向
    public function touchDirection()
    {
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump(C('Wechat'));exit;
    	$this->display('touchDirection');
    }
    
    public function processRequest(){
    	$data = base64_decode(str_replace('data:image/jgp;base64,', '', I('data')));
    	$filepath = WEB_ROOT_DIR . 'test/qrcode/images/';
    	if (!is_dir($filepath)){
    		$flag = mkdir($filepath, 0777, true);
    		if($flag == false){
    			log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
    		}
    	}
    	$filename = $filepath.md5($data).'.jpg';
    	file_put_contents($filename, $data);
    }
    

    
    /**
     * 发送邮件
     */
    public function getSes(){
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r(session(MODULE_NAME),1);exit;
    }
   
}

/* EOF */
