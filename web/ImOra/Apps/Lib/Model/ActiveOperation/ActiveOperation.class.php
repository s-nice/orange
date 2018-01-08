<?php
/*
 * 普通账号 相关接口
 * @author zhangpeng <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\ActiveOperation;
use Model\WebService;
class ActiveOperation extends WebService{
	public function __construct()
	{
		parent::__construct();
	}

	//获取活动列表
	public function getOperation($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_CREATE_OPERATION');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		/*echo '<pre>';
		print_r($params);die;*/
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	//新增活动
	public function createOperation($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_CREATE_OPERATION');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		//print_r($params);die;
		if(isset($params['image']) && !empty($params['image'])){
            $this->setUploadFile($params['image'], 'image');
        }
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//print_r($response);
		$result = parseApi($response);
		return $result;
	}

	//更新活动
	public function updateOperation($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_UPDATE_OPERATION');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		if(isset($params['image']) && !empty($params['image'])){
            $this->setUploadFile($params['image'], 'image');
        }
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}
	
	/**
	 * 获取兑换码列表
	 * @param
	 * @return array
	 */
	public function getRedeemCode($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_GET_REDEEMCODE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 新增兑换码
	 * @param
	 * @return array
	 */
	public function createRedeemCode($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_CREATE_REDEEMCODE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//print_r($response);die;
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 追加兑换码
	 * @param
	 * @return array
	 */
	public function appendRedeemCode($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_APPEND_REDEEMCODE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//print_r($response);die;
		$result = parseApi($response);
		return $result;
	}
	

	/**
	 * 获取兑换码消费列表
	 * @param
	 * @return array
	 */
	public function getUseList($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_REDEEMCODE_USELIST');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	//任务列表
	public function getTaskList($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_TASK_LIST');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		/*echo '<pre>';
		print_r($params);die;*/
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		/*echo '<pre>';
		print_r($response);die;*/
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 新增任务
	 * @param
	 * @return array
	 */
	public function createTask($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_TASK_ADD');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 编辑任务
	 * @param
	 * @return array
	 */
	public function editTask($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_TASK_EDIT');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//print_r($response);die;
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 删除任务
	 * @param
	 * @return array
	 */
	public function delTask($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_TASK_DEL');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		//print_r($params);die;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 达标用户
	 * @param
	 * @return array
	 */
	public function getStandardUser($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_TASK_STANDARD_USER');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 设置请求参数
		//$params = array();
		// 发送http请求
		/*echo '<pre>';
		print_r($params);die;*/
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	/**
	 * 达标用户
	 * @param
	 * @return array
	 */
	public function invalidRedeemcode($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_INVALID_REDEEMCODE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}
}
?>