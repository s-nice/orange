<?php
namespace Model\Position;
use Model\WebService;
/**
 * 职能管理数据模型
 * @author wangzx
 *
 */
class Position extends WebService
{
    /**
	 * 职能管理操作接口(添加、修改、删除、查询)
	 * @param Array $params 行业操作参数
	 * @param string $crud  API的crud操作请求
	 * @return Array
	 */
	public function managePosition($params=array(), $crud='R')
	{
		// 设置请求方法为 新建
		switch ( strtoupper($crud) ){
			case 'R':
		        $webServiceRootUrl = C('API_INDUSTRY_GET');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
		        $webServiceRootUrl = C('API_INDUSTRY_ADD');
		        $crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
		        $webServiceRootUrl = C('API_INDUSTRY_DELETE');
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			case 'U':
		        $webServiceRootUrl = C('API_INDUSTRY_UPDATE');
		        $crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 职能管理model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);

		return parseApi($response);
	}
}

/* EOF */