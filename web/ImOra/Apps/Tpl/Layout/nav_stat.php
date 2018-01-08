<form class="form_marginauto js_search_form"  method='get'>
      <div class="content_search">
      	<div class="search_right_c">
                  <div class="js_proversion select_IOS menu_list select_option input_s_width js_s_div" title="{:$_GET['s_versions']?$_GET['s_versions']:'全部软件版本'}">
      			<input type="text" value="{:$_GET['s_versions']?$_GET['s_versions']:'全部软件版本'}" name='sysPlatform' readonly="readonly"  alltext='全部软件版本' autocomplete='off'/>
      			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="s_versions" value="{$s_versions_name}" autocomplete='off'>
      			<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
                              <li title="全部" val="all"><label><input class="js_i_s" type="checkbox" >全部</label></li>
                              <foreach name="s_versions" item="v">
                              <li title="{$v}"><label><input type="checkbox" value="{$v}" autocomplete='off' <if condition="in_array($v,$s_versions_check)">checked="checked"</if>><span class="copyright" title="{$v}">{$v}</span></label></li>
                              </foreach>
      			</ul>
      		</div>
      		<div class="js_modelversion select_IOS menu_list input_s_width select_option js_s_div" title="{:$_GET['h_versions']?$_GET['h_versions']:'全部硬件版本'}">
      			<input type="text" name="channel" value="{:$_GET['h_versions']?$_GET['h_versions']:'全部硬件版本'}"  readonly="readonly"  alltext='全部硬件版本' autocomplete='off'/>
      			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <b></b>
                        <input type="hidden" name="h_versions" value="{$h_versions_name}" autocomplete='off'>
      			<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
            			<li title="全部" val="all"><label><input class="js_i_h" type="checkbox" >全部</label></li>
                              <foreach name="h_versions" item="v">
                              <li title="{$v}"><label><input type="checkbox"  value="{$v}" autocomplete='off'<if condition="in_array($v,$h_versions_check)">checked="checked"</if>><span class="copyright" title="{$v}">{$v}</span></label></li>
                              </foreach>
      			</ul>
      		</div>
      	     <div class="select_time_c">
                            <span>{$T->str_time}</span>
				 <if condition="!isset($endTimeOnly)">
					 <div class="time_c">
						 <input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" autocomplete='off'/>
						 <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
					 </div>
					 <span>--</span>
				 </if>
                              <div class="time_c">
                                    <input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" autocomplete='off'/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                              </div>
                  </div>
            	<input class="submit_button" type="submit" value="{$T->str_submit}"/>
      	</div>
      </div>        
</form>
<link href="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.css" rel="stylesheet" text="text/css">
<script src="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.js"></script>
<script>   
$(function(){
	$.dataTimeLoad.init();
	
	//点击区域外关闭此下拉框
    $(document).on('click',function(e){
        if(!$(e.target).parents('.js_s_div').length){
            $('.js_s_div>ul').hide();
        }
    });

    //下拉
    $('.js_s_div').on('click',function(e){
    	$('.js_s_div>ul').hide();
        if(!$(e.target).parents('ul').length){
            $(this).find('ul').show();
        }
    });
    
	$('.js_s_div').each(function(){
		//全选
		var $all=$(this).find('ul input:first');
		$all.on('click', function(evt){
			evt.stopPropagation();
			var $ul=$(this).parents('ul');
			$ul.find('input').prop('checked', $(this).prop('checked'));
			setValues($ul);
		});

		//单选
		var $items=$(this).find('ul input:gt(0)');
		$items.on('click', function(evt){
			evt.stopPropagation();
			setValues($(this).parents('ul'));
		});

		//加载时是否全选
		var hiddenVal=$(this).find('input:eq(1)').val();
		if (hiddenVal!='' && hiddenVal.split(',').length==$items.length){
			$all.prop('checked',false);
			$all.click(); 
		}
	});

    //赋值
	function setValues($ul){
    var isAllChecked=true;
    var val=[];
    $ul.find('input:gt(0)').each(function(){
      if ($(this).prop('checked')){
        val.push($(this).val());
      } else {
        isAllChecked=false;
      }
    });

     $ul.find('input:first').prop('checked', isAllChecked);
      if (isAllChecked){
        var $input=$ul.parent().find('input:eq(0)');
        $input.val($input.attr('alltext'));
    } else {
      var otherUl  = $ul.parents('.js_s_div').siblings('.js_s_div').find('ul');
      otherUl.find('input').prop('checked',true);
      $.each(otherUl,function(k,v){
         setValues($(this));
      });
      var textVal=val.join(',');
      $ul.parent().find('input:eq(0)').val(textVal);
      $ul.parent().attr('title',textVal);
    }
      $ul.parent().find('input:eq(1)').val(val.join(','));
  }
  //下拉框添加滚动条
  $('.js_scroll_list').mCustomScrollbar({
      theme:"dark", //主题颜色
      autoHideScrollbar: false, //是否自动隐藏滚动条
      scrollInertia :0,//滚动延迟
      horizontalScroll : false,//水平滚动条
  });
});
</script>