<?php
namespace Model\Statistics;

use \Think\Model;
class BeAnalysis extends Model
{
    protected $limit = 20;

    private $echoSql = false;

    private $die = false;
    
    public $to_tz   = '+08:00';
    
    public $from_tz = '+00:00';

 /**
     * 橙秀---收藏用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getSaveUserNum($startDate, $endDate, $platform, $infoType='all', $searchDateType='d'){
        if (in_array($infoType, ['news', 'ask'])){
            return $this->_getSaveUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType);
        } else {
            return $this->_getSaveUserNumAll($startDate, $endDate, $platform, $searchDateType);
        }
    }
    
    /**
     * 橙秀---收藏用户数（百分比）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getSaveUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType='d'){
        
    }
    
    /**
     * 橙秀---收藏用户数（总数）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getSaveUserNumAll($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,
                    COUNT(DISTINCT a.user_id) user_count,
                    b.visit_count
                FROM
                    `orashow_collect` a
                JOIN (
                    SELECT 
                        %s date1,a.sys_platform,
                        COUNT(DISTINCT a.user_id) visit_count
                    FROM `user_page_visit` a
                    WHERE 
                        convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                        AND a.page_id='OR01' 
                        %s
                    GROUP BY date1 %s
                ) b ON %s=b.date1 %s
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        $whereValues[] = $whereValues[0];
        $whereValues[] = $platform == 'all'?'':"AND b.sys_platform=a.sys_platform";
        
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('user_count'=>'0', 'visit_count'=>'0'));
    }
    
    /**
     * 橙秀---查看分享用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getShareUserNum($startDate, $endDate, $platform, $infoType='all', $searchDateType='d'){
        if (in_array($infoType, ['news', 'ask'])){
            return $this->_getShareUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType);
        } else {
            return $this->_getShareUserNumAll($startDate, $endDate, $platform, $searchDateType);
        }
    }
    
    /**
     * 橙秀---查看分享用户数（百分比）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getShareUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType='d'){
        
    }
    
    /**
     * 橙秀---查看分享用户数（总数）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getShareUserNumAll($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,
                    COUNT(DISTINCT a.user_id) user_count,
                    b.visit_count
                FROM
                    `orashow_share` a
                JOIN (
                        SELECT 
                            %s date1,a.sys_platform,
                            COUNT(DISTINCT a.user_id) visit_count
                        FROM `user_page_visit` a
                        WHERE 
                            convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                            AND a.page_id='OR01' 
                            %s
                        GROUP BY date1 %s
                    ) b ON %s=b.date1 %s
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        switch ($searchDateType){
        	case 'w':
        		$whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
        		break;
        	case 'm':
        		$whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
        		break;
        	default:
        		$whereValues[] = "(CONVERT(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), date))";
        		break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        $whereValues[] = $whereValues[0];
        $whereValues[] = $platform == 'all'?'':"AND b.sys_platform=a.sys_platform";
        
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('user_count'=>'0', 'visit_count'=>'0'));
    }
    
    /**
     * 用户分享次数比例
     * @param datetime $startDate
     * @param datetime $endDate
     * @param str $platform
     * @param str $searchDateType
     * @return array
     */
    public function getShareNum($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    %s date1,
                    count(*) total_count,a.sys_platform,
                    b.inside_count
                FROM
                    `orashow_share` a
                LEFT JOIN (
                    SELECT 
                        %s date1,COUNT(*) inside_count,a.sys_platform
                    FROM 
                        `orashow_share` a
                    WHERE 
                        convert_tz(a.time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                        %s
                        AND share_to='contacts'
                    GROUP 
                        BY date1 %s
                ) b ON %s=b.date1 %s
                WHERE
                    convert_tz(a.time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $whereValues[0];
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        $whereValues[] = $whereValues[0];
        $whereValues[] = $platform == 'all'?'':"AND b.sys_platform=a.sys_platform";
        
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0', 'inside_count'=>'0', 'outside_count'=>'0'));
    }
    
    /**
     * 橙秀---查看评论用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getCommentUserNum($startDate, $endDate, $platform, $infoType='all', $searchDateType='d'){
        if (in_array($infoType, ['news', 'ask'])){
            return $this->_getCommentUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType);
        } else {
            return $this->_getCommentUserNumAll($startDate, $endDate, $platform, $searchDateType);
        }
    }

    /**
     * 橙秀---查看评论用户数（百分比）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getCommentUserNumSub($startDate, $endDate, $platform, $infoType, $searchDateType='d'){
        
    }
    
    /**
     * 橙秀---查看评论用户数（总数）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getCommentUserNumAll($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,
                    COUNT(DISTINCT a.user_id) user_count,
                    b.visit_count
                FROM
                    `orashow_comment` a
                JOIN(
                    SELECT 
                        %s date1,a.sys_platform,
                        COUNT(DISTINCT a.user_id) visit_count
                    FROM `user_page_visit` a
                    WHERE 
                        convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                        AND a.page_id='OR01' 
                        %s
                    GROUP BY date1 %s
                ) b ON %s=b.date1 %s
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        switch ($searchDateType){
        	case 'w':
        		$whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
        		break;
        	case 'm':
        		$whereValues[] = "date_format(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
        		break;
        	default:
        		$whereValues[] = "(CONVERT(convert_tz(a.enter_time, '$this->from_tz', '$this->to_tz'), date))";
        		break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        $whereValues[] = $whereValues[0];
        $whereValues[] = $platform == 'all'?'':"AND b.sys_platform=a.sys_platform";
        
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
    
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('user_count'=>'0', 'visit_count'=>'0'));
    }
    
    /**
     * 橙秀---发布问题用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getPublishQaUserNum($startDate, $endDate, $platform, $qaType='all', $searchDateType='d'){
        if (in_array($qaType, ['news', 'ask'])){
            return $this->_getPublishQaUserNumSub($startDate, $endDate, $platform, $qaType, $searchDateType);
        } else {
            return $this->_getPublishQaUserNumAll($startDate, $endDate, $platform, $searchDateType);
        }
    }

    /**
     * 橙秀---发布问题用户数（百分比）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $infoType 子查询类型（news资讯，ask问答，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getPublishQaUserNumSub($startDate, $endDate, $platform, $qaType, $searchDateType='d'){
        
    }
    
    /**
     * 橙秀---发布问题用户数（总数）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    private function _getPublishQaUserNumAll($startDate, $endDate, $platform, $searchDateType='d'){
        
    }
    
    /**
     * 我---新添加卡片数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getNewAddCardNum($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,
                    COUNT(a.id) total_count
                FROM
                    `package_add_card` a
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0'));
    }
    
    /**
     * 我---添加卡片用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getAddCardUserNum($startDate, $endDate, $platform, $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,
                    COUNT(DISTINCT a.user_id) total_count
                FROM
                    `package_add_card` a
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s
                GROUP
                    BY date1 %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $platform == 'all'?'':",a.sys_platform";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0'));
    }
    
    /**
     * 我---添加卡片用户数比例（百分比）
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getAddCardUserPercent($startDate, $endDate, $platform, $searchDateType='d'){
        
    }
    
    /**
     * 我---不同主题类型使用用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getThemeUserNum($startDate, $endDate, $searchDateType='d'){
        
    }
    
    /**
     * 我---不同模板使用用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getTemplateUserNum($startDate, $endDate, $searchDateType='d'){
        $sql = "SELECT
                    template_name, count(distinct(user_id)) total_count
                FROM
                    `card_template`
                WHERE
                    `date` between '%s' and '%s'
                GROUP
                    BY template_name
                ORDER BY total_count DESC
                ";
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
    
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        return  $this->query($sql);
    }

    /**
     * 搜索---使用搜索用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $version 版本
     * @param int $type 子查询（text文本，speech语音，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getSearchUserNum($startDate, $endDate, $platform, $version, $type='all', $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    c.sys_platform, c.date1, c.prd_version,
                    c.searched_count,
                    count(distinct a.user_id) total_count
                FROM
                    `user_daily_last_login` a
                JOIN
                    (SELECT
                        a.sys_platform, %s date1,prd_version,
                        COUNT(DISTINCT a.user_id) searched_count
                    FROM
                        `user_search` a
                    WHERE
                        convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                        %s/*平台*/
                        %s/*版本*/
                        %s/*子类别*/
                    GROUP
                        BY date1 %s %s) c ON %s=c.date1
                        %s 
                        %s 
                WHERE
                    convert_tz(a.time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s/*平台*/
                    %s/*版本*/
                GROUP BY c.date1 %s %s
                ";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        
        $versionSql = '';
        if (empty($version)) {
            $whereValues[] = $versionSql;
        } else {
            $tmp = join("','", $version);
            $versionSql = "AND a.prd_version in ('$tmp')";
            $whereValues[] = $versionSql;
        }
        
        $whereValues[] = $type=='all'?'':"AND a.type='$type'";
        $whereValues[] = $platform   == 'all'?'':",a.sys_platform";
        $whereValues[] = $versionSql == ''?'':",a.prd_version";
        $whereValues[] = $whereValues[0];
        $whereValues[] = $platform   == 'all'?'':"AND a.sys_platform=c.sys_platform";
        $whereValues[] = $versionSql == ''   ?'':"AND a.prd_version = c.prd_version";
        
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        $whereValues[] = $versionSql;
        $whereValues[] = $platform   == 'all'?'':",c.sys_platform";
        $whereValues[] = $versionSql == ''   ?'':",c.prd_version";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDate, $endDate, $searchDateType, array('searched_count'=>'0'));
        //return $this->_fillEmptyData2($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0', 'searched_count'=>'0'));
    }

    /**
     * 搜索---搜索次数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param int $type 子查询（text文本，speech语音，all所有）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getSearchNum($startDate, $endDate, $platform, $version, $type='all', $searchDateType='d'){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    a.sys_platform, %s date1,prd_version,
                    COUNT(*) searched_count
                FROM
                    `user_search` a
                WHERE
                    convert_tz(time, '$this->from_tz', '$this->to_tz') BETWEEN '%s' AND '%s'
                    %s/*平台*/
                    %s/*版本*/
                    %s/*子类别*/
                GROUP
                    BY date1 %s %s";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), '%Y-%m')";
                break;
            default:
                $whereValues[] = "(CONVERT(convert_tz(a.time, '$this->from_tz', '$this->to_tz'), date))";
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        $whereValues[] = $platform == 'all'?'':"AND a.sys_platform='$platform'";
        //$whereValues[] = empty($version)?'':"AND a.prd_version='$version'";
        $versionSql = '';
        if (empty($version)) {
            $whereValues[] = $versionSql;
        } else {
            $tmp = join("','", $version);
            $versionSql = "AND a.prd_version in ('$tmp')";
            $whereValues[] = $versionSql;
        }
        $whereValues[] = $type=='all'?'':"AND a.type='$type'";
        $whereValues[] = $platform   == 'all'?'':",a.sys_platform";
        $whereValues[] = $versionSql == ''   ?'':",a.prd_version";
        
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData($list, $startDate, $endDate, $searchDateType, array('searched_count'=>'0'));
        //return $this->_fillEmptyData2($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('searched_count'=>'0'));
    }
    
    /**
     * 文件共享---功能使用用户数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getFileShareUserNum($startDate, $endDate, $version, $searchDateType){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    %s date1,prd_version,
                    COUNT(DISTINCT a.user_id) total_count
                FROM
                    `file_share` a
                WHERE
                    time BETWEEN '%s' AND '%s'
                    %s/*版本*/
                GROUP
                    BY date1, prd_version";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(a.time, '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(a.time, '%Y-%m')";
                break;
            default:
                $whereValues[] = '(CONVERT(a.time, date))';
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        if (!empty($version)){
            $whereValues[] = "AND a.prd_version='$version'";
        } else {
            $whereValues[] = "";
        }
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData2($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0'));
    }
    
    /**
     * 文件共享---功能使用次数
     * @param datetime $startDate 开始日期
     * @param datetime $endDate 结束日期
     * @param str $platform 平台（Android,IOS,Leaf）
     * @param str $searchDateType 查询的日期类别（d日，w周，m月）
     * @return array
     */
    public function getFileShareNum($startDate, $endDate, $version, $searchDateType){
        $startDateOrigin = $startDate;
        $endDateOrigin   = $endDate;
        $sql = "SELECT
                    %s date1,prd_version,
                    COUNT(*) total_count
                FROM
                    `file_share` a
                WHERE
                    time BETWEEN '%s' AND '%s'
                    %s/*版本*/
                GROUP
                    BY date1, prd_version";
        switch ($searchDateType){
            case 'w':
                $whereValues[] = "date_format(a.time, '%x-%v')";
                break;
            case 'm':
                $whereValues[] = "date_format(a.time, '%Y-%m')";
                break;
            default:
                $whereValues[] = '(CONVERT(a.time, date))';
                break;
        }
        $whereValues[] = $startDate;
        $whereValues[] = $endDate;
        if (!empty($version)){
            $whereValues[] = "AND a.prd_version='$version'";
        } else {
            $whereValues[] = "";
        }
        $sql = vsprintf($sql, $whereValues);
        if ($this->echoSql) {echo $sql; if ($this->die) {die;}}
        
        $list = $this->query($sql);
        return $this->_fillEmptyData2($list, $startDateOrigin, $endDateOrigin, $searchDateType, array('total_count'=>'0'));
    }
    
    /**
     * 补空数据方法，支持date1的补空
     * @param array $list 源数据
     * @param date $startDate 开始日期
     * @param date $endDate 结束日期
     * @param str $searchDateType 搜索类型d日 w周 m月
     * @param array $defaultArray 默认值
     * @return array:
     */
    private function _fillEmptyData($list, $startDate, $endDate, $searchDateType, $defaultArray){
        
        $formatString = $startTime = $endTime = $keyword = '';
        $this->_getFillEmptyParams($formatString, $startTime, $endTime, $keyword, $startDate, $endDate, $searchDateType);
    
        //补空数据
        for ($i = 0; true; $i++) {
            $tmpStartTime = strtotime("+$i $keyword", $startTime);
    
            if ($tmpStartTime > $endTime) {
                break;
            }
    
            $date = date($formatString, $tmpStartTime);
    
            $flag = true;
            for ($j = 0; $j < count($list); $j++) {
                if ($list[$j]['date1'] == $date){
                    $flag = false;
                    break;
                }
            }
    
            if ($flag) {
                $list[] = array_merge(array('date1'=>$date), $defaultArray);
            }
        }
        
        $list = array_sort($list, 'date1');
        
        return $this->_weekDateConvert($list, $searchDateType);
    }
    
    /**
     * 如果搜索日期类型是周，则把周的第一天显示到数据里
     * @param array $list
     * @param str $searchDateType
     * @return array
     */
    private function _weekDateConvert($list,$searchDateType){
        if ($searchDateType != 'w') {
            return $list;
        }
        for ($j = 0; $j < count($list); $j++) {
            $tmp = explode('-', $list[$j]['date1']);
            $list[$j]['date1'] = date('Y-m-d',strtotime("o$tmp[0]-W$tmp[1]")); 
        }
        return $list;
    }
    
    /**
     * 补空方法参数初始化
     * @param str $formatString 格式化日期的格式
     * @param int $startTime 开始time
     * @param int $endTime 结束time
     * @param str $keyword strtotime方法里的关键字
     * @param date $startDate 开始时间
     * @param date $endDate 结束时间
     * @param str $searchDateType 搜索类型d日 w周 m月
     */
    private function _getFillEmptyParams(&$formatString, &$startTime, &$endTime, &$keyword, &$startDate, &$endDate, $searchDateType){
        $startTime = strtotime($startDate);
    
        //开始日期计算
        switch ($searchDateType){
            case 'w':
                $formatString = 'o-W';
                $keyword = ' Week';
    
                $weekIndex = date('w', $startTime);
                if ($weekIndex == 0){
                    $startDate = date('Y-m-d', strtotime('this Sunday', $startTime));
                } else {
                    $startDate = date('Y-m-d', strtotime('last Sunday', $startTime));
                }
                break;
            case 'm':
                $formatString = 'Y-m';
                $keyword = ' Month';
                $startDate = date('Y-m-', $startTime).'01';
                break;
            default:
                $formatString = 'Y-m-d';
                $keyword = ' Day';
                break;
        }
    
        //开始，结束日期秒数
        $startTime = strtotime($startDate);
        $endTime   = strtotime($endDate);
    }
    
    /**
     * 补空数据方法，支持date1,prd_version的补空（没用了）
     * @param array $list 源数据
     * @param date $startDate 开始日期
     * @param date $endDate 结束日期
     * @param str $searchDateType 搜索类型d日 w周 m月
     * @param array $defaultArray 默认值
     * @return array
     * 
     */
    private function _fillEmptyData2($list, $startDate, $endDate, $searchDateType, $defaultArray, $anotherKey='prd_version'){
        
        $formatString = $startTime = $endTime = $keyword = '';
        $this->_getFillEmptyParams($formatString, $startTime, $endTime, $keyword, $startDate, $endDate, $searchDateType);
    
        //获取所有版本数据
        $versions = array();
        for ($i = 0; $i < count($list); $i++) {
            $versions[] = $list[$i][$anotherKey];
        }
        $versions = array_unique($versions);
    
        //制作空数据
        $emptyData = array();
    
        //补空数据
        for ($i = 0; true; $i++) {
            $tmpStartTime = strtotime("+$i $keyword", $startTime);
    
            if ($tmpStartTime > $endTime) {
                break;
            }
            
            $date = date($formatString, $tmpStartTime);
            
            for ($j = 0; $j < count($versions); $j++) {
                $tmpArr = array('date1'=>$date,$anotherKey=>$versions[$j]);
                $emptyData[] = array_merge($tmpArr, $defaultArray);
            }
        }
    
        //把结果集里的数据，添加到空数据数组里
        for ($i = 0; $i < count($emptyData); $i++) {
            $tmp = $emptyData[$i];
    
            for ($j = 0; $j < count($list); $j++) {
                $tmp2 = $list[$j];
                if ($tmp2['date1'] == $tmp['date1'] && $tmp2[$anotherKey] == $tmp[$anotherKey]){
                    $emptyData[$i]['total_count'] = $tmp2['total_count'];
                    if (isset($tmp2['searched_count'])) {
                        $emptyData[$i]['searched_count'] = $tmp2['searched_count'];
                    }
                    break;
                }
            }
        }
        return $this->_weekDateConvert($list, $searchDateType);
    }
}