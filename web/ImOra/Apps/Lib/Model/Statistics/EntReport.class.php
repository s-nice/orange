<?php
namespace Model\Statistics;
use \Think\Model;

class EntReport extends Model
{
     public $from_tz = '+00:00';//原始时区
     public $to_tz   = '+08:00';//要转换到的时区
     private $dateTypeArr = array('d'=>'"%Y-%j"','w'=>'"%x-%v"','m'=>'"%Y-%c"');//定义mysql中一年内中第几天、第几周、第几个月格式

     /**
      * 获取名片行业占比统计
      */
     public function getCardIndusRate($param=array())
     {
     	$sort = '';
     	if(!empty($param['sort'])){
     		$sort = " ORDER BY ".str_replace(',', ' ', $param['sort']);
     	}
     	$sql = "SELECT category_name as name, COUNT(card_id) as 'value' FROM biz_card_industry WHERE biz_id = '%s'  GROUP BY category_name {$sort}";
     	$sql = sprintf($sql,$param['bizid']);
     	$userStats = $this->query ( $sql );
     	return $userStats;
     }
     /**
      * 获取名片区域占比
      */
     public function getCardAreaRate($param=array())
     {
     	$sort = '';
     	if(!empty($param['sort'])){
     		$sort = " ORDER BY ".str_replace(',', ' ', $param['sort']);
     	}
     	$sql = "SELECT province as name, COUNT(distinct card_id) as value
				FROM biz_employee_cards
				WHERE biz_id = '%s' 
				GROUP BY province {$sort}";
     	$sql = sprintf($sql,$param['bizid']);
     	$userStats = $this->query ( $sql );
     	return $userStats;
     }
	/**
	 * 名片增幅趋势统计
	 * @param unknown $param
	 * @return \Think\mixed
	 */
	public function getPartnerStat($param=array())
	{
		$where = $whereValues = array ();
		$dateField = '';
		$groupBy = $groupStr = '';
		$whereStr = '';
		$dateField = 'created_time';
		$where [] = ' biz_id = "%s"';
		$whereValues [] = $param ['bizid'];
		if (! empty ( $param ['startDate'] )) { // 结束日期
			$where [] = $dateField . ' >= "%s"';
			$whereValues [] = $param ['startDate'];
		}
		if (! empty ( $param ['endDate'] )) { // 结束日期
			$where [] = $dateField . ' <= "%s"';
			$whereValues [] = $param ['endDate'] . ' 23:59:59';
		}
		if (! empty ( $param ['departId'] )) { // 部门
			$where [] = ' department = "%s"';
			$whereValues [] = $param ['departId'];
		}
		if(!empty($param['employId'])){ //员工
			$where [] = ' name = "%s"';
			$whereValues [] = $param ['employId'];
		}
		
		if ($where) {
			$where = join ( ' AND ', $where );
			$where = vsprintf ( $where, $whereValues );
			$whereStr = ' WHERE ' . $where;
		}
		$groupDateRegex = $this->dateTypeArr [$param ['statType']];
		$groupDayArr = array('d'=>'gb_day','w'=>'gb_week','m'=>'gb_month');
		$groupDay = $groupDayArr[$param ['statType']];
		$dateField = 'created_time';//'convert_tz(a.create_time, "' . $this->from_tz . '", "' . $this->to_tz . '")';				
		$groupDateRegex    = $this->dateTypeArr[$param['statType']];
		$sql = "SELECT DATE(created_time) as date, DATE_FORMAT({$dateField}, $groupDateRegex) AS gb_index, department, empl_id, name,COUNT(distinct card_id) count ".
			   'FROM biz_employee_cards '.
				"{$whereStr} ".
			   'GROUP BY gb_index, department';			
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

