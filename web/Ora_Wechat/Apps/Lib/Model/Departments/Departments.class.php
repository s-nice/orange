<?php
namespace Model\Departments;
/*
 * admin 2b 部门管理
 * @author wuzj
 * @date   2017年9月20日10:28:24
 */
use Model\WebService;
class Departments extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 部门列表
     * @param array|array $params 接口参数
     * @return array
     */
    public function getDepartmentListM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/getdepart';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 添加部门
     * @param array|array $params 接口参数
     * @return array
     */
    public function addDepartmentM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/depart';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    /*
    * 编辑部门
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function editDepartmentM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/edpart';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
    * 删除部门
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function delDepartmentM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/delpart';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
    * 获取员工
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function getStaffM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/getemp';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
    * 添加员工
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function addStaffM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/addemp';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
    * 修改员工
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function editStaffM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/editemp';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    public function delStaffM($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/oauth/delemployee';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    public function getRecovers($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/bizcard/getrecyclecard';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    public function revokeRecovers($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/bizcard/updatecardrecycle';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    public function setPowerM($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/edit';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    public function getBizInfo($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/getbiz';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    public function importStaffM($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/employee/addemps';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
    *
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function ddd($params = array(),$crud = 'r'){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/wxbiz/admin/edpart';
        switch($crud){
            case 'c':
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'u':
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            case 'd':
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            default :
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

}