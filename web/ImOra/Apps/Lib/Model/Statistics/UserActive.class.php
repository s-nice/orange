<?php
namespace Model\Statistics;
use \Think\Model;

class UserActive extends Model
{
     public $from_tz = '+00:00';//原始时区
     public $to_tz   = '+08:00';//要转换到的时区
     private $dateTypeArr = array('d'=>'"%Y-%j"','w'=>'"%x-%v"','m'=>'"%Y-%c"');//定义mysql中一年内中第几天、第几周、第几个月格式
	/**
	 * 活跃统计
	 */
	public function getActive($param,$start=0,$limit=1000)
	{
		$where = $whereValues = array(); //定义where查询条件存储变量
		$dateField = 'di.date';
		$groupBy = $groupStr = '';		
		
		switch ($param['dataType']){
			case '1'://活跃用户量
				$whereStr = '';
				$dateField = 'convert_tz(a.time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
				if(!empty($param['startDate'])){//开始日期
					$where[] = $dateField.' >= "%s"';
					$whereValues[] = $param['startDate'];
				}
				if(!empty($param['endDate'])){//结束日期
					$where[] = $dateField.' <= "%s"';
					$whereValues[] = $param['endDate'].' 23:59:59';
				}
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' a.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',a.sys_platform';
				}
				if(!empty($param['channel'])){//渠道
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}
					$groupStr .= ',a.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
					if(count($prdVersArr)>1){
						$valStr = "";
						foreach ($prdVersArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
						$where[] = ' a.prd_version= "%s"';
					}
					$groupStr .= ',a.prd_version';
				}
				
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' a.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' a.province = "%s"';
					}
				}
				
				if ($where) {
					$where = join(' AND ', $where);
					$where = vsprintf($where, $whereValues);
					$whereStr = ' WHERE ' . $where;
				}
				$haveUser = $groupNewUser = '';
				if($param['isNewUser'] != ''){//新老用户
					$haveUser = " HAVING is_new_user = {$param['isNewUser']}";
					$groupNewUser = ",is_new_user ";
				}
				$groupDateRegex    = $this->dateTypeArr[$param['statType']];
				if(isset($param['chartDataSqlNew']) && $param['chartDataSqlNew'] == true){
					$groupBy = " GROUP BY gb_index {$groupNewUser} {$haveUser}";
				}else{
					$groupBy = " GROUP BY gb_index {$groupStr} {$groupNewUser} {$haveUser}";
				}
				$reg_time = 'convert_tz(b.reg_time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
				$sql = "SELECT
							DATE_FORMAT({$dateField}, $groupDateRegex) as gb_index,
							IF (
								DATE_FORMAT({$reg_time}, $groupDateRegex) = DATE_FORMAT({$dateField}, $groupDateRegex),
								1,
								0
							) is_new_user,
							count(DISTINCT a.user_id) AS count,
							a.sys_platform,
							d.channel_name as channel,
							a.prd_version
						FROM
							user_daily_last_login a
						INNER JOIN user_register_info b ON a.user_id = b.user_id
						LEFT JOIN channel_info AS d ON a.channel = d.channel
							{$whereStr} AND b. STATUS = \"SUCC\"
						";
				unset($param, $where);//对变量进行释放
				$param = $where = array();
				break;
			case '2'://  人均在线时长
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' di.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',di.sys_platform';
				}
				if(!empty($param['channel'])){//渠道
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}
					$groupStr .= ',di.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
					if(count($prdVersArr)>1){
						$valStr = "";
						foreach ($prdVersArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
						$where[] = ' di.prd_version= "%s"';
					}
					$groupStr .= ',di.prd_version';
				}
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' di.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' di.province = "%s"';
					}
				}
				
				$haveUser = $groupNewUser = '';
				if($param['isNewUser'] != ''){//渠道
					$haveUser = " HAVING is_new_user = {$param['isNewUser']}";
					$groupNewUser = ",is_new_user ";
				}
				$groupDateRegex    = $this->dateTypeArr[$param['statType']];
				if(isset($param['chartDataSqlNew']) && $param['chartDataSqlNew'] == true){
					$groupBy = " GROUP BY gb_index {$groupNewUser} ".$haveUser;
				}else{
					$groupBy = " GROUP BY  gb_index {$groupStr} {$groupNewUser} ".$haveUser;
				}

				$dateField = 'convert_tz(di.login_time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
				
				$sql = "SELECT  date_format({$dateField},\"%Y-%m-%d\") as date,
							IF (
								DATE_FORMAT(b.reg_time, $groupDateRegex) = DATE_FORMAT(di.login_time, $groupDateRegex),1,0
							) is_new_user,
							ROUND(sum(di.duration)/count(distinct di.user_id)/60,2)  as count,
							di.sys_platform, d.channel_name as channel, di.prd_version,
							date_format({$dateField}, {$groupDateRegex}) AS gb_index 
					FROM user_login_info as di
					INNER JOIN user_register_info b ON di.user_id = b.user_id
					LEFT JOIN channel_info AS d ON di.channel = d.channel
					";

				break;
			case '3': // 单次登陆平均在线时长
				$dateField = 'convert_tz(di.login_time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
				
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' di.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',di.sys_platform';
				}
				if(!empty($param['channel'])){//渠道
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}
					$groupStr .= ',di.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
					if(count($prdVersArr)>1){
						$valStr = "";
						foreach ($prdVersArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
						$where[] = ' di.prd_version= "%s"';
					}
					$groupStr .= ',di.prd_version';
				}
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' di.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' di.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' di.province = "%s"';
					}
				}
				
				$haveUser = $groupNewUser = '';
				if($param['isNewUser'] != ''){//渠道
					$haveUser = " HAVING is_new_user = {$param['isNewUser']}";
					$groupNewUser = ",is_new_user ";
				}
				$groupDateRegex    = $this->dateTypeArr[$param['statType']];
				$groupDate = self::$_SQL_PART['active'][$param['dataType']][$param['statType']]['groupDate'];
				$sql = "SELECT date_format({$dateField},\"%Y-%m-%d\") as date,
						IF (
							DATE_FORMAT(b.reg_time, $groupDateRegex) = DATE_FORMAT(di.login_time, $groupDateRegex),1,0
						) is_new_user,
							ROUND(avg(di.duration)/60,2) as count,
							di.sys_platform, d.channel_name as channel, di.prd_version,
							date_format({$dateField}, {$groupDateRegex}) AS gb_index 
						FROM user_login_info as di
						INNER JOIN user_register_info b ON di.user_id = b.user_id
						LEFT JOIN channel_info AS d ON di.channel = d.channel
						";
				if(isset($param['chartDataSqlNew']) && $param['chartDataSqlNew'] == true){
					$groupBy = " GROUP BY gb_index {$groupNewUser} ".$haveUser;
				}else{
					$groupBy = " GROUP BY  gb_index {$groupStr} {$groupNewUser} ".$haveUser;
				}
				break;

			case '4': // 人均登陆次数
				$dateField = 'convert_tz(uli.login_time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
				
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' uli.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',uli.sys_platform';
				}
				if(!empty($param['channel'])){//渠道
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}
					$groupStr .= ',uli.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
					if(count($prdVersArr)>1){
						$valStr = "";
						foreach ($prdVersArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' uli.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
						$where[] = ' uli.prd_version= "%s"';
					}
					$groupStr .= ',uli.prd_version ';
				}
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' uli.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' uli.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' uli.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' uli.province = "%s"';
					}
				}
				
				$haveUser = $groupNewUser = '';
				if($param['isNewUser'] != ''){//渠道
					$haveUser = " HAVING is_new_user = {$param['isNewUser']}";
					$groupNewUser = ",is_new_user ";
				}
				$groupDateRegex    = $this->dateTypeArr[$param['statType']];
				
				$sql = "SELECT
							COUNT(uli.id)/COUNT(DISTINCT uli.user_id) as count,
													IF (
							DATE_FORMAT(b.reg_time, $groupDateRegex) = DATE_FORMAT(uli.login_time, $groupDateRegex),
							1,
							0
						) is_new_user,
							date_format({$dateField},\"%Y-%m-%d\") as date
				  			,date_format({$dateField}, {$groupDateRegex}) AS gb_index  ,d.channel_name as channel,uli.prd_version,uli.sys_platform
					 	FROM user_login_info as uli
					 	INNER JOIN user_register_info b ON uli.user_id = b.user_id
					 	LEFT JOIN channel_info AS d ON uli.channel = d.channel
					";

				if(isset($param['chartDataSqlNew']) && $param['chartDataSqlNew'] == true){
					$groupBy = " GROUP BY gb_index {$groupNewUser} ".$haveUser;
				}else{
					$groupBy  = "GROUP BY gb_index {$groupStr} {$groupNewUser} ".$haveUser;//self::$_SQL_PART['active'][$param['dataType']][$param['statType']]['groupBy'].',is_new_user '.$haveUser;
				}
				break;

			case '5': //日活跃占比
				$dateField = 'a.date';//convert_tz(a.date, "'. $this->from_tz .'", "'. $this->to_tz .'");
				$groupDate = self::$_SQL_PART['active'][$param['dataType']][$param['statType']]['groupDate'];
				
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' a.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',a.sys_platform';
				}
				if(!empty($param['channel'])){//渠道，可能有问题
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}
					$groupStr .= ',a.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
					if(count($prdVersArr)>1){
						$valStr = "";
						foreach ($prdVersArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
						$where[] = ' a.prd_version= "%s"';
					}
					$groupStr .= ',a.prd_version';
				}
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' a.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' a.province = "%s"';
					}
				}
				
				$groupBy = '';
				$rateFeilds = ',sum(a.day_active_cnt)/sum(a.p7_active_cnt) as count,sum(a.day_active_cnt)/sum(a.p30_active_cnt) as count_30';
				if(isset($param['chartDataSqlNew']) && $param['chartDataSqlNew'] == true){
					$groupBy = " GROUP BY gb_index ";					
				}else{
					$groupBy = " GROUP BY gb_index {$groupStr} ";
				}				
				$sql = "SELECT
					$dateField as date,a.sys_platform,d.channel_name as channel,a.prd_version				
					{$rateFeilds}
				    {$groupDate}
					FROM st_day_week_active_ratio as a LEFT JOIN channel_info AS d ON a.channel = d.channel ";
				break;

			case '6': //周活跃占比
				$whereStrInner = '';
				$whereInner = $whereValuesInner = array();
				$dateField = 'a.date'; //convert_tz(a.date, "'. $this->from_tz .'", "'. $this->to_tz .'")
				if(!empty($param['startDate'])){//开始日期
					$whereInner[] = $dateField.' >= "%s"';
					$whereValuesInner[] = $param['startDate'];
				}
				if(!empty($param['endDate'])){//结束日期
					$whereInner[] = $dateField.' <= "%s"';
					$whereValuesInner[] = $param['endDate'].' 23:59:59';
				}
				if(!empty($param['sysPlatform'])){//系统平台
					$where[] = ' a.sys_platform = "%s"';
					$whereValues[] = $param['sysPlatform'];
					$groupStr .= ',a.sys_platform';
				}
				if(!empty($param['channel'])){//渠道
					$channelArr = explode(',',$param['channel']);
					if(count($channelArr)>1){
						$valStr = "";
						foreach ($channelArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' d.channel_name in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['channel'];
						$where[] = ' d.channel_name = "%s"';
					}	
					$groupStr .= ',a.channel';
				}
				if(!empty($param['prdVersion'])){//产品版本
					$prdVersArr = explode(',',$param['prdVersion']);
							if(count($prdVersArr)>1){
							$valStr = "";
						foreach ($prdVersArr as $val){
						$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.prd_version in (%s)';
						$valStr = rtrim($valStr,',');
						$whereValues[] = $valStr;
					}else{
						$whereValues[] = $param['prdVersion'];
							$where[] = ' a.prd_version= "%s"';
					}
					$groupStr .= ',a.prd_version';
				}
				if (!empty($param['country'])){ // 指定国家
					$countryArr = explode(',',$param['country']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.country in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['country'];
						$where[] = ' a.country = "%s"';
					}
				}
				if (!empty($param['province'])){ // 指定省份
					$countryArr = explode(',',$param['province']);
					if(count($countryArr)>1){
						$valStr = "";
						foreach ($countryArr as $val){
							$valStr .= '"'.$val.'",';
						}
						$where[] = ' a.province in (%s)';
						$whereValues[] = rtrim($valStr,',');
					}else{
						$whereValues[] = $param['province'];
						$where[] = ' a.province = "%s"';
					}
				}
				
				if ($where) {
					$where = join(' AND ', $where);
					$where = vsprintf($where, $whereValues);
					$whereStr = ' WHERE ' . $where;
				}
				if ($whereInner) {
					$whereInner = join(' AND ', $whereInner);
					$whereInner = vsprintf($whereInner, $whereValuesInner);
					$whereStrInner = ' WHERE ' . $whereInner;
				}
				$sql = "SELECT
							{$dateField} as date,
						   DATE_FORMAT({$dateField}, \"%x-%v\") gb_index,
						   a.sys_platform,d.channel_name as channel,a.prd_version,
						   sum(a.week_active_cnt)/sum(a.p30_active_cnt) AS count
					FROM
						   st_day_week_active_ratio a
					INNER JOIN (
						   SELECT
						   			DATE_FORMAT({$dateField}, \"%x-%v\") AS weekIdx,
						            max(date) AS date
						   FROM
						            st_day_week_active_ratio a
						   {$whereStrInner}
						   GROUP BY
						            weekIdx
						) b ON a.date = b.date LEFT JOIN channel_info AS d ON a.channel = d.channel {$whereStr}
					GROUP BY   gb_index {$groupStr}";
				unset($param, $where);//对变量进行释放
				$param = $where = array();
				break;
			default:
				die('类型错误');
		}
		isset($param) === false && $param = array();
		isset($where) === false && $where = array();
		// 组装 Where
		if(!empty($param['startDate'])){//开始日期
			$where[] = $dateField.' >= "%s"';
			$whereValues[] = $param['startDate'];
		}
		if(!empty($param['endDate'])){//结束日期
			$where[] = $dateField.' <= "%s"';
			$whereValues[] = $param['endDate'].' 23:59:59';
		}
		if ($where) {
			$where = join(' AND ', $where);
			$where = vsprintf($where, $whereValues);
			$sql = $sql . ' WHERE ' . $where;
		} else {
			$whereValues = false;
		}

		if($groupBy){
			$sql = $sql . $groupBy;
		}
		// 设定返回行数
		$sql = $this->_addSqlLimit($sql, $start, $limit);
		$userStats = $this->query($sql);
		return  $userStats;
	}
	//定义SQL组件
	private static $_SQL_PART = array(
			'active'=>array(
					'1'=>array(/*活跃用户量*/
							'd'=>array('groupDate'=>' date_format(di.date, "%Y-%j") AS gb_index '),
							'w'=>array('groupDate'=>' date_format(di.time, "%x-%v") AS gb_index '),
							'm'=>array('groupDate'=>' date_format(di.time, "%Y-%c") AS gb_index ')
					),
					'4'=>array(/*人均登陆次数*/
							'd'=>array(
									'groupDate'=>' date_format(uli.login_time, "%Y-%j") AS gb_index ',
									'groupBy'=>' GROUP BY gb_index,uli.channel,uli.prd_version '
							),
							'w'=>array('groupDate'=>' date_format(uli.login_time, "%x-%v") AS gb_index ',
											'groupBy'=>' GROUP BY gb_index,uli.channel,uli.prd_version '
							),
							'm'=>array('groupDate'=>' date_format(uli.login_time, "%Y-%c") AS gb_index ',
										'groupBy'=>' GROUP BY gb_index,uli.channel,uli.prd_version '
							)
					),
					'11'=>array(/*计算周、月活跃量次数*/
							'w'=>array('groupDate'=>',date_format(di.time, "%x-%v") AS gb_index ',
										 'groupBy'=>' GROUP BY di.sys_platform,di.channel,gb_index '
							),
							'm'=>array('groupDate'=>' date_format(di.time, "%Y-%c") AS gb_index ',
										'groupBy'=>' GROUP BY di.sys_platform,di.channel,di.prd_version,gb_index '
							)
					),
					'5'=>array(/*计算周、月活跃量次数*/
							'd'=>array('groupDate'=>' ,date_format(a.date, "%Y-%j") AS gb_index ',
									'groupBy'=>' GROUP BY a.channel,gb_index '
							),
					),
					'6'=>array(/*计算周、月活跃量次数*/
							'w'=>array('groupDate'=>' date_format(a.date, "%x-%v") AS gb_index ',
									'groupBy'=>' GROUP BY di.sys_platform,di.channel,gb_index '
							),
							'm'=>array('groupDate'=>' date_format(di.time, "%Y-%c") AS gb_index ',
									'groupBy'=>' GROUP BY di.sys_platform,di.channel,di.prd_version,gb_index '
							)
					),
			),
			'remain'=>array(
					'7'=>array(/*注册用户数*/
							'd'=>array(
										'groupDate'=>',date_format(ur.reg_time, "%Y-%m-%d") AS gb_index ',
										'groupBy'=>' GROUP BY dei.channel,gb_index '
									),
							'w'=>array('groupDate'=>',date_format(ur.reg_time, "%x-%v") AS gb_index ',
										'groupBy'=>' GROUP BY dei.channel,gb_index '),
							'm'=>array('groupDate'=>',date_format(ur.reg_time, "%Y-%c") AS gb_index ',
										'groupBy'=>' GROUP BY dei.channel,gb_index ')
					),
			)
	);

	/**
	 * 查询留存用户信息
	 */
	public function getRemaned($param,$start=0,$limit=1000)
	{
		$where = $whereValues = array();
		$statField = $groupBy = $groupStr = '';
		// 组装 Group by
		isset($param['statType']) ? null : ($param['statType'] = 'd');
		switch(strtolower($param['statType'])) {
			case 'm': // 按月显示
				$statField = ',date_format(di.date, "%Y-%c") AS stat_index';
				break;
			case 'w': // 按周显示
				$statField = ',date_format(di.date, "%x-%v") AS stat_index';
				break;
			default: // 默认按天显示
				$statField = ',date_format(di.date, "%Y-%m-%d") AS stat_index';
		}
		
		// 组装 Where
		if(!empty($param['sysPlatform'])){//系统平台
			$where[] = ' di.sys_platform = "%s"';
			$whereValues[] = $param['sysPlatform'];
			$groupStr .= ',di.sys_platform';
		}
		if(!empty($param['channel'])){//渠道
			$channelArr = explode(',',$param['channel']);
			if(count($channelArr)>1){
				$valStr = "";
				foreach ($channelArr as $val){
					$valStr .= '"'.$val.'",';
				}
				$where[] = ' d.channel_name in (%s)';
				$valStr = rtrim($valStr,',');
				$whereValues[] = $valStr;
			}else{
				$whereValues[] = $param['channel'];
				$where[] = ' d.channel_name = "%s"';
			}
			$groupStr .= ',di.channel';
		}
		
		if(!empty($param['startDate'])){//开始日期
			$where[] = ' di.date >= "%s"';
			$whereValues[] = $param['startDate'];
		}
		if(!empty($param['endDate'])){//结束日期
			$where[] = ' di.date <= "%s"';
			$whereValues[] = $param['endDate'].' 23:59:59';
		}

		$groupBy =  " GROUP BY  stat_index {$groupStr}";		
		//日留存用户量：
		$sql = "SELECT 	sum(di.one) as one_c,sum(di.two) as two_c,sum(di.three) as three_c,
	       				sum(di.seven) as seven_c,sum(di.ten) as ten_c,
	       				sum(di.fourteen) as fourteen_c, sum(di.thirty) as thirty_c,
	                    di.date, di.sys_platform, di.channel,di.fourteen,di.thirty {$statField}, sum(reg_cnt) as reg_cnt,
	                    d.channel_name AS channel
	       FROM st_user_remain di
           LEFT JOIN channel_info d ON di.channel = d.channel
	       "; //where di.sys_platform = ? AND di.date = ?  GROUP BY  di.channel

		if ($where) {
			$where = join(' AND ', $where);
			$where = vsprintf($where, $whereValues);
			$sql = $sql . ' WHERE ' . $where;
		} else {
			$whereValues = false;
		}

		$sql = $sql . $groupBy;
		// 设定返回行数
		$sql = $this->_addSqlLimit($sql, $start, $limit);
		$userStats = $this->query($sql);
		return  $userStats;
	}
	/**
	 * 累加流水用户量、日流失用户量、日回流用户量
	 * @param unknown $param
	 * @param number $start
	 * @param number $limit
	 * @return \Think\mixed
	 */
	public function getUserQuantity($param,$start=0,$limit=1000)
	{
		$where = $whereValues = array();
		$groupStr = $joinWhere = '';
		// 组装 Where
		if(!empty($param['sysPlatform'])){//系统平台
			$where[] = ' di.sys_platform = "%s"';
			$whereValues[] = $param['sysPlatform'];
			$groupStr .= ',di.sys_platform';
			$joinWhere .= ' AND c.sys_platform = e.sys_platform ';
		}
		if(!empty($param['channel'])){//渠道
			$channelArr = explode(',',$param['channel']);
			if(count($channelArr)>1){
				$valStr = "";
				foreach ($channelArr as $val){
					$valStr .= '"'.$val.'",';
				}
				$where[] = ' d.channel_name in (%s)';
				$valStr = rtrim($valStr,',');
				$whereValues[] = $valStr;
			}else{
				$whereValues[] = $param['channel'];
				$where[] = ' d.channel_name = "%s"';
			}
			$groupStr .= ',di.channel';
			$joinWhere .= ' AND c.channel_id = e.channel_id ';
		}
		if(!empty($param['prdVersion']) && $param['dataType'] != '3'){//产品版本
			$prdVersArr = explode(',',$param['prdVersion']);
			if(count($prdVersArr)>1){
				$valStr = "";
				foreach ($prdVersArr as $val){
					$valStr .= '"'.$val.'",';
				}
				$where[] = ' di.prd_version in (%s)';
				$valStr = rtrim($valStr,',');
				$whereValues[] = $valStr;
			}else{
				$whereValues[] = $param['prdVersion'];
				$where[] = ' di.prd_version= "%s"';
			}
			$groupStr .= ',di.prd_version';
			$joinWhere .= ' AND c.prd_version = e.prd_version ';
		}
		
		$param['dataType']>=4 ? ($prdVersion=",di.prd_version") : null;
		$groupBy = " GROUP BY  date {$groupStr}";
		$dateField = 'di.date'; //convert_tz(di.date, "'. $this->from_tz .'", "'. $this->to_tz .'")

		$tableNameSet = array(
				'3'=>'st_cumulative_lose', //累计流失用户量
				'4'=>'st_daily_lose', //日流失用户量
				'5'=>'st_daily_back', //日回流用户量

		);
		$tableColumn = array(
				'3'=>",sum(di.cumulative_active_cnt) AS active_cnt,sum(di.seven) as seven_c, sum(di.fourteen) as fourteen_c, sum(di.thirty) as thirty_c,\"--\" as prd_version", //累计流失用户量
				'4'=>',sum(di.active_cnt) AS active_cnt,sum(di.lt_7) as seven_c, sum(di.ge_7_le_14) as fourteen_c, sum(di.gt_14_le_30) as thirty_c, sum(di.gt_30) as gt_thirty_c,di.prd_version', //日流失用户量
				'5'=>',sum(di.lt_7) as seven_c, sum(di.ge_7_le_14) as fourteen_c, sum(di.gt_14_le_30) as thirty_c, sum(di.gt_30) as gt_thirty_c,di.prd_version', //日回流用户量

		);
		
		$tableName = isset($tableNameSet[$param['dataType']]) ? $tableNameSet[$param['dataType']] : die('param is error!not find db table');
		$column = isset($tableColumn[$param['dataType']]) ? $tableColumn[$param['dataType']] : die('param is error!not find table column');
		$sql = " SELECT DATE_FORMAT({$dateField}, \"%Y-%m-%d\")  as date, di.sys_platform, di.channel AS channel_id,
                       d.channel_name AS channel
		               {$column}
		       FROM {$tableName} di
		       LEFT JOIN channel_info d ON di.channel = d.channel
		"; 

		if(!empty($param['startDate'])){//开始日期
			$where[] = $dateField.' >= "%s"';
			$whereValues[] = $param['startDate'];
		}
		if(!empty($param['endDate'])){//结束日期
			$where[] = $dateField.' <= "%s"';
			$whereValues[] = $param['endDate'].' 23:59:59';
		}

			if ($where) {
				$where = join(' AND ', $where);
				$where = vsprintf($where, $whereValues);
				$sql = $sql . ' WHERE ' . $where;
			} else {
				$whereValues = false;
			}

			$sql = $sql . $groupBy;
			
			if($param['dataType'] == 5){
				//单独处理日回流用户量中日流水用户量
				$sql = "SELECT
							c.date,
							c.sys_platform,
							c.channel_id,
							c.channel,
							c.seven_c,
							c.fourteen_c,
							c.thirty_c,
							c.gt_thirty_c,
							c.prd_version,
							ifnull(e.lt_7, 0) lt_7,
							ifnull(e.ge_7_le_14, 0) ge_7_le_14,
							ifnull(e.gt_14_le_30, 0) gt_14_le_30,
							ifnull(e.gt_30, 0) gt_30
						FROM
							(
								SELECT
									di.date,
									di.sys_platform,
									di.channel AS channel_id,
									d.channel_name AS channel,
									sum(di.lt_7) AS seven_c,
									sum(di.ge_7_le_14) AS fourteen_c,
									sum(di.gt_14_le_30) AS thirty_c,
									sum(di.gt_30) AS gt_thirty_c,
									di.prd_version
								FROM
									st_daily_back di
						    LEFT JOIN channel_info d ON di.channel = d.channel
								WHERE {$where}			
								GROUP BY
									di.date {$groupStr}
							) AS c
						LEFT JOIN (
							SELECT
								di.date,
								di.sys_platform,
								di.channel AS channel_id,
								d.channel_name AS channel,
								di.prd_version,
								sum(di.lt_7) AS lt_7,
								sum(di.ge_7_le_14) AS ge_7_le_14,
								sum(di.gt_14_le_30) AS gt_14_le_30,
								sum(di.gt_30) AS gt_30
							FROM
								st_daily_lose di
						 LEFT JOIN channel_info d ON di.channel = d.channel
							WHERE {$where}
							GROUP BY
								di.date {$groupStr}
						) AS e ON c.date = e.date ".$joinWhere;
			}
					// 设定返回行数
			$sql = $this->_addSqlLimit($sql, $start, $limit);
			$userStats = $this->query($sql);
			return  $userStats;
	}

	/**
	 * 留存用户量中-->注册用户数
	 * @param unknown $param
	 * @param number $start
	 * @param number $limit
	 * @return \Think\mixed
	 */
	public function getResterUser($param,$start=0,$limit=1)
	{
		$where = $whereValues = array();
		$groupBy = self::$_SQL_PART['remain']['7'][$param['statType']]['groupBy'];
		$dateField = self::$_SQL_PART['remain']['7'][$param['statType']]['groupDate'];
		$dateFieldPart = ',DATE_FORMAT(ur.reg_time,"%Y-%m-%d") as date';
		$sql = "SELECT
					  COUNT(ur.id) as count
					  {$dateFieldPart}
					  {$dateField}
					  ,dei.channel
				FROM user_register_info as ur
				INNER JOIN device_info as dei ON dei.id = ur.device_id
		"; //where di.sys_platform = ? AND di.date = ?  GROUP BY  di.channel
		// 组装 Where
		if(!empty($param['sysPlatform'])){//系统平台
			$where[] = ' dei.sys_platform = "%s"';
			$whereValues[] = $param['sysPlatform'];
		}
		if(!empty($param['channel'])){//渠道
			$where[] = ' dei.channel = "%s"';
			$whereValues[] = $param['channel'];
		}
		if(!empty($param['startDate'])){//开始日期
			$where[] = ' ur.reg_time >= "%s"';
			$whereValues[] = $param['startDate'];
		}
		if(!empty($param['endDate'])){//结束日期
			$where[] = ' ur.reg_time <= "%s"';
			$whereValues[] = $param['endDate'].' 23:59:59';
		}

		if ($where) {
			$where = join(' AND ', $where);
			$where = vsprintf($where, $whereValues);
			$sql = $sql . ' WHERE ' . $where;
		} else {
			$whereValues = false;
		}

		$groupBy && $sql = $sql . $groupBy;
		// 设定返回行数
		$sql = $this->_addSqlLimit($sql, $start, $limit);
		$userStats = $this->query($sql);
		return  $userStats;
	}

	/**
	 * 合作商统计
	 * @param unknown $param
	 * @return \Think\mixed
	 */
	public function getPartnerStat($param)
	{
		$where = $whereValues = array ();
		$dateField = '';
		$groupBy = $groupStr = '';
		switch ($param ['dataType']) {
			case '1' : // 累计合作商数量
				$whereStr = '';
				$dateField = 'a.date';
				if (! empty ( $param ['startDate'] )) { // 结束日期
					$where [] = $dateField . ' >= "%s"';
					$whereValues [] = $param ['startDate'];
				}
				if (! empty ( $param ['endDate'] )) { // 结束日期
					$where [] = $dateField . ' <= "%s"';
					$whereValues [] = $param ['endDate'] . ' 23:59:59';
				}
				if (! empty ( $param ['entType'] )) { // 系统平台
					$where [] = ' a.type = "%s"';
					$whereValues [] = $param ['entType'];
					$groupStr .= ',a.type';
				}else{
					$where [] = ' (a.type = "%s" OR a.type = "%s")';
					$whereValues [] = 1;
					$whereValues [] = 2;
				}			
				
				if ($where) {
					$where = join ( ' AND ', $where );
					$where = vsprintf ( $where, $whereValues );
					$whereStr = ' WHERE ' . $where;
				}
				$groupDateRegex = $this->dateTypeArr['d'];
			    $sql="select DATE_FORMAT({$dateField}, {$groupDateRegex}) as gb_index, sum(a.cumulative_biz_num) as count
						from st_scanner_cumulative_biz_info a
						{$whereStr}
						GROUP BY a.date{$groupStr}";
				
				unset ( $param, $where ); // 对变量进行释放
				$param = $where = array ();
				break;
				
			case '2' : // 新增合作商数量
				$whereStr = '';
				$dateField = 'a.create_time';
				if (! empty ( $param ['startDate'] )) { // 结束日期
					$where [] = $dateField . ' >= UNIX_TIMESTAMP("%s")';
					$whereValues [] = $param ['startDate'];
				}
				if (! empty ( $param ['endDate'] )) { // 结束日期
					$where [] = $dateField . ' <= UNIX_TIMESTAMP("%s")';
					$whereValues [] = $param ['endDate'] . ' 23:59:59';
				}
				if (! empty ( $param ['entType'] )) { // 系统平台
					$where [] = ' a.type = "%s"';
					$whereValues [] = $param ['entType'];
					$groupStr .= ',a.type';
				}else{
					$where [] = ' (a.type = "%s" OR a.type = "%s")';
					$whereValues [] = 1;
					$whereValues [] = 2;
				}
				
				if ($where) {
					$where = join ( ' AND ', $where );
					$where = vsprintf ( $where, $whereValues );
					$whereStr = ' WHERE ' . $where;
				}
				//$dateTypeArr = array('d'=>'"%Y-%m-%d"','w'=>'"%x-%v"','m'=>'"%Y-%c"');
				$groupDateRegex = $this->dateTypeArr [$param ['statType']];
				$groupDayArr = array('d'=>'gb_day','w'=>'gb_week','m'=>'gb_month');
				$groupDay = $groupDayArr[$param ['statType']];
				
				$dateField = 'a.create_time';//'convert_tz(a.create_time, "' . $this->from_tz . '", "' . $this->to_tz . '")';				
				$sql = "select DATE_FORMAT(FROM_UNIXTIME({$dateField}), {$groupDateRegex}) as gb_index, 
						count(1) as count
						from scanner_biz_info a
						{$whereStr}
						GROUP BY a.{$groupDay} {$groupStr}";				
			break;	
			default :
				die ( '类型错误' );
		}
		$userStats = $this->query ( $sql );
		return $userStats;
	}
		
	/**
	 * 在SQL语句中添加 LIMIT start,pos
	 * @param string $sql 待处理的sql
	 * @param int $start 开始位置
	 * @param int $limit 返回限制行数
	 * @return string
	 */
	protected function _addSqlLimit ($sql, $start=null, $limit=null)
	{
		return $sql;
	}
}

