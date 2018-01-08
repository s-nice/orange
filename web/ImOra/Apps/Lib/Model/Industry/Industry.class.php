<?php
namespace Model\Industry;
use Model\WebService;
class Industry extends WebService
{
    /**
	 * 行业操作接口(添加、修改、删除、查询)
	 * @param Array $params 行业操作参数
	 * @param string $crud  API的crud操作请求
	 * @return Array
	 */
	public function doRequest($param=array(), $crud='R')
	{
		// 设置请求方法为 新建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		$crud = strtoupper($crud);
		switch ($crud){
			case 'R':
				$webServiceRootUrl = C('API_INDUSTRY_GET');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				$webServiceRootUrl = C('API_INDUSTRY_ADD');
				break;
			case 'D':
				$webServiceRootUrl = C('API_INDUSTRY_DELETE');
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'U':
				$webServiceRootUrl = C('API_INDUSTRY_UPDATE');
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 行业model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $param);

		return parseApi($response);
	}

	public function manageIndustry($params=array(), $crud='R')
	{
	    return $this->doRequest($params, $crud);
	}
}
?>