<?php
/*
 * 推广 相关接口
 * @author panyy <panyy@oradt.com>
 * @date   2016-01-19
 */
namespace Model\Push;
use Model\WebService;
class Push extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 获取推广行业
	 *  @param array $params
	 *  @return array
	 */
	public function getCategory($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_R;
		//* 解析http 请求
// 		$response = parseApi($this->request(C('API_POPULAR_CATEGORY'), $crudMethod, $params));
		$response = parseApi($this->request(C('API_INDUSTRY_GET'), $crudMethod, $params));
		
		
		return $response;
	}

	/**
	 * 根据行业id获取名片
	 *  @param array $params
	 *  @return array
	 *
	 */
	public function getCardByCategoryid($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_R;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_POPULAR_CARD'), $crudMethod, $params));
	    return $response;
	}

	/**
	 * 根据行业id推送
	 *  @param array $params
	 *  @return array
	 */
	public function pushByCategoryId($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_CATE_POPULAR'), $crudMethod,$params));
	    return $response;
	}

	/**
	 * 根据uuid推送
	 *  @param array $params
	 *  @return array
	 */
	public function pushByuuid($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_UUID_POPULAR'), $crudMethod, $params));
	    return $response;
	}


	/**
	 * 根据uuid删除
	 *  @param array $params
	 *  @return array
	 */
	public function deleteByuuid($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_IGNORE_POPULAR'), $crudMethod, $params));
	    return $response;
	}

	/**
	 * 批量操作
	 * @param array $params
	 * @return array
	 */
	public function doMany($params)
	{
	    $webServiceRootUrl = C('API_BATCH');
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //         print_r($params);die;
	    $params = array('object'=>json_encode($params));
	    $response = $this->request($webServiceRootUrl, $crudMethod, $params);
	    $response = parseApi($response);
	    return $response;
	}


}
?>
