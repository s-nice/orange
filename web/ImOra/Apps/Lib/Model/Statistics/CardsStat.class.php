<?php
namespace Model\Statistics;

use \Think\Model;
use Appadmin\Controller\AdminBaseController;

class CardsStat extends Model
{
     private $indexArr = array('d'=>'%Y %j','w'=>'%x %v','m'=>'%Y %c');
     private $cardType = "('scan','selfadd','contacts','exchage','qrscan')";
     public $to_tz   = '+08:00';
     public $from_tz = '+00:00';

     /**
      * 获取累计名片数 和 累计添加名片用户数 
      * 页面头部公用部分|cardsFiveStat
      * SELECT COUNT(id) AS cardNum , COUNT(DISTINCT user_id) AS userNum 
		FROM user_add_card
      * @return array
      */
     public function getCardAndUserNum($conditions=array())
     {
     	$total = array();
     	$where = array();
     	// 时区转换 | 组装表查询条件
     	if(isset($conditions['statType'])){
     		// cardsFiveStat 页面部分
     		$time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
     		isset($conditions['startDate']) && $where[] = "{$time} >= '{$conditions['startDate']}'";
     		isset($conditions['endDate']) && $where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
     		$where = empty($where)? " where card_from in {$this->cardType} ": " where card_from in {$this->cardType} and ".join(' and ',$where);
     		$sql = 'SELECT 
     					sys_platform,
     					COUNT(id) AS cardNum , 
	     				'.$time.' AS datatime,
	        			date_format('.$time.', "'. $this->indexArr[$conditions['statType']] .'") AS timeindex
        			FROM user_add_card '.$where.'  
     				GROUP BY timeindex 
        			ORDER BY timeindex';
     	}else{
     		// 名片夹头部公用部分
     		$sql = 'SELECT COUNT(id) AS cardNum , COUNT(DISTINCT user_id) AS userNum FROM user_add_card where card_from in '.$this->cardType;
     	}
     	
		$total = $this->query($sql);
		return $total;
	}
    /**
     * 获取用户添加名片数目统计数据
     * @param array $$conditions 添加名片数目数据的限制条件
     * @return array
     */
    public function getAddCardNumStat ($conditions=array(),$statType ='d')
    {
        $userStats = array();
        $where = array();
        // 时区转换
        $time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	// 组装表查询条件
    	isset($conditions['sys_platform']) && $where[] = 'sys_platform = "'.$conditions['sys_platform'].'"';
    	isset($conditions['startDate']) && $where[] = "{$time} >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? ' ': ' where '.join(' and ',$where);
        // 月周日分组
        in_array($statType,array('d','w','m')) || $statType = 'd';
        
        $sql = 'SELECT card_from,sys_platform, 
	        		COUNT(id) AS cardNum , 
        			'.$time.' AS datatime,
        			date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindex 
        		FROM user_add_card '.$where.' 
        		GROUP BY card_from';
        /* // 系统平台分组
        if(!isset($conditions['sys_platform']) || empty($conditions['sys_platform'])){
        	$sql .= " , sys_platform";
        }
        */
        $sql .= " , timeindex ORDER BY timeindex";
//         var_dump($sql);
        $userStats = $this->query($sql);
        return $userStats;
    }
    /**
     * 获取添加名片用户数目统计数据
     * @param array $conditions 条件限制
     * @return array
     */
    public function getAddCardUserNumStat ($conditions=array(),$statType ='d')
    {
    	$userStats = array();
    	$where = $whereA = array();
    	// 时区转换
    	$time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	$timeA = 'convert_tz(a.time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	 
    	// 组装表查询条件
    	if(isset($conditions['sys_platform'])){
    		$where[] = 'sys_platform = "'.$conditions['sys_platform'].'"';
    		$whereA[] = 'a.sys_platform = "'.$conditions['sys_platform'].'"';
    	}
    	if(isset($conditions['startDate'])){
    		$where[] = "{$time} >= '{$conditions['startDate']}'";
    		$whereA[] = "{$timeA} >= '{$conditions['startDate']}'";
    	}
    	if(isset($conditions['endDate'])){
    		$where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    		$whereA[] = "{$timeA} <= '{$conditions['endDate']} 23:59:59'";
    	}
    	$where = empty($where)? " where card_from in {$this->cardType}" : " where card_from in {$this->cardType} and ".join(' and ',$where);
    	$whereA = empty($whereA)? " where a.card_from in {$this->cardType}": " where a.card_from in {$this->cardType} and ".join(' and ',$whereA);
    	
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	$sql = 'SELECT a.card_from,a.sys_platform,b.totalNum ,
    					COUNT(DISTINCT a.user_id) AS userNum ,
    					'.$timeA.' AS datatime,
        				date_format('.$timeA.', "'. $this->indexArr[$statType] .'") AS timeindex 
        		FROM user_add_card as a 
        		LEFT JOIN 
        				(SELECT 
        						COUNT(DISTINCT user_id) AS totalNum,
        						date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindexb 
        				FROM user_add_card '.$where.' 
        				GROUP BY timeindexb) as b 
        		ON date_format('.$timeA.', "'. $this->indexArr[$statType] .'") = b.timeindexb '.$whereA.' 
        		GROUP BY a.card_from';
    	
    	
    	// 系统平台分组
    	/* if(!isset($conditions['sys_platform']) || empty($conditions['sys_platform'])){
    		$sql .= " , a.sys_platform";
    	}*/
    	$sql .= " , timeindex ORDER BY timeindex";
//     	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 获取新建好友关系数目统计数据
     * @param array $conditions 条件限制
     * @return array
     */
    public function getAddFriendNumStat ($conditions=array(),$statType ='d')
    {
    	$userStats = array();
    	$where = array();
    	// 时区转换
    	$time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	// 组装表查询条件
    	isset($conditions['sys_platform']) && $where[] = 'sys_platform = "'.$conditions['sys_platform'].'"';
    	isset($conditions['startDate']) && $where[] = "{$time} >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? ' ': ' where '.join(' and ',$where);
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	$sql = 'SELECT source,sys_platform,
    			COUNT(id) AS friendNum , 
    			'.$time.' AS datatime, 
        		date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindex 
        		FROM user_add_friend '.$where.' 
        		GROUP BY source';
    	/*// 系统平台分组
    	if(!isset($conditions['sys_platform']) || empty($conditions['sys_platform'])){
    		$sql .= " , sys_platform";
    	}
    	*/

    	$sql .= " , timeindex ORDER BY timeindex";
//     	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 获取推荐好友关系数目统计数据
     * @param array $conditions 条件限制
     * @return array
     */
    public function getRecommendNumStat ($conditions=array(),$statType ='d')
    {
    	$userStats = array();
    	$where = array();
    	// 时区转换
    	$time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	// 组装表查询条件
    	isset($conditions['sys_platform']) && $where[] = 'sys_platform = "'.$conditions['sys_platform'].'"';
    	isset($conditions['startDate']) && $where[] = "{$time} >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? " where status = '0' ": " where status = '0' and ".join(' and ',$where);
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	
    	$totalArr = array();
    	$sql = 'SELECT sys_platform,
	    			COUNT(id) AS sendNum ,
    				COUNT(DISTINCT user_id) AS userNum,
	    			'.$time.' AS datatime,
	    			date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindex
	    	    	FROM card_recommend_letter '.$where;
    	$groupby = '';
    	/* // 系统平台分组
    	if(!isset($conditions['sys_platform']) || empty($conditions['sys_platform'])){
    		$groupby .= " sys_platform";
    	}
    	*/
    	
    	$groupby .= " , timeindex";
    	if($groupby != ''){
    		$sql = $sql.' GROUP BY '.ltrim($groupby,' , ');
    	}
    	$sql .= ' ORDER BY timeindex';
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 累计名片数目 cardFiveStat
     * @param array $conditions 时间数组
     * @return array
     */
    public function getFiveInfo($conditions=array()){
    	$userStats = array();
    	$where = array();
    	// 时区转换
//     	$time = 'convert_tz(date, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	$time = 'date';
    	 
    	// 组装表查询条件
    	if(isset($conditions['startDate'])){
    		$where[] = "{$time} >= '{$conditions['startDate']}'";
    	}
    	if(isset($conditions['endDate'])){
    		$where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	}
    	$where = empty($where)? ' ' : " where ".join(' and ',$where);
    	// 月周日分组
    	in_array($conditions['statType'],array('d','w','m')) || $conditions['statType'] = 'd';
    	$sql = 'SELECT 
    			'.$time.' AS datatime,
    			cumulative_card_cnt As cardNum,
    			date_format('.$time.', "'. $this->indexArr[$conditions['statType']] .'") AS timeindex
    			FROM st_cumulative_add_card '.$where.' 
    			ORDER BY timeindex';		
//     	    	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 使用名片添加功能用户数比例 cardSixStat
     * @param array $conditions 条件限制
     * @return array
     */
    public function getSixInfo($conditions=array(),$statType ='d'){
    	$userStats = array();
    	$where = $whereA = array();
    	// 时区转换
    	$timeA = 'convert_tz(a.time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	$time = 'convert_tz(date, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	// 组装表查询条件
    	if(isset($conditions['startDate'])){
    		$whereA[] = "{$timeA} >= '{$conditions['startDate']}'";
    		$where[] = "{$time} >= '{$conditions['startDate']}'";
    	}
    	if(isset($conditions['endDate'])){
    		$whereA[] = "{$timeA} <= '{$conditions['endDate']} 23:59:59'";
    		$where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	}
    	$whereA = empty($whereA)? " where a.card_from in {$this->cardType}" : " where a.card_from in {$this->cardType} and ".join(' and ',$whereA);
    	$where = empty($where)? ' ' : " where ".join(' and ',$where);
    	 
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	$sql = 'SELECT b.activeUserNum ,
    				   COUNT(DISTINCT a.user_id) AS userNum ,
    				   '.$timeA.' AS datatime,
        			   date_format('.$timeA.', "'. $this->indexArr[$statType] .'") AS timeindex
        		FROM user_add_card as a
        		LEFT JOIN 
        				(SELECT
        						COUNT(DISTINCT user_id) AS activeUserNum,
        						date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindexb
        				FROM user_daily_last_login '.$where.'
        				GROUP BY timeindexb) as b
        		ON date_format('.$timeA.', "'. $this->indexArr[$statType] .'") = b.timeindexb '.$whereA.'
        		GROUP BY timeindex 
        		ORDER BY timeindex';
//     	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 累计添加过名片的用户数 cardSevenStat
     * @param array $conditions 条件限制
     * @return array
     */
    public function getSevenInfo($conditions=array(),$statType ='d'){
    	$userStats = array();
    	$where = array();
		$time = 'date';
    	// 组装表查询条件
    	if(isset($conditions['startDate'])){
    		$where[] = "{$time} >= '{$conditions['startDate']}'";
    	}
    	if(isset($conditions['endDate'])){
    		$where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	}
    	$where = empty($where)? " " : " where ".join(' and ',$where);
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	
    	$sql = 'SELECT cumulative_active_cnt AS activeUserNum ,
    				   cumulative_user_cnt AS userNum ,
    				   '.$time.' AS datatime,
        			   date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindex
        		FROM st_cumulative_add_card '.$where.'
        		ORDER BY timeindex';
//     	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }
    /**
     * 第三方推荐建立好友关系成功率 cardEightStat
     * @param array $conditions 条件限制
     * @return array
     */
    public function getEightInfo($conditions=array(),$statType ='d'){
    	$userStats = array();
    	$where = array();
    	// 时区转换
    	$time = 'convert_tz(time, "'. $this->from_tz .'", "'. $this->to_tz .'")';
    	// 组装表查询条件
    	isset($conditions['startDate']) && $where[] = "{$time} >= '{$conditions['startDate']}'";
    	isset($conditions['endDate']) && $where[] = "{$time} <= '{$conditions['endDate']} 23:59:59'";
    	$where = empty($where)? " where status in('0','2') ": " where status in('0','2') and ".join(' and ',$where);
    	// 月周日分组
    	in_array($statType,array('d','w','m')) || $statType = 'd';
    	$sql = 'SELECT status,
    			COUNT(id) AS recommendNum , 
    			'.$time.' AS datatime,
    			date_format('.$time.', "'. $this->indexArr[$statType] .'") AS timeindex
    	    	FROM card_recommend_letter '.$where.' 
    	    	GROUP BY status,timeindex 
    	    	ORDER BY timeindex';
//     	var_dump($sql);
    	$userStats = $this->query($sql);
    	return $userStats;
    }


}
