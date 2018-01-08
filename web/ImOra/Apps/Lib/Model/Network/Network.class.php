<?php
namespace Model\Network;

use \Think\Model;
class Network extends Model
{
    // 数据表名（不包含表前缀）
    protected $tableName        =   'account_employee';
    protected $typeArr = array(
        'day'=>'%Y-%m-%d',
        'month'=>'%Y-%m',
        'week'=>'%Y-%u',
        );
    protected $disHour;

    public function _initialize(){
        $time = time();
        $gmt_date = gmdate('Y-m-d H:i:s',$time);
        $gmt_time = strtotime($gmt_date);
        $this->disHour = ($time-$gmt_time)/3600;
    }
/*
    //查询新增任务数
        SELECT 
            count(1) as num,
            sys_platform,
            DATE_FORMAT(`create_time`,'%Y-%m-%d' ) as t_time
        FROM 
            relationship_task 
        WHERE
            `create_time` between '2016-02-16' AND '2016-02-23' 
        AND 
            type='task' 
        GROUP BY 
            t_time,sys_platform


    //查询创建任务用户数
        SELECT 
            count(DISTINCT user_id) as num, 
            sys_platform,
            DATE_FORMAT(`date`,'%Y-%m-%d' ) as t_time
        FROM
            st_task_record_im
        WHERE 
            `date` between '2016-02-16' AND '2016-02-23' 
        AND 
            type='task' 
        GROUP BY 
            t_time,sys_platform


    //查询活跃用户数
        SELECT 
            sum(`count`) as num, 
            date_format(`date`,'%Y-%m-%d') as t_time  ,
            sys_platform 
        FROM 
            st_active_user_cnt  
        WHERE 
                sys_platform='IOS' 
            AND 
                `date` between '2016-02-16' AND '2016-02-23' 
        GROUP BY 
            t_time,
            sys_platform

    //查询发布记录用户数
        SELECT 
            count(DISTINCT user_id) as num, 
            sys_platform,
            DATE_FORMAT(`date`,'%Y-%m-%d' ) as t_time
        FROM
            st_task_record_im
        WHERE 
            `date` between '2016-02-16' AND '2016-02-23' 
        AND 
            type='record' 
        GROUP BY 
            t_time,sys_platform

    //查询聊天用户数
        SELECT 
            count(DISTINCT user_id) as num, 
            sys_platform,
            DATE_FORMAT(`date`,'%Y-%m-%d' ) as t_time
        FROM
            st_task_record_im
        WHERE 
            `date` between '2016-02-16' AND '2016-02-23' 
        AND 
            type='im' 
        GROUP BY 
            t_time,sys_platform 
*/




    //新增任务数
    public function getTaskNum($sys_platform,$type,$start_time,$end_time){

        $str = $this->typeArr[$type];
        //起始结束日期转为格林威治时间
        $start_time = gmdate('Y-m-d H:i:s',strtotime($start_time));
        $end_time = gmdate('Y-m-d H:i:s',strtotime($end_time.' 23:59:59'));
        $sql = "SELECT 
                    count(1) as num,
                    sys_platform,
                    DATE_FORMAT(date_add(`create_time`,Interval $this->disHour Hour),'$str') as t_time 
                FROM 
                    relationship_task 
                WHERE ";
        if($sys_platform){
            $sql.="sys_platform='$sys_platform' AND ";
        }
        $sql.= "`create_time` between '$start_time' AND '$end_time' 
                GROUP BY 
                    t_time";
        if(!$sys_platform){
            $sql.=",sys_platform";
        }
       // echo $sql;die;
        $userStats = $this->query($sql);
        //print_r($userStats);die;
        return $userStats;
    }

    //查询新增任务用户数
    public function getUserNum($sys_platform,$type,$start_time,$end_time,$sle_name){
        $str = $this->typeArr[$type];
        $sql = "SELECT 
                    count(DISTINCT user_id) as num,
                    sys_platform,
                    DATE_FORMAT(`date`,'$str') as t_time 
                FROM 
                    st_task_record_im 
                WHERE ";
                if($sys_platform){
                    $sql.="sys_platform='$sys_platform' AND ";
                }
                $sql.=" `date` between '$start_time' AND '$end_time' 
                    AND type='$sle_name' 
                GROUP BY 
                    t_time";
                if(!$sys_platform){
                    $sql.=",sys_platform";
                }

        $userStats = $this->query($sql);
        return $userStats;
    }

    //查询新增记录总数及人均新增记录数
    public function getAvgNum($sys_platform,$type,$start_time,$end_time,$sle_name){
        $str = $this->typeArr[$type];
        $sql = "SELECT 
                    count(DISTINCT user_id) as num,
                    SUM(count) as sum,
                    (SUM(count)/count(DISTINCT user_id)) as avg,
                    sys_platform,
                    DATE_FORMAT(`date`,'$str') as t_time 
                FROM 
                    st_task_record_im 
                WHERE ";
                if($sys_platform){
                    $sql.="sys_platform='$sys_platform' AND ";
                }
                $sql.=" `date` between '$start_time' AND '$end_time' 
                    AND type='$sle_name' 
                GROUP BY 
                    t_time";
                if(!$sys_platform){
                    $sql.=",sys_platform";
                }
//echo $sql;die;
        $userStats = $this->query($sql);
        //print_r($userStats);die;
        return $userStats;
    }


    //查询活跃用户数
    public function getActiveUserNum($sys_platform,$type,$start_time,$end_time){

        $str = $this->typeArr[$type];
        $start_time = gmdate('Y-m-d H:i:s',strtotime($start_time));
        $end_time = gmdate('Y-m-d H:i:s',strtotime($end_time.' 23:59:59'));
        $sql = "SELECT 
                    count(DISTINCT `user_id`) as num,
                    sys_platform,
                    DATE_FORMAT(date_add(`time`,Interval $this->disHour Hour),'$str') as t_time 
                FROM 
                    user_daily_last_login 
                WHERE ";
                /*if($sys_platform){
                    $sql.="sys_platform='$sys_platform' AND ";
                }*/
                    $sql.="`time` between '$start_time' AND '$end_time' 
                GROUP BY 
                    t_time";
                //if(!$sys_platform){
                    $sql.=",sys_platform";
                //}
        $userStats = $this->query($sql);
        return $userStats;
    }

}