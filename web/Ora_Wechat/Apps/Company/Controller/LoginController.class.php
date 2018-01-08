<?php
namespace Company\Controller;

use BaseController\LoginBaseController;
use Classes\GConf;
use Classes\GFunc;
/**
 * 企业后台登陆类
 */
class LoginController extends LoginBaseController
{

    public $verify = array();
    private $info = null;
    private $certification = null;
    private $selfWebUrl = 'web.oradt.com:8006';
    private $qrcodeCssUrl = 'https://web.oradt.com/css/Company/qrcode.css';
    public function _initialize(){
    	parent::_initialize();
    	// 增加翻译文件
        $this->qrcodeCssUrl.= '?'.time();
    	$this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
    	$this->assign('T',$this->translator);
    }
    public function serveText()
    {
    	$this->display('serveText');
    }
    /**
     * 用户登陆页
     */
    public function index()
    {
        /*if (IS_AJAX) {
            $key = I('get.key', mt_rand());
            $flag = session($key . 'verify.bool');
            if (!$flag) {
                $r = array('status' => '100011');
                $this->_ajaxRtnInfo($r);
            } 
        }*/
        $session = session(MODULE_NAME);
        $redirectUrl = '';
        if(isset($session['username'])&&($session['username'])){
            $redirectUrl = U(MODULE_NAME.'/Index/index');
        }
        if(IS_AJAX){
            if($redirectUrl){
                $this->ajaxReturn(array('status'=>0,'url'=>$redirectUrl));
            }else{
                $user = I('post.account','');
                $passwd = I('post.password','');
                if($user&&$passwd){
                    $params['user'] = $user;
                    $params['passwd'] = $passwd;
                    $res = \AppTools::webService('\Model\Company\CompanyLogin', 'LoginPost', array('params'=>$params));
                    //print_r($res);die;
                    if($res['status']==0){
                        $time = time();
                        $clientid = $res['data']['clientid'];
                        
                        $session['username'] = $user;
                        $session['login_succ'] = 1;
                        $session['accesstoken'] = $res['data']['accesstoken'];
                        $session['tokenExpireTime'] = $res['data']['expiration']+$time;
                        $session['bizid'] = $res['data']['bizid'];
                        $session['clientid'] = $clientid;
                        $session['roleid'] = $res['data']['roleid'];
                        $session['created_time'] = $res['data']['created_time'];
                        $session['loginTimestamp'] = $time;
                        if($res['data']['roleid']==1 || $res['data']['roleid']==2){ //超级管理员和普通管理员都有权限进入管理设置
                            $session['isAdmin'] = 1;
                        }
                        session(MODULE_NAME,$session);
                        //echo 11111111111111;
                        $res1 = \AppTools::webService('\Model\Company\CompanyLogin', 'getEmpInfo', array('params'=>array('id'=>$clientid)));
                        if(isset($res1['data']['list'][0])){
                            $session['name'] = $res1['data']['list'][0]['name'];
                        }
                        $res2 = \AppTools::webService('\Model\Departments\Departments', 'getBizInfo',array('params'=>array('bizid'=>$res1['data']['list'][0]['bizid'])));
                        if(isset($res2['data']['numfound'])&&($res2['data']['numfound']==1)){
                        	$session['bizname'] = $res2['data']['list'][0]['bizname'];
                        	session(MODULE_NAME,$session);
                        }

                        $this->ajaxReturn(array('status'=>0,'url'=>$redirectUrl));
                    }elseif($res['status']=='100010'){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'用户名或密码错误'));
                    }elseif($res['status']=='100009'){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'此用户名未注册'));
                    }elseif($res['status']=='999033'){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'此用户还未审核通过'));
                    }elseif($res['status']=='999025'){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'此用户已离职'));
                    }
                }
            }
        }else{
            if($redirectUrl){
                redirect($redirectUrl);
            }else{
                $wxReturnUrl = U(MODULE_NAME.'/Login/wx',true,true,true);
                $wxReturnUrl = preg_replace('/\/\/(.*?)\//', '//'.$this->selfWebUrl.'/', $wxReturnUrl);
                $state = time();
                $session['wxState'] = $state;
                if(isset($session['wxLoginMsg'])&&($session['wxLoginMsg'])){
                    $this->assign('wxLoginMsg',$session['wxLoginMsg']);
                    unset($session['wxLoginMsg']);
                }
                session(MODULE_NAME,$session);
                $this->assign('state',$state);
                $this->assign('wxReturnUrl',$wxReturnUrl);
                $this->assign('qrcodeCssUrl',$this->qrcodeCssUrl);
                $this->assign('appid',C('APPID'));
                $this->display('login');
            }
        }
        /*$r = parent::indexBase();
        if (is_null($r)) {
            $this->_displayLoginTpl();
        } else {
            if (IS_AJAX) {
                $this->_ajaxRtnInfo($r);
            } else {
                redirect(U(MODULE_NAME . '/Index/index'));
            }
        }*/
    }

    //登录ajax返回信息处理
    private function _ajaxRtnInfo($r)
    {
        //定义错误信息对照列表
        $msgMap = array(
            '100010' => $this->translator->login_put_right_uname_pws,
            '10000' => $this->translator->login_put_right_uname_pws,
            '0' => 'login succ',
            '10002' => sprintf($this->translator->login_password_error_num_max, GConf::LOGIN_PWD_ERROR_COUNT, GConf::LOGIN_PWD_ERROR_TIME_MAX),
            '100011' => $this->translator->str_login_verify_error, //验证码错误
            '200013' => '对不起，你的账号未激活，请登入邮箱激活',
        	'200014' => '账号已被锁定，请联系管理员'
        );
        $msg = isset($msgMap[$r['status']]) ? $msgMap[$r['status']] : $this->translator->login_put_right_uname_pws;
        $r['status'] == '200013' && $this->_sendActiveEmail();
        $url = U(MODULE_NAME . '/Index/index'); //注意不要把U方法放到ajaxReturn中，否则TP解析时有可能解析错
        $this->ajaxReturn(array('data' => array('url' => $url),
            'msg' => $msg, 'status' => $r['status']));
    }
    
    /**
     * 发送激活邮件
     */
    private function _sendActiveEmail(){
    	$email = $_POST['username'];
    	$redirectUrl  = U('Company/Register/registerSucc',array('username'=>$email,'uuid'=>'<{UUID}>','activeUser'=>'regusterComplete'),true,true);//发送邮件链接
    	$content = "尊敬的企业平台管理员，您好：<br/>
    	感谢您注册成为我们的会员，请点击下面的链接确认并激活新的管理员邮箱，此链接有效期为24小时，且只能使用一次。<br/>
    	<a href=\"{$redirectUrl}\">{$redirectUrl}</a><br/>
    	如果不能点击以上链接，请将链接复制到浏览器地址栏以完成确认激活。<br/>
    	谢谢！<br/>
    	橙鑫科技企业平台 	";
    	$params = array(
    	'title' => '账号激活邮件',
    	'email' => $email,
    			'content' => $content,
    			'type' => 'biz'
    	);
    	$result = \AppTools::webService('\Model\AccountBiz\AccountBiz', 'sendemail', $params);
		if($result['status'] != 0){
    			$msg = '发送邮件失败'.$result['msg'];
    	}else{
    			$flag = 0;
    	}
    }

    /**
     * 显示登录页面模板部分
     */
    private function _displayLoginTpl()
    {
        import('ErrorCoder', LIB_ROOT_PATH . 'Classes/');
		$otherLoginKey = MODULE_NAME . '_USER_OTHER_LOGINED';
        $rdtCode = session($otherLoginKey);
        session($otherLoginKey, null);
        $this->assign('top', generalImagePos(ACTION_NAME)); //生成图片验证码的位置传递给前端并存储在session中
        $this->assign('formKey', $this->_genFormKey('loginForm'));
        $this->assign('code', \ErrorCoder::ERR_session_expired); //定义用户在其他地方登录错误码
        $this->assign('rdtCode', $rdtCode);
        $this->display('login');
    }


    /**
     * 用户退出操作
     */
    public function logout()
    {
        $this->logoutBase();
    }

    /**
     *生成验证码
     */
    public function getVerifyCode()
    {
    	$key = I('get.key');//确保每个各个页面的验证码的互不干扰
    	$max = I('get.w',192); //小图片的宽度
    	session($key . 'verify.left', mt_rand(0, $max-41-2));
    	session($key . 'verify.bool', false);
    	$fileSuffix = $key=='index'?'_big':'';
    	$image = WEB_ROOT_DIR . 'images'.DIRECTORY_SEPARATOR.'d'.$fileSuffix.'.png';
    	$image1 = WEB_ROOT_DIR . 'images'.DIRECTORY_SEPARATOR.'ddd.png';
    	$im = @imagecreatefrompng($image);
    	$im1 = @imagecreatefrompng($image1);
    	imagecopymerge($im, $im1, session($key . 'verify.left'), session($key . 'verify.top'), 0, 0, 40, 40, 50);
    	header("Content-type: image/png");
    	imagepng($im);
    }

    /**
     *检测验证码是否正确
     */
    public function checkVerifyCode()
    {
    	$key = I('get.key', mt_rand()); //获取验证key，每个key表示不同页面的滑动验证
    	$left = I('left'); //图片距离左侧的间距
    	$data = array();
    	$verify = session($key . 'verify');
    	if ($verify['left'] - 1 <= $left && $left <= $verify['left'] + 1) {
    		$data['status'] = 0;
    		session($key . 'verify.bool', true);
    	} else {
    		$data['status'] = 1;
    	}
    	$this->ajaxReturn($data);
    }

    /*认证图片上传*/
    public function imgUpload()
    {
    	$name = I('name');
    	$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize = 2 * 1024 * 1024;// 设置附件上传大小
    	$upload->exts = array('jpg', 'png', 'jpeg');// 设置图片上传类型
    	$upload->rootPath = C('COMPANY__CERTIFICATION_IMG_PATH'); // 设置附件上传目录
    	// 上传单个文件
    	$info = $upload->uploadOne($_FILES[$name]);
    	if (!$info) {// 上传错误提示错误信息
    		$data['status'] = 1;
    		$data['msg'] = $upload->getError();
    		echo json_encode($data);
    		trace(print_r($upload->getError(), true), '[FILE]', 'INFO', true);//日志
    	} else {// 上传成功 获取上传文件信息
    		$pathArr = explode('Public', C('COMPANY__CERTIFICATION_IMG_PATH'));
    		$data['status'] = 0;
    		$data['path'] = $pathArr[1]. $info['savepath'] . $info['savename']; //路径
    		echo json_encode($data);
    	}
    }

    public  function wx(){
        $state = I('get.state','');
        $code = I('get.code','');
        if($code){
            session(MODULE_NAME,$session);
            $params['wecode'] = $code;
            $res = \AppTools::webService('\Model\Company\CompanyLogin', 'weiLoginPost', array('params'=>$params));
            if($res['data']['isbind']==1){
                $time = time();
                $clientid = $res['data']['clientid'];
                
                //$session['username'] = $user;
                $session['login_succ'] = 1;
                $session['accesstoken'] = $res['data']['accesstoken'];
                $session['tokenExpireTime'] = $res['data']['expiration']+$time;
                $session['bizid'] = $res['data']['bizid'];
                $session['clientid'] = $clientid;
                $session['roleid'] = $res['data']['roleid'];
                $session['created_time'] = $res['data']['created_time'];
                $session['loginTimestamp'] = $time;
                if($res['data']['roleid']==1){
                    $session['isAdmin'] = 1;
                }
                session(MODULE_NAME,$session);
                $res1 = \AppTools::webService('\Model\Company\CompanyLogin', 'getEmpInfo', array('params'=>array('id'=>$res['data']['clientid'])));
                if(isset($res1['data']['list'][0])){
                    $session['name'] = $res1['data']['list'][0]['name'];
                    $session['username'] = $res1['data']['list'][0]['mobile'];
                    session(MODULE_NAME,$session);
                }
                $this->redirect('Index/index');
            }else{
                $session['wxLoginMsg'] = '您的微信未同账号绑定';
                session(MODULE_NAME,$session);
            }
            /*$params1['bindid'] = $res['data']['bindid'];
            $params1['mobile'] = '15010547303';
            $res1 = \AppTools::webService('\Model\Company\CompanyLogin', 'wxBind', array('params'=>$params1));*/
            //p($res);die;
            $this->redirect('Login/index');
        }else{
            $this->redirect('Login/index');
        }
    }


    //修改密码提交
    public function updatePwd(){
        if(IS_AJAX){
            $currentPwd = I('post.currentPwd','');
            $newPwd = I('post.newPwd','');
            if($currentPwd&&$newPwd){
                $session = session(MODULE_NAME);
                $params['id'] = $session['clientid'];
                $params['oldpass'] = $currentPwd;
                $params['password'] = $newPwd;
                $res = \AppTools::webService('\Model\Company\CompanyLogin', 'upPwd', array('params'=>$params));
                if($res['status']=='300008'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'原密码错误'));
                }elseif($res['status']==0){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'修改成功'));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1,'msg'=>'修改失败'));
    }
    
    //引导页面
    public function lead(){
    	$this->display('lead');
    }
}