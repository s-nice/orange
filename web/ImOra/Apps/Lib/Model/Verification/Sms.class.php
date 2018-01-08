<?php
/*
 * 验证接口 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
namespace Model\Verification;
use Model\WebService;
class Sms extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 短信验证接口 
	 * 支持对短信验证码的获取和验证操作。
	 * mobile true string 手机号码
	 * mcode true string 电话区号,默认86
	 * module true enumeration 验证模块
	 */ 
	public function sms($params = array(),$crudMethod = 'R')
	{
		// web service path
		$webServiceRootUrl = C('API_VERIFY_SMS');
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 读取
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 邮箱验证接口
	 * 支持对邮件验证码/链接的获取和验证操作。
	 */
	public function email($params = array(),$crudMethod = 'R')
	{
		// web service path
		$webServiceRootUrl = C('API_VERIFY_EMAIL');
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 读取
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				;
		}
	
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 短信查询接口
	 * 支持对手机验证码的查询。
	 */
	public function getsendsms($params = array(),$crudMethod = 'R')
	{
		// web service path
		$webServiceRootUrl = C('API_COMMON_APISTORE_GETSENDSMS');
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 读取
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			default:
				// 设置请求方法为 读取
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
	
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
}
?>