<?php
namespace Model\Customer;
/*
 * admin 企业-客户-员工客户
 * @author wuzj
 * @date   2016年11月28日
 */
use Model\WebService;
class Customer extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    * 员工客户 员工列表
    * @param array $params
    * @param array $crud（c、u、r、d：增改查删）
    * @return array
    * */
    public function customerModel($params = array(),$crud = 'r'){
        // web service path API_ACCOUNTBIZ_EMPLOYEE_GET
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/add';
        switch($crud){
            case 'c':
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/add';
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'u':
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/edit';
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'd':
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/edit';
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            default :
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/get';
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    
    /**
     * 获取员工信息 FOR 生成员工名片
     * @param arr $params
     * @return arr
     */
    public function getEmpForEmpCard($params=array()){
        $webServiceRootUrl = C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/getemp';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取企业名片模板 FOR 生成员工名片
     * @param arr $params
     * @return arr
     */
    public function getVcardTempForEmpCard($params=array()){
        $webServiceRootUrl = C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/getvcardtemp';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }
    
    /**
     * 添加员工名片 FOR 生成员工名片
     * @param arr $params
     * @return arr
     */
    public function addPictureForEmpCard($params=array()){
        $webServiceRootUrl = C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/addpictrue';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        
        !empty($params['picture'])  && $this->setUploadFile($params['picture'], 'picture');
        !empty($params['picturea']) && $this->setUploadFile($params['picturea'], 'picturea');
        !empty($params['pictureb']) && $this->setUploadFile($params['pictureb'], 'pictureb');
        
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }
    
    /**
     * 获取员工的客户名片列表（客户共享名片接口）
     *
     */
    public function getCustomerListM($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
     * 数据分配 员工客户名片
     * @params vcardid 客户名片id
     * @params fromuid 员工列表选择的员工id 多个用‘，’号隔开
     * @params clientids 分配数据弹框选择的员工id 多个用‘，’号隔开
     * */
    public function customerDistributionM($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $crudMethod = parent::OC_HTTP_CRUD_U;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }








}