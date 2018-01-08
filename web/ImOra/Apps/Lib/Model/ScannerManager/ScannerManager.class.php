<?php
namespace Model\Scannermanager;
/*
 * admin 扫描仪管理
 * @author wuzj
 * @date   2016年7月5日11:00:09
 */
use Model\WebService;
class ScannerManager extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 扫描仪管理
     * @param array|array $params 接口参数
     * @return array
     */
    public function getList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 扫描仪管理-导入
     * @param array|array $params 接口参数
     * @return array
     */
    public function getImport($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_IMPORT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    /**
     * 扫描仪使用记录
     * @param array|array $params 接口参数
     * @return array
     */
    public function getLogList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_RECORD');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        /*echo '<pre>';
        print_r($response);die;*/
        return $response;
    }
    

    //添加扫描仪
    public function createScanner($params = array()){
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_ADD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    //扫描仪删除
    public function deleteScanner($params = array()){
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_DEL');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    //更新扫描仪
    public function updateScanner($params = array()){
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        // print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    //获取企业列表
    public function getPartner($params = array()){
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_COMPANY_GETBIZ');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        isset($params['state']) || $params['state'] = 'active,inactive,limited';
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    
    //扫描仪外放或回收
    public function operatar($params = array()){
    	$webServiceRootUrl =   C('API_SCANNER_MANAGER_OPERATE');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }
    
    //获取扫描仪已扫名片记录
    public function scanedVcard($params = array()){
    	$webServiceRootUrl =   C('API_SCANNER_MANAGER_VCARD');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }

    /* 企业账号 获取扫描仪使用记录 */
    public function getScannerRecordList( $params = array() ){
        $webServiceRootUrl =   C('API_SCANNER_MANAGER_HISTORY');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    //企业账号 获取扫描仪数量和名片数量
    public function getInfoCompany($params = array()){
        $webServiceRootUrl =   C('API_ACCOUNTBIZ_COMPANY_GETBIZ');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    //获取扫描仪设备列表
    public function getScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    //扫描仪定位查询 - 获取扫描仪设备列表
    public function getLocationScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER_LOCATION_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    //扫描仪定位查询 - 重启
    public function restartScanners($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_RESTART');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    //新增
    public function addScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_ADD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    //编辑
    public function editScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    //删除
    public function delScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_DEL');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    //扫描仪使用记录
    public function recardUseScanner($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_USE_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
    //扫描仪使用记录统计
    public function recardUseScannerStatics($params = array() ){
        $webServiceRootUrl =   C('API_SCANNER2_STATISTICS');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

}