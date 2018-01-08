<form name="headForm" action="{:U('OraStatCard/index','','',true)}" method="get" onsubmit="if(typeof (submitFun)!='undefined'){
return submitFun(this);}">
      <div class="content_search">
      	<div class="search_right_c">
			<if condition="!isset($notShowVersions)">
				<div class="select_IOS menu_list select_option input_s_width js_s_div">
					<input type="text"  defaultVal="全部软件版本"
					<if condition=" isset($software)">value="{$software}" title="{$software}"<else/> value='全部软件版本'</if>name='sysPlatform' readonly="readonly"   />
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
					<b></b>
					<input type="hidden" name="s_versions" value="">
					<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
						<li title="全部"><input class="js_i_s" name="software" value="all" type="checkbox" >全部</li>
						<foreach name="s_versions" item="v">
							<li title="{$v}"><input type="checkbox" value="{$v}" <if condition="in_array($v,$s_versions_check)">checked="checked"</if>>{$v}</li>
						</foreach>
					</ul>
				</div>
				<div class="select_IOS menu_list select_option input_s_width js_s_div">
					<input type="text" name="channel" defaultVal="全部硬件版本"
					<if condition=" isset($hardware)">value="{$hardware}" title="{$hardware}"<else/>value='全部硬件版本'</if>  readonly="readonly"   />
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
					<b></b>
					<input type="hidden" name="h_versions" value="">
					<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
						<li title="全部"><input class="js_i_h" name="hardware" value="all" type="checkbox" >全部</li>
						<foreach name="h_versions" item="v">
							<li title="{$v}"><input type="checkbox"  value="{$v}" <if condition="in_array($v,$h_versions_check)">checked="checked"</if>>{$v}</li>
						</foreach>
					</ul>
				</div>
			</if>
      	    <div class="select_time_c">
				<span>{$T->str_time}</span>
				<!-- 是否只有截至时间 -->
				<if condition="$startStopTime != 'stop'">
				<div class="time_c">
					<input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" />
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
				</div>
				<span>--</span>
				</if>
				<div class="time_c">
					<input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" />
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                </div>
             </div>
			<input type="hidden" value="{$stattype}" name="date_type">
            <input class="submit_button" type="submit" value="{$T->str_submit}"/>
      	</div>
      </div>
      <!-- 小标题 -->
      <div id="js_selectitem_div" class="select_xinzeng margin_top">
			<input id="itemKeyNow" type="text" >
			<i><img src="/images/appadmin_icon_xiala.png"></i>
			<ul></ul>
	  </div>

	  <!-- 1日3日周月 -->
	  <if condition="isset($statTypeArr)">
		  <div class="js_stat_date_type">
		  <input readonly="readonly" name="date_type" type="hidden" value="{$stattype}" />
		  <foreach name="statTypeArr" key="k" item="v">
		  	<a class="js_stattype <if condition="$k == $stattype">on</if>" val="{$k}"
					 href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME,
					array('endTime'=>$params['endTime'],
					'startTime'=>$params['startTime'],
					'date_type'=>$k,
					'itemKey'=>$itemKey))}">{$v}
	       </a>
		  </foreach>
		 </div>
	 </if>
</form>  
<script type="text/javascript">   
$(function(){
    function checkAll(oDom){
          var isAll = true;
          var boxs = oDom.find('input[type=checkbox]');
          $.each(boxs,function(k,v){
                if(k){   
                      if(!$(this).is(':checked')){
                            isAll = false;
                      }
                }
          });
          boxs.eq(0).prop('checked',isAll);
	/*	oDom.find('input[type=text]').val($(this).attr('defaultVal'));//input value title
		oDom.attr('title',$(this).attr('defaultVal'));*/

    }
    function getCheckValue(oDom){
          var boxs = oDom.find('input[type=checkbox]');
          var arr = [];
		  var i =0;
          $.each(boxs,function(k,v){
                if(k){   
                      if($(this).is(':checked')){
						  i++;
                            arr.push($(this).val());
                      }
                }
          });
          var str = arr.join(',');
		  if(boxs.length-1 != i){
			  oDom.find('input[type=hidden]').val(str);
			  oDom.find('input[type=text]').val(str);//input value title
			  oDom.attr('title',str);
		  }else{
			  oDom.find('input[type=hidden]').val('');
			  var defaultVal =oDom.find('input[type=text]').attr('defaultVal');
			  oDom.find('input[type=text]').val(defaultVal);//input value title
			  oDom.attr('title',$(this).attr(defaultVal));
		  }

		  //setValues(oDom);
    }
    //点击区域外关闭此下拉框
    $(document).on('click',function(e){
          if(!$(e.target).parents('.js_s_div').length){
                $('.js_s_div>ul').hide();
          }
    });
    $('.js_s_div').on('click',function(e){
          if(!$(e.target).parents('ul').length){
                $(this).find('ul').toggle();
          }
    });
    
    $('.js_s_div').on('click','input[type=checkbox]',function(){

          var index = $(this).parent('li').index();
          if(index){
                checkAll($(this).parents('.js_s_div'));

          }else{
                $(this).parents('.js_s_div').find('input[type=checkbox]').prop('checked',$(this).is(':checked'));
          }
          getCheckValue($(this).parents('.js_s_div'));
    })
    $.dataTimeLoad.init();
    $.each($('.js_s_div'),function(){
          checkAll($(this));
    })
});

</script>
<!-- 页面内容 -->
<script type="text/javascript">
	$(function(){
    $('.js_scroll_list').mCustomScrollbar({
      theme:"dark", //主题颜色
      autoHideScrollbar: false, //是否自动隐藏滚动条
      scrollInertia :0,//滚动延迟
      horizontalScroll : false,//水平滚动条
    });

		$('#js_selectitem_div').selectPlug({
			getValId: 'itemKey', 
			defaultVal: '{$itemKey}',
			liValAttr: 'item',
			dataSet:{:json_encode($selectArr)}
				});
		// 生成下载模块
		var hidForm = $('form[name="headForm"]').clone().attr({'style':'display:none','name':'headForm1'}).removeAttr('onsubmit');
		$('body').append(hidForm);
		$.each(hidForm.find('input'),function(i,dom){
			$(dom).removeAttr('id');
		});
		$('form[name="headForm1"]').append('<input name="download" type="hidden" value="download" />');

		$('form[name="headForm"]').on('submit',function(){ //带有开始结束时间 不能只填写其中一个
			if($('#js_begintime').length > 0 && ($('#js_begintime').val()=='' ^ $('#js_endtime').val()=='')){
				$('#js_begintime').val('') ;
				$('#js_endtime').val('');
				$('input[name="date_type"]').val('0')
			}

		})
	});
	// 切换小标题 刷新页面
	$('#js_selectitem_div').on('click','li',function(){
		var olditem="{:$itemKey}";
		var newitem=$(this).attr('item');

		if(newitem != olditem){
			var betweenArr=<?php  echo $betweenArr ?>;//需要查询开始结束时间的页面
			betweenArr=betweenArr.split(',');
			var url="{:U('OraStatCard/index','','',true)}" +'?itemKey='+$(this).attr('item');
			if(($.inArray(olditem,betweenArr)== -1) && ($.inArray(newitem,betweenArr)== -1) ){
				//都为查询累计 只查询结束时间
				url+='&endTime='+$('#js_endtime').val();
			}else if($.inArray(olditem,betweenArr)!= -1 && $.inArray(newitem,betweenArr)!= -1) {
				//都为区间时间查询 开始结束时间
				if(($('#js_begintime').val()=='' ^ $('#js_endtime').val()=='')){
					$('#js_begintime').val('') ;
					$('#js_endtime').val('');
					$('input[name="date_type"]').val('0')
				}
				url+='&startTime='+$('#js_begintime').val() +'&endTime='+$('#js_endtime').val()+'&date_type='+$('input[name="date_type"]').val();

			}else{ //两个页面不相同 时间参数不带入
				url="{:U('OraStatCard/index','','',true)}"
					+'?itemKey='+$(this).attr('item');
			}
			window.location.href=url;
		}
	});
   
	var js_Empty_Time = '{$T->tip_select_time}'; // 请选择时间
	var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))}; // 曲线颜色
	// 曲线最大值决定纵轴最大值
	<include file="@Layout/js_stat_widget" />
	var maxVal = paramsForGrid('800');
</script>