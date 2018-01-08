<?php
namespace Model\Orange;
use Model\WebService;
class ContentType extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取内容类型
     * @param array $params
     * @return array $response
     */
    public function getContentType($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getcontenttype';
        // 发送http请求
        $response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_R, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    /**
     * 删除内容类型|提取规则
     * @param array $params
     * @return array $response
     */
    public function delContentType($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/delcontenttype';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    /**
     * 添加内容类型 --- 只适用于添加内容管理页面
     * @param array $params
     * @return array $response
     */
    public function addContentType($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/addcontenttype';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    /**
     * 修改内容类型|提取规则 
     * @param array $params
     * @return array $response
     */
    public function editContentType($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/editcontenttype';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    /**
     * 提取规则是否被使用
     * @param array $params
     * @return array $response
     */
    public function infoStatus($params = array()){
    	// web service path
    	$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getusedextractinfo';
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_R, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
}
?>