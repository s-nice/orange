<script src='../jquery.form.min.js'></script>
<link rel="stylesheet" type="text/css" href="../jquery-ui.css">
<script>
$(function(){
    $(".datepicker").datepicker();//调用日历选择器
    $("#isallday").click(function(){//是否是全天事件
        if($("#sel_start").css("display")=="none"){
            $("#sel_start,#sel_end").show();
        }else{
            $("#sel_start,#sel_end").hide();
        }
    });

    $("#isend").click(function(){//是否有结束时间
        if($("#p_endtime").css("display")=="none"){
            $("#p_endtime").show();
        }else{
            $("#p_endtime").hide();
        }
       // $.fancybox.resize();//调整高度自适应
    });
    //删除事件
    $("#del_event").click(function(){
        if(confirm("您确定要删除吗？")){
            var eventid = $("#eventid").val();
            $.post("../do.php?action=del",{id:eventid},function(msg){
                if(msg==1){//删除成功
                    $.fancybox.close();
                    $('#calendar').fullCalendar('refetchEvents'); //重新获取所有事件数据
                }else{
                    alert(msg);
                }
            });
        }
    });
});
$(function(){
    //提交表单
    $('#add_form').ajaxForm({
        beforeSubmit: showRequest, //表单验证
        success: showResponse //成功返回
    });
});

function showRequest(){
    var events = $("#event").val();
    if(events==''){
        alert("请输入日程内容！");
        $("#event").focus();
        return false;
    }
}

function showResponse(responseText, statusText, xhr, $form){
    if(statusText=="success"){
        if(responseText==1){
            $.fancybox.close();//关闭弹出层
            $('#calendar').fullCalendar('refetchEvents'); //重新获取所有事件数据
        }else{
            alert(responseText);
        }
    }else{
        alert(statusText);
    }
}
</script>
<?php
$action = $_REQUEST['action'];
if($action == 'add'){
?>
<div class="fancy">
    <h3>新建事件</h3>
    <form id="add_form" action="../do.php?action=add" method="post">
    <input type="hidden" name="action" value="add">
    <p>日程内容：<input type="text" class="input" name="event" id="event" style="width:320px" placeholder="记录你将要做的一件事..."></p>
    <p>关联人：   <select>
    			<option value="111">好友1</option>
    			<option value="111">好友2</option>
    			<option value="111">好友3</option>
    		 </select>
    </p>
    <p>开始时间：<input type="text" class="input datepicker" name="startdate" id="startdate" value="<?php echo $_GET['date'];?>">
	    <span id="sel_start" style="display:none">
		    <select name="s_hour">
		    <?php
		    	for($i=0;$i<24;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
		    <select name="s_minute">
		    <?php
		    	for($i=0;$i<60;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
	    </span>
    </p>
    <p id="p_endtime" style="display:none">结束时间：<input type="text" class="input datepicker"  name="enddate" id="enddate" value="<?php echo $_GET['date'];?>">
	    <span id="sel_end" style="display:none">
		    <select name="e_hour">
		    <?php
		    	for($i=0;$i<24;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
		    <select name="e_minute">
		    <?php
		    	for($i=0;$i<60;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
	    </span>
    </p>
    <p>
    <label><input type="checkbox" value="1" id="isallday" name="isallday" checked> 全天</label>
    <label><input type="checkbox" value="1" id="isend" name="isend"> 结束时间</label>
    </p>
    <div class="sub_btn">
    	<span class="del">
    	</span>
    		<input type="submit" class="btn btn_ok" value="确定">
    		<input type="button" class="btn btn_cancel" value="取消" onClick="$.fancybox.close()">
    </div>
    </form>
</div>
<?php
	}elseif($action == 'edit'){
			$id = $_REQUEST['id'];
			$conn=mysql_connect('127.0.0.1','root','');
			mysql_select_db('test');
			mysql_set_charset('utf8');
			$sql = "select * from demo where id = $id";
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);
			if($row){
				$id = $row['id'];
				$title = $row['title'];
				$starttime = $row['starttime'];
				$start_d = date("Y-m-d",$starttime);
				$start_h = date("H",$starttime);
				$start_m = date("i",$starttime);

				$endtime = $row['endtime'];
				if($endtime==0){
					$end_d = $startdate;
					$end_chk = '';
					$end_display = "style='display:none'";
				}else{
					$end_d = date("Y-m-d",$endtime);
					$end_h = date("H",$endtime);
					$end_m = date("i",$endtime);
					$end_chk = "checked";
					$end_display = "style=''";
				}

				$allday = $row['allday'];
				if($allday==1){
					$display = "style='display:none'";
					$allday_chk = "checked";
				}else{
					$display = "style=''";
					$allday_chk = '';
				}
?>
		<div class="fancy">
		    <h3>编辑事件</h3>
		    <form id="add_form" action="../do.php?action=edit" method="post">
		    <input type="hidden" name="id" id="eventid" value="<?php echo $id;?>">
		    <p>日程内容：<input type="text" class="input" name="event" id="event" style="width:320px" placeholder="记录你将要做的一件事..." value="<?php echo $title;?>"></p>
		    <p>关联人：   <select>
    			<option value="111">好友1</option>
    			<option value="111">好友2</option>
    			<option value="111">好友3</option>
    		 </select>
    		</p>
		    <p>开始时间：<input type="text" class="input datepicker" name="startdate" id="startdate" value="<?php echo $start_d;?>" readonly>
		    <span id="sel_start" <?php echo $display;?>>
		    <select name="s_hour">
		        <option value="<?php echo $start_h;?>" selected><?php echo $start_h;?></option>
		    <?php
		    	for($i=0;$i<24;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    <?php
		    	for($i=0;$i<24;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		        <option value="00">00</option>
		    </select>:
		    <select name="s_minute">
		    <?php
		    	for($i=0;$i<60;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
		    </span>
		    </p>
		    <p id="p_endtime" <?php echo $end_display;?>>结束时间：<input type="text" class="input datepicker" name="enddate" id="enddate" value="<?php echo $end_d;?>" readonly>
		    <span id="sel_end"  <?php echo $display;?>><select name="e_hour">
		        <option value="<?php echo $end_h;?>" selected><?php echo $end_h;?></option>
		    </select>:
		    <select name="e_minute">
			    <?php
		    	for($i=0;$i<60;$i++){
					if($i<10){
		    			echo "<option value='0$i'>0$i</option>";
		    		}else{
		    			echo "<option value='$i'>$i</option>";
		    		}
		    	}
		    ?>
		    </select>
		    </span>
		    </p>
		    <p>
		    <label><input type="checkbox" value="1" id="isallday" name="isallday" <?php echo $allday_chk;?>>
		全天</label>
		    <label><input type="checkbox" value="1" id="isend" name="isend" <?php echo $end_chk;?>> 结束时间</label>
		    </p>
		    <div class="sub_btn"><span class="del"><input type="button" class="btn btn_del" id="del_event"
		value="删除"></span><input type="submit" class="btn btn_ok" value="确定">
		<input type="button" class="btn btn_cancel" value="取消" onClick="$.fancybox.close()"></div>
		    </form>
		</div>
<?php }
	}
?>