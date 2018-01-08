<?php
namespace Model\Finance;
use Model\Common\SQLModel;
class MailCard extends SQLModel
{
    // 时区转换 utc 0:00 北京 8:00
    public $timezone = 'unix_timestamp(convert_tz( "%s" , "+08:00","+00:00"))';
    public function _initialize()
    {
        //设置数据库配置：运营后台库
        $this->connection = C('APPADMINDB_EMAIL');
    }

    public function getList($params){
        $where = " where d.order_no!='' ";
        $limit = "";
        $order = "";
        if(isset($params['start'])&&isset($params['rows'])){
            $limit = " limit ".$params['start'].','.$params['rows']." ";
        }
        unset($params['start']);
        unset($params['rows']);
        foreach ($params as $key => $value) {
            if($key=='sort'){
                $isCreateTime = stripos($value,'create_time');
                if($isCreateTime===false){
                    $order = "order by i.".str_replace(',',' ',$value)." ";
                }else{
                    $order = "order by d.".str_replace(',',' ',$value)." ";
                }
            }elseif($key=='create_time'){
                $arr = explode(',',$value);
                $count = count($arr);
                if($count==1){
                    if ($arr[0]) {
                       $where .= " and d.$key>'".$arr[0]."' ";
                    }
                }elseif($count==2){
                    if ($arr[0]&&$arr[1]) {
                        $where .= " and d.$key>='".$arr[0]."' and d.$key<='".$arr[1]."' ";
                    }elseif(!$arr[0]&&$arr[1]){
                        $where .= " and d.$key<'".$arr[1]."' ";
                    }
                }

            }elseif($key=='mobile'){
                $where .= " and b.$key='$value' ";
            }elseif($key=='order_no'){
                $where .= " and d.$key='$value' ";
            }elseif($key=='real_name'){
                $where .= " and bd.$key='$value' ";
            }else{
                $where .= " and i.$key='$value' ";
            }
        }
        $sql = "select i.*,bd.real_name,b.mobile,d.order_no,d.create_time,d.payment_price price from `service_invoice` i LEFT JOIN `service_order_detail` d on i.id = d.invoice_id LEFT JOIN `account_basic` b on i.client_id=b.user_id LEFT JOIN `account_basic_detail` bd on i.client_id=bd.user_id ".$where.$order.$limit;
        $countSql = "select count(1) numfound from `service_invoice` i LEFT JOIN `service_order_detail` d on i.id = d.invoice_id LEFT JOIN `account_basic` b on i.client_id=b.user_id LEFT JOIN `account_basic_detail` bd on i.client_id=bd.user_id ".$where;
        $list = $this->query($sql);
        //$this->setLog($sql);
        //p($list);die;
        $re = $this->query($countSql);
        $numfound = $re[0]['numfound'];
        return array('list'=>$list,'numfound'=>$numfound);
    }


    //获取发票详情
    public function getData($id){
        $data = array();
        if($id){
            $sql = "select i.*,bd.real_name,b.mobile,d.order_no,d.payment_price price from `service_invoice` i LEFT JOIN `service_order_detail` d on i.id = d.invoice_id LEFT JOIN `account_basic` b on i.client_id=b.user_id LEFT JOIN `account_basic_detail` bd on i.client_id=bd.user_id where i.id='$id'";
            $list = $this->query($sql);
            if(sizeof($list)){
                $data = $list[0];
            }
        }
        return $data;
    }

    //修改发票
    public function setData($params){
        $this->tableName = 'service_invoice';
        $re = $this->save($params);
        return $re;
    }

    //获取手机号
    public function getMobile($id){
        $mobile = '';
        $sql = "select b.mobile from `service_invoice` i LEFT JOIN `account_basic` b on i.client_id = b.user_id where i.id='$id'";
        $list = $this->query($sql);
        if(sizeof($list)){
            $mobile = $list[0]['mobile'];
        }
        return $mobile;
    }
}