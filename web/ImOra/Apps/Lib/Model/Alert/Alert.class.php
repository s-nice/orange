<?php
/**
 * 到期提醒
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\Alert;
use Model\WebService;
class Alert extends WebService{
    
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 添加到期提醒
	 * @param array $params
	 * @return array
	 */
	public function addalert($params = array()){
	    $response = $this->request(C('API_ALERT_ADD'), parent::OC_HTTP_CRUD_C, $params);
	    $response = parseApi($response);
	    return $response;
	}
	
	/**
	 * 修改到期提醒
	 * @param array $params
	 * @return array
	 */
	public function editalert($params = array()){
	    $response = $this->request(C('API_ALERT_EDIT'), parent::OC_HTTP_CRUD_C, $params);
	    $response = parseApi($response);
	    return $response;
	}
	
	/**
	 * 删除到期提醒
	 * @param array $params
	 * @return array
	 */
	public function delalert($params = array()){
	    $response = $this->request(C('API_ALERT_DEL'), parent::OC_HTTP_CRUD_C, $params);
	    $response = parseApi($response);
	    return $response;
	}
	
	/**
	 * 查询到期提醒
	 * @param array $params
	 * @return array
	 */
	public function alert($params = array()){
	    $response = $this->request(C('API_ALERT_GET'), parent::OC_HTTP_CRUD_R, $params);
	    $response = parseApi($response);
	    return $response;
	}
}
?>