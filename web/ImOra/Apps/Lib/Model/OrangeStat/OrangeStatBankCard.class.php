<?php
namespace Model\OrangeStat;
use Model\OrangeStat\OrangeStatBase;
class OrangeStatBankCard extends OrangeStatBase
{

    //根据查询日/3日/周/月 种类 处理日期
    private function getFormat($startTime,$date_type){
        switch ($date_type) {
            case '1':
                $format = "date_sub(dt,interval mod((datediff(dt,'$startTime')),3) day)";
                break;
            case '2':
                $format = "date_sub(dt,interval mod(datediff(dt,'$startTime'),7) day)"; //周
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
        $date_type = isset($params['date_type'])?$params['date_type']:0;
        //$format = $this->getFormat($startTime,$date_type);
        if($isAll){
            //$verArr = $this->getAllVersions();
            $s_versions = "('all')";
            $h_versions =  "('all')";
        }else{
            $s_versions = $this->versionsToStr($params['s_versions']);
            $h_versions = $this->versionsToStr($params['h_versions']);
        }
        switch ($params['stat_type']) {
            case '0':
                $sql = "SELECT 
                            dt dtime,
                            pro_version s_versions,
                            model h_versions,
                            user_total,
                            user_swipe_num,
                            user_no_swipe_num,
                            user_mode_num,
                            user_no_mode_num
                        FROM
                            dm_orange_stats_funccard_accumulate_user
                        WHERE
                            (dt BETWEEN '$startTime' AND '$endTime')
                        AND pro_version in $s_versions
                        AND model in $h_versions
                        AND module='89'
                        ORDER BY
                            dt,pro_version,model";
                break;
            case '1':
                $sql = "SELECT
                            u.dt dtime,
                            u.pro_version s_versions,
                            u.model h_versions,
                            c.card_all_num/u.user_total as  num
                        FROM
                            (SELECT
                                dt,
                                pro_version,
                                model,
                                card_all_num
                            FROM
                                dm_orange_stats_funccard_accumulate_card
                            WHERE
                                (dt BETWEEN '$startTime' AND '$endTime')
                            AND pro_version in $s_versions
                            AND model in $h_versions
                            AND module='89'
                            ) as c
                        RIGHT JOIN
                            (SELECT
                                dt,
                                pro_version,
                                model,
                                user_total
                            FROM
                                dm_orange_stats_user
                            WHERE
                                (dt BETWEEN '$startTime' AND '$endTime')
                            AND pro_version in $s_versions
                            AND model in $h_versions
                            AND user_total!=0
                            ) as u
                        ON
                            u.dt = c.dt
                        AND u.pro_version = c.pro_version
                        AND u.model = c.model
                        HAVING not ISNULL(num)
                        ORDER BY dtime,s_versions,h_versions";
                break;
            case '2'://	人均使用次数
                $sql='select
                            u.dt dtime
                            ,u.pro_version  s_versions
                            ,u.model h_versions
                            ,use_count/user_all as  num
                        from (
                            select
                                %s as dt1
                                ,pro_version
                                ,model
                                ,%s as use_count
                            from dm_orange_stats_funccard_use_times
                            WHERE
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
                            WHERE
                            %s
                        ) as u
                        on u.dt=c.dt1
                            and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                            dtime,s_versions,h_versions';
                $whereStr='
                	pro_version in %s
                    and model in %s
                    and dt between \'%s\' and \'%s\'
                    and module=\'89\'';
                $whereStr_1=vsprintf($whereStr,array($s_versions,$h_versions,$startTime,$endTime));//替换
                $whereStr_2=$whereStr_1.' and period='.$date_type.'  and user_all!=0 ';
                if($date_type==1){ //3日独有条件
                    $whereStr_2.='and mod(datediff(dt,\''.$startTime.'\'),3)=0 ';
                }
                $use_count=$date_type == 0 ? 'use_times_all' : 'sum(use_times_all)' ; //被除数
               $sql=vsprintf($sql,array($this->getFormat($startTime,$date_type),$use_count,$whereStr_1,$whereStr_2));//替换
               break;
            case '3'://4.	使用用户数
                     $sql='select
                                dt dtime
                                ,pro_version s_versions
                                ,model  h_versions
                                ,user_all user_total
                                ,user_swipe_num
                                ,user_no_swipe_num
                                ,user_mode_num
                                ,user_no_mode_num
                            from dm_orange_stats_funccard_user
                            where
                               %s
                            order by
                                dt
                                ,pro_version
                                ,model';
                     $whereStr=' pro_version in %s
                                and model in %s
                                and dt between \'%s\' and \'%s\'
                                and module=\'89\'
                                and period=%s';
                     $whereStr = vsprintf($whereStr,array($s_versions,$h_versions,$startTime,$endTime,$date_type));
                if($date_type==1){ //3日独有条件
                    $whereStr.=' and mod(datediff(dt,\''.$startTime.'\'),3)=0 ';
                }
                     $sql=sprintf($sql,$whereStr);
                break;
            case '4'://单次消费金额
                $sql='select
                            dt dtime
                            ,pro_version s_versions
                            ,model  h_versions
                            ,consume_num/real_consume_time num
                        from dm_orange_stats_bankcard_calculate
                        where
                           %s
                        order by
                            dt
                            ,pro_version
                            ,model';
                $whereStr=' pro_version in %s
                                and model in %s
                                and dt between \'%s\' and \'%s\'
                                and period=%s
                                 and real_consume_time!=0';
                $whereStr = vsprintf($whereStr,array($s_versions,$h_versions,$startTime,$endTime,$date_type));
                if($date_type==1){ //3日独有条件
                    $whereStr.=' and mod(datediff(dt,\''.$startTime.'\'),3)=0 ';
                }
                $sql=sprintf($sql,$whereStr);
                break;
            case '5': //总消费次数和人均消费次数
                $sql='select
                            dt dtime
                            ,pro_version  s_versions
                            ,model h_versions
                            ,consume_time as num #总
                            ,round(consume_time/consume_person,2) as avg #人均
                        from dm_orange_stats_bankcard_calculate
                        where
                        %s
                        order by
                            dt
                            ,pro_version
                            ,model';
                    $whereStr=' pro_version in %s
                                        and model in %s
                                        and dt between \'%s\' and \'%s\'
                                        and period=%s
                                         and consume_person!=0';
                    $whereStr = vsprintf($whereStr,array($s_versions,$h_versions,$startTime,$endTime,$date_type));
                    if($date_type==1){ //3日独有条件
                        $whereStr.=' and mod(datediff(dt,\''.$startTime.'\'),3)=0 ';
                    }
                    $sql=sprintf($sql,$whereStr);
                break;
            case '6':
                $sql='select
                        dt dtime
                        ,pro_version s_versions
                        ,model h_versions
                        ,accum_num num
                    from dm_orange_stats_bankcard_accumulate
                    where
                        pro_version in %s
                        and model in %s
                        and dt between \'%s\' and \'%s\'
                    order by
                        dt
                        ,pro_version
                        ,model';
                $sql=vsprintf($sql,array($s_versions,$h_versions,$startTime,$endTime));
                break;
            case '7':
                $sql='select
                        dt dtime
                        ,pro_version s_versions
                        ,model  h_versions
                        ,binding_page_num  num #进入绑卡流程
                        ,binding_succ_num  bind #成功绑定
                    from dm_orange_stats_bankcard_calculate
                    where
                      %s
                    order by
                        dt
                        ,pro_version
                        ,model';
                $whereStr=' pro_version in %s
                                        and model in %s
                                        and dt between \'%s\' and \'%s\'
                                        and period=%s ';
                $whereStr = vsprintf($whereStr,array($s_versions,$h_versions,$startTime,$endTime,$date_type));
                if($date_type==1){ //3日独有条件
                    $whereStr.=' and mod(datediff(dt,\''.$startTime.'\'),3)=0 ';
                }
                $sql=sprintf($sql,$whereStr);
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

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }

}