<?php
namespace Model\Orange;
use Model\WebService;

class ParseRule extends WebService
{
    /**
	 * 橙子管理中的协议管理model(编辑、获取)
	 * @param Array $params 协议管理操作参数
	 * @return Array
	 */
	public function manageParseRule($params=array(), $action='R', $doJsonDecode=true)
	{
		// 设置请求方法为 新建
		$crudMethod = parent::OC_HTTP_CRUD_C;
		switch (strtoupper($action)){
			case 'R':
				$webServiceRootUrl = C('API_DAS_PARSE_RULE_GET');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				$webServiceRootUrl = C('API_DAS_PARSE_RULE_ADD');
				break;
			case 'U':
				$webServiceRootUrl = C('API_DAS_PARSE_RULE_UPDATE');
				break;
			case 'D':
				$webServiceRootUrl = C('API_DAS_PARSE_RULE_DELETE');
				break;
			case 'VERIFY':
				$webServiceRootUrl = C('API_DAS_PARSE_RULE_VERIFY');
				break;
			case 'FAIL_LIST':
				$webServiceRootUrl = C('API_DAS_FAIL_RULE_GET');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'FAIL_DETAIL':
				$webServiceRootUrl = C('API_DAS_FAIL_RULE_DETAIL');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'COM_LIST':
				$webServiceRootUrl = C('API_DAS_CLOUD_COMPANY');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'BANK_LIST':
			    $webServiceRootUrl = C('API_DAS_CLOUD_BANK');
			    $crudMethod = parent::OC_HTTP_CRUD_R;
			    break;
				
			default:
				trace(' 橙子数据提取规则管理Model方法 ParseRule：：manageParseRule 调用错误 ' . var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);
		$response = $doJsonDecode ? @ json_decode($response, true) : $response;

		return $response;
	}
}

/* EOF */