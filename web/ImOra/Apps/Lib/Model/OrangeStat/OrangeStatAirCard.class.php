<?php
namespace Model\OrangeStat;
use Model\OrangeStat\OrangeStatBase;
class OrangeStatAirCard extends OrangeStatBase
{

    //根据查询日/3日/周/月 种类 处理日期
    private function getFormat($startTime,$date_type){
        switch ($date_type) {
            case '1':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),3) day)";
                break;
            case '2':
                $format = "subdate(dt,date_format(dt,'%w')-1)";
                break;
            case '3':
                $format = "date_add(dt,interval - day(dt) + 1 day)";
                break;
            default:
                $format = "dt";
                break;
        }
        return $format;
    }

    
    //查询
    public function getData($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        if($isAll){
            $verArr = $this->getAllVersions();
            $s_versions = $verArr['s'];
            $h_versions = $verArr['h'];
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $stat_type = $params['stat_type'];
        switch ($stat_type) {
            case 0:
                if($isAll){
                    $s_versions = "('all')";
                    $h_versions = "('all')";
                }
                $sql = "SELECT 
                    dt dtime,
                    model h_versions,
                    pro_version s_versions,
                    user_total,
                    user_mode_num,
                    user_no_mode_num 
                FROM 
                    dm_orange_stats_funccard_accumulate_user 
                WHERE 
                    pro_version IN $s_versions 
                AND 
                    model IN $h_versions  
                AND 
                    (dt between '$startTime' AND '$endTime')  
                AND 
                    module='3' 
                ORDER BY 
                    dtime,
                    pro_version,
                    model";
                break; 
            case 1:
                if($isAll){
                    $s_versions = "('all')";
                    $h_versions = "('all')";
                }
                $date_type = $params['date_type'];
                $where = ($date_type==1)?" AND mod(datediff(dt,'$startTime'),3)=0 ":'';
                $sql = "SELECT 
                    dt dtime,
                    model h_versions,
                    pro_version s_versions,
                    user_all,
                    user_mode_num,
                    user_no_mode_num 
                FROM 
                    dm_orange_stats_funccard_user 
                WHERE 
                    pro_version IN $s_versions 
                AND 
                    model IN $h_versions  
                AND 
                    (dt between '$startTime' AND '$endTime')  
                AND 
                    module='3' 
                AND period = $date_type $where 
                ORDER BY 
                    dtime,
                    pro_version,
                    model";
                break; 

            case 3:
                if($isAll){
                    $s_versions = "('all')";
                    $h_versions = "('all')";
                }
                $sql = "SELECT 
                    u.dt dtime,
                    u.model h_versions,
                    u.pro_version s_versions,
                    card_all_num/user_total as num 
                FROM 
                    (SELECT 
                        dt,
                        model,
                        pro_version,
                        card_all_num 
                    FROM 
                        dm_orange_stats_funccard_accumulate_card 
                    WHERE 
                        pro_version IN $s_versions 
                    AND 
                        model IN $h_versions  
                    AND 
                        (dt between '$startTime' AND '$endTime')  
                    AND 
                        module='3') as c 
                JOIN 
                    (SELECT 
                        dt,
                        model,
                        pro_version,
                        user_total 
                    FROM 
                        dm_orange_stats_user 
                    WHERE 
                        pro_version IN $s_versions 
                    AND 
                        model IN $h_versions  
                    AND 
                        (dt between '$startTime' AND '$endTime')  
                    AND 
                        user_total!=0) as u 
                ON  
                    u.dt = c.dt 
                AND u.pro_version = c.pro_version 
                AND u.model = c.model 
                ORDER BY dtime,s_versions,h_versions";
                // echo $sql;die;
                break; 
            case 4:
                if($isAll){
                    $s_versions = "('all')";
                    $h_versions = "('all')";
                }
                $date_type = $params['date_type'];
                if(!$date_type){
                    $sql = "SELECT 
                        u.dt dtime,
                        u.model h_versions,
                        u.pro_version s_versions,
                        use_count/user_all as num 
                    FROM 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            use_times_all as use_count 
                        FROM 
                            dm_orange_stats_funccard_use_times 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            module='3') as c 
                    JOIN 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            user_all 
                        FROM 
                            dm_orange_stats_funccard_user 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            user_all!=0 
                        AND 
                            module='3' 
                        AND 
                            period=0) as u 
                    ON  
                        u.dt = c.dt 
                    AND u.pro_version = c.pro_version 
                    AND u.model = c.model 
                    ORDER BY dtime,s_versions,h_versions";
                }elseif($date_type=='1'){
                    $sql = "SELECT 
                        u.dt dtime,
                        u.model h_versions,
                        u.pro_version s_versions,
                        use_count/user_all as num 
                    FROM 
                        (SELECT 
                            date_sub(dt,interval mod(datediff(dt,'$startTime'),3) day) as dt1,
                            model,
                            pro_version,
                            sum(use_times_all) as use_count 
                        FROM 
                            dm_orange_stats_funccard_use_times 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            module='3' 
                        GROUP BY 
                            dt1,pro_version,model) as c 
                    JOIN 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            user_all 
                        FROM 
                            dm_orange_stats_funccard_user 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            user_all!=0 
                        AND 
                            module='3' 
                        AND 
                            period=1 
                        AND 
                            mod(datediff(dt,'$startTime'),3)=0) as u 
                    ON  
                        u.dt = c.dt1  
                    AND u.pro_version = c.pro_version 
                    AND u.model = c.model 
                    ORDER BY dtime,s_versions,h_versions";
                }elseif($date_type=='2'){
                    $sql = "SELECT 
                        u.dt dtime,
                        u.model h_versions,
                        u.pro_version s_versions,
                        use_count/user_all as num 
                    FROM 
                        (SELECT 
                            date_sub(dt,interval mod(datediff(dt,'$startTime'),7) day) as dt1,
                            model,
                            pro_version,
                            sum(use_times_all) as use_count 
                        FROM 
                            dm_orange_stats_funccard_use_times 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            module='3' 
                        GROUP BY 
                            dt1,pro_version,model) as c 
                    JOIN 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            user_all 
                        FROM 
                            dm_orange_stats_funccard_user 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            user_all!=0 
                        AND 
                            module='3' 
                        AND 
                            period=2) as u 
                    ON  
                        u.dt = c.dt1  
                    AND u.pro_version = c.pro_version 
                    AND u.model = c.model 
                    ORDER BY dtime,s_versions,h_versions";
                }elseif($date_type=='3'){
                    $sql = "SELECT 
                        u.dt dtime,
                        u.model h_versions,
                        u.pro_version s_versions,
                        use_count/user_all as num 
                    FROM 
                        (SELECT 
                            date_sub(dt,interval day(dt)-1 day) as dt1,
                            model,
                            pro_version,
                            sum(use_times_all) as use_count 
                        FROM 
                            dm_orange_stats_funccard_use_times 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            module='3' 
                        GROUP BY 
                            dt1,pro_version,model) as c 
                    JOIN 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            user_all 
                        FROM 
                            dm_orange_stats_funccard_user 
                        WHERE 
                            pro_version IN $s_versions 
                        AND 
                            model IN $h_versions  
                        AND 
                            (dt between '$startTime' AND '$endTime')  
                        AND 
                            user_all!=0 
                        AND 
                            module='3' 
                        AND 
                            period=3) as u 
                    ON  
                        u.dt = c.dt1  
                    AND u.pro_version = c.pro_version 
                    AND u.model = c.model 
                    ORDER BY dtime,s_versions,h_versions";
                }
                break;
            default:
                # code...
                break;
        }
        //echo $sql;die;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }

    public function getMileage($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        if($isAll){
            $verArr = $this->getAllVersions();
            $s_versions = $verArr['s'];
            $h_versions = $verArr['h'];
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $sql = "SELECT 
                    dt dtime,
                    model h_versions,
                    pro_version s_versions,
                    mileage_all num
                FROM 
                    dm_orange_stats_hotel_air_month 
                WHERE 
                    pro_version IN $s_versions 
                AND 
                    model IN $h_versions  
                AND 
                    (dt between '$startTime' AND '$endTime')  
                ORDER BY 
                    dtime,
                    pro_version,
                    model";
                    //echo $sql;die;
        $data = $this->query($sql);
        return $data;
    }

    public function getMileageByPart($params){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];

        $sections = $this->getSections($params['minValue'],$params['maxValue'],$params['rangeValue']);
        $str = $this->getSqlPart($sections,'mileage_all');
        $sql = "SELECT 
                    case $str else 'other' end as section,
                    count(1) as num 
                FROM 
                    dm_orange_stats_hotel_air_month_detail 
                WHERE  
                    (dt between '$startTime' AND '$endTime')  
                GROUP BY 
                    section";
        $data = $this->query($sql);
        return $data;
    }

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }

    
}