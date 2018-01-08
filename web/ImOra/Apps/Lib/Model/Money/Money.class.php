<?php
namespace Model\Money;

/**
 * 账号金额处理model
 */
use Model\WebService;
class Money extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取余额
     * @return array
     * */
    public function getMoney()
    {
        return sprintf('%0.2f', 8888);
        // web service path
        $webServiceRootUrl =   C('API_MONEY');
        $crudMethod = parent::OC_HTTP_CRUD_R;

        return $this->callAndParseApi($webServiceRootUrl, $crudMethod);
    }
}