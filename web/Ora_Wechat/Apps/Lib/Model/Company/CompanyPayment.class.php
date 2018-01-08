<?php
namespace Model\Company;
/**
 * 企业基本信息、修改企业密码等
 */
use Model\WebService;

class CompanyPayment extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }
    //获取套餐基本信息
    public function suitemeta($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/suitemeta';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    //企业套餐购买接口
    public function purchasesuite($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/purchasesuite';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    //企业套餐续期接口
    public function renewsuite($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/renewsuite';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    //新增员工接口
    public function addemployeesuite($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/addemployeesuite';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    //购买、新增、续费订单再次支付接口
    public function getsuiteorder($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/getsuiteorder';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    //企业套餐订单列表接口
    public function getorderlist($params)
    {
        $webServiceRootUrl = 'http://192.168.30.191:9996/wxbiz/payment/getorderlist';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}