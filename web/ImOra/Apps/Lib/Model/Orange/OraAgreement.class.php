<?php
namespace Model\Orange;
use Model\WebService;
class OraAgreement extends WebService
{
    /**
     * orange 协议管理 操作接口( 修改、查询)
     * @param Array $params 协议管理操作参数
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
                $webServiceRootUrl = C("API_ORANGE_AGREEMENT_GET");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
           case 'C'://创建
                $webServiceRootUrl = C("API_ORANGE_AGREEMENT_GET");
                break;
        /*    case 'D'://删除(暂时没有此功能)
                // $webServiceRootUrl = C("");
                break;*/
            case 'U'://修改
                $webServiceRootUrl = C("API_ORANGE_AGREEMENT_EDIT");
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 协议管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    public function manageAgreement($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
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