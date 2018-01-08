<?php
namespace Model\EquityCard;

use Model\WebService;

class EquityCard extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 权益卡分类管理model(编辑、获取，删除，添加，置顶)
     * @param Array $params 协议管理操作参数
     * @return Array
     */
    public function manageType($params = array(), $crud = 'R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)) {
            case 'R'://获取
                $webServiceRootUrl = C('API_ORANGE_STORE_TYPE_GET');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://添加
                $webServiceRootUrl = C('API_ORANGE_STORE_TYPE_ADD');
                break;
            case 'U'://编辑
                $webServiceRootUrl = C('API_ORANGE_STORE_TYPE_EDIT');
                break;
            case 'D'://删除
                $webServiceRootUrl = C('API_ORANGE_STORE_TYPE_DEL');
                break;
            case 'TOP'://置顶操作
                $webServiceRootUrl = C('API_ORANGE_STORE_TOP');
                break;
            default:
                trace(' 协议卡分类管理Model方法  调用错误 ' . var_export(func_get_args(), true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 权益卡城市管理model(编辑、获取，删除，添加，置顶)
     * @param Array $params 协议管理操作参数
     * @return Array
     */
    public function manageCity($params = array(), $crud = 'R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)) {
            case 'R'://获取
                $webServiceRootUrl = C('API_ORANGE_STORE_CITY_GET');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://添加
                $webServiceRootUrl = C('API_ORANGE_STORE_CITY_ADD');
                break;
            case 'U'://编辑
                $webServiceRootUrl = C('API_ORANGE_STORE_CITY_EDIT');
                break;
            case 'D'://删除
                $webServiceRootUrl = C('API_ORANGE_STORE_CITY_DEL');
                break;
            case 'TOP'://置顶操作
                $webServiceRootUrl = C('API_ORANGE_STORE_TOP');
                break;
            default:
                trace(' 协议卡城市管理Model方法  调用错误 ' . var_export(func_get_args(), true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 权益卡商户权益管理model(编辑、获取，删除，添加，置顶)
     * @param Array $params 协议管理操作参数
     * @return Array
     */
    public function manageStore($params = array(), $crud = 'R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)) {
            case 'R'://获取
                $webServiceRootUrl = C('API_ORANGE_UNIT_DETAIL_GET');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://添加
                $webServiceRootUrl = C('API_ORANGE_UNIT_DETAIL_ADD');
                break;
            case 'U'://编辑
                $webServiceRootUrl = C('API_ORANGE_UNIT_DETAIL_EDIT');
                break;
            case 'D'://删除
                $webServiceRootUrl = C('API_ORANGE_UNIT_DETAIL_DEL');
                break;
            default:
                trace(' 商户权益管理Model方法  调用错误 ' . var_export(func_get_args(), true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 	//获取商户详情分类下的城市中单位的排序
     * */

    public function showSort($params){
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C('API_ORANGE_STORE_SHOW_SORT');
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}
/* EOF */