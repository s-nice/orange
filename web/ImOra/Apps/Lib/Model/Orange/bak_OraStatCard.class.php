<?php
namespace Model\Orange;

use Model\OrangeStat\OrangeStatBase;
use Appadmin\Controller\AdminBaseController;
use Zend\Validator\Between;

class OraStatCard extends OrangeStatBase
{
    private $indexArr = array('d'=>'%Y %j','w'=>'%x %v','m'=>'%Y %c');
    public $to_tz   = '+08:00';
    public $from_tz = '+00:00';

    //根据查询日/3日/周/月 种类 处理日期(添加名片用户数，添加他人名片数)
    private function getFormat($startTime,$date_type,$stat_type=1){

        switch ($stat_type.'-'.$date_type) {
            case '1-0':
                $table = "dm_orange_stats_card_source";
                $dt = "dt";
                $column = "add_card_user";
                $where = "";
                break;
            case '1-1':
                $table = "dm_orange_stats_period_add_card_user";
                $dt = "dt";
                $column = "add_card_user";
                $where = " and period_type=1 and mod(datediff(dt,'$startTime'),3)=0 ";
                break;
            case '1-2':
                $table = "dm_orange_stats_period_add_card_user";
                $dt = "dt";
                $column = "add_card_user";
                $where = " and period_type=2 ";
                break;
            case '1-3':
                $table = "dm_orange_stats_period_add_card_user";
                $dt = "dt";
                $column = "add_card_user";
                $where = " and period_type=3 ";
                break;
            case '4-0':
                $table = "dm_orange_stats_card_source";
                $dt = "dt";
                $column = "add_other_card";
                $where = "";
                break;
            case '4-1':
                $table = "dm_orange_stats_card_source";
                $dt = "date_sub(dt,interval mod(datediff(dt,'$startTime'),3) day)";
                $column = "add_other_card";
                $where = "";
                break;
            case '4-2':
                $table = "dm_orange_stats_card_source";
                $dt = "date_sub(dt,interval mod(datediff(dt,'$startTime'),7) day)";
                $column = "add_other_card";
                $where = "";
                break;
            case '4-3':
                $table = "dm_orange_stats_card_source";
                $dt = "date_sub(dt,interval day(dt)-1 day)";
                $column = "add_other_card";
                $where = "";
                break;
            default:
                break;
        }
        return array('table'=>$table,'dt'=>$dt,'column'=>$column,'where'=>$where);
    }
    /**
     * 累计拥有他人名片用户数量1
     * @param array $params 搜索条件
     * @param number $dataType 1：tabArr 2：all
     * @return multitype:boolean \Think\mixed
     */
    public function getHasOtherCardUserNum($params,$dataType = 2){
        $where = array();
        $select='SELECT dt as time';
        if(isset($params['software']) || isset($params['hardware'])){ //软硬件版本设置其中之一
            if(isset($params['software'])){ //软件版本
                $where[] = 'pro_version in'.sprintf('(\'%s\')',implode("','",$params['software']));
                $select.=',pro_version as software';
            }else{
                $where[] =  "pro_version != 'all' ";
                $select.=",'全部' as software";
            }
            if(isset($params['hardware'])){ //硬件版本
                $where[] = 'model in'.sprintf('(\'%s\')',implode("','",$params['hardware']));
                $select.=',model as hardware';
            }else{
                $where[] =  "model != 'all' ";
                $select.=",'全部' as hardware";
            }
        }else{ //都不设置 为 all
            $where[] =  "pro_version = 'all' ";
            $select.=",'全部' as software";
            $where[] =  "model = 'all' ";
            $select.=",'全部' as hardware";

        }

        $whereStr=$whereLineStr= "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        empty($where) || ($whereStr .= ' and '.implode(' and ', $where));
        $orderBy=' ORDER BY time ASC';
        $tabSql =$select.
            ',own_other_user as usernum
					 FROM dm_orange_stats_card_acu '
            .$whereStr.' GROUP BY time,model,pro_version'.$orderBy;

        $tabArr = $this->query($tabSql);
        $lineArr =  array();
        if($dataType!=1){
            $lineSql = 'SELECT dt as time,own_other_user as usernum
     			        FROM dm_orange_stats_card_acu '
                .$whereLineStr. '
     			         AND pro_version = \'all\' and model = \'all\' GROUP BY time'.$orderBy;
            $lineArr = $this->query($lineSql);
        }
        return array('tabArr'=>$tabArr,'lineArr'=>$lineArr);
    }
    /**
     * 添加名片用户数量 1  和 添加他人名片数量
     */
    public function getAddCardUserNum($params,$isAll=false){
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
        $format = $this->getFormat($params['startTime'],$params['date_type'],$params['stat_type']);
        $table = $format['table'];
        $dt = $format['dt'];
        $column = $format['column'];
        $where = $format['where'];

        $sql = "SELECT
                        $dt as dtime,
                        pro_version as s_versions,
                        model as h_versions,
                        SUM(if(card_from=0,$column,0)) as total,
                        SUM(if(card_from=1,$column,0)) as camera_app,
                        SUM(if(card_from=2,$column,0)) as imora,
                        SUM(if(card_from=3,$column,0)) as qrcode,
                        SUM(if(card_from=4,$column,0)) as input,
                        SUM(if(card_from=5,$column,0)) as exchange_app,
                        SUM(if(card_from=6,$column,0)) as import,
                        SUM(if(card_from=7,$column,0)) as scanner_app,
                        SUM(if(card_from=8,$column,0)) as scanner_imora,
                        SUM(if(card_from=9,$column,0)) as yao,
                        SUM(if(card_from=10,$column,0)) as peng,
                        SUM(if(card_from=11,$column,0)) as mail,
                        SUM(if(card_from=12,$column,0)) as exchange,
                        SUM(if(card_from=13,$column,0)) as sys,
                        SUM(if(card_from=14,$column,0)) as other
                    FROM
                        $table
                    WHERE
                            (dt between '$startTime' AND '$endTime')
                        AND pro_version IN $s_versions
                        AND model IN $h_versions $where
                    GROUP BY
                        dt,
                        pro_version,
                        model
                    ORDER BY dt,pro_version,model";
        //echo $sql;die;
        $data = $this->query($sql);
        return $data;
    }
    /**
     * 累计人均他人名片数量 2
     * @param array $params 搜索条件
     * @param number $dataType 1：tabArr 2：line 3：all
     * @return array 符合条件的结果
     */
    public function getTotalAddOtherCardNum($params,$dataType = 3){
        $sql = "SELECT DATE_FORMAT(`dt`,'%Y-%m-%d') as timetype,pro_version,model,sum(other_card)/sum(own_other_user) as average_value ";
        $sql .= "
            from
                dm_orange_stats_others_card
            where
                dt between   '".$params['startTime']."' and '".$params['endTime']."'";

        if( !empty($params['s_versions']) ){
            $params['pro_version'] = explode(',',$params['s_versions']);
            $params['pro_version'] = implode("','",$params['pro_version']);
            $sql .= " and `pro_version` in('".$params['pro_version']."')  ";
        }
        if( !empty($params['h_versions']) ){
            $params['model'] = explode(',',$params['h_versions']);
            $params['model'] = implode("','",$params['model']);
            $sql .= " and `model` in('".$params['model']."')  ";
        }

        $sql .= ' group by timetype ';

        //获取列表数据
        if( !empty($params['s_versions']) ) $sql .= " ,pro_version ";
        if( !empty($params['h_versions']) ) $sql .= " ,model ";
        $sql .= "  order by dt asc";
        $result['data'] = $this->query($sql);

        return $result;
    }
    /**
     * 累计人均我的名片数量 3
     */
    public function getTotalAddOurCardNum($params){
        $sql = "SELECT
           DATE_FORMAT(`dt`,'%Y-%m-%d') as timetype,pro_version,model,
           sum(case when card_from='vcard' then mycard  else 0 end ) as sum_vcard_mycard,
           sum(case when card_from='scan' then mycard  else 0 end ) as sum_scan_mycard,
           sum(case when card_from='vcard' then mycard_owner  else 0 end ) as sum_vcard_mycard_owner,
           sum(case when card_from='scan' then mycard_owner  else 0 end ) as sum_scan_mycard_owner,
           sum(mycard) as ave_mycard,
           sum(mycard_owner) as ave_mycardowner ";
        $sql .= "
            from
                dm_orange_stats_card_group
            where
                dt between   '".$params['startTime']."' and '".$params['endTime']."' and card_from in('scan','vcard') and source_type='orange'";

        if( !empty($params['s_versions']) ){
            $params['pro_version'] = explode(',',$params['s_versions']);
            $params['pro_version'] = implode("','",$params['pro_version']);
            $sql .= " and `pro_version` in('".$params['pro_version']."')  ";
        }
        if( !empty($params['h_versions']) ){
            $params['model'] = explode(',',$params['h_versions']);
            $params['model'] = implode("','",$params['model']);
            $sql .= " and `model` in('".$params['model']."')  ";
        }
        $sql .= ' group by timetype ';

        //获取列表数据
        if( !empty($params['s_versions']) ) {
            $sql .= " ,pro_version ";
        }
        if( !empty($params['h_versions']) ) {
            $sql .= " ,model ";
        }
        $sql .= "  order by dt asc";
        $result['data'] = $this->query($sql);

        return $result;
    }

    /**
     * 累计名片数 5
     * @param array $params 搜索条件
     * @param number $dataType 1：tabArr 2：all
     * @return multitype:boolean \Think\mixed
     */
    public function getCardNurNum($params,$dataType = 2){
        $where = array();
        $select='SELECT dt as time';
        if(isset($params['software']) || isset($params['hardware'])){ //软硬件版本设置其中之一
            if(isset($params['software'])){ //软件版本
                $where[] = 'pro_version in'.sprintf('(\'%s\')',implode("','",$params['software']));
                $select.=',pro_version as software';
            }else{
                $where[] =  "pro_version != 'all' ";
                $select.=",'全部' as software";
            }
            if(isset($params['hardware'])){ //硬件版本
                $where[] = 'model in'.sprintf('(\'%s\')',implode("','",$params['hardware']));
                $select.=',model as hardware';
            }else{
                $where[] =  "model != 'all' ";
                $select.=",'全部' as hardware";
            }

        }else{ //都不设置 为 all
            $where[] =  "pro_version = 'all' ";
            $select.=",'全部' as software";
            $where[] =  "model = 'all' ";
            $select.=",'全部' as hardware";

        }

        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        empty($where) || ($whereTableStr =$whereStr. ' and '.implode(' and ', $where));
        $groupBy=' group by dt,pro_version ,model ';
        $orderBy=' ORDER BY time ASC';
        $tabSql =$select.
            ',sum(if(card_from=0,card_total,0)) as usernum
                ,sum(if(card_from=1,card_total,0)) as num1
                ,sum(if(card_from=2,card_total,0)) as num2
                ,sum(if(card_from=3,card_total,0)) as num3
                ,sum(if(card_from=4,card_total,0)) as num4
                ,sum(if(card_from=5,card_total,0)) as num5
                ,sum(if(card_from=6,card_total,0)) as num6
                ,sum(if(card_from=7,card_total,0)) as num7
                ,sum(if(card_from=8,card_total,0)) as num8
                ,sum(if(card_from=9,card_total,0)) as num9
                ,sum(if(card_from=10,card_total,0)) as num10
                ,sum(if(card_from=11,card_total,0)) as num11
                ,sum(if(card_from=12,card_total,0)) as num12
                ,sum(if(card_from=13,card_total,0)) as num13
                ,sum(if(card_from=14,card_total,0)) as num14
            from dm_orange_stats_card_source '.$whereTableStr.$groupBy.$orderBy;

        $tabArr = $this->query($tabSql);
        $lineArr =  array();
        if($dataType!=1){
            $lineSql = 'SELECT dt as time,sum(if(card_from=0,card_total,0)) as usernum
     			        FROM dm_orange_stats_card_source '
                .$whereStr." and  model='all' and pro_version = 'all'
     			        GROUP BY time".$orderBy;
            $lineArr = $this->query($lineSql);
        }
        return array('tabArr'=>$tabArr,'lineArr'=>$lineArr);
    }

    /**
     * 当月累计添加名片数 6
     * @param array $params 搜索条件
     * @param number $dataType 1：tabArr 2：all
     * @return multitype:boolean \Think\mixed
     */
    public function getAddCardNumMonth($params,$dataType = 2){
        $where = array();
        $select='SELECT dt as time';
        if(isset($params['software']) || isset($params['hardware'])){ //软硬件版本设置其中之一
            if(isset($params['software'])){ //软件版本
                $where[] = 'pro_version in'.sprintf('(\'%s\')',implode("','",$params['software']));
                $select.=',pro_version as software';
            }else{
                $where[] =  "pro_version != 'all' ";
                $select.=",'全部' as software";
            }
            if(isset($params['hardware'])){ //硬件版本
                $where[] = 'model in'.sprintf('(\'%s\')',implode("','",$params['hardware']));
                $select.=',model as hardware';
            }else{
                $where[] =  "model != 'all' ";
                $select.=",'全部' as hardware";
            }

        }else{ //都不设置 为 all
            $where[] =  "pro_version = 'all' ";
            $select.=",'全部' as software";
            $where[] =  "model = 'all' ";
            $select.=",'全部' as hardware";

        }

        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        empty($where) || ($whereTableStr =$whereStr. ' and '.implode(' and ', $where));
        $groupBy=' group by dt,pro_version ,model ';
        $orderBy=' ORDER BY time ASC';
        $tabSql =$select.
            ',sum(if(card_from=0,card_month_accumulate,0)) as usernum
                ,sum(if(card_from=1,card_month_accumulate,0)) as num1
                ,sum(if(card_from=2,card_month_accumulate,0)) as num2
                ,sum(if(card_from=3,card_month_accumulate,0)) as num3
                ,sum(if(card_from=4,card_month_accumulate,0)) as num4
                ,sum(if(card_from=5,card_month_accumulate,0)) as num5
                ,sum(if(card_from=6,card_month_accumulate,0)) as num6
                ,sum(if(card_from=7,card_month_accumulate,0)) as num7
                ,sum(if(card_from=8,card_month_accumulate,0)) as num8
                ,sum(if(card_from=9,card_month_accumulate,0)) as num9
                ,sum(if(card_from=10,card_month_accumulate,0)) as num10
                ,sum(if(card_from=11,card_month_accumulate,0)) as num11
                ,sum(if(card_from=12,card_month_accumulate,0)) as num12
                ,sum(if(card_from=13,card_month_accumulate,0)) as num13
                ,sum(if(card_from=14,card_month_accumulate,0)) as num14
            from dm_orange_stats_card_source '.$whereTableStr.$groupBy.$orderBy;

        $tabArr = $this->query($tabSql);
        $lineArr =  array();
        if($dataType!=1){
            $lineSql = 'SELECT dt as time,sum(if(card_from=0,card_month_accumulate,0)) as usernum
     			        FROM dm_orange_stats_card_source '
                .$whereStr." and  model='all' and pro_version = 'all'
     			        GROUP BY time".$orderBy;
            $lineArr = $this->query($lineSql);
        }
        return array('tabArr'=>$tabArr,'lineArr'=>$lineArr);
    }

    /**
     * 名片交换次数 7
     * @param array $params 搜索条件
     * @param number $dataType 1：tabArr 2：all
     * @return multitype:boolean \Think\mixed
     */
    public function getSwitchCardNum($params,$dataType = 2){
        $where = array();
        $select='SELECT %s as time ';
        switch($params['date_type']){//时间类型
            case 1://3日
                $select=sprintf($select,sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),3) day)',$params['startTime']));
                break;
            case 2://周
                $select=sprintf($select,sprintf('date_sub(dt,interval mod(datediff(dt,\'%s\'),7) day)',$params['startTime']));
                break;
            case 3://月
                $select=sprintf($select,'date_sub(dt,interval day(dt)-1 day)');
                break;
            default: //日
                $select=sprintf($select,'dt');

        }


        if(isset($params['software']) || isset($params['hardware'])){ //软硬件版本设置其中之一
            if(isset($params['software'])){ //软件版本
                $where[] = 'pro_version in'.sprintf('(\'%s\')',implode("','",$params['software']));
                $select.=',pro_version as software';
            }else{
                $where[] =  "pro_version != 'all' ";
                $select.=",'全部' as software";
            }
            if(isset($params['hardware'])){ //硬件版本
                $where[] = 'model in'.sprintf('(\'%s\')',implode("','",$params['hardware']));
                $select.=',model as hardware';
            }else{
                $where[] =  "model != 'all' ";
                $select.=",'全部' as hardware";
            }

        }else{ //都不设置 为 all
            $where[] =  "pro_version = 'all' ";
            $select.=",'全部' as software";
            $where[] =  "model = 'all' ";
            $select.=",'全部' as hardware";

        }
        $select.=',sum(if(card_from=3,card_exchanged,0))
                            +sum(if(card_from=5,card_exchanged,0))
                            +sum(if(card_from=9,card_exchanged,0))
                            +sum(if(card_from=10,card_exchanged,0))
                            +sum(if(card_from=12,card_exchanged,0))
                            +sum(if(card_from=13,card_exchanged,0)) as num ';
        $select_table=$select.
            ',sum(if(card_from=3,card_exchanged,0)) as num1
                        ,sum(if(card_from=5,card_exchanged,0)) as num2
                        ,sum(if(card_from=9,card_exchanged,0)) as num3
                        ,sum(if(card_from=10,card_exchanged,0)) as num4
                        ,sum(if(card_from=12,card_exchanged,0)) as num5
                        ,sum(if(card_from=13,card_exchanged,0)) as num6
                    from dm_orange_stats_card_source
                    ';

        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        empty($where) || ($whereTableStr =$whereStr. ' and '.implode(' and ', $where));
        $groupBy=' group by time,pro_version ,model ';
        $orderBy=' ORDER BY time ASC';
        $tabSql =$select_table.$whereTableStr.$groupBy.$orderBy;
        $tabArr = $this->query($tabSql);
        $lineArr = array();
        if($dataType!=1){
            $lineSql = $select.' from dm_orange_stats_card_source '
                .$whereStr." and  model='all' and pro_version = 'all'
     			        GROUP BY time".$orderBy;
            $lineArr = $this->query($lineSql);
        }
        return array('tabArr'=>$tabArr,'lineArr'=>$lineArr);

    }

    //将版本字符串改成('','')格式，方便in查询
    private function versionsToStr($versions){
        $arr = explode(',', $versions);
        $str = implode('\',\'', $arr);
        $str = '(\''.$str.'\')';
        return $str;
    }
}
