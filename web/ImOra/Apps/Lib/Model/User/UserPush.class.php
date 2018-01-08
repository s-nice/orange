<?php
namespace Model\User;
use \Think\Model;
/**
 * admin 用户推广
 * @author wuzj
 * @date   2016年9月29日
 */
use Model\WebService;
class UserPush extends WebService{
	/**
	 * 上传音频文件
	 * @param array $params
	 * @return array 
     */
	public function uploadAudio($params){
// 	    $params['resource'] = $params['resource'][0];
// 	    print_r($params);die;

	    /*
        $webServiceRootUrl = C('API_SOURCE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        
        $this->setUploadFile($params['resource'][0], 'resource');
        
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params['resource']);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;*/
	    
        $webServiceRootUrl =   C('API_PICTURE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile($params['audio'], 'resource');
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params['audio']);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
	}
	
	/**
	 * 添加用户推广
	 * @param array $params
	 * @return array
	 */
    public function douserpush($params = array()){
		//echo $crudMethod;
		//echo C('API_USER_PROMOTION');
		//print_r($params);
        $response = $this->request(C('API_USER_PROMOTION'), parent::OC_HTTP_CRUD_C, $params);
        $response = parseApi($response);
		return $response;
	}
	
	/**
	 * 查询用户推广
	 * @param array $params
	 * @return array
	 */
	public function userpush($params = array()){
	    //echo $crudMethod;
	    //echo C('API_USER_PROMOTION');
	    //print_r($params);
	    $response = $this->request(C('API_USER_GETPROMOTION'), parent::OC_HTTP_CRUD_R, $params);
	    $response = parseApi($response);
	    return $response;
	}
	
	public function edituserpush($params = array()){
	    $response = $this->request(C('API_USER_EDITPROMOTION'), parent::OC_HTTP_CRUD_C, $params);
	    $response = parseApi($response);
	    return $response;
	}
	
	
}