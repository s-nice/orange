<?php
namespace Model\Orange;
use Model\OrangeStat\OrangeStatBase;
class OraUserStatistics extends OrangeStatBase
{
    private $selectTypes = array(
        0=>array('pro_version','model'),
        1=>array('pro_version','model'),
        2=>array('pro_version','model'),
        3=>array('pro_version','model'),
        4=>array('pro_version','model'),
        5=>array('pro_version','model'),
        6=>array('pro_version','model'),
        7=>array('pro_version','model'),
        8=>array('pro_version','model'),
        9=>array('pro_version','model'),
        10=>array('pro_version','model'),
        11=>array('pro_version','model'),
        );

    //根据查询日/3日/周/月 种类 处理日期
    private function getFormat($startTime,$date_type){
        switch ($date_type) {
            case '1':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),3) day)";
                break;
            case '2':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),7) day)";
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

    


    private $columns = array(
        '0'=>array(
            'name'=>'sum(new_device) as num',
            ),
        '1'=>array(
            'name'=>'sum(device_total) as num',
            ),
        '2'=>array(
            'name'=>'sum(active_user) as num',
            ),
        '3'=>array(
            'name'=>'new_device',
            'child'=>array(
                0=>'sum(use_time/active_user) as num',
                1=>'sum(use_time/use_count) as num',
                ),
            'where'=>array(
                0=>' and active_user <>0 ',
                1=>' and use_count <>0 ',
                ),
            ),
        '4'=>array(
            'name'=>'sum(bright_total) as num',
            'child'=>array(
                0=>'sum(bright_total) as num',
                1=>'avg(bright_total/active_user) as num',
                ),
            'where'=>array(
                0=>'',
                1=>' and active_user <>0 ',
                ),
            ),

        '6'=>array(
            'name'=>'sum(churn_user7) as user7,sum(churn_user14) as user14,sum(churn_user30) as user30,sum(churn_user32) as user32',
            ),
        '7'=>array(
            'name'=>'sum(recurring_user7) as user7,sum(recurring_user14) as user14,sum(recurring_user30) as user30,sum(recurring_user32) as user32',
            ),
        '8'=>array(
            'name'=>'avg(mob_conn_time/active_user) as num',
            ),
        '10'=>array(
            'name'=>'sum(online_time) as num',
            ),
        '11'=>array(
            'name'=>'sum(active_user_month_acu) as num'
            ),
        );
    //查询
    public function getData($params,$isAll=false){

        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        $date_type = isset($params['date_type'])?$params['date_type']:0;
        $format = $this->getFormat($startTime,$date_type);

        $selects = $this->getSelect($params,$isAll);
        $column = $selects['column'];
        $where = $selects['where'];
        $groupby = $selects['groupby'];
        $order = $selects['order'];

        if($isAll){
            $s_versions = "('all')";
            $h_versions = "('all')";
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $column = isset($params['child_type'])?$this->columns[$params['stat_type']]['child'][$params['child_type']]:$this->columns[$params['stat_type']]['name'];
        $column .= ',pro_version s_versions,model h_versions';
        $from = 'dm_orange_stats_user';
        $groupby = 'dtime,s_versions,h_versions';
        if($params['stat_type']==2){
            $from = 'dm_orange_stats_active_user';
            $groupby = 'dtime,s_versions,h_versions,area';
            $column .= ',area';
        }
        if(isset($this->columns[$params['stat_type']]['where'])){
            if(isset($params['child_type'])){
                $where = $this->columns[$params['stat_type']]['where'][$params['child_type']];
            }else{
                $where = $this->columns[$params['stat_type']]['where'];
            }
        }else{
            $where = '';
        }
        if(in_array($params['stat_type'], array('0','1','2','3','4','8','10'))){
            $having = " HAVING not ISNULL(num)";
        }else{
            $having = '';
        }
        //$where = isset($this->columns[$params['stat_type']]['where'])?$this->columns[$params['stat_type']]['where'][$params['child_type']]:'';
        $sql = "SELECT 
                    $column,
                    $format as dtime   
                FROM 
                    $from 
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime') $where  
                AND pro_version IN $s_versions 
                AND model IN $h_versions  
                GROUP BY 
                    $groupby";

                    echo $sql;die;
        $sql .= $having;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }

    public function getDatas($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        $stat_type = $params['stat_type'];
        $date_type = isset($params['date_type'])?$params['date_type']:0;
        $child_type = isset($params['child_type'])?$params['child_type']:0;
        $format = $this->getFormat($startTime,$date_type);
        $selects = $this->getSelect($params,$isAll);
        $column = $selects['column'];
        $where = $selects['where'];
        $groupby = $selects['groupby'];
        //print_r($selects);
        $order = $selects['order'];
        $column_num = isset($params['child_type'])?$this->columns[$params['stat_type']]['child'][$params['child_type']]:$this->columns[$params['stat_type']]['name'];
        switch ($stat_type) {
            case 0:
                //$groupby = ($date_type)?',pro_version,model':'';
                $sql = "SELECT 
                    sum(new_device) as num,
                    $column,
                    $format as dtime   
                FROM 
                    dm_orange_stats_user 
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime') 
                AND $where 
                GROUP BY dtime $groupby  
                ORDER BY dtime,$order";
                break;
            case 1:
                $sql = "SELECT 
                    device_total as num,
                    $column,
                    dt as dtime   
                FROM 
                    dm_orange_stats_user 
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime') 
                AND $where 
                
                ORDER BY dt,$order";
                break;
            case 2:
                $where1 = ($date_type==1)?"AND mod(datediff(dt,'$startTime'),3)=0 ":"";
                $sql = "SELECT 
                    active_user as num,
                    $column,
                    area,
                    dt as dtime   
                FROM 
                    dm_orange_stats_active_user  
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime') 
                AND $where 
                $where1 
                AND is_domestic=1 
                AND period_type=$date_type  
                ORDER BY dt,$order,area";
                //echo $sql;die;
                break;
            case 3:
                if($child_type==0){ 
                    if($date_type==0){ 
                        $sql = "SELECT 
                            (use_time/active_user) as num,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        AND active_user!=0 
                        ORDER BY dt,$order";
                    }else{
                        switch ($date_type) {
                            case '1':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                                $table = 'dm_orange_stats_three_day';
                                $where1 = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                                break;
                            case '2':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";

                                $table = 'dm_orange_stats_week';
                                $where1 = "";
                                break;
                            case '3':
                                $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                                $table = 'dm_orange_stats_month';
                                $where1 = "";
                                break;
                            default:
                                # code...
                                break;
                        }
                        $sql = "SELECT 
                            u.dt as dtime,
                            u.model as model,
                            u.pro_version as pro_version,
                            use_time/vals as num 
                        FROM
                            (SELECT
                                $dt dt1,
                                $column,
                                SUM(use_time) use_time  
                            FROM 
                                dm_orange_stats_user 
                            WHERE
                                (dt between '$startTime' AND '$endTime') 
                                AND $where 
                            GROUP BY 
                                dt1,
                                model,
                                pro_version
                                ) c 
                         JOIN 
                            (SELECT 
                                dt,
                                $column,
                                vals 
                            FROM 
                                $table  
                            WHERE 
                                (dt BETWEEN '$startTime' AND '$endTime' ) 
                                $where1  
                                AND $where   
                                AND 
                                module = 1 
                                AND 
                                field = 1 
                                AND 
                                detail = 0 
                                AND vals!=0 
                            ) u 
                        ON 
                            c.dt1 = u.dt 
                        AND c.model = u.model 
                        AND c.pro_version = u.pro_version 
                        
                        ORDER BY 
                            dtime,
                            model,
                            pro_version";

                        //echo $sql;die;
                    }
                }elseif($child_type==1){
                    if($date_type==0){ 
                        $sql = "SELECT 
                            (use_time/use_count) as num,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        AND use_count!=0 
                        ORDER BY dtime,$order";
                    }else{
                        switch ($date_type) {
                            case '1':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                                break;
                            case '2':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                                break;
                            case '3':
                                $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                                break;
                            default:
                                # code...
                                break;
                        }
                        $sql = "SELECT
                                $dt dtime,
                                $column,
                                sum(use_time)/sum(use_count) num 
                            FROM 
                                dm_orange_stats_user 
                            WHERE
                                (dt between '$startTime' AND '$endTime') 
                                AND 
                                $where 
                            GROUP BY dtime,pro_version,model   
                            HAVING sum(use_count)!=0 
                            ORDER BY 
                                dtime,$order
                                ";
                        //echo $sql;die;
                    }
                }
                break;
            case '4':
                if($child_type==0){
                    if($date_type==0){ 
                        $sql = "SELECT 
                            bright_total as num,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        AND bright_total!=0 
                        ORDER BY dtime,$order";
                    }else{
                        switch ($date_type) {
                            case '1':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                                break;
                            case '2':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                                break;
                            case '3':
                                $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                                break;
                            default:
                                # code...
                                break;
                        }
                        $sql = "SELECT
                                $dt dtime,
                                $column,
                                sum(bright_total) num 
                            FROM 
                                dm_orange_stats_user 
                            WHERE
                                (dt between '$startTime' AND '$endTime') 
                                AND 
                                $where 
                            GROUP BY dtime,pro_version,model   
                            HAVING sum(bright_total)!=0 
                            ORDER BY 
                                dtime,$order
                                ";
                        //echo $sql;die;
                    }
                    //echo $sql;die;
                }elseif($child_type==1){
                    if($date_type==0){ 
                        $sql = "SELECT 
                            (bright_total/active_user) as num,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        AND active_user!=0 
                        ORDER BY dt,$order";
                    }else{
                        switch ($date_type) {
                            case '1':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                                $table = 'dm_orange_stats_three_day';
                                $where1 = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                                break;
                            case '2':
                                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";

                                $table = 'dm_orange_stats_week';
                                $where1 = "";
                                break;
                            case '3':
                                $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                                $table = 'dm_orange_stats_month';
                                $where1 = "";
                                break;
                            default:
                                # code...
                                break;
                        }
                        $sql = "SELECT 
                            u.dt as dtime,
                            u.model as model,
                            u.pro_version as pro_version,
                            bright_total/vals as num 
                        FROM
                            (SELECT
                                $dt dt1,
                                $column,
                                SUM(bright_total) bright_total  
                            FROM 
                                dm_orange_stats_user 
                            WHERE
                                (dt between '$startTime' AND '$endTime') 
                                AND $where 
                            GROUP BY 
                                dt1,
                                model,
                                pro_version
                                ) c 
                         JOIN 
                            (SELECT 
                                dt,
                                $column,
                                vals 
                            FROM 
                                $table  
                            WHERE 
                                (dt BETWEEN '$startTime' AND '$endTime' ) 
                                $where1  
                                AND $where   
                                AND 
                                module = 1 
                                AND 
                                field = 1 
                                AND 
                                detail = 0 
                                AND vals!=0 
                            ) u 
                        ON 
                            c.dt1 = u.dt 
                        AND c.model = u.model 
                        AND c.pro_version = u.pro_version 
                        
                        ORDER BY 
                            dtime,
                            model,
                            pro_version";

                        //echo $sql;die;
                    }
                }
                break;
            case '6':
                $sql = "SELECT 
                            churn_user7 as user7,churn_user14 as user14,churn_user30 as user30,churn_user32 as user32,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        ORDER BY dt,$order";
                
                break;
            case '7':
                $sql = "SELECT 
                            recurring_user7 as user7,recurring_user14 as user14,recurring_user30 as user30,recurring_user32 as user32,
                            $column,
                            dt as dtime   
                        FROM 
                            dm_orange_stats_user 
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime') 
                        AND $where 
                        ORDER BY dt,$order";
                
                break;
            case '8':
                if($date_type==0){ 
                    $sql = "SELECT 
                        (mob_conn_time/active_user) as num,
                        $column,
                        dt as dtime   
                    FROM 
                        dm_orange_stats_user 
                    WHERE 
                        (dt BETWEEN '$startTime' AND '$endTime') 
                    AND $where 
                    AND active_user!=0 
                    ORDER BY dt,$order";
                }else{
                    switch ($date_type) {
                        case '1':
                            $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                            $table = 'dm_orange_stats_three_day';
                            $where1 = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                            break;
                        case '2':
                            $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";

                            $table = 'dm_orange_stats_week';
                            $where1 = "";
                            break;
                        case '3':
                            $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                            $table = 'dm_orange_stats_month';
                            $where1 = "";
                            break;
                        default:
                            # code...
                            break;
                    }
                    $sql = "SELECT 
                        u.dt as dtime,
                        u.model as model,
                        u.pro_version as pro_version,
                        mob_conn_time/vals as num 
                    FROM
                        (SELECT
                            $dt dt1,
                            $column,
                            SUM(mob_conn_time) mob_conn_time   
                        FROM 
                            dm_orange_stats_user 
                        WHERE
                            (dt between '$startTime' AND '$endTime') 
                            AND $where 
                        GROUP BY 
                            dt1,
                            model,
                            pro_version
                            ) c 
                     JOIN 
                        (SELECT 
                            dt,
                            $column,
                            vals 
                        FROM 
                            $table  
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime' ) 
                            $where1  
                            AND $where   
                            AND 
                            module = 1 
                            AND 
                            field = 1 
                            AND 
                            detail = 0 
                            AND vals!=0 
                        ) u 
                    ON 
                        c.dt1 = u.dt 
                    AND c.model = u.model 
                    AND c.pro_version = u.pro_version 
                    
                    ORDER BY 
                        dtime,
                        model,
                        pro_version";

                    //echo $sql;die;
                }
                break;
            case '10':
                if($date_type==0){ 
                    $sql = "SELECT 
                        online_time as num,
                        $column,
                        dt as dtime   
                    FROM 
                        dm_orange_stats_user 
                    WHERE 
                        (dt BETWEEN '$startTime' AND '$endTime') 
                    AND $where 
                    AND online_time!=0 
                    ORDER BY dtime,$order";
                }else{
                    switch ($date_type) {
                        case '1':
                            $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";

                            break;
                        case '2':
                            $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                            break;
                        case '3':
                            $dt = "DATE_SUB(dt,interval day(dt)-1 day)";

                            break;
                        default:
                            # code...
                            break;
                    }
                    $sql = "SELECT
                            $dt dtime,
                            $column,
                            sum(online_time) num 
                        FROM 
                            dm_orange_stats_user 
                        WHERE
                            (dt between '$startTime' AND '$endTime') 
                            AND 
                            $where 
                        GROUP BY dtime,pro_version,model   
                        HAVING sum(online_time)!=0 
                        ORDER BY 
                            dtime,$order
                            ";
                }
                break;
            case '11':
                $sql = "SELECT 
                    active_user_month_acu num,
                    $column,
                    dt as dtime   
                FROM 
                    dm_orange_stats_user 
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime') 
                AND $where 
                ORDER BY dt,$order";
                break;
            default:
                # code...
                break;
        }

        //echo $sql;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }

    public function getActiveUser($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        if($isAll){
            $s_versions = "('all')";
            $h_versions = "('all')";
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $date_type = isset($params['date_type'])?$params['date_type']:0;
        switch ($date_type) {
            case '1':
                $format = " AND mod((datediff(dt,'$startTime')),3)=0";
                break;
            default:
                $format = "";
                break;
        }
        $sql = "SELECT 
                    sum(active_user) as num,
                    area,
                    pro_version s_versions,
                    model h_versions,
                    dt as dtime 
                FROM 
                    `dm_orange_stats_active_user` 
                WHERE 
                    (dt BETWEEN '$startTime' AND '$endTime')  AND  period_type='$date_type' 
                AND is_domestic = 1  
                AND pro_version IN $s_versions 
                AND model IN $h_versions  
                $format 
                GROUP BY 
                    dt,s_versions,h_versions,area";
                //echo $sql;die;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }


    //多日使用时长
    public function getAvgUseTime($params,$isAll=false){
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
        if($params['child_type']==0){  
            switch ($params['date_type']) {
                case '1':
                    $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                    $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                    $table = 'dm_orange_stats_three_day';
                    $where = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                    break;
                case '2':
                    $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                    $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                    $table = 'dm_orange_stats_week';
                    $where = "AND (MOD(DATEDIFF(dt,'$startTime'),7) = 0 )";
                    break;
                case '3':
                    $dt = "DATE_ADD(dt,interval -day(dt)+1 day)";
                    $groupby = "MONTH(dt)";
                    $table = 'dm_orange_stats_month';
                    $where = "";
                    break;
                default:
                    # code...
                    break;
            }
            $sql = "SELECT 
                        u.dt as dtime,
                        u.model as h_versions,
                        u.pro_version as s_versions,
                        c.some_day_use_time/u.some_day_active_user as num 
                    FROM
                        (SELECT
                            $dt dt,
                            model,
                            pro_version,
                            SUM(use_time) some_day_use_time 
                        FROM 
                            dm_orange_stats_user 
                        WHERE
                            (dt between '$startTime' AND '$endTime') 
                            AND 
                            pro_version IN $s_versions 
                            AND 
                            model IN $h_versions  
                        GROUP BY 
                            $groupby,
                            model,
                            pro_version
                            ) c 
                    RIGHT JOIN 
                        (SELECT 
                            dt,
                            model,
                            pro_version,
                            vals some_day_active_user
                        FROM 
                            $table  
                        WHERE 
                            (dt BETWEEN '$startTime' AND '$endTime' ) 
                            $where  
                            AND 
                            pro_version IN $s_versions  
                            AND 
                            model IN $h_versions 
                            AND 
                            module = 1 
                            AND 
                            field = 1 
                            AND 
                            detail = 0
                        ) u 
                    ON 
                        c.dt = u.dt 
                    AND c.model = u.model 
                    AND c.pro_version = u.pro_version 
                    WHERE c.some_day_use_time <>0 and u.some_day_active_user <>0 
                    GROUP BY 
                        u.dt,
                        u.model,
                        u.pro_version";
        }elseif($params['child_type']==1){
            switch ($params['date_type']) {
                case '1':
                    $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                    $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                    $where = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                    break;
                case '2':
                    $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                    $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                    $where = "AND (MOD(DATEDIFF(dt,'$startTime'),7) = 0 )";
                    break;
                case '3':
                    $dt = "DATE_SUB(dt,interval day(dt)-1 day)";
                    $groupby = "MONTH(dt)";
                    $where = "";
                    break;
                default:
                    # code...
                    break;
            }
            $sql = "SELECT
                            $dt dtime,
                            model h_versions,
                            pro_version s_versions,
                            SUM(use_time)/SUM(use_count) num 
                        FROM 
                            dm_orange_stats_user 
                        WHERE
                            (dt between '$startTime' AND '$endTime') 
                            AND 
                            pro_version IN $s_versions 
                            AND 
                            model IN $h_versions  
                        GROUP BY 
                            dtime,
                            pro_version,
                            model 
                        HAVING 
                            SUM(use_count)!=0 
                        ORDER BY 
                            dtime,s_versions,h_versions
                            ";
        }
        //echo $sql;die;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }

    public function getAvgBright($params,$isAll=false){
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
        if($params['stat_type']=='4'){
            $column = "bright_total";
        }elseif($params['stat_type']=='8'){
            $column = "mob_conn_time";
        }
        switch ($params['date_type']) {
            case '1':
                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),3) DAY)";
                $table = 'dm_orange_stats_three_day';
                $where = "AND (MOD(DATEDIFF(dt,'$startTime'),3) = 0 )";
                break;
            case '2':
                $dt = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                $groupby = "DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,'$startTime'),7) DAY)";
                $table = 'dm_orange_stats_week';
                $where = "AND (MOD(DATEDIFF(dt,'$startTime'),7) = 0 )";
                break;
            case '3':
                $dt = "DATE_ADD(dt,interval -day(dt)+1 day)";
                $groupby = "MONTH(dt)";
                $table = 'dm_orange_stats_month';
                $where = "";
                break;
            default:
                # code...
                break;
        }
        $sql = "SELECT 
                    u.dt as dtime,
                    u.model as h_versions,
                    u.pro_version as s_versions,
                    c.some_day_bright_total/u.some_day_active_user as num 
                FROM
                    (SELECT
                        $dt dt,
                        model,
                        pro_version,
                        SUM($column) some_day_bright_total  
                    FROM 
                        dm_orange_stats_user 
                    WHERE
                        (dt between '$startTime' AND '$endTime') 
                        AND 
                        pro_version IN $s_versions 
                        AND 
                        model IN $h_versions  
                    GROUP BY 
                        $groupby,
                        model,
                        pro_version
                        ) c 
                RIGHT JOIN 
                    (SELECT 
                        dt,
                        model,
                        pro_version,
                        vals some_day_active_user
                    FROM 
                        $table  
                    WHERE 
                        (dt BETWEEN '$startTime' AND '$endTime' ) 
                        $where  
                        AND 
                        pro_version IN $s_versions  
                        AND 
                        model IN $h_versions 
                        AND 
                        module = 1 
                        AND 
                        field = 1 
                        AND 
                        detail = 0
                    ) u 
                ON 
                    c.dt = u.dt 
                AND c.model = u.model 
                AND c.pro_version = u.pro_version 
                WHERE u.some_day_active_user !=0 
                GROUP BY 
                    u.dt,
                    u.model,
                    u.pro_version 
                HAVING not ISNULL(num)";

        //echo $sql;die;
        $data = $this->query($sql);
        //print_r($data);die;
        return $data;
    }

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }
    /*
     * 地域分布统计
     * $params sql 参数
     * */
    public function mapStatM($params = array() ){
        $sql = "select ";

        switch($params['date_type']){
            case '1':
                //$sql .= " date_sub(dt,interval mod((datediff(dt,".$params['timestart'].")),3) day) as timetype, ";
                break;
            case '2':
                //$sql .= " subdate(dt,date_format(dt,'%w')-1) as timetype, ";
                break;
            case '3':
                //$sql .= " date_add(dt, interval - day(dt) + 1 day) as timetype, ";
                break;
            default :
                //$sql .= " DATE_FORMAT(`dt`,'%Y-%m-%d') as timetype, ";
                $params['date_type'] = 0;
        }
        $sql .= " dt,pro_version,model,area,active_user,sum(active_user) as user_numb ";

        $sql .= "
            from
                dm_orange_stats_user_province
            where
                dt between   '".$params['timestart']."' and '".$params['timeend']."' and is_domestic=".$params['is_domestic']." and period_type=".$params['date_type']." ";

        //版本条件组装
        if( empty($params['pro_version']) && empty($params['model']) ){
            $sql .= " and `pro_version` = 'all' ";
            $sql .= " and `model` = 'all' ";
        }else{
            if( !empty($params['pro_version']) ){
                $params['pro_version'] = explode(',',$params['pro_version']);
                $params['pro_version'] = implode("','",$params['pro_version']);
                $sql .= " and `pro_version` in('".$params['pro_version']."')  ";
            }else{
                $sql .= " and `pro_version` <> 'all' ";
            }
            if( !empty($params['model']) ){
                $params['model'] = explode(',',$params['model']);
                $params['model'] = implode("','",$params['model']);
                $sql .= " and `model` in('".$params['model']."')  ";
            }else{
                $sql .= " and `model` <> 'all' ";
            }
        }
        if($params['date_type']==1){
            $sql .= "and (MOD(DATEDIFF(dt,'".$params['timestart']."'),3)=0) ";
        }


        //获取地图数据
        $sql .= " group by area ";
        $result['mapdata'] = $this->query($sql);

        //获取列表数据
        $sql .= " ,dt ";
        if( !empty($params['pro_version']) || !empty($params['model']) ){
            if( !empty($params['pro_version']) ) $sql .= " ,pro_version ";
            if( !empty($params['model']) ) $sql .= " ,model ";
        }

        $sql .= "  order by dt asc,area asc";
        $result['listdata'] = $this->query($sql);

        return $result;

    }
    /*
     * 获取使用用户量最大值
     * */
    public function mapStatMaxUser($params){
        $sql = "select sum(`active_user`) as maxnumber from dm_orange_stats_user_province where 1=1";
        $sql .= " and dt between   '".$params['timestart']."' and '".$params['timeend']."' and is_domestic=".$params['is_domestic']." and period_type=".$params['date_type']." and model='all' and pro_version='all' ";
        if($params['date_type'] == 1){
            $sql .= "and (MOD(DATEDIFF(dt,'".$params['timestart']."'),3)=0) ";
        }
        $sql .= " group by area ";
        $result = $this->query($sql);
        $maxnumb = 12;
        if(!empty($result)){
            foreach($result as $val){
                if($val['maxnumber'] >= $maxnumb) $maxnumb=$val['maxnumber'];
            }
        }
        return $maxnumb;
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
            if($isAll){
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

}