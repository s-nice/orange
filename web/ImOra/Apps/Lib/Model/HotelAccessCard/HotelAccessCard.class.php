<?php
namespace Model\HotelAccessCard;
/*
 * 鉴权接口 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
use Model\WebService;
class HotelAccessCard extends WebService{
	public function __construct()
	{
		parent::__construct();
	}

    //获取企业角色列表
    public function getBssidList($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_HOTELCARD_GET_BSSID');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //创建角色列表
    public function createBssid($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_HOTELCARD_ADD_BSSID');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //更新角色
    public function updateBssid($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_HOTELCARD_EDIT_BSSID');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //创建角色
    public function delBssid($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_HOTELCARD_DEL_BSSID');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        $result = parseApi($response);
        return $result;
    }


    //获取发卡单位列表
    public function getLssuerList($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ORANGE_ISSUE_UNIT_GET');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //获取酒店列表
    public function getHotelList($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_GET_HOTEL');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }
}
