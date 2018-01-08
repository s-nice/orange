<?php
namespace Model\Company;
/**
 * 企业注册
 */
use Model\WebService;

class CompanyReg extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    //发送验证码
    public function sendSms($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/verification/sms';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //验证验证码
    public function checkSms($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/verification/sms';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //注册提交
    public function regPost($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/regist';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //查询手机号是否已注册
    public function getEmByMobile($params=array()){
        $webServiceRootUrl = C('API_EMP_CHECK_MOBILE');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        //return array('status'=>0,'id'=>2);
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return json_decode($response,true);

    }

    //查询公司名称是否已注册
    public function getCompanyByName($params=array()){
        $webServiceRootUrl = C('API_COMPANY_CHECK_NAME');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return json_decode($response,true);
    }
}