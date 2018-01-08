<?php
namespace Model\Staff;
/*
 * admin 企业-员工邀请
 * @author wuzj
 * @date   2016年9月27日
 */
use Model\WebService;
class Staff extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    * 员工邀请
    * @param array $params
    * @param array $crud（c、u、r、d：增改查删）
    * @return array
    * */
    public function staffModel($params = array(),$crud = 'r'){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/add';
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
     * 员工导入
     *
     */
    public function importEmployee($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_EMPLOYEE_IMPORT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 员工邀请
    * @param array|array $params 接口参数
    * @return array
    * */
    /*public function actionSensitiveM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/add';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }*/

    /**
     * 获取客户共享列表
     *
     */
    public function getShareList($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/depart';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 客户共享 添加
     *
     */
    public function addShareM($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/group';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 客户共享 编辑
     *
     */
    public function editShareM($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/editgroup';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 客户共享 组成员信息获取
     *
     */
    public function getShareMemberM($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/member';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 客户共享 删除
     *
     */
    public function delShareM($params=array()){
        // web service path
        //$webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/bizcard/pool';
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/accountbiz/employee/delgroup';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 获取部门
    * @param array|array $params 接口参数
    * @return array
    * */
    public function getDepartmentList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_CUSTOMER_USERGROUP');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 获取职位
    * @param array|array $params 接口参数
    * @return array
    * */
    public function getTitleList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_EMPLOYEE_GET_TITLE');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 获取授权列表
    * @param array|array $params 接口参数
    * @return array
    * */
    public function getAuthorList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_ORDER_AUTHORLIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }


    /*
    * 获取消费规则
    * @param array|array $params 接口参数
    * @return array
    * */
    public function getConsumeList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_CONSUME_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 新增消费规则
    * @param array|array $params 接口参数
    * @return array
    * */
    public function createConsume($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_CONSUME_ADD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 编辑删除消费规则
    * @param array|array $params 接口参数
    * @return array
    * */
    public function editConsume($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_CONSUME_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

}