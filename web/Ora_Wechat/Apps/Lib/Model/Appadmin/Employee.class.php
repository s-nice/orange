<?php
namespace Model\Appadmin;
use Model\WebService;
class Employee extends WebService
{
    /**
     * 企业员工信息 操作接口( 修改、查询)
     * @param Array $params 操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */
    public function doRequest($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R'://获取
                $webServiceRootUrl = C("API_ADMIN_COMPANY_EMPLOYEE_LIST");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
           /* case 'C'://创建
                $webServiceRootUrl = C("API_ORANGE_AGREEMENT_GET");
                break;*/
            /*    case 'D'://删除(暂时没有此功能)
                    // $webServiceRootUrl = C("");
                    break;*/
            case 'P'://修改 密码
                $webServiceRootUrl = C("API_ADMIN_COMPANY_EMPLOYEE_PASSWORD_EDIT"); //
                break;
            case 'U'://修改 状态
                $webServiceRootUrl = C("API_ADMIN_COMPANY_EMPLOYEE_STATUS_EDIT"); //
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 企业管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
 

    /**
     * 批量操作
     * @param array $params
     * @return array
     */
    public function doMany($params)
    {
        $webServiceRootUrl = C('API_BATCH');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        //         print_r($params);die;
        $params = array('object'=>json_encode($params));
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }


}