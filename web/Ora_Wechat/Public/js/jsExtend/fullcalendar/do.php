<?php
$conn=mysql_connect('127.0.0.1','root','');
mysql_select_db('test');
mysql_set_charset('utf8');
$action = $_REQUEST['action'];
if($action == 'add'){
    $events = stripslashes(trim($_POST['event']));//事件内容
    //$events=mysql_real_escape_string(strip_tags($events),$link); //过滤HTML标签，并转义特殊字符
	$events = strip_tags($events);
    $isallday = $_POST['isallday'];//是否是全天事件
    $isend = $_POST['isend'];

    $startdate = trim($_POST['startdate']);//开始日期
    $enddate = trim($_POST['enddate']);//结束日期

    $s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
    $e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

    if($isallday==1 && $isend==1){
        $starttime = strtotime($startdate);
        $endtime = strtotime($enddate);
    }elseif($isallday==1 && $isend==""){
        $starttime = strtotime($startdate);
    }elseif($isallday=="" && $isend==1){
        $starttime = strtotime($startdate.' '.$s_time);
        $endtime = strtotime($enddate.' '.$e_time);
    }else{
        $starttime = strtotime($startdate.' '.$s_time);
    }
    $colors = array("#360","#f30","#06c");
    $key = array_rand($colors);
    $color = $colors[$key];

    $isallday = $isallday?1:0;
    $sql = "insert into demo(title,starttime,endtime,allday,color) values('$events','$starttime','$endtime','$isallday','$color')";
	$result = mysql_query($sql);
    if($result){
        echo '1' ;
    }else{
        echo '写入失败！';
    }
}elseif($action=="edit"){
    //编辑事件
    $id = intval($_POST['id']);
    if($id==0){
        echo '事件不存在！';
        exit;
    }
    $events = stripslashes(trim($_POST['event']));//事件内容
	$events = strip_tags($events);
    $isallday = $_POST['isallday'];//是否是全天事件
    $isend = $_POST['isend']; // 是否有结束时间

    $startdate = trim($_POST['startdate']);//开始日期
    $enddate = trim($_POST['enddate']);//结束日期

    $s_time = $_POST['s_hour'].':'.$_POST['s_minute'].':00';//开始时间
    $e_time = $_POST['e_hour'].':'.$_POST['e_minute'].':00';//结束时间

    if($isallday==1 && $isend==1){
        $starttime = strtotime($startdate);
        $endtime = strtotime($enddate);
    }elseif($isallday==1 && $isend==""){
        $starttime = strtotime($startdate);
        $endtime = 0;
    }elseif($isallday=="" && $isend==1){
        $starttime = strtotime($startdate.' '.$s_time);
        $endtime = strtotime($enddate.' '.$e_time);
    }else{
        $starttime = strtotime($startdate.' '.$s_time);
        $endtime = 0;
    }

    $isallday = $isallday?1:0;
	$sql="update demo set title='$events',starttime='$starttime',endtime='$endtime',allday='$isallday' where id=$id";
    $result = mysql_query($sql);
    if(mysql_affected_rows()==1){
        echo '1';
    }else{
        echo '出错了！';
    }
}elseif($action=="del"){
    //删除事件
	$id = intval($_POST['id']);
	if($id>0){
		mysql_query("delete from demo where id=$id");
		if(mysql_affected_rows()==1){
			echo '1';
		}else{
			echo '出错了！';
		}
	}else{
		echo '事件不存在！';
	}
}
?>