<?php
/**
 * Created by machaoyang.
 * Descprpt:公司主页
 * Date: 2016-10-21
 * Time: 16:54
 */
namespace Model\Company;
use Model\WebService;
class Info extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取公司内容详情
     * @param array $params
     * @return array
     */
    public function getInfo($params = array()){
        // web service path
        // $webServiceRootUrl =   C('API_FAQ_QUESTION');
        // $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        // $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        //* 解析http 请求
        //$response = parseApi($response);
        $response = array ( 'status' => 0, 'msg' =>'', 'data' => array('content'=>"北京橙鑫数据有限公司(以下简称橙鑫数据)成立于2013年，由橙鑫数据科技（香港）有限公司全额投资，目前已投入上亿美元进行智能移动终端和云服务平台自主研发。","website"=>"www.oredt.com","tel"=>"010-58230505",'address'=>'北京市朝阳区亮马桥安家楼1号'));
        return $response;
    }
}
