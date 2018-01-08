<?php
namespace Model\User;
use \Think\Model;
/*
 * admin 个人用户管理
 * @author wuzj
 * @date   2016年9月29日
 */

class User extends Model
{
    // 时区转换 utc 0:00 北京 8:00
    public $timezone_add = 'unix_timestamp(convert_tz( "%s" , "+08:00","+00:00"))';
    public $timezone_red = 'unix_timestamp(convert_tz( "%s" , "-08:00","+00:00"))';
    public $timezone = 'unix_timestamp(convert_tz( "%s" , "+00:00","+00:00"))';
    public function _initialize()
    {
        //设置数据库配置：运营后台库
        $this->connection = C('APPADMINDB');
    }

    /*
     * 获取交易评价列表
     * */
    public function getUserCommentList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'create_time':
                                $orderby = " e.create_time ".$v;
                                break;
                            case 'end_time':
                                $orderby = " o.end_time ".$v;
                                break;
                            default:
                                $orderby = " e.create_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_id':
                    $where []= " o.to_userid='".$val."' ";
                    break;
                case 'create_time':
                    $ctime = explode(',',$val);
                    $where[] = 'e.create_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'e.create_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'mobile':
                    $where []= " o.user_account='".$val."' ";
                    break;
                case 'realname':
                    $where []= " o.user_name='".$val."' ";
                    break;
                case 'order_id':
                    $where []= " o.order_id='".$val."' ";
                    break;
                case 'type':
                    $where []= " e.type='".$val."' ";
                    break;
                default:

                    break;
            }
        }

        $sql = "SELECT
                       e.order_id,e.user_id,e.type,e.create_time,
                       o.order_id,o.end_time,o.user_name,o.user_account
                FROM
                     basic_order_eval as e
                     left join basic_order as o
                          on e.order_id = o.order_id
                WHERE ";
        $where = implode(' and ', $where);
        $where = empty($where) ? ' e.status=1 ' : $where.' and e.status=1 ';

        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;
        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "SELECT count(e.order_id) as nber
                FROM basic_order_eval as e
                     left join basic_order as o
                          on e.order_id = o.order_id
                WHERE ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }

    /*
     * 获取消费记录列表
     * */
    public function getUserConsumeList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'create_time':
                                $orderby = " create_time ".$v;
                                break;
                            case 'end_time':
                                $orderby = " end_time ".$v;
                                break;
                            default:
                                $orderby = " end_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_id':
                    $where []= " user_id='".$val."' ";
                    break;
                case 'end_time':
                    $ctime = explode(',',$val);
                    $where[] = 'end_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'end_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'payment':
                    $where []= " payment='".$val."' ";
                    break;
                case 'type':
                    $where []= " type='".$val."' ";
                    break;
                default:

                    break;
            }
        }

        $sql = "select
                       id,type,order_id,price,user_id,end_time,payment,trade_no
                from
                     basic_order
                where ";
        $where = implode(' and ', $where);
        $where = empty($where) ? ' status>1 ' : $where.' and status>1 ' ;

        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;
        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(id) as nber

                from basic_order
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }




}