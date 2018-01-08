<?php
/**
 * orange 统计 行程卡 model
 *
 * */
namespace Model\OrangeStat;

use \Think\Model;

class OraStatJourneyCard extends Model
{
    /**
     * 查看用户数
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */

    public function getLookUserNum($params = array(), $isDownload = false){
        $sql='select
                    dt
                    ,pro_version
                    ,model
                    ,user_all as num
                from dm_orange_stats_funccard_user';
        $where = $this->getWhere($params, true);//获取通用where条件
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $sql = str_replace('model', '\'全部 \' as model ', $sql);
        }
        if (empty($params['sv']) || null == $params['sv']) {
            $sql = str_replace('pro_version', '\'全部 \' as pro_version ', $sql);
        }
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'd3': //三日
                $where.= sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0  ', $params['starttime']);
                break;
            case 'w': //周
                $where.= ' and period=2  ';
                break;
            case 'm': //月
                $where.= ' and period=3  ';
                break;
            default: //日
                $where.= ' and period=0  ';
        };
        $res = array();
        $res['tableData'] = $this->query($sql . $where . $groupBy . $orderBy);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $whereStr = $this->getWhere($params, false);
            $groupBy = ' group by dt  ';
            $sqlLine = 'select dt ,user_all as num from dm_orange_stats_funccard_user ' .$where . $groupBy . $orderBy;
            $res['lineData'] = $this->query($sqlLine);
        }
        return $res;
    }

    /**
     * 人均航段数
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getAvgAirLine($params = array(), $isDownload = false){
        $sql='select
                     u.dt
                    ,u.pro_version
                    ,u.model
                    ,round(seg/user_all,2) as num
                from (
                    select
                        %s as dt1
                        ,pro_version
                        ,model
                        ,sum(air_seg) as seg
                    from dm_orange_stats_flight
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
                        ,user_all
                    from dm_orange_stats_funccard_user
                    %s
                ) as u
                on u.dt=c.dt1
                    and u.pro_version=c.pro_version
                    and u.model=c.model ';
        $where_1=$this->getWhere($params,true,false);
        $where_2=$this->getWhere($params);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'd3': //三日
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),3) day)',$params['starttime']) ;
                $where_temp = sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0  and user_all!=0 ', $params['starttime']);
                break;
            case 'w': //周
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'2017-05-01\'),7) day)',$params['starttime']);
                $where_temp = ' and period=2 and user_all!=0 ';
                break;
            case 'm': //月
                $dateField='date_sub(dt,interval day(dt)-1 day)';
                $where_temp = ' and period=3 and user_all!=0 ';
                break;
            default: //日
                $dateField='dt';
                $where_temp = ' and period=0 and user_all!=0 ';
        };
        $where_2.=$where_temp;
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        $tableSql =$sql. $groupBy . $orderBy;
        $tableSql= vsprintf($tableSql, array($dateField,$where_1, $where_2)); //替换where
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $tableSql = preg_replace('/u.model/', '\'全部 \' as model', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) {
            $tableSql = preg_replace('/u.pro_version/', '\'全部 \' as pro_version', $tableSql, 1); //只替换一次

        }
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $where_1 = $this->getWhere($params,false,false);//2个表联查 线形图第一个表的where
            $where_2 =$this->getWhere($params,false,true). $where_temp;
            $lineSql = vsprintf($sql, array($dateField,$where_1, $where_2)); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }
    /**
     * 航段数人数分布
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getAirLineUser($params = array(), $isDownload = false){
        $tableSql='select
                        dt
                        ,pro_version
                        ,model
                        ,air_seg_all as num
                    from dm_orange_stats_hotel_air_month
                   %s
                    group by
                        dt
                        ,pro_version
                        ,model
                         ORDER BY  dt';
        $where=$this->getWhere($params,true,false);
        $tableSql=sprintf($tableSql,$where);
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $maxSql='select air_seg_all
                      from dm_orange_stats_hotel_air_month_detail
                      where air_seg_all=(select max(air_seg_all) from dm_orange_stats_hotel_air_month_detail )';
            $getMax=$this->query($maxSql);
            $getMax=$getMax[0]['air_seg_all'];
           if(empty($getMax)){ //  获取航段最大值
                return;//没有数据
            }

            $min = $params['min']=='' ? 1 : $params['min']; //最小值
            $max = $params['max']=='' ?  $getMax : $params['max']; //最大值
            $max = $getMax< $max ? $getMax : $max;//最大值

            if($max<$min){
                return;//没有数据
            }
            $where = sprintf('where dt=\'%s\' ',$params['starttime']);
            if($max == $min){ //最大最小值相等
                $sectionSql ="'".$min."-".$max."'"." as section  '1' as section_num ";
                $where.= "and air_seg_all = ".$max." ";

            }
            if($max > $min){
                $maxBetween= $max-$min;//  分段 默认最大分段 最大值减最小值每段为1
                if($params['between']==''){
                    $between=$maxBetween;
                }else{//分段数比最大分段数大采用最大分段数
                    $between= $maxBetween >= $params['between'] ? $params['between'] : $maxBetween;
                }
                $sectionSql='case  %s  end as section ,case  %s  end as section_num ';
                $one=intval(($max-$min)/$between);//每段数量
                $tempSql=''; //分段
                $tempSql2='';//分段标记 排序用
                for($i=$min;$i<=$max;$i+=$one){ //根据最大最小值分段的值 循环出分段的sql
                    if($i==$min){
                        $tempSql.=" when air_seg_all>=".$i." and air_seg_all<= ".($i+$one) ." then '".$i."-".($i+$one) ."' ";
                        $tempSql2.=" when air_seg_all>=".$i." and air_seg_all<= ".($i+$one) ." then ".$i." ";
                    }
                    else{
                        if($i+$one < $max){
                            $tempSql.=" when air_seg_all>".$i."  and air_seg_all<= ".($i+$one) ." then '".$i."-".($i+$one) ."' ";
                            $tempSql2.=" when air_seg_all>".$i."  and air_seg_all<= ".($i+$one) ." then ".$i." ";
                        }else{
                            $tempSql.=" else '".$i."-".$max."'";
                            $tempSql2.=" else ".$i." ";
                            break;
                        }
                    }
                }
                $sectionSql=vsprintf($sectionSql,array($tempSql,$tempSql2));
                $where.=" and air_seg_all >= ".$min." and air_seg_all <=" .$max." ";

            }

            $lineSql='select
                        dt
                        ,%s
                        ,count(1) as num
                    from dm_orange_stats_hotel_air_month_detail
                   %s
                    group by
                        dt
                        ,section
                    order by
                        section_num asc
                    ';
            $lineSql=vsprintf($lineSql,array($sectionSql,$where));
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }


    /**
     * 人均在途时间
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getOnLineTime($params = array(), $isDownload = false){
        $sql='select
                     u.dt
                    ,u.pro_version
                    ,u.model
                    ,round(travel/user_all/3600,2) as num
                from (
                    select
                        %s as dt1
                        ,pro_version
                        ,model
                        ,sum(travel_time) as travel
                    from dm_orange_stats_flight
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
                        ,user_all
                    from dm_orange_stats_funccard_user
                      %s
                ) as u
                on u.dt=c.dt1
                    and u.pro_version=c.pro_version
                    and u.model=c.model';
        $where_1=$this->getWhere($params,true,false);
        $where_2=$this->getWhere($params);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'd3': //三日
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),3) day)',$params['starttime']) ;
                $where_temp = sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0  and user_all!=0 ', $params['starttime']);
                break;
            case 'w': //周
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'2017-05-01\'),7) day)',$params['starttime']);
                $where_temp = ' and period=2 and user_all!=0 ';
                break;
            case 'm': //月
                $dateField='date_sub(dt,interval day(dt)-1 day)';
                $where_temp = ' and period=3 and user_all!=0 ';
                break;
            default: //日
                $dateField='dt';
                $where_temp = ' and period=0 and user_all!=0 ';
        };
        $where_2.=$where_temp;
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        $tableSql =$sql. $groupBy . $orderBy;
        $tableSql= vsprintf($tableSql, array($dateField,$where_1, $where_2)); //替换where
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $tableSql = preg_replace('/u.model/', '\'全部 \' as model', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) {
            $tableSql = preg_replace('/u.pro_version/', '\'全部 \' as pro_version', $tableSql, 1); //只替换一次

        }
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $where_1 = $this->getWhere($params,false,false);//2个表联查 线形图第一个表的where
            $where_2 =$this->getWhere($params,false,true). $where_temp;
            $lineSql = vsprintf($sql, array($dateField,$where_1, $where_2)); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;


    }

    /**
     * 在途时间人数分布
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getOnLineTimeUser($params = array(), $isDownload = false){
        $tableSql='select
                        dt
                        ,pro_version
                        ,model
                        ,round(travel_time_all/3600,2) as num
                    from dm_orange_stats_hotel_air_month
                   %s
                    group by
                        dt
                        ,pro_version
                        ,model
                         ORDER BY  dt';
        $where=$this->getWhere($params,true,false);
        $tableSql=sprintf($tableSql,$where);
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $maxSql='select  travel_time_all
                      from dm_orange_stats_hotel_air_month_detail
                      where  travel_time_all=(select max( travel_time_all) from dm_orange_stats_hotel_air_month_detail )';
            $getMax=$this->query($maxSql);
            $getMax=round($getMax[0]['travel_time_all']/3600);//字段单位为秒 取小时
            if(empty($getMax)){ //  获取航段最大值
                return;//没有数据
            }

            $min = $params['min']=='' ? 1 : $params['min']; //最小值
            $max = $params['max']=='' ?  $getMax : $params['max']; //最大值
            $max = $getMax< $max ? $getMax : $max;//最大值

            if($max<$min){
                return;//没有数据
            }
            $where = sprintf('where dt=\'%s\' ',$params['starttime']);
            if($max == $min){ //最大最小值相等
                $sectionSql ="'".$min."-".$max."'"." as section  '1' as  section_num";
                $where.= "and  travel_time_all = ".($max*3600)." ";

            }
            if($max > $min){
                $maxBetween= $max-$min;//  分段 默认最大分段 最大值减最小值每段为1
                if($params['between']==''){
                    $between=$maxBetween;
                }else{//分段数比最大分段数大采用最大分段数
                    $between= $maxBetween >= $params['between'] ? $params['between'] : $maxBetween;
                }
                $sectionSql='case  %s  end as section , case  %s  end as section_num';
                $one=intval(($max-$min)/$between);//每段数量
                $tempSql='';//分段标记
                $tempSql2='';//第几段标记 排序用
                for($i=$min;$i<=$max;$i+=$one){ //根据最大最小值分段的值 循环出分段的sql
                    if($i==$min){
                        $tempSql.=" when  travel_time_all>=".($i*3600)." and  travel_time_all<= ".(($i+$one)*3600) ." then '".$i."-".($i+$one) ."' ";
                        $tempSql2.=" when  travel_time_all>=".($i*3600)." and  travel_time_all<= ".(($i+$one)*3600) ." then ".$i." ";
                    }
                    else{
                        if($i+$one < $max){
                            $tempSql.=" when  travel_time_all>".($i*3600)."  and  travel_time_all<= ".(($i+$one)*3600) ." then '".$i."-".($i+$one) ."' ";
                            $tempSql2.=" when  travel_time_all>".($i*3600)."  and  travel_time_all<= ".(($i+$one)*3600) ." then ".$i." ";

                        }else{
                            $tempSql.=" else '".$i."-".$max."'";
                            $tempSql2.=" else ".$i." ";
                            break;
                        }
                    }
                }
                $sectionSql=vsprintf($sectionSql,array($tempSql,$tempSql2));
                $where.=" and  travel_time_all >= ".($min*3600)." and  travel_time_all <=" .($max*3600)."  ";

            }

            $lineSql='select
                        dt
                        ,%s
                        ,count(1) as num
                    from dm_orange_stats_hotel_air_month_detail
                   %s
                    group by
                        dt
                        ,section
                    order by
                      section_num asc
                    ';
            $lineSql=vsprintf($lineSql,array($sectionSql,$where));
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;
    }

    /**
     * 人均数用次数
     * @param  array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getAvgUseNum($params = array(), $isDownload = false){
       $sql='select
                    u.dt
                    ,u.pro_version
                    ,u.model
                    ,round(use_count/user_all,2) as num
                from (
                    select
                        %s as dt1
                        ,pro_version
                        ,model
                        ,sum(use_times_all) as use_count
                    from dm_orange_stats_funccard_use_times
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
                        ,user_all
                    from dm_orange_stats_funccard_user
                  %s

                ) as u
                on u.dt=c.dt1
                    and u.pro_version=c.pro_version
                    and u.model=c.model ';
        $where_1=$this->getWhere($params,true,true);
        $where_2=$this->getWhere($params);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'd3': //三日
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),3) day)',$params['starttime']) ;
                $where_temp = sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0  and user_all!=0 ', $params['starttime']);
                break;
            case 'w': //周
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'2017-05-01\'),7) day)',$params['starttime']);
                $where_temp = ' and period=2 and user_all!=0 ';
                break;
            case 'm': //月
                $dateField='date_sub(dt,interval day(dt)-1 day)';
                $where_temp = ' and period=3 and user_all!=0 ';
                break;
            default: //日
                $dateField='dt';
                $where_temp = ' and period=0 and user_all!=0 ';
        };
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        $tableSql =$sql. $groupBy . $orderBy;
        $tableSql= vsprintf($tableSql, array($dateField,$where_1, $where_2.$where_temp)); //替换where
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $tableSql = preg_replace('/u.model/', '\'全部 \' as model', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) {
            $tableSql = preg_replace('/u.pro_version/', '\'全部 \' as pro_version', $tableSql, 1); //只替换一次

        }
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $where_1 = $this->getWhere($params,false,true);//2个表联查 线形图第一个表的where
            $where_2 =$this->getWhere($params,false,true). $where_temp;
            $lineSql = vsprintf($sql, array($dateField,$where_1, $where_2)); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }

    /**
     * 行程卡返回通用where条件的数组
     * @param array $params 查询参数
     * @param boolean $type true 为加上软硬件版本条件 false 不加 线形图不带软硬件版本条件
     * @param boolean $isCardType true 多表查询时 不需要默认卡类型参数
     * @return array
     * */
    private function getWhere($params, $type = true, $isCardType = true)
    {
        $where = [];
        $whereValues = [];
        if ($type  &&  (null != $params['sv'] || null != $params['hv'] ) ) {
            //软件版本
            if ( null == $params['sv']) {
                $whereValues['pro_version'] = 'all';
                $where['pro_version'] = ' pro_version != "%s"';

            } else {
                $channelArr = $params['sv'];
                if (count($channelArr) > 1) { //值只有一个用 where =  多个用where in
                    $valStr = "";
                    foreach ($channelArr as $val) {
                        $valStr .= '"' . $val . '",';
                    }
                    $where['pro_version'] = ' pro_version in (%s)';
                    $valStr = rtrim($valStr, ',');
                    $whereValues['pro_version'] = $valStr;
                } else {
                    $whereValues['pro_version'] = $params['sv'][0];
                    $where['pro_version'] = ' pro_version = "%s"';
                }
            }

            //硬件版本
            if ( null == $params['hv']) {
                $whereValues['model'] = 'all';
                $where['model'] = ' model != "%s"';
            } else {
                $channelArr = $params['hv'];
                if (count($channelArr) > 1) {
                    $valStr = "";
                    foreach ($channelArr as $val) {
                        $valStr .= '"' . $val . '",';
                    }
                    $where['model'] = '  model in (%s)';
                    $valStr = rtrim($valStr, ',');
                    $whereValues['model'] = $valStr;
                } else {
                    $whereValues['model'] = $params['hv'][0];
                    $where['model'] = '  model = "%s"';
                }
            }
        } else {
            $whereValues['pro_version'] = 'all';
            $where['pro_version'] = ' pro_version = "%s"';
            $whereValues['model'] = 'all';
            $where['model'] = ' model = "%s"';

        }

        //时间
        $where[] = 'dt >= "%s"'; //开始日期
        $whereValues[] = $params['starttime'];
        $where[] = 'dt <= "%s"';//结束日期
        $whereValues[] = $params['endtime'] . ' 23:59:59';
        //默认卡类型 行程卡 为9
        if ($isCardType) {
            $where[] = 'module = "%s"';
            $whereValues[] = '9';
        }

        $where = ' WHERE ' . join(' AND ', $where);
        $whereStr = vsprintf($where, $whereValues);
        return $whereStr;

    }



}
/*EOF*/


