<?php

namespace Model\News;
use Model\WebService;
class Category extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	
    /**
	 * 频道操作接口(添加、修改、删除、查询)
	 * @param Array $params 频道操作参数
	 * @return Array
	 */
	public function operaChannel($param=array(), $crud='R') 
	{
		// 设置请求方法为 新建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$crud = strtoupper($crud);
		switch ($crud){
			case 'R':
				$webServiceRootUrl = C('API_INFOMATION_CATEGORY');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				$webServiceRootUrl = C('API_INFOMATION_CATEGORY');
				break;
			case 'D':
				$webServiceRootUrl = C('API_INFOMATION_CATEGORY_DELETE');
				break;
			case 'U':
				$webServiceRootUrl = C('API_INFOMATION_CATEGORY_EDIT');
				break;
			default:
				\Think\log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 行业model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $param);
		return parseApi($response);
	}
}
?>