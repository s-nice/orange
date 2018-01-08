<?php
namespace Model\CardShare;

use Model\WebService;

/**
 * 扩展名片共享model
 * User: zhaoge
 * Date: 2016/7/11
 * Time: 9:56
 */
class CardShare extends WebService
{
    /**
     * 获取共享列表
     * Get Share list
     * @param
     * @return array
     */
    public function getShareList($params)
    {
        $webServiceRootUrl =   C('API_CARD_SHARE_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取被共享的账号信息
     * Get ShareAccountList
     * @param
     * @return array
     */
    public function  getShareAccount($params)
    {
        $webServiceRootUrl =   C('API_CARD_SHARE_SHAREDACCOUNT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }

    /**
     * 获取共享名片列表
     * Get ShareCard list
     * @param
     * @return array
     */
    public function  getShareCardList($params)
    {
        $webServiceRootUrl =   C('API_CARD_SHARE_CARDLIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }

    /**
     * 新建共享
     * add share
     * @param
     * @return array
     */
    public function addShare($params)
    {
        $webServiceRootUrl =   C('API_CARD_SHARE_ADD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }
    /**
     * 获取共享的名片数量
     * Get ShareCard number
     * @param
     * @return array
     */
    public function getShareCardNumber($params)
    {
        $webServiceRootUrl =   C('API_x_xx');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }

    /**
     * 获取账号信息
     * Get Account information
     * @param
     * @return array
     */
    public function getAccountInfo($params)
    {
        $webServiceRootUrl =   C('API_x_xx');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }
    /**
     *编辑共享状态
     * Edit share status
     * @param
     * @return array
     */

    public  function editShare($params){
        $webServiceRootUrl =   C('API_CARD_SHARE_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }

    /**
     *删除共享（待共享）
     * del share
     * @param
     * @return array
     */

    public  function delShare($params){
        $webServiceRootUrl =   C('API_CARD_SHARE_DEL');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;

    }



}

/* EOF */