<style>
.time_right{float: right; height: 28px;  margin-top: 20px; position: relative; width: auto; z-index: 11;}
.time_right span{color: #333;display: block;float: left;font: 14px/28px "微软雅黑"; height: 28px; text-align: center; width: 28px;}
.time_right span.active{background: #666; color: #ccc; cursor: pointer; font: 14px/28px "微软雅黑";}
</style>
<form class="form_margintop" style="height:112px;" name="headForm" action="{:U('CardsStat/index','','',true)}" method="get" onsubmit="return submitForm(this);">
			<div class="content_search">
            	<div class="search_right_c">
            	<if condition="in_array($selecItem,array('1','2','3','4')) != false">
            		<div class="js_select_item select_IOS menu_list">
						<input readonly="readonly" type="text" name="sys_platform" title="{:isset($keyword['sys_platform'])?$keyword['sys_platform']:$T->stat_sys_platform}" value="{:isset($keyword['sys_platform'])?$keyword['sys_platform']:$T->stat_sys_platform}" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			    <li class="on" title="{$T->stat_sys_platform}">{$T->stat_sys_platform}</li>
            				<li title="IOS">IOS</li>
            				<li title="Android">Android</li>
            				<li title="Leaf">Leaf</li>
            			</ul>
            		</div>
            	</if>
            		<div class="select_time_c">
					    <span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="start_time" value="{$keyword['start_time']}" readonly="readonly"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="end_time" value="{$keyword['end_time']}"/ readonly="readonly">
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
	            	</div>
	            	<input class="js_submit_form submit_button" type="button" value="{$T->str_submit}"/>
            	</div>
            </div>
            <div class="cards_tishiyu">
            <php>
            	$cardnum = isset($total[0]['cardnum'])?$total[0]['cardnum']:0;
            	$usernum = isset($total[0]['usernum'])?$total[0]['usernum']:0;
            </php>
            <span>{:sprintf($T->stat_total_infomation,$cardnum,$usernum)}</span>
            </div>
            <div class="js_select_item select_xinzeng margin_top">
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<input name="item" type="hidden" value="{$selecItem}" />
            	<input name="item1" type="text" title="{$select[$selecItem]}" val="{$selecItem}" value="{$select[$selecItem]}" />
            	<ul id="selectType">
            		<foreach name="select" item="v" key="k">
<!--             		<a href="{:U('CardsStat/index',array('item'=>$k),'',true)}"><li title="{$v}" val="{$k}">{$v}</li></a> -->
            		<li title="{$v}" class="itemClass" val="{$k}">{$v}</li>
            		</foreach>
            	</ul>
            </div>
            <if condition="$selecItem == '4'">
            <div class="js_select_item select_xinzeng margin_top" style="width: 200px;">
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<input readonly="readonly" type="hidden" name="itemselect" value="{$itemselect}" />
            	<input readonly="readonly" style="width: 200px;" type="text" title="{$itemselectArr[$itemselect]}" value="{$itemselectArr[$itemselect]}" />
            	<ul id="TypeSelect" style="width: 199px;">
            		<foreach name="itemselectArr" item="v" key="k">
            		<if condition="$itemselect != $k">
            		<a href="{:U('CardsStat/index',array('item'=>4,'itemselect'=>$k),'',true)}"><li style="width: 193px;" title="{$v}" val="{$k}">{$v}</li></a>
            		<else/>
            		<li style="width: 193px;" title="{$v}" val="{$k}">{$v}</li>
            		</if>
            		</foreach>
            	</ul>
            </div>
            </if>
            <div class="time_right" style="cursor: pointer;">
            	<input readonly="readonly" name="stattype" type="hidden" value="{$stattype}" />
            	 <if condition="$selecItem != 8">
            	 	<span class="js_timeselect <if condition="$stattype == 'd'">{:'active'}</if>" val="d">{$T->str_date_day}</span>
            	 </if>
            	 <if condition="$selecItem != 7">
                    <span class="js_timeselect <if condition="$stattype == 'w'">{:'active'}</if>" val="w">{$T->str_date_week}</span>
                    <span class="js_timeselect <if condition="$stattype == 'm'">{:'active'}</if>" val="m">{$T->str_date_month}</span>
                 </if>
            </div>
</form>
<script type="text/javascript">
<include file="@Layout/js_stat_widget" />
var gStatisticDateType = "{$stattype}";
function submitForm(form){
	var obj = $(form).find('input[name="item1"]');
	$(form).find('input[name="item"]').val(obj.attr('val'));
	return true;
}
// 推荐好友 显示小标题
<if condition="$selecItem == '4'">
var getLineTitle = '{$itemselectArr[$itemselect]}';
<else />
var getLineTitle = '{$select[$selecItem]}';
</if>
var xdata = {$xdata};
var alldataArr = {$lineArr};
var formType = {:isset($formType)?$formType:"[]"};// 页面按平台下各个分类画线时需要复制该标题
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))}; // 曲线颜色
var maxVal = paramsForGrid('{$maxVal}'); // 曲线最大值
var js_Empty_Time = '{$T->tip_select_time}'; // 请选择时间
</script>