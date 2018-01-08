<?php
namespace Model\Orange;
use Model\WebService;
class OrangeTemplate extends WebService
{
    /**
     * 会员卡模板
     * @param arr $params
     * @param string $crud
     * @return arr
     */
    public function cardTpl($params=array(), $crud='R'){
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R':
                $webServiceRootUrl = C('API_ORANGE_TPL_LIST');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $webServiceRootUrl = C('API_ORANGE_TPL_ADD');
                break;
            case 'D':
                $webServiceRootUrl = C('API_ORANGE_TPL_DEL');
                break;
            case 'U':
                $webServiceRootUrl = C('API_ORANGE_TPL_EDIT');
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 标签类型model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }
    
    /**
     * 用户非模板卡
     * @param arr $params
     * @param string $crud
     * @return arr
     */
    public function cardUserTpl($params=array(), $crud='R'){
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R':
                $webServiceRootUrl = C('API_ORANGE_USER_TPL_LIST');
                //$crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                //$webServiceRootUrl = C('API_ORANGE_TPL_ADD');
                break;
            case 'D':
                //$webServiceRootUrl = C('API_ORANGE_TPL_DEL');
                break;
            case 'U':
                $webServiceRootUrl = C('API_ORANGE_USER_TPL_EDIT');
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 标签类型model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
    
        return parseApi($response);
    }
}
?>