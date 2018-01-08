<?php
/**
 * 判断是否为手机号码格式
 * @param str $mobile
 * @return boolean
 */
function _isMobile($mobile){
    if (trim($mobile)=='') {
        return false;
    }
    $reg = '/^1[3578]\d{9}$/';
    $res = preg_match($reg,$mobile);
    return $res;
}


/**
 * 二维数组按指定的键值排序
 * @param array $array 数组
 * @param str $keys 键名
 * @param str $type 排序方式
 * @return array 返回排序后的数组
 */
function array_sort($array,$keys,$type='asc'){
    if(!isset($array) || !is_array($array) || empty($array)){
        return '';
    }
    if(!isset($keys) || trim($keys)==''){
        return '';
    }
    if(!isset($type) || $type=='' || !in_array(strtolower($type),array('asc','desc'))){
        return '';
    }
    $keysvalue=array();
    foreach($array as $key=>$val){
        $val[$keys] = str_replace('-','',$val[$keys]);
        $val[$keys] = str_replace(' ','',$val[$keys]);
        $val[$keys] = str_replace(':','',$val[$keys]);
        $keysvalue[] =$val[$keys];
    }
    asort($keysvalue); //key值排序
    reset($keysvalue); //指针重新指向数组第一个
    foreach($keysvalue as $key=>$vals) {
        $keysort[] = $key;
    }
    $keysvalue = array();
    $count=count($keysort);
    if(strtolower($type) != 'asc'){
        for($i=$count-1; $i>=0; $i--) {
            $keysvalue[] = $array[$keysort[$i]];
        }
    }else{
        for($i=0; $i<$count; $i++){
            $keysvalue[] = $array[$keysort[$i]];
        }
    }
    return $keysvalue;
}

/**
 * 求两个日期之间相差的天数
 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
 * @param string $day1
 * @param string $day2
 * @return number
 */
function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}

//根据url判断此页面是否有权限
function linkGetAccess($url){
    /*$pattern = '/.*?('.MODULE_NAME.'\/)?(\w+)\/(\w+)/i';
    preg_match($pattern, $url,$arr);
    // SHOW_PAGE_TRACE 调试模式打开 指定的模块开启所有权限
    if(C('SHOW_PAGE_TRACE') && in_array(ACTION_NAME,array('dbtestone','dbtesttwo','dbtestthree')) && CONTROLLER_NAME == 'Dbtest'){
    	return true;
    }*/
   // return isAbleAccess($arr[2],$arr[3],$arr[1]);
    return true;
}

/*
 * 多维数组，排序
 * @param array $multi_array 排序数组
 * @param str $sort_key 排序字段
 * @param str $sort 排序方式
 * @return array 返回排序后的数组
 * */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){
    if(is_array($multi_array)){
        foreach ($multi_array as $row_array){
            if(is_array($row_array)){
                $key_array[] = $row_array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_array,$sort,$multi_array);
    return $multi_array;
}