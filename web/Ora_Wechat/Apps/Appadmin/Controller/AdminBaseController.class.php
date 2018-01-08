<?php
namespace Appadmin\Controller;
use BaseController\BaseController;
use Model\WebService;
use Zend\Http\Header\Vary;

/**
 * 后台控制器基类
 */
class AdminBaseController extends BaseController
{
    /*
     * 用户获取的权限列表
     * @var array
     */
    protected $authorityList = array();
    protected $menuList = array();
    protected $navList = array();

    protected $rows = 20;//每页显示20行

    //protected $PubAuthorityFun = array('unlock','lock','nopermission','error404');
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
     * 初始化控制器， 检查是否设置session
     */
    public function _initialize()
    {
      //  $this->accessControl();
        parent::_initialize();
        //加载语言包
        $this->translator->mergeTranslationDir(APP_PATH . 'Lang/'. $this->uiLang, 'xml');//获取语言配置文件
        $this->menuList = require(APP_PATH.'Appadmin/Conf/'.'menuConf.php'); //权限配置文件加载
        $userinfo = session(MODULE_NAME);

        $list = require(APP_PATH.'/'.MODULE_NAME.'/Conf/authorityList.php');
        //配置中的所有权限列表
        $AuthorityList = $list['AuthorityList'];
        $array = array();
        foreach ($AuthorityList as $v) {
            if(isset($v['children'])){
                foreach ($v['children'] as $v1) {
                    $array = array_merge($array,$v1['access']);
                }
            }else{
                $array = array_merge($array,$v['access']);
            }
        }

        $AuthorityList=getCtrActList($array);


    //    $myAuthorityList = $userinfo['rolelist'];
        $myAuthorityList = $AuthorityList;
        //判断权限
         //$this->hasAuthority();
        //获取顶级菜单
        $modules = array_keys($myAuthorityList);
        $menu = $this->getMenu($myAuthorityList);
        $this->_outputPhpVars();//输出锁定功能相关变量
        $this->assign('admin_info', $userinfo);//头部管理员信息
        $this->assign('menu', $menu);

      /*   $session = session(MODULE_NAME);
        $rolelist = \AppTools::webService('\Model\Role\Role', 'getRoleList',array('params'=>array('roleid'=>$session['roleid'])));
        if($rolelist['data']['groups'][0]['status'] == '2'){
        	$session['rolelist'] = json_decode($rolelist['data']['groups'][0]['permission'],true);
        }else{
        	$session['rolelist'] = array('Index'=>array('index'));
        }
        session(MODULE_NAME, $session); */
    }
    /**
     * php端输出js变量
     */
    private function _outputPhpVars()
    {
    	if(!IS_AJAX){
    		$session = session(MODULE_NAME);
    		$this->assign('isLocked',$session['islock']);
    		$this->assign('JS_LOCK_SCREEN_TIME', C('LOCK_SCREEN_TIME')); //设置锁屏时间
    	}
    	$lockArr = array('unlock','islocked','lock'); //定义不用更新锁定时间列表
    	$actionName = strtolower(ACTION_NAME);
    	if($this->isLocked()==0 && !in_array($actionName, $lockArr)){
    		 $this->resetLock();
    	}
    }

    /**
     * 用户解锁操作
     */
    public function unlock()
    {
    	$password = I("post.unlookcode");
    	$session = session(MODULE_NAME);
    	$status = 1;
    	$msg = $this->translator->unlock_fail;
    	if($session['password'] == md5($password)){
    		$status = 0;
    		$msg    = $this->translator->unlock_succ;
    		$this->resetLock($session);
    	}
    	$this->ajaxReturn(array('status'=>$status,'msg'=>$msg,'data'=>NULL));
    }

    /**
     * 判断是否已经锁屏
     */
    public function isLocked()
    {
    	$session = session(MODULE_NAME);
    	return $session['islock'];
    }
    /**
     * 重置锁状态与锁时间
     * @param unknown $session
     */
    public function resetLock($session=null)
    {
    	empty($session) &&  $session=session(MODULE_NAME);
    	$session['islock'] = 0; //0:表示不锁定，1：锁定
    	$session['islockstart'] = time();
    	session(MODULE_NAME,$session);
    }
    /**
     * 锁定屏幕动作
     */
    public function lock()
    {
    	$lock = I('post.lscreen');
    	$hand = I('post.hand'); //是否手动锁屏，1表示手动
    	if($lock == 1){
    		$session = session(MODULE_NAME);
    		$flag = 1; //0表示锁定成功，1：锁定失败
    		if(time() - $session['islockstart'] >= C('LOCK_SCREEN_TIME') || $hand =='1'){
    			$session['islock'] = 1;
    			session(MODULE_NAME,$session);
    			$flag = 0;
    		}
    		$this->ajaxJson($flag,null, $session['islockstart']*1000);
    	}
    }

    /**
     * 权限验证处理
     */
    private function _verifyAuth($roleList=array())
    {
    	$moduleName = CONTROLLER_NAME;
    	if($moduleName != 'Index' && !isset($roleList[$moduleName])){
    		if(IS_AJAX || I('isAjax')==1){
    			$this->ajaxReturn(array('status'=>\ErrorCoder::ERR_FILE_NOT_PERMISSION,'msg'=>\ErrorCoder::ERR_DESC_1004,'data'=>''));
    		}else{
    			$url = U('Home/Public/noPermission');
    			redirect($url);
    		}
    	}else{
    		/* $actions = array_map('strtoupper',$roleList[$moduleName]);
    		var_dump(ACTION_NAME,$actions);exit;
    		if(!in_array(ACTION_NAME,$actions)){

    		} */
    	}
    }
    /**
     * 弹出提示信息，并刷新返回上一页
     * @param string $msg
     */
/*     public function back($msg = '', $url = '')
    {
        header("Content-type: text/html; charset=utf-8");
        if ($msg) {
            $msg = "alert('" . $msg . "');";
        }
        if ($this->strEmpty($url)) {
            echo "<script>" . $msg . "history.back(-1);</script>";
        } else {
            echo "<script>" . $msg . "location.href = '" . $url . "';</script>";
        }
        die;
    } */

    /**
     * 判断字符串是否为空
     * @param type $str
     * @return boolean
     */
    public function strEmpty($str = '')
    {
        if (!isset($str) || empty($str) || preg_replace('/\s(?=\s)/', '', trim($str)) == '') {
            return true;
        }
        return false;
    }
    

    /**
     * 获取菜单
     * @param array $myAuthorityList 权限数组
     * @return array $myMenu
     */
    public function getMenu($myAuthorityList)
    {
        $myMenu  = array();
        $mod = CONTROLLER_NAME;//控制模块访问
        //$globleMenus = $this->globleAuthority;//获得对应模块控制器配置
        foreach ($this->menuList as $key =>$_menuInfo) {//遍历目录控制器配置文件 得到菜单
            $active = 0;
            $disable = 1;
            $url = '';
            foreach ($_menuInfo['children'] as $v){
                if(isset($myAuthorityList[$v][0])){
                    $this->navList[$key] = $v.'/'.$myAuthorityList[$v][0];
                    $url = U($v.'/'.$myAuthorityList[$v][0],'','',true);
                    //echo $url;die;
                    $disable = 0;
                    break;
                }
            }
            in_array($mod,$_menuInfo['children']) && $active = 1;
            $myMenu[] = array('text'=>$_menuInfo['text'],'href'=>$url,'disable'=>$disable,'active'=>$active);
            
        }
        //p($myMenu);die;
        return $myMenu;
    }

    /**
     * ajax返回json数据格式
     * @param number $status 操作状态码 0:表示成功，非0表示失败
     * @param string $msg 操作提示消息
     * @param string $data 传递给前端的数据
     * @param string $original 仅当当操作失败时，返回给前端的额外错误信息,便于开发人员使用
     */
    protected function ajaxJson($status, $msg='', $data=null, $original=null)
    {
    	$result = array('status'=>$status,'msg'=>$msg,'data'=>$data);
    	$status != 0 && $result['$original']=$original;
    	return $this->ajaxReturn($result,'JSON');
    }

    /**
     * 获取左侧菜单，title ,面包屑导航
     * @param  string $className 类名称
     * @param  string $activeMenu  活动菜单（控制器名称）
     * @param string $smallMenu 二级小菜单
     *
     */
    protected function getLeftMenu($className,$activeMenu=null, $smallMenu=null ){
        $leftMenu=array(
            'Admin'=>array('title'=>$this->translator->str_set,
                  'menus'=>array(
                      'index'=> array('title'=>$this->translator->str_admin_manage,'link'=>MODULE_NAME.'/Admin/index'),
                      'role'=> array('title'=>$this->translator->str_role_manage,'link'=>MODULE_NAME.'/Admin/role'),
                  	  'logs'=> array('link'=>'logs/index', 'title'=>$this->translator->expand_admin_logs)
                  )
            ),
            'BasicData'=>array('title'=>$this->translator->basic_data_management,
                'menus'=>array(
                    'industry'=> array('title'=>$this->translator->str_industry_management,'link'=>MODULE_NAME.'/BasicData/industry'),
                    'city'=> array('title'=>$this->translator->str_city_management,'link'=>MODULE_NAME.'/BasicData/city'),
                	'title'=> array('title'=>$this->translator->str_menu_titlemanagement,'link'=>MODULE_NAME.'/BasicData/titlemanage')
                )

           ),
           'scancard'=>array('title'=>$this->translator->str_menu_scanner_usage,
                'menus'=>array(
                    'scannermanager'=>array('link'=>'ScannerManager/index', 'title'=>$this->translator->scanner_manager,
	    	                        'qrcode'=>$this->translator->str_print_qrcode,'history'=>$this->translator->str_scanner_history,
	    							'infomation'=>$this->translator->str_scanner_card_infomation
			    	),
		           /*  'officialpartner'=>array('link'=>'Officialpartner/OfficialpartnerList', 'title'=>$this->translator->official_partner_manage,
		            		'partnerdetail'=>$this->translator->str_look_detail,'infomation'=>$this->translator->str_scanner_card_infomation
			    	), */
		          /*  'cardshare'=>array('link'=>'CardShare/index', 'title'=>$this->translator->str_card_share ),*/
                )
           ),
           //'software' => array('link'=>MODULE_NAME.'/SoftwareManage/softwareUpdate', 'title'=>$this->translator->expand_software_version_manage ),
        );
        if(isset($activeMenu)){
        	$leftMenu["$className"]["menus"]["$activeMenu"]['active'] = 1;
        }else{
        	$leftMenu["$className"]['active'] = 1;
        }
        $menuInfo= $leftMenu[$className];
        /*导航*/
        $breadcrumbs = array(
            array('title'=>'设置','link'=>'Admin/index'),$menuInfo['menus'][$activeMenu]
            );
        // 二级小标题存在 就增加右侧面包屑
        if(isset($menuInfo['menus'][$activeMenu][$smallMenu])){
        	$breadcrumbs[] = array('title'=>$menuInfo['menus'][$activeMenu][$smallMenu]);
        }else{
        	unset($breadcrumbs[1]['link']);
        }
        $this->assign('breadcrumbs',$breadcrumbs );
        /*title*/
        $this->assign('title',$leftMenu[$className]['title'].'-'.$leftMenu[$className]['menus'][$activeMenu]['title']);
        /*左侧菜单*/
        $this->assign('leftMenu6',$leftMenu);

    }

    /**
     * 扩展左侧菜单(用户管理模块)
     * @param number $num 当前选中是第一个值
     */

    public function getUserManageExtendMenu($menuModule='person',$mKey = 'logs',$parentKey=null){
    	$mKeyTmp = $mKey;
    	$entManage = array('link'=>'user/entManage', 'title'=>$this->translator->str_ent_manage ); //企业管理列表
    	$entExpensesRecord = array('link'=>'user/entCertifiedList', 'title'=>$this->translator->str_perExpensesRecord );//企业消费记录列表;
    	$entAuthedAccount = array('link'=>'user/entAuthedAccount', 'title'=>$this->translator->str_ent_auth_account );//企业授权账号列表
    	$entCertifyTpl = array('link'=>'user/entCertifyTpl', 'title'=>$this->translator->str_ent_auth_account ); //企业认证操作
    	$entInfoDetail = array('link'=>'PartnerManager/partnerDetail', 'title'=>$this->translator->str_ent_detail );//企业详情
    	$scallVcardDetail = array('link'=>'PartnerManager/scallVcardDetail', 'title'=>$this->translator->str_scannered_cards_list );//扫描名片列表
    	//定义企业管理中父子菜单的关系
    	$children = array(
    			'ent'=>array( /*key=>val对应    子菜单->父菜单  */
    				'entExpensesRecord'=>'entManage', 'entAuthedAccount'=>'entManage',
    				'partnerDetail'=>'entManage', 'scallVcardDetail'=>'entManage',
    				'entCertifyTpl'=>array('entCertifiedList'=>'entCertifiedList', 'entNotCertifiedList'=>'entNotCertifiedList'),
    		    ),
                'person'=>array(
                    'perTradeEvaluation'=>'index',
                    'perExpensesRecord'=>'index',
                    'perNotCertifiedDetail'=>'perNotCertifiedUser',
                    'perCertifiedDetail'=>'perCertifiedUser',
                )
        );
    	$menus = array(
    			'person'=>array(
    					'usermanage'=>array('link'=>'user/index', 'title'=>$this->translator->str_user ),//用户管理首页列表
    					//'comments'=>array('link'=>'user/perTradeEvaluation', 'title'=>$this->translator->str_perTradeEvaluation ), //交易评价
    					//'consumer'=>array('link'=>'user/perExpensesRecord', 'title'=>$this->translator->str_perExpensesRecord ), //消费记录
    					//'perNotCertifiedUser'=>array('link'=>'user/perNotCertifiedUser', 'title'=>$this->translator->str_user_not_certified ), //待认证用户身份
    					//'perCertifiedUser'=>array('link'=>'user/perCertifiedUser', 'title'=>$this->translator->str_user_certified ), //已认证用户身份
    			),
    			'ent'=>array(
    					'entManage'=>$entManage,
    					'entNotCertifiedList'=>array('link'=>'user/entNotCertifiedList', 'title'=>$this->translator->str_ent_not_certified ), //待认证企业
    					'entCertifiedList'=>array('link'=>'user/entCertifiedList', 'title'=>$this->translator->str_ent_certified ), //已认证企业
    			)
    	);

    	if(!isset($menus[$menuModule][$mKey])){
    		 $mKey = is_array($children[$menuModule][$mKey])?$children[$menuModule][$mKey][$parentKey] : $children[$menuModule][$mKey];
    	}

    	$menus[$menuModule][$mKey]['active'] = 1;
    	$leftMenu = array(
    			array('title'=>$this->translator->str_user_person, 'menus'=>$menus['person']), //个人用户菜单列表
    			//array('title'=>$this->translator->str_user_ent, 'menus'=>$menus['ent'] ) //企业用户菜单列表
    	);
    	$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), array('title'=>$menus[$menuModule][$mKey]['title']));
    	switch ($mKeyTmp){
    		case 'entExpensesRecord'://企业消费记录列表;
    			$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), $entManage, $entExpensesRecord);
    			break;
    		case 'entAuthedAccount'://企业授权账号列表
    			$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), $entManage, $entAuthedAccount);
    			break;
    		case 'partnerDetail': //企业详情,代码位于模块：PartnerManager
    			$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), $entManage, $entInfoDetail);
    			break;
    		case 'entCertifyTpl': //企业认证操作
    			$middleMenu = ($parentKey && isset($menus[$menuModule][$parentKey])) ? $menus[$menuModule][$parentKey] : $entManage; //获取中间菜单，因为用户审核认证和取消认证公用了一个模板，造成成了判断菜单逻辑复杂
    			$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), $middleMenu, $entCertifyTpl);
    			break;
    		case 'scallVcardDetail': //扫描名片列表,代码位于模块：PartnerManager
    			$breadcrumbs = array(array('title'=>$this->translator->str_regusermanage,'link'=>'user/index'), $entManage, $entInfoDetail,$scallVcardDetail);
    			break;
    		default:
    	}
    	$this->assign('breadcrumbs', $breadcrumbs);
    	$this->assign('leftMenu6', $leftMenu);
    }

    //将$_GET中的参数用urldecode处理
    private function urldecodeGet($get){
        foreach ($get as $key => $value) {
            $get[$key] = urldecode($value);
        }
        return $get;
    }

    //用来处理兑换时间和发放时间排序 图标，及链接
    protected function getHrefClass($sort_type,$sort,$params1,$params2){
        $get = $this->urldecodeGet($_GET);
        unset($get['t_sort']);
        $href_arr = array($params1=>$get,$params2=>$get);
        $href_arr[$params1]['t_sort'] = $params1;
        $href_arr[$params2]['t_sort'] = $params2;
        $href_class_arr = array();
        switch ($sort_type) {
            case $params1:
                $sort_name = $params1;
                $href_class_arr[$params2]['classname'] = 'list_sort_none';

                $href_arr[$params2]['sort'] = 1;
                $href_class_arr[$params2]['href'] = U(ACTION_NAME,$href_arr[$params2]);
                break;
            case $params2:
                $sort_name = $params2;
                $href_class_arr[$params1]['classname'] = 'list_sort_none';

                $href_arr[$params1]['sort'] = 1;
                $href_class_arr[$params1]['href'] = U(ACTION_NAME,$href_arr[$params1]);
                break;
            default:
                $sort_name = 'id';
                $href_class_arr[$params2]['classname'] = 'list_sort_none';
                $href_class_arr[$params1]['classname'] = 'list_sort_none';
                $href_arr[$params2]['sort'] = 1;
                $href_class_arr[$params2]['href'] = U(ACTION_NAME,$href_arr[$params2]);
                $href_arr[$params1]['sort'] = 1;
                $href_class_arr[$params1]['href'] = U(ACTION_NAME,$href_arr[$params1]);
                break;
        }
        switch ($sort) {
            case 1:
                $params_sort = $sort_name.',asc';
                //tpl排序图标的class
                $href_class_arr[$sort_name]['classname'] = 'list_sort_asc';
                $href_arr[$sort_name]['sort'] = 2;
                $href_class_arr[$sort_name]['href'] = U(ACTION_NAME,$href_arr[$sort_name]);
                break;

            default:
                $params_sort = $sort_name.',desc';
                $href_class_arr[$sort_name]['classname'] = 'list_sort_desc';
                $href_arr[$sort_name]['sort'] = 1;
                $href_class_arr[$sort_name]['href'] = U(ACTION_NAME,$href_arr[$sort_name]);
            break;
        }
        return array('href_class_arr'=>$href_class_arr,'params_sort'=>$params_sort);
    }


    protected function getCommonMenu($key,$mkey,$others=null){
        $menus = array();
        foreach ($this->menuList as $k => $v) {
            if(isset($v['leftmenu'])){   
                foreach ($v['leftmenu'] as $k1 => $v1) {
                    if($k1==$key){
                        $menus = $this->menuList[$k];
                        $baseKey = $k;
                        break 2;
                    }
                }
            }
        }
        $leftMenu = $menus['leftmenu'];
        $keys = array_keys($leftMenu);
        isset($leftMenu[$key]) || $key = $mkey = $keys[0];

        if(($mkey)&&(isset($leftMenu[$key]['menus'][$mkey]))){
            $leftMenu[$key]['menus'][$mkey]['active'] = 1;

            $breadcrumbs[] = array('title'=>$this->translator->$menus['text'],'link'=>$this->navList[$baseKey]);
            if($this->translator->$menus['text']!=$leftMenu[$key]['title']){
                $breadcrumbs[] = array('title'=>$leftMenu[$key]['title'],'link'=>$leftMenu[$key]['link']);
            }
            if(!is_null($others)){
                $breadcrumbs[] = array('title'=>$leftMenu[$key]['menus'][$mkey]['title'],'link'=>$leftMenu[$key]['menus'][$mkey]['link']);
            }else{     
                $breadcrumbs[] = array('title'=>$leftMenu[$key]['menus'][$mkey]['title']);
            }
        }else{

            $breadcrumbs[] = array('title'=>$this->translator->$menus['text'],'link'=>$this->navList[$baseKey]);
            if($this->translator->$menus['text']!=$leftMenu[$key]['title']){
                $breadcrumbs[] = array('title'=>$leftMenu[$key]['title']);
            }
            $leftMenu[$key]['active'] = 1;
        }
        //判断是否有第三个参数
        if(!is_null($others)){
            $type = gettype($others);
            if($type=='array'){
                foreach ($others as $value) {
                    $arr = array();
                    $arr['title'] = $value;
                    $breadcrumbs[] = $arr;
                }
            }elseif($type=='string'){
                $arr = array();
                $arr['title'] = $others;
                $breadcrumbs[] = $arr;
            }
        }

        if($key=='mypanel' && $_SESSION['Appadmin']['info']['roleid'] !=='0') {
            unset($leftMenu['adminaccount']);
        }

        $this->assign('breadcrumbs', $breadcrumbs);
        $this->assign('leftMenu5', $leftMenu);
    } 
}

/* EOF */