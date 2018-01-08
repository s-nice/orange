<?php
namespace Demo\Controller;
use Classes;


Class LogController
{

    // 获取发布的消息
    public function getList()
    {
        (!\Classes\CacheRedis::ping()) and die(); // 如果连通性差则取消

        set_time_limit(30); 
    	$redisObj = \Classes\CacheRedis::getInstance();

        // 获取现有消息队列的长度
    	$count = 0;
        $max = $redisObj->lLen("wx_api");

        // 回滚数组
        $roll_back_arr = array();

        // 获取消息队列的内容，拼接sql
        $insert = "insert into wx_api_log (`wechat_id`, `duration`,`api_name`,`method`,`parameter`,`response`,`call_time`) values ";
        $insert_sql = $insert;
        
    	while ($count < $max) {
            $log_info = $redisObj->lPop("wx_api");
            $roll_back_arr[] = $log_info;
            if ($log_info == 'nil' || !isset($log_info)) {
                $insert_sql .= ";";
                break;
            }
            
            // 从队列值解析回数组
            $log_info_arr = json_decode($log_info,true);

            if (($count >0) && ($count%10 == 0)) { // 每十条记录一句sql
                $insert_sql = rtrim($insert_sql,",").";".$insert;
            }
            
            // 循环拼接sql语句
            $insert_sql .= ' ("'.addslashes($log_info_arr['user_id']).'","'.addslashes($log_info_arr['using_time']).'","'.addslashes($log_info_arr['api_name']).'","'.addslashes($log_info_arr['method']).'","'.addslashes($log_info_arr['parameter']).'","'.addslashes($log_info_arr['response']).'","'.addslashes($log_info_arr['calltime']).'"),';
            $count++;
        }
		if ($count != 0) {
            $link = $redisObj::getMysql();
            if ($link === false) {
                die();
            }
            $insert_sql = rtrim($insert_sql,",").";";
            $res = $redisObj->insertDb($link,C('WX_REDIS_DB_NAME'),$insert_sql);
                      
            // 如果插入失败则回滚
            if(!$res){
               \Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n<pre>".''.var_export('插入数据库失败 '.$insert_sql),true);
            }
            $redisObj->closeDb($res,$link); // 关闭数据库连接
        }

        $redisObj->close(); // 关闭redis

    }
    
}