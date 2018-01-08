<?php
/*
 * 财务资质 相关接口
 * @author jiyl <jiyl@oradt.com>
 */
namespace Model\Finance;
use Model\WebService;
class Finance extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 财务资质
	 */ 
	public function aptitude($params = array(),$crudMethod = 'R')
	{
		// 上传图片
		!empty($params['paytaxprove']) && $this->setUploadFile($params['paytaxprove'], 'paytaxprove');
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 读
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
	/*		case 'U':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;*/
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
		//* 解析http 请求
        // 发送http请求
        $response = $this->request(C('API_FINANCE_APTITUDE'), $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}

    public function updateOrderStatus($params = array()){

        // web service path
        $webServiceRootUrl =   C('API_ORDERMANAGE_OPERATE');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

}
?>