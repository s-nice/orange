<?php

namespace Model\Orange;

use \Think\Model;

class OraStatAirLine extends Model
{

    protected $localTimeZone = "+08:00"; // 用作SQL时间转换
    protected $limit = 20;
    /**
     * 飞常准 获取列表数据统计(推动和调用)
     * @params  array 查询参数
     * return array
     * */
    public function getData($params = array())
    {
        $timeField=$params['type']=='pull' ? 'created_time' : 'custom_time' ; //根据查询类型（推送或调用）获取相关时间字段
        $where = [];
        if (isset($params['startTime'])) {
            $where[] = vsprintf('date(date_add(from_unixtime(%s), interval 8 hour))  >=  \'%s\'',array($timeField,$params['startTime']));

        }

        if (isset($params['endTime'])) {
            $where[] = vsprintf('date(date_add(from_unixtime(%s), interval 8 hour)) <=  \'%s\'',array($timeField,$params['endTime']));

        }

        if($params['type']=='push'){ //推送数据统计 ifcustom=1
            $where[] = 'ifcustom=1';

        }
        $where = implode(' AND ', $where);

        switch ($params['timeType']) {
            case 'threeDay': //日期区间类型为3日
                $dateSql = vsprintf(
                    'date_sub(date(date_add(from_unixtime(%1$s), interval 8 hour)),
                     interval mod(datediff(date(date_add(from_unixtime(%1$s), interval 8 hour)),\'%2$s\'),3) day)as date_index',
                    array($timeField,$params['startTime'])
                );//选择时间类型
                break;
            case  'week': //周
                $dateSql = vsprintf('date_sub(date(date_add(from_unixtime(%1$s), interval 8 hour)),
		                  interval mod(datediff(date(date_add(from_unixtime(%1$s), interval 8 hour)), \'%2$s\'),7) day) AS date_index' ,
                    array($timeField,$params['startTime'])
                );
                break;
            case 'month': //月
                $dateSql = sprintf('date_sub(date(date_add(from_unixtime(%s), interval 8 hour)),
		                   interval day(date(date_add(from_unixtime(%1$s), interval 8 hour)))-1 day) as date_index',$timeField);
                break;
            default://默认为天
                $dateSql =sprintf( 'date(date_add(from_unixtime(%s), interval 8 hour)) as date_index',$timeField);
                break;

        }
        $sql = 'Select ' . $dateSql .
               ' ,sum(if((ncount=1 and fcategory=0),1,0)) as nostopDomestic #国内不经停
                ,sum(if((ncount>1 and fcategory=0),3,0)) as stopDomestic #国内经停
                ,sum(if((ncount=1 and fcategory=0),1,0))
                    +sum(if((ncount>1 and fcategory=0),3,0)) as domestic #国内
                ,sum(if((ncount=1 and fcategory>=1 and fcategory<=4),1,0)) as nostopInter #国际不经停
                ,sum(if((ncount>1 and fcategory>=1 and fcategory<=4),3,0)) as stopInter #国际经停
                ,sum(if((ncount=1 and fcategory>=1 and fcategory<=4),1,0))
                    +sum(if((ncount>1 and fcategory>=1 and fcategory<=4),3,0)) as inter #国际
                ,sum(if(fcategory=5,1,0)) as unknown #未知
                from dm_orange_stats_flight_center
                where ' . $where . ' GROUP BY date_index ORDER BY date_index ASC';
        $list = $info = $this->query($sql);
        if (count($list) > 0) {
            return array(
                'status' => 0,
                'list' => $list
            );
        } else {
            return array(
                'status' => 1
            );

        }
    }


    /**
     * 飞常准 获取数据统计详情（推送和调用）
     * @params  array 查询参数
     * return array
     * */
    public function getDetail($params)
    {
        $timeField=$params['type']=='pull' ? 'created_time' : 'custom_time' ; //根据查询类型（推送或调用）获取相关时间字段
        $where = [];
        if($params['type']=='push'){ //推送数据统计 ifcustom=1
            $where[] = ' ifcustom=1';
        }
        if (isset($params['startTime'])) {  //开始结束时间
            $where[] =vsprintf('date(date_add(from_unixtime(%s), interval 8 hour)) >= \'%s\'',array($timeField,$params['startTime']));

        }

        if (isset($params['endTime'])) {
            $where[] = vsprintf('date(date_add(from_unixtime(%s), interval 8 hour)) <=  \'%s\'',array($timeField,$params['endTime'] . ' 23:59:59'));

        }
        if (isset($params['flight_num'])) { //航班号
            $where[] = 'fnum = ' . sprintf('\'%s\'', $params['flight_num']);

        }
        if (isset($params['goff_date'])) { //出发日期
            $where[] = 'fdate = ' . sprintf('\'%s\'', $params['goff_date']);

        }
        if (isset($params['is_stop'])) { //是否经停

            $where[] =  $params['is_stop']==1 ? ' ncount != 1 ' : ' ncount = 1 ' ;

        }
        if (isset($params['legType'])) { //航断 航段 （0:国内-国内;1国内-国际;2国内-地区;3:地区-国际;4:国际-国际;5:未知）
            switch ($params['legType']) {
                case 1: //国内
                    $where[] = 'fcategory = 0';
                    break;
                case 2: //国际
                    $where[] = 'fcategory in (1,4)';
                    break;
                case 3://未知
                    $where[] = 'fcategory =5';
                    break;
                default:
                    //no do
            }

        }
        $where = implode(' AND ', $where);
        $select=sprintf('select
                         date_add(from_unixtime(%s), interval 8 hour) as dt
                        ,fnum as flight_num
                        ,fdate as goff_date
                        ,case
                            when fcategory=0 then \'国内\' #国内
                            when fcategory>=1 and fcategory<=4 then \'国际\' #国际
                            else \'unknow\'  #未知
                        end as leg
                        ,case
                            when  ncount=1 then \'不经停\'
                            else \'经停\'
                        end as isStop',$timeField);
        $sql = $select.' from dm_orange_stats_flight_center
               where ' . $where.' ORDER BY dt';
        $list = $info = $this->query($sql);
        if (count($list) > 0) {
            return array(
                'status' => 0,
                'list' => $list
            );
        } else {
            return array(
                'status' => 1,
            );
        }
    }




}