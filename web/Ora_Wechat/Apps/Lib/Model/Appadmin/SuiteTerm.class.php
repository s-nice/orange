<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-11-14
 * Time: 16:33
 */

namespace Model\Appadmin;


use Model\WebService;

class SuiteTerm extends WebService {

    /**
     * 企业套餐数据 操作接口( 修改、查询)
     *
     * @param Array $params 操作参数
     * @param string $crud API的crud操作请求
     * @return Array
     */
    public function doRequest($params = array(), $crud = 'R'){
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud       = strtoupper($crud);
        switch($crud){
            case 'R'://获取
                $webServiceRootUrl = C("API_BIZSUITE_GET");
                $crudMethod        = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://创建
                $webServiceRootUrl = C("API_BIZSUITE_ADD");
                break;
            case 'D'://删除(暂时没有此功能)
                $webServiceRootUrl = C("API_BIZSUITE_DEL");
                break;
            case 'U'://修改企业状态
                $webServiceRootUrl = C("API_BIZSUITE_SET"); //
                break;
            default:
                trace('File:' . __FILE__ . ' LINE:' . __LINE__ . "\r\n" . ' 套餐管理model传参错误 ' . var_export(func_get_args(), true));

                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }
}