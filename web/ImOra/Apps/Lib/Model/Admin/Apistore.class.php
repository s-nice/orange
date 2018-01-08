<?php
namespace Model\Admin;
/*
 * 管理员操作日志 API | 管理员是否绑定虚拟客服API 相关接口
* @author jiyl <jiyl@oradt.com>
* @date   2015-12-28
*/
use Model\WebService;
class Apistore extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 获得管理员操作日志
	 * @param array $params
	 * @return array $response = array('status'=>0  成功|1 失败)
	 */
	public function getAdminLogs($params = array())
	{
		$webServiceRootUrl = C('API_ADMIN_APISTORE_ADMINLOG');
		// 发送http请求
		$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 添加管理员操作日志
	 * @param array $params
	 * @return array $response = array('status'=>0  成功|1 失败)
	 */
	public function addAdminLogs($params = array())
	{
		$params['action'] = 'add';
		// web service 接口路径
		$webServiceRootUrl = C('API_ADMIN_APISTORE_ADMINLOG');
		// 发送http请求
		$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 删除管理员操作日志
	 * @param array $params
	 * @return array $response = array('status'=>0  成功|1 失败)
	 */
	public function deleteAdminLogs($params = array())
	{
		$params['action'] = 'delete';
		// web service 接口路径
		$webServiceRootUrl = C('API_ADMIN_APISTORE_ADMINLOG');
		// 发送http请求
		$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 判断管理员是否绑定了客服账号
	 * @param array $params
	 * @return array $response 空数组说明没有绑定 |非空数组包含绑定客服用户信息
	 */
	public function getCustomer($params = array())
	{
		// web service 接口路径
		$webServiceRootUrl = C('API_ADMIN_APISTORE_GETCUSTOMER');
		// 发送http请求
		$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		if($response['status'] == 0 && $response['data']['numfound'] == 1){
			return $response['data']['list'][0];
		}else{
			return array();
		}
	}
	
	/**
	 * 内容协议管理 操作接口( 修改、查询)
	 * @param Array $params 协议管理操作参数
	 * @param string $crud  API的crud操作请求
	 * @return Array
	 */
	public function apistoreAgreement($params=array(), $crud='R')
	{
		// 设置请求方法为 新建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$crud = strtoupper($crud);
		switch ($crud){
			case 'R'://获取
				$webServiceRootUrl = C("API_APISTORE_AGREEMENT_GET");
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C'://创建
				$webServiceRootUrl = C("API_APISTORE_AGREEMENT_GET");
				break;
				/*    case 'D'://删除(暂时没有此功能)
				 // $webServiceRootUrl = C("");
				break;*/
			case 'U'://修改
				$webServiceRootUrl = C("API_APISTORE_AGREEMENT_EDIT");
				break;
			default:
				trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 协议管理model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
	
		return parseApi($response);
	}
}
