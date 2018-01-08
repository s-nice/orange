<?php
namespace Model\Statistics;

use \Think\Model;
use Behavior\AgentCheckBehavior;

class Statistics extends Model
{
    protected $localTimeZone = "+08:00"; // 用作SQL时间转换
    protected $limit = 20;
    // 数据表名（不包含表前缀）
    protected $tableName        =   'account_employee';

    /**
     * 获取用户统计数据
     * @param array $conditions 获取用户统计数据的限制条件
     *
     * @return array
     */
    public function getUserStat ($conditions=array(), $start=null, $limit=null)
    {
        $where = array();
        $sql = 'SELECT COUNT(*) AS count_all,
                       activate_time, sys_platform, channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %m") AS month_index
                FROM device_info';
        // 组装 Where
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[$conditions['sysPlatform']] = ' sys_platform = "%s"';
        }
        if (isset($conditions['channel'])) { // 指定渠道
            $where[$conditions['channel']] = ' channel = "%s"';
        }
        if (isset($conditions['startTime'])) { // 指定开始时间
            $where[$conditions['startTime']] = ' activate_time >= "%s"';
        }
        if (isset($conditions['endTime'])) { // 指定结束时间
            $where[$conditions['endTime']] = ' activate_time <= "%s"';
        }
        if ($where) {
            $sql = $sql . join(' AND ', $where);
            $where = array_keys($where);
        } else {
            $where = false;
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
        $sql = $this->_addSqlLimit($sql, $start, $limit);
        $userStats = $this->query($sql, $where);

        return $userStats;
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
                       activate_time, sys_platform, channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %m") AS month_index
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
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %m") AS month_index
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
                       di.activate_time, di.sys_platform, di.channel,
                       date_format(activate_time, "%Y %j") AS day_index,
                       date_format(activate_time, "%x %v") AS week_index,
                       date_format(activate_time, "%Y %m") AS month_index
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
                       ui.reg_time, sys_platform, channel,
                       date_format(ui.reg_time, "%Y %j") AS day_index,
                       date_format(ui.reg_time, "%x %v") AS week_index,
                       date_format(ui.reg_time, "%Y %m") AS month_index
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
     * 性能统计
     * */
    public function getAppError ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $groupBy=' GROUP BY date_index';//列表group by
        //$string_all=",'全部' ";
        $string_all=",'".$conditions['string_all']."' ";
        isset($conditions['timeType']) ? null : ($conditions['timeType'] = 'day');
        switch(strtolower($conditions['timeType'])) {
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(`time`, "+00:00","'.$this->localTimeZone.'"), "%%Y %%m") AS date_index';
                break;
            case 'week': // 按周显示 显示日期所在星期的周一
                $sql = 'subdate(
                date(CONVERT_TZ(`time`, "+00:00","'.$this->localTimeZone.'"))
                 ,date_format(CONVERT_TZ(`time`, "+00:00","'.$this->localTimeZone.'") ,"%%w")
                 -1)
                 AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date(CONVERT_TZ(`time`, "+00:00","'.$this->localTimeZone.'")) AS date_index';
                break;
        }
        $sql = 'SELECT COUNT(*) AS count_all, date(CONVERT_TZ(MIN(a.time), "+00:00","'.$this->localTimeZone.'")) stat_date,
                       CONVERT_TZ(MIN(a.time), "+00:00","'.$this->localTimeZone.'") AS `time`, a.sys_platform, a.sys_version,
                       a.prd_version, a.brand, ifnull(d.model_for_sale, a.model) AS model,
                       ' . $sql . '
                FROM app_error as a  LEFT JOIN device_model_info AS d ON a.model = d.model';
        /*列表sql*/
        $sql_list='SELECT  `count_all`,`stat_date`,`time`,`date_index`';
        // 组装 Where
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' a.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            $groupBy.=',sys_platform';
            $sql_list.=',sys_platform';
        }else{
            $sql_list.=$string_all.' as sys_platform ';
        }

        if (isset($conditions['prdVersion'])) { // 指定设备版本(复选)
            $str=$conditions['prdVersion'];
            $where[] = "a.prd_version IN('$str')";
            $groupBy.=',prd_version';
            $sql_list.=',prd_version';
            // $whereValues[] = $conditions['prdVersion'];
        }else{
            $sql_list.=$string_all.'as prd_version';
        }

        if (isset($conditions['sysVersion'])) { // 指定系统版本
            $where[] = 'a. sys_version  = "%s"';
            $whereValues[] = $conditions['sysVersion'];
            $groupBy.=',sys_version';
            $sql_list.=',sys_version';
        } else{
            $sql_list.=$string_all.'as sys_version ';
        }
        if (isset($conditions['brand'])) { // 指定设备品牌（复选）
            $str=$conditions['brand'];
            $where[] = "a.brand IN('$str')";
            $groupBy.=',brand';
            $sql_list.=',brand';
            // $where[] = "FIND_IN_SET(brand,'$str')";
        }else{
            $sql_list.=$string_all.'as brand';
        }
        if (isset($conditions['model'])) { // 指定设备型号(复选)
            $str=$conditions['model'];
            $where[] ="a.model IN('$str')";
            $groupBy.=',model';
            $sql_list.=',model';
            /*      $where[] = '';
                  $whereValues[] = $conditions['model'];*/
        }else{
            $sql_list.=$string_all.'as model';
        }
        /* if (!empty($conditions['startTime'])) { // 指定开始时间
             $where[] = ' `time` >= "%s"';
             $whereValues[] = $conditions['startTime'];
         }*/
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' `time` <= "%s"';
            $whereValues[] = $conditions['endTime'];
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        // 组装 Group by
        $sql2 =$sql_list.' from('.$sql.$groupBy.' order by date_index '.') as temp_table';//列表数据
        $sql = $sql . ' GROUP BY prd_version order by count_all desc';//图标数据


        // 设定返回行数
        // $sql = $this->_addSqlLimit($sql, $start, $limit);
        $stats[0] = $this->query($sql, $whereValues);//图表数据
        $stats[1] = $this->query($sql2, $whereValues);//列表数据
        return $stats;
    }

    /*
     * 名片交换
     * sql left join 为了保证数据的准确性，如遇到性能问题，需要考虑要不要去掉join提高性能
     * $params sql 参数
     * */
    public function cardExchangeM($params = array() ){

        /*
         * 时间（月-日），平台，版本，交换人数，总人数
         * */
        $sql = "select ";

        switch($params['timetype']){
            case 'm':
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%Y-%m') as timetype, ";
                break;
            case 'w':
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%x-%v') as timetype, ";
                break;
            default :
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%Y-%m-%d') as timetype, ";

        }
        $sql .= " c.`sys_platform`, c.`prd_version`,c.`type`,count(c.user_id) as exchangenumb ,count(distinct c.user_id) as totalnumb ";

        $sql .= "
            from
                card_exchange as c left join user_info as u on c.user_id = u.user_id
            where date_add(c.`time`,Interval 8 Hour) between   '".$params['timestart']."' and '".$params['timeend']."' ";

        if( !empty($params['platform']) ){
            $sql .= ' and c.`sys_platform` = "'.$params['platform'].'" ';
        }
        if( !empty($params['version']) ){
            $params['version'] = explode(',',$params['version']);
            $params['version'] = implode("','",$params['version']);
            $sql .= " and c.`prd_version` in('".$params['version']."')  ";
        }


        $sql .= " group by timetype,c.`type` ";
        /*$sql .= " group by timetype ,c.`sys_platform`,c.`prd_version`,c.`type`  ";*/

        $sql .= "  order by c.`time` asc";
        //echo $sql;
        $result = $this->query($sql);

        return $result;

    }


    /*
     * 名片交换
     * $params sql 参数
     * */
    public function cardExchangeTotalM($params = array() ){

        /*
         * 时间（月-日），平台，版本，交换人数，总人数
         * */
        $sql = "select ";

        switch($params['timetype']){
            case 'm':
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%Y-%m') as timetype, ";
                break;
            case 'w':
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%x-%v') as timetype, ";
                break;
            default :
                $sql .= " DATE_FORMAT(date_add(c.`time`,Interval 8 Hour),'%Y-%m-%d') as timetype, ";

        }
        $sql .= " c.`sys_platform`, c.`prd_version`,count(distinct c.user_id) as totalnumb ";

        $sql .= "
            from
                card_exchange as c left join user_info as u on c.user_id = u.user_id
            where date_add(c.`time`,Interval 8 Hour) between   '".$params['timestart']."' and '".$params['timeend']."' ";

        if( !empty($params['platform']) ){
            $sql .= ' and c.`sys_platform` = "'.$params['platform'].'" ';
        }
        if( !empty($params['version']) ){
            $params['version'] = explode(',',$params['version']);
            $params['version'] = implode("','",$params['version']);
            $sql .= " and c.`prd_version` in('".$params['version']."')  ";
        }


        $sql .= " group by timetype";

        $sql .= "  order by c.`time` asc";
        //echo $sql;
        $result = $this->query($sql);

        return $result;

    }

    /*
         * 查询活跃用户量
         * */
    public function activeUserM($params = array(),$isdraw = 0 ){

        /*
         * 时间（月-日），平台，版本，交换人数，总人数
         * */
        $sql = 'select ';

        switch($params['timetype']){
            case 'm':
                $sql .= " DATE_FORMAT(date_add(a.`time`,Interval 8 Hour),'%Y-%m') as timetype, ";
                break;
            case 'w':
                $sql .= " DATE_FORMAT(date_add(a.`time`,Interval 8 Hour),'%x-%v') as timetype, ";
                break;
            default :
                $sql .= " DATE_FORMAT(date_add(a.`time`,Interval 8 Hour),'%Y-%m-%d') as timetype, ";
        }
        $sql .= "  count(distinct user_id) as sumnumber,`sys_platform`
                from
                    user_daily_last_login as a
                where a.`time` between date_add('".$params['timestart']."',Interval -8 Hour)  and date_add('".$params['timeend']."',Interval -8 Hour) ";

        if(!empty($params['platform']) ){
            $sql .= " and a.`sys_platform` = '".$params['platform']."' ";
        }

        $sql .= " group by timetype ";

        if(!empty($params['platform']) ){
            $sql .= " ,`sys_platform` ";
        }



        $sql .= " order by a.`time` asc ";

        $result = $this->query($sql);

        return $result;

    }


    /*
     * 获取产品版本 （全部版）
     *  */
    public function getVersionM($platform = null){

        $sql = "select sys_platform,GROUP_CONCAT(DISTINCT prd_version order by prd_version desc) as prd_versions
              from device_info group by sys_platform ";

        $stats = $this->query($sql);

        return $stats;
    }
    /*
     * 获取渠道
     *  */
    public function getChannelM($channel = null){
        $sql = "select sys_platform,GROUP_CONCAT(DISTINCT channel order by channel desc) as channels
              from device_info group by sys_platform ";

        $stats = $this->query($sql);

        return $stats;
    }


    /**
     * 获取频道列表
     * @return \Think\mixed
     */
    public function getChannels ()
    {
        $sql = 'SELECT channel AS id, channel_name AS channel
                FROM channel_info
                ORDER BY id ASC';
        $stats = $this->query($sql);

        return $stats;
    }

    /**
     * 获取频道列表
     * @return \Think\mixed
     */
    public function getChannelsAndMergePlatforms ()
    {
        $sql = 'SELECT channel AS id, channel_name AS channel, GROUP_CONCAT(DISTINCT sys_platform) AS sys_platforms
                FROM channel_info
                GROUP BY channel';
        $stats = $this->query($sql);

        return $stats;
    }

    /**
     * 获取一级模块列表
     * @return \Think\mixed
     */
    public function getRootModules ()
    {
        $sql = 'SELECT DISTINCT parent_page_id page_id, parent_page_name page_name
                FROM page_info';
        $stats = $this->query($sql);
        if (is_array($stats)) {
            $_tmpStats = array();
            foreach ($stats as $_moduleInfo) {
                $_tmpStats[$_moduleInfo['page_id']] = $_moduleInfo;
            }
            $stats = $_tmpStats;
        }

        return $stats;
    }

    /**
     * 获取二级模块数据
     * @return \Think\mixed
     */
    public function getAllSubModules ()
    {
        $sql = 'SELECT page_id, page_name, parent_page_id
                FROM page_info';
        $stats = $this->query($sql);

        return $stats;
    }

    //获取产品版本
    public function getProductVersions ($platform=null)
    {
        $sql = 'SELECT DISTINCT prd_version
                FROM device_info';
        $where = $whereValues = array();
        if ($platform) { // 指定结束时间
            $where[] = ' sys_platform = "%s"';
            $whereValues[] = $platform;
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        }
        $sql .= ' order by prd_version desc ';
        $stats = $this->query($sql, $whereValues);

        return $stats;
    }

    //获取产品版本
    public function getProductVersionsAndMergeChannels ($platform=null)
    {
        $sql = 'SELECT prd_version, GROUP_CONCAT(DISTINCT channel) AS channels
                FROM device_info';
        $where = array();
        $whereValues= array();
        if ($platform) { // 指定结束时间
            $where[] = ' sys_platform = "%s"';
            $whereValues[] = $platform;
        }
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        }
        $sql .= ' GROUP BY prd_version order by prd_version desc';
        $stats = $this->query($sql, $whereValues);

        return $stats;
    }

    //获取产品版本
    public function getProductVersionsAndMergePlatform ($platform=null)
    {
        $sql = 'SELECT prd_version, GROUP_CONCAT(DISTINCT sys_platform) AS sys_platforms
                FROM device_info
                GROUP BY prd_version order by prd_version desc';
        $stats = $this->query($sql);
        return $stats;
    }

    /**
     * 获取访问用户总数
     *          SELECT COUNT(*) AS count_all, date(v.`enter_time`) stat_date,
                       v.`enter_time`, v.sys_platform,
                       v.prd_version, v.channel,
                       "所有模块" page_name,
                       date(v.`enter_time`) AS date_index
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                WHERE  v.sys_platform = "IOS"
                GROUP BY date_index
     * @param string $conditions 获取数据的条件信息
     * @param int $start 获取的行数开始位置
     * @param int $limit 获取的总行数
     * @return array
     */
    public function getTotalModuleVisitUsers ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        isset($conditions['timeType']) ? null : ($conditions['timeType'] = 'day');
        switch(strtolower($conditions['timeType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y-%%m") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%x-%%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) AS date_index';
                break;
        }
        // 组装 Where 和 group by
        $groupBy = '';
        $where[] = 'v.page_id != "%s" ';
        $whereValues[] = 'userLogin';
        if (! empty($conditions['moduleId'])) {
            $where[] = ' FIND_IN_SET(p.parent_page_id, "%s") ';
            $whereValues[] = join(',', $conditions['moduleId']);
        }
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' v.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            $sysPlatformName = 'v.sys_platform';
            $sysPlatformName1 = 'sys_platform';
        } else {// 没有指定某个平台， 合并全部平台数据
            $sysPlatformName = '"'.$conditions['stringForAll'] . '" AS sys_platform';
            $sysPlatformName1 = '"'.$conditions['stringForAll'] . '" AS sys_platform';
        }
        if (! empty($conditions['channel'])) { // 指定渠道
            $where[] = ' FIND_IN_SET (v.channel, "%s")';
            $whereValues[] = join(',', $conditions['channel']);
            $channelName = 'c.channel_name AS channel';
            $channelName1 = 'channel';
            $channelId = 'v.channel AS channel_id';
            $channelId1 = 'channel AS channel_id';
        } else {
            $channelName = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelName1 = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelId = ' 0 AS channel_id ';
            $channelId1 = ' 0 AS channel_id ';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['channel'])) {
            $groupBy = $groupBy . ' , v.channel ';
        }
        if (! empty($conditions['version'])) { // 指定产品版本
            $where[] = ' FIND_IN_SET(v.prd_version, "%s")';
            $whereValues[] = join(',', $conditions['version']);
            $versionName = ' v.prd_version';
            $versionName1 = ' prd_version';
        } else {
            $versionName = '"'.$conditions['stringForAll'] . '" AS prd_version';
            $versionName1 = '"'.$conditions['stringForAll'] . '" AS prd_version';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['version'])) {
            $groupBy = $groupBy . ' , v.prd_version ';
        }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' v.`enter_time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' v.`enter_time` <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        $sql = 'SELECT COUNT(DISTINCT v.user_id) AS count_all, date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) stat_date,
                       date(SUBDATE(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"),
                                    (DAYOFWEEK(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") )-2 + 7 ) %% 7
                           )
                       ) stat_week_date,
                       CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") AS `enter_time`,
                       '.$sysPlatformName.',
                       '.$versionName.', '.$channelId.', '.$channelName.',
                       p.page_name, p.parent_page_name, p.page_id, p.parent_page_id,
                       ' . $sql . '
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                LEFT JOIN channel_info c
                   ON c.channel = v.channel';
        //        WHERE p.page_id IN (SELECT page_id FROM page_info WHERE parent_page_id = %s)';
        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY date_index ' . $groupBy;
        if (! empty($conditions['doGroupBy'])) {
            $sql = 'SELECT a.*, b.count_all AS count_level_one
                    FROM ('.$sql . ' , p.parent_page_id, p.page_id ) AS a
                    LEFT JOIN ('.$sql . ' , p.parent_page_id) AS b
                       ON a.sys_platform = b.sys_platform
                      AND a.prd_version  = b.prd_version
                      AND a.channel_id      = b.channel_id
                      AND a.parent_page_id      = b.parent_page_id
                      AND a.date_index      = b.date_index';
            $whereValues = $whereValues ? array_merge($whereValues, $whereValues) : false;
        }
        $sql =  $sql . ' ORDER BY enter_time';
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);
        //if (! empty($conditions['doGroupBy'])) {
        //    $stats = $this->_computeModuleLevelOneData($stats);
        //}

        return $stats;
    }

    /**
     * 获取用户平均访问次数
     *          SELECT (COUNT(1)/COUNT(DISTINCT user_id)) AS count_all,
                       date(MIN(v.`enter_time`)) stat_date,
                       MIN(v.`enter_time`) AS enter_time, v.sys_platform,
                       v.prd_version, v.channel,
                       "所有模块" page_name,
                       date(v.`enter_time`) AS date_index
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                WHERE  v.sys_platform = "IOS"
                GROUP BY date_index
     * @param string $conditions 获取数据的条件信息
     * @param int $start 获取的行数开始位置
     * @param int $limit 获取的总行数
     * @return array
     */
    public function getAvgVisits ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        isset($conditions['timeType']) ? null : ($conditions['timeType'] = 'day');
        switch(strtolower($conditions['timeType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y-%%m") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%x-%%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) AS date_index';
                break;
        }
        // 组装 Where 和 group by
        $groupBy = '';
        $where[] = 'v.page_id != "%s" ';
        $whereValues[] = 'userLogin';
        if (! empty($conditions['moduleId'])) {
            $where[] = ' FIND_IN_SET(p.parent_page_id, "%s") ';
            $whereValues[] = join(',', $conditions['moduleId']);
        }
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' v.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            $sysPlatformName = 'v.sys_platform';
        } else {// 没有指定某个平台， 合并全部平台数据
            $sysPlatformName = '"'.$conditions['stringForAll'] . '" AS sys_platform';
        }
        if (! empty($conditions['channel'])) { // 指定渠道
            $where[] = ' FIND_IN_SET (v.channel, "%s")';
            $whereValues[] = join(',', $conditions['channel']);
            $channelName = 'c.channel_name AS channel';
            $channelId = 'v.channel AS channel_id';
        } else {
            $channelName = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelId = ' 0 AS channel_id ';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['channel'])) {
            $groupBy = $groupBy . ' , v.channel ';
        }
        if (! empty($conditions['version'])) { // 指定产品版本
            $where[] = ' FIND_IN_SET(v.prd_version, "%s")';
            $whereValues[] = join(',', $conditions['version']);
            $versionName = ' v.prd_version';
        } else {
            $versionName = '"'.$conditions['stringForAll'] . '" AS prd_version';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['version'])) {
            $groupBy = $groupBy . ' , v.prd_version ';
        }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' v.`enter_time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' v.`enter_time` <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        $sql = 'SELECT ROUND(COUNT(1)/COUNT(DISTINCT user_id)) AS count_all, date(CONVERT_TZ(MIN(v.`enter_time`), "+00:00", "'.$this->localTimeZone.'")) stat_date,
                       date(SUBDATE(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"),
                                    (DAYOFWEEK(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") )-2 + 7 ) %% 7
                           )
                       ) stat_week_date,
                       CONVERT_TZ(MIN(v.`enter_time`), "+00:00", "'.$this->localTimeZone.'") AS enter_time, '.$sysPlatformName.',
                       '.$versionName.', '.$channelId.', '.$channelName.',
                       p.page_name, p.parent_page_name, p.page_id, p.parent_page_id,
                       ' . $sql . '
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                LEFT JOIN channel_info c
                   ON c.channel = v.channel';
        //        WHERE p.page_id IN (SELECT page_id FROM page_info WHERE parent_page_id = %s)';

        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY date_index ' . $groupBy;
        if (! empty($conditions['doGroupBy'])) {
            $sql = 'SELECT a.*, b.count_all AS count_level_one
                    FROM ('.$sql . ' , p.parent_page_id, p.page_id ) AS a
                    LEFT JOIN ('.$sql . ' , p.parent_page_id) AS b
                       ON a.sys_platform = b.sys_platform
                      AND a.prd_version  = b.prd_version
                      AND a.channel_id   = b.channel_id
                      AND a.parent_page_id      = b.parent_page_id
                      AND a.date_index   = b.date_index';
            $whereValues = $whereValues ? array_merge($whereValues, $whereValues) : false;
        }
        $sql = $sql  . ' ORDER BY enter_time ';

        $stats = $this->query($sql, $whereValues);
        //if (! empty($conditions['doGroupBy'])) {
        //    $stats = $this->_computeModuleLevelOneData($stats);
        //}

        return $stats;
    }

    /**
     * 获取用户平均访问时长
     *          SELECT (SUM(v.duration)/COUNT(DISTINCT v.user_id)) AS count_all,
                       date(v.`enter_time`) stat_date,
                       v.`enter_time`, v.sys_platform,
                       v.prd_version, v.channel,
                       "所有模块" page_name,
                       date(v.`enter_time`) AS date_index
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                WHERE  v.sys_platform = "IOS"
                GROUP BY date_index
     * @param string $conditions 获取数据的条件信息
     * @param int $start 获取的行数开始位置
     * @param int $limit 获取的总行数
     * @return array
     */
    public function getAvgDuration ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        isset($conditions['timeType']) ? null : ($conditions['timeType'] = 'day');
        switch(strtolower($conditions['timeType'])) {
            case 'year': // 按年显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y-%%m") AS date_index';
                break;
            case 'week': // 按周显示
                $sql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%x-%%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $sql = 'date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) AS date_index';
                break;
        }
        // 组装 Where 和 group by
        $groupBy = '';
        $where[] = 'v.page_id != "%s" ';
        $whereValues[] = 'userLogin';
        if (! empty($conditions['moduleId'])) {
            $where[] = ' FIND_IN_SET(p.parent_page_id, "%s") ';
            $whereValues[] = join(',', $conditions['moduleId']);
        }
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' v.sys_platform = "%s"';
            $whereValues[] = $conditions['sysPlatform'];
            $sysPlatformName = 'v.sys_platform';
            $sysPlatformName1 = 'sys_platform';
        } else {// 没有指定某个平台， 合并全部平台数据
            $sysPlatformName = '"'.$conditions['stringForAll'] . '" AS sys_platform';
            $sysPlatformName1 = '"'.$conditions['stringForAll'] . '" AS sys_platform';
        }
        if (! empty($conditions['channel'])) { // 指定渠道
            $where[] = ' FIND_IN_SET (v.channel, "%s")';
            $whereValues[] = join(',', $conditions['channel']);
            $channelName = 'c.channel_name AS channel';
            $channelId = 'v.channel AS channel_id';
        } else {
            $channelName = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelId = ' 0 AS channel_id ';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['channel'])) {
            $groupBy = $groupBy . ' , v.channel ';
        }
        if (! empty($conditions['version'])) { // 指定产品版本
            $where[] = ' FIND_IN_SET(v.prd_version, "%s")';
            $whereValues[] = join(',', $conditions['version']);
            $versionName = ' v.prd_version';
        } else {
            $versionName = '"'.$conditions['stringForAll'] . '" AS prd_version';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['channel'])) {
            $groupBy = $groupBy . ' , v.prd_version ';
        }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' v.`enter_time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' v.`enter_time` <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00")';
            $whereValues[] = $conditions['endTime'];
        }
        $sql = 'SELECT (SUM(v.duration)/COUNT(DISTINCT v.user_id)) AS count_all,
                       date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) stat_date,
                       date(SUBDATE(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"),
                                    (DAYOFWEEK(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") )-2 + 7 ) %% 7
                           )
                       ) stat_week_date,
                       CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") AS enter_time, '.$sysPlatformName.',
                       '.$versionName.', '.$channelId.', '.$channelName.',
                       p.page_name, p.parent_page_name, p.page_id, p.parent_page_id,
                       ' . $sql . '
                FROM user_page_visit v
                INNER JOIN page_info p
                   ON v.page_id = p.page_id
                LEFT JOIN channel_info c
                   ON c.channel = v.channel';
        //        WHERE p.page_id IN (SELECT page_id FROM page_info WHERE parent_page_id = %s)';

        if ($where) {
            $sql = $sql . ' WHERE '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = false;
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY date_index ' . $groupBy;
        if (! empty($conditions['doGroupBy'])) {
            $sql = 'SELECT a.*, b.count_all AS count_level_one
                    FROM ('.$sql . ' , p.parent_page_id, p.page_id ) AS a
                    LEFT JOIN ('.$sql . ' , p.parent_page_id) AS b
                       ON a.sys_platform = b.sys_platform
                      AND a.prd_version  = b.prd_version
                      AND a.channel_id   = b.channel_id
                      AND a.parent_page_id      = b.parent_page_id
                      AND a.date_index      = b.date_index';
            $whereValues = $whereValues ? array_merge($whereValues, $whereValues) : false;
        }
        $sql = $sql . ' ORDER BY stat_date ';
        // 设定返回行数
        //$sql = $this->_addSqlLimit($sql, $start, $limit);

        $stats = $this->query($sql, $whereValues);
        //if (! empty($conditions['doGroupBy'])) {
        //    $stats = $this->_computeModuleLevelOneData($stats);
        //}
        foreach ($stats as $_key=>$_stat) {
            $stats[$_key]['count_all'] = round($_stat['count_all'] / 60, 2);
            if (isset($stats[$_key]['count_level_one'])) {
                unset($stats[$_key]['count_level_one']);
                $stats[$_key]['count_level_one'] = round($_stat['count_level_one'] / 60, 2);
            }
        }

        return $stats;
    }

    protected function _computeModuleLevelOneData ($stats)
    {
        $countLevelOne = array();
        foreach ($stats as $_key=>$_stat) {
            $tmpKey = $_stat['stat_date'].$_stat['sys_platform']
            .$_stat['prd_version'].$_stat['channel']
            .$_stat['parent_page_name'];
            if (! isset($countLevelOne[$tmpKey])) {
                $countLevelOne[$tmpKey] = 0;
            }
            $countLevelOne[$tmpKey] += $_stat['count_all'];
            $stats[$_key]['count_level_one'] = & $countLevelOne[$tmpKey]; // ！！！ 务必保留引用符号
        }

        return $stats;
    }

    protected function _composeBehaviorSql ($originalSql, $conditions)
    {

    }

    /**
     * 获取活跃用户数
     * @param array $conditions
     */
    public function getTotalActiveUsers ($conditions=array())
    {

    }

    /**
     * 获取用户访问率
     * @param string $conditions 获取数据的条件信息
     * @param int $start 获取的行数开始位置
     * @param int $limit 获取的总行数
     * @return array
     */
    public function getUserVisitRate ($conditions=array(), $start=null, $limit=null)
    {
        $where = $whereValues = array();
        $where1 = $whereValues1 = array();
        isset($conditions['timeType']) ? null : ($conditions['timeType'] = 'day');
        switch(strtolower($conditions['timeType'])) {
            case 'year': // 按年显示
                $dateSql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y") AS date_index';
                $dateSql1 = 'date_format(`date`, "%%Y") AS date_index';
                break;
            case 'month': // 按月显示
                $dateSql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%Y-%%m") AS date_index';
                $dateSql1 = 'date_format(`date`, "%%Y-%%m") AS date_index';
                break;
            case 'week': // 按周显示
                $dateSql = 'date_format(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"), "%%x-%%v") AS date_index';
                $dateSql1 = 'date_format(`date`, "%%x-%%v") AS date_index';
                break;
            case 'day':
            default: // 默认按天显示
                $dateSql = 'date(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'")) AS date_index';
                $dateSql1 = '`date` AS date_index';
                break;
        }
        // 组装 Where 和 group by
        $groupBy = $groupBy1 = array();
        $groupBy[] = ' date_index ';
        $groupBy1[] = ' date_index ';

        if(! empty($conditions['doGroupBy'])) {
            $groupBy[] = ' p.parent_page_id ';
        }
        if (! empty($conditions['moduleId'])) {
            $where[] = ' FIND_IN_SET(p.parent_page_id, "%s") ';
            $whereValues[] = join(',', $conditions['moduleId']);
        }
        if (isset($conditions['sysPlatform'])) { // 指定系统平台
            $where[] = ' v.sys_platform = "%s"';
            $where1[] = ' sys_platform = "%s" ';
            $whereValues[] = $whereValues1[] = $conditions['sysPlatform'];
            $sysPlatformName = 'v.sys_platform';
            $sysPlatformName1 = 'sys_platform';
        } else {// 没有指定某个平台， 合并全部平台数据
            $sysPlatformName = '"'.$conditions['stringForAll'] . '" AS sys_platform';
            $sysPlatformName1 = '"'.$conditions['stringForAll'] . '" AS sys_platform';
        }
        if (! empty($conditions['channel'])) { // 指定渠道
            $where[] = ' FIND_IN_SET (v.channel, "%s")';
            $where1[] = ' FIND_IN_SET (channel, "%s")';
            $whereValues[] = $whereValues1[] = join(',', $conditions['channel']);
            $channelName = 'c.channel_name AS channel';
            $channelName1 = 'channel';
            $channelId = 'c.channel AS channel_id';
            $channelId1 = 'channel AS channel_id';
        } else {
            $channelName = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelName1 = '"'.$conditions['stringForAll'] . '" AS channel';
            $channelId = ' 0 AS channel_id ';
            $channelId1 = ' 0 AS channel_id ';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['channel'])) {
            $groupBy[] = ' v.channel ';
            $groupBy1[] = ' channel ';
        }
        if (! empty($conditions['version'])) { // 指定产品版本
            $where[] = ' FIND_IN_SET(v.prd_version, "%s")';
            $where1[] = ' FIND_IN_SET(prd_version, "%s")';
            $whereValues[] = $whereValues1[] = join(',', $conditions['version']);
            $versionName = ' v.prd_version';
            $versionName1 = ' prd_version';
        } else {
            $versionName = '"'.$conditions['stringForAll'] . '" AS prd_version';
            $versionName1 = '"'.$conditions['stringForAll'] . '" AS prd_version';
        }
        if(! empty($conditions['doGroupBy']) && ! empty($conditions['version'])) {
            $groupBy[] = ' v.prd_version ';
        }
        if (!empty($conditions['startTime'])) { // 指定开始时间
            $where[] = ' v.`enter_time` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00") ';
            $where1[] = ' `date` >= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00") ';
            $whereValues[] = $whereValues1[] = $conditions['startTime'];
        }
        if (!empty($conditions['endTime'])) { // 指定结束时间
            $where[] = ' v.`enter_time` <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00") ';
            $where1[] = ' `date` <= CONVERT_TZ("%s", "'.$this->localTimeZone.'", "+00:00") ';
            $whereValues[] = $whereValues1[] = $conditions['endTime'];
        }
        /* 模块的访问用户数/统计期活跃用户数 */
        $sql = 'SELECT DATE(CONVERT_TZ(MIN(v.enter_time), "+00:00", "'.$this->localTimeZone.'")) AS enter_time,
                       date(SUBDATE(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'"),
                                    (DAYOFWEEK(CONVERT_TZ(v.`enter_time`, "+00:00", "'.$this->localTimeZone.'") )-2 + 7 ) %% 7
                           )
                       ) stat_week_date,
                      '.$sysPlatformName.' ,
	                  '.$channelName.', '.$channelId.', '.$versionName.',
	                   p.parent_page_name, p.page_name,
                       COUNT(DISTINCT v.user_id) AS count_all,
                ' . $dateSql . '
                FROM user_page_visit AS v
                INNER JOIN page_info AS p ON v.page_id = p.page_id
                INNER JOIN channel_info AS c ON v.channel = c.channel
                WHERE v.page_id != "userLogin"';


                /* 活跃用户量  */
        $sql1 ='SELECT COUNT(DISTINCT user_id) AS act_user, '.$sysPlatformName1.',
                       '.$channelId1.', '.$versionName1.',
                       '.$dateSql1.'
                FROM user_daily_last_login';
        if ($where) {
            $sql = $sql . ' AND '.join(' AND ', $where);
        } else {
            $sql = sprintf($sql);// 格式化处理两个%
            $whereValues = array();
        }
        if ($where1) {
            $sql1 = $sql1 . ' WHERE '.join(' AND ', $where1);
        } else {
            $sql1 = sprintf($sql1);// 格式化处理两个%
            $whereValues1 = array();
        }
        // 组装 Group by
        $sql = $sql . ' GROUP BY ' . join(',', $groupBy);
        if ($groupBy1) {
            $sql1 = $sql1 . ' GROUP BY ' . join(',', $groupBy1);
        }
        $finalSql = 'SELECT a.enter_time, a.sys_platform, a.stat_week_date,
	                   a.channel, a.channel_id, a.prd_version,
	                   a.parent_page_name, a.page_name,
                       a.date_index, CASE WHEN b.act_user>0 THEN CONCAT(ROUND(a.count_all/b.act_user * 100), "%%") ELSE 0 END AS count_all
                     FROM (' . $sql . ') AS a
                     LEFT JOIN (' . $sql1 . ') AS b
                        ON a.date_index = b.date_index';
        if(! empty($conditions['doGroupBy'])) {
            $finalSql .= '
                       AND a.sys_platform = b.sys_platform
                       AND a.channel_id = b.channel_id
                       AND a.prd_version = b.prd_version';
        }
        $finalSql .= ' ORDER BY a.enter_time';
        $whereValues = array_merge($whereValues, $whereValues1);
        $whereValues = $whereValues ? $whereValues : false;
        //echo print_r($finalSql, true),'<hr/>', print_r($whereValues, true);exit;

        $stats = $this->query($finalSql, $whereValues);

        return $stats;
    }

    /**
     * 获取系统版本列表(sys_version)和对应的平台（sys_platform）
     *
     */

    public function getSysVersionList()
    {
        $sql = 'SELECT DISTINCT sys_version , sys_platform
                FROM device_info order by sys_version desc';
        $stats = $this->query($sql);

        return $stats;
    }
    /**
     * 获取用户熟知的设备型号列表,和对应的型号,平台（model model_for_sale, model,sys_platform）
     *
     */
    public function getModelList()
    {

        $sql="SELECT model, model as model_for_sale ,sys_platform
                FROM `device_info`
                WHERE sys_platform !='IOS'
                union
                select group_concat( distinct model SEPARATOR \"','\") as model, model_for_sale ,'IOS' as sys_platform
                from `device_model_info`
                group by model_for_sale  ";
        $stats = $this->query($sql);
        $modelList=array();
        foreach($stats as $k){
            $modelList[$k['model_for_sale']]=['model'=>$k['model'],'sys_platform'=>$k['sys_platform']];

        }

        return $modelList;
    }
    /**
     * 设备品牌列表(brand)和对应的系统平台（sys_platform）
     *
     */
    public function getBrandList()
    {
        $sql = 'SELECT DISTINCT brand ,sys_platform
                FROM device_info order by sys_version desc';
        $stats = $this->query($sql);

        return $stats;
    }

    /**
     * 获取产品版本(prd_version)和对应的系统平台（sys_platform）
     *
     */
    public function getPrdVersionList()
    {
        $sql = 'SELECT DISTINCT prd_version  ,sys_platform
                FROM device_info order by sys_version desc';
        $stats = $this->query($sql);

        return $stats;
    }



}

/* EOF */
