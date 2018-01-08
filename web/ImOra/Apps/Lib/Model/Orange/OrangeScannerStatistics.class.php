<?php
namespace Model\Orange;
use Model\WebService;
class OrangeScannerStatistics extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 扫描仪管理 - 统计
     * */
    public function getDataM($params = array()){

        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/admin/scannerv2/statistics';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }



}
?>