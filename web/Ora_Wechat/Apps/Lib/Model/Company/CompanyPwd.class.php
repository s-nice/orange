<?php
/**
 * Created by PhpStorm.
 * User: mizhennan
 * Date: 2017/9/25
 * Time: 15:27
 */

namespace Model\Company;
use Model\WebService;

class CompanyPwd extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }
    //重置密码
    public function resetPassword($params=array())
    {
        $webServiceRootUrl = C('API_COMPANY_REG_RESETPWD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}