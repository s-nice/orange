<?php
namespace Model\CompanyLogin;

use Model\WebService;
/**
 * 企业平台注册model
 * */
class Register extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取注册选择的行业列表
     *  @param array $params
     *  @return array
     */
    public function getCategoryList($params = array())
    {
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl =  C('API_INDUSTRY_GET');
        //* 解析http 请求
        $response = parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
        return $response;
    }

    /**
     *  企业注册功能
     *  @param array $params
     *  @return array
     */
    public function register($params = array())
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C('API_COM_REGISTER');
        //向API上传文件
        $this->setUploadFile($params['licenpath'], 'licenpath');
        $params['licentype']==1 && $this->setUploadFile($params['organpath'], 'organpath'); 
        $params['licentype']==1 && $this->setUploadFile($params['registpath'], 'registpath');
        $response = parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
        return $response;
    }
    
    /**
     *  获取企业基本信息
     *  @param array $params
     *  @return array
     */
    public function getComInfo($params = array())
    {
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$webServiceRootUrl = C('API_ACCOUNTBIZ_COMPANY_GETBIZ');
    	$response = parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
    	return $response;
    }
    
    /**
     *  更新企业基本信息
     *  @param array $params
     *  @return array
     */
    public function updateComInfo($params = array())
    {
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$webServiceRootUrl = C('API_ACCOUNTBIZ_COMPANY_EDIT');
    	//向API上传文件
    	$this->setUploadFile($params['licenpath'], 'licenpath');
    	$params['licentype']==1 && $this->setUploadFile($params['organpath'], 'organpath');
    	$params['licentype']==1 && $this->setUploadFile($params['registpath'], 'registpath');
    	//企业logo
    	if($params['logo']){
    		if(strtolower(substr($params['logo'], 0,4)) == 'http'){
    			$this->httpUploadFiles['logo'] = $params['logo'];
    		}else{
    			$this->setUploadFile( WEB_ROOT_DIR.ltrim($params['logo'],'/'), 'logo');
    		}
    	}
    	$response = parseApi($this->request($webServiceRootUrl, $crudMethod, $params));
    	return $response;
    }

}