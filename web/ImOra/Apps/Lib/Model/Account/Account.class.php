<?php
/*
 * 普通账号 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\Account;
use Model\WebService;
class Account extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 普通账号
	 */ 
	public function account($params = array(),$crudMethod = 'R')
	{
		// 设置请求头信息
		$headers = array();
		if(isset($params['headers'])){
			$headers=$params['headers'];
			unset($params['headers']);
		}
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
        $response = $this->request(C('API_ACCOUNT'), $crudMethod, $params,$headers);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	

	/**
	 * 获取头像
	 * @param array $params
	 * @return array
	 */
	public function headImage($params){
	    header('Content-type: png');
	    $webServiceRootUrl = C('API_ACCOUNT_AVATAR');
	    $crudMethod = parent::OC_HTTP_CRUD_R;
	    $response = $this->request($webServiceRootUrl, $crudMethod, $params);
	    $status = json_decode($response,true);
	    
	    if(empty($status) || (isset($status['head']['status']) && $status['head']['status'] == '1')){
	        echo file_get_contents($params['defaultHeadImg']);
	    }else{
	        $len = strlen($response);
	        header("Content-Length: $len");
	        echo $response;
	    }
	
	    return $response;
	}
	/**
	 * 校验手机号是否已注册
	 * @param array $params array('mobile'=>手机号,'mcode'=>手机区号(默认86))
	 * @return number $status 3：API错误   0：已注册 1： 未注册  
	 */
	public function checkPhone($params){
		$status = 3;
		$response = $this->request(C('API_OAUTH_APISTORE_CHECKACCOUNT'), parent::OC_HTTP_CRUD_C, $params);
		// 解析http请求
		$response = parseApi($response);
		if($response['status'] == '0'){
			if(isset($response['data']['clientid']) && !empty($response['data']['clientid'])){
				// 已注册
				$status = 0;
			}else{
				// 未注册
				$status = 1;
			}
		}else{
			// API网络错误
		}
		return $status;
		
	}
	/**
	 * 获取他人名片信息
	 */
	public function getVcards($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 发送http请求
		$response = $this->request(C('API_ACCOUNT_COMMON_GETVCARDS'), $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 获取他人名片扩展信息
	 */
	public function getCardattach($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 发送http请求
		$response = $this->request(WEB_SERVICE_ROOT_URL . '/contact/common/getcardattach', $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 获取他人名片扩展信息-视频
	 */
	public function getVideo($params = array())
	{
		$crudMethod = parent::OC_HTTP_CRUD_R;
		// 发送http请求
		$response = $this->request(WEB_SERVICE_ROOT_URL . '/contact/common/editextenddetail', $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	
}
?>