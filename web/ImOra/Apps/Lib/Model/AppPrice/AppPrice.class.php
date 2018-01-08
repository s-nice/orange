<?php
namespace Model\AppPrice;
use Model\WebService;
class AppPrice extends WebService{
	public function __construct()
	{
		parent::__construct();
	}

	//创建
	public function createData($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_CREATE_APPPRICE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	//获取APP价格列表
	public function getData($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_CREATE_APPPRICE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	//编辑
	//获取列表
	public function editData($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_EDIT_APPPRICE');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

	//获取会员赠送列表
	public function getGiveList($params){
		// web service 接口路径
		$webServiceRootUrl = C('API_VIP_GIVELIST');
		// 设置请求方法为 读取
		$crudMethod = parent::OC_HTTP_CRUD_R;
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$result = parseApi($response);
		return $result;
	}

}
?>
