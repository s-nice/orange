<?php
namespace Model\Company;
/**
 * 企业注册
 */
use Model\WebService;

class CompanyLogin extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    //密码登录
    public function LoginPost($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/oauth/login';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //微信登录
    public function weiLoginPost($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/oauth/welogin';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //获取员工信息
    public function getEmpInfo($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getemp';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //绑定员工
    public function wxBind($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/oauth/webind';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }


    //修改密码
    public function upPwd($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/editpass';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}