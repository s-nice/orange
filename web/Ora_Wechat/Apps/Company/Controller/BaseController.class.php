<?php
namespace Company\Controller;
use BaseController\BaseController AS GlobalBaseController;
use Model\WebService;
use Classes\Factory;
/**
 * 后台控制器基类
 */
abstract class BaseController extends GlobalBaseController
{
	//get请求方式
	const METHOD_GET  = 'get';
	//post请求方式
	const METHOD_POST = 'post';
	
    /*
     * 用户获取的权限列表
     * @var array
     */
    protected $authorityList = array();
    protected $globleAuthority = array();
    protected $PubAuthorityFun = array('unlock','lock','nopermission','error404');
    /**
     * 初始化控制器， 检查是否设置session
     */
    public function _initialize()
    {
        parent::_initialize();
        $userinfo = session(MODULE_NAME);
        //用来判断是否有权限
        //$this->hasAuthority();
        
        $this->assign('leftMenu',$this->getMenu());
        $this->_outputPhpVars();//输出锁定功能相关变量
        // 增加翻译文件
        $this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
        $this->assign('company_info', $userinfo);//头部管理员信息
        //\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__." 菜单面包屑 \r\n<pre>".''.var_export($this->getMenu(),true));
    }
    
    /**
     * php端输出js变量
     */
    private function _outputPhpVars()
    {
    	if(!IS_AJAX){
    		import('ErrorCoder', LIB_ROOT_PATH.'Classes/');
    		$session = session(MODULE_NAME);
    		$this->assign('isLocked',isset($session['islock'])?$session['islock']:NULL);
    		$this->assign('JS_LOCK_SCREEN_TIME', C('LOCK_SCREEN_TIME')); //设置锁屏时间
    		$this->assign('expiredCode',\ErrorCoder::ERR_SESSION_EXPIRED); //定义用户在其他地方登录错误码 
    	}
    }
    
    /**
     * 会话过期动作
     */
    public function lock()
    {
    	$lock = I('get.lscreen');
    	if($lock == 1){
    		$session = session(MODULE_NAME);
    		$session['islock'] = 1;
    		session(MODULE_NAME,$session);
    		//$url = U(MODULE_NAME.'/Login/logout');
    		//redirect($url);
    	}
    }
    
    /**
     * 判断是否会话过期
     */
    public function isLocked()
    {
    	$session = session(MODULE_NAME);
    	return $session['islock'];
    }
    /**
     * 获取菜单
     * @return array $myMenu
     */
    public function getMenu()
    {
    	$menuArr = C('LEFTMENUARR');
    	$myMenu  = array();
    	foreach ($menuArr as $key =>$_menuInfo) {
    		// 大标题的ctl存在且不为空  没有权限就直接退出本次循环  有权限则增加大标题的url值
    		if(isset($_menuInfo['ctl']) && $_menuInfo['ctl'] != ''){
    			if(!isAbleAccess($_menuInfo['ctl'],$_menuInfo['act'])){
    				continue;
    			}else{
    				if (CONTROLLER_NAME == $_menuInfo['ctl'] && ACTION_NAME == $_menuInfo['act']){
    					$_menuInfo['active'] = 1;
    				}
    				$_menuInfo['url'] = U(MODULE_NAME."/{$_menuInfo['ctl']}/{$_menuInfo['act']}",'','',true); 
    			}
    		}
    		// 没有退出循环 就开始检测小标题的权限 没有权限就unset对应的小标题 有权限则判断是否是当前选中内容
    		foreach ($_menuInfo['children'] as $k=>$_menu){
    			if(!isAbleAccess($_menu['ctl'],$_menu['act'])){
    				unset($_menuInfo['children'][$k]);
    			}else{
    				if ($_menu['ctl'] == CONTROLLER_NAME && $_menu['act'] == ACTION_NAME){
    					$_menuInfo['children'][$k]['active'] = 1;
    					$_menuInfo['active'] = 1;
    				}
    			}
    		}
    		// 处理好的值赋给返回值
    		$myMenu[$key] = $_menuInfo;
    	}
    	return $myMenu;
    }

    /**
     * 获取加解密后的密码
     * $param int 1:加密,2:解密,3:获取元素密码
     */
    protected  function self_crypt($str,$type=1)
    {
        $key      = MODULE_NAME;
        $password = $str;
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
     * 发起一个get或post请求
     * @param $url 请求的url
     * @param int $method 请求方式
     * @param array $params 请求参数
     * @param array $extra_conf curl配置, 高级需求可以用, 如
     * $extra_conf = array(
     *    CURLOPT_HEADER => true,
     *    CURLOPT_RETURNTRANSFER = false
     * )
     * @return bool|mixed 成功返回数据，失败返回false
     * @throws Exception
     */
    public static function exec($url,  $params = array(), $method = self::METHOD_GET, $extra_conf = array())
    {
    	//Log::write('-------exec $$$$$$$$$$$---- '.print_r(func_get_args(),1));
    	$params = is_array($params)? http_build_query($params): $params;
    	//如果是get请求，直接将参数附在url后面
    	if(strtoupper($method) == strtoupper(self::METHOD_GET))
    	{
    		$url .= (strpos($url, '?') === false ? '?':'&') . $params;
    	}
    
    	//默认配置
    	$curl_conf = array(
    			CURLOPT_URL => $url,  //请求url
    			CURLOPT_HEADER => false,  //不输出头信息
    			CURLOPT_RETURNTRANSFER => true, //不输出返回数据
    			CURLOPT_CONNECTTIMEOUT => 3, // 连接超时时间
    			CURLOPT_SSL_VERIFYPEER => false,
    			CURLOPT_SSL_VERIFYHOST => false,
    	);
    
    	//配置post请求额外需要的配置项
    	if(strtoupper($method) == strtoupper(self::METHOD_POST))
    	{
    		//使用post方式
    		$curl_conf[CURLOPT_POST] = true;
    		//post参数
    		$curl_conf[CURLOPT_POSTFIELDS] = $params;
    	}
    
    	//添加额外的配置
    	foreach($extra_conf as $k => $v)
    	{
    		$curl_conf[$k] = $v;
    	}
    
    	$data = false;
    	try
    	{
    		//初始化一个curl句柄
    		$curl_handle = curl_init();
    		//设置curl的配置项
    		curl_setopt_array($curl_handle, $curl_conf);
    		//发起请求
    		$data = curl_exec($curl_handle);
    		if($data === false)
    		{
    			throw new \Exception('CURL ERROR: ' . curl_error($curl_handle));
    		}
    	}
    	catch(\Exception $e)
    	{
    		echo $e->getMessage();
    	}
    	curl_close($curl_handle);
    
    	return $data;
    }
}
