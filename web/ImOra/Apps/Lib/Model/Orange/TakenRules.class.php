<?php
namespace Model\Orange;
use Model\WebService;
class TakenRules extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取提取规则
     * @param array $params
     * @return array $response
     */
    public function getTakenRules($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/gettakenrules';
        // 发送http请求
        $response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_R, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 添加提取规则
     * @param array $params
     * @return array $response
     */
    public function addTakenRules($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/addtakenrules';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    /**
     * 修改提取规则 
     * @param array $params
     * @return array $response
     */
    public function editTakenRules($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/edittakenrules';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    /**
     * 删除提取规则
     * @param array $params
     * @return array $response
     */
    public function delTakenRules($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/deltakenrules';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
}
?>