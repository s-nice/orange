<?php
namespace Model\OrderManage;
use \Think\Model;
class PostServiceDb extends Model
{
    public $timezone = "%s";
    // tp的构造函数
    public function _initialize() {
        $this->connection = C('APPADMINDB_EMAIL');
    }

    /**
     * 邮寄服务订单列表
     * params array $params 搜索条件
     * return array
     *
     * */
     public function getPostList($params=array()){
         $sql='SELECT a.id ,a.create_time AS createtime,c.mobile AS clientid,a.order_no AS orderNum ,a.status,
                       b.real_name AS name
               FROM `service_order_detail` AS a
               LEFT JOIN `account_basic_detail` AS b ON a.client_id=b.user_id
               LEFT JOIN `account_basic` AS c ON a.client_id=c.user_id
              ';
         $where=[];
         if(isset($params['orderNum'])){
             $where[]='  a.order_no='.sprintf('\'%s\'',$params['orderNum']);

         }
         if(isset($params['status'])){
             $where[]=' a.status='.$params['status'];

         }
         if(isset($params['userid'])){
             $where[]=' c.mobile='.sprintf('\'%s\'',$params['userid']);//‘账号id 为手机号’

         }
         if(isset($params['username'])){
             $where[]=' b.real_name='.sprintf('\'%s\'',$params['username']);

         }
         if(isset($params['createtime'])){
             $where[]=' a.create_time BETWEEN '.$params['createtime'];

         }
         $where = implode(' and ', $where);
         $where = $where!='' ? ' WHERE '.$where :'';
         $sqlNumFound = 'SELECT COUNT(a.id) AS numfound
               FROM `service_order_detail` AS a
               LEFT JOIN `account_basic_detail` AS b ON a.client_id=b.user_id
               LEFT JOIN `account_basic` AS c ON a.client_id=c.user_id
             '.$where;
         $numFound = $this->query($sqlNumFound);
         $numFound=$numFound[0]['numfound'];
         $orderby=$params['sort']=='asc' ? ' ORDER BY createtime asc' : ' ORDER BY createtime desc';
         $limit=' LIMIT '.$params['start'].','.$params['rows'];
         $sql=$sql.$where.$orderby.$limit;
         $list=$info = $this->query($sql);
         $res=array(
             'numfound'=>$numFound,
             'list'=>$list

         );
         return $res;

     }

    /**
     * 邮寄服务订单列表详情
     * params str $id  详情订单的id
     * return array
     *
     * */
    public function getPostDetail($id){
        $res=array('status'=>'fail');
        if (isset($id)){
            $sql='SELECT
                            a.id,
                            a.order_no AS orderNum,
                            /* 订单号*/
                            a.create_time AS createtime,
                            /* 创建时间*/
                            c.mobile AS userid,
                            /*用户id*/
                            b.real_name AS username,
                            /*用户名*/
                            a.received_quantity AS number,
                            /*收到数量*/
                            f.receipt_time,
                            /*收货时间*/
                            a.complete_quantity AS complete_number,
                            /*实际完成数量*/
                            a.fail_quantity AS fail_number,
                            /*失败数量*/
                            a. STATUS,
                            /*订单状态*/
                            a.update_time AS updatetime,
                            /*更新时间*/
                            a.serviceend_time,
                           /*服务完成时间*/
                            a.express_name,
                            /*快递公司名称*/
                            a.express_no,
                            /*快递单号*/
                            a.is_return,
                            /*是否回寄名片*/
                            a.is_share,
                            /*是否数据共享*/
                            e.name AS to_name,
                            /*收件人？*/
                            e.mobile_phone,
                            /*联系电话？*/
                            e.address,
                           /*地址*/
                           group_concat(d.mobilephone) AS share_ids
                          /*共享账号多个逗号隔开*/
                        FROM
                            `service_order_detail` AS a
                        LEFT JOIN `account_basic_detail` AS b ON a.client_id = b.user_id
                        LEFT JOIN `account_basic` AS c ON a.client_id = c.user_id
                        LEFT JOIN `service_share` AS d ON a.id = d.orderDetail_id
                        LEFT JOIN `service_address` AS e ON a.address_id = e.id
                        LEFT JOIN `service_backstage_order` AS f ON a.order_no = f.order_no
                        WHERE
                            a.id = ';
            $list=$this->query($sql.$id);
            if(!empty($list)){
                $res['status']=0;
                $res['list']=$list[0];
            }
        }
        return $res;
    }
}