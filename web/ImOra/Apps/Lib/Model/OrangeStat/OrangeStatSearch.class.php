<?php
namespace Model\OrangeStat;
use Model\OrangeStat\OrangeStatBase;
class OrangeStatSearch extends OrangeStatBase
{
    protected $limit = 20;

    private $echoSql = false;

    private $die = false;
    
    //根据查询日/3日/周/月 种类 处理日期
    private function getFormat($startTime,$date_type){
        switch ($date_type) {
            case '1':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),3) day)";
                break;
            case '2':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),7) day)";
                //$format = "subdate(dt,date_format(dt,'%w')-1)";
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
    /**
     * 人均搜索次数
     * @param arr $params  //搜索条件
     * @type int $type //查询 0 为页面访问 图形 和图标都查询 1为导出图表 只查询图表数据
     * @return arr
     */
    public function averageSearchNum($params,$type=0){

    	$where = $whereValues = array(); //定义where查询条件存储变量
        $where[] = 'dt >= "%s"'; //开始日期
        $whereValues[] = $params['starttime'];
        $where[] = 'dt <= "%s"';//结束日期
        $whereValues[] = $params['endtime'].' 23:59:59';
        if(!empty($params['sv']) ||  !empty($params['hv'])){ //软硬件版本设置其中之一
            //软件版本
            if(!empty($params['sv'])){
                $channelArr = $params['sv'];
                if(count($channelArr)>1){ //值只有一个用 where =  多个用where in
                    $valStr = "";
                    foreach ($channelArr as $val){
                        $valStr .= '"'.$val.'",';
                    }
                    $where['pro_version'] = ' pro_version in (%s)';
                    $valStr = rtrim($valStr,',');
                    $whereValues['pro_version'] = $valStr;
                }else{
                    $whereValues['pro_version'] = $params['sv'][0];
                    $where['pro_version'] = ' pro_version = "%s"';
                }
            }else{
                $whereValues['pro_version'] = 'all';
                $where['pro_version'] = ' pro_version != "%s"';

            }
            //硬件版本
            if(!empty($params['hv'])){
                $channelArr = $params['hv'];
                if(count($channelArr)>1){
                    $valStr = "";
                    foreach ($channelArr as $val){
                        $valStr .= '"'.$val.'",';
                    }
                    $where['model'] = '  model in (%s)';
                    $valStr = rtrim($valStr,',');
                    $whereValues['model'] = $valStr;
                }else{
                    $whereValues['model'] = $params['hv'][0];
                    $where['model'] = '  model = "%s"';
                }
            }else{
                $whereValues['model'] ='all';
                $where['model'] = '  model != "%s"';

            }
        }else{ //都不设置 为 all
            $whereValues['pro_version'] = 'all';
            $where['pro_version'] = ' pro_version = "%s"';
            $whereValues['model'] ='all';
            $where['model'] = '  model = "%s"';

        }


        if ($where) { //第二张表没有“search_type”字段
            $whereTemp = join(' AND ', $where);
            $whereTemp = vsprintf($whereTemp, $whereValues);
            $whereStr_2 = ' WHERE ' .  $whereTemp;
        }
        if($params['type']!=''){//搜索类型 语音 or 文本 字段search_type
            $where['search_type'] = 'search_type = %s';
            $search_type=$whereValues['search_type'] = intval($params['type']);

        }else{
            $where['search_type'] = 'search_type = %s';
            $search_type=$whereValues['search_type'] = 0; //0 为总数

        }
    	if ($where) {
    		$whereTemp = join(' AND ', $where);
    		$whereTemp = vsprintf($whereTemp , $whereValues);
    		$whereStr_1 = ' WHERE ' . $whereTemp;

            $where['model']='  model = "%s"'; //线形图数据不包括软硬件版本条件
            $whereValues['model']='all';
            $where['pro_version']=' pro_version = "%s"';
            $whereValues['pro_version']='all';
            $whereLine= join(' AND ', $where);
            $whereLine=vsprintf($whereLine , $whereValues);
            $whereLineStr_1 = ' WHERE ' .$whereLine; //线形图数据where
            unset($where['search_type'],$whereValues['search_type']);
            $whereLineTemp= join(' AND ', $where);
            $whereLineTemp=vsprintf($whereLineTemp , $whereValues);
            $whereLineStr_2 = ' WHERE ' .$whereLineTemp; //线形图数据where

    	}
        $sql='select
                                u.dt as time
                                ,u.pro_version as software
                                ,u.model as hardware
                                ,CASE  WHEN pv_user=0  THEN 0 ELSE round(pv_sum/pv_user,2) END  pv_count #人均访问页面次数
                                ,CASE  WHEN search_user=0  THEN 0 ELSE ROUND(search_sum/ search_user,2) END search_count#人均使用搜索次数
                            from (
                                select
                                   %s as dt1
                                    ,pro_version
                                    ,model
                                    ,sum(pv_num) as pv_sum #访问页面次数
                                    ,sum(search_num) as search_sum #使用搜索次数
                                from dm_orange_stats_search
                                %s
                                group by
                                    dt1
                                    ,pro_version
                                    ,model
                            ) as c
                            join (
                                select
                                    dt
                                    ,pro_version
                                    ,model
                                    ,sum(if(module=2 and field=1 and detail=0,vals,0)) as pv_user #访问页面用户数
                                    ,sum(if(module=2 and field=2 and detail='.$search_type.',vals,0)) as search_user #使用搜索用户数
                                from %s
                                %s
                                group by
                                    dt
                                    ,pro_version
                                    ,model
                            ) as u
                            on u.dt=c.dt1
                                and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                                    dt';
        switch ($params['period']){
            case 'w'://周
                $dateField = sprintf('DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,\'%s\'),7) DAY) ',$params['starttime']);//查询时间sql
                $fromDateTable='dm_orange_stats_week';//选择时间周期对应点多数据表
                $tableSql=vsprintf($sql,array($dateField,$whereStr_1,$fromDateTable,$whereStr_2));
                $lineSql =vsprintf($sql,array($dateField,$whereLineStr_1,$fromDateTable,$whereLineStr_2)); //线形图sql
                break;
            case 'm'://月
                $dateField = 'DATE_ADD(dt,interval -day(dt)+1 day)';//查询时间sql
                $fromDateTable='dm_orange_stats_month';//选择时间周期对应点多数据表
                $tableSql=vsprintf($sql,array($dateField,$whereStr_1,$fromDateTable,$whereStr_2));
                $lineSql =vsprintf($sql,array($dateField,$whereLineStr_1,$fromDateTable,$whereLineStr_2)); //线形图sql
                break;
            case 'd3'://3日
                $dateField = sprintf('DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,\'%s\'),3) DAY )',$params['starttime']);//查询时间sql
                $fromDateTable='dm_orange_stats_three_day';//选择时间周期对应点多数据表
                $tableSql=vsprintf($sql,array($dateField,$whereStr_1,$fromDateTable,$whereStr_2.sprintf(' and mod(datediff(dt,\'%s\'),3)=0  ',$params['starttime'])));
                $lineSql =vsprintf($sql,array($dateField,$whereLineStr_1,$fromDateTable,$whereLineStr_2)); //线形图sql
                break;
            default://日
                $sql='select
                            dt as time
                            ,pro_version as software
                            ,model as hardware
                            ,CASE  WHEN pv_user=0 THEN 0 ELSE round(pv_num/pv_user,2) END  pv_count  #人均访问页面次数
                            ,CASE  WHEN search_user=0 THEN 0 ELSE ROUND(search_num/ search_user,2) END search_count
                        from dm_orange_stats_search
                            %s
                        order by
                           dt';

                $tableSql=sprintf($sql,$whereStr_1);
                $lineSql =sprintf($sql,$whereLineStr_1); //线形图sql
                break;
        }
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $replaceStr= $params['period']=='d' ?'/model/' : '/u.model/';
            $tableSql = preg_replace($replaceStr, '\'全部 \'', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) {
            $replaceStr= $params['period']=='d' ?'/pro_version/' : '/u.pro_version/';
            $tableSql = preg_replace($replaceStr, '\'全部 \' ', $tableSql, 1); //只替换一次

        }

        if(0==$type){
            $data['lineData'] = $this->query($lineSql);
            $data['tableData'] = $this->query($tableSql);
        }else{
            $data['tableData'] = $this->query($tableSql);
        }
        return $data;
    }
    
    /**
     * 使用搜索功能的总用户数
     * @param arr $params
     * @return arr
     */
    public function totalUserNum($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];
        if($isAll){
            $s_versions = "('all')";
            $h_versions =  "('all')";
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $child_type = isset($params['child_type'])?$params['child_type']:0;
        //$search_type = $child_type?"search_type=$child_type":"search_type=0 ";
        //$format = $this->getFormat($startTime,$params['date_type']);
        if($params['date_type']==0){
            $child_type = $child_type?1^2^$child_type:0;
            $sql = "SELECT 
                        dt dtime,
                        model h_versions,
                        pro_version s_versions,
                        SUM(if(search_type = 0 ,pv_user,0)) as sum_pv_user,
                        SUM(if(search_type = $child_type ,search_user,0)) as sum_search_user,
                        SUM(if(search_type = $child_type ,rs_search_user,0)) as sum_rs_search_user,
                        SUM(if(search_type = $child_type ,rclick_user,0)) as sum_rclick_user 
                    FROM 
                        dm_orange_stats_search 
                    WHERE 
                        pro_version IN $s_versions 
                    AND 
                        model IN $h_versions  
                    AND 
                        (dt between '$startTime' AND '$endTime')  
                    GROUP BY 
                        dtime,
                        pro_version,
                        model 
                    ORDER BY dtime,pro_version,model";
        }else{
            switch ($params['date_type']) {
                case '1':
                    $table = "dm_orange_stats_three_day";
                    $three_where = " AND (mod(DATEDIFF(dt,'$startTime'),3) = 0 ) ";
                    break;
                case '2':
                    $table = "dm_orange_stats_week";
                    $three_where = "";
                    break;
                case '3':
                    $table = "dm_orange_stats_month";
                    $three_where = "";
                    break;
                default:
                    # code...
                    break;
            }
            $child_type = $child_type?1^2^$child_type:0;
            $sql = "SELECT 
                        dt dtime,
                        model h_versions,
                        pro_version s_versions,
                        SUM(if(field = 1 and detail = 0,vals,0)) as sum_pv_user,
                        SUM(if(field = 2 and detail = $child_type,vals,0)) as sum_search_user,
                        SUM(if(field = 3 and detail = $child_type,vals,0)) as sum_rs_search_user,
                        SUM(if(field = 4 and detail = $child_type,vals,0)) as sum_rclick_user 
                    FROM 
                        $table  
                    WHERE 
                            pro_version IN $s_versions $three_where 
                        AND 
                            model IN $h_versions  
                        AND module = 2 

                        AND 
                            (dt between '$startTime' AND '$endTime')  
                    GROUP BY 
                        dtime,
                        pro_version,
                        model 
                    ORDER BY dtime,pro_version,model";
        }
        //echo $sql;die;
        $list = $this->query($sql);
        //print_r($list);die;
        return $list;//$this->_chartData($this->_processList($list, $params));
    }
    
    /**
     * 使用搜索功能的总次数
     * @param unknown $param
     */
    public function totalSearchNum($params,$isAll=false){
        $startTime = $params['startTime'];
        $endTime = $params['endTime'];

        if($isAll){
            $s_versions = "('all')";
            $h_versions =  "('all')";
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        $child_type = isset($params['child_type'])?$params['child_type']:0;
        $child_type = $child_type?1^2^$child_type:0;
        $search_type = $child_type?" ($child_type) ":" (1,2) ";
        $format = $this->getFormat($startTime,$params['date_type']);
        $sql = "SELECT
                    $format dtime,
                    model h_versions,
                    pro_version s_versions,
                    SUM(if(search_type = 0 ,pv_num,0)) as sum_pv_numb,
                    SUM(if(search_type in $search_type ,search_num,0)) as sum_search_use_numb,
                    SUM(if(search_type in $search_type ,rs_search_num,0)) as sum_rs_search_numb,
                    SUM(if(search_type in $search_type ,rclick_num,0)) as sum_rclick_numb 
                FROM
                    dm_orange_stats_search
                WHERE 
                    pro_version IN $s_versions
                AND
                    model IN $h_versions
                AND
                    (dt between '$startTime' AND '$endTime') 
                GROUP BY
                    dtime,
                    pro_version,
                    model";
          //echo  $sql;die;
        $list = $this->query($sql);
        //print_r($list);die;
        return $list;//$this->_chartData($this->_processList($list, $params));
    }
    
    /**
     * 生成用户图表的数据(即总和)
     * @param arr $list
     * @param arr
     */
    private function _chartData($list){
        $newlist['list'] = $list;
        $chartData       = array();
        for ($i = 0; $i < count($list); $i++) {
            $tmp = $list[$i];
            $chartData['card3'] += $tmp['card3'];
            $chartData['card1'] += $tmp['card1'];
            $chartData['card4'] += $tmp['card4'];
            $chartData['card15_19'] += $tmp['card15_19'];
            $chartData['card6'] += $tmp['card6'];
            $chartData['card0'] += $tmp['card0'];
        }
        
        foreach ($chartData as $key=>$value) {
            $newlist['chart'][] = array('name'=>$key, 'count'=>$value);
        }
        
        $newlist['chart'] = array_sort($newlist['chart'], 'count');
        return $newlist;
    }
    
    /**
     * 处理数据(补空，周转换)
     * @param arr $list
     * @param arr $params
     */
    private function _processList($list, $params){
        if ($params['period'] == 'w') {
            return $this->_weekDateConvert($list, $params['period']);
        }
        //三日数据合并;
        if ($params['period'] == 'd3') {
            $newlist = $newlist2 = $dates = array();
            $_date   = $params['starttime'];
            $dates[] = $_date;
            
            //日期列表
            while (true){
                $_date = date('Y-m-d', strtotime($_date)+3600*24*3);
                if ($_date > $params['endtime']) {
                    break;
                }
                $dates[] = $_date;
            }
            
            //拼结果
            for ($i = 0; $i <count($dates); $i++) {
                $_date = $dates[$i];
                $enddate = date('Y-m-d', strtotime($_date)+3600*24*3);
                for ($j = 0; $j <  count($params['sv']); $j++) {
                    $_sv = $params['sv'][$j];
                    for ($k = 0; $k < count($params['hv']); $k++) {
                        $_hv = $params['hv'][$k];
                        for ($a = 0; $a < count($list); $a++) {
                            $tmp = $list[$a];
                            if ($tmp['date1'] >= $_date && $tmp['date1'] < $enddate && $tmp['pro_version'] == $_sv && $tmp['model'] == $_hv) {
                                if (empty($newlist[$_date])) {
                                    $newlist[$_date] = $tmp;
                                } else {
                                    $newlist[$_date]['total'] += $tmp['total'];
                                    $newlist[$_date]['card3'] += $tmp['card3'];
                                    $newlist[$_date]['card1'] += $tmp['card1'];
                                    $newlist[$_date]['card4'] += $tmp['card4'];
                                    
                                    $newlist[$_date]['card15_19'] += $tmp['card15_19'];
                                    $newlist[$_date]['card6']     += $tmp['card6'];
                                    $newlist[$_date]['card0']     += $tmp['card0'];
                                }
                            }
                        }
                    }
                }
            }
            
            //再转换
            foreach ($newlist as $key=>$value) {
                $value['date1'] = $key;
                $newlist2[] = $value;
            }
            return $newlist2;
        }
        return $list;
    }
    /**
     * 如果搜索日期类型是周，则把周的第一天显示到数据里
     * @param array $list
     * @param str $searchDateType
     * @return array
     */
    private function _weekDateConvert($list,$searchDateType){
        if ($searchDateType != 'w') {
            return $list;
        }
        for ($j = 0; $j < count($list); $j++) {
            $tmp = explode('-', $list[$j]['date1']);
            $list[$j]['date1'] = date('Y-m-d',strtotime("o$tmp[0]-W$tmp[1]"));
        }
        return $list;
    }
    
    public function testDataUser(){
        $sv = array('s1.0','s1.1','s1.2','s1.3','s1.4');
        $hv = array('h1.0','h1.1','h1.2','h1.3','h1.4');
        $time = time()-3600*24*101;
     
        for ($i = 0; $i < count($sv); $i++) {
            $_sv = $sv[$i];
            for ($j = 0; $j < count($hv); $j++) {
                $_hv = $hv[$j];
                $_time = $time;
                for ($k = 0; $k < 100; $k++) {
                    $_time += 3600*24;
                    $arr = array();
                    $arr[] = $_sv;
                    $arr[] = $_hv;
                    for ($m = 0; $m < 16; $m++) {
                        $arr[] = rand(100, 999);
                    }
                    $arr[] = date('Y-m-d', $_time);
                    $arr[] = date('Y-m-d H:i:s', $_time);
                    $sql = "insert into `dm_orange_stats_user` values(null,'%s','%s',%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,'%s','%s')";
                    $this->execute($sql, $arr);
                }
            }
        }
    }
    
    public function testDataService(){
        $sv = array('s1.0','s1.1','s1.2','s1.3','s1.4');
        $hv = array('h1.0','h1.1','h1.2','h1.3','h1.4');
        $time = time()-3600*24*101;
         
        for ($i = 0; $i < count($sv); $i++) {
            $_sv = $sv[$i];
            for ($j = 0; $j < count($hv); $j++) {
                $_hv = $hv[$j];
                $_time = $time;
                for ($k = 0; $k < 100; $k++) {
                    $_time += 3600*24;
                    $arr = array();
                    $arr[] = $_sv;
                    $arr[] = $_hv;
                    for ($m = 0; $m < 6; $m++) {
                        $arr[] = rand(100, 99999);
                    }
                    $arr[] = rand(1, 20);
                    $arr[] = date('Y-m-d', $_time);
                    $arr[] = date('Y-m-d H:i:s', $_time);
                    $sql = "insert into `dm_orange_stats_service` values(null,'%s','%s',%d,%d,%d,%d,%d,%d,'%s','%s','%s')";
                    $this->execute($sql, $arr);
                }
            }
        }
    }

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }
}

