<?php
namespace Model\Orange;

use \Think\Model;
class OraStatEntranceGuard extends Model
{
    /*
     * 获取数据
     * $params sql 参数
     * */
    public function getDataStatM($params = array(),$type ){

        $result = array();
        switch($type){
            case '0':
                $result = $this->getDataSqlone($params);
                break;
            case '1':
                $result = $this->getDataSqltwo($params);
                break;
            case '2':
                $result = $this->getDataSqlthree($params);
                break;
            case '3':
                $result = $this->getDataSqlfour($params);
                break;
            default:
                $result = $this->getDataSqlone($params);
        }

        return $result;

    }

    public function getDataSqlone($params=array()){
        $sql = "select dt,pro_version,model,user_total as chartnumb ";

        $sql .= "
            from
                dm_orange_stats_funccard_accumulate_user
            where
                dt between  '".$params['timestart']."' and '".$params['timeend']."' and module='6' ";

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

        //获取地图数据
        $sql .= " group by dt ";
        $result['chartdata'] = $this->query($sql);

        //获取列表数据
        //$sql .= " ,dt ";
        if( !empty($params['pro_version']) || !empty($params['model']) ){
            if( !empty($params['pro_version']) ) $sql .= " ,pro_version ";
            if( !empty($params['model']) ) $sql .= " ,model ";
        }

        $sql .= "  order by dt asc";
        $result['listdata'] = $this->query($sql);

        return $result;
    }
    public function getDataSqltwo($params=array()){
        $sql = "select dt,pro_version,model,user_all as chartnumb from dm_orange_stats_funccard_user where ";

        $sql .= " dt between '".$params['timestart']."' and '".$params['timeend']."' and module='6' ";

        switch($params['date_type']){
            case '1':
                $sql .= "and period=1 and mod(datediff(dt,'".$params['timestart']."'),3)=0 ";
                break;
            case '2':
                $sql .= "and period=2";
                break;
            case '3':
                $sql .= "and period=3";
                break;
            default :
                $sql .= "and period=0";
                $params['date_type'] = 0;
        }

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
        $sql .= " group by dt ";
        $result['chartdata'] = $this->query($sql);

        //获取列表数据
        if( !empty($params['pro_version']) || !empty($params['model']) ){
            if( !empty($params['pro_version']) ) $sql .= " ,pro_version ";
            if( !empty($params['model']) ) $sql .= " ,model ";
        }

        $sql .= "  order by dt asc ";
        $result['listdata'] = $this->query($sql);

        return $result;
    }

    public function getDataSqlthree($params=array()){
        $sql = "select u.dt,u.pro_version,u.model,use_count/user_all as chartnumb from ( select ";
        switch($params['date_type']){
            case '1':
                $sql .= " date_sub(dt,interval mod(datediff(dt,'".$params['timestart']."'),3) day) as dt1 ";
                break;
            case '2':
                $sql .= " date_sub(dt,interval mod(datediff(dt,'".$params['timestart']."'),7) day) as dt1 ";
                break;
            case '3':
                $sql .= " date_sub(dt,interval day(dt)-1 day) as dt1 ";
                break;
            default :
                $sql .= " dt as dt1 ";
                $params['date_type'] = 0;
        }

        $sql .= ",pro_version,model,sum(use_times_all) as use_count from dm_orange_stats_funccard_use_times
	            where ";
        $sql .= " dt between '".$params['timestart']."' and '".$params['timeend']."' and module='6' ";
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

        $sql .=" group by dt1,pro_version,model ) as c right join ( select dt,pro_version,model,user_all from dm_orange_stats_funccard_user where";
        $sql .= " dt between '".$params['timestart']."' and '".$params['timeend']."' and module='6' and user_all!=0 ";
        //版本条件组装
        if( empty($params['pro_version']) && empty($params['model']) ){
            $sql .= " and `pro_version` = 'all' ";
            $sql .= " and `model` = 'all' ";
        }else{
            if( !empty($params['pro_version']) ){
                //$params['pro_version'] = explode(',',$params['pro_version']);
                //$params['pro_version'] = implode("','",$params['pro_version']);
                $sql .= " and `pro_version` in('".$params['pro_version']."')  ";
            }else{
                $sql .= " and `pro_version` <> 'all' ";
            }
            if( !empty($params['model']) ){
                //$params['model'] = explode(',',$params['model']);
                //$params['model'] = implode("','",$params['model']);
                $sql .= " and `model` in('".$params['model']."')  ";
            }else{
                $sql .= " and `model` <> 'all' ";
            }
        }

        switch($params['date_type']){
            case '1':
                $sql .= " and period=1 and mod(datediff(dt,'".$params['timestart']."'),3)=0 ";
                break;
            case '2':
                $sql .= " and period=2 ";
                break;
            case '3':
                $sql .= " and period=3 ";
                break;
            default :
                $sql .= " and period=0 ";
        }

        $sql .=") as u on u.dt=c.dt1 and u.pro_version=c.pro_version and u.model=c.model ";

        if($params['date_type']==1){
            $sql .= " and (MOD(DATEDIFF(dt,'".$params['timestart']."'),3)=0) ";
        }


        //获取地图数据
        $sql .= " group by dt ";
        $result['chartdata'] = $this->query($sql);

        //获取列表数据
        if( !empty($params['pro_version']) || !empty($params['model']) ){
            if( !empty($params['pro_version']) ) $sql .= " ,pro_version ";
            if( !empty($params['model']) ) $sql .= " ,model ";
        }

        $sql .= "  order by dt asc,model asc ";
        $result['listdata'] = $this->query($sql);

        return $result;
    }

    public function getDataSqlfour($params=array()){
        $sql = "select
                    u.dt,u.pro_version,u.model,card_all_num/user_total as chartnumb
                from (
                    select
                        dt,pro_version,model,card_all_num
                    from dm_orange_stats_funccard_accumulate_card
                    where ";

        $sql .= " dt between  '".$params['timestart']."' and '".$params['timeend']."' and module='6' ";

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

        $sql .=') as c right join (
                    select dt,pro_version,model,user_total
                    from dm_orange_stats_user
                    where ';
        $sql .= " dt between  '".$params['timestart']."' and '".$params['timeend']."' and user_total!=0 ";

        //版本条件组装
        if( empty($params['pro_version']) && empty($params['model']) ){
            $sql .= " and `pro_version` = 'all' ";
            $sql .= " and `model` = 'all' ";
        }else{
            if( !empty($params['pro_version']) ){
                //$params['pro_version'] = explode(',',$params['pro_version']);
                //$params['pro_version'] = implode("','",$params['pro_version']);
                $sql .= " and `pro_version` in('".$params['pro_version']."')  ";
            }else{
                $sql .= " and `pro_version` <> 'all' ";
            }
            if( !empty($params['model']) ){
                //$params['model'] = explode(',',$params['model']);
                //$params['model'] = implode("','",$params['model']);
                $sql .= " and `model` in('".$params['model']."')  ";
            }else{
                $sql .= " and `model` <> 'all' ";
            }
        }

        $sql .= ') as u on u.dt=c.dt and u.pro_version=c.pro_version and u.model=c.model ';


        //获取地图数据
        $sql .= " group by dt ";
        $result['chartdata'] = $this->query($sql);

        //获取列表数据
        //$sql .= " ,dt ";
        if( !empty($params['pro_version']) || !empty($params['model']) ){
            if( !empty($params['pro_version']) ) $sql .= " ,pro_version ";
            if( !empty($params['model']) ) $sql .= " ,model ";
        }

        $sql .= "  order by dt asc";
        $result['listdata'] = $this->query($sql);

        return $result;
    }


}