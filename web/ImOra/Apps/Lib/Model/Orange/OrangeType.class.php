<?php
namespace Model\Orange;
use Model\WebService;
class OrangeType extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 卡类型model
     * */
    public function cardTypeM($params = array(),$crud = 'r'){
        // web service path
        switch($crud){
            case 'u':
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/editcardtype';
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            default :
                // web service path
                $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getcardtype';
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 发卡单位属性添加接口 /admin/orange/importattr
     * id,jsonstring
     * */
    public function createIssuerM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/importattr';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 获取发卡单位接口 /admin/orange/getcardlssuer
     * id,jsonstring
     * */
    public function getIssuerM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getcardlssuer';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /**
     * 卡类型模板model
     * @param arr $params
     * @param str $crud
     * @return arr
     */
    public function cardTemplate($params = array()){
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/editcardtypetemp';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }
    
    /*
     * 发卡单位接口
     * */
    public function sendCardBankM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getcardlssuer';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 卡属性接口(等待开发接口）
     * */
    public function cardPropM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/orange/getcardattribute';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }



}
?>