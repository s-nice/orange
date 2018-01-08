<?php
namespace Model\OraPay;
use Model\WebService;
class OraPay extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * orapay 创建
     * */
    public function oraPayM($params = array(),$crud = 'r'){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/apistore/orapaybank';
        switch($crud){
            case 'c':
                $crudMethod = parent::OC_HTTP_CRUD_C;
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

    /*
     * 编辑orapay
     * */
    public function oraPayEdit($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/apistore/editorapaybank';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /*
     * 删除orapay
     * */
    public function oraPayDel($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/apistore/delorapaybank';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }



}
?>