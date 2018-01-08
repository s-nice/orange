<?php
/**
 * Created by PhpStorm.
 * User: mizhennan
 * Date: 2017/9/28
 * Time: 9:40
 */
namespace Model\Home;
use Model\WebService;
use Think\Log;
class WordCloud extends WebService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTags($params=array())
    {
        $Url = 'http://192.168.30.251:10010/api/v1.0/wordCloud/test/';
        $response = curlPost($Url,$params);
//        dump($params);
//        dump($response);
//        die;
//        $crudMethod = parent::OC_HTTP_CRUD_C;
//        $response = $this->request($Url, $crudMethod, $params);
        //dump();
        return $response;
//        return parseApi($response);
    }
    public function getPics($params=array())
    {
        $Url = 'http://192.168.30.251:10010/api/v1.0/tagCardList/test/';
        $response = curlPost($Url,$params);
        return $response;
    }
}