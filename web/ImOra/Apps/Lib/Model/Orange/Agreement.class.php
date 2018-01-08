<?php
namespace Model\Orange;
use Model\WebService;

class Agreement extends WebService
{
    /**
	 * 橙子管理中的协议管理model(编辑、获取)
	 * @param Array $params 协议管理操作参数
	 * @return Array
	 */
	public function manageAgreement($params=array(), $crud='R')
	{
		// 设置请求方法为 新建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		switch (strtoupper($crud)){
			case 'R':
				$webServiceRootUrl = C('API_LABEL_MANAGE');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				$webServiceRootUrl = C('API_LABEL_MANAGE');
				break;
			case 'D':
				$webServiceRootUrl = C('API_LABEL_MANAGE_DELETE');
				break;

			default:
				trace(' 橙子协议管理Model方法 Agreement：：manageAgreement 调用错误 ' . var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);

		return parseApi($response);
	}
}

/* EOF */