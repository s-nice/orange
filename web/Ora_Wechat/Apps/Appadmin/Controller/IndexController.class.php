<?php
namespace Appadmin\Controller;
//use Appadmin\Controller;
use Classes\GFunc;

class IndexController extends AdminBaseController
{
	protected $rows = 20;//每页显示20行

	public function _initialize()
	{
		parent::_initialize();
		$this->leftAndBreadcrumb();
	}

	/**
	 * 后台首页
	 * Enter description here ...
	 */
	public function index()
	{
		/*$session_info = session(MODULE_NAME);
		var_dump($session_info);
		//$params = array('params'=>array('adminid'=>$session_info['adminid']));
		$admin_info = \AppTools::webService('\Model\AdminInfo\AdminInfo','getAdminInfo',$params);
		$role_id = array('roleid'=>$admin_info['roleid']);
		$admin_info['role_name'] = \AppTools::webService('\Model\AdminInfo\AdminInfo','getAdminRole', $role_id);
		$session_info['role_name'] = $admin_info['role_name'];
		session(MODULE_NAME,$session_info);
		$admin_info['lastlogintime'] = date('Y-m-d H:i:s',strtotime($admin_info['lastlogintime'])+28800);//当地时间
		$login_time = explode('-',$admin_info['lastlogintime']);
		$admin_info['date'] = $login_time[0].$this->translator->year.$login_time[1].
			$this->translator->month.str_replace(' ',$this->translator->day,$login_time[2]);*/
		$admin_info=session(MODULE_NAME);
		$this->assign('admin_info', $admin_info);
		$this->getCommonMenu('mypanel');
		//  echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($this->translator,1);exit;
		$this->assign('title',$this->translator->home_page);
		$this->display('Index/index');
	}

	/**
	 * 左侧菜单及面包屑导航
	 * Enter description here ...
	 */
	private function leftAndBreadcrumb()
	{
		$method = ACTION_NAME;
		$left_menu1 = array('link'=>'/'.MODULE_NAME.'/Index/showModifyPage', 'title'=>$this->translator->modify_personal_info);
		$left_menu2 = array('link'=>'/'.MODULE_NAME.'/Index/modifyPasswd', 'title'=>$this->translator->modify_passwd);
		switch($method){
			case 'index':
				$breadcrumb_menu =
					array(
						array('link'=>'/'.MODULE_NAME.
							'/AdminInfo/Index/index', 'title'=>$this->translator->my_panel)
					);
				break;
			case 'showModifyPage':
				$breadcrumb_menu =
					array(
						array('link'=>'Index/index', 'title'=>$this->translator->my_panel),
						array('link'=>'Index/index', 'title'=>$this->translator->personal_info),
						array('link'=>'Index/index', 'title'=>$this->translator->modify_personal_info)
					);
				$left_menu1['active'] = 1;
				break;
			case 'modifyPasswd':
				$breadcrumb_menu =
					array(
						array('link'=>'Index/index', 'title'=>$this->translator->my_panel),
						array('link'=>'Index/index', 'title'=>$this->translator->personal_info),
						array('link'=>'Index/index', 'title'=>$this->translator->modify_passwd)
					);
				$left_menu2['active'] = 1;
				break;
			default:
				;
		}


		$leftMenu = array('title'=>$this->translator->personal_info, 'menus'=>array($left_menu1, $left_menu2));
		//$this->assign('breadcrumbs', $breadcrumb_menu);
	//	$this->assign('leftMenu', $leftMenu);
	}

	/**
	 * 修改个人信息
	 * Enter description here ...
	 */
	public function showModifyPage()
	{
		$session_info = session(MODULE_NAME);
		$info=GFunc::getAdminAccountInfo($session_info['info']['adminid']);
		//$params = array('params'=>array('adminid'=>$session_info['adminid']));
		//$admin_info = \AppTools::webService('\Model\AdminInfo\AdminInfo','getAdminInfo',$params);
		/*$last_login_time = explode('-',$session_info['logintime']);
		$session_info['logintime'] = $last_login_time[0].$this->translator->year.

			$last_login_time[1].$this->translator->month.str_replace(' ',$this->translator->day,$last_login_time[2]);*/
		$this->assign('admin_info',$info);
		$this->assign('moreScripts',array(
			'js/Appadmin/globalPop','js/Appadmin/admininfo'));
		$this->getCommonMenu('personalinfo','showModifyPage');
		$this->assign('title',$this->translator->modify_personal_info);
		$this->display('Index/modifyinfo');
	}

	/**
	 * 修改个人信息
	 */
	public function modifyInfo()
	{
		$session_info = session(MODULE_NAME);
		$realname = I('post.realname');
		//$email = I('post.email');
		//$mobile = I('post.mobile');
		$params = array();
		if(!empty($realname)){
			$params['realname'] = $realname;
		}
		/*
        if(!empty($email)){
            $params['email'] = $email;
        }
        if(!empty($mobile)){
            $params['mobile'] = $mobile;
        }*/
		$params['adminid'] = $session_info['info']['adminid'];
		$bool = \AppTools::webService('\Model\Appadmin\AdminAccount', 'manageAdminAccount', array('params'=>$params,'crud'=>'U'));
		$data = array();
		if($bool){
			$data['status'] = 0;
			$data['message'] = $this->translator->modify_admin_personal_succ;
			$this->ajaxReturn($data);
		}else{
			$data['status'] = 1;
			$data['message'] = $this->translator->modify_admin_personal_fail;
			$this->ajaxReturn($data);
		}
	}

	/**
	 * 检查旧密码
	 */
	public function getOldPasswd()
	{
		$password = I('post.password');
		if(!empty($password)){
			$session_info = session(MODULE_NAME);
		//	$params = array('params'=>array('email'=>$session_info['info']['email']));
		//	$bool = \AppTools::webService('\Model\AdminInfo\AdminInfo','checkPasswd',$params);
		//	$data = array();
			if(md5($password)==$session_info['password']){
				$data['status'] = 0;//ok
				$this->ajaxReturn($data);
			}else{
				$data['status'] = 1;//err
				$this->ajaxReturn($data);
			}
		}
	}

	/**
	 * 修改密码
	 */
	public function modifyPasswd()
	{
		$password = I('post.password');
		$session_info = session(MODULE_NAME);
		if(!empty($password)){
			$params = array('params'=>array('adminid'=>$session_info['info']['adminid'],'passwd'=>$password),'crud'=>'U');
			$bool = \AppTools::webService('\Model\Appadmin\AdminAccount', 'manageAdminAccount', $params);
			$data = array();
			if($bool){
				$data['status'] = 0;//ok
				$data['message'] = $this->translator->modify_admin_passwd_succ_redirect;
				$this->ajaxReturn($data);
			}else{
				$data['status'] = 1;//err
				$data['message'] = $this->translator->modify_admin_passwd_fail;
				$this->ajaxReturn($data);
			}
		}
		$this->assign('title',$this->translator->modify_passwd);
		$this->assign('session_info',$session_info['info']);
		$this->assign('moreScripts',array('js/Appadmin/globalPop',
			'js/Appadmin/admininfo'));
		$this->getCommonMenu('personalinfo','modifyPasswd');
		$this->display('Index/modifypasswd');
	}

	/**
	 * 服务器异常模板
	 */
	public function noPermission ()
	{
		$this->assign('return',isset($_GET['redirect']));
		$this->display('../Public/nopermission');
	}
	/**
	 * 404页面模板
	 */
	public function error404 ()
	{

		$this->display('../Public/error404');
	}

	//锁屏方法
	public function lock()
	{
		parent::lock();
	}

	//解锁方法
	public function unlock()
	{
		parent::unlock();
	}

	/**
	 * 管理员账号管理
	 * */
	public function AdminAccount(){
		$rows=$this->rows;
		$p=I('p',1);
		$start=($p-1)*$rows;
		$sort = I('get.sort', 'id', 'strval,trim');//排序字段
		$sortType = I('get.sortType', 'desc');//排序升降：asc，desc
		$keyword=urldecode(I('keyword',''));
		$status=I('status',null);
		$params=array(
			'p'=>$p,
			'rows'=>$rows,
			'start'=>$start,
			'sort'=>$sort.' '.$sortType,
			'state'=>$status,
			'realname'=>$keyword,
			'roleid'=>1 //角色ID 1 为管理员 0为超级管理员
		);
	//	$params =array();
		$model=new \Model\Appadmin\AdminAccount();
		$result=$model->manageAdminAccount($params,'R');
		$numFound=$result['data']['numfound'];
		$totalpages = ceil($numFound / $rows);
		$page = getpage($numFound,$rows);//使用分页类
		$this->assign('pagedata', $page->show());//分配分页
		$this->assign('totalpage',$totalpages);//分配总页数
		$sortParams=array( //排序用url 传参
			'sortType'=> $sortType == 'asc' ? 'desc' : 'asc',
			'keyword'=>$keyword
		);
		$this->assign('list',$result['data']['admins']);
		$this->assign('params',$params);
		$this->assign('sortParams',$sortParams);
		$this->assign('sort', $sort);//排序
		$this->assign('keyword', $keyword);//关键词
		$this->assign('sortType', $sortType);//asc or descc
		$this->assign('moreCSSs', array('js/jsExtend/datetimepicker/datetimepicker'));//加载css
		$this->assign('moreScripts', array('js/Appadmin/AdminAccount','js/jsExtend/datetimepicker/datetimepicker'));
		$this->getCommonMenu('adminaccount');
		$this->display('AdminAccount');
	}

	/**
	 * 添加编辑管理员账号页面
	 * */

	public function addAdminAccount()
	{
		if(I('id')){ //编辑
			$params['id']=I('id');
			$model=new \Model\Appadmin\AdminAccount();
			$result=$model->manageAdminAccount($params,'R');
			$this->assign('info',$result['data']['admins'][0]);
		}
		$this->assign('moreScripts', array('js/Appadmin/AdminAccount'));
		$this->getCommonMenu('adminaccount');
		$this->display('addAdminAccount');
	}
	/**
	 * 添加编辑管理员账号
	 * */
	public function doAddEditAccount(){
		$params['email']=I('email');
		$params['realname']=I('realname');
		$crud='C'; //默认创建
		if(I('password')){
			$params['passwd']=I('password');
		}
		if(I('id')){ //编辑
			$params['adminid']=I('id');
			$crud='U';
		}
		$model=new \Model\Appadmin\AdminAccount();
		$result=$model->manageAdminAccount($params,$crud);
		$this->ajaxReturn($result);
	}


}