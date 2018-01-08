<?php
namespace Model\JobInfo;

use \Think\Model;
use Model\Admin\Admin;

class JobInfo extends Model{
    
    /**
     * 根据ID，删除照片
     * @param int $id
     * @return bool
     */
    public function deleteJob($id){
        $sql = "delete from `job_info` where id=%d";
        return $this->execute($sql, $id);
    }
    
    /**
     * 根据时间，查询发布的数据
     * @param date $date
     * @return array
     */
    public function selectByStatusDate($date){
        $sql = "select * from `job_info` where status=2 and start_date<='%s' and end_date>='%s' order by sort desc";
        $list = $this->query($sql, $date, $date);
        return $list;
    }
    
    /**
     * 根据状态码，查询数据
     * @param int $status 1未发布，2已发布
     * @return array
     */
    public function selectByStatus($status, $start, $limit, $sort, $sortType){
        if (empty($sort)) {
            $sort = 'id';
        }
        if (empty($sortType)) {
            $sortType='asc';
        }
        $sql = "select * from `job_info` where status=%d order by %s %s limit %d, %d";
        $list = $this->query($sql, $status, $sort, $sortType, $start, $limit);
        $this->_setAdminName($list);
        return $list;
    }
    
    /**
     * 根据状态码，查询数据数量
     * @param int $status 1未发布，2已发布
     * @return int
     */
    public function countByStatus($status){
        $sql = "select count(*) c from `job_info` where status=%d";
        $list = $this->query($sql, $status);
        return $list[0]['c'];
    }
    
    /**
     * 根据ID，更新数据发布状态
     * @param str $ids
     * @param int $status
     * @param str $admin_id
     * @return bool
     */
    public function updateStatusByIds($ids,$status,$admin_id){
        $sql = "update `job_info` set status=%d, admin_id='%s' where id in(%s)";
        return $this->execute($sql, $status, $admin_id, $ids);
    }
    
    /**
     * 通过结果集里的admin_id,获取admin_name
     * @param unknown $list
     */
    private function _setAdminName(&$list){
        $admins = array();
        for ($i = 0; $i < count($list); $i++) {
            $admins[] = $list[$i]['admin_id'];
        }
        $admins = array_unique($admins);
        $params = array();
        $params['adminid'] = join(',', $admins);
        $params['fields'] = 'realname,adminid';
        $model = new Admin();
        $rst = $model->getAdminList($params);
        $rst = $rst['data']['admins'];
        
        for ($i = 0; $i < count($list); $i++) {
            for ($j = 0; $j < count($rst); $j++) {
                if ($list[$i]['admin_id'] == $rst[$j]['adminid']){
                    $list[$i]['admin_name'] = $rst[$j]['realname'];
                }
            }
        }
    }
    
    /**
     * 添加招聘信息
     * @param str $title
     * @param date $startDate
     * @param date $endDate
     * @param str $content
     * @param str $admin_id
     * @param int $lang
     * @param int $sort
     * @return bool
     */
    public function addjob($title, $startDate, $endDate, $content, $admin_id, $lang, $sort){
        $sql = "insert into `job_info` (title, content, sort, start_date, end_date, lang, admin_id, mtime, status) 
            values ('%s', '%s', %d, '%s', '%s', %d, '%s', now(), 1)";
        return $this->execute($sql, $title, $content, $sort, $startDate, $endDate, $lang, $admin_id);
    }
    
    /**
     * 更新招聘信息
     * @param int $id
     * @param str $title
     * @param date $startDate
     * @param date $endDate
     * @param str $content
     * @param str $admin_id
     * @param int $lang
     * @param int $sort
     * @return bool
     */
    public function updatejob($id, $title, $startDate, $endDate, $content, $admin_id, $lang, $sort){
        $sql = "update `job_info` set title='%s', content='%s', sort=%d, 
            start_date='%s', end_date='%s', lang=%d, admin_id='%s',mtime=now()   
            where id=%d";
        return $this->execute($sql, $title, $content, $sort, $startDate, $endDate, $lang, $admin_id, $id);
    }
}
