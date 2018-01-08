<?php
namespace Model\News;
/**
 * 咨询内容采集相关接口
 */
use Model\WebService;
class Collection extends WebService
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 采集内容操作接口(添加、修改、删除、查询)
	 * @param Array $params 频道操作参数
	 * @return Array
	 */
	public function operaCollContent($param=array(), $crud='R')
	{
		switch ($crud){
			case 'R':
				$webServiceRootUrl = C('API_INFOMATION_COLLECTION_GET');
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
				$webServiceRootUrl = C('API_INFOMATION_COLLECTION_DEL');
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'U':
				$webServiceRootUrl = C('API_INFOMATION_COLLECTION_EDIT');
				// 设置请求方法为 更新
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;
			case 'P': //采集内容的发布
				$webServiceRootUrl = C('API_INFOMATION_COLLECTION_DEPLOY');
				$crudMethod = parent::OC_HTTP_CRUD_C;
				if(isset($param['image']) && !empty($param['image'])){
					$this->setUploadFile($param['image'], 'image');
				}
				break;
			default:
				\Think\log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 采集内容model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $param);
		return parseApi($response);
	}	
	
}