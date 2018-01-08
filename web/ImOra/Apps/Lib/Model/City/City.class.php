<?php
namespace Model\City;

use Model\WebService;

class City extends WebService
{   
    /**
     * 城市信息
     */
    public function getCity($params=array())
    {
    	// web service 接口路径
    	$webServiceRootUrl = C('API_GET_CITY');
    	// 设置请求方法为 读取
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	// 设置请求参数
    	 //	$fields = array('fields'=>'countrycode,countrycd2,countryname,countryabbr,cityname,cityabbr,citycode,citynativename');
    	$fields = array('fields'=>'city,prefecturecode,provincecode,province');
    	$params = array_merge($fields,$params);
    	//$params['languageid'] = 2;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	// 解析http 请求
    	return parseApi($response);
    }
    
    /**
     * 递归的获取所有的城市信息
     * @param int $start //开始查询索引
     * @param array $dataRst 上次查询的结果集
     */
    public function getAllCity($start=0,$dataRst=array(),$param=array())
    {
    	set_time_limit(0);
    	$record = 50;//每页显示记录数
    	$params = array('start'=>$start,'rows'=>$record);
    	$params = array_merge($params,$param);
    	$result = $this->getCity($params);
    	if($result['status'] == 0){
    		$numFound = $result['data']['numfound'];
    		$data 	  = $result['data']['cityinfo'];
    		$data     = array_merge($dataRst,$data);
    		$end      = $start+$record;
    		if($end < $numFound-1 && $end<1200){
    			return $this->getAllCity($end,$data);
    		}else{
    			return array('status'=>0,'msg'=>'get all city succuss completely','data'=>$data);
    		}
    	}else{
    		return array('status'=>$result['status'],'msg'=>$result['msg'],'data'=>'get all city error ! start={$start}');
    	}
    }

    /*
     * 获取地区信息 企业基本信息用
    * */
    public function getProvinceList($params=array()){
    	$list = array();
    	// web service 接口路径
    	$webServiceRootUrl = C('API_GET_PROVINCE');
    	// 设置请求方法为 读取
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	//$params['fields'] = 'provincecode,name';
//     	$params['rows']   = PHP_INT_MAX;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	$result     = parseApi($response);
    	if($result['status'] == 0 && $result['data']['numfound']>0){
    		$list = $result['data']['list'];
    	}
    	return $list;
    }

}