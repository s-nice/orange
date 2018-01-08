<?php
namespace Appadmin\Controller;
use BaseController\LoginBaseController;
use Classes\GConf;
/**
 * 橙鑫后台登陆类
 * @author zhangpeng
 *
 */
class LoginController extends LoginBaseController
{
	const FORM_KEY = 'loginForm';
    /*
     * 访问控制
     * 如果不在配置的ip内（配置：ACCESS_LIST_IP），则不允许访问后台，跳转到官网首页。
     * */
    protected function accessControl(){
        $accesslist = C('ACCESS_LIST_IP');
        if(!empty($accesslist)){
            if(!in_array($_SERVER['REMOTE_ADDR'],$accesslist)){
                $this->redirect('/');
            }
        }

    }
    /**
     * 用户登陆页
     */
    public function index()
    {

      //  $this->accessControl();
        $r = parent::indexBase();
        if(is_null($r)){
        	$this->_displayLoginTpl();
        }else{
        	if (IS_AJAX) {
        		//定义错误信息对照列表
        		$msgMap = array(
        				'100010' => $this->translator->login_put_right_uname_pws,
        				'10000' => $this->translator->login_put_right_uname_pws,
        				'0' => 'login succ',
        				'10002' => sprintf($this->translator->login_password_error_num_max,GConf::LOGIN_PWD_ERROR_COUNT,GConf::LOGIN_PWD_ERROR_TIME_MAX),
        				'3' => 'form key valid fail',
        				'100009' => 'user name error'       				
        		);
        		$msg = isset($msgMap[$r['status']])?$msgMap[$r['status']]: $this->translator->login_put_right_uname_pws;
        		$result = array('msg'=>$msg, 'status'=>$r['status']);
        		if($r['status'] == 0){
        			$url = U(MODULE_NAME . '/Index/index'); //注意不要把U方法放到ajaxReturn中，否则TP解析时有可能解析错
        			$result['data'] = array('url'=>$url,'p'=>self::getMd5Pwd(1));
        		}else{
        			$result['data'] = array('formKey'=>$this->_genFormKey(self::FORM_KEY));
        		}        		
        		$this->ajaxReturn($result);
        	}else{
        		redirect(U(MODULE_NAME . '/Login/index'));
        	}
        }
    }

    /**
     * 显示登录页面模板部分
     */
    private function _displayLoginTpl()
    {
    	$this->assign('formKey',$this->_genFormKey(self::FORM_KEY));//定义防止重复提交表单关键字
    	$this->assign('rememberpwdkey', parent::$_REMEMBER_PWD_KEY); //记住密码cookie中的key
    	$this->display();
    }

    /**
     * 用户退出操作
     */
    public function logout()
    {
       $delauto = I('delauto',null); //是否清除登录时记住的用户名与密码信息，1表示清楚，非1不清楚
       $this->logoutBase($delauto,parent::USER_TYPE_ADMIN);
    }

    public function wx(){
        //echo dirname(WEB_ROOT_DIR).'/Runtime/Logs/Appadmin/'.date('y-m-d').'.log';die;
        require_once WEB_ROOT_DIR . 'WxpayAPI/lib/WxPay.Api.php';
        require_once WEB_ROOT_DIR . 'WxpayAPI/example/WxPay.JsApiPay.php';
        require_once WEB_ROOT_DIR . 'WxpayAPI/example/log.php';
        //初始化日志
        $logHandler= new \CLogFileHandler(dirname(WEB_ROOT_DIR).'/Runtime/Logs/Appadmin/'.date('y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        //打印输出数组信息


        //①、获取用户openid
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
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
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();
        $this->assign('order',$order);
        $this->assign('editAddress',$editAddress);
        $this->assign('jsApiParameters',$jsApiParameters);
        $this->display('wx');

    }

}