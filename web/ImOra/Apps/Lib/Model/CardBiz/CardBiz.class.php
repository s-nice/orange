<?php
/*
 * 普通账号 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-21
 */
namespace Model\CardBiz;
use Model\WebService;
class CardBiz extends WebService{
    
	public function __construct(){
		parent::__construct();
	}
	
	/*
	BEGIN:VCARD
	VERSION:4.0
	FN:王鹤龄
	PROFILE:VCARD
	TEL;TYPE=CELL,PREF=1:18710269886
	EMAIL;PREF=1:whlmark@163.com
	TITLE:php
	ORG:wewew
	END:VCARD
	*/
	
	/**
	 * 企业名片
	 */ 
	public function card($params = array(),$crudMethod = 'R'){
		switch ($crudMethod){
			case 'R':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_R;
				break;
			case 'C':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_C;
				break;
			case 'D':
				// 设置请求方法为 删除
				$crudMethod = parent::OC_HTTP_CRUD_D;
				break;
			case 'U':
				// 设置请求方法为 新建
				$crudMethod = parent::OC_HTTP_CRUD_U;
				break;
			default:
				$crudMethod = parent::OC_HTTP_CRUD_R;
		}
        $response = $this->request(C('API_BIZ_CARD'), $crudMethod, $params);
		return parseApi($response);
	}
	
	/**
	 * 名片模板
	 */
	public function template($params = array()){
	    $response = $this->request(C('API_VCARD_TEMPLATE'), parent::OC_HTTP_CRUD_R, $params);
	    return parseApi($response);
	}
	
	
}
?>