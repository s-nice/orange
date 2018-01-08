<?php
namespace Demo\Controller;
use BaseController\BaseController;
use Classes\GConf;

class RegisterController extends BaseController
{

    public function _initialize()
    {
    	parent::_initialize();
        $this->assign('T', $this->translator);
    }
// demo登陆页面
//    public function index()
//    {
//        $r = parent::indexBase();
//        if(is_null($r)){
//        	$this->_displayLoginTpl();
//        }else{
//        	if (IS_AJAX) {
//        		//定义错误信息对照列表
//        		$msgMap = array(
//        				'100010' => $this->translator->login_put_right_uname_pws,
//        				'10000' => $this->translator->login_put_right_uname_pws,
//        				'0' => 'login succ',
//        				'10002' => sprintf($this->translator->login_password_error_num_max,GConf::LOGIN_PWD_ERROR_COUNT,GConf::LOGIN_PWD_ERROR_TIME_MAX)
//        		);
//        		$msg = isset($msgMap[$r['status']])?$msgMap[$r['status']]: $this->translator->login_put_right_uname_pws;
//        		$url = U(MODULE_NAME . '/Index/index'); //注意不要把U方法放到ajaxReturn中，否则TP解析时有可能解析错
//        		if($r['status'] == 0){
//        			$this->getUserInfo();
//        		}
//        		$this->ajaxReturn(array('data'=>array('url'=>$url),
//        				'msg'=>$msg, 'status'=>$r['status']));
//        	}else{
//        		redirect(U(MODULE_NAME . '/Login/index'));
//        	}
//        }
//    }
    public function index()
    {
        if(IS_GET){
            $this->display('index');
        }elseif (IS_AJAX){
            $com = I('post.company','');
            $code =I('post.mcode','');

        }
    }

	// 发送验证码
	public function sendPhoneCode(){
		$phone = I('post.phone','');
		$mcode = I('post.mcode','');
		$mcode = ltrim($mcode,'+');
		$ret = array('status'=>1,'msg'=>'');

		$params = array('mobile'=>$phone,'mcode'=>$mcode,'module'=>strtolower(MODULE_NAME).'/'.strtolower(ACTION_NAME));
		$re = \AppTools::webService('\Model\Verification\Sms','sms',array('params'=>$params,'crudMethod'=>'C'));
		if($re['status'] == 0){
			$ret['status'] = 0;
			$ret['data'] = $re['data']['messageid'];
			session('messageid',$re['data']['messageid']);
		}else{
			$ret['msg'] = $this->translator->h5_pop_send_fail;
		}
		echo json_encode($ret);
	}
	//验证手机验证码
    public function apply()
    {
        if(IS_AJAX){
            $phone = I('post.phone');
            $code = I('post.code');
            $mcode = I('post.mcode');
            $message_id = I('post.messageid');
            $params = array(
                'mobile' => $phone,
                'mcode'  => $mcode,
                'code'   => $code,
                'messageid' => $message_id,
            );
            $res = \AppTools::webService('\Model\Verification\Sms','sms',array('params'=>$params,'crudMethod'=>'C'));
            if($res['status'] === 0){
                $res = \AppTools::webService('\Model\Demo\Demo','apply',array('params'=>$params,'crudMethod'=>'C'));

            }else{

            }
        }
    }
	// 手机鉴权登陆注册
	public function phoneLogin(){
		$phone = I('post.phone','');
		$mcode = I('post.mcode','');
		$mcode = ltrim($mcode,'+');
		$codeId = I('post.codeId','');
		$code = I('post.code','');
		$ret = array('status'=>1,'msg'=>'');
		$params = array('messageid'=>$codeId,'mcode'=>$mcode,'mobile'=>$phone,'code'=>$code,'ip'=>get_client_ip());
		$re = \AppTools::webService('\Model\Oauth\Oauth', 'smslogin',array('params'=>$params,'crudMethod'=>'C'));
		if($re['status'] == 0){
				$ret['status'] = 0;
				/** session */
				$session = array(
						'username'=>'',
						'state'  =>isset($re['data']['state'])?$re['data']['state']:NULL,
						'userType'      => 'basic',
						'loginip'       => get_client_ip(), // use this ip for check autologin
						'accesstoken'   => $re['data']['accesstoken'],
						'tokenExpireTime' => $re['data']['expiration'] + time(),
						'company'=>'',
						'industry'=>'',
						'login_succ'=>'true',
				        'clientid'  => $re['data']['clientid']
				);
				session(MODULE_NAME, $session);
				$this->getUserInfo();
		}else{
			$statusArr = array('999002','999021','999010','999011','100011');
			if(in_array($re['status'], $statusArr)){
				$msg = "h5_login_fail_{$re['status']}";
			}else{
				$msg = "h5_login_fail";
			}
			$ret['msg'] = empty($re['msg'])?$this->translator->h5_login_fail:$this->translator->$msg;
		}
		echo json_encode($ret);
	}
    /**
     * 显示登录页面模板部分
     */
    private function _displayLoginTpl()
    {
    	// 后台个人账号密码登陆页面
    	$this->assign('formKey',$this->_genFormKey('loginForm'));

    	// h5页面 验证码登陆页面
    	$this->display('login');

    }
    // 获得公司和行业信息
	private function getUserInfo(){
		$session = session(MODULE_NAME);
		$params = array('showindustry'=>'true');
		$basicInfo = \AppTools::webService('\Model\Account\Account', 'account',array('params'=>$params,'crudMethod'=>'R'));
		$basicInfo = $basicInfo['data']['users'][0];
		$session['username'] = $basicInfo['mobile'];
		$session['company'] = $basicInfo['company'];
		$session['industry'] = $basicInfo['industry'];

		$params = array('nindex'=>'1');
		$vcardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard',array('params'=>$params,'crudMethod'=>'R'));
		if($vcardInfo['status'] == '0' && $vcardInfo['data']['numfound'] != '0'){
			// 解析首页名片
			require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';
			$CardOperator = new \CardOperator();
			$vcardInfo = $vcardInfo['data']['vcards']['0']['vcard'];
			$vcardInfo = $CardOperator->parseVcardText($vcardInfo);
			// 首页名片公司字段存在 重新修改session值中的company值
			if(isset($vcardInfo[0]['company']) && !empty($vcardInfo[0]['company']['value'])){
				$session['company'] = $vcardInfo[0]['company']['value'];
			}
		}
		session(MODULE_NAME, $session);
	}
	/**
     * 用户退出操作
     */
    public function logout()
    {
       $this->logoutBase();
    }

}