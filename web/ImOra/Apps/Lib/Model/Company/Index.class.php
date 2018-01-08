<?php
namespace Model\Company;
use Model\WebService;
class Index extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取企业平台首页统计数据
     * @param array $params
     * @return array
     */

    public function getIndexStatisticsData($params = array()){
        $webServiceRootUrl =   C('API_COMPANY_INDEX_DATA_STATISTICS');
        $crudMethod = parent::OC_HTTP_CRUD_R;

        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);


    }
}