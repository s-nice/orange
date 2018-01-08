<?php
namespace Model\Company;
/**
 * 企业基本信息、修改企业密码等
 */
use Model\WebService;

class CompanyBaseInfo extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取企业信息接口
     */
    public function getEntInfo($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_GET_ENT_INFO');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    
    /**
     * 根据id获取企业信息
     * @param mixed $id 企业id，既可以是整形id,也可以是字符串类型id
     */
    public function getBizInfoByXId($id){
    	$key = is_numeric($id)?'id':'bizid'; //根据传递的值类型自动判断查询传递的属性及值
    	$params = array($key=>$id);
    	$res = \AppTools::webService('\Model\Company\CompanyBaseInfo', 'getEntInfo', array('params'=>$params));
    	if($res['status'] == 0 && !empty($res['data']['list'])){
    		return $res['data']['list'][0];
    	}else{
    		return null;
    	}
    }
}