<?php
/**
 * Created by PhpStorm.
 * User: zhaoge
 * Date: 2017/4/25
 * Time: 20:03
 */
namespace Model\Scanner;
use Model\WebService;


class  Scanner extends WebService{

    /**
     * 获取扫描仪设备列表 操作接口(查询)
     * @param array $params 操作参数
     * @return array
     */
    public function manageScannerList($params=array())//获取描仪列表
    {
        // 设置请求方法为 获取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C("API_SCANNER_LIST");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);

    }

    /**
     * 故障历史记录 操作接口(查询)
     * @param string $crud  API的crud操作请求
     * @return array
     */

    public function manageScannerErrList($params=array())//扫描仪故障历史记录
    {
        // 设置请求方法为 获取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C("API_SCANNER_ERR_LIST");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);

    }

    /**
     * 添加扫描仪设备 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function addScanner($params=array())//添加扫描仪
    { // 设置请求方法为 获取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_ADD");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 编辑扫描仪 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function editScanner($params=array())//编辑扫描仪
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_EDIT");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 扫描仪使用统计 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function statisScanner($params=array())//扫描仪使用统计
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_STATISTICS");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 获取扫描仪设备列表 操作接口(查询)
     * @param array $params 操作参数
     * @return array
     */
    public function useListScanner($params=array())//扫描仪使用列表
    {
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C("API_SCANNER2_USE_LIST");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 删除扫描仪设备 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function delScanner($params=array())//扫描仪使用列表
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_DEL");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }


    /**
     * 重启扫描仪设备 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function rebootScanner($params=array())//扫描仪使用列表
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_DEL");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 余额提醒获取手机号/流量/余额信息等 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function balance($params=array())
    {
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $webServiceRootUrl = C("API_SCANNER2_BALANCE");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 余额提醒设置提醒金额 操作接口
     * @param array $params 操作参数
     * @return array
     */
    public function setremindprice($params=array())
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $webServiceRootUrl = C("API_SCANNER2_SETREMINDPRICE");
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 添加获取删除余额提醒接收人 操作接口
     * @param array $params 操作参数
     * @param array $type 操作类型
     * @return array
     */
    public function Managereminduser($params=array(),$type='R')//扫描仪使用列表
    {
        $crudMethod = parent::OC_HTTP_CRUD_C;
        switch($type){
            case 'C'://创建
                $webServiceRootUrl = C("API_SCANNER2_ADDREMINDUSER");
                break;
            case 'D'://删除
                $webServiceRootUrl = C("API_SCANNER2_DELREMINDUSER");
                break;
            default://获取
                $crudMethod = parent::OC_HTTP_CRUD_R;
                $webServiceRootUrl = C("API_SCANNER2_GETREMINDUSER");
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }


}
/*EOF*/
