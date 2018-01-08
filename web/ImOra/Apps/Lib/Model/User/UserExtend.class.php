<?php
namespace Model\User;
/*
 * admin 运营后台-个人用户管理扩展
 * @author wuzj
 * @date   2016年10月8日
 */
use Model\WebService;
class UserExtend extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 认证，待认证-列表
     * */
    public function getUserAuthList($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/contact/common/getcertification';

        $crudMethod = parent::OC_HTTP_CRUD_R;

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 认证和取消认证
     * @param $type :1认证，2取消认证
     * */
    public function userAuth($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/apistore/editcertification';

        $crudMethod = parent::OC_HTTP_CRUD_C;

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 获取用户名片图片信息
     * */
    public function getUserInfo($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_CONTACT_VCARD');

        $crudMethod = parent::OC_HTTP_CRUD_R;

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 获取硬件记录
     * */
    public function getHardwareRecord($params=array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/account/orange/bing';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

}