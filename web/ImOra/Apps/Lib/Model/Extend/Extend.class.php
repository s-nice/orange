<?php
namespace Model\Extend;
/*
 * admin 扩展 - 敏感词、已经反馈
 * @author wuzj
 * @date   2015-12-23
 */
use Model\WebService;
class Extend extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 敏感词列表
     * @param array|array $params 接口参数
     * @return array
     */
    public function getSensitiveList($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/common/apistore/illegalword';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
    * 敏感词 - 添加，删除，修改(action:add,update,delete)
    * @param array|array $params 接口参数
    * @return array
    * */
    public function actionSensitiveM($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/common/apistore/illegalword';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 常见问题，新手帮助 
     * @param array $params
     * @return array
     */
    public function faq($params = array(),$crud='r'){
        // web service path
        $webServiceRootUrl = C('API_FAQ_QUESTION');
        switch($crud){
            case 'c':
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'u':
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            case 'd':
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            default :
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }
        
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    /*
    * 意见反馈操作
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function actionFeedbackM($params = array(),$crud = 'r'){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/feedback';
        switch($crud){
            case 'c':
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'u':
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            case 'd':
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            default :
                    $crudMethod = parent::OC_HTTP_CRUD_R;
        }

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

}