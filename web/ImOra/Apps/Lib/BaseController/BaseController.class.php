<?php
namespace BaseController;

use Think\Controller;
use Classes\GFunc;
use Classes\Factory;
/**
 * 控制器基类
 * @author liyl <liyl@oradt.com>
 */
// 载入工厂类
import('Factory', LIB_ROOT_PATH . 'Classes/');
class BaseController extends Controller
{

	/*
	 * 是否检查登陆状态。 如果检查登陆状态， controller里面会自动检测登陆。
	 * @var bool
	 */
	protected $toCheckLogin = true;

	protected $uiLang = '';

	protected $title = '';

	/*
	 * 翻译类实例
	 * @var TranslationLoader
	 */
	protected $translator = null;

	/**
	 * 定义不需要登陆就可以进入的操作的模块和操作
	 * (注意：模块名称和操作名称必须小写,*表示整个Controll里面的方法都不拦截)
	 */
	protected static $_NO_NEED_LOGIN = null;

    /**
     * 重载构造函数。 做https请求判断
     */
    public function __construct()
    {
        // 强制 企业 portal使用https请求
//         if (!is_ssl() && strtolower(MODULE_NAME)=='company') {
//             // 强制生成 https 请求
//             $_SERVER['HTTPS'] = 1;
//             $url = U('/'.MODULE_NAME, '', true, true);
//             $this->redirect($url);
//         }
        // !!! 非常重要。 需要调回父类的构造函数
        self::$_NO_NEED_LOGIN = C('NO_NEED_LOGIN')?C('NO_NEED_LOGIN'):array();
        parent::__construct();
    }

	/**
	 * 初始化控制器， 检查是否设置session
	 * Enter description here ...
	 */
	public function _initialize()
	{
		$this->uiLang = GFunc::getUiLang();
		// load the global language strings
		$globalLangFile = APP_PATH . 'Lang/'. $this->uiLang . '.xml';
		$this->translator = Factory::getTranslator($globalLangFile, 'xml');
        $this->assign('T',$this->translator);
		if (true === $this->toCheckLogin) { // 检测登陆状态， 验证session
			//GFunc::checkAutoLogin();//检测自动登陆
			$session = session(MODULE_NAME);
			if(empty($session['login_succ']) && $this->isLoginRequired()){
				if(IS_AJAX){
					if(!class_exists('ErrorCoder')){
						import('ErrorCoder', LIB_ROOT_PATH . 'Classes/'); //暂时添加
					}
					$url = U(MODULE_NAME . '/Login/index');
					$this->ajaxReturn(array('data'=>array('url'=>$url),
							'msg'=>sprintf($this->translator->str_session_expired,C('UNVALID_LOGIN_AUTO_REDIRECT')), 'status'=>\ErrorCoder::ERR_FILE_OPEN_REMOTE_FAILED));
				}else{
					redirect(U(MODULE_NAME . '/Login/index'));
				}
			}
		}
		// 不允许企业和个人同时登陆。 如果企业登陆， 强制跳转到企业potal
		/* if (C('ALLOW_DIFF_CLIENT_ONLINE')!==true && session('Company') && MODULE_NAME!='Company' && !session('Appadmin')) {
		    redirect(U('Company/index/index'));
		} */
	    $this->assign('title', $this->title);
	}

	/**
	 * 判断是否需要登录
	 * return boolean 返回值说明-> true:需要登录，false:不需要登录
	 */
	protected function isLoginRequired()
	{
		$lowerModuleName = strtolower(CONTROLLER_NAME);
		//需要登录
		if(!isset(self::$_NO_NEED_LOGIN[MODULE_NAME][$lowerModuleName])){
			return true;
		}
		//不需要登录
		if(self::$_NO_NEED_LOGIN[MODULE_NAME][strtolower(CONTROLLER_NAME)][0] == '*' || in_array(ACTION_NAME, self::$_NO_NEED_LOGIN[MODULE_NAME][$lowerModuleName])){
			return false;
		}
		//需要登录
		return true;
	}

    /**
     * 判断权限
     * @param array $myAuthorityList 权限数组
     * @return boolean
     */
    public function hasAuthority(){
        // 检测类方法是否存在  不存在直接到404 存在做权限判断
        if(method_exists($this,ACTION_NAME)){
            $isAllowAccess = isAbleAccess(CONTROLLER_NAME,ACTION_NAME);
            try {
                $logs = new \Model\WebService();
                $logs->actionLogs($isAllowAccess); // 记录操作日志
            } catch (\Exception $e) {}

            if(! $isAllowAccess){
                if(IS_AJAX){
                    $this->ajaxReturn(array('status'=>C('AJAX_NO_AUTH_CODE'),'msg'=>$this->translator->no_auth,'data'=>''));
                }else{
                        $this->display('../Public/company404');
                        exit();
                }
            }
        } else {
            trace('非法进入：' . get_class($this) .'/'. ACTION_NAME);
            redirect(U(MODULE_NAME . '/Index/error404'));
            return;
        }
        return true;
    }

	/**
	 * 获取图片
	 */
    Public function outputImageByPath($imagePath, $modelClassName, $apiurl, $isdownload = false,$return=false)
    {
        $imgurl = base64_encode($imagePath);
        $imagePath = urldecode($imagePath);
	    $imageBinary = \AppTools::webService($modelClassName,
	                                        'getImageFromApi',
	                                        array('imagePath'=>$imagePath,
	                                              'apiurl'=>$apiurl)
	                   );
	    if(strlen($imagePath) == 40){
            $contentType='image/png';
	    } else {
	        $extName = strtolower(array_pop(explode('.', $imagePath)));
	        switch ($extName) {
	            case 'png':
	            case 'gif':
	            case 'jpg':
	                $contentType = 'image/' . $extName;
	                break;

	            case 'bmp':
	                $contentType = 'image/vnd.wap.wbmp';
	                break;

	            default:
	                $contentType = 'image/jpg';
	                $imageBinary = file_get_contents(WEB_ROOT_DIR.'images/background/logo.jpg');
	                break;
	        }
	    }

        if ($isdownload) {
            $temImgFile = WEB_ROOT_DIR . 'temp/cardpicture/' . $imgurl . '.' . $extName;
            // 文件不存在， 或者图片过小， 或者文件已存在超过5分钟
            if (! file_exists($temImgFile)
               || filesize($temImgFile)<200
	           || (time()-filemtime($temImgFile)>60*5)) {
                file_put_contents($temImgFile, $imageBinary);
            }

        }
        if($return){
            return 'temp/cardpicture/' . $imgurl . '.' . $extName;
        }else{
            header('Content-type: ' . $contentType);
	        echo $imageBinary;
        }

    }

	/**
	 * 获取图片
	 */
    Public function getImageFromApi($imagePath, $apiurl, $echoImageOrNot = false)
    {
        $imgurl = base64_encode($imagePath);
        $imagePath = urldecode($imagePath);
	    $imageBinary = \AppTools::webService('\Model\WebService','getImageFromApi',array('imagePath'=>$imagePath,'apiurl'=>$apiurl));

	    if(strlen($imagePath) == 40){
            $contentType='image/png';
	    } else {
	        $extName = strtolower(array_pop(explode('.', $imagePath)));
	        switch ($extName) {
	            case 'png':
	            case 'gif':
	            case 'jpg':
	                $contentType = 'image/' . $extName;
	                break;

	            case 'bmp':
	                $contentType = 'image/vnd.wap.wbmp';
	                break;

	            default:
	                break;
	        }
	    }

        if(strlen($imageBinary)>100){
            if ($echoImageOrNot) {
                header('Content-type: ' . $contentType);
	            echo $imageBinary;

	            return true;
            }

            return $imageBinary;

        } else {
            return false;
        }
    }

    /**
     * 获取标签
	 * param $conditions  array 搜索条件
	 * param $templatePath str 模板路径
	 *
     */
    protected function getLabels ($conditions=array(), $templatePath='')
    {
        $params = array();

        isset($conditions['sort']) && $params['sort'] = $conditions['sort'];
        isset($conditions['fields']) && $params['fields'] = $conditions['fields'];
        isset($conditions['keyword']) && $params['name'] = $conditions['keyword'];
        isset($conditions['createdtime']) && $params['createdtime'] = $conditions['createdtime'];
		isset($conditions['type']) && $params['type'] = $conditions['type'];//type =1 为精确搜索
        $params['rows'] = isset($conditions['rows']) ? $conditions['rows'] : 20;
        if (isset($conditions['p'])) {
            $p = intval($conditions['p']);
            $p = $p > 0 ? $p : 1;
            $params['start']  = ($p - 1) * $params['rows'];
        }

        $params = array_merge($conditions, $params);
    	$param = array('crud'=>'R', 'params'=>$params);
    	$result = \AppTools::webService('\Model\Label\Label', 'manageLabel', $param);

    	if (! $templatePath) {
    	    return $result;
    	}

        $labels = $result['data']['list'];
        //分页
        $page = getpage($result['data']['numfound'], $params['rows']);
        $this->assign('pagedata',$page->show());

        $this->assign('labels', $labels);

        $this->display($templatePath);
    }

    /**
     * 从API处获取行业信息
     */
    protected function _getIndustries ($conditions=array(), $templatePath='',$isReturn=false)
    {
        $params = array();

        isset($conditions['sort']) && $params['sort'] = $conditions['sort'];
        isset($conditions['fields']) && $params['fields'] = $conditions['fields'];
        isset($conditions['keyword']) && $params['name'] = $conditions['keyword'];
        isset($conditions['categoryid']) && $params['categoryid'] = $conditions['categoryid'];
		isset($conditions['parentid']) && $params['parentid'] = $conditions['parentid'];
		isset($conditions['status']) && $params['status'] = $conditions['status'];
		isset($conditions['type']) && $params['type'] = $conditions['type'];
		isset($conditions['restype']) && $params['restype'] = $conditions['restype'];
        $params['rows'] = isset($conditions['rows']) ? $conditions['rows'] : $this->rows;
        if (isset($conditions['p'])) {
            $p = intval($conditions['p']);
            $p = $p > 0 ? $p : 1;
            $params['start']  = ($p - 1) * $params['rows'];
        }
        // 合并请求参数
		$params = array_merge($conditions, $params);

    	$param = array('crud'=>'R', 'params'=>$params);
    	$result = \AppTools::webService('\Model\Industry\Industry', 'manageIndustry', $param);

    	if (!empty($conditions['withRootPosition'])) {
    	    $param['params'] = array('type' => 2, 'parentid' => 0);
    	    $result1 = \AppTools::webService('\Model\Industry\Industry', 'manageIndustry', $param);
    	    if ($result1['data']['list']) {
    	        $result['data']['list'] = array_merge($result['data']['list'], $result1['data']['list']);
    	    }
    	}

    	if (! $templatePath) {
    		if (IS_AJAX&&($isReturn==false)) {
    			!empty($conditions['max']) && $result = $result['data']['list']; //直接返回json数组
    			echo json_encode($result);
    			return;
    		} else {
    	    	return $result;
    		}
    	}

        $industries = $result['data']['list'];
        //分页
        $page = getpage($result['data']['numfound'], $params['rows']);
        $this->assign('pagedata',$page->show());

        $this->assign('industries', $industries);

        $this->display($templatePath);
    }

    /**
     * 从API处获取职能信息
     */
    protected function _getPositions ($conditions=array(), $templatePath='')
    {
        $params = array();

        isset($conditions['sort']) && $params['sort'] = $conditions['sort'];
        isset($conditions['fields']) && $params['fields'] = $conditions['fields'];
        isset($conditions['keyword']) && $params['name'] = $conditions['keyword'];
        isset($conditions['parentid']) && $params['parentid'] = $conditions['parentid'];
        isset($conditions['type']) && $params['type'] = $conditions['type'];
		isset($conditions['status']) && $params['status'] = $conditions['status'];
        $params['rows'] = isset($conditions['rows']) ? $conditions['rows'] : $this->rows;
        if (isset($conditions['p'])) {
            $p = intval($conditions['p']);
            $p = $p > 0 ? $p : 1;
            $params['start']  = ($p - 1) * $params['rows'];
        }

    	$param = array('crud'=>'R', 'params'=>$params);
    	$result = \AppTools::webService('\Model\Position\Position', 'managePosition', $param);

    	if (! $templatePath) {
    	    if (IS_AJAX) {
    	    	!empty($conditions['max']) && $result = $result['data']['list']; //直接返回json数组
    	        echo json_encode($result);
    	        return;
    	    } else {
    	        return $result;
    	    }
    	}

        $items = $result['data']['list'];
        //分页
        $page = getpage($result['data']['numfound'], $params['rows']);
        $this->assign('pagedata',$page->show());

        $this->assign('items', $items);

        $this->display($templatePath);
    }



}

/* EOF */