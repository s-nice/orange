<?php
namespace Model\Statistics;

use \Think\Model;
use Appadmin\Controller\AdminBaseController;

class ScannerStat extends Model
{
     private $indexArr = array('d'=>'%Y %j','w'=>'%x %v','m'=>'%Y %c');
     private $timeArr = array('d'=>'day','w'=>'week','m'=>'month');
     public $to_tz   = '+08:00';
     public $from_tz = '+00:00';

    /**
     * 获取使用扫描仪次数数目统计数据
     * @param array $$conditions 限制条件
     * @return array
     */
    public function getUsescannerNumStat ($conditions=array(),$statType ='d')
    {
        $userStats = array();
        $where = array();
    	// 组装表查询条件
    	$conditions['type'] != 'all' && $where[] = 'type = "'.$conditions['type'].'"';
    	isset($conditions['startDate']) && $where[] = "date >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "date <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? ' ': ' where '.join(' and ',$where);
        // 月周日分组
        in_array($statType,array('d','w','m')) || $statType = 'd';
        if($conditions['type'] == 'all'){
        	$sql = 'SELECT date AS datatime, date_format(date, "'. $this->indexArr[$statType] .'") AS timeindex,
        				   sum('. $this->timeArr[$statType] .'_scanner_num) as bindscaner, sum('. $this->timeArr[$statType] .'_use_num) as total 
        				   FROM st_scanner_scan_info '.$where.'
        				   GROUP BY datatime 
        				   ORDER BY timeindex'; 
        }else{
        	$sql = 'SELECT date AS datatime, date_format(date, "'. $this->indexArr[$statType] .'") AS timeindex,
        				   '. $this->timeArr[$statType] .'_scanner_num as bindscaner, '. $this->timeArr[$statType] .'_use_num as total 
        				   FROM st_scanner_scan_info '.$where.' 
        				   ORDER BY timeindex';
        }
//         echo $sql;
        $userStats = $this->query($sql);
        return $userStats;
    }
    /**
     * 获取扫描名片数目统计数据
     * @param array $conditions 条件限制
     * @return array
     */
    public function getScancardNumStat ($conditions=array(),$statType ='d')
    {
        $userStats = array();
        $where = array();
    	// 组装表查询条件
    	$conditions['type'] != 'all' && $where[] = 'type = "'.$conditions['type'].'"';
    	isset($conditions['startDate']) && $where[] = "date >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "date <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? ' ': ' where '.join(' and ',$where);
        // 月周日分组
        in_array($statType,array('d','w','m')) || $statType = 'd';
        if($conditions['type'] == 'all'){
        	$sql = 'SELECT date AS datatime, date_format(date, "'. $this->indexArr[$statType] .'") AS timeindex,
        				   sum('. $this->timeArr[$statType] .'_scancard_num) as scancardnum 
        				   FROM st_scanner_scan_info '.$where.' 
        				   GROUP BY datatime 
        				   ORDER BY timeindex'; 
        }else{
        	$sql = 'SELECT date AS datatime, date_format(date, "'. $this->indexArr[$statType] .'") AS timeindex,
        				   '. $this->timeArr[$statType] .'_scancard_num as scancardnum 
        				   FROM st_scanner_scan_info '.$where.' 
        				   ORDER BY timeindex';
        }
//         echo $sql;
        $userStats = $this->query($sql);
        return $userStats;
    }

}
