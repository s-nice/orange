<?php
namespace BaseController;

use Classes\GFunc;
/**
 * 用户登陆基类
 * @author zhangpeng
 */
import('BaseController');
class LoginBaseController extends BaseController
{
    /*
     * 用户类型为个人用户
     * @const
     */
    const USER_TYPE_BASIC = 'basic';
    /*
     * 用户类型为后台管理用户
     * @const
     */
    const USER_TYPE_ADMIN = 'admin';
    /*
     * 用户类型为企业用户
    * @const
    */
    const USER_TYPE_BIZ = 'biz';
    //用户记住密码时cooke中key前缀
    protected static $_REMEMBER_PWD_KEY = array('auto'=>'afsauto','uname'=>'afsDF8FDORDATU','upwd'=>'afsDF8FDORADTP');

	public function _initialize()
	{
		parent::_initialize();
// 		$this->translator->mergeTranslation(APP_PATH . 'Lang/'. $this->uiLang .'.xml', 'xml');
		$this->assign('T', $this->translator);
	}

    /**
     * 判断是否登陆
     */
    public function indexBase()
    {
       $return = null;
       $userInfo = session(MODULE_NAME);
       if (!empty($userInfo['username'])) {
	       	if (IS_AJAX) {
	       		$url = U(MODULE_NAME . '/Index/index'); //注意不要把U方法放到ajaxReturn中，否则TP解析时有可能解析错
	       		$this->ajaxReturn(array('url'=>$url,'p'=>self::getMd5Pwd(1)),
	       		                        $this->translator->INFO_G_LOGIN_SUCCESSFULLY, 0);
	       	} else {
	       		redirect(U(MODULE_NAME . '/Index/index'));
	       	}
        }else if (IS_POST && isset($_POST['username'], $_POST['password'], $_POST['usertype'])) {//输入用户名密码， 验证
	       /* 	$formkey = I('post.formkey');
	       	if(!$this->_validFromKey($formkey)){
	       		return array('status'=>3,'msg'=>'form key valid fail');
	       	} */
            $return =self::checkUser();
       }
       return $return;
    }
	/**
	 * 检测用户账号和密码
	 */
    static public function checkUser()
	{
 	    $username = I('username', null);
	    $password = self::getMd5Pwd(3);//获取解密后的密码 I('password', null);
        $usertype = I('usertype', null);

		//检测用户登陆
		$result = GFunc::checkUsernameAndPassword($username, $password, $usertype);
	    if ($result['status'] !== 0 ) {
            return $result;
        }
		// 验证用户成功  set the session
		$session = array(
                'state'         => isset($result['data']['state'])?$result['body']['state']:NULL,
                'userType'		=> $usertype,
				'loginip'		=> get_client_ip(), // use this ip for check autologin
                'accesstoken'   => $result['data']['accesstoken'],
                'tokenExpireTime' => $result['data']['expiration'] + time(),
		        'loginTimestamp'  => time()
		);
		session(MODULE_NAME, $session);
		// 获取个人好友信息
		if (self::USER_TYPE_BASIC == $usertype) {
		// 为个人用户设定头像，手机等session信息
			$userBasicInfo = \AppTools::webService('\Model\Account\Account', 'account',array('params'=>array(),'crudMethod'=>'R'));
			$userBasicInfo = isset($userBasicInfo['data']['users'][0])?$userBasicInfo['data']['users'][0]:array();
			$session['avatarPath'] = $userBasicInfo['avatar'];
		    $session['username'] 	= !empty($userBasicInfo['realname'])?$userBasicInfo['realname']:$userBasicInfo['nickname'];
			$session['mobile'] 		= $userBasicInfo['mobile'];
			$session['email'] 		= $userBasicInfo['email'];
			$session['country'] 		= empty($userBasicInfo['country'])?156:$userBasicInfo['country'];//框架默认
			$session['languageid'] 		= empty($userBasicInfo['languageid'])?2:$userBasicInfo['languageid'];//框架默认
			$session['clientid'] 	= $userBasicInfo['clientid'];
			$session['password'] 	= md5($password);
			$session['longitude'] = $userBasicInfo['longitude'];
			$session['latitude']=  $userBasicInfo['latitude'];
			$session['imid']=  $userBasicInfo['imid'];
			$session['mpany'] = $userBasicInfo['company'];
            // 根据API判断语言类型
            $LanguageSetting = include CONF_PATH.'LanguageSetting.php';
            $langInfo = $LanguageSetting[$session['languageid']];
            $session['lang'] = empty($langInfo['folder'])?'':$langInfo['folder'];

		} else if (self::USER_TYPE_ADMIN == $usertype) {
			// 后台用户， 需要用到邮箱（邮箱为登录名)
			$session['username'] = $username;
		    $session['password'] = md5($password);
		    $session['pwdshowmd5'] =  self::getMd5Pwd(1);
		    $adminInfo = \Apptools::WebService('\Model\Oauth\Oauth',
		                                     'getUserByEmail',
		                                     array('email'=>$username));
		                                     $session['adminid']  = $adminInfo['admins'][0]['adminid'];
		                                     $session['roleid']   = $adminInfo['admins'][0]['roleid'];
		    $session['realname'] = $adminInfo['admins'][0]['realname'];
		    $session['mobile']   = $adminInfo['admins'][0]['mobile'];
		    $session['email']    = $adminInfo['admins'][0]['email'];
		    $session['date']     = $adminInfo['admins'][0]['date'];
		    $session['loginip']     = $adminInfo['admins'][0]['loginip'];//最后登录IP
		    $session['logintime']     = date('Y-m-d H:i:s',(strtotime($adminInfo['admins'][0]['logintime'])+28800));//最后登录时间

		    $session['islock']     = 0;

		    $rolelist = \AppTools::webService('\Model\Role\Role', 'getRoleList',array('params'=>array('roleid'=>$adminInfo['admins'][0]['roleid'])));
		    if($rolelist['data']['groups'][0]['status'] == '2'){
		      $session['rolelist'] = json_decode($rolelist['data']['groups'][0]['permission'],true);
		    }else{
		       $session['rolelist'] = array('Index'=>array('index'));
		    }
        $adminidArr = C('ADMIN_USERNAME');
        if(in_array($username,$adminidArr)){
          $session['isAdmin'] = 1;
        }
		}else if(self::USER_TYPE_BIZ == $usertype){
      	    //企业用户设定账户状态信息
            $resultbiz = \Apptools::WebService('\Model\AccountBiz\AccountBiz', 'bizAccount', array('params'=>array()));
            $session['state'] = $resultbiz['state'];
            $session['username'] = $username;
            $session['bizid']    = $resultbiz['bizid'];
            $session['clientid'] = $resultbiz['bizid'];
            $session['bizname'] = $resultbiz['name']; // 企业名称
            $session['country']         = empty($resultbiz['country'])?156:$resultbiz['country'];//框架默认
            $session['languageid']      = empty($resultbiz['languageid'])?2:$resultbiz['languageid'];//框架默认
            $session['logo'] = empty($resultbiz['logo'])?U('/','','',true).'/images/default/content_img_logo.png':$resultbiz['logo'];
            $session['headImg'] = empty($resultbiz['logo'])?U('/','','',true).'/images/default/avatar_user_chat.png':$resultbiz['logo'];
            if((isset($result['data']['employeeid']))&&($result['data']['employeeid'])){
                $session['bizid'] = $result['data']['bizsuperid'];
                $session['reg_type'] = $result['data']['reg_type'];
                $session['empid'] = $result['data']['employeeid'];
                $session['rolelist'] = self::getRolelistByEmpid($result['data']['employeeid'],$result['data']['employeeid']);
                
            }
            if($result['data']['clientid']==$resultbiz['bizid']){
                $session['isAdmin'] = 1;
            }
        }
		$session['login_succ'] = true;//整个登陆流程成功
		session(MODULE_NAME, $session);
    
		$autologin = $_POST['autologin'];
		if($autologin == 'true'){//如果用户选择了自动登陆，存入cookie信息
			GFunc::storeAccountIntoCookie($session, 3600*24*30); // set cookie life time is one month cookie有效期
		}

		return array('status'=>0,'msg'=>'loginSucc');
	}

    /**
     * 用户退出登录
     * $delauto string 是否取消记住登录功能
     * $userType string 用户类型，包括个人用户、后台管理员、企业用户
     */
    public function logoutBase ($delauto=null,$userType='')
    {
    	if($delauto == '1'){
    		cookie(self::$_REMEMBER_PWD_KEY['auto'].$userType, null);
    		cookie(self::$_REMEMBER_PWD_KEY['uname'].$userType, null);
    		cookie(self::$_REMEMBER_PWD_KEY['upwd'].$userType, null);
    	}
        // 获取session
        $sessionInfo = session(MODULE_NAME);
        if (isset($sessionInfo)) {// 用户已登录
            cookie('Oradt_'.MODULE_NAME, null);
            //session_unset(); //释放当前在内存中已经创建的所有$_SESSION变量，但不删除session文件以及不释放对应的session id
			//session_destroy();//删除当前用户对应的session文件以及释放session id，内存中的$_SESSION变量内容依然保留
			session(MODULE_NAME,null);
            $this->logoutRedirect(MODULE_NAME);
        } else {// 用户未登录
            // 未找到指定应用组，到默认组首页
            $this->logoutRedirect(C('DEFAULT_MODULE'));
        }
    }
    /**
     * 注销用户后的回跳地址
     */
    private function logoutRedirect($groupName)
    {
    	$redrectUrl = isset($_REQUEST['r'])?$_REQUEST['r']:'';
    	if(!empty($redrectUrl)){//从回调参数中获取url地址
    		$redrectUrl = base64_decode($redrectUrl);
    		redirect($redrectUrl);
    	}else{
    		redirect(U('/' . $groupName . '/Index/Index'));
    	}
    }

    /**
     * 获取加解密后的密码
     * $param int 1:加密,2:解密,3:获取元素密码
     */
    public static function getMd5Pwd($type=1)
    {
    	$key 	  = $_POST['username'];
    	$password = $_POST['password'];
    	$part = substr(md5($key), 0,strlen($key));
    	if($password){
    		switch ($type){
    			case 1:
    				if(strpos($password,$part) === false){
    					$strArr = str_split(base64_encode($password));
    					$strCount = count($strArr);
    					foreach (str_split($key) as $key => $value)
    						$key < $strCount && $strArr[$key].=$value;
    					$password = str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    					$password .= $part;
    					}
					    break;
    			case 2:
    				$password = str_replace($part,'',$password);
    				$strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $password), 2);
				    $strCount = count($strArr);
				    foreach (str_split($key) as $key => $value)
				        $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
				    $password = base64_decode(join('', $strArr));
					break;
    			case 3:
    				if(strpos($password,$part) !== false){
    					$password = self::getMd5Pwd(2);
    				}
    			default:
    		}
    	}else{
    		$password = '';
    	}
    	return $password;
    }

    /**
     * 生成form表单key
     * @param string  $fromKey 表单唯一值，每个表单不相同
     * @return string
     */
    protected function _genFormKey($fromKey)
    {
    	$fromKey .= MODULE_NAME;
    	$val     = md5($fromKey.time()+rand(1, 100));
    	$session = session(MODULE_NAME.'_');
    	$session[$fromKey] = $val;
    	session(MODULE_NAME.'_', $session);
    	return $fromKey.'_'.$val;
    }

    /**
     * 验证form表单key
     * @param string  $str 表单唯一字符串组合
     * @return boolean
     */
    protected function _validFromKey($str)
    {
    	$str = trim($str);
    	if(!$str || (($arr = explode('_', $str)) && count($arr) != 2)){
    		return false;
    	}
    	$session = session(MODULE_NAME.'_');
    	$fromKey = $arr[0];
    	if($session[$fromKey] != $arr[1]){
    		return false;
    	}
    	return true;
    }

    /**
     * 根据员工empid获取其权限数组
     * @param string  $str 表单唯一字符串组合
     * @return boolean
     */
    static public function getRolelistByEmpid($empid,$bizid)
    {
      $array = array();
      $rlist = \Apptools::WebService('\Model\Role\Role', 'getEmployee', array('params'=>array('empid'=>$empid)));
      if($rlist['status']==0){
          $arr = array();
          foreach ($rlist['data']['list'] as $va) {
            $arr[] = $va['roleid'];
          }
          if(sizeof($arr)){
            $str = implode(',',$arr);
            $roles = \Apptools::WebService('\Model\Role\Role', 'getBizRoleList', array('params'=>array('roleid'=>$str,'bizid'=>$bizid)));
            foreach ($roles['data']['list'] as $val) {
                $array[] = json_decode($val['permission'],true);
            }
          }
      }
      return mergePermission($array);
    }

}
