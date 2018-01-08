<?php
/*
 * 企业支付充值管理 相关接口
 * @author jiyl <jiyl@oradt.com>
 */
namespace Model\AccountBiz;
use Model\WebService;
class PayManage extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 获取账户余额
	 * @return number
	 */
	public function getTotalNum($params = array()){
		$AccountBiz = new AccountBiz();
		$info = $AccountBiz->bizAccount($params);
		$num = 0;
		if(isset($info['payfee'])) $num = $info['payfee'];
		return  $num;
	}
	/**
	 * 员工消费充值列表
	 * @param array $params 搜索条件
	 * @param number $PageNum 页码
	 * @param number $pageSize 每页展示记录数
	 * @return array
	 */
	public function getPayList($params = array()){
		// 发送http请求
		$response = $this->request(C('API_ACCOUNTBIZ_ORDER_RECHARGELOG'), parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 提交支付生成订单
	 */ 
	public function submitPay($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;
		//* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_ACCOUNTBIZ_ORDER_ADD'), $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	/**
	 * 判断充值操作是否成功
	 */
	public function isPaySucc($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_R;
		//* 解析http 请求
		// 发送http请求
		$response = $this->request(C('API_PAYORDER_LIST'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		
		return $response;
	}
}
?>