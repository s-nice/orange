<?php 
$conn=mysql_connect('127.0.0.1','root','');
mysql_select_db('test');
mysql_set_charset('utf8');
$sql = "select * from demo"; 
$query = mysql_query($sql); 
while($row=mysql_fetch_array($query)){ 
    $allday = $row['allday']; 
    $is_allday = $allday==1?true:false; 
     
    $data[] = array( 
        'id' => $row['id'],//事件id 
        'title' => $row['title'],//事件标题 
        'start' => date('Y-m-d H:i',$row['starttime']),//事件开始时间 
        'end' => date('Y-m-d H:i',$row['endtime']),//结束时间 
        'allDay' => $is_allday, //是否为全天事件 
        'color' => $row['color'] //事件的背景色 
    ); 
} 
var_dump($data);
echo json_encode($data); 
?>