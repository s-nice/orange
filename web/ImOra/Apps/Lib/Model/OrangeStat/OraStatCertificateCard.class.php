<?php
/**
 * orange 统计 证件卡model
 *
 * */
namespace Model\OrangeStat;

use \Think\Model;

class OraStatCertificateCard extends Model
{
    /**
     * 拥有用户数
     * @param array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */

    public function getUserNum($params = array(), $isDownload = false)
    {
        $whereStr = $this->getWhere($params, true);//获取通用where条件
        $select = 'select dt ,pro_version ,model ,user_total as num ';
        $from = ' from dm_orange_stats_funccard_accumulate_user ';
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $select = str_replace('model', '\'全部 \' as model ', $select);
        }
        if (empty($params['sv']) || null == $params['sv']) {
            $select = str_replace('pro_version', '\'全部 \' as pro_version ', $select);
        }

        $res = array();
        $res['tableData'] = $this->query($select . $from . $whereStr . $groupBy . $orderBy);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $whereStr = $this->getWhere($params, false);
            $groupBy = ' group by dt  ';
            $sqlLine = 'select dt ,sum(user_total) as num ' . $from . $whereStr . $groupBy . $orderBy;
            $res['lineData'] = $this->query($sqlLine);
        }
        return $res;

    }

    /**
     * 查看用户数
     * @param array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */

    public function getLookNum($params = array(), $isDownload = false)
    {
        $sql = 'select
                    dt
                    ,pro_version
                    ,model
                    ,user_all as num
                from dm_orange_stats_funccard_user';
        $where = $this->getWhere($params, true);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'd3': //三日
                $where_temp = sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0 ', $params['starttime']);
                break;
            case 'w': //周
                $where_temp = ' and period=2 ';
                break;
            case 'm': //月
                $where_temp = ' and period=3 ';
                break;
            default: //日
                $where_temp = ' and period=0 ';
        };
        $where .= $where_temp;
        $groupBy = ' group by dt ,pro_version ,model ';
        $orderBy = 'order by dt';
        if (empty($params['hv']) || null == $params['hv']) { //软硬件版本为全部时
            $sql = str_replace('model', '\'全部 \' as model ', $sql);
        }
        if (empty($params['sv']) || null == $params['sv']) {
            $sql = str_replace('pro_version', '\'全部 \' as pro_version ', $sql);
        }
        $res = array();
        $res['tableData'] = $this->query($sql . $where . $groupBy . $orderBy);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $whereStr = $this->getWhere($params, false);
            $groupBy = ' group by dt  ';
            $sqlLine = $sql . $whereStr . $where_temp . $groupBy . $orderBy;
            $res['lineData'] = $this->query($sqlLine);
        }
        return $res;
    }

    /**
     * 累计人均身份卡数
     * @param array $params 查询参数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function getAvgUserNum($params = array(), $isDownload = false)
    {
        $sql = 'select
                    u.dt
                    ,u.pro_version
                    ,u.model
                    ,case
		                     when round(%s/user_total,2) IS NULL  then 0
                             else  round(%s/user_total,2)
                             end as num
                from (
                    select
                        dt
                        ,pro_version
                        ,model
                        ,%s
                    from dm_orange_stats_funccard_accumulate_card
                  %s
                ) as c
                right join (
                    select
                        dt
                        ,pro_version
                        ,model
                        ,user_total
                    from dm_orange_stats_user
                    %s
                ) as u
                on u.dt=c.dt
                    and u.pro_version=c.pro_version
                    and u.model=c.model
            ';
        if ($params['cardStatus'] == 'on') { //卡状态除数字段
            $cardStatusField = 'card_swipe_num'; //可刷
        } elseif ($params['cardStatus'] == 'disabled') {//不可刷
            $cardStatusField = 'card_no_swipe_num';
        } else {//总数
            $cardStatusField = 'card_all_num';
        }
        /*表格sql组装*/
        $tableSql = vsprintf($sql, array($cardStatusField, $cardStatusField, $cardStatusField, $this->getWhere($params, true),
            $this->getWhere($params, true, false) . ' and user_total!=0'));
        $groupBy = ' group by
                    dt
                    ,pro_version
                    ,model ';
        $orderBy = ' order by dt ';
        if ( null == $params['hv']) { //软硬件版本为全部时
            $tableSql = preg_replace('/u.model/', '\'全部 \' as model', $tableSql, 1); //只替换一次
        }
        if ( null == $params['sv']) {
            $tableSql = preg_replace('/u.pro_version/', '\'全部 \' as pro_version', $tableSql, 1); //只替换一次
        }
        $tableSql = $tableSql . $groupBy . $orderBy;
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            /*线形图sql 组装*/
            $lineSql = vsprintf($sql, array($cardStatusField, $cardStatusField, $cardStatusField, $this->getWhere($params, false),
                $this->getWhere($params, false, false) . 'and user_total!=0'));
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }

    /**人均使用数
     * @param array $params 查询参数
     * @param boolean  $isDownload   是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     **/
    public function getAvgUseNum($params = array(), $isDownload = false)
    {
        $sql = 'select
                    u.dt
                    ,u.pro_version
                    ,u.model
                    , round(use_count/user_all,2) as num
                from (
                    select
                           %s
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
                        and u.model=c.model
                    ';
        $where_1 = $this->getWhere($params, true);//2个表联查 第一个表的where
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装第二个表的where
            case 'd3': //三日
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),3) day) as dt1 ',$params['starttime']);
                $where_temp = sprintf(' and period=1 and mod(datediff(dt,\'%s\'),3)=0  and user_all!=0 ', $params['starttime']);
                break;
            case 'w': //周
                $dateField=sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),7) day) as dt1 ',$params['starttime']);
                $where_temp = ' and period=2 and user_all!=0 ';
                break;
            case 'm': //月
                $dateField='date_sub(dt,interval day(dt)-1 day) as dt1 ';
                $where_temp = ' and period=3 and user_all!=0 ';
                break;
            default: //日
                $dateField='dt  as dt1';
                $where_temp = ' and period=0 and user_all!=0 ';
        };
        $where_2 = $where_1 . $where_temp;
        $groupBy = ' group by
                    dt
                    ,pro_version
                    ,model ';
        $orderBy = ' order by dt ';
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
            $where_1 = $this->getWhere($params, false);//2个表联查 线形图第一个表的where
            $where_2 = $where_1 . $where_temp;
            $lineSql = vsprintf($sql, array($dateField,$where_1, $where_2)); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }

    /**
     * 证件卡返回通用where条件的数组
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
        //默认卡类型 证件卡 为8
        if ($isCardType) {
            $where[] = 'module = "%s"';
            $whereValues[] = '8';
        }

        $where = ' WHERE ' . join(' AND ', $where);
        $whereStr = vsprintf($where, $whereValues);
        return $whereStr;

    }

}

/*EOF*/


