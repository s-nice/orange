<?php
namespace Model\Orange;
use Model\WebService;

class RecommendRule extends WebService
{
    /**
	 * 橙子管理中的推荐规则管理model(编辑、获取)
	 * @param Array $params 推荐规则管理操作参数
	 * @return Array
	 */
	public function manageRecommendRule($params=array(), $action='R')
	{
		// 设置请求方法为 新建
		switch (strtoupper($action)){
			case 'R':
				$webServiceRootUrl = C('API_ORANGE_RECOMMEND_RULE_GET');
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'U':
				$webServiceRootUrl = C('API_ORANGE_RECOMMEND_RULE_UPDATE');
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;

			default:
				trace(' 橙子数据推荐规则管理Model方法 RecommendRule：：manageRecommendRule 调用错误 ' . var_export(func_get_args(),true));
				return;
		}
		$response = $this->request($webServiceRootUrl, $crudMethod, $params);

		return parseApi($response);
	}
}

/* EOF */