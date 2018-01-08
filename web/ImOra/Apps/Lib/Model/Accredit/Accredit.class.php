<?php
namespace Model\Accredit;

/**
 * 账号授权model
 */
use Model\WebService;
class Accredit extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取授权数
     * @return array
     * */
    public function getAccredit()
    {
        return 666;
        // web service path
        $webServiceRootUrl =   C('API_ACCREDIT');
        $crudMethod = parent::OC_HTTP_CRUD_R;

        return $this->callAndParseApi($webServiceRootUrl, $crudMethod);
    }
}