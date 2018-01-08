<?php
namespace Model\RegionManage;

use Model\WebService;

class RegionManage  extends WebService
{
    /**
     * 城市操作接口(添加、修改、删除、查询)
     * @param Array $params 地区操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */
    public function doRequest($params=array(), $crud='R'){
        $crudMethod = parent::OC_HTTP_CRUD_R;

        switch ($crud){
            case 'R':
                $webServiceRootUrl =C( 'API_GET_CITY_LIST');
                break;
            case 'C':
                $webServiceRootUrl = ''; //接口还没定义
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'D':
                $webServiceRootUrl = '';//接口还没定义
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'U':
                $webServiceRootUrl = '';//接口还没定义
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 地区管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }


    public function manageCity($params=array(), $crud='R')
    {
        $params['rows']= isset($params['rows']) ? $params['rows'] : PHP_INT_MAX;
        return $this->doRequest($params, $crud);
    }

    /**
     * 获取省份列表
     * @param Array $params 省操作参数
     * */
    public function getProviceList($params=array()){
        $params['rows']= isset($params['rows']) ? $params['rows'] : PHP_INT_MAX;
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C('API_GET_PROVINCE_LIST');
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);

    }

}