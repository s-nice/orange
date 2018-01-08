<?php
namespace Model\Orange;
use Model\WebService;
//酒店门禁卡model
class HotelAccessCard extends WebService
{
    /**
     * 酒店门禁卡加密类型管理model(编辑、获取)
     * @param Array $params 操作参数
     * @return Array
     */
    public function manageEncryptionType($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)){
            case 'R':
                $webServiceRootUrl = C('API_GET_ENCRYPT');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $webServiceRootUrl = C('API_ADD_ENCRYPT');
                break;
            case 'U':
                $webServiceRootUrl = C('API_EDIT_ENCRYPT');
                break;
            case 'D':
                $webServiceRootUrl = C('API_DEL_ENCRYPT');
                break;

            default:
                trace(' 门禁卡加密类型管理Model方法调用错误 ' . var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 酒店门禁卡图集model(编辑、获取，添加)
     * @param Array $params 操作参数
     * @return Array
     */
    public function manageImg($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)){
            case 'R':
                $webServiceRootUrl = C('API_GET_HOTEL_IMG');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $webServiceRootUrl = C('API_ADD_HOTEL_IMG');
                $this->setUploadFile( $params['resource'],'resource');//设置上传的文件
                break;
            case 'U':
                $webServiceRootUrl = C('API_EDIT_HOTEL_IMG');
                if(isset($params['resource'])){
                    $this->setUploadFile( $params['resource'],'resource');//设置上传的文件
                }
                break;
        /*    case 'D':
                $webServiceRootUrl = C('API_DEL_HOTEL_IMG');
                break;*/
            default:
                trace(' 门禁卡加密类型管理Model方法调用错误 ' . var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 酒店管理model(编辑、获取)
     * @param Array $params 操作参数
     * @return Array
     */
    public function manageHotel($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch (strtoupper($crud)){
            case 'R':
                $webServiceRootUrl = C('API_GET_HOTEL');
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                $webServiceRootUrl = C('API_ADD_HOTEL');
                break;
            case 'U':
                $webServiceRootUrl = C('API_EDIT_HOTEL');
                break;
            case 'D':
                $webServiceRootUrl = C('API_DEL_HOTEL');
                break;

            default:
                trace(' 酒店管理Model方法调用错误 ' . var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    /**
     * 酒店管理导入
     * @param Array $params 操作参数
     * @return Array
     */
    public  function importHotel($params){
        $webServiceRootUrl = C('API_IMPORT_HOTEL');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}

/* EOF */