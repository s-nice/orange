<?php
/*
 * 企业客户接口
 * @author jiyl
 */
namespace Model\AccountBiz;
use Model\WebService;
use \Think\Model;
class Customer extends WebService{
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 读取客户名片
	 */ 
	public function card($params = array())
	{
        // 发送http请求
        $response = $this->request(C('API_CUSTOMER_CARD'), parent::OC_HTTP_CRUD_R, $params);
        //* 解析http 请求
        $response = parseApi($response);

		return $response;
	}
	/**
	 * 员工部门
	 */
	public function userGroup($params = array())
	{
		// 发送http请求
		$response = $this->request(C('API_CUSTOMER_USERGROUP'), parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 根据部门id获取员工信息
	 */
	public function userByGId($params = array())
	{
		// 发送http请求
		$response = $this->request(C('API_CUSTOMER_USER_BYGID'), parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	
	/**
	 * 获取所有企业员工接口
	 * @return Ambigous <multitype:, multitype:string Ambigous <NULL, mixed> Ambigous <number, NULL, int, unknown> >
	 */
	public function getAllCustomer($params = array())
	{
		// 发送http请求
		$response = $this->request(C('API_ACCOUNTBIZ_EMPLOYEE_GET'), parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);
		return $response;
	}
	/**
	 * 导入客户名片
	 */
	public function importCard($params = array())
	{
		// 发送http请求
		$response = $this->request(C('API_CUSTOMER_CARD'), parent::OC_HTTP_CRUD_C, $params);
		//* 解析http 请求
		$response = parseApi($response);
	
		return $response;
	}

	/**
	 *  获取客户公司
	 *  @params =array $params
	 *
	 * */

	public function getCompany($params = array())

	{
		$bizid=$params['bizid'] ? $params['bizid'] :$_SESSION['Company']['bizid'];;
		$where=' WHERE a.biz_id='. sprintf('\'%s\'', $bizid) .' AND a.cardtype=2 AND a.isdelete=0';
		$start=($params['p']-1)* $params['rows'];//起始条目
		$limit = ' LIMIT ' . $start . ',' . $params['rows'];//分页
		if(!empty($params['name'])){
			$where.=' AND ORG LIKE'. sprintf('\'%s\'', $params['name']);

		}
		$sqlNumFound='SELECT COUNT(b.ORG) AS numfound
              FROM biz_card_pool AS a INNER JOIN contact_card_company AS b
              ON a.card_id=b.cardid '.$where .' GROUP BY b.ORG';
		$model = new Model();
		$model->db(1, C('APPADMINDB'));
		$resNumFound = $model->query($sqlNumFound);
		$res='';
		if(!empty($resNumFound)){
			$numFound = $resNumFound[0]['numfound'];
			$sql='SELECT b.ORG AS name,count(distinct a.card_id) AS cardNum
              FROM biz_card_pool AS a INNER JOIN contact_card_company AS b
              ON a.card_id=b.cardid '.$where.' GROUP BY b.ORG'.$limit;
			$list= $model->query($sql);
			$res = array(
				'numfound' => $numFound,
				'list' => $list
			);
		}else{
			$res = array(
				'numfound' =>0,

			);
		}
		return $res;

	}

	/**
	 *  获取客户公司详情(企业详情)
	 *  @params =array $params
	 *
	 * */

	public function getCompanyDetail($params=array()){
      // 发送http请求
		$response = $this->request(C('API_COMPANY_DETAIL'), parent::OC_HTTP_CRUD_R, $params);
		//* 解析http 请求
		$response = parseApi($response);

		return $response;


	}

}
