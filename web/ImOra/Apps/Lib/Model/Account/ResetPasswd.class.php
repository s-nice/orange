<?php
/*
 * 重置密码接口
 * @author jiyl <jiyl@oradt.com>
 */
namespace Model\Account;
use Model\WebService;
class ResetPasswd extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 充值密码
	 */
	public function resetPasswd($params = array(),$crudMethod='C')
	{
		
		switch ($crudMethod){
			case 'R':
				// 获取验证码
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 申请重置密码
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'U':
				// 提交密码
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		// 发送http请求
		$response = $this->request(C('API_RESET_PASS_BY_SMS'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	
}
?>