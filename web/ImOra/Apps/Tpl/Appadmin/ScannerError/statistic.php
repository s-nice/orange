<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
                <div class="content_search">
                    <form name="headForm" action="{:U('OraStatEntranceGuard/index',array('itemKey'=>$itemKey),'',true)}" method="get" >
                        <div class="search_right_c">
                            <div class="js_modelversion select_IOS menu_list select_option input_s_width js_s_div">
                                <input type="text" name="channel" value="{:$_GET['h_versions']?$_GET['h_versions']:'全部硬件版本'}"  readonly="readonly"  disabled="disabled" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                <b></b>
                                <input type="hidden" name="h_versions" value="{$h_versions_name}">
                                <ul class="js_scroll_list" style="max-height:300px;">
                                    <li title="全部" val="all"><input name="hardware" value="all" type="checkbox" >全部</li>
                                    <foreach name="h_versions" item="v">
                                        <li title="{$v}"><input type="checkbox"  value="{$v}" <if condition="in_array($v,$h_versions_check)">checked="checked"</if>>{$v}</li>
                                    </foreach>
                                </ul>
                            </div>
                            <div class="select_time_c">
                                <span>{$T->str_time}</span>
                                <if condition="$type eq 0">
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
                            <input class="submit_button" type="button" value="{$T->str_submit}"/>
                        </div>
                    </form>
                </div>
				<div class="select_xinzeng margin_top menu_list">
					<input type="text" value="人均添加卡片数量" readonly='readonly' autocomplete='off'>
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li class="on hand" href="{:U('Appadmin/OraStatBusiness/avgAddCardNum')}" type='total'>人均添加卡片数量</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/avgUsedCardNum')}" type='total'>人均使用卡片数量</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/totalAvgCardNum')}">累计人均卡片</li>
						<li class='hand' href="{:U('Appadmin/OraStatBusiness/totalAvgFavoriteCardNum')}">累计人均常用卡数</li>
					</ul>
				</div>
				<div id='typeChange' class="select_xinzeng margin_top menu_list">
					<input type="text" value="总数" readonly='readonly' autocomplete='off'>
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li href="{:U('Appadmin/OraStatBusiness/avgAddCardNum')}" type='total' <if condition="$type eq 'total'">class="on"</if>>总数</li>
						<li href="{:U('Appadmin/OraStatBusiness/avgAddCardNum')}" type='tpl' <if condition="$type eq 'tpl'">class="on"</if>>模板</li>
						<li href="{:U('Appadmin/OraStatBusiness/avgAddCardNum')}" type='notpl' <if condition="$type eq 'notpl'">class="on"</if>>非模板</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a href="javascript:void(0);" val='d' <if condition="$period eq 'd'">class='on'</if>>1日</a>
					<a href="javascript:void(0);" val='d3' <if condition="$period eq 'd3'">class='on'</if>>3日</a>
					<a href="javascript:void(0);" val='w' <if condition="$period eq 'w'">class='on'</if>>周</a>
					<a href="javascript:void(0);" val='m' <if condition="$period eq 'm'">class='on'</if>>月</a>
				</div>	
			</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">人均扫描数</span>
					<form action="{:U('Appadmin/OraStatBusiness/download')}" target='_blank' method='post'>
					<input type='hidden' value='{$downloaddata}' name='data'>
					<input type='hidden' value='' name='header'>
					<button class="right_down" type="button">导出</button>
					</form>
				</div>
				<div class="table_content">
					<div class="table_list table_tit clear">
						<span class="span_t5">日期</span>
						<span class="span_t8">硬件版本</span>
						<span class="span_t4">扫描张数(总)</span>
						<span class="span_t8">卖出</span>
						<span class="span_t6">公司发放</span>
						<span class="span_t6">酒店</span>
						<span class="span_t6">咖啡厅</span>
						<span class="span_t6">商场</span>
						<span class="span_t6">机场</span>
						<span class="span_t6">其他</span>
					</div>
					<div class="table_scrolls clear">
						<foreach name='list' item='v'>
						<div class="table_list clear">
							<span class="span_t5">{$v.dt}</span>
							<span class="span_t8">{$v.pro_version}</span>
							<span class="span_t4">{$v.total}</span>
							<span class="span_t8">{$v.model}</span>
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
				<!--表格开始-->
				<div class="table_content">
					<div class="table_list table_tit clear">
						<span class="span_t9">日期</span>
						<span class="span_t9">硬件版本</span>
						<span class="span_t9">故障次数(总)</span>
						<span class="span_t9">卡纸</span>
						<span class="span_t9">传感器失灵</span>
						<span class="span_t9">断网</span>
					</div>
					<div class="table_scrolls clear">
						<foreach name='list' item='v'>
						<div class="table_list clear">
							<span class="span_t9">{$v.dt}</span>
							<span class="span_t9">{$v.pro_version}</span>
							<span class="span_t9">{$v.total}</span>
							<span class="span_t9">{$v.model}</span>
							<span class="span_t9">{$v.card3}</span>
							<span class="span_t9">{$v.card1}</span>
						</div>
						</foreach>
					</div>
				</div>
				<!--表格结束-->

			</div>
		</div>
	</div>
</div>
<script>
    var selfUrl = "{:U('ScannerError/statistic','','',true)}";
    var subUrl = "{:U('ScannerError/statistic',array('itemKey'=>$itemKey),'',true)}";
    $(function(){
        $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $.scannererror.statJs();
    });
</script>