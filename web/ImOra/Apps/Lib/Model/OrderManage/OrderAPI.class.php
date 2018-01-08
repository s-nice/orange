<?php
/*
 * 订单管理 相关接口
 * @author jiyl <jiyl@oradt.com>
 */
namespace Model\OrderManage;
use Model\WebService;
class OrderAPI extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 冻结订单操作
	 */ 
	public function frozenOrder($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;
		//* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_ORDERMANAGE_API').'/handle', $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	/**
	 * 定则操作
	 */
	public function liabilityAct($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;
		//* 解析http 请求
		// 发送http请求
		$response = $this->request(C('API_ORDERMANAGE_API').'/ident', $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		
		return $response;
	}
	
	/**
	 * 订单回访操作
	 */
	public function addVisit($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;
		//* 解析http 请求
		// 发送http请求
		$response = $this->request(C('API_ORDERMANAGE_API').'/visit', $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
	
		return $response;
	}
	/**
	 * 上架(下架)操作
	 */
	public function shareCard($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_U;
		//* 解析http 请求
		// 发送http请求
		$response = $this->request(C('API_CONTACT_VCARD'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
	
		return $response;
	}
}
?>