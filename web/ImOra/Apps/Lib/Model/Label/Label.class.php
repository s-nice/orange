<?php
namespace Model\Label;
use Model\WebService;

class Label extends WebService
{
    /**
	 * 内容管理中的标签管理model(添加、删除、获取)
	 * @param Array $params 频道操作参数
	 * @return Array
	 */
	public function manageLabel($params=array(), $crud='R')
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
				trace(' 标签Model方法 Label：：manageLabel 调用错误 ' . var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);

		return parseApi($response);
	}
}

/* EOF */