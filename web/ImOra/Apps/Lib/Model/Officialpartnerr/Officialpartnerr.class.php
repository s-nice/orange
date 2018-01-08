<?php
namespace Model\Officialpartnerr;
use Model\WebService;
class Officialpartnerr extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 获取推广行业
	 * @param array $params
	 * @return array
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
	 * 获取合作商列表
	 * @param array $params
	 * @return array
	 */
	public function getOfficialpartnerList($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_R;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_GETBIZ'), $crudMethod, $params));
	    return $response;
	}

	/**
	 * 获取合作商信息
	 * @param array $params
	 * @return array
	 */
	public function getCompanyInfo($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_R;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_GETBIZ'), $crudMethod, $params));
	    return $response;
	}



	/**
	 * 修改合作商
	  * @param array $params
	 * @return array
	 */
	public function officialpartnerEdit($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_C;;
	    //* 解析http 请求
		//向API上传文件
		if($params['licenpath']){
			if(strtolower(substr($params['licenpath'], 0,4)) == 'http'){
				$this->httpUploadFiles['licenpath'] = $params['licenpath'];
			}else{
				$this->setUploadFile($params['licenpath'], 'licenpath');
			}
		}
		if($params['licenseType']==1){
			if($params['organpath']){
				if(strtolower(substr($params['organpath'], 0,4)) == 'http'){
					$this->httpUploadFiles['organpath'] = $params['licenpath'];
				}else{
					$this->setUploadFile($params['organpath'], 'organpath');
				}
			}
			if($params['registpath']){
				 if(strtolower(substr($params['registpath'], 0,4)) == 'http'){
				 	$this->httpUploadFiles['registpath'] = $params['licenpath'];
				 }else{
				 	$this->setUploadFile($params['registpath'], 'registpath');
				 }
			}
		}else{
			unset($params['organpath'], $params['registpath']);
		}
	    $response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_EDIT'), $crudMethod,$params));
	    return $response;
	}
	
	/**
	 * 添加合作商
	 * @param array $params
	 * @return array
	 */
	public function officialpartnerAdd($params = array())
	{
		$crudMethod =  parent::OC_HTTP_CRUD_C;;
		//* 解析http 请求
		$response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_ADD'), $crudMethod,$params));
		return $response;
	}




	/**
	 * 根据id删除
 	 * @param array $params
	 * @return arrayn
	 */
	public function delOfficialpartner($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_active'), $crudMethod, $params));
	    return $response;
	}


	/**
	 * 更改状态
	 * @param array $params
	 * @return array
	 */
	public function changeStatusByid($params = array())
	{
	    $crudMethod = parent::OC_HTTP_CRUD_C;
	    //* 解析http 请求
	    $response = parseApi($this->request(C('API_ACCOUNTBIZ_COMPANY_active'), $crudMethod, $params));
	    return $response;
	}

	/**
	 * 获取已扫名片详情列表
	 */
	public function getScanVcards($params=array()){
		$crudMethod = parent::OC_HTTP_CRUD_R;
		//* 解析http 请求
// 		$response = parseApi($this->request(C('API_POPULAR_CATEGORY'), $crudMethod, $params));
		$response = parseApi($this->request(C('API_INDUSTRY_GET'), $crudMethod, $params));
		
		return array('data'=>array('numfound'=>30,
				'list' => array('id'=>1,'account'=>1271886001,'name'=>'张三','account'=>1271886001)
		));
	}
}
