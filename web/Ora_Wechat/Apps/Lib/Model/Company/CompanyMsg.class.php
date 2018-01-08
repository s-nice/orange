<?php
namespace Model\Company;
/**
 * 企业注册
 */
use Model\WebService;

class CompanyMsg extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }


    //获取系统消息
    public function getMsg($params=array()){
        $webServiceRootUrl = C('API_COMPANY_GET_MSG');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response,true);
    }

    //获取系统消息
    public function setMsg($params=array()){
        $webServiceRootUrl = C('API_COMPANY_SET_MSG');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return json_decode($response,true);
    }

    //获取系统消息
    public function delMsg($params=array()){
        $webServiceRootUrl = C('API_COMPANY_DEL_MSG');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return json_decode($response,true);
    }
}