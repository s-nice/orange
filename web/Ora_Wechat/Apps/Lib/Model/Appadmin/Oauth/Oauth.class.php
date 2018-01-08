<?php
namespace Model\Appadmin\Oauth;
/*
 * 鉴权接口 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
use Model\WebService;
class Oauth extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 手机验证鉴权接口
	 * 使用短信验证码鉴权登陆
	 * mobile true string 手机号码
	 * mcode true string 电话区号,默认86
	 * code true string 短信验证码
	 * messageid true string 短信ID（发送验证码返回的ID）
	 * ip true string IP 地址
	 * device false 设备
	 */
	public function smslogin($params = array(),$crudMethod = 'C')
	{
		// web service path
		$webServiceRootUrl = C('WEB_SERVICE_ROOT_URL').'/oauth/apistore/smslogin';
		switch ($crudMethod){
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_C;
		}
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 鉴权接口
	 * 鉴权返回access token，每次访问其它接⼝都在HEADER 中提供此项信息，以供API 鉴权使用。
	 */
	public function oauth($params = array(),$crudMethod = 'C')
	{
		// web service path
		$webServiceRootUrl = C('WEB_SERVICE_ROOT_URL').'/oauth';
		switch ($crudMethod){
			case 'D':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
		}

		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	
	/**
	 *检测登陆用户
	 * @param string $username 用户账号
	 * @param string $password 用户密码
	 * @param return boolean
	 */
	public function getUserToken($username, $password, $usertype)
	{
		// web service 接口路径
		$webServiceRootUrl = C('API_ADMIN_LOGIN');
		// 设置请求方法为 创建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		$params = array('user'     => $username,
				'passwd'   => $password,
				'type'     => $usertype,
				'ip'       => get_client_ip()
		);
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		return parseApi($response);
	}
	
	/**
	 * 根据Email查询用户数据
	 * @param email
	 * @return array
	 */
	public function getUserByEmail($email)
	{
		// web service 接口路径
		$webServiceRootUrl = C('API_ADMIN');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		$params = array('email' => $email);
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		// 解析http 请求
		if ($response instanceof \ErrorCoder) { // 请求错误。 错误处理
			$errorMessage = $response->getErrorDesc();
			$errorCode = $response->getErrorCode();
		} else {// 解析用户信息
			$result = @ json_decode($response, true);
			if (is_array($result)) {
				if (isset($result['body']['admins']) && '0' == $result['head']['status']) {
					return $result['body'];
				} else {
					//错误信息
					return false;
				}
			} else {
				//错误信息
				return false;
			}
		}
	}

}
