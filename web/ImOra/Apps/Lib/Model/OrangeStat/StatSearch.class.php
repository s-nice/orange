<?php
/**
 * orange 统计 系统卡model
 *
 * */
namespace Model\OrangeStat;

use \Think\Model;

class StatSearch extends Model
{

    /**
     * 搜索用户数 和 搜索次数
     * @param array $params 查询参数
     * @param int $type 类型2为搜索用户数 1为搜索次数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function searchNum($params = array(),$type=1,$isDownload = false){
        $sql='select
                    dt
                    ,platform as model
                    ,proversion as pro_version
                    ,search_num_all as num
                    ,search_number_text  as num1 #文本
                    ,search_number_voice as num2 #语音
                from dm_app_stats_search
                 %s
              ';
        $where=$this->getWhere($params);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'w': //周
                $where_temp = ' and period=2  ';
                break;
            case 'm': //月
                $where_temp = ' and period=3  ';
                break;
            default: //日
                $where_temp = ' and period=0  ';
        };
        $where_temp.= 'and type='.$type.' ';
        $where=$where.$where_temp;
        $groupBy = ' group BY dt,platform,proversion ';
        $orderBy = 'order by dt';
        $tableSql =$sql. $groupBy . $orderBy;
        $tableSql= sprintf($tableSql,$where); //替换where
        if (empty($params['hv']) || null == $params['hv']) { //系统平台全部时
            $tableSql = preg_replace('/platform/', '\'全部 \' ', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) { //软件版本全部
            $tableSql = preg_replace('/proversion/', '\'全部 \' ', $tableSql, 1); //只替换一次

        }
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $where_line = $this->getWhere($params,false);//2个表联查 线形图第一个表的where
            $where_line.=$where_temp;
            $lineSql = sprintf($sql, $where_line); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }

    /**
     * 搜索用户数 和 搜索次数
     * @param array $params 查询参数
     * @param int $type 类型2为搜索用户数 1为搜索次数
     * @param  boolean $isDownload  是否是下载表格 默认false (下载表格只导出表格数据)
     * @return array
     * */
    public function avgsearchNum($params = array(),$isDownload = false){
        $sql='select
                     dt
                    ,platform as model
                    ,proversion as pro_version
                    ,sum(if(type=1,search_number_text,0))/sum(if(type=2,search_num_all,0)) as num1 #文本
                    ,sum(if(type=1,search_number_voice,0))/sum(if(type=2,search_num_all,0)) as num2 #语音
                     ,sum(if(type=1,search_number_text,0))/sum(if(type=2,search_num_all,0))+
                     sum(if(type=1,search_number_voice,0))/sum(if(type=2,search_num_all,0))as num #总数
                from dm_app_stats_search
                 %s
              ';
        $where=$this->getWhere($params);
        switch ($params['period']) { //根据 日 3日 周 月 不同类型 组装where
            case 'w': //周
                $where_temp = ' and period=2  ';
                break;
            case 'm': //月
                $where_temp = ' and period=3  ';
                break;
            default: //日
                $where_temp = ' and period=0  ';
        };
        $where_temp.= 'and search_num_all!=0 ';
        $where=$where.$where_temp;
        $groupBy = ' group BY dt,platform,proversion ';
        $orderBy = 'order by dt';
        $tableSql =$sql. $groupBy . $orderBy;
        $tableSql= sprintf($tableSql,$where); //替换where
        if (empty($params['hv']) || null == $params['hv']) { //系统平台全部时
            $tableSql = preg_replace('/platform/', '\'全部 \' ', $tableSql, 1); //只替换一次

        }
        if (empty($params['sv']) || null == $params['sv']) { //软件版本全部
            $tableSql = preg_replace('/proversion/', '\'全部 \' ', $tableSql, 1); //只替换一次

        }
        $res = array();
        $res['tableData'] = $this->query($tableSql);//表格数据
        if ($isDownload === false) { //不导出 显示页面 线形图查询 不要 软硬件版本条件
            $where_line = $this->getWhere($params,false);//2个表联查 线形图第一个表的where
            $where_line.=$where_temp;
            $lineSql = sprintf($sql, $where_line); //替换where
            /*线形图sql 组装*/
            $lineSql = $lineSql . ' group by dt ' . $orderBy;
            $res['lineData'] = $this->query($lineSql);
        }
        return $res;

    }


    /**
     * 通用where条件的数组
     * @param array $params 查询参数
     * @param boolean $type true 为加上软硬件版本条件 false 不加 线形图不带软硬件版本条件
     * @return array
     * */
    private function getWhere($params, $type = true)
    {
        $where = [];
        $whereValues = [];
        if ($type ) {
            //软件版本
            if ( null == $params['sv']) {
                $whereValues['proversion'] = 'all';
                $where['pro_version'] = ' proversion = "%s"';

            } else {
                $channelArr = $params['sv'];
                if (count($channelArr) > 1) { //值只有一个用 where =  多个用where in
                    $valStr = "";
                    foreach ($channelArr as $val) {
                        $valStr .= '"' . $val . '",';
                    }
                    $where['proversion'] = ' proversion in (%s)';
                    $valStr = rtrim($valStr, ',');
                    $whereValues['proversion'] = $valStr;
                } else {
                    $whereValues['proversion'] = $params['sv'][0];
                    $where['proversion'] = ' proversion = "%s"';
                }
            }

            //系统平台
            if ( null == $params['hv']) {
                $whereValues['platform'] = 'all';
                $where['platform'] = ' platform = "%s"';
            } else {
                $channelArr = $params['hv'];
                if (count($channelArr) > 1) {
                    $valStr = "";
                    foreach ($channelArr as $val) {
                        $valStr .= '"' . $val . '",';
                    }
                    $where['platform'] = '  platform in (%s)';
                    $valStr = rtrim($valStr, ',');
                    $whereValues['platform'] = $valStr;
                } else {
                    $whereValues['platform'] = $params['hv'][0];
                    $where['platform'] = '  platform = "%s"';
                }
            }
        }else{
            $whereValues['proversion'] = 'all';
            $where['pro_version'] = ' proversion = "%s"';
            $whereValues['platform'] = 'all';
            $where['platform'] = ' platform = "%s"';
        }

        //时间
        $where[] = 'dt >= "%s"'; //开始日期
        $whereValues[] = $params['starttime'];
        $where[] = 'dt <= "%s"';//结束日期
        $whereValues[] = $params['endtime'] . ' 23:59:59';
        $where = ' WHERE ' . join(' AND ', $where);
        $whereStr = vsprintf($where, $whereValues);
        return $whereStr;

    }

}
/*EOF*/


