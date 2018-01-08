<?php
namespace Model\Common;
use Model\WebService;
/**
 * 公用API调用数据模型
 * @author wangzx
 *
 */
class Common extends WebService
{
    /**
	 * 公用方法调用API接口(添加、修改、删除、查询)
	 * @param string $url API接口地址
	 * @param Array $params 操作参数
	 * @param string $crud  API的crud操作请求
	 * @return Array
	 */
	public function callApi($url, $params=array(), $crud='R', $doParseApi=true, $files=array())
	{
		// 设置请求方法为 新建
		switch ( strtoupper($crud) ){
			case 'R':
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
		        $crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			case 'U':
		        $crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			default:
				trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 公用API调用model传参错误 '.var_export(func_get_args(),true));
				return;
		}
		
		if (!empty($files)) {
		    foreach ($files as $key=>$value) {
		        $this->setUploadFile($value, $key);
		    }
		}
		$response = $this->request($url, $crudMethod, $params);
		$response = $doParseApi ? parseApi($response) : $response;

		return $response;
	}
}

/* EOF */