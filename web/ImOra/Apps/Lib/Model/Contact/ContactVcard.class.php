<?php
/*
 * 联系人名片 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-16
 */
namespace Model\Contact;
use Model\WebService;
class ContactVcard extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 联系人名片接口 
	 */ 
	public function contactVcard($params = array(),$crudMethod = 'R')
	{
		// web service 接口路径  联系人名片接口
		$webServiceRootUrl = C('API_CONTACT_VCARD');
		!empty($params['cardres']) && $this->setUploadFile($params['cardres'], 'cardres');
		!empty($params['picture']) && $this->setUploadFile($params['picture'], 'picture');
		!empty($params['picturea']) && $this->setUploadFile($params['picturea'], 'picturea');
		!empty($params['pictureb']) && $this->setUploadFile($params['pictureb'], 'pictureb');
		!empty($params['picpatha']) && $this->setUploadFile($params['picpatha'], 'picpatha');
		// 设置请求头信息
		$headers = array();
		if(isset($params['headers'])){
			$headers=$params['headers'];
			unset($params['headers']);
		}
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 读取
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'U':
				// 设置请求方法为 更新
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params,$headers);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
}
?>