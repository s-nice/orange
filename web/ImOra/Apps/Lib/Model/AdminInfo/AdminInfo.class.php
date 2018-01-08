<?php 
namespace Model\AdminInfo;

use Model\WebService;
class AdminInfo extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 修改管理员信息
	 * Enter description here ...
	 */
	public function modifyAdminInfo($params)
	{
		$webServiceRootUrl = C('API_ADMIN');
		$crudMethod = parent::OC_HTTP_CRUD_U;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$result = parseApi($response);
		if(!$result['status']){
			$session_info = session(MODULE_NAME);
			if(!empty($params['realname'])){
				$session_info['realname'] = $params['realname'];
			}
			if(!empty($params['email'])){
				$session_info['email'] = $params['email'];
			}
			if(!empty($params['mobile'])){
				$session_info['mobile'] = $params['mobile'];
			}
			session(MODULE_NAME,$session_info);
			return true;
		}
		return false;
	}
	
	/**
	 * 查看管理员信息
	 * Enter description here ...
	 * @param unknown_type $params
	 */
	public function getAdminInfo($params)
	{
		$webServiceRootUrl = C('API_ADMIN');
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$result = parseApi($response);
		if(!$result['status']){
			return $result['data']['admins'][0];
		}
		return array();
		//print_r($result);exit;
	}
	
	/**
	 * 查看角色
	 */
	public function getAdminRole($roleid)
	{
		$webServiceRootUrl = C('API_ADMIN_ROLE');
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$params = array('roleid'=>$roleid);
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$result = parseApi($response);
		if(!$result['status']){
			return $result['data']['groups'][0]['name'];
		}
		return false;
	}
	
	/**
	 * 检查管理员密码是否正确
	 */
	public function checkPasswd($params)
	{
		$webServiceRootUrl = C('API_ADMIN');
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		if(!$result['status']){
			
		}
		
	}
	
	/**
	 * 修改密码
	 */
	public function modifyPasswd($params)
	{
		$webServiceRootUrl = C('API_ADMIN');
		$crudMethod = parent::OC_HTTP_CRUD_U;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		if(!$result['status']){
			$session_info = session(MODULE_NAME);
			$session_info['password'] = md5($params['passwd']);
			session(MODULE_NAME,$session_info);
			return true;
		}else{
			return false;
		}
	}
}
?>