<?php
namespace Model\Appadmin;
use Model\WebService;
class AdminAccount extends WebService
{
    /**
     * 管理员账号管理 操作接口( 修改、查询)
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
                $webServiceRootUrl = C("API_ADMIN_GET");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
             case 'C'://创建
                 $webServiceRootUrl = C("API_ADMIN_ADD");
                 break;
               case 'D'://删除
                     $webServiceRootUrl = C("API_ADMIN_DEL");
                    break;
            case 'U'://修改
                $webServiceRootUrl = C("API_ADMIN_EDIT");
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 管理员账号管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    public function manageAdminAccount($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
    }




}