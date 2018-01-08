<?php
/**
 * Created by PhpStorm.
 * User: zhaoge
 * Date: 2017/4/25
 * Time: 20:03
 */
namespace Model\Orange;
use Model\WebService;


class OraUnitDetail extends WebService{
    /**
     * orange 单位详情 操作接口(查询，添加，编辑)
     * @param Array $params 单位详情操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */

    private function doRequest($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R'://获取
                $webServiceRootUrl = C("API_ORANGE_UNIT_DETAIL_GET");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://创建
                $webServiceRootUrl = C("API_ORANGE_UNIT_DETAIL_ADD");
                break;
            case 'U'://更新
                $webServiceRootUrl = C("API_ORANGE_UNIT_DETAIL_EDIT");
                break;
            case 'D'://删除
                //no do
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' orange 单位详情管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    public function manageUnitDetail($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
    }



}
/*EOF*/
