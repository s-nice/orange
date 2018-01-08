<?php
namespace Model\OrangeStat;

use \Think\Model;
class OrangeStatBase extends Model
{
    /**
     * 所有软件版本
     * @param arr $params
     * @return arr
     */
    public function allsv(){
        $sql = "SELECT DISTINCT(pro_version) v FROM `dm_orange_stats_user` WHERE pro_version!='' order by v asc";
        $list = $this->query($sql);
        return $this->_processData($list);
    }
    
    /**
     * 所有软件版本
     * @param arr $params
     * @return arr
     */
    public function allhv(){
        $sql = "SELECT DISTINCT(model) v FROM `dm_orange_stats_user`  WHERE model!='' order by v asc";
        $list = $this->query($sql);
        return $this->_processData($list);
    }

    /**
     *  橙脉统计有软件版本
     * @param arr $params
     * @return arr
     */
    public function allProversion(){
        $sql = "SELECT DISTINCT(pro_version) v FROM `dm_orange_stats_device_info_new` WHERE pro_version!='' order by v asc";
        $list = $this->query($sql);
        return $this->_processData($list);
    }

    /**
     * 橙脉所有系统平台
     * @param arr $params
     * @return arr
     */
    public function allPlatform(){
        return array('iOS','Android');
    }
    
    /**
     * 橙脉所有省份
     * @param arr $params
     * @return arr
     */
    public function allProvince(){
        $sql = "SELECT DISTINCT(province) v FROM `dm_app_stats_increase_user` WHERE province!='' order by v asc";
        $list = $this->query($sql);
        return $this->_processData($list);
    }
    /**
     * 处理数据
     * @param arr $list
     * @return arr
     */
    private function _processData($list){
        $newlist = array();
        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i]['v'] == 'all'){
                continue;
            }
            $newlist[] = $list[$i]['v'];
        }
        return $newlist;
    }

    //获取所有软件硬件版本返回带括号的字符串
    protected function getAllVersions(){
        $hv = $this->allhv();
        $hv_str = implode('\',\'', $hv);
        $hv_str = '(\''.$hv_str.'\')';
        $sv = $this->allsv();
        $sv_str = implode('\',\'', $sv);
        $sv_str = '(\''.$sv_str.'\')';
        return array('h'=>$hv_str,'s'=>$sv_str);
    }


    //由最小，最大，间隔 划分区间
    public function getSections($min,$max,$range){
        $i = 0;
        $t = ($max-$min)/$range;
        $start = $min;
        $arr = array();
        while ($i<$range) {
            $d = array();
            $d['start'] = $start;
            $d['end'] = $start+$t;
            $d['str'] = "'".$start."-".($start+$t)."'";
            array_push($arr,$d);
            $start+=$t;
            $i++;
        }
        return $arr;
    }


    protected function getSqlPart($sections,$column){
        $arr = array();
        foreach ($sections as $key => $value) {
            $str = '';
            $str .= " when $column>=".$value['start']." and $column<".$value['end']." then ".$value['str'];
            array_push($arr, $str);
        }
        return implode($arr,' ');
    }
}