<?php
/**
 * 关于企业信息相关Controller
 * @author zhangpeng
 *
 */
namespace Demo\Controller;

use Think\Log;
use Demo\Controller\Base\WxBaseController;

use Classes\GFunc;
import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class CompanyExtendController extends WxBaseController
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

    /**
     * 获取公司名片信息
     */
    public  function cardsList(){
    	$params['user_id'] = I('get.id','ofIP5vnuTl1UTMpiIu3pO4_mRQ90'); //公司名称
    	$params['company_name']  = urldecode(I('get.name','京中粮广场发展有限公司')); //公司名称
		$data = $this->_post('/corporate_information_query_interface/card_statistics/', $params);
		$list = parseApi(json_encode($data,true));
    	
		$this->assign('list',$list['data']['card_list']);
    	$this->display('cardsList');
    }
    



    /**
     * 绑定员工页面
     */
    public function bindEmployPage(){
    	$bizId = I('bizId'); //企业id
    	$openid = I('openid'); //微信id
    	$this->_authBase('bindEmployPage', 'CompanyExtend',array('bizId'=>$bizId,'openid'=>$openid,'bindedId'=>$bindedId)); //微信基本授权操作
    	$entInfo = $this->getBizInfoByXId($bizId);
    	if(empty($entInfo)){
            $this->assign('info','未查询到相关企业信息');
            $this->display('unbindedPage');
            exit;
    	}
    	$this->assign('bizName', $entInfo['bizname']); //企业名字
    	$this->assign('bizId', $entInfo['bizid']); //企业id
    	$this->display('bindEmployeePage');
    }


    /**
     * 绑定员工操作
     */
    public function bindEmployOpera()
    {
    	$mobile = I('mobile'); //手机号
    	$mcode = I('mcode','86'); //手机前缀
    	$code  = I('code'); //验证码
    	$email = I('email'); //邮箱
    	$password  = I('password'); //密码
    	$messageid = I('messageid'); //短信ID    	
    	$name = I('name'); //姓名
    	$bizId = I('bizId'); //企业id
    	$params['name'] = $name;
    	$params['mobile'] = $mobile;
    	$params['mcode'] = $mcode;
    	$params['email'] = $email;
    	$params['passwd'] = $password;
    	$params['bizid'] = $bizId;
    	$params['wechatid'] = $this->session['openid'];
//    	$params['wechatid'] = 'ofIP5vth-O1CVoun0Q4bXG0dPTFA';
    	$flag = $this->verifyMobileCode($mobile,$messageid, $code);
    	if($flag != 0){
    		$this->ajaxReturn(array('status'=>$flag,'msg'=>'验证手机验证码失败','data'=>'验证手机验证码失败'));
    	}
    	$res = \AppTools::webService('\Model\WeChat\WeChat', 'employBindEnt', array('params'=>$params));
//    	$this->ajaxReturn($res);
    	if($res['status'] === 0){
            $this->ajaxReturn(array('status'=>0,'msg'=>'绑定成功','data'=>''));
        }
        elseif($res['status'] === 999004){
            $this->ajaxReturn(array('status'=>1,'msg'=>'您还没有关注微信','data'=>''));
        }
        elseif($res['status'] === 999005){
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户已绑定过','data'=>''));
        }
        elseif($res['status'] === 999020){
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户不存在','data'=>''));
        }
        elseif($res['status'] === 100011){
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户异常','data'=>''));
        }
        elseif($res['status'] === 999015){
            $this->ajaxReturn(array('status'=>1,'msg'=>'要绑定的企业不存在','data'=>''));
        }
        elseif($res['status'] === 999033){
            $this->ajaxReturn(array('status'=>1,'msg'=>'已绑定其他企业','data'=>''));
        }
        elseif($res['status'] === 999003){
            $this->ajaxReturn(array('status'=>1,'msg'=>'参数不够','data'=>''));
        }
        else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'用户不存在','data'=>''));
        }
    }
    /**
     * 员工解绑企业页面
     */
    public function unbindEnt()
    {
        $bizId = I('bizId'); //企业id
        $openid = I('openid'); //微信id
        $bindedId = I('bindedId','');//要解绑的企业
        $params = array('wechatid'=> $openid);
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
        if(empty($res['data']['wechats']) || empty($res['data']['wechats'][0]['bizid'])){//已解绑过
            $this->assign('info','您已经解绑,请重新扫描二维码');
            $this->display('unbindedPage');
        }
        elseif($res['data']['wechats'][0]['bizid']!==$bindedId){
            $bizInfo = $this->getBizInfoByXId($res['data']['wechats'][0]['bizid']);
            if(empty($bizInfo)){
                $this->assign('info','未查询到相关企业信息');
                $this->display('unbindedPage');
                exit;
            }
            $this->assign('bizName', $bizInfo['bizname']); //要解绑的企业名字
            $this->assign('bindedId', $res['data']['wechats'][0]); //要解绑的企业id
            $this->assign('bizId', $bizId); //要加入的企业id
            $this->assign('openid', $openid);
            $this->display('unbindEnt');
        }
        else{
            $entInfo = $this->getBizInfoByXId($bindedId);
            if(empty($entInfo)){
                $this->assign('info','未查询到相关企业信息');
                $this->display('unbindedPage');
                exit;
            }
            $this->assign('bizName', $entInfo['bizname']); //要解绑的企业名字
            $this->assign('bindedId', $bindedId); //要解绑的企业id
            $this->assign('bizId', $bizId); //要加入的企业id
            $this->assign('openid', $openid);
            $this->display('unbindEnt');
        }
    }

    /**
     * 解绑企业操作
     */
    public function unbindEntOpera(){
        $bindedId = I('bindedId');//要解绑的企业
        $openid = I('openid');//要解绑的企业
        //解绑以前的企业
        if($bindedId&&$openid){
            $params = array('wechatid'=>$openid, 'bizid'=>$bindedId);
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'employUnBindEnt', array('params'=>$params));
            if($res['status']===0){
                $this->ajaxReturn(array('status'=>0,'msg'=>'','data'=>''));
            }
            elseif($res['status']===310004){
                $this->ajaxReturn(array('status'=>1,'msg'=>'您是最后超级管理员，不能解绑'));
            }
            elseif($res['status']===999020){
                $this->ajaxReturn(array('status'=>1,'msg'=>'员工不存在'));
            }
            else{
                $this->ajaxReturn(array('status'=>1,'msg'=>$res['msg']));
            }
        }
    }
    public function ajaxUnBind()
    {
        $openid = I('openid');
        $bindedId = I('bindedId');
        $params = array('wechatid'=>$openid, 'bizid'=>$bindedId);
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'employUnBindEnt', array('params'=>$params));
        if($res['status'] === 0){
            $this->ajaxReturn($res);
        }
        elseif($res['status']===310004){
            $this->ajaxReturn(array('status'=>1,'msg'=>'您是最后超级管理员，不能解绑'));
        }
        elseif($res['status']===999020){
            $this->ajaxReturn(array('status'=>1,'msg'=>'员工不存在'));
        }
        else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'解绑失败'));
        }
    }
    //根据企业id获取二维码页面
    public function entQrCode()
    {
        $session = session(MODULE_NAME);
        $params = $session['bizid'];
        $res = \AppTools::webService('\Model\Company\CompanyBaseInfo', 'getBizInfoByXId', array('id'=>$params));
        $session['bizid'] = $res['bizid'];
        $session['bizIntid'] = $res['id'];
        session(MODULE_NAME, $session);
        $name = $res['id'];
        $info = $this->getQRCode($name);
        Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n生成企业二维码2：<pre>".''.var_export($info,true));
        if($info['status'] == 0){
            $imageBinary = file_get_contents($info['url']);
            $contentType = 'image/jpg';
            header('Content-type: ' . $contentType);
            echo $imageBinary;
        }else{
            echo '';
        }
    }


    /*
     * 根据企业id生产带参数二维码
     * @param int $prefix 二维码前缀 : 1 企业二维码前缀 2 单个扫描议二维码前缀 3 批量扫描仪二维码前缀
     */
    private function getQRCode($name,$prefix=1){
        $prefixStr = '';$source = '';
        switch($prefix){
            case 1:$prefixStr = C('COMPANY_QR_PREFIX');$source = '根据企业id获取二维码';break;
            case 2:$prefixStr = C("SCANNER_QR_PREFIX");$source = '根据扫描仪名称获取二维码';break;
            case 3:$prefixStr = C("SCANNER_QRS_PREFIX");$source = '根据扫描仪名称获取二维码';break;
        }
        $name = $prefixStr.$name;
        $token = $this->getAcessToken(0,$source);
        $scene = array(
            'scene_id' => $name,
            'scene_str' => $name
        );
        $postArr = array(
            'expire_seconds'=>2592000,
            'action_name'=>'QR_STR_SCENE',
            'action_info'=>array(
                'scene'=>$scene,
            ),
        );
        $postJson = json_encode($postArr);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
        $res = $this->exec($url,$postJson,'POST');
        $info = json_decode($res,true);
        $status = 0;$msg = '';
        Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n生成企业二维码1：<pre>".''.var_export($info,true));
        if(empty($info['ticket'])){
            $status = $info['errcode'];
            $msg = $info['errmsg'];
        }else{
            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.@$info['ticket'];
        }
        return array('status'=>$status,'msg'=>$msg,'url'=>$url);
    }
    public function getSession()
    {
        dump(session(MODULE_NAME));
    }
    /*
     *个人端企业注册
     */
    public function register()
    {
        if(IS_GET){
            $this->_weixinAuthBase('register', 'CompanyExtend');
            $openid = $this->session['openid'];
            $params = array('wechatid'=> $openid);
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBindWxUserInfo', array('params'=>$params));
            if(empty($res['data']['wechats']) || empty($res['data']['wechats'][0]['bizid'])){
                $this->assign('openid',$openid);
                $this->display('bindNum');
            }else{//已经绑定企业
                $bizId = $res['data']['wechats'][0]['bizid'];
                $bizInfo = $this->getBizInfoByXId($bizId);
                $session = session(MODULE_NAME)?:array();
                $session['bizid'] = $bizId;
                $session['bizname'] = $bizInfo['bizname'];
                session(MODULE_NAME, $session);
                if($bizInfo){
                    $bizId = $res['data']['wechats'][0]['bizid'];
                    $bizName = $bizInfo['bizname'];
                    $this->redirect('myCompany',array('openid'=>$openid,'bizid'=>$bizId));
                }
            }
        }elseif (IS_AJAX){
            $phone = I('post.mobile');
            $password = I('post.password');
            $company = I('post.company');
            $mcode = I('post.mcode','86');
            $employeename = I('post.employeename','');
            $params = array();
            $params['user'] = $phone;
            $params['password'] = $password;
            $params['company'] = $company;
            $params['mcode'] = $mcode;
            $params['type'] = 1;
            $params['openid'] = $this->session['openid'];
            $params['name'] = $employeename;
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'register',array('params'=>$params,'crudMethod'=>'C'));
            if($res['status']===0){
                $session = array();
                $session['bizid'] = $res['data']['bizid'];
                session(MODULE_NAME, $session);
                $this->ajaxReturn(['status'=>0,'msg'=>'申请成功','bizid'=>$res['data']['bizid']]);
            }elseif($res['status']===999005){
                $this->ajaxReturn(['status'=>1,'msg'=>'手机号已存在']);
            }elseif($res['status']===999022){
                $this->ajaxReturn(['status'=>1,'msg'=>'企业已注册']);
            }
        }
    }
    //我的企业
    public function myCompany()
    {
        $session = session(MODULE_NAME);
        $bizname = $session['bizname'];
        $openid = I('openid');
        $bizid= I('bizid');
        $this->_authBase('myCompany', 'CompanyExtend',array('bizname'=>$bizname,'openid'=>$openid,'bizid'=>$bizid));
        $this->assign('bizname',$bizname);
        $this->assign('openid',$openid);
        $this->assign('bizid',$bizid);
        $this->display('myCompany');
    }
    public function bindSuccess()
    {
        $this->display('bindSucess');
    }
    /**账号申请**/
    public function bindNum(){
        $this->display('bindNum');
    }
    /**判断是否加入公司**/
    public function newsCompany(){
        $this->display('newsCompany');
    }
    /**申请结果**/
    public function bindSucess(){
        $url = 'http://web.orayun.com:8006/Company/AdminSet/getQRByName.html';
        curlPost($url,array(''));
        $this->display('bindSucess');
    }
    /*
     * 企业名称验证
     */
    public function checkCompany()
    {
        $companyName = I('post.companyName');
        $params = array(
            'company' => $companyName
        );
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'checkCompany', array('params'=>$params));
        $this->ajaxReturn($res);
    }

    /*
    * 企业手机号验证
    */
    public function checkMobile()
    {
        $mobile = I('post.mobile');
        $params = array(
            'mobile' => $mobile
        );
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'checkMobile', array('params'=>$params));
        $this->ajaxReturn($res);
    }
    /**
     * 给手机发送验证码
     */
    public function sendMobileCode()
    {
        $mobile = I('mobile'); //手机号
        $params['mobile'] = $mobile;
        $params['mcode'] = I('mcode','86');
        $params['module'] = 'accountbiz';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'sendMobileCode', array('params'=>$params));
        $this->ajaxReturn(array('status'=>0,'msg'=>'','data'=>$res['data']['messageid']));
    }
    /**
     * 验证短信验证码
     */
    public function verifyMobileCode($mobile,$messageid, $code,$mcode='86'){
        $mobile = I('mobile'); //手机号
        $params['mobile'] = $mobile;
        $params['mcode'] = $mcode;
        $params['code'] = $code;
        $params['messageid'] = $messageid;
        $params['module'] = 'accountbiz';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'verifyMobileCode', array('params'=>$params));
        return $res['status'];
    }
    public function verifyMobileCode2($mobile,$messageid, $code,$mcode='86'){
        $mobile = I('mobile'); //手机号
        $params['mobile'] = $mobile;
        $params['mcode'] = $mcode;
        $params['code'] = $code;
        $params['messageid'] = $messageid;
        $params['module'] = 'accountbiz';
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'verifyMobileCode', array('params'=>$params));
        $this->ajaxReturn(array('status'=>$res['status']));
    }

    public function qrCode()
    {
        $filePath = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/C8CjulrrNGtFYwd8MQVJ4FkMLxzPNDYi.vcf";
        $str = <<<STR

BEGIN:VCARD
VERSION:3.0
FN:户胀开
PROFILE:VCARD
TEL;TYPE=WORK,PREF=1:075632001737436059313233
TEL;TYPE=WORK,PREF=1:0756786
TITLE:名\:陈春钡
ORG:江苏三麦食品机械有限公司汇款资料
N:户胀开;;;;
END:VCARD
STR;

        include_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";
//        \QRcode::png(file_get_contents($filePath));
        \QRcode::png($str);
    }


}

/* EOF */
