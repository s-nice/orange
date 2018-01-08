<layout name="../Layout/Company/Layout" />
<a href="{:U(MODULE_NAME.'/Login/logout')}">操作成功</a><br/>
<div class="appadmin_panel">
	<div>{$succStr|sprintf=###,'<i id="cls_time_decr">',$totalSec,'</i>'}</div>
	<a href="{:U('Company/Login/logout')}">{$loginStr}</a>
</div>

<script type="text/javascript">
var totalSec = "{:intval($totalSec)}";
setTimeout('jumpurl()',totalSec * 1000); 

setTimeout(countDown,1000);
//倒计时函数
function countDown(){
	totalSec = totalSec - 1;
	$('#cls_time_decr').text(totalSec);
	setTimeout(countDown,1000);
}
function jumpurl(){  
	  window.location.href = "{:U('Company/Login/logout')}";  
}  
</script>
