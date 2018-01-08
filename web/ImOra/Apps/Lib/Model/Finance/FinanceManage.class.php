<?php
namespace Model\Finance;
use \Think\Model;
/*
 * admin 财务管理
 * @author wuzj
 * @date   2016年10月20日
 */

class FinanceManage extends Model
{
    // 时区转换 utc 0:00 北京 8:00
    public $timezone = 'unix_timestamp(convert_tz( "%s" , "+08:00","+00:00"))';
    public function _initialize()
    {
        //设置数据库配置：运营后台库
        $this->connection = C('APPADMINDB');
    }

    /*
     * 获取结算列表
     * */
    public function getList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'settlement_time':
                                $orderby = " o.settlement_time ".$v;
                                break;
                            case 'end_time':
                                $orderby = " o.end_time ".$v;
                                break;
                            default:
                                $orderby = " o.end_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_name':
                    $where []= " o.to_user_name like '%".$val."%' ";
                    break;
                case 'user_account':
                    $where []= " o.to_user_account like '%".$val."%' ";
                    break;
                case 'order_id':
                    $where []= " o.order_id like '%".$val."%' ";
                    break;
                case 'end_time':
                    $ctime = explode(',',$val);
                    $where[] = 'o.end_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'o.end_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'payment':
                    $where []= " o.payment='".$val."' ";
                    break;
                case 'status':
                    $where []= " o.status='".$val."' ";
                    break;
                default:

                    break;
            }
        }
        //订单状态 ：status = 9 or status = 10 or paystatus = 5 or paystatus = 6
        $where[] = '(o.status = 9 or o.status = 10 or o.paystatus = 5 or o.paystatus = 6) ';

        $sql = "select
                       o.id,o.type,o.order_id,o.price,o.user_id,o.to_userid,o.to_user_name,o.to_user_account,o.end_time,o.payment,o.status,o.paystatus,o.trade_no,o.settlement_time,d.bind_account
                from
                     basic_order as o left join account_basic_detail as d on o.to_userid = d.user_id
                where ";
        $where = implode(' and ', $where);
        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(o.id) as nber

                from basic_order as o
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }

    /*
     * 当日到期结算列表
     * */
    public function getDayList($params = array() ){
        $searchtime = date('Y-m-d',strtotime('-5 day')).' 23:59:59';
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'settlement_time':
                                $orderby = " o.settlement_time ".$v;
                                break;
                            case 'end_time':
                                $orderby = " o.end_time ".$v;
                                break;
                            default:
                                $orderby = " o.end_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_name':
                    $where []= " o.to_user_name like '%".$val."%' ";
                    break;
                case 'user_account':
                    $where []= " o.to_user_account like '%".$val."%' ";
                    break;
                case 'order_id':
                    $where []= " o.order_id like '%".$val."%' ";
                    break;
                case 'end_time':
                    $ctime = explode(',',$val);
                    $where[] = 'o.end_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'o.end_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'payment':
                    $where []= " o.payment='".$val."' ";
                    break;
                default:

                    break;
            }
        }
        //订单状态 ：status = 9
        $where[] ="(o.status = 9 or o.paystatus = 5) and o.end_time <= ".sprintf($this->timezone,$searchtime);

        $sql = "select
                       o.id,o.type,o.order_id,o.price,o.user_id,o.to_user_name,o.to_user_account,o.end_time,o.payment,o.status,o.trade_no,o.settlement_time,d.bind_account
                from
                     basic_order as o left join account_basic_detail as d on o.to_userid = d.user_id
                where ";
        $where = implode(' and ', $where);
        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(o.id) as nber

                from basic_order as o
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);
    }

    /*
     * 获取退款列表
     * */
    public function getRefundList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'modify_time':
                                $orderby = " o.modify_time ".$v;
                                break;
                            case 'end_time':
                                $orderby = " o.end_time ".$v;
                                break;
                            default:
                                $orderby = " o.end_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_name':
                    $where []= " o.user_name like '%".$val."%' ";
                    break;
                case 'user_account':
                    $where []= " o.user_account like '%".$val."%' ";
                    break;
                case 'order_id':
                    $where []= " o.order_id like '%".$val."%' ";
                    break;
                case 'trade_no':
                    $where []= " o.trade_no like '%".$val."%' ";
                    break;
                case 'end_time':
                    $ctime = explode(',',$val);
                    $where[] = 'o.end_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'o.end_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'payment':
                    $where []= " o.payment='".$val."' ";
                    break;
                case 'paystatus':
                    $where []= " o.paystatus='".$val."' ";
                    break;
                default:

                    break;
            }
        }
        //订单状态 ：paystatus = 3 or paystatus = 4
        $where[] = '(o.paystatus = 3 or o.paystatus = 4) ';

        $sql = "select
                      o.id,type,o.order_id,o.price,o.user_id,o.user_name,o.user_account,o.end_time,
                      o.payment,o.status,o.paystatus,o.trade_no,o.modify_time,
                      a.buyer
                from
                     basic_order as o left join basic_order_abnormal as a on o.order_id = a.order_id
                where ";
        $where = implode(' and ', $where);
        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);

        //数据量
        $sql = "select count(o.id) as nber

                from basic_order as o left join basic_order_abnormal as a on o.order_id = a.order_id
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }

    /*
     * 发票 - 找人业务 - 待开发票列表 个人发票
     * */
    public function getInvoiceList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'create_time':
                                $orderby = " i.create_time ".$v;
                                break;
                            case 'update_time':
                                $orderby = " i.update_time ".$v;
                                break;
                            default:
                                $orderby = " i.create_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_name':
                    $where []= " u.real_name like '%".$val."%' ";
                    break;
                case 'account_name':
                    //申请人id（手机号）
                    $where []= " a.mobile like '%".$val."%' ";
                    break;
                case 'invoice_numb':
                    //发票号
                    $where []= " i.invoice_numb like '%".$val."%' ";
                    break;
                case 'create_time':
                    $ctime = explode(',',$val);
                    $where[] = 'i.create_time >= '.$ctime[0];
                    $where[] = 'i.create_time <= '.$ctime[1];
                    break;
                case 'status':
                    $where []= " i.status='".$val."' ";
                    break;
                default:

                    break;
            }
        }
        //
        $where[] = ' role_type = 1 ';

        $sql = "select
                        i.id,i.invoice_id,i.email,i.user_id,i.amount,i.invoice_type,i.role_type,i.create_time,i.update_time,i.status,i.invoice_numb,u.real_name as uname,a.mobile as account_name
                from
                        admin_invoice_info as i left join account_basic as a on i.user_id=a.user_id left join account_basic_detail as u on a.user_id=u.user_id
                where ";
        $where = implode(' and ', $where);
        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(i.id) as nber

                from admin_invoice_info as i left join account_basic as a on i.user_id=a.user_id left join account_basic_detail as u on a.user_id=u.user_id
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }
    /*
     * 发票 - 找人业务 - 待开发票列表 企业发票
     * */
    public function getInvoiceCompList($params = array() ){
        $where = array();
        $limit = '';
        $orderby = array();

        foreach($params as $key => $val){
            switch($key){
                case 'sort':
                    foreach($val as $k=>$v){
                        switch($k) {
                            case 'create_time':
                                $orderby = " i.create_time ".$v;
                                break;
                            case 'update_time':
                                $orderby = " i.update_time ".$v;
                                break;
                            default:
                                $orderby = " i.create_time desc ";
                                break;
                        }
                    }
                    break;
                case 'start':
                    $limit = ' limit '.$val.','.$params['rows'].' ';
                    break;
                case 'user_name':
                    $where []= " u.biz_name like '%".$val."%' ";
                    break;
                case 'account_name':
                    $where []= " u.biz_email like '%".$val."%' ";
                    break;
                case 'invoice_numb':
                    $where []= " i.invoice_numb like '%".$val."%' ";
                    break;
                case 'create_time':
                    $ctime = explode(',',$val);
                    $where[] = 'i.create_time >= '.sprintf($this->timezone,$ctime[0]);
                    $where[] = 'i.create_time <= '.sprintf($this->timezone,$ctime[1]);
                    break;
                case 'status':
                    $where []= " i.status='".$val."' ";
                    break;
                default:

                    break;
            }
        }
        //
        $where[] = ' role_type = 2 ';
        //企业账号，user_name为邮箱，biz_name 企业名称。
        $sql = "select
                        i.id,i.invoice_id,i.email,i.user_id,i.amount,i.invoice_type,i.role_type,i.create_time,i.update_time,i.status,i.invoice_numb,u.biz_name as uname,u.biz_email as account_name
                from
                        admin_invoice_info as i left join account_biz_detail as u on i.user_id=u.biz_id
                where ";
        $where = implode(' and ', $where);
        $sql .= $where;

        $sql .= ' order by '.$orderby;

        $sql .= $limit;

        //select data
        $data = $this->query($sql);
        //数据量
        $sql = "select count(i.id) as nber

                from admin_invoice_info as i left join account_biz_detail as u on i.user_id=u.biz_id
                where ".$where;
        $countnumber = $this->query($sql);

        return array('data'=>$data,'findnumber'=>$countnumber[0]['nber']);

    }

    /*
     * 根据手机号获取user_id
     * */
    public function getUserId($mobile){
        $this->tableName = 'account_basic';
        $id = $this->where(array('mobile'=>$mobile))->getField('user_id');
        return $id;
    }

    /*
     * 保存申请开票
     * */
    public function saveInvoice($arr1,$arr2){
    	$modelDb = new \Model\OrderManage\OrderDb();
    	$total = $modelDb->getTotalAmountCanBeInvoiced($arr1['user_id'],$arr1['role_type'],$arr1['create_time']);
    	if($total<$arr1['amount']){
    		// 订单金额没那么多。 不能给开发票。 操作过程， 应该有订单用过了。
    		return array('status'=>1,'msg'=>$this->translator->str_invoice_order_used);
    	}else{
    		// 分配订单
    		$ordersList = $modelDb->getOrdersToBeInvoiced($arr1['amount'],$arr1['user_id'],$arr1['role_type'],$arr1['create_time']);
    		if (! $ordersList) {
    			$this->ajaxReturn(array('status'=>2,'msg'=>$this->translator->str_invoice_order_used));
    			// 订单金额没那么多。 不能给开发票。 操作过程， 应该有订单用过了。
    		}else{
    			$beforOrderList = $orderIds = array();
    			$totalAmount = $arr1['amount'];
    			foreach ($ordersList as $v)
    			{
    				// 计算订单本次开票金额；
    				$usedAmount = $totalAmount >= $v['left_amount'] ? $v['left_amount'] : $totalAmount;
    				// 计算本订单开出票后， 本张发票剩余金额
    				$totalAmount = $totalAmount-$usedAmount;
    				$orderIds[] = $v['order_id'];
    				$beforOrderList[] = array('order_id'=>$v['order_id'],'invoice_amount'=>$usedAmount,'left_amount'=>$v['left_amount']);
    			}
    			// 将符合条件的订单写入队列表
    			$modelDb->loadOrdersIntoInvoiceQueueByIds($orderIds,$arr1['role_type']);
    			
    			$orders = $modelDb->getOrdersToBeInvoiced($arr1['amount'], $arr1['user_id'],$arr1['role_type'],$arr1['create_time']);
    			if (! $orders) {
    				$this->ajaxReturn(array('status'=>2,'msg'=>$this->translator->str_invoice_order_used));
    				// 订单金额没那么多。 不能给开发票。 操作过程， 应该有订单用过了。
    			}
    			// 创建发票后，绑定发票和订单
    			$result = $modelDb->bindOrderWithInvoice($arr1, $beforOrderList, $orders,$arr2);
    			if(!$result){
    				$this->ajaxReturn(array('status'=>3,'msg'=>$this->translator->str_invoice_order_used));
    			}else{
    				return array('status'=>0,'id'=>$result);
    			}
    		}
    		
    	}
    }


    /*
     * 获取发票详情
     * */
    public function getInvoiceData($params=array()){
        if($params['invoice_id'] == ''){
            return array();
        }
        $where = '';
        if(isset($params['status'])){
            $where = " i.status=".$params['status']." and ";
        }
        $sql = "select
                        i.id,i.email,i.invoice_id,i.invoice_numb,i.enclosure,i.invoice_type,i.create_time,i.amount,i.role_type,
                        i.reason,i.update_time,i.user_id,i.status,v.invoice_head,v.contact,v.contact_phone,v.company,v.taxpayer_code,
                        v.company_address,v.company_phone,v.bank_deposit,v.bank_account,v.certificate,v.taxpayer
                from admin_invoice_info as i left join admin_invoice_extend as v on i.invoice_id = v.invoice_id 
                where ".$where." i.invoice_id=".$params['invoice_id'];
        $res = $this->query($sql);
        return $res;
    }
    /*
     * 录入发票号和附件
     * */
    public function updateInvoiceData($params = array()){
        $this->trueTableName = 'admin_invoice_info';
        $this->where(array('invoice_id'=>$params['invoice_id']));
        $res = $this->save($params);
        return $res;
    }

    //修改发票
    public function setData($params){
        $this->trueTableName = 'admin_invoice_info';
        $re = $this->save($params);
        return $re;
    }
    // 拒绝开票 同时修改发票订单可开金额
    public function setDataAndUpdateOrder($params,$oList){
    	$this->startTrans();
    	$this->trueTableName = 'admin_invoice_info';
    	$re = $this->save($params);
		$oList = json_decode($oList,true);
    	$hasError = empty($oList)?true:false;
    	foreach ($oList as $k=>$v){
    		$sql = 'UPDATE admin_invoice_order_queue 
	                SET order_surplus = order_surplus + "' . $v . '"
	                WHERE order_id = "' . $k . '"' ;
    		$this->execute($sql);
    		if ($this->getError()!=='') {
    			$hasError = true;
    			break;
    		}
    	}
    	if($re && !$hasError)
    	{
    		$this->commit();
    		return true;
    	}else{
    		$this->rollback();
    		return false;
    	}
    	 
    }
}