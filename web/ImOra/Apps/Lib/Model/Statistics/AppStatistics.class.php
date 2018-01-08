<?php
namespace Model\Statistics;

use \Think\Model;

class AppStatistics extends Model
{
    protected $limit = 10;
    // 数据表名（不包含表前缀）
    protected $tableName        =   'account_employee';
    protected $localTimeZone = "+08:00"; // 用作SQL时间转换

    /**
     * 新增设备量
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getUserStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(a.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(a.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%c") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(a.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%x %%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date_format(CONVERT_TZ(a.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%j") AS date_index';
                break;
        }
        $sql = 'SELECT COUNT(a.device_id) AS count_all,
               date(CONVERT_TZ(MIN(a.activate_time), "+00:00", "'.$this->localTimeZone.'")) as time, a.sys_platform, b.channel_name as channel,'
                .$sql.
                ' FROM device_info AS a LEFT JOIN channel_info AS b ON a.channel = b.channel
                ';
        // 组装 Where 和 group by
        $groupBy = '';
        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . '  ,a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            $groupBy = $groupBy . ' , b.channel ';
        }
//          else if(! empty($conditions['doGroupBy'])) {



//         }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' a.activate_time >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.activate_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where).' AND a.history = 0';
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
           $date_index =  ' date_index ';
        }else{
            $date_index =  ', date_index ';
        }
        // 组装 Group by
       $sql = $sql . ' GROUP BY date_index ' . $groupBy;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);
        $stats = $this->query($sql, $whereValues);
        return $stats;



    }
    
    
    /**
     * 激活用户量
     * @param array $conditions 获取用户统计数据的限制条件
 	 * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function geActivateUserStat($conditions=array(), $start=null, $limit=null)
    {
    	$where = $whereValues = array();
    	isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
    	switch(strtolower($conditions['statType'])) {
    		case 'year': // 按年显示
    			$sql = 'date_format(CONVERT_TZ(a.time, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
    			break;
    		case 'month': // 按月显示
    			$sql = 'date_format(CONVERT_TZ(a.time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%c") AS date_index';
    			break;
    		case 'week': // 按周显示
    			$sql = 'date_format(CONVERT_TZ(a.time, "+00:00", "'.$this->localTimeZone.'"), "%%x %%v") AS date_index';
    			break;
    		case 'day':
    		default: // 默认按天显示
    			$sql = 'date_format(CONVERT_TZ(a.time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%j") AS date_index';
    			break;
    	}
    	$sql = 'SELECT COUNT(a.device_id) AS count_all,
               date(CONVERT_TZ(MIN(a.time), "+00:00", "'.$this->localTimeZone.'")) as time, a.sys_platform, b.channel_name as channel,'
                   		.$sql.
                   		' FROM app_activation AS a LEFT JOIN channel_info AS b ON a.channel = b.channel
                ';
    	// 组装 Where 和 group by
    	$groupBy = '';
    	if (!empty($conditions['sysPlatform'])) { // 指定系统平台
    		$where[] = ' a.sys_platform = "%s"';
    		$whereValues[] = $conditions['sysPlatform'];
    	}
    	//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
    	//             $groupBy = $groupBy . '  ,a.sys_platform ';
    	//         }
    	if (!empty($conditions['channel'])) { // 指定渠道
    		$channels =  explode(",", $conditions['channel']);
    		$channel = '"'.join('","',$channels).'"';
    		$where[] = 'b.channel_name in ('.$channel.')';
    		$groupBy = $groupBy . ' , b.channel ';
    	}
    	//          else if(! empty($conditions['doGroupBy'])) {
    
    
    
    	//         }
    	if (!empty($conditions['startTime'])) { // 指定开始时间
    		$where[] = ' a.time >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
    		$whereValues[] = $conditions['startTime'];
    	}
    	if (!empty($conditions['endTime'])) { // 指定结束时间
    		$where[] = ' a.time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
    		$whereValues[] = $conditions['endTime'];
    	}
    	if ($where) {
    		$sql = $sql . ' WHERE '.join(' AND ', $where);
    	} else {
    		$sql = sprintf($sql);// 格式化处理两个%
    		$whereValues = false;
    	}
    	if(empty($groupBy)){
    		$date_index =  ' date_index ';
    	}else{
    		$date_index =  ', date_index ';
    	}
    	// 组装 Group by
    	$sql = $sql . ' GROUP BY date_index ' . $groupBy;
    	// 设定返回行数
    	//$sql = $this->_addSqlLimit($sql, $start, $limit);
    	$stats = $this->query($sql, $whereValues);
    	return $stats;
    
    
    
    }


    /**
     * 获取新增设备注册量
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getRegistStat ($conditions=array(), $start=null, $limit=null)
    {

        $where = $whereValues = array();
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        if($conditions['statType'] == 'day'){
            $date_format = "%%Y %%j";
        }elseif($conditions['statType'] == 'week'){
            $date_format = "%%Y %%v";
        }else{
            $date_format = "%%Y %%c";
        }
        switch(strtolower($conditions['statType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(c.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(c.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%c") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(c.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%x %%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date_format(CONVERT_TZ(c.activate_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%j") AS date_index';
                break;
        }
//         $sql = 'SELECT count(distinct u.device_id) AS count_all,
//                date(CONVERT_TZ(MIN(d.activate_time), "+00:00", "'.$this->localTimeZone.'")) as time, d.sys_platform, d.channel,'
//                                .$sql.
//                ' FROM   user_register_info AS u LEFT JOIN device_info AS d  ON u.device_id = d.device_id AND date_format(d.activate_time, "'.$date_format.'") = date_format(u.reg_time, "'.$date_format.'")';


                $sql = "SELECT
                            	c.time,
                            	c.sys_platform,
                            	e.channel_name as channel,
                            	COUNT(c.device_id) AS count_all,".$sql."
                            FROM
                            	(
                            		SELECT
                            			MIN(a.id),
                            			DATE(a.reg_time) AS time,
                            			a.sys_platform,
                            			a.channel,
                            			a.device_id,
                            			b.activate_time
                            		FROM
                            			user_register_info AS a
                            		LEFT JOIN (
                            			SELECT
                            				d.device_id,
                            				d.activate_time
                            			FROM
                            				device_info AS d
                            			WHERE
                            				d.history = 0
                            		) AS b ON a.device_id = b.device_id
                            		AND DATE(a.reg_time) = DATE(b.activate_time)
                            		AND a.`status` = 'succ'
                            		WHERE
                            			NOT ISNULL(b.activate_time)
                            		GROUP BY
                            			a.device_id
                            	) AS c LEFT JOIN channel_info AS e ON c.channel = e.channel";


        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' c.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
//          else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . '  ,c.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'e.channel_name in ('.$channel.')';
            $groupBy = $groupBy . ' , e.channel ';
        }
//         else if(! empty($conditions['doGroupBy'])) {
//                 $groupBy = $groupBy . ' , e.channel ';

//         }
//         if (isset($conditions['version'])) { // 指定产品版本
//             $where[] = ' FIND_IN_SET(v.prd_version, "%s")';
//             $whereValues[] = join('", "', implode('/', $conditions['version']));
//         } else if(! empty($conditions['doGroupBy'])) {
//             $groupBy = $groupBy . ' , d.prd_version ';
//         }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' c.activate_time >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' c.activate_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
           $date_index =  ' date_index ';
        }else{
            $date_index =  ', date_index ';
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY date_index  ' . $groupBy;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;

    }


    /**
     * 获取新增账号注册量
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function geUserRegistStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(a.reg_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(a.reg_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%c") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(a.reg_time, "+00:00", "'.$this->localTimeZone.'"), "%%x %%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
               $sql = 'date_format(CONVERT_TZ(a.reg_time, "+00:00", "'.$this->localTimeZone.'"), "%%Y %%j") AS date_index';
                break;
        }
        $sql = 'SELECT COUNT(a.user_id) AS count_all,
               date(CONVERT_TZ(MIN(a.reg_time), "+00:00", "'.$this->localTimeZone.'")) as time, a.sys_platform, b.channel_name as channel,'
               .$sql.
               ' FROM user_register_info  AS a LEFT JOIN channel_info AS b ON a.channel = b.channel';
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . ' , a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            $groupBy = $groupBy . ' , b.channel ';
        }
        if (!empty($conditions['country'])) { // 指定国家
        	$countrys =  explode(",", $conditions['country']);
        	$country = '"'.join('","',$countrys).'"';
        	$where[] = 'a.country in ('.$country.')';
        	//$groupBy = $groupBy . ' , a.country ';
        }
        if (!empty($conditions['province'])) { // 指定省份
        	$provinces =  explode(",", $conditions['province']);
        	$province = '"'.join('","',$provinces).'"';
        	$where[] = 'a.province in ('.$province.')';
        	//$groupBy = $groupBy . ' , a.province ';
        }
//         else if(! empty($conditions['doGroupBy'])) {
//                 $groupBy = $groupBy . ' , b.channel ';

//         }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' a.reg_time >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.reg_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where)." AND a.status='succ'";
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
            $date_index =  ' date_index ';
        }else{
            $date_index =  ', date_index ';
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY date_index ' . $groupBy;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;
    }



    /**
     * 获取设备转化率
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getPercentStat ($conditions=array(), $start=null, $limit=null)
    {
        if($conditions['statType'] == 'day'){
            $date_format = "%Y %j";
        }elseif($conditions['statType'] == 'week'){
            $date_format = "%Y %V";
        }else{
            $date_format = "%Y %c";
        }
        $where = array();
        $sql = 'SELECT   COUNT(distinct d.device_id) as count_device_id,COUNT(distinct u.device_id) as count_user_id,
                       date_format(d.activate_time, "%Y-%m-%d") as time, d.sys_platform, d.channel,
                       date_format(d.activate_time, "%Y %j") AS day_index,
                       date_format(d.activate_time, "%x %v") AS week_index,
                       date_format(d.activate_time, "%Y %c") AS month_index
                FROM   user_register_info AS u RIGHT JOIN device_info AS d  ON u.device_id = d.device_id AND date_format(d.activate_time, "'.$date_format.'") = date_format(u.reg_time, "'.$date_format.'")';
        // 组装 Where
        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[$conditions['sysPlatform']] = ' d.sys_platform = "%s"';
        }
        if (!empty($conditions['channel'])) { // 指定渠道
            $where[$conditions['channel']] = ' d.channel = "%s"';
        }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[$conditions['startTime']] = ' d.activate_time >= "%s"';
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[$conditions['endTime'].' 23:59:59'] = ' d.activate_time <= "%s"';
        }
        if ($where) {
            $where_keys = array_keys($where);
            $where = vsprintf(join(' AND ', $where), $where_keys);
            $sql = $sql . ' WHERE '.$where."AND u.status='SUCC' AND is_new =1 ";


        } else {
            $where = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY d.sys_platform, d.channel';
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'month': // 按月显示
                $sql = $sql . ', month_index';
                break;
            case 'week': // 按周显示
                $sql = $sql . ', week_index';
                break;
            default: // 默认按天显示
                $sql = $sql . ', day_index';
                break;
        }
        $userStats = $this->query($sql);
        return $userStats;
    }


    /**
     * 获取软件版本升级数
     * @param array $conditions 获取用户统计数据的限制条件
  	 * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getAppSoftVersionStat($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.user_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') as time, a.old_version,a.new_version as version, a.sys_platform,b.channel_name as channel"
                               .' FROM   app_upgrade AS a LEFT JOIN channel_info AS b ON a.channel = b.channel';
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(! empty($conditions['doGroupBy'])) {// 指定某个平台， 按照平台进行 group by
                $groupBy = $groupBy . '  a.sys_platform ';
            }

        }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
           // $whereValues[] = join(', ',  explode('/', $conditions['channel']) );
            if(! empty($conditions['doGroupBy'])) {
                if(empty($groupBy)){
                    $groupBy = $groupBy . ' b.channel ';
                }else{
                    $groupBy = $groupBy . ' , b.channel ';
                }
            }

        }
        if(!empty($conditions['doGroupBy'])) {
            if(empty($groupBy)){
                $groupBy.=  ' a.old_version ';
            }else{
                $groupBy.=  ', a.old_version ';
            }
        }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';

        }

      //  if(! empty($conditions['doGroupBy'])) {
            if(empty($groupBy)){
                $groupBy = $groupBy . ' a.new_version ';
            }else{
                $groupBy = $groupBy . ' , a.new_version ';
            }
      //  }
//         if (!empty($conditions['startTime'])) { // 指定开始时间
//             $where[] = ' `time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
//             $whereValues[] = $conditions['startTime'];
//         }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }

        if(!empty($groupBy)){
            $groupBy = ' GROUP BY  ' . $groupBy;
        }
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }

        // 组装 Group by
       $sql = $sql . $groupBy .' ORDER BY count_all DESC '.$limit;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);
        $stats = $this->query($sql,$whereValues);


        return $stats;
    }


    /**
     * 获取累计用户版本统计数据
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getUserVersionStat($conditions=array(), $start=null, $limit=null)
    {

        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.device_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') as time, a.sys_platform, b.channel_name as channel,a.prd_version as version".' FROM   device_info  AS a LEFT JOIN channel_info AS b ON a.channel = b.channel ';
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(! empty($conditions['doGroupBy'])) {// 指定某个平台， 按照平台进行 group by
                $groupBy = $groupBy . '  a.sys_platform ';
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . ' a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
             $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            if(! empty($conditions['doGroupBy'])) {
                if(empty($groupBy)){
                    $groupBy = $groupBy . ' b.channel ';
                }else{
                    $groupBy = $groupBy . ' , b.channel ';
                }
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//             if(empty($groupBy)){
//                 $groupBy = $groupBy . ' b.channel ';
//             }else{
//                 $groupBy = $groupBy . ' , b.channel ';
//             }
//         }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';

        }
            if(empty($groupBy)){
                $groupBy = $groupBy . ' a.prd_version ';
            }else{
                $groupBy = $groupBy . ' , a.prd_version ';
            }

        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.modified_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where).' AND is_new = 1';
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }
        
        // 组装 Group by
         $sql = $sql . ' GROUP BY ' . $groupBy.' ORDER BY count_all DESC '.$limit;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;

    }


    /**
    * 用户设备品牌
    * @param array $conditions 获取用户统计数据的限制条件
    * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getBrandStat($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.device_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') as time, a.sys_platform,a.brand, b.channel_name as channel,a.prd_version as version".' FROM   device_info AS a LEFT JOIN channel_info AS b ON a.channel = b.channel ';
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(! empty($conditions['doGroupBy'])) {// 指定某个平台， 按照平台进行 group by
                $groupBy = $groupBy . '  a.sys_platform ';
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . ' a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            if(! empty($conditions['doGroupBy'])) {
                           if(empty($groupBy)){
                                $groupBy = $groupBy . ' b.channel ';
                            }else{
                                $groupBy = $groupBy . ' , b.channel ';
                            }
           }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//            if(empty($groupBy)){
//                 $groupBy = $groupBy . ' b.channel ';
//             }else{
//                 $groupBy = $groupBy . ' , b.channel ';
//             }
//         }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';
            if(! empty($conditions['doGroupBy'])) {
                         if(empty($groupBy)){
                                $groupBy = $groupBy . ' a.prd_version ';
                            }else{
                                $groupBy = $groupBy . ' , a.prd_version ';
                            }
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//          if(empty($groupBy)){
//                 $groupBy = $groupBy . ' a.prd_version ';
//             }else{
//                 $groupBy = $groupBy . ' , a.prd_version ';
//             }
//         }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.modified_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
            $brand =  ' a.brand ';
        }else{
            $brand =  ', a.brand ';
        }
        
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY  ' . $groupBy.$brand.'  ORDER BY count_all DESC '.$limit;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;

    }


    /**
     * 用户设备机型
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getModelStat($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.device_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') as time, a.sys_platform, c.channel_name as channel,a.brand,a.prd_version as version,ifnull(b.model_for_sale, a.model) AS model FROM  device_info AS a LEFT JOIN device_model_info AS b ON a.model = b.model LEFT JOIN channel_info AS c ON a.channel = c.channel";
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
                             $groupBy = $groupBy . '  a.sys_platform ';
          }
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . '  a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'c.channel_name in ('.$channel.')';
            if(! empty($conditions['doGroupBy'])) {
                              if(empty($groupBy)){
                                $groupBy = $groupBy . ' c.channel ';
                            }else{
                                $groupBy = $groupBy . ' , c.channel ';
                            }
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//               if(empty($groupBy)){
//                 $groupBy = $groupBy . ' c.channel ';
//             }else{
//                 $groupBy = $groupBy . ' , c.channel ';
//             }
//         }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';
            if(! empty($conditions['doGroupBy'])) {
                         if(empty($groupBy)){
                                $groupBy = $groupBy . ' a.prd_version ';
                            }else{
                                $groupBy = $groupBy . ' , a.prd_version ';
                            }
            }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//          if(empty($groupBy)){
//                 $groupBy = $groupBy . ' a.prd_version ';
//             }else{
//                 $groupBy = $groupBy . ' , a.prd_version ';
//             }
//         }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.modified_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            // 格式化处理两个
            $sql = sprintf($sql);
            $whereValues = false;
        }
        if(empty($groupBy)){
            $model =  ' a.model ';
        }else{
            $model =  ', a.model ';
        }
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }
        // 组装 Group by
        $sql = "{$sql} GROUP BY {$groupBy}{$model} ORDER BY count_all DESC ".$limit;


        $stats = $this->query($sql, $whereValues);
        return $stats;

    }


    /**
     * 国家
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getCountryStat($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.user_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') time, a.sys_platform, b.channel_name as channel , a.province,a.country,a.prd_version as version FROM  user_register_info AS a LEFT JOIN channel_info AS b ON a.channel = b.channel";
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(!empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
                            $groupBy = $groupBy . '  a.sys_platform ';
             }
        }
//         else if(!empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . '  a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            if(!empty($conditions['doGroupBy'])) {
                             if(empty($groupBy)){
                                $groupBy = $groupBy . ' b.channel ';
                            }else{
                                $groupBy = $groupBy . ' , b.channel ';
                            }
            }
        }
//         else if(!empty($conditions['doGroupBy'])) {
//              if(empty($groupBy)){
//                 $groupBy = $groupBy . ' b.channel ';
//             }else{
//                 $groupBy = $groupBy . ' , b.channel ';
//             }
//         }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';
            if(!empty($conditions['doGroupBy'])) {
                         if(empty($groupBy)){
                                $groupBy = $groupBy . ' a.prd_version ';
                            }else{
                                $groupBy = $groupBy . ' , a.prd_version ';
                            }
            }
        }
//         else if(!empty($conditions['doGroupBy'])) {
//          if(empty($groupBy)){
//                 $groupBy = $groupBy . ' a.prd_version ';
//             }else{
//                 $groupBy = $groupBy . ' , a.prd_version ';
//             }
//         }
        //         if (!empty($conditions['startTime'])) { // 指定开始时间
        //             $where[] = ' `time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
        //             $whereValues[] = $conditions['startTime'];
        //         }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.reg_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where)." AND a.status='SUCC'";
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
            $country =  ' a.country ';
        }else{
            $country =  ', a.country ';
        }
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY ' . $groupBy.$country." ORDER BY count_all DESC ".$limit;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;

    }


    /**
     * 省份
     * @param array $conditions 获取用户统计数据的限制条件
     * @param int $start 开始
     * @param int $limit 结束
     * @return array
     */
    public function getProvinceStat($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = "SELECT COUNT(DISTINCT a.user_id) AS count_all,date_format('".$conditions['endTime']. "', '%%Y-%%m-%%d') time, a.sys_platform, b.channel_name as channel, a.province,a.country,a.prd_version as version FROM  user_register_info  AS a LEFT JOIN channel_info AS b ON a.channel = b.channel";
        // 组装 Where 和 group by
        $groupBy = '';

        if (!empty($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
                             $groupBy = $groupBy . ' a.sys_platform ';
             }
        }
//         else if(! empty($conditions['doGroupBy'])) {// 没有指定某个平台， 按照平台进行 group by
//             $groupBy = $groupBy . ' a.sys_platform ';
//         }
        if (!empty($conditions['channel'])) { // 指定渠道
            $channels =  explode(",", $conditions['channel']);
            $channel = '"'.join('","',$channels).'"';
            $where[] = 'b.channel_name in ('.$channel.')';
            if(! empty($conditions['doGroupBy'])) {
                           if(empty($groupBy)){
                                $groupBy = $groupBy . ' b.channel ';
                            }else{
                                $groupBy = $groupBy . ' , b.channel ';
                            }
             }
        }
//         else if(! empty($conditions['doGroupBy'])) {
//            if(empty($groupBy)){
//                 $groupBy = $groupBy . ' b.channel ';
//             }else{
//                 $groupBy = $groupBy . ' , b.channel ';
//             }
//         }
        if (!empty($conditions['version'])) { // 指定产品版本
            $versions =  explode(",", $conditions['version']);
            $version = '"'.join('","',$versions).'"';
            $where[] = 'a.prd_version in ('.$version.')';
            if(! empty($conditions['doGroupBy'])) {
                          if(empty($groupBy)){
                                $groupBy = $groupBy . ' a.prd_version ';
                            }else{
                                $groupBy = $groupBy . ' , a.prd_version ';
                            }
            }

        }
//         else if(! empty($conditions['doGroupBy'])) {
//           if(empty($groupBy)){
//                 $groupBy = $groupBy . ' a.prd_version ';
//             }else{
//                 $groupBy = $groupBy . ' , a.prd_version ';
//             }
//         }
        //         if (!empty($conditions['startTime'])) { // 指定开始时间
        //             $where[] = ' `time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
        //             $whereValues[] = $conditions['startTime'];
        //         }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' a.reg_time <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'].' 23:59:59';
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where)." AND status='SUCC'";
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        if(empty($groupBy)){
            $province =  ' a.province ';
        }else{
            $province =  ', a.province ';
        }
        $limit = '';
        if(empty($conditions['doGroupBy'])){
        	$limit = " LIMIT 0,10";
        }
        // 组装 Group by
       $sql = $sql . ' GROUP BY ' . $groupBy.$province." ORDER BY count_all DESC ".$limit;
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);

        return $stats;

    }

    /*
     * 时区转换
    */

    function toTimeZone($src, $from_tz = 'Asia/Shanghai', $to_tz = 'America/Denver', $fm = 'Y-m-d H:i:s')
    {
        $datetime = new DateTime($src, new DateTimeZone($from_tz));
        $datetime->setTimezone(new DateTimeZone($to_tz));
        return $datetime->format($fm);
    }

    /**
     * 获取设备统计数据
     * @param array $conditions 获取设备统计数据的限制条件
     *
     * @return array
     */
    public function getDeviceStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = 'SELECT COUNT( DISTINCT device_id) AS count_all,
                       activate_time as time, sys_platform, channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %v") AS month_index
                FROM device_info';
        // 组装 Where
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
        if (isset($conditions['channel'])) { // 指定渠道
            $where[] = ' channel = "%s"';
            $whereValues[] = $conditions['channel'];
        }
        if (isset($conditions['startTime'])) { // 指定开始时间
            $where[] = ' activate_time >= "%s"';
            $whereValues[] = $conditions['startTime'];
        }
        if (isset($conditions['endTime'])) { // 指定结束时间
            $where[] = ' activate_time <= "%s"';
            $whereValues[] = $conditions['endTime'];
        }
        if (isset($conditions['isNew'])) { // 指定结束时间
            $where[] = ' is_new = %d';
            $whereValues[] = $conditions['isNew'] ? 1 : 0;
        }
        if ($where) {
            $sql = $sql . join(' AND ', $where);
        } else {
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY sys_platform, channel';
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'month': // 按月显示
                $sql = $sql . ', month_index';
                break;
            case 'week': // 按周显示
                $sql = $sql . ', week_index';
                break;
            default: // 默认按天显示
                $sql = $sql . ', day_index';
                break;
        }
        $sql = 'SELECT  ceil( rand( ) *100 ) AS count_all,
                       activate_time, sys_platform, channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%Y %u") AS week_index,
                       date_format(activate_time, "%Y %v") AS month_index
                FROM device_info';
        // 设定返回行数
        $sql = $this->_addSqlLimit($sql, $start, $limit);

        $userStats = $this->query($sql, $whereValues);

        return $userStats;
    }

    /**
     * 获取注册设备统计数据
     * @param array $conditions 获取设备统计数据的限制条件
     *
     * @return array
     */
    public function getRegDeviceStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = 'SELECT COUNT( DISTINCT di.device_id) AS count_all,
                       di.activate_time as time, di.sys_platform, di.channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %v") AS month_index
                FROM device_info di
                INNER JOIN user_regist ur
                   ON di.id = ur.device_pk';
        // 组装 Where
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' di.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
        if (isset($conditions['channel'])) { // 指定渠道
            $where[] = ' di.channel = "%s"';
            $whereValues[] = $conditions['channel'];
        }
        if (isset($conditions['startTime'])) { // 指定开始时间
            $where[] = ' di.activate_time >= "%s"';
            $whereValues[] = $conditions['startTime'];
        }
        if (isset($conditions['endTime'])) { // 指定结束时间
            $where[] = ' di.activate_time <= "%s"';
            $whereValues[] = $conditions['endTime'];
        }
        if (isset($conditions['isNew'])) { // 指定结束时间
            $where[] = ' di.is_new = %d';
            $whereValues[] = $conditions['isNew'] ? 1 : 0;
        }
        if ($where) {
            $sql = $sql . join(' AND ', $where);
        } else {
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY di.sys_platform, di.channel';
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'month': // 按月显示
                $sql = $sql . ', month_index';
                break;
            case 'week': // 按周显示
                $sql = $sql . ', week_index';
                break;
            default: // 默认按天显示
                $sql = $sql . ', day_index';
                break;
        }
        // 设定返回行数
        $sql = $this->_addSqlLimit($sql, $start, $limit);

        $userStats = $this->query($sql, $whereValues);

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
        $start = $start > 0 ? $start : 0;
        $limit = $limit > 0 ? $limit : $this->limit;

        $sql = $sql . ' LIMIT ' . $start . ', ' . $limit;

        return $sql;
    }

    /**
     * 获取新注册账号量
     * @param array $conditions 获取设备统计数据的限制条件
     * @param int $start 查询结果起始位置
     * @param int $limit 查询结果返回行数
     * @return mixed
     */
    public function getNewUserStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $sql = 'SELECT COUNT(ui.*) AS count_all,
                       ui.reg_time as time, sys_platform, channel,
                       date_format(ui.reg_time, "%Y %j") AS day_index,
                       date_format(ui.reg_time, "%x %v") AS week_index,
                       date_format(ui.reg_time, "%Y %v") AS month_index
                FROM user_info ui
                INNER JOIN user_regist ur
                   ON ui.id = ur.user_pk
                INNER JOIN device_info di
                   ON ur.device_pk = di.id';
        // 组装 Where
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' di.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
        }
        if (isset($conditions['channel'])) { // 指定渠道
            $where[] = ' di.channel = "%s"';
            $whereValues[] = $conditions['channel'];
        }
        if (isset($conditions['startTime'])) { // 指定开始时间
            $where[] = ' ui.reg_time >= "%s"';
            $whereValues[] = $conditions['startTime'];
        }
        if (isset($conditions['endTime'])) { // 指定结束时间
            $where[] = ' ui.reg_time <= "%s"';
            $whereValues[] = $conditions['endTime'];
        }
        if ($where) {
            $sql = $sql . join(' AND ', $where);
        } else {
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY sys_platform, channel';
        isset($conditions['statType']) ? null : ($conditions['statType'] = 'day');
        switch(strtolower($conditions['statType'])) {
            case 'month': // 按月显示
                $sql = $sql . ', month_index';
                break;
            case 'week': // 按周显示
                $sql = $sql . ', week_index';
                break;
            default: // 默认按天显示
                $sql = $sql . ', day_index';
                break;
        }
        // 设定返回行数
        $sql = $this->_addSqlLimit($sql, $start, $limit);

        $userStats = $this->query($sql, $whereValues);

        return $userStats;
    }


    /**
     * 获取频道列表
     * @return \Think\mixed
     */
    public function getChannels ()
    {
        $sql = 'SELECT channel AS id, channel_name AS channel, GROUP_CONCAT(DISTINCT sys_platform) AS sys_platforms
                FROM channel_info
                GROUP BY channel';
        $stats = $this->query($sql);

        return $stats;
    }

    public function getProductVersions ()
    {
        $sql = 'SELECT prd_version, GROUP_CONCAT(DISTINCT sys_platform) AS sys_platforms
                FROM device_info';
        $where = array();
        $sql .= ' GROUP BY prd_version order by prd_version desc';
        $stats = $this->query($sql);

        return $stats;
    }
    /**
     * 获取国家列表
     */
    public function getCountry()
    {
    	$sql = 'SELECT DISTINCT country FROM user_register_info where country <>"" order by country desc';
    	$stats = $this->query($sql);
    	return $stats;
    	
    }
    
    
    /**
     * 获取省份列表 
     */ 
    public function getProvince()
    {
    	$sql = 'SELECT province, GROUP_CONCAT(DISTINCT country) AS countrys
                FROM user_register_info where country <>"" and province <>""';
    	$where = array();
    	$sql .= ' GROUP BY province order by province desc';
    	$stats = $this->query($sql);
    	
    	return $stats;
    	
    }

    /*
         * 我
         * */
    public function one1(){

    }

    /*
         * 橙秀
         * */
    public function one2(){

    }

    /*
         * 人脉
         * */
    public function one3(){

    }


    /*
         * 性能统计
         * */
    public function one4(){

    }

    /*
         * 名片交换
         * */
    public function one5(){

    }

    /*
         * 名片夹
         * */
    public function one6(){

    }

    /*
     * 文件共享
     * */
    public function getFileShare(){


    }

    /*
     * 搜索
     * */
    public function getUserSearch(){


    }

}
