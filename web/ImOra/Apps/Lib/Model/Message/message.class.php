<?php
/*
 *客服消息接口
* @author panyy
* @date   2016
*/
namespace Model\Message;
use Model\WebService;
class message extends WebService{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 获取消息
     */
    public function getMessage($params = array(),$crudMethod = 'R')
    {
        switch ($crudMethod){
            case 'R':
                // 设置请求方法为 删除
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C':
                // 设置请求方法为 新建
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'D':
                // 设置请求方法为 删除
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            case 'U':
                // 设置请求方法为 新建
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            default:
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }
        //* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_ACCOUNT'), $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

}