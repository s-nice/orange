<!--业务   累计人均卡数页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="../Layout/nav_stat" />
				<div class="select_xinzeng margin_top menu_list">
					<input type="text" value="添加卡片数" readonly='readonly' autocomplete='off'>
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/avgAddCardNum')}" type='total'>人均添加卡片数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/avgUsedCardNum')}" type='total'>人均使用卡片数</li>
						<li class="hand" href="{:U('Appadmin/OraStatBusiness/totalAvgCardNum')}">累计人均卡片数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/totalAvgFavoriteCardNum')}">累计人均常用卡数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/totalCardNum')}">累计卡片数</li>
						<li class='hand on' href="{:U('Appadmin/OraStatBusiness/addCardNum')}">添加卡片数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/addCardUserNum')}">添加卡片用户数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/usedCardNum')}">使用卡片数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/monthTotalAddCardNum')}">当月累计添加卡片数</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/usedNum')}">使用次数</li>
					</ul>
				</div>
				<input type='hidden' value="{$type}" id='typeChange'>
				<div class="select_xinzeng margin_top menu_list">
					<input type="text" value="总数" readonly='readonly' autocomplete='off'>
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='total' <if condition="$type eq 'total'">class="on"</if>>总数</li>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='tpl' <if condition="$type eq 'tpl'">class="on"</if>>模板</li>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='notpl' <if condition="$type eq 'notpl'">class="on"</if>>非模板</li>
					</ul>
				</div>
				<div class="select_xinzeng margin_top menu_list">
					<input type="text" value="总数" readonly='readonly' autocomplete='off'>
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='total' <if condition="$type eq 'total'">class="on"</if>>总数</li>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='brush' <if condition="$type eq 'brush'">class="on"</if>>可刷</li>
						<li href="{:U('Appadmin/OraStatBusiness/addCardNum')}" type='nobrush' <if condition="$type eq 'nobrush'">class="on"</if>>不可刷</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a href="javascript:void(0);" val='d' <if condition="$period eq 'd'">class='on'</if>>1日</a>
					<a href="javascript:void(0);" val='d3' <if condition="$period eq 'd3'">class='on'</if>>3日</a>
					<a href="javascript:void(0);" val='w' <if condition="$period eq 'w'">class='on'</if>>周</a>
					<a href="javascript:void(0);" val='m' <if condition="$period eq 'm'">class='on'</if>>月</a>
				</div>
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">添加卡片数</span>
					<form action="{:U('Appadmin/OraStatBusiness/download')}" target='_blank' method='post'>
					<input type='hidden' value='{$downloaddata}' name='data'>
					<input type='hidden' value='添加卡片数' name='filename'>
					<input type='hidden' value='' name='header'>
					<button class="right_down" type="button">导出</button>
					</form>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t5">日期</span>
						<span class="span_t8">软件版本</span>
						<span class="span_t8">硬件版本</span>
						<span class="span_t4">添加总卡片数</span>
						<span class="span_t6">航旅卡(占比)</span>
						<span class="span_t6">银行卡(占比)</span>
						<span class="span_t6">酒店卡(占比)</span>
						<span class="span_t6">会员卡(占比)</span>
						<span class="span_t6">门禁卡(占比)</span>
						<span class="span_t6">其他(占比)</span>
					</div>
					<div class="table_scrolls clear">
						<foreach name='list' item='v'>
						<div class="table_list">
							<span class="span_t5">{$v.dt}</span>
							<span class="span_t8">{$v.pro_version}</span>
							<span class="span_t8">{$v.model}</span>
							<span class="span_t4">{$v.total}</span>
							<span class="span_t6">{$v.card3}</span>
							<span class="span_t6">{$v.card1}</span>
							<span class="span_t6">{$v.card4}</span>
							<span class="span_t6">{$v.card15_19}</span>
							<span class="span_t6">{$v.card6}</span>
							<span class="span_t6">{$v.card0}</span>
						</div>
						</foreach>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var URL="{:U('Appadmin/OraStatBusiness/addCardNum')}";
var onlyEndTime=false;
var gStatisticDateType = "{$period}";
var tip_select_time = "{$T->tip_select_time}";

<include file="@Layout/js_stat_widget" />
var alldata = '{$lineStats}';
var colors = $.parseJSON('{$colors}');
var max=0;
if(alldata != 'null'){
    var xdata = [];//横坐标数据
    alldata = eval('('+alldata+')');
    var numbers=[];
    for(var i in alldata){
        var dataarr = alldata[i];
        var v=parseInt(dataarr.total);
        xdata.push(dataarr.dt)
        numbers.push(v);
        parseInt(v)>parseInt(max) && (max=v);
    }
    var obj = {
        name:'Total',
        type:'line',
        itemStyle:{normal: {color:colors[0]}},
        data:numbers
    };
    
    var rst=paramsForGrid(max);
    var echartOptionLine =  {
        tooltip : {trigger: 'axis'},
        color:['#999'],
        calculable : true,
        xAxis : [{
        	type : 'category',
            data : xdata,
            boundaryGap : false,
            splitLine: {
                show: true
            }
        }],
        yAxis : [{
        	type : 'value',
            max : rst.max,
            splitNumber: rst.splitNumber,
            interval: rst.interval
        }],
        series:[obj]
    };
    var gEchartSettings = [
        {containerId: 'userStatisticsLine', option : echartOptionLine},
    ];
}

$(function(){
	$.business.init();
	$('.table_list span').each(function(){
		$(this).attr('title', $(this).html());
	});
});
</script>