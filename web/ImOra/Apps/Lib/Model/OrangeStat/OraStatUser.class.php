<?php
namespace Model\OrangeStat;
use Model\OrangeStat\OrangeStatBase;
class OraStatUser extends OrangeStatBase
{
    private $selectTypes = array(
        0=>array('platform','channel','province'),
        1=>array('platform','channel','province'),
        2=>array('platform','proversion','channel','province'),
        3=>array('platform','channel'),
        4=>array('platform','channel'),
        5=>array('platform','channel','province'),
        6=>array('platform','channel'),
        7=>array('channel'),
        8=>array('platform','proversion','channel'),
        9=>array('platform','proversion','channel'),
        10=>array('platform','proversion','channel'),
        11=>array('platform','proversion','channel'),
        );
    
    //查询
    public function getData($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        $date_type = $params['date_type'];
        $stat_type = $params['stat_type'];
        $selects = $this->getSelect($params,$isAll);
        $column = $selects['column'];
        $where = $selects['where'];
        $groupby = $selects['groupby'];
        $order = $selects['order'];
        ///print_r($selects);die;
        switch ($stat_type) {
            case 0:
                //$andWhere = $isAll?" AND "
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(new_increase_num) num 
                FROM 
                    dm_app_stats_increase_user 
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND 
                    period=$date_type  
                AND 
                    $where AND proversion='all' 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break; 
            case 1:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(user_all) total_num,
                    sum(formal_vip_num) vip_num,
                    sum(binding_orange_num) binding_num 
                FROM 
                    dm_app_stats_accum_user  
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                break; 

            case 2:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(active_user_num) total_num,
                    sum(formal_vip_num) vip_num,
                    sum(employ_vip_num) employ_num  
                FROM 
                    dm_app_stats_active_user  
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND 
                    period=$date_type  
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break; 

            case 3:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(accum_num) num 
                FROM 
                    dm_app_stats_accum_user  
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND province = 'all' 
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break; 
            case 4:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(if(period=7,keep_wastage_user_num,0)) ltseven,
                    sum(if(period=14,keep_wastage_user_num,0)) seventofourteen,
                    sum(if(period=30,keep_wastage_user_num,0)) fourteentothirty,
                    sum(if(period=31,keep_wastage_user_num,0)) gtthirty 
                FROM 
                    dm_app_stats_keep_wastage_status   
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND proversion = 'all' 
                AND type = '2' 
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break;
            case 5:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(new_vip_num) num 
                FROM 
                    dm_app_stats_increase_user 
                WHERE 
                    (dt between '$startTime' AND '$endTime')  
                AND proversion='all' 
                AND 
                    period=$date_type  
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break;
            case 6:
                $sql = "SELECT 
                    dt dtime,
                    $column,
                    sum(connect_orange_num) num 
                FROM 
                    dm_app_stats_connect_orange  
                WHERE 
                    (dt between '$startTime' AND '$endTime')   
                AND 
                    period=$date_type  
                AND 
                    $where 
                GROUP BY dt $groupby 
                ORDER BY 
                    dt,
                    $order";
                //echo $sql;die;
                break;
            case 7:
                $groupby = $isAll?" brand,model ":" channel,brand,model ";
                $sql = "SELECT 
                    $column,
                    brand,
                    model,
                    sum(device_num) num  
                FROM 
                    dm_app_stats_device  
                WHERE 
                    (dt between '$startTime' AND '$endTime')   
                AND 
                    $where 
                GROUP BY $groupby  
                ORDER BY 
                    num desc ,channel asc";
                //echo $sql;die;
                break;
            case 8:
                $sql="SELECT 
                    u.dt dtime,
                    u.platform,
                    u.proversion,
                    u.channel,
                    login_time/active_user_num num 
                FROM 
                    (SELECT 
                        dt,
                        $column,
                        login_time   
                    FROM 
                        dm_app_stats_login_status   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        period=$date_type  
                    AND 
                        $where) as c 
                JOIN 
                    (SELECT 
                        dt,
                        $column,
                        active_user_num    
                    FROM 
                        dm_app_stats_active_user   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        period=$date_type  
                    AND active_user_num!=0 
                    AND province='all' 
                    AND 
                        $where) as u 
                ON 
                    u.dt = c.dt 
                    AND u.proversion = c.proversion 
                    AND u.channel = c.channel 
                    AND u.platform = c.platform 
                ORDER BY 
                    u.dt,
                    $order";
            // echo $sql;
                break;
            case 9:
                $sql="SELECT 
                    dt dtime,
                    $column,
                    login_time/use_times num 
                FROM 
                    dm_app_stats_login_status    
                WHERE 
                    (dt between '$startTime' AND '$endTime')   
                AND 
                    period=$date_type  
                AND use_times!=0 
                AND 
                    $where 
                ORDER BY $order";
            //echo $sql;die;
                break;
            case 10:
                $sql="SELECT 
                    u.dt dtime,
                    u.platform,
                    u.proversion,
                    u.channel,
                    login_times/active_user_num num 
                FROM 
                    (SELECT 
                        dt,
                        $column,
                        login_times   
                    FROM 
                        dm_app_stats_login_status   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        period=$date_type  
                    AND 
                        $where) as c 
                JOIN 
                    (SELECT 
                        dt,
                        $column,
                        active_user_num    
                    FROM 
                        dm_app_stats_active_user   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        period=$date_type  
                    AND active_user_num!=0 
                    AND province='all' 
                    AND 
                        $where) as u 
                ON 
                    u.dt = c.dt 
                AND u.proversion = c.proversion 
                AND u.channel = c.channel 
                AND u.platform = c.platform 
                ORDER BY u.dt,$order";
            //echo $sql;die;
                break;
            case 11:
                $sql="SELECT 
                    u.dt dtime,
                    u.platform,
                    u.proversion,
                    u.channel,
                    new_increase_num,
                    keep1/new_increase_num oneper,
                    keep2/new_increase_num twoper,
                    keep3/new_increase_num threeper,
                    keep7/new_increase_num sevenper,
                    keep10/new_increase_num tenper,
                    keep14/new_increase_num fourteenper,
                    keep30/new_increase_num thirtyper 
                FROM 
                    (SELECT 
                        calculate_dt,
                        $column,
                        sum(if(period=1,keep_wastage_user_num,0)) as keep1,
                        sum(if(period=2,keep_wastage_user_num,0)) as keep2,
                        sum(if(period=3,keep_wastage_user_num,0)) as keep3,
                        sum(if(period=7,keep_wastage_user_num,0)) as keep7,
                        sum(if(period=10,keep_wastage_user_num,0)) as keep10,
                        sum(if(period=14,keep_wastage_user_num,0)) as keep14,
                        sum(if(period=30,keep_wastage_user_num,0)) as keep30 
                    FROM 
                        dm_app_stats_keep_wastage_status   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        type=1 
                    AND 
                        $where
                    GROUP BY 
                        calculate_dt,
                        $order) as c 
                JOIN 
                    (SELECT 
                        dt,
                        $column,
                        new_increase_num 
                    FROM 
                        dm_app_stats_increase_user   
                    WHERE 
                        (dt between '$startTime' AND '$endTime')   
                    AND 
                        period=0   
                    AND new_increase_num!=0 
                    AND province='all' 
                    AND 
                        $where) as u 
                ON 
                    u.dt = c.calculate_dt  
                AND u.proversion = c.proversion 
                AND u.channel = c.channel 
                AND u.platform = c.platform 
                ORDER BY u.dt,$order";
                break;
            default:
                # code...
                break;
        }
        //echo $sql;
        $data = $this->query($sql);
        return $data;
    }

    private function getSelect($params,$isAll){
        //$params
        $stat_type = $params['stat_type'];
        $orders = array();
        $groupbys = array();
        $wheres = array();
        $columns = array();
        foreach ($this->selectTypes[$stat_type] as $key => $value) {
            /*if($isAll){
                $wheres[] = " $value in ('all') ";
            }else{
                if(!empty($params[$value])){
                    $wheres[] = " $value in ".$this->versionsToStr($params[$value])." ";
                }
            }*/
            $orders[] = $value;
            $str = $value.'_is_all';
            if($isAll||!empty($params[$str])){
                $columns[] = "'全部' as $value";
                $wheres[] = " $value in ('all') ";
            }else{
                $columns[] =  $value;
                $groupbys[] = $value;
                $wheres[] = " $value in ".$this->versionsToStr($params[$value])." ";
            }
        }
        $order = implode(',', $orders);
        $groupby = implode(',', $groupbys);
        $groupby = $groupby?','.$groupby:'';
        $column = implode(',', $columns);
        $where = implode('and', $wheres);
        return array('order'=>$order,'column'=>$column,'groupby'=>$groupby,'where'=>$where);
    }

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }

    
}