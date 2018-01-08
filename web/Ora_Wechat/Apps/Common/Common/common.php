<?php
    /**
     * 重写uniqid方法，加上随机三位数后缀
     * @return string
     */
    function uniqueID(){
    	return uniqid().rand(1000, 9999);
    }

    /**
     *解析并处理API返回的结果(此方法合并了服务器端和API端返回的错误信息，统一归为错误信息)
     *@param Object $response 待处理的对象
     * @return array 处理后的数组数据
     * @author zhangpeng
     */
     function parseApi($response){
    	$status   = 0; //返回码状态，0表示成功，其他表示操作失败
    	$msg      = ''; //返回信息
    	$data     = NULL; //返回的数据
    	$errorObj = NULL;
    	if(!class_exists('ErrorCoder')){
    		import('ErrorCoder', LIB_ROOT_PATH.'Classes/');
    	}    	
    	// 解析http 请求
    	if ($response instanceof ErrorCoder) { // 请求错误。 错误处理
    		$errorObj = $response;
    	} else {
    		$result = json_decode($response, true);
    		if (empty($result) || !is_array($result)) { // webService 返回数据格式错误
    			$errorObj = new ErrorCoder(ErrorCoder::ERR_HTTP_RESPONSE_ERROR);
    		}else{
    			if ($result['head']['status'] == 1) { //数据操作失败
    				$errorCode = $result['head']['error']['errorcode'];
    				$errorMsg  = $result['head']['error']['description'];
    				$errorData = isset($result['head']['error']['body'])?$result['head']['error']['body']:array();
    				$errorObj = new ErrorCoder($errorCode,$errorMsg);
    			} else {
    				$data = isset($result['body'])?$result['body']:NULL;
    			}
    		}
    	}
    	if($errorObj){ //表示有错误
    		$status = $errorObj->getErrorCode();
    		$msg    = $errorObj->getErrorDesc();
    		$data   = isset($errorData)?$errorData:array();
    		if($status == ErrorCoder::ERR_SESSION_EXPIRED && MODULE_NAME == 'Company'){
    			cookie('Oradt_'.MODULE_NAME, null);
    			session(MODULE_NAME,null);
    			session(MODULE_NAME.'_USER_OTHER_LOGINED', ErrorCoder::ERR_session_expired);
    			$url    =   U('Login/index');
    			redirect($url);
    		}
    	}
    	return array('status'=>$status,'msg'=>$msg,'data'=>$data);
    }
    /**
     * 打印函数
     *@return 数组或者字符串格式
     */
    function p($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
    /**
     * 分页 适用于标签 volist offset/length
     *@return 数字
     *@param page / 当前的页数
     *@param $num / 需要显示的数量
     */
    function pageStart($page=1,$num){
        if (1 == $page) {
            $start  = 0;
        }else{
            $start = ($page - 1) * $num;
        }
        return $start;
    }

    /**
     * 二维数组重构方法
     * @param array $array 需要被处理的二维
     * @param string $column_key 用来放置在key位置上的字段名称,为空时表示修改原key值,默认为空
     * @param string $column_value 用来放置在value位置上的字段名称，为空时表示不修改原value值,默认为空
     * @param string $mulit 是否自动合并key值相同的数据(合并后生成三维数组)，默认不合并
     * @return array 返回数据处理后的数组
     * @author zhangpeng
     */
    function arrayRebuild($array, $column_key = '', $column_value = '', $mulit = false)
    {
    	$rt = array();
    	if (!is_array($array)) {
    		return $rt;
    	}

    	foreach($array as $key => $row) {
    		$_key = ($column_key && isset($row[$column_key]))?$row[$column_key]:$key;
    		$_val = ($column_value && isset($row[$column_value]))?$row[$column_value]:$row;
    		$mulit ? $rt[$_key][] = $_val : $rt[$_key] = $_val;
    	}
    	return $rt;
    }
    /**
     * 对textarea输入的内容在页面回显时的替换(主要替换换行、空格)
     * @param unknown $text
     * return string 返回替换后的字符串
     */
    function textAreaReplace($text)
    {
    	if(!is_string($text)){
    		return false;
    	}
    	return str_replace(array("\r\n","\n",' '), array("<br/>","<br/>","&nbsp;&nbsp;"),$text);
    }
    /**
     * 对于Hr产品添加、修改时价格与单位拆分
     *@param unknown $price
     *return array('price','unit') 返回数组
     */
    function splitUnit($price)
    {
        //将中文 。转换为 .
        // $price = urlencode($price);
        // $price = preg_replace('/%E3%80%82/', '.', $price);
        // $price = urldecode($price);
        $length = strlen($price);
        $number = $unit = $arr ='';
        for ($i=0; $i <$length ; $i++) {
            if (is_numeric($price[$i])) {
                $number.=$price[$i];
            }else if ($price[$i] == '.') {
                $number.='.';
            }else if ($price[$i] == '。') {
                $number.='.';
            }
            else{
                $unit = $i;
                break;
            }
        }
        $arr = array(
                'price'=>$number,
                'unit'=>substr($price, $unit)
                );
        return $arr;
    }
	/**
	 * 截取字符串功能 (注意：是按照英文字母的长度进行计算截取的，一个汉字表示两个英文字母)
	 * 比如cutstr_dis('我是中国人',6),输出:我是中...
	 * @param string $string 原始字符串
	 * @param int $length 需要保留的字符串长度 ()
	 * @param string $dot 超过指定长度时的表示符号
	 * @return string 截取后的字符串
	 */
    function cutstr($string, $length, $dot = '...') {
        if (strlen ( $string ) <= $length) {
            return $string;
        }

        $pre = chr ( 1 );
        $end = chr ( 1 );
        $string = str_replace ( array (
                '&amp;',
                '&quot;',
                '&lt;',
                '&gt;'
        ), array (
                $pre . '&' . $end,
                $pre . '"' . $end,
                $pre . '<' . $end,
                $pre . '>' . $end
        ), $string );

        $strcut = '';
        if (strtolower ( 'utf-8' ) == 'utf-8') {

            $n = $tn = $noc = 0;
            while ( $n < strlen ( $string ) ) {

                $t = ord ( $string [$n] );
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n ++;
                    $noc ++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n ++;
                }

                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr ( $string, 0, $n );
        } else {
            for($i = 0; $i < $length; $i ++) {
                $strcut .= ord ( $string [$i] ) > 127 ? $string [$i] . $string [++ $i] : $string [$i];
            }
        }

        $strcut = str_replace ( array (
                $pre . '&' . $end,
                $pre . '"' . $end,
                $pre . '<' . $end,
                $pre . '>' . $end
        ), array (
                '&amp;',
                '&quot;',
                '&lt;',
                '&gt;'
        ), $strcut );

        $pos = strrpos ( $strcut, chr ( 1 ) );
        if ($pos !== false) {
            $strcut = substr ( $strcut, 0, $pos );
        }
        return (strlen($string)==strlen($strcut)?$string:($strcut . $dot));
    }
    /**
     * @data $month  $rendmonth $day $year
     * @type 判断$day 是 31号 30号 29 号 判断今年是闰年还是平年
     * 判断日程开始月份在 1-12月份的什么位置
     *
     */
      function judgeMonth($month,$rendMonth,$day=0,$year=0)
    {
        $arr = array();
        // 31 天的月份
        $sanyMonth = array(1,3,5,7,8,10,12);
        for ($i=1; $i <=$rendMonth ; $i++) {
            if ($month<=$i) {
                if ($day !=0 || $year !=0) {
                    if ($day == 31) {
                        if (in_array($i, $sanyMonth)) {
                           $arr[] = $i;
                        }
                    }else if ($day == 30) {
                        if ($i != 2) {
                            $arr[] = $i;
                        }
                    }else if ($day == 29) {
                        if (($year%4) == 0) {
                            $arr[] = $i;
                        }else{
                            if ($i != 2) {
                                $arr[] = $i;
                            }
                        }
                    }else{
                        $arr[] = $i;
                    }
                }else{
                    $arr[] = $i;
                }

            }
        }
        return $arr;
    }
    /**
     * 判断31 30 29 在不在某一月内
     *&type $day $month $year
     */
    function judgeDay($day,$month,$year)
    {
        $result = '';
        // 31 天的月份
        $sanyMonth = array(1,3,5,7,8,10,12);
        if (in_array($month, $sanyMonth)) {
            $result = 1;
        }else{
            if ($day == 31) {
                $result = 0;
            }else{
                if ($month == 2) {
                    if (($year%4)==0) {
                        if ($day <=29) {
                            $result = 1;
                        }else{
                            $result = 0;
                        }
                    }else{
                        if ($day <= 28) {
                            $result = 1;
                        }else{
                            $result = 0;
                        }
                    }
                }else{
                    $result = 1;
                }
            }
        }
        return $result;
    }

    /*生成随机字符串*/
    function generate_password($length = 8)
    {
        // 随机字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    /**
    * 计算某年某月有多少天数
    * cal_days_in_month();php.ini内置函数可以不存在
    */
    function matchDays($year,$month)
    {
        $days = '';
        $sanyMonth = array(1,3,5,7,8,10,12);
        if (in_array($month, $sanyMonth)) {
            $days = 31;
        }else{
            if (2 == $month) {
                if (0 == ($year%4)) {
                    $days = 29;
                }else{
                    $days = 28;
                }
            }else{
                $days = 30;
            }
        }
        return $days;
    }
   /**
    * 计算某年某月有多少天数
    */
   // function matchDays($year,$month)
   // {
   //    $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
   //    return $days;
   // }
   /**
    * 根据周几
    */
   function judgeWeak($weak)
   {
        $str = '';
        switch ($weak) {
            case 0:
                $str = '周日';
                break;
            case 1:
                $str = '周一';
                break;
            case 2:
                $str = '周二';
                break;
            case 3:
                $str = '周三';
                break;
            case 4:
                $str = '周四';
                break;
            case 5:
                $str = '周五';
                break;
            case 6:
                $str = '周六';
                break;
        }
        return $str;
   }


   /**
    * 判断页面是否具有此操作
    * @param string  $operation 操作名称
    * @param $string $mod 模块名称
    * return boolean
    */
    function hasOperation($operation,$mod=CONTROLLER_NAME){
        $userinfo = session(MODULE_NAME);
        $myAuthorityList = $userinfo['rolelist'];
         $r = in_array($operation,$myAuthorityList[$mod]);
         return $r;
    }

/**
 * des 基础分页的相同代码封装，使前台的代码更少
 * @param int $count 要分页的总记录数
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage($count, $pagesize = 10, $theme = MODULE_NAME) {
    import('NewPage',LIB_ROOT_PATH . 'Classes/');// 导入分页类
    $Page       = new Think\NewPage($count,$pagesize);// 实例化分页类 传入总记录数
    switch ($theme)
    {
    	case 'Company':
    		$Page->setConfig('header', '');
    		$Page->setConfig('prev', '上一页');
    		$Page->setConfig('next', '下一页');
    		$Page->setConfig('theme', '%NOW_PAGE/TOTAL_PAGE%%UP_PAGE%%DOWN_PAGE%%JUMP_PAGE%%NOW_PAGE%');
    		$Page->lastSuffix = false;//最后一页不显示为总页数
    		break;
    	case 'Appadmin':
            $Page->setConfig('header', '');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '%NOW_PAGE/TOTAL_PAGE%%UP_PAGE%%DOWN_PAGE%%JUMP_PAGE%%NOW_PAGE%');
            $Page->lastSuffix = false;//最后一页不显示为总页数
/*    		$Page->setConfig('header', '<div class="pageHeader"><span class="listRows">每页 %LISTROWS% 条</span><span class="nowPage">当前第[ %NOWPAGE% ]页</span><span class="totalPages">/共 %TOTALPAGES% 页</span></div>');
    		$Page->setConfig('first', '首页');
    		$Page->setConfig('prev', '上一页');
    		$Page->setConfig('next', '下一页');
    		$Page->setConfig('last', '尾页');
    		$Page->setConfig('theme', '%HEADER%  %FIRST%  %UP_PAGE%  %DOWN_PAGE%  %END%  %JUMP_PAGE%');
    		$Page->rollPage = 0;
    		$Page->lastSuffix = false;//最后一页不显示为总页数*/
    		break;
    	default:
    		$Page->setConfig('header', '');
    		$Page->setConfig('prev', '上一页');
    		$Page->setConfig('next', '下一页');
    		$Page->setConfig('theme', '%NOW_PAGE/TOTAL_PAGE%%UP_PAGE%%DOWN_PAGE%%JUMP_PAGE%%NOW_PAGE%');
    		$Page->lastSuffix = false;//最后一页不显示为总页数
    }
    return $Page;
}

/**
 * 递归打印列表
 * @param array $list 数据列表
 * @param number $entranceKey 入口key
 * @param string $parentKey  用来定位子集的key值
 * @param string $parentTag 用来打印列表的html标签
 * @param string $childTag  用来打印子元素列表的html标签
 * @return string
 */
function recursivePrint ($list, $entranceKey=0, $parentKey='id', $parentTag='ul', $childTag='li')
{
    $string = '';
    if (! isset($list[$entranceKey])) {
        return $string;
    }
    $string = $string . '<' . $parentTag . ">\r\n";
    foreach ($list[$entranceKey] as $_info) {
        $string = $string .  '<' . $childTag . ' parentId="' . $entranceKey . '"';
        if (isset($_info['id'])) {
            $string = $string .  ' id="' . $_info['id'] . '"';
        }
        foreach ($_info as $_k=>$_v) {
            if (in_array($_k, array('id', 'name', 'parent'))) {
                continue;
            }
            $string = $string .  ' ' . $_k . '="' . $_v . '"';
        }
        $string = $string .  '>';
        if (isset($_info['name'])) {
            $string = $string .  '<i>' . $_info['name'] . '</i>';
        }
        if (isset($list[$_info[$parentKey]])) {
            $string = $string .  '<u></u>';
            $string = $string .  recursivePrint($list, $_info[$parentKey], $parentKey, $parentTag, $childTag);
        }
        $string = $string .  '</' . $childTag . ">\r\n";
    }
    $string = $string .  '</' . $parentTag . ">\r\n";

    return $string;
}

/**
 * 获取几号
 * @param date $date
 * @return int
 */
function _getDate($date){
	return intval(substr($date, 8));
}

/**
 * 日期计算
 * @param date $startDate
 * @param date $endDate
 * @param string $statType (d日，w周，m月)
 * @return array['startDate', 'endDate'] or false
 */
function _processDate($startDate, $endDate, $statType='d'){
	//$startDate = '2016-05-01';
	//$endDate = '2016-05-30';
	//$statType = 'w';
	if(empty($startDate) && empty($endDate)){
		//为空时，给默认值
		switch ($statType){
			case 'w':
				$endDate 	= date('Y-m-d',strtotime('last Sunday'));
				$startDate	= date('Y-m-d',strtotime('-11 weeks'.$endDate)-3600*24*6);
				break;
			case 'm':
				$endDate 	= date('Y-m-d',strtotime('first day of this month')-24*3600);
				$startDate	= date('Y-m-d',strtotime('-12 months'.$endDate)+24*3600);
				break;
			case 'd3':
			    $endDate 	= date('Y-m-d',strtotime('-1 day'));
			    $startDate	= date('Y-m-d',strtotime('-89 days'.$endDate));
			    break;
			default:
				$endDate 	= date('Y-m-d',strtotime('-1 day'));
				$startDate	= date('Y-m-d',strtotime('-30 days'.$endDate));
		}
	} else {
		switch ($statType){
			case 'w':
				if (_getDay($startDate) != 1) {
					//$startDate = _firstDateOfWeek(_addDate($startDate, 7));
					$startDate = _firstDateOfWeek($startDate);
				}
				if (_getDay($endDate) != 0) {
					//$endDate = _addDate(_firstDateOfWeek($endDate), -1);
					$endDate = _addDate(_firstDateOfWeek(_addDate($endDate, 7)), -1);
				}
				break;
			case 'm':
				if (_getDate($startDate) != 1){
					//$startDate = _addDate(_lastDateOfMonth($startDate), 1);
					$startDate = _firstDateOfMonth($startDate);
				}
				if (_getDate(_addDate($endDate, 1)) != 1){
					//$endDate = _addDate(_firstDateOfMonth($endDate), -1);
					$endDate = _lastDateOfMonth($endDate);
				}
				break;
            case 'd3':
                $diffDay=(strtotime($endDate)-strtotime($startDate))/86400+1;//开始结束时间相差天数(算本身天数)
                //print_r(array('startDate'=>$startDate, 'endDate'=>$endDate));
                if($diffDay<3){ //相差小于3天
                    $startDate=date('Y-m-d',strtotime('-2 days'.$endDate));
                }else if($diffDay%3!=0){ //不是3的倍数
                    $startDate=date('Y-m-d',strtotime($startDate)+($diffDay%3)*86400);
                }
                break;
			default:
				break;
		}
	}

	/*
	 if (strtotime($endDate) < strtotime($startDate)) {
	return false;//无数据
	}*/
	//print_r(array('startDate'=>$startDate, 'endDate'=>$endDate));die;
	return array('startDate'=>$startDate, 'endDate'=>$endDate);
}

/**
 * 日期所属月的第一天
 * @param date $date
 * @return date
 */
function _firstDateOfMonth($date){
	return substr($date, 0, 8).'01';
}

/**
 * 日期所属月的最后一天
 * @param date $date
 * @return date
 */
function _lastDateOfMonth($date){
	return date('Y-m-d', strtotime('last day of this month', strtotime($date)));
}

/**
 * 获取星期几
 * @param date $date
 * @return int
 */
function _getDay($date){
	return date('w', strtotime($date));
}

/**
 * +多少天
 * @param date $date
 * @param int $add
 * @return date
 */
function _addDate($date, $add){
	return date('Y-m-d', strtotime($add.' day', strtotime($date)));
}

/**
 * 日期所属周的第一天（星期一）
 * @param date $date
 * @return date
 */
function _firstDateOfWeek($date){
	$day = _getDay($date);
	if ($day == 1){
		return $date;
	}

	$add = -6;
	if ($day >= 2){
		$add = -($day-1);
	}

	return _addDate($date, $add);
}

    //获取dealAuthortyList处理后的数组中的arr键值
    function getAuthortyList($AuthorityList,$permission=array()){
        $arr = dealAuthortyList($AuthorityList,$permission);
        return $arr['arr'];
    }

    /**
     * @param array 配置文件中的权限数组
     * @param array 数据库中保存的权限数组
     * @return array 递归处理，返回带标记的权限数组，方便前台判断是否勾选
     */
    function dealAuthortyList($AuthorityList,$permission=array()){
        $arr = array();
        //$num = 0;
        $bool = 0;
        foreach ($AuthorityList as $k => $v) {
            $v['isCheck'] = 0;
            if(isset($v['children'])){
                $return = dealAuthortyList($v['children'],$permission);
                $v['children'] = $return['arr'];
                //先将所有权限置为0
                $v['isCheck'] = $return['bool'];
                if($return['bool']>=1){
                    $bool++;
                }
            }else{
                $access = $v['access'];
                //当有某子功能的权限时，此子功能isCheck置为1，且其父功能的isCheck也置为1
                if(checkAccess($access,$permission)){
                    $v['isCheck']=1;
                    $bool++;
                }
            }
            $arr[$k] = $v;
        }
        return array('arr'=>$arr,'bool'=>$bool);
    }


    /**
     * @param array 配置文件中的权限数组
     * @param string 前台提交过来的字符串
     * @return array 权限数组
     */
    function dealPostAccess($AuthorityList,$str){
        $array = array();
        $authList = explode(',',$str);//post过来的选中数据
        foreach($authList as $v){
            $nameArr = explode('__',$v);
            $count = count($nameArr);
            if($count==1){
                $access=$AuthorityList[$nameArr[0]]['access'];
            }elseif($count==2){
                $access=$AuthorityList[$nameArr[0]]['children'][$nameArr[1]]['access'];
            }elseif($count==3){
                $access=$AuthorityList[$nameArr[0]]['children'][$nameArr[1]]['children'][$nameArr[2]]['access'];
            }
            $array=array_merge($array,$access);
        }
        return $array;
    }

    //检查此功能是否勾选
    function checkAccess($access,$permission){
        $bool = true;
        foreach ($access as $key => $value) {
            $ctr = trim($value['ctr']);
            $actArr = strtoArr($value['act']);
            if(!arrayContain($actArr,$permission[$ctr])){
                $bool = false;
                break;
            }
        }
        return $bool;
    }
    //检查一个数组是否包含另一个 数组
    function arrayContain($arr1,$arr2){
        $bool = true;
        foreach ($arr1 as $v) {
            if(!in_array($v,$arr2)){
                $bool = false;
                break;
            }
        }
        return $bool;
    }

    //整理得到的CONTROLLER,ACTION数组,转换为存储在数据库中的格式
    function getCtrActList($access){
        $arr = array();
        foreach($access as $v){
            $ctr = trim($v['ctr']);
            if(!isset($arr[$ctr])){
                $arr[$ctr] = $v['act'];
            }else{
                $arr[$ctr]= $arr[$ctr].','.$v['act'];
            }
        }
        foreach ($arr as $key => $value) {
            $arr[$key] = strtoArr($value);
        }
        return $arr;
    }

    //字符串转成数组并去重
    function strtoArr($str){
        $str = trim($str);
        $arr = explode(',',$str);
        $arr = array_unique($arr);
        $arr = array_values($arr);
        return $arr;
    }

    /**
     * @param string controller名称
     * @param string action名称
     * @param string APP名字， session的key值
     * @return bool 是否可以进入对应模块的controller和action。
     */
    function isAbleAccess ($controller,$action,$app=null)
    {
        $app = $app?$app:MODULE_NAME;
        //判断是否不需要登录
        $no_login_arr = C('NO_NEED_LOGIN');
        if(isset($no_login_arr[$app][strtolower($controller)])){
            if($no_login_arr[$app][strtolower($controller)][0] == '*' || in_array($action, $no_login_arr[$app][strtolower($controller)])){
                return true;
            }
        }
        $session = session($app);
        //判断是否是管理员
        if(isset($session['isAdmin'])&&($session['isAdmin']==1)){
            return true;
        }
        //先查看免验证的功能
        $free_arr = C('FREE_CTR_ACT');
        if(isset($free_arr[$controller])&&(in_array($action,$free_arr[$controller])||($free_arr[$controller]=='*'))){
            return true;
        }
        $authority = $session['rolelist'];
        $action = strtolower($action);
        if (isset($authority[$controller])
         && in_array($action, array_map('strtolower', $authority[$controller]))) {
           return true;
        }else{
            return false;
        }
    }

    /**
     * @param array 多个角色的权限三维 数组
     * @return array 权限二维数组，也就是写入到session中的数组格式
     */
    function mergePermission ($arr)
    {
        $array = array();
        foreach ($arr as $k => $v) {
            foreach ($v as $key => $value) {
                if(isset($array[$key])){
                    $array[$key] = array_merge($array[$key],$value);
                }else{
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }


   /**   加密函数
     * @param string 要加密的字符串
     * @param string 盐
     * @return string 加密后的字符串
     */
    function en_crypt($str,$key){//加密
        $md5 = md5(rand(0,1000));
        $tmp = '';
        for ($i=0; $i < strlen($str) ; $i++) {
            $j = $i%strlen($md5);
            $tmp .= $md5[$j].($str[$i] ^ $md5[$j]);
        }
        return base64_encode(assist($tmp,$key));
    }

    /**   解密函数
     * @param string 要解密的字符串
     * @param string 盐
     * @return string 解密密后的字符串
     */
    function de_crypt($str,$key){//解密
        $str = assist(base64_decode($str),$key);
        $tmp = '';
        for ($i=0; $i < strlen($str) ; $i++) {
            $tmp .= $str[$i] ^ $str[++$i];
        }
        return  $tmp;
    }
    //加解密辅助函数 将$str同MD5($key) 顺序相同的字符 按位异或  组成新的字符串
    function assist($str,$key){
        $md5 = md5($key);
        $tmp = '';
        for ($i=0; $i < strlen($str) ; $i++) {
            $j = $i%strlen($md5);
            $tmp .= $str[$i] ^ $md5[$j];
        }
        return $tmp;
    }
    /**
     * 判断是否为空，若干为空给定默认值，否则返回原值
     * @param string $val
     * @param string $default
     */
    function isEmpty($val,$default='---'){
    	$val = trim($val);
    	if(empty($val)){
    		return $default;
    	}else{
    		return $val;
    	}
    }

    /**
     +----------------------------------------------------------
     * 把返回的数据集转换成Tree（递归处理函数）
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
    	// 创建Tree
    	$tree = array();
    	if(is_array($list)) {
    		// 创建基于主键的数组引用
    		$refer = array();
    		foreach ($list as $key => $data) {
    			$refer[$data[$pk]] =& $list[$key];
    		}
    		foreach ($list as $key => $data) {
    			// 判断是否存在parent
    			$parentId = $data[$pid];
    			if ($root == $parentId) {
    				$tree[] =& $list[$key];
    			}else{
    				if (isset($refer[$parentId])) {
    					$parent =& $refer[$parentId];
    					$parent[$child][] =& $list[$key];
    				}
    			}
    		}
    	}
    	return $tree;
    }
	/**
     * 解析名片数据信息
     * @param string $card
     * @return array $arr
     */
    function getCardArr($data=''){
    	$arr = array();
    	$cardData = @json_decode($data, true);
    	if (is_array($cardData)) {
    		//解析名片json数据
    		$cardData = isset($cardData['front'])?$cardData['front']:array();
    		$arr['name'] =  ''; // 姓名
    		$arr['mobile'] = ''; // 手机
    		$arr['job'] = ''; // 职位
    		$arr['company_name'] = ''; // 公司
    		$arr['department'] = ''; // 部门
    		$arr['email'] = ''; // 邮箱
    		$arr['address'] = ''; // 公司地址
    		$arr['web'] = ''; // 网址
    		$arr['fax'] = ''; // 传真
    		$arr['telephone'] = ''; // 电话

    		foreach (array('name','mobile') as $key){
    			if(isset($cardData[$key])){
    				$value = '';
    				foreach ($cardData[$key] as $v){
    					$value .= $v['value'].',';
    				}
    				$arr[$key] = trim($value,',');
    			}
    		}
    		$company = isset($cardData['company'])?$cardData['company']:array();
    		$comKey = array('department','job','address','company_name','telephone','fax','email','web');
    		foreach ($company as $companyV){
    			foreach ($comKey as $key){
    				if(isset($companyV[$key])){
    					foreach ($companyV[$key] as $v){
    						$arr[$key] .= $v['value'].',';
    					}
    					$arr[$key] = trim($arr[$key],',');
    				}
    			}
    		}

    	}else{
    		//解析名片vcf数据
    		if (!class_exists('CardOperator')) {
				require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
            }
    		$CardOperator = new \CardOperator();
    		$vcard = $CardOperator->parseVcardText($data);
    		if(isset($vcard[0])){
    			$vcard = $vcard[0];
    		}
    		$arr['name'] = isset($vcard['name']) ? $vcard['name']['value'] : ''; // 姓名
    		$arr['mobile'] = isset($vcard['mobilephone1']) ? $vcard['mobilephone1']['value'] : ''; // 手机
    		$arr['job'] = isset($vcard['title']) ? $vcard['title']['value'] : ''; // 职位
    		$arr['company_name'] = isset($vcard['company']) ? $vcard['company']['value'] : ''; // 公司
    		$arr['department'] = isset($vcard['department']) ? $vcard['department']['value'] : ''; // 部门
    		$arr['email'] = isset($vcard['email1']) ? $vcard['email1']['value'] : ''; // 邮箱
    		$arr['address'] = isset($vcard['address']) ? $vcard['address']['value'] : ''; // 公司地址
    		$arr['web'] = isset($vcard['web']) ? $vcard['web']['value'] : ''; // 网址
    		$arr['fax'] = isset($vcard['fax1']) ? $vcard['fax1']['value'] : ''; // 传真
    		$arr['telephone'] = isset($vcard['officephone1']) ? $vcard['officephone1']['value'] : ''; // 电话
    	}
    	return $arr;
    }

    /**
     *  超过2038年1月19日的时间戳转换为日期
     * $param  int  $time 要转换的时间戳
     * $param  str  $format  转换的日期格式
     * $param   str  $timeZone 设置时区
     *
     * */

    function overflowTimeToDate($time,$format=null,$timeZone=null){
        if($time>strtotime('2038-01-19')){
            $format=isset($format) ? $format : 'Y-m-d';
            $d = new \DateTime('@'.$time);
            isset($timeZone) && $d->setTimezone(new DateTimeZone($timeZone));
            return $d->format($format);

        }else{
            return date($time,$format);

        }

    }
    //
    function curlPost($url, $post_data){
        $post_data = json_encode($post_data);
        $url = C('NEWPAGE_API').$url;
        //Log::write("START--Wechat demo $url with params $post_data", 'INFO');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        $output = curl_exec($ch);
        //echo $output;die;
       // Log::write("CONTENT--$output", 'INFO');
        $arr = json_decode($output, true);
        curl_close($ch);
      //  Log::write("END--Wechat demo $url with params $post_data", 'INFO');
        if (empty($arr)) {
            echo '无法解析JSON数据';
            echo $output;
            die;
        }
        return $arr;
    }

    function substrtext($text, $length)
    {
        if(mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8').'...';
        return $text;
    }


