<?php
namespace Model\Contact;
/*
 * 联系人名片二维码 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
use Model\WebService;
class VcardExchange extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 二维码交换名片接口
	 * act :
	 * 		getkey 生成名片二维码保存所需参数
	 * 		qrcopycard 二维码保存名片
	 * 		downqrcardres 下载二维码资源
	 * 		getqrcopycard 获取交换名片信息
	 */
	public function vcardExchange($params = array(),$crudMethod = 'C')
	{
		// web service 接口路径  联系人名片接口
		$webServiceRootUrl = C('API_CONTACT_VCARD_EXCHANGE');
		switch ($crudMethod){
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_C;
		}
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 获取名片的个人主页信息
	 */
	public function getCardExtendDetail($params = array())
	{
		// web service 接口路径  联系人名片接口
		$webServiceRootUrl = WEB_SERVICE_ROOT_URL.'/contact/common/getnonextenddetail';
		$crudMethod = parent::OC_HTTP_CRUD_R;		
		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}

	/**
	 * 获取联系人
	 * @param array $params
	 * @param string $crudMethod
	 * @return array $response
	 */
	public function contact($params = array(),$crudMethod = 'R')
	{
		// web service 接口路径  联系人
		$webServiceRootUrl = C('API_CONTACT');
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
				if(isset($params['cardres'])){
					$this->setUploadFile($params['cardres'],'cardres');
					unset($params['cardres']);
				}
				break;
			default:
				;
		}

		// 发送http请求
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 根据邀请码获取联系人名片信息
	 */
	public function getCardByCode($params = array())
	{
		$webServiceRootUrl = C('API_APISTORE_INVITECODECARD');
		// 发送http请求
		$response = $this->request($webServiceRootUrl, parent::OC_HTTP_CRUD_C , $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
}
?>