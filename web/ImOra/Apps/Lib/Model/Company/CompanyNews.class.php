<?php
namespace Model\Company;
/**
 * 企业动态model
 */
use Model\WebService;
use Zend\Validator\Date;

class CompanyNews extends WebService
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
    public function doRequest($param=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R':
                $webServiceRootUrl = C('API_COMPANY_NEWS');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $webServiceRootUrl = C('API_COMPANY_NEWS');
                break;
            case 'D':
            case 'U':
                $webServiceRootUrl = C('API_COMPANY_EDIT_NEWS');
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 企业动态model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $param);

        return parseApi($response);
    }

    public function manageCompanyNews($params=array(), $crud='R')
    {
        return $this->doRequest($params,$crud);

    }


}