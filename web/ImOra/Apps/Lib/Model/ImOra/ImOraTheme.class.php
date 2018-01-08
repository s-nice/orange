<?php
namespace Model\ImOra;

use Model\WebService;

/**
 * theme管理model
 * @author wangzx
 *
 */
class ImOraTheme extends WebService
{

    /**
     * Get Theme list
     * @param
     * @return array
     */
    public function getThemeList($params){
        $webServiceRootUrl =   C('API_APP_THEME');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 添加主题
     * @param
     * @return array
     */
    public function addTheme ($params)
    {
        $webServiceRootUrl =   C('API_APP_THEME');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile( $params['url'],'url');//设置上传的文件
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;


    }
    /**
     * 删除主题
     * @param
     * @return array
     */
    public function delTheme($params){
        $webServiceRootUrl =   C('API_APP_THEME_DEL');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;


    }





}