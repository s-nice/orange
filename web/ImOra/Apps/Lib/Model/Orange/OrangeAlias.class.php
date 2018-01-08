<?php
namespace Model\Orange;
use Model\WebService;
class OrangeAlias extends WebService
{
    /**
     * orange 公司别名维护 操作接口(添加 修改、查询)
     * @param Array $params 公司别名维护操作参数
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
                $webServiceRootUrl = C("API_ORANGE_ALIAS_GET");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://创建
                $webServiceRootUrl = C("API_ORANGE_ALIAS_ADD");
                break;
            case 'D'://删除(暂时没有此功能)
               // $webServiceRootUrl = C("");
                break;
            case 'U'://修改
                $webServiceRootUrl = C("API_ORANGE_ALIAS_EDIT");
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 公司别名维护model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    public function manageAlias($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
    }

}