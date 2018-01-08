<?php
namespace Model\Orange;

use \Think\Model;

class OraStatScheduleCard extends Model
{
   // protected $localTimeZone = "+08:00"; // 用作SQL时间转换
    //protected $limit = 20;


    /**
     * orange-统计-日程卡用户数
     * $params array 查询参数
     * return array
     * */

    public function getUserNum($params=array()){
        $selectLine=$selectTable='SELECT dt first_date';
        $groupBy= ' GROUP BY first_date';
        $where = [];
        if(isset($params['pro_version']) || isset($params['model']) ){
            if (isset($params['pro_version'])) { //软件版本
                // 只有一个 用where = 多个用where in
                $where['pro_version']=count($params['pro_version']) > 1 ?
                    '  pro_version in ' . sprintf('(\'%s\')',implode("','",$params['pro_version'])) :
                    '  pro_version=' . sprintf('\'%s\'', $params['pro_version'][0]);
                $groupBy.=',pro_version';
                $selectTable.=',pro_version';
            }else{
                $where['pro_version']=' pro_version!=\'all\'';
                $selectTable.=',\'全部\' as pro_version ';
            }

            if (isset($params['model'])) { //硬件版本
                $where['model']=count($params['model']) > 1 ?
                    '  model in ' . sprintf('(\'%s\')',implode("','",$params['model'])) :
                    '  model=' . sprintf('\'%s\'', $params['model'][0]);
                $groupBy.=',model';
                $selectTable.=',model';

            }else{
                $where['model']=' model!=\'all\'';
                $selectTable.=',\'全部\' as model' ;
            };
        }else{
            $where['pro_version']=' pro_version =\'all\'';
            $selectTable.=',\'全部\' as pro_version ';
            $where['model']=' model=\'all\'';
            $selectTable.=',\'全部\' as model' ;

        }
        if (isset($params['startTime']) && isset($params['endTime'])) {//创建时间区间
            $where[] = ' dt BETWEEN ' . sprintf('\'%s\'',$params['startTime']). ' AND ' . sprintf('\'%s\'',$params['endTime']);
        };

        switch($params['timeType']){
            case 'threeDay': //日期区间类型为3日
                $selectLine.=',SUM(vals) num ';
                $selectTable.=',SUM(vals) num ';
                $fromStr='FROM dm_orange_stats_three_day';
                $where[]=' field = 1';
                $where[]=' detail = 0';
                $where[]= ' module = 3';
                $where[]=sprintf(' mod(datediff(dt,\'%s\'),3)=0',$params['startTime']);
                $where[]= ' vals!=0 ';
                break;
            case  'week': //周
                $selectLine.=',SUM(vals) num ';
                $selectTable.=',SUM(vals) num ';
                $fromStr='FROM  dm_orange_stats_week';
                $where[]=' field = 1';
                $where[]=' detail = 0';
                $where[]= ' module = 3';
                $where[]= ' vals!=0 ';
                break;
            case 'month': //月
                $selectLine.=',SUM(vals) num ';
                $selectTable.=',SUM(vals) num ';
                $fromStr='FROM  dm_orange_stats_month';
                $where[]=' field = 1';
                $where[]=' detail = 0';
                $where[]= ' module = 3';
                $where[]= ' vals!=0 ';
                break;
            default://默认为天
                $selectLine.=',SUM(see_user) num ';
                $selectTable.=',SUM(see_user) num ';
                $fromStr='FROM  dm_orange_stats_schedule';
                $where[] =' see_user!=0 ';
                break;
        }

        $whereStr=' WHERE'.implode(' AND ', $where);
        $where['pro_version']=' pro_version!=\'all\'';
        $where['model']=' model!=\'all\'';
        $whereLineStr=' WHERE'.implode(' AND ', $where);//线形图Where不区分软硬件版本
        $orderBy=' ORDER BY first_date ASC';
        $sql=$selectTable.$fromStr.$whereStr.$groupBy.$orderBy;
        $tableData=$this->query($sql);//列表数据
        $res['tableData']=$tableData;
        if(!$params['downloadStat']){ //非导出
            $sql=$selectLine.$fromStr.$whereLineStr.' GROUP BY first_date '.$orderBy;
            $lineData=$this->query($sql);//折线图数据
            $res['lineData']=$lineData;
        }
        return $res ;

    }

     public function getAvgUsedNum($params=array()){
         //按日查询 select
         $select_day='SELECT
                    dt  first_date,
                    pro_version,
                    model,
                    case see_user when 0 then 0  else  ROUND(use_count/see_user,2) end num';

         //3天、周、月 select
         $select='SELECT
                  u.dt  first_date,
                  u.model,
                  u.pro_version,
                  case u.date_active_user when 0 then 0 else  ROUND(c.date_use_count/u.date_active_user,2) end  num';
          //3天、周、月 sql
         $otherSql=' FROM
                    (
                    SELECT %s dt, model,pro_version, SUM(use_count) date_use_count
                    FROM dm_orange_stats_schedule
                    WHERE %s
                    GROUP BY %s,model, pro_version
                    )
                    c JOIN
                    (
                    SELECT
                    dt,model,pro_version,SUM(vals) date_active_user
                    FROM %s
                    WHERE
                    %s AND
                    module = 3 AND
                    field = 1 AND
                    detail = 0
                    and vals!=0
                    GROUP BY %s,model, pro_version
                    ) u
                    ON c.dt = u.dt AND c.model = u.model AND c.pro_version = u.pro_version
                    WHERE u.date_active_user!= 0 AND u.date_active_user is not NULL
                   ';
         $where = [];
         $groupBy='GROUP BY u.dt';
         if(!empty($params['pro_version']) || !empty($params['model'])){
             if (isset($params['pro_version'])) { //软件版本
                 // 只有一个 用where = 多个用where in
                 $where['pro_version']=count($params['pro_version']) > 1 ?
                     '  pro_version in ' . sprintf('(\'%s\')',implode("','",$params['pro_version'])) :
                     '  pro_version=' . sprintf('\'%s\'', $params['pro_version'][0]);
                 $groupBy.=',u.pro_version';
             }else{
                 if($params['timeType']=='day'){
                     $select_day=str_replace("pro_version","'全部' pro_version ",$select_day);
                 }else{
                     $select=str_replace("u.pro_version","'全部' pro_version",$select);
                 }
                 $where['pro_version']=  '  pro_version!=\'all\'';
             };
             if (isset($params['model'])) { //硬件版本
                 $where['model']=count($params['model']) > 1 ?
                     '  model in ' . sprintf('(\'%s\')',implode("','",$params['model'])) :
                     '  model=' . sprintf('\'%s\'', $params['model'][0]);
                 $groupBy.=',u.model';

             }else{
                 if($params['timeType']=='day'){
                     $select_day=str_replace("model","'全部' model ",$select_day);
                 }else{
                     $select=str_replace("u.model","'全部' model",$select);
                 }
                 $where['model']=  '  model!=\'all\'';
             };

         }else{
             if($params['timeType']=='day'){
                 $select_day=str_replace("pro_version","'全部' pro_version ",$select_day);
             }else{
                 $select=str_replace("u.pro_version","'全部' pro_version",$select);
             }
             $where['pro_version']=  '  pro_version=\'all\'';
             if($params['timeType']=='day'){
                 $select_day=str_replace("model","'全部' model ",$select_day);
             }else{
                 $select=str_replace("u.model","'全部' model",$select);
             }
             $where['model']=  '  model=\'all\'';

         }

         if (isset($params['startTime']) && isset($params['endTime'])) {//创建时间区间
             $where[] = ' dt BETWEEN ' . sprintf('\'%s\'',$params['startTime']). ' AND ' . sprintf('\'%s\'',$params['endTime']);;

         }

         $whereStr= implode(' AND ', $where);//表格数据where
         $where['pro_version']=' pro_version=\'all\'';//线形图Where不区分软硬件版本
         $where['model']=' model=\'all\'';
         $whereLineStr = implode(' AND ', $where);
         switch($params['timeType']){
             case 'threeDay': //日期区间类型为3日
                 $dateSql=sprintf('DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,\'%s\'),3) DAY) ',$params['startTime']);//选择时间类型
                 $tableOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereStr,
                     $dateSql,
                     'dm_orange_stats_three_day',
                     $whereStr.' AND' .sprintf(' (MOD(DATEDIFF(dt,\'%s\'),3) = 0 )',$params['startTime']),
                     $dateSql,
                 ));
                 $lineOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereLineStr,
                     $dateSql,
                     'dm_orange_stats_three_day',
                     $whereLineStr.' AND' .sprintf(' (MOD(DATEDIFF(dt,\'%s\'),3) = 0 )',$params['startTime']),
                     $dateSql
                 ));
                 $tableSql=$select.$tableOtherSql;
                 $lineSql=$select.$lineOtherSql;
                 break;
             case  'week': //周
                 $dateSql=sprintf('DATE_SUB(dt,INTERVAL MOD(DATEDIFF(dt,\'%s\'),7) DAY)  ',$params['startTime']);//选择时间类型
                 $tableOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereStr,
                     $dateSql,
                     'dm_orange_stats_week',
                     $whereStr.' AND' .sprintf('(MOD(DATEDIFF(dt,\'%s\'),7) = 0 )',$params['startTime']),
                     $dateSql,
                 ));
                 $lineOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereLineStr,
                     $dateSql,
                     'dm_orange_stats_week',
                     $whereLineStr.' AND' .sprintf('(MOD(DATEDIFF(dt,\'%s\'),7) = 0 )',$params['startTime']),
                     $dateSql,
                 ));
                 $tableSql=$select.$tableOtherSql;
                 $lineSql=$select.$lineOtherSql;
                 break;
             case 'month': //月
                 $dateSql='DATE_ADD(dt,interval -day(dt)+1 day) ';//选择时间类型
                 $tableOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereStr,
                     'MONTH(dt)',
                     'dm_orange_stats_month',
                     $whereStr,
                     $dateSql,
                 ));
                 $lineOtherSql=vsprintf($otherSql,array(
                     $dateSql,
                     $whereLineStr,
                     'MONTH(dt)',
                     'dm_orange_stats_month',
                     $whereLineStr,
                     $dateSql,
                 ));
                 $tableSql=$select.$tableOtherSql;
                 $lineSql=$select.$lineOtherSql;
                 break;
             default://默认为天
                 $tableSql=$select_day.' FROM dm_orange_stats_schedule u WHERE '.$whereStr .' and see_user!=0 ';
                 $lineSql=$select_day.' FROM dm_orange_stats_schedule u WHERE '.$whereLineStr;
                 break;
         }

         $lineData=$params['downloadStat'] ? null :$this->query($lineSql.'GROUP BY u.dt'); //折线图数据,导出时不查询
         if($lineData && empty($params['pro_version']) && empty($params['model'])){ //软硬件版本都为全部
             $tableData=$lineData; //线形图 和 表格 数据一致
         }else{
             $tableData=$this->query($tableSql.$groupBy);//表格数据
         }
         $res=array(
             'lineData'=>$lineData,
             'tableData'=>$tableData
         );


         return $res;

     }


}