<?php
namespace Model\OrderManage;
use \Think\Model;
class OrderDb extends Model
{
	// 时区转换 utc 0:00 北京 8:00
// 	public $timezone = 'unix_timestamp(convert_tz( "%s" , "+08:00","+00:00"))';
	public $timezone = "%s";
	// tp的构造函数
	public function _initialize() {
		$this->connection = C('APPADMINDB');
	}
/**
 * 找人订单列表
 * @param array $params 搜索条件
 * @param number $PageNum 页码
 * @param number $pageSize 每页展示记录数
 * @return array
 */
     public function getOrderList($params,$PageNum=0,$pageSize=10)
     {
     	$where = array();
     	$orderby = array();
     	foreach($params as $k=>$v){
     		switch($k){
     			case 'orderby':
     				foreach ($v as $bk=>$by){
     					$orderby[] = $bk.' '.$by;
     				}
     				break;
     			case 'starttime':
     				$where[] = 'create_time >= '.sprintf($this->timezone,$v);
     				break;
     			case 'endtime':
     				$where[] = 'create_time <= '.sprintf($this->timezone,$v);
     				break;
     			case 'status':
     				$where[] = 'status = '.$v;
     				break;
     			default:
     				$where[] = $k.' like "%'.$v.'%"';
     		}
     	}
     	$where = implode(' and ', $where);
     	$where = empty($where)?' where type = "1" and status > "1" ':'  where type = "1" and status > "1" and '.$where;
     	$orderby = implode(' , ', $orderby);
     	empty($orderby) || $orderby = ' order by '.$orderby;
     	$sql = 'SELECT * FROM `basic_order`'.$where.$orderby.' limit '.$PageNum.' , '.$pageSize;
//      	echo $sql;
     	$info = $this->query($sql);
     	$sql = 'SELECT COUNT(order_id) AS totalNum FROM `basic_order`'.$where;
     	$num = $this->query($sql);
     	return array('list'=>$info,'num'=>isset($num[0]['totalnum'])?$num[0]['totalnum']:0);
	}
	/**
	 * 责任认定列表
	 * @param array $params 搜索条件
	 * @param number $PageNum 页码
	 * @param number $pageSize 每页展示记录数
	 * @return array
	 */
	public function getliabilityList($params,$PageNum=0,$pageSize=10)
	{
		$where = array();
		$orderby = array();
		foreach($params as $k=>$v){
			switch($k){
				case 'orderby':
					foreach ($v as $bk=>$by){
						$orderby[] = $bk.' '.$by;
					}
					break;
				case 'starttime':
     				$where[] = 'b.created_time >= '.sprintf($this->timezone,$v);
     				break;
     			case 'endtime':
     				$where[] = 'b.created_time <= '.sprintf($this->timezone,$v);
					break;
				case 'status':
					$where[] = 'a.status = '.$v;
					break;
				case 'statusAct':
					$where[] = 'a.status in ('.$v.')';
					break;
				default:
					$where[] = 'a.'.$k.' like "%'.$v.'%"';
			}
		}
		$where = implode(' and ', $where);
		$where = empty($where)?' where a.type = "1" and a.is_abnormal = 1 and b.action = 11':' where a.type = "1" and a.is_abnormal = 1 and b.action = 11 and '.$where;
		$orderby = implode(' , ', $orderby);
		empty($orderby) || $orderby = ' order by '.$orderby;
		$sql = 'SELECT a.*,b.created_time as time, c.buyer,c.saler,c.customer,c.person_liable FROM `basic_order` as a left join `basic_order_log` as b on a.order_id = b.order_id left join `basic_order_abnormal` as c on b.order_id = c.order_id  ' . $where . $orderby .' limit '.$PageNum.' , '.$pageSize;
// 		echo $sql;
		$info = $this->query($sql);
		$sql = 'SELECT COUNT(a.order_id) AS totalNum FROM `basic_order` as a left join `basic_order_log` as b on a.order_id = b.order_id left join `basic_order_abnormal` as c on b.order_id = c.order_id  ' . $where;
		$num = $this->query($sql);
		return array('list'=>$info,'num'=>isset($num[0]['totalnum'])?$num[0]['totalnum']:0);
	}
	/**
	 * 不满意订单列表
	 * @param array $params 搜索条件
	 * @param number $PageNum 页码
	 * @param number $pageSize 每页展示记录数
	 * @return array
	 */
	public function getProblemList($params,$PageNum=0,$pageSize=10)
	{
		$where = array();
		$orderby = array();
		foreach($params as $k=>$v){
			switch($k){
				case 'orderby':
					foreach ($v as $bk=>$by){
						$orderby[] = $bk.' '.$by;
					}
					break;
				case 'starttime':
     				$where[] = 'b.create_time >= '.sprintf($this->timezone,$v);
     				break;
     			case 'endtime':
     				$where[] = 'b.create_time <= '.sprintf($this->timezone,$v);
					break;
				case 'status':
					$where[] = 'b.status = '.$v;
					break;
				default:
					$where[] = 'b.'.$k.' like "%'.$v.'%"';
			}
		}
		$where = implode(' and ', $where);
		$where = empty($where)?' where b.type = "1" and a.type = 2':' where a.type = 2 and b.type = "1" and '.$where;
		$orderby = implode(' , ', $orderby);
		empty($orderby) || $orderby = ' order by '.$orderby;
		$sql = 'SELECT b.*,a.is_visit,a.admin_id,a.remark,a.visit_time FROM `basic_order_eval` as a LEFT JOIN `basic_order` as b on a.order_id = b.order_id' . $where . $orderby .' limit '.$PageNum.' , '.$pageSize;
// 		echo $sql;
		$info = $this->query($sql);
		$sql = 'SELECT COUNT(b.order_id) AS totalNum FROM `basic_order_eval` as a LEFT JOIN `basic_order` as b on a.order_id = b.order_id' . $where;
		$num = $this->query($sql);
		return array('list'=>$info,'num'=>isset($num[0]['totalnum'])?$num[0]['totalnum']:0);
	}
	/**
	 * 订单详情
	 */
	public function getOrderInfo($orderId)
	{
		$arr = array();
		// 基本信息
		$sql = 'SELECT a.order_id,a.to_user_account,a.to_user_name,a.user_account,a.user_name,a.content,b.type FROM `basic_order` as a LEFT JOIN `basic_order_eval` as b on a.order_id = b.order_id where a.order_id = "'.$orderId.'"';
		$arr['info'] = $this->query($sql);
     	if(isset($arr['info'][0])){
     		$arr['info'] = $arr['info']['0'];
     	}
     	// 售后信息
     	$sql = 'SELECT * FROM `basic_order_abnormal` where order_id = "'.$orderId.'"';
     	$arr['after'] = $this->query($sql);
     	if(isset($arr['after'][0])){
     		$arr['after'] = $arr['after']['0'];
     	}
     	// 订单状态信息
     	$sql = 'SELECT * FROM `basic_order_log` where order_id = "'.$orderId.'" order by created_time asc';
     	$arr['status'] = $this->query($sql);
     	// 订单支付信息
     	$sql = 'SELECT a.payment,a.price as total,a.trade_no as code FROM `basic_order` as a where a.order_id = "'.$orderId.'"';
     	$arr['payinfo'] = $this->query($sql);
     	if(isset($arr['payinfo'][0])){
     		$arr['payinfo'] = $arr['payinfo']['0'];
     	}
		return $arr;
	}
	/**
	 * 名片控制-已下线名片
     * @param array $params 搜索条件
	 * @param number $PageNum 页码
	 * @param number $pageSize 每页展示记录数
	 * @return array
	 */
	public function getunderShelfCard($params,$PageNum=0,$pageSize=10)
	{
		$where = array();
		foreach($params as $k=>$v){
			switch($k){
				case 'public':
					$where[] = 'a.public = "'.$v.'"';
					break;
				default:
					$where[] = 'b.'.$k.' like "%'.$v.'%"';
			}
		}
		$where = implode(' and ', $where);
		empty($where) || $where = ' where '.$where;
		$sql = 'SELECT a.public,a.uuid as cardid,b.vcard FROM `contact_card` as a left join `contact_card_extend` as b on a.uuid = b.uuid '.$where.' limit '.$PageNum.' , '.$pageSize;
		$info = $this->query($sql);
		$sql = 'SELECT COUNT(a.uuid) AS totalNum FROM `contact_card` as a left join `contact_card_extend` as b on a.uuid = b.uuid '.$where;
		$num = $this->query($sql);
		return array('list'=>$info,'num'=>isset($num[0]['totalnum'])?$num[0]['totalnum']:0);
	}
	/**
	 * 名片控制-在售名片
     * @param array $params 搜索条件
	 * @param number $PageNum 页码
	 * @param number $pageSize 每页展示记录数
	 * @return array
	 */
	public function getonlineCard($params,$PageNum=0,$pageSize=10)
	{
		$where = array();
		foreach($params as $k=>$v){
			switch($k){
				case 'public':
					$where[] = 'a.public = "'.$v.'"';
					break;
				default:
					$where[] = 'b.'.$k.' like "%'.$v.'%"';
			}
		}
		$where = implode(' and ', $where);
		empty($where) || $where = ' where '.$where;
		$sql = 'SELECT b.card_id as cardid,a.public,c.vcard FROM `contact_card` as a left join `contact_card_vcardinfo` as b on b.card_id=a.uuid left join `contact_card_extend` as c on a.uuid = c.uuid '.$where.' limit '.$PageNum.' , '.$pageSize;
		$info = $this->query($sql);
		$sql = 'SELECT COUNT(b.card_id) AS totalNum FROM `contact_card` as a left join `contact_card_vcardinfo` as b on b.card_id=a.uuid left join `contact_card_extend` as c on a.uuid = c.uuid '.$where;
		$num = $this->query($sql);
		return array('list'=>$info,'num'=>isset($num[0]['totalnum'])?$num[0]['totalnum']:0);
	}

	/**
	 * 获取用户服务订单列表
	 * @param arr $params
	 * @param int $PageNum
	 * @param int $pageSize
	 */
	public function getUserServiceOrder($params){
		$where  = array();
		$values = array();
		$order = '';
		$start = 0;
		$rows  = 10;
		//搜索条件
		if (!empty($params['order_id'])){//订单id
			$where[] = "t1.order_id='%s'";
			$values[] = $params['order_id'];
		}
		if (!empty($params['status'])){//订单状态
			$where[] = "t1.`status`=%d";
			$values[] = $params['status'];
		}else{
			$where[] = "t1.`status` in (%s)";
			$values[] = '1,2';
		}
		if (!empty($params['userid'])){
			$where[] = "t1.user_account='%s'";
			$values[] = $params['userid'];
		}
		if (!empty($params['username'])){
			$where[] = "t1.user_name='%s'";
			$values[] = $params['username'];
		}
		if (!empty($params['start_time'])){
			$where[] = "t1.create_time>='%s'";
			$values[] = $params['start_time'];
		}
		if (!empty($params['end_time'])){
			$where[] = "t1.create_time<='%s'";
			$values[] = $params['end_time'];
		}
		if (!empty($params['service_type'])){//订单状态
			$where[] = "t1.`type`=%d";
			$values[] = $params['service_type'];
		}else{
			$where[] = "t1.`type` in (%s)";
			$values[] = '2';
		}
		if(empty($where)){
			$where = '';
		} else {
			$where = ' where '.join(' and ', $where);
		}

		//排序
		if (!empty($params['sort'])){
			$arr = explode(' ', $params['sort']);
			$order = " order by t1.$arr[0] $arr[1] ";
		}
		//分页
		!empty($params['start']) && $start = $params['start'];
		!empty($params['rows'])  && $rows  = $params['rows'];

		$t1 = "t1.id,t1.order_id as orderid,t1.create_time as createtime,t1.`status`,t1.payment".
		",t1.goods_id as goodsid,t1.price,t1.user_account as mobile,t1.user_name as username,t2.type as goodstype,t2.equity_time";
		$sql = "SELECT {$t1} FROM basic_order as t1 LEFT JOIN oradt_recharge_app_price as t2 ON t1.goods_id=t2.id {$where} {$order} limit $start,$rows";
		$rst = $this->query($sql, $values);
		$sql_numfound = "SELECT  count(id) as total FROM `basic_order` as t1 {$where} {$order}"; //{$whereStr}
		$rstNumfound = $this->query($sql_numfound, $values); //查询总记录数
		return array('list'=>$rst, 'numfound'=>$rstNumfound[0]['total']);
	}

	/**
	 * 获取用户服务订单详情数据
	 * @param arr $params
	 * @param int $PageNum
	 * @param int $pageSize
	 */
	public function getUserServiceOrderDetail($params){
		$where  = array();
		$values = array();
		//搜索条件
		if (!empty($params['id'])){//id
			$where[] = "t1.id='%d'";
			$values[] = $params['id'];
		}
		if(empty($where)){
			$where = '';
		} else {
			$where = ' where '.join(' and ', $where);
		}
        /*
		$t1  = "t1.id,t1.order_id as orderid,t1.create_time as createtime,t1.`status`,t1.payment,t1.goods_id as goodsid,t1.trade_no as tradeno".
				",t1.price,t1.unit,t1.user_account as mobile,t1.user_name as username";
		$t2  = "t2.type as goodstype,t2.num,t2.price as goodsprice ";
		$sql = "SELECT {$t1},{$t2} FROM basic_order as t1  INNER JOIN oradt_recharge_rules as t2 ON t1.goods_id = t2.id ".
				"{$where} LIMIT 0,1";*/
		$t1  = "t1.id,t1.order_id as orderid,t1.create_time as createtime,t1.`status`,t1.payment,t1.paystatus,t1.goods_id as goodsid,t1.trade_no as tradeno".
		       ",t1.price,t1.unit,t1.user_account as mobile,t1.user_name as username";
		$t2 = "t2.type as goodstype,t2.equity_time,t2.price as goodsprice ";
		$where = $where."  and t2.type = 2 and t2.status = 1 ";
		$sql = "SELECT {$t1},{$t2} FROM basic_order as t1  INNER JOIN oradt_recharge_app_price as t2 ON t1.goods_id = t2.id "."{$where} LIMIT 0,1";
// 		echo $sql;die;
		$rst = $this->query($sql, $values);
		$result = array();
		if($rst){
			$t3  = "t3.action,t3.created_time as createtime";
			$sql = "SELECT {$t3} FROM basic_order_log as t3 ".
					"WHERE t3.order_id = '%s'";
			$orderStatusList = $this->query($sql, array($rst[0]['orderid']));
			$result = $rst[0];
			$result['statuslist'] = $orderStatusList;
		}
		return $result;
	}

	/**
	 * 获取企业订单数据
	 * @param arr $params
	 * @param int $PageNum
	 * @param int $pageSize
	 */
	public function getCompanyOrder($params){
	    $where  = array();
	    $values = array();
	    $order = '';
	    $start = 0;
	    $rows  = 10;
	    //搜索条件
	    if (!empty($params['order_id'])){
	        $where[] = "t1.order_id='%s'";
	        $values[] = $params['order_id'];
	    }
	    if (!empty($params['status'])){
	        $where[] = "t1.status=%d";
	        $values[] = $params['status'];
	    }
	    if (!empty($params['company_id'])){
	        $where[] = "t2.biz_email='%s'";
	        $values[] = $params['company_id'];
	    }
	    if (!empty($params['company_name'])){
	        $where[] = "t2.biz_name='%s'";
	        $values[] = $params['company_name'];
	    }
	    if (!empty($params['start_time'])){
	        $where[] = "t1.create_time>='%s'";
	        $values[] = strtotime($params['start_time']);
	    }
	    if (!empty($params['end_time'])){
	        $where[] = "t1.create_time<='%s'";
	        $values[] = strtotime($params['end_time'].' 23:59:59');
	    }
	    /*if (!empty($params['length'])){
	        $where[] = "t1.length>0";
	    }
	    if (!empty($params['storage'])){
	        $where[] = "t1.storage_num>0";
	    }
	    if (!empty($params['authorize'])){
	        $where[] = "t1.authorize_num>0";
	    }*/
	    if (!empty($params['gt'])){
	        $where[] = "t1.".$params['gt'].">0";
	    }
	    if(empty($where)){
	        $where = '';
	    } else {
	        $where = ' where '.join(' and ', $where);
	    }

	    //排序
	    if (!empty($params['sort'])){
	        $arr = explode(' ', $params['sort']);
	        $order = " order by t1.$arr[0] $arr[1] ";
	    }

	    //分页
	    !empty($params['start']) && $start = $params['start'];
	    !empty($params['rows'])  && $rows  = $params['rows'];
	    $values[] = $start;
	    $values[] = $rows;

	    $t1 = "t1.id,t1.order_id,t1.create_time,t1.status,t1.length,t1.authorize_num,t1.storage_num,t1.price";
	    $t2 = "t2.biz_email,t2.biz_name";
	    $sql = "select $t1,$t2 from `biz_order` t1
	        join `account_biz_detail` t2 on t1.biz_id=t2.biz_id $where $order
	        limit %d,%d";
	    $sql_numfound = "SELECT  count(1) as total FROM `biz_order` as t1 join `account_biz_detail` t2 on t1.biz_id=t2.biz_id $where $order"; //{$whereStr}
		$rstNumfound = $this->query($sql_numfound, $values); //查询总记录数
	    $rst = $this->query($sql, $values);
	    return array('list'=>$rst, 'numfound'=>$rstNumfound[0]['total']);
	}

	/**
	 * 获取用户服务订单详情数据
	 * @param arr $params
	 * @param int $PageNum
	 * @param int $pageSize
	 */
	public function getCompanyServiceOrderDetail($params){
		$where  = array();
		$values = array();
		//搜索条件
		if (!empty($params['id'])){//id
			$where[] = "t1.id='%d'";
			$values[] = $params['id'];
		}
		if(empty($where)){
			$where = '';
		} else {
			$where = ' where '.join(' and ', $where);
		}

		$t1  = "t1.id,t1.order_id as orderid,t1.create_time as createtime,t1.`status`,t1.trade_no as tradeno,t1.authorize_num as authorize,t1.storage_num storage,t1.length".
				",t1.price,t1.unit";
		$t2  = " t2.biz_name as bizname,t2.biz_email bizemail ";
		$sql = "SELECT {$t1},{$t2} FROM biz_order as t1 INNER JOIN `account_biz_detail` t2 on t1.biz_id=t2.biz_id  ".
				"{$where} LIMIT 0,1";
		$rst = $this->query($sql, $values);
		$result = array();
		if($rst){
			$t3  = "t3.`status`,t3.created_time as createtime";
			$sql = "SELECT {$t3} FROM biz_order_log as t3 ".
					"WHERE t3.order_id = '%s'";
			$orderStatusList = $this->query($sql, array($rst[0]['orderid']));
			$result = $rst[0];
			$result['statuslist'] = $orderStatusList;
		}
		return $result;
	}

	/**
	 * 获取可以被开票的订单
	 * @param unknown $clientId
	 * @return \Think\mixed
	 * 暂时不用
	 */
	public function getUserOrdersWhichCanBeInvoiced ($clientId)
	{
	    $table = 'invoice_order';
	    $sql = 'SELECT sum(ir.usedamount) AS consumed_total, *
	            FROM invoice_relation ir
	            INNER JOIN invoice i
	              ON ir.invoiceid = i.invoiceid
	            INNER JOIN invoice_detail id
	              ON ir.orderid = id.orderid
	            WHERE id.client_id = "'.$clientId.'"
	              AND createtime > date_sub(CURDATE(),INTERVAL 3 MONTH)
	            GROUP BY ir.orderid
	            HAVING consumed_total < orderamount
	            ORDER BY createtime ASC';

	    return $this->query($sql);
	}
	/**
	 * 将最近订单信息转移到待开发票数据表
	 * @param string $clientId
	 * @return boolean 执行是否成功
	 *  暂时不用
	 */
	public function loadOrdersIntoInvoiceQueue ($clientId, $howManyMonth=3)
	{
		$table = 'admin_invoice_order_queue';
		$sql = 'INSERT INTO admin_invoice_order_queue (orderid, orderamount, ordersurplus, clientid)
	            SELECT order_id, CASE type WHEN 1 THEN price * 0.2 ELSE price END AS price,
	                   0, CASE type WHEN 1 THEN to_userid ELSE user_id END AS client_id
	            FROM basic_order
	            WHERE status = 10
	              AND price > 0
	              AND create_time > UNIX_TIMESTAMP (date_sub(CURDATE(),INTERVAL '.$howManyMonth.' MONTH) )
	              AND ( (type = 1 AND to_userid = "' . $clientId . '")
	                  OR (FIND_IN_SET(type, "2,3") AND user_id = "' . $clientId . '")
	               )';
		$this->query($sql);
	
		$hasError = $this->getError()!=='';
	
		return $hasError;
	}
	/**
	 * 将最近符合条件的订单信息转移到待开发票数据表
	 * @param array $orderIds 订单id
	 * @param int $invoiceType 发票类型
	 * @return boolean 执行是否成功
	 */
	public function loadOrdersIntoInvoiceQueueByIds ($orderIds=array(),$invoiceType=3)
	{
	    $hasError = true;
	    switch ($invoiceType)
	    {
	    	case '1':
	    		$selectSql = 'SELECT order_id, price, 
	    							 CASE type WHEN 1 THEN price * '.C('COMMISSION_RATE').' ELSE price END AS left_amount,
			    	                 CASE type WHEN 1 THEN to_userid ELSE user_id END AS client_id,
			    	                 type,create_time
    	            		  FROM basic_order';
	    		break;
	    	case '2':
	    		$selectSql = 'SELECT order_id, price, price AS left_amount, biz_id, type ,create_time
    	            		  FROM biz_order';
	    		break;
	    	default:
	    		trace('发票类型错误：'.$invoiceType);
	    		return false;
	    }
	    settype($orderIds, 'array');
    	if (count($orderIds)) {
    	    $sql = 'INSERT IGNORE INTO admin_invoice_order_queue
    	                  (order_id, order_amount, order_surplus,
    	                  user_id, order_type, create_time) '.$selectSql.'
    	    		WHERE FIND_IN_SET(order_id, "'. join(',', $orderIds) .'")';
    	    $this->execute($sql);

    	    $hasError = $this->getError()!=='';
	    }

	    return $hasError;
	}

	/**
	 * 获取指定时间前1个月内的所有订单可开票的金额总额
	 * @param string $clientId
	 * @param int $invoiceType 发票类型 1个人发票 2企业发票
	 * @param int|string $time 时间值 默认now：当前时间
	 * @return float $num 可开金额
	 */
	public function getTotalAmountCanBeInvoiced ($clientId,$invoiceType,$time='now')
	{
	    $time = $time == 'now'?time():$time;
	    $time = $this->getTimeLine($time);
	    switch ($invoiceType)
	    {
	    	case '1':
				$sql = 'SELECT sum(IF(o.type=1, o.price*'.C('COMMISSION_RATE').', o.price)) AS amount 
						FROM basic_order o 
						WHERE ( (type = 1 AND o.to_userid = "'.$clientId.'" AND o.status = 10)
		        				OR (FIND_IN_SET(type, "2,3") AND o.user_id = "'.$clientId.'" AND o.status = 2)
							  ) AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].'
							  	AND o.payment != 1 
								AND o.price > 0';
				$result = $this->query($sql);
				if(isset($result[0]) && $result[0]['amount']>0){
					$total = $result[0]['amount'];
					$sql = 'SELECT sum(IF(ii.status=4,0,IFNULL(i.used_amount, 0 ))) AS used_amount
						FROM basic_order o
						LEFT JOIN admin_invoice_order_relation i
							ON o.order_id = i.order_id
						LEFT JOIN admin_invoice_info ii
							ON i.invoice_id = ii.invoice_id
						WHERE ( (type = 1 AND o.to_userid = "'.$clientId.'" AND o.status = 10)
		        				OR (FIND_IN_SET(type, "2,3") AND o.user_id = "'.$clientId.'" AND o.status = 2)
							  ) AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].'
							  	AND o.payment != 1
								AND o.price > 0';
					$result = $this->query($sql);
					$total = (isset($result[0]) && $result[0]['used_amount']>0)?$total-$result[0]['used_amount']:$total;
					return $total;
				}else{
					return 0.00;
				}
	    		break;
	    	case '2':
	    		$sql = 'SELECT sum(o.price) AS amount  
	    				FROM biz_order o
	    				WHERE o.status = 2
	    				  AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].'
	    				  AND o.price > 0';
	    		
	    		$result = $this->query($sql);
	    		if(isset($result[0]) && $result[0]['amount']>0){
	    			$total = $result[0]['amount'];
	    			$sql = 'SELECT sum(IF(ii.status=4,0,IFNULL(i.used_amount, 0 ))) AS used_amount 
	    				FROM biz_order o
	    				LEFT JOIN admin_invoice_order_relation i
	    				  ON o.order_id = i.order_id 
	    				LEFT JOIN admin_invoice_info ii 
						  ON i.invoice_id = ii.invoice_id 
	    				WHERE o.status = 2
	    				  AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].'
	    				  AND o.price > 0';
	    			$result = $this->query($sql);
	    			$total = (isset($result[0]) && $result[0]['used_amount']>0)?$total-$result[0]['used_amount']:$total;
	    			return $total;
	    		}else{
	    			return 0.00;
	    		}
	    		break;
	    	default:
	    		trace('发票类型错误：'.$invoiceType);
	    		return 0.00;
	    }
	}

	/**
	 * 订单列表 --- 未开发票查看详情：根据待开发票金额、申请开票时间，获取到相应的可开发票的订单
	 * @param float $invoiceAmount 发票金额
	 * @param string $clientId 用户id
	 * @param int $invoiceType 发票类型
	 * @param int|string $time 申请开票时间  默认now:当前时间
	 * @param int    $start 数据偏移量开始位置
	 * @param int    $limit 返回的记录条数
	 *
	 * @return array 返回订单列表
	 */
	public function getOrdersToBeInvoiced ($invoiceAmount, $clientId, $invoiceType,$time = 'now')
	{
	    $orderList = array();
	    $start = 0;
	    $limit = 1;
	    $time = $time == 'now'?time():$time;
	    $time = $this->getTimeLine($time);
	    switch ($invoiceType)
	    {
	    	case '1':
	    		$selectSql = 'SELECT o.*, IF(o.type=1, o.price*'.C('COMMISSION_RATE').', o.price)-sum(IF(ii.status=4,0,IFNULL(i.used_amount, 0 ))) AS left_amount
			    		FROM basic_order o
			    		LEFT JOIN admin_invoice_order_relation i
			    		  ON o.order_id = i.order_id 
	    				LEFT JOIN admin_invoice_info ii
						  ON i.invoice_id = ii.invoice_id 
		    	        WHERE ( (type = 1 AND o.to_userid = "' . $clientId . '" AND o.status = 10)
		                        OR (FIND_IN_SET(type, "2,3") AND o.user_id = "' . $clientId . '" AND o.status = 2) )
		    	           AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].'
			        	   AND o.payment != 1
			        	   AND o.price > 0
			        	   GROUP BY o.order_id
			        	HAVING left_amount > 0
			        	ORDER BY o.create_time ASC';
		    	break;
	    	case '2':
	    		$selectSql = 'SELECT o.*, o.price-sum(IF(ii.status=4,0,IFNULL(i.used_amount, 0 ))) AS left_amount 
	    				FROM biz_order o 
	    				LEFT JOIN admin_invoice_order_relation i 
	    				  ON o.order_id = i.order_id 
	    				LEFT JOIN admin_invoice_info ii
						  ON i.invoice_id = ii.invoice_id 
	    				WHERE o.status = 2 
	    				  AND o.create_time > '.$time['startTime'].' AND o.create_time < '.$time['endTime'].' 
	    				  AND o.price > 0 
	    				GROUP BY o.order_id
	    		    	HAVING left_amount > 0
	    		    	ORDER BY o.create_time ASC';
	    		break;
	    	default:
	    		trace('发票类型错误：'.$invoiceType);             
	    		return $orderList;
	    }
	    while ($invoiceAmount > 0) {
	    	$sql = $selectSql.' LIMIT ' . $start . ', ' . $limit;
    	    $tmpOrderList = $this->query($sql);
    	    if (! is_array($tmpOrderList)) {
    	        trace('本次查询出现错误');
    	        break;
    	    }

    	    // 所有订单不够开票金额
    	    if (count($tmpOrderList)==0) {
    	        trace('本次查询到的可开票订单为空');
    	        break;
    	    }
    	    foreach($tmpOrderList as $_orderInfo) {
    	        $orderList[] = $_orderInfo;
    	        $invoiceAmount = $invoiceAmount - $_orderInfo['left_amount'];
    	        if ($invoiceAmount <= 0) {
    	            break;
    	        }
    	    }

    	    // 本次获取的订单列表， 不够开票。 继续查找
    	    $start = $start + $limit;
	    }
	    // 未找到足够的订单可供开票， 返回空数组， 需要重新设定金额
	    if ($invoiceAmount > 0) {
	        $orderList = array();
	    }
	    return $orderList;
	}

	/**
	 * 申请发票（创建发票信息）  绑定订单的开票信息和发票id
	 * @param array $invoiceArr 发票基本信息
	 * @param array $ordersInfoBeforeBind
	 * @param array $ordersInfoAfterBind
	 * @param array $invoiceExtendArr 发票扩展信息
	 */
	public function bindOrderWithInvoice ($invoiceArr, $ordersInfoBeforeBind, $ordersInfoAfterBind,$invoiceExtendArr)
	{
		$invoiceId = $invoiceArr['invoice_id'];
	    settype($ordersInfoAfterBind, 'array');
	    settype($ordersInfoBeforeBind, 'array');
	    $this->startTrans();
	     

	    // 创建发票基本信息和扩展信息
	    $this->trueTableName = 'admin_invoice_info';
	    $id = $this->add($invoiceArr);
	    if($id){
	    	$this->trueTableName = 'admin_invoice_extend';
	    	$vid = $this->add($invoiceExtendArr);
	    	if($vid){
	    		// 绑定发票和订单
	    		if(count($ordersInfoAfterBind)==0 || count($ordersInfoAfterBind)!=count($ordersInfoBeforeBind)) {
	    			trace('Model OrderManage line:'.__LINE__ .' 传入的订单数据信息无效: before:   ' . print_r($ordersInfoBeforeBind) . "\r\n after:"
	    					. print_r($ordersInfoAfterBind, true));
	    					return false;
	    		}
	    		$tmpArray = array();
	    		foreach ($ordersInfoBeforeBind as $_orderInfo) {
	    			$tmpArray[$_orderInfo['order_id']] = $_orderInfo;
	    		}
	    		$ordersInfoBeforeBind = $tmpArray;
	    		$tmpArray = array();
	    		$hasError = false;
	    		foreach ($ordersInfoAfterBind as $_orderInfo) {
	    			if (! isset($ordersInfoBeforeBind[$_orderInfo['order_id']])) {
	    				trace('Model OrderManage line:'.__LINE__ .' 传入的订单数据信息无效: before:   '
	    						. print_r($ordersInfoBeforeBind, true) . "\r\n after:"
	    								. print_r($ordersInfoAfterBind, true));
	    								$hasError = true;
	    								break;
	    			}
	    			$sql = 'UPDATE admin_invoice_order_queue
	                SET order_surplus = order_surplus - "' . $ordersInfoBeforeBind[$_orderInfo['order_id']]['invoice_amount'] . '"
	                WHERE order_id = "' . $ordersInfoBeforeBind[$_orderInfo['order_id']]['order_id'] . '"
	                  AND order_surplus =' . $ordersInfoBeforeBind[$_orderInfo['order_id']]['left_amount'] ;
	    			$this->execute($sql);
	    			if ($this->getError()!=='') {
	    				$hasError = true;
	    				break;
	    			}
	    			$sql = 'INSERT INTO admin_invoice_order_relation (invoice_id, order_id, used_amount)
	                VALUES ("'.$invoiceId.'", "'.$_orderInfo['order_id'].'", "'.$ordersInfoBeforeBind[$_orderInfo['order_id']]['invoice_amount'].'")';
	    			$this->execute($sql);
	    			if ($this->getError()!=='') {
	    				$hasError = true;
	    				break;
	    			}
	    		}
	    		if (! $hasError) {
	    			$this->commit();
	    			return $id;
	    		} else {
	    			$this->rollback();
	    			return false;
	    		}
	    	}else{
	    		$this->rollback();
	    		return false;
	    	}
	    }else{
	    	$this->rollback();
	    	return false;
	    }

	}
	/**
	 * 订单列表
	 * @param string $invoiceId 发票id
	 * @return array $orderList 订单列表
	 */
	public function invoiceHasOrderList ($invoiceId)
	{
		$sql = 'SELECT r.order_id as order_id,
					q.order_type as type,
					order_amount as price,
					CASE q.order_type WHEN 1 THEN q.order_amount * '.C('COMMISSION_RATE').' ELSE q.order_amount END as order_amount,
					used_amount,
					order_surplus
				FROM admin_invoice_order_relation r
				LEFT JOIN admin_invoice_order_queue q
					ON r.order_id = q.order_id
				WHERE invoice_id = "'.$invoiceId.'" order by create_time asc';
		$orderList = $this->query($sql);
		return $orderList;
	}
	/**
	 * 获得指定时间间隔1个月后新的起止时间段
	 * @param int $time
	 * @return array $timeArr
	 */
	private function getTimeLine($time)
	{
		$month = date('m',$time);
		$time = date('Y-m-d',$time);
		$timeArr = array();
		$timeArr['endTime'] = strtotime($time.' 23:59:59');
		$timeArr['startTime'] = $month == '1' ? 
				strtotime(date('Y-m-01',$timeArr['endTime'])):
				strtotime("$time -1 month");
		return $timeArr;
	}
}
