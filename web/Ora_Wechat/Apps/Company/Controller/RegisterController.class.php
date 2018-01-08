<?php
namespace Company\Controller;

use BaseController\LoginBaseController;
use Classes\GConf;
use Classes\GFunc;
use Think\Verify;
/**
 * 企业后台登陆类
 */
class RegisterController extends LoginBaseController
{

    public $verify = array();
    private $info = null;
    private $certification = null;

    public function _initialize(){
    	parent::_initialize();
    	// 增加翻译文件
    	$this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
    	$this->assign('T',$this->translator);
    }
    /**
     * 找回密码
     */
    public function getBackpwd()
    {
        if(IS_AJAX){
            $session = session(MODULE_NAME);
            $messageid = $session['messageid'];
            $mobile = I('post.mobile','');
            $code = I('post.mbcode','');
            $password = I('post.password','');
            if($code&&$mobile){
                $data = [
                    'messageid' => $messageid,
                    'mobile'    => $mobile,
                    'code'      => $code,
                    'password'  => $password,
                ];
                $res = \AppTools::webService('\Model\Company\CompanyPwd', 'resetPassword', array('params'=>$data));
//                $this->ajaxReturn($res);
                if($res['status']==0){
                    $this->ajaxReturn(['status'=>0,'msg'=>'密码重置成功']);
                }elseif($res['status']==999011||$res['status']==720013){
                    $this->ajaxReturn(['status'=>1,'msg'=>'验证码错误']);
                }elseif($res['status']==999010||$res['status']==999032){
                    $this->ajaxReturn(['status'=>1,'msg'=>'验证码已过期']);
                }elseif($res['status']==999004){
                    $this->ajaxReturn(['status'=>2,'msg'=>'用户不存在']);
                }
            }

        }else{
            $this->display('getBackpwd');
        }
    }
    //获取验证码
    public function verify()
    {
        $config = [
            'fontSize' => 12,
            'length'   => 4,
            'imageW'   => 100,
            'imageH'   => 26,
            'useNoise' => false,
            'fontttf'  => '4.ttf',
        ];
        $verify = new Verify($config);
        $verify->entry();
    }
    //验证验证码
    public function checkVerify()
    {
        if(IS_AJAX){
            $code = I('post.code');
            $verify = new Verify();
            $res = $verify->check($code);
            $this->ajaxReturn(['res'=>$res]);
        }
    }
    
    /**
     * 用户登陆页
     */
    public function index()
    {
        $session = session(MODULE_NAME);
        $currentTime = time();
        $time = $session['sendCodeTime'];
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
        $this->display('index');
    }

    
    //发送验证码
    public function verifySend()
    {
        if(IS_AJAX){
            $mobile = I('post.mobile','');
            $mcode = I('post.mcode','86');
            if($mobile){
                $params['mobile'] = $mobile;
                $re = \AppTools::webService('\Model\Company\CompanyReg', 'getEmByMobile', array('params'=>$params));
                if($re['head']['status']==1){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'此手机号已注册'));
                }
                $params['mcode'] = $mcode;
                $params['type'] = 1;
                $params['module'] = MODULE_NAME;
                $res = \AppTools::webService('\Model\Company\CompanyReg', 'sendSms', array('params'=>$params));
                if(!empty($res['data']['messageid'])){
                    $session = session(MODULE_NAME);
                    $time = time();
                    $session['sendCodeTime'] = $time;
                    $session['messageid'] = $res['data']['messageid'];
                    session(MODULE_NAME,$session);
                    $this->ajaxReturn(array('status'=>0));
                }elseif($res['status']=='999020'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'发送失败'));
                }
            }
        }
    }

    public function sendCode()
    {
        if(IS_AJAX) {
            $mobile = I('post.mobile', '');
            $mcode = I('post.mcode', '86');
            $params['mcode'] = $mcode;
            $params['mobile'] = $mobile;
            $params['type'] = 1;
            $params['module'] = MODULE_NAME;
            $res = \AppTools::webService('\Model\Company\CompanyReg', 'sendSms', array('params' => $params));
            if (!empty($res['data']['messageid'])) {
                $session = session(MODULE_NAME);
                $time = time();
                $session['sendCodeTime'] = $time;
                $session['messageid'] = $res['data']['messageid'];
                session(MODULE_NAME, $session);
                $this->ajaxReturn(array('status' => 0));
            } elseif ($res['status'] == '999020') {
                $this->ajaxReturn(array('status' => 1, 'msg' => '发送失败'));
            }
        }
    }


    //注册提交
    public function submitPost()
    {
        if(IS_AJAX){
            $user = I('post.user','');
            $password = I('post.password','');
            $mcode = I('post.mcode','86');
            $code = I('post.code','');
            $company = I('post.company','');
            $type = I('post.type','1');
            $name = I('post.name','');
            if($code&&$user){
                $session = session(MODULE_NAME);
                $messageid = $session['messageid'];
                $params['code'] = $code;
                $params['mcode'] = $mcode;
                $params['mobile'] = $user;
                $params['messageid'] = $messageid;
                $res = \AppTools::webService('\Model\Company\CompanyReg', 'checkSms', array('params'=>$params));
                //print_r($res);die;
                if($res['status']=='999011'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'验证码错误'));
                }elseif($res['status']=='999004'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'绑定失败，请重新发送验证码'));
                }elseif($res['status']=='999005'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败，您已绑定'));
                }elseif($res['status']=='999010'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'验证码已过期，请重新发送'));
                }elseif($res['status']=='999023'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'操作失败，此橙脉用户已绑定'));
                }
                if($res['status']==0){
                    $params = array();
                    $params['user'] = $user;
                    $params['mcode'] = $mcode;
                    $params['password'] = $password;
                    $params['company'] = $company;
                    $params['type'] = $type;
                    $params['name'] = $name;
                    $res = \AppTools::webService('\Model\Company\CompanyReg', 'regPost', array('params'=>$params));
                    //print_r($res);die;
                    if($res['status']==0){
                        $this->ajaxReturn(array('status'=>0,'msg'=>'注册成功'));
                    }elseif($res['status']=='999005'){
                        $this->ajaxReturn(array('status'=>0,'msg'=>'此手机号已注册'));
                    }
                }
            }
        }
        $this->ajaxReturn(array('status'=>2,'msg'=>'注册失败'));
    }

    //橙鑫服务条款
    public function serverText(){
        $this->display('serverText');
    }

    //验证企业名称
    public function checkCompany(){
        if(IS_AJAX){
            $company = I('post.company','');
            if($company){
                $params['company'] = $company;
                $re = \AppTools::webService('\Model\Company\CompanyReg', 'getCompanyByName', array('params'=>$params));
                if($re['head']['status']==1){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'此公司名称已注册'));
                }
            }
            $this->ajaxReturn(array('status'=>0));
        }
    }
}