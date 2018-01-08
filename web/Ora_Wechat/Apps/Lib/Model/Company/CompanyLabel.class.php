<?php
namespace Model\Company;
/**
 * 企业注册
 */
use Model\WebService;

class CompanyLabel extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    //获取企业标签
    public function getlabels($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getbiztag';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //修改企业标签
    public function editLabel($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/editbiztag';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //新增企业标签
    public function addLabel($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/addbiztag';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //删除企业标签
    public function delLabel($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/wxbiz/admin/delbiztag';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}