<?php
namespace Model\UserStatic;
use \Think\Model;

class UserStatic extends Model
{
    public function _initialize()
    {
        //设置数据库配置：运营后台库
        //$this->connection = C('APPADMINDB');
    }


    /*
     * 获取列表
     * */
    public function getDataList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = 'create_time desc';

        foreach($params as $key => $val){
            switch($key){
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'create_time':
                    if(!empty($val)) $where[] = ' create_time between '.$val;
                    break;
                case 'mobile':
                    $where []= " mobile like '%".$val."%' ";
                    break;
                case 'end_time':
                    $ctime = explode(',',$val);
                    $where[] = 'dt >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'dt <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'real_name':
                    $where []= " real_name like '%".$val."%' ";
                    break;
                default:

                    break;
            }
        }

        $sql = "select
                      id,userid,dt,mobile,real_name,use_times,use_time,create_time
                from
                     dm_orange_stats_use_status_detail
                where ";
        $where = implode(' and ', $where);
        $where = empty($where) ? ' 1=1 ' : $where ;

        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(id) as nber

                from dm_orange_stats_use_status_detail
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }




}