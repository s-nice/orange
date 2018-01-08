<?php
namespace Model\Company;
/**
 * 企业名片模板
 */
use Model\WebService;

class CompanyTemplate extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 企业动态操作接口(添加、修改、删除、查询)
     * @param Array $params 行业操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */
    public function doRequest($params = array(), $crud='R'){
        $webServiceRootUrl = C('API_VCARD_TEMPLATE');
        $crud = strtoupper($crud);
        
        switch ($crud){
            case 'R':
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $crudMethod = parent::OC_HTTP_CRUD_C;
                if (!empty($params['cardres'])){
                    $this->setUploadFile($params['cardres'], 'cardres');
                    unset($params['cardres']);
                }
                if (!empty($params['picture'])){
                    $this->setUploadFile($params['picture'], 'picture');
                    unset($params['picture']);
                }
                if (!empty($params['picturea'])){
                    $this->setUploadFile($params['picturea'], 'picturea');
                    unset($params['picturea']);
                }
                break;
            case 'D':
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            case 'U':
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 企业名片模板model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }
}