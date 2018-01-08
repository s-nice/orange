<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="form_margintop">
	            <div class="content_search">
	            	<div class="search_right_c">
	            		<div id="select_platform" class="select_sketch menu_list select_IOS js_sel_public js_sel_user_app js_select_item">
	            			<input  name="sysPlatformId" id="sysPlatformId" type="text" value="<if condition='!empty($sysPlatform)'>{$sysPlatform}<else/>{$T->str_title_app_type}</if>" class="hand" readonly="readonly"/>
	            			<i class="hand"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="hand js_sel_ul">
		            		<li class="on" title="{$T->stat_sys_platform}" val="{$T->stat_sys_platform}"  class="hand">{$T->stat_sys_platform}</li>
            			    	<volist name="appTypeSet" id="vo">
		            				<li title="{$vo}" val="{$key}" <if condition="$sysPlatform eq $vo"> class='on'</if>>{$vo}</li>
		            			</volist>
	            			</ul>
	            		</div>
	            		<div  id="select_channel" class="select_sketch js_sel_public js_sel_user_channel js_select_item js_multi_select menu_list">
	            			<input name="channelId" id="channelId" type="text" value="<if condition='!empty($channel)'>{$channel}<else/>{$T->str_channel}</if>" class="hand" readonly="readonly"/>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="hand js_sel_ul">
	            				<li class="on" title="{$T->str_channel}" val="0" class="js_all_in_one">{$T->str_channel}</li>
	            				<volist name="channList" id="vo">
	            				<li data-link-value=",{$vo['sys_platforms']},"  title="{$vo.channel}" val="{$vo.id}" <php> if(strstr($channel,$vo['channel'])!==false){echo "class='on'";}</php>>{$vo.channel}</li>
	            				</volist>
	            			</ul>
	            		</div>
	            		<div id="select_prd_version" class="select_sketch select_cpbb js_sel_public js_sel_user_prd_version js_select_item js_multi_select menu_list">
	            			<input name="prdVersion" id="prdVersion" type="text" value="<if condition='!empty($prdVersion)'>{$prdVersion}<else/>{$T->str_prd_version}</if>" class="hand active" readonly="readonly"/>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="hand js_sel_ul">
	            				 <li class="on" title="{$T->str_prd_version}" val="0" class="js_all_in_one">{$T->str_prd_version}</li>
            					<volist name="prdVerList" id="vo" class="js_all_in_one">
            						<li data-link-value=",{$vo['sys_platforms']}," title="{$vo.prd_version}" val="{$vo.prd_version}" <php> if(strstr($prdVersion,$vo['prd_version'])!==false){echo "class='on'";}</php> >{$vo.prd_version}</li>
            					</volist>
	            			</ul>
	            		</div>
	            		<div class="select_time_c">
						    <span>{$T->str_time}</span>
							<div class="time_c">
								<input class="time_input" type="text" name="js_begintime" id="js_begintime" value="{$startDate}" readOnly="readOnly"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" type="text"  name="js_endtime" id="js_endtime" value="{$endDate}" readOnly="readOnly"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
						 
				            <input class="submit_button_c js_btn_submit" type="submit" value="{$T->str_btn_submit}"/>
		            	</div>
	            	</div>
	            </div>
	            <div class="select_xinzeng js_sel_public js_sel_user_remain_type margin_top" >
	            	<input type="text" value="" class="hand" id="remainDataType" readonly="readonly"/>
	            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            	<ul class="hand js_sel_ul">
	            		<!-- <li title="{$T->str_label_day_remain_cnt}" val="1">{$T->str_label_day_remain_cnt}</li> --><!--日留存用户量-->
	            		<li title="{$T->str_label_day_remain_lv}" val="2">{$T->str_label_day_remain_lv}</li><!--日留存率-->
	            		<li title="{$T->str_label_total_lose_cnt}" val="3">{$T->str_label_total_lose_cnt}</li><!--累计流失用户量-->
	            		<li title="{$T->str_label_day_lose_cnt}" val="4">{$T->str_label_day_lose_cnt}</li><!--日流水用户量-->
	            		<li title="{$T->str_lebal_day_back_cnt}" val="5">{$T->str_lebal_day_back_cnt}</li><!--日回流用户量-->
	            	</ul>
	            </div>
	            <div class="select_zhouqi js_sel_public js_sel_user_remain_day_num menu_list" >
	            	<input type="text" value="7天" class="hand" id="remainDataType" readonly="readonly"/>
	            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            	<ul class="hand js_sel_ul">
	            		<if condition="$dataType eq '3'">
	            		    <li class="on" title="&gt;=7{$T->str_day_unit}" val="1">>=7{$T->str_day_unit}</li>
	            			<li title=">=14{$T->str_day_unit}" val="2">>=14{$T->str_day_unit}</li>
	            			<li title=">=30{$T->str_day_unit}" val="3">>=30{$T->str_day_unit}</li>
	            		<else/>
	            			<li class="on" title=">=7{$T->str_day_unit}" val="1">小于7{$T->str_day_unit}</li>
	            			<li title=">=7{$T->str_day_unit}" val="2">7~14{$T->str_day_unit}</li>
	            			<li title=">=14{$T->str_day_unit}" val="3">14~30{$T->str_day_unit}</li>
	            			<li title=">=30{$T->str_day_unit}" val="4">大于30{$T->str_day_unit}</li>
	            		</if>

	            	</ul>
	            </div>
	            <div class="select_beizhu js_dayNum_tips">
	            	<span><img src="__PUBLIC__/images/appadmin_icon_beizhu.png" /></span>
	            	<p><if condition="$dataType eq 3">{$T->str_label_lose_define}<elseif condition="$dataType eq 4"/>{$T->str_label_day_lose_define}<elseif condition="$dataType eq 5"/>{$T->str_label_day_back_define}</if></p>
	            </div>
	            <if condition="$dataType lt 0 ">
	            <div class="js_stat_date_type js_stat_type">
					<a class="<if condition='$statType eq "d"'>on</if>" href="javascript:void(0);" value="d">{$T->str_date_day}<!--日--></a>
					<a class="<if condition='$statType eq "w"'>on</if>" href="javascript:void(0);" value="w">{$T->str_date_week}<!--周--></a>
					<a class="<if condition='$statType eq "m"'>on</if>" href="javascript:void(0);" value="m">{$T->str_date_month}<!--月--></a>
				</div>
	            </if>
           	</div>
            <!--
            <div id="userStatisticsBar" style="width:820px;height:500px; margin-bottom:20px;" class=""></div>
            -->
            <div id="userStatisticsLine" style="width:820px;height:500px;block:none;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt"><span class="left_s js_table_title_last"><!--新增设备量数据表 --></span><span class="right_s hand" id="js_remain_export_btn">{$T->str_btn_export}<!--导出--></span></div>
            	<if condition="$dataType lt 3">
            	<div class="Data_c_content js_table_all del_height">
            		<div class="js_data_area" style="height: 900px;"></div>
            	</div>
            	<else/>
            	<div class="Data_c_content js_table_all">
            		<div class="js_data_area" style="height: 400px;"></div>
            	</div>
            	</if>		        
            </div>
        </div>
    </div>
</div>

<script>
<include file="@Layout/js_stat_widget" />
var gStatisticDateType = "{$statType[0]}"; // 全局参数， 根据时间类型控制时间空间可选范围
var getDataUrlIndex = "{:U(CONTROLLER_NAME.'/retained')}"; //刷新页面请求地址
var gTotalLostUserCnt = "{$T->str_label_total_lose_cnt}"; //累计流失用户量
var gTotalActiveUserCnt = "{$T->str_label_total_active_cnt}"; //累计活跃用户量
var gStrTitleDate = "{$T->str_title_date}";/*日期*/
var gStrTitleAppType = "{$T->str_title_app_type}";/*系统平台*/
var gStrChannel = "{$T->str_channel}";/*渠道*/
var gStrSysplatformVersion = "{$T->str_sysplatform_version}";/*系统平台版本*/
var gStrRegUserCnt = "{$T->str_reg_user_cnt}";/*注册用户数*/
var gStrRetainOne = "{$T->str_retain_one}";/*次日留存*/
var gStrRetainTwo = "{$T->str_retain_two}";/*二日留存*/
var gStrRetainThree = "{$T->str_retain_three}";/*三日留存*/
var gStrRetainFour = "{$T->str_retain_four}";/*四日留存*/
var gStrRetainFive = "{$T->str_retain_five}";/*五日留存*/
var gStrRetainSix = "{$T->str_retain_six}";/*六日留存*/
var gStrRetainServen = "{$T->str_retain_serven}";/*七日留存*/
var gStrRetainTen = "{$T->str_retain_ten}";/*十日留存*/
var gStrRetainFourteen = "{$T->str_retain_fourteen}";/*十四日留存*/
var gStrRetainThirty = "{$T->str_retain_thirty}";/*三十日留存*/
var gStrRetainRate = "{$T->str_retain_rate}";/*占比*/
var gStrTotalRegisterUser = "{$T->str_total_register_user}";/*总注册用户*/
var gStrTotalLoseUserServen = "{$T->str_total_lose_user_serven}";/*7日累计流失用户量*/
var gStrTotalLoseUserFourteen = "{$T->str_total_lose_user_fourteen}";/*14日累计流失用户量*/
var gStrTotalLoseUserThirty = "{$T->str_total_lose_user_thirty}";/*30日累计流失用户量*/
var gStrDayLoseUserLessServen = "{$T->str_day_lose_user_less_serven}";/*小于7日流失用户量*/
var gStrDayLoseUserLessFourteen = "{$T->str_day_lose_user_less_fourteen}";/*7~14日流失用户量*/
var gStrDayLoseUserLessThirty = "{$T->str_day_lose_user_less_thirty}";/*15~30日流失用户量*/
var gStrDayLoseUserMoreThirty = "{$T->str_day_lose_user_more_thirty}";/*大于30日流失用户量*/
var gStrDayBackUserLessServen = "{$T->str_day_back_user_less_serven}";/*小于7日回流用户量*/
var gStrDayBackUserLessFourteen = "{$T->str_day_back_user_less_fourteen}";/*7~14日回流用户量*/
var gStrDayBackUserLessThirty = "{$T->str_day_back_user_less_thirty}";/*15~30日回流用户量*/
var gStrDayBackUserMoreThirty = "{$T->str_day_back_user_more_thirty}";/*大于30日回流用户量*/
var max=0;
//生成列表功能行数
$.extend({
	autoGenTable: function(dataSource){
		this.generalTitle = function(){
			var html = '<div class="Data_cjs_data js_head_tr"><span class="span_c_1">'+gStrTitleDate+'</span>'+
                '<span class="span_c_2">'+gStrTitleAppType +'</span>'+
                '<span class="span_c_3">'+gStrChannel+'</span>'+
                '<span class="span_c_4">'+gStrRegUserCnt+'</span>'+
                '<span class="span_c_5">'+((dataType==2)?('<i>'+gStrRetainOne+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainOne)+'</span>'+
                '<span class="span_c_6">'+((dataType==2)?('<i>'+gStrRetainTwo+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainTwo)+'</span>'+
                '<span class="span_c_7">'+((dataType==2)?('<i>'+gStrRetainThree+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainThree)+'</span>'+
                '<span class="span_c_11">'+((dataType==2)?('<i>'+gStrRetainServen+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainServen)+'</span>' +
                '<span class="span_c_7">'+((dataType==2)?('<i>'+gStrRetainTen+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainTen)+'</span>'+
                '<span class="span_c_9">'+((dataType==2)?('<i>'+gStrRetainFourteen+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainFourteen)+'</span>'+
                '<span class="span_c_10">'+((dataType==2)?('<i>'+gStrRetainThirty+'</i><em>('+gStrRetainRate+')</em>'):gStrRetainThirty)+'</span>'+
                '</div>';
			return html;
		}
		this.genaralBody = function(data){
			var html = '';
			$.each(data,function(key,val){
				var noValShow = '--';
				var one 	 = val.one_c == noValShow ? noValShow : '<em>'+val.one_c+'</em><i>('+val.one_c_rate+')</i>';
				var one_tips = val.one_c ==noValShow ? '' : val.one_c+'('+val.one_c_rate+')';
				var two 	 = val.two_c == noValShow ? noValShow : '<em>'+val.two_c+'</em><i>('+val.two_c_rate+')</i>';
				var two_tips = val.two_c ==noValShow ? '' : val.two_c+'('+val.two_c_rate+')';
				var three 	 = val.three_c == noValShow ? noValShow : '<em>'+val.three_c+'</em><i>('+val.three_c_rate+')</i>';
				var three_tips = val.three_c ==noValShow ? '' : val.three_c+'('+val.three_c_rate+')';
				var seven 	= val.seven_c == noValShow ? noValShow : '<em>'+val.seven_c+'</em><i>('+val.seven_c_rate+')</i>';
				var seven_tips = val.seven_c ==noValShow ? '' : val.seven_c+'('+val.seven_c_rate+')';
				var ten 	 = val.ten_c == noValShow ? noValShow : '<em>'+val.ten_c+'</em><i>('+val.ten_c_rate+')</i>';
				var ten_tips = val.ten_c ==noValShow ? '' : val.ten_c+'('+val.ten_c_rate+')';
				var fourteen 	 = val.fourteen_c == noValShow ? noValShow : '<em>'+val.fourteen_c+'</em><i>('+val.fourteen_c_rate+')</i>';
				var fourteen_tips = val.fourteen_c ==noValShow ? '' : val.fourteen_c+'('+val.fourteen_c_rate+')';
				var thirty 	 = val.thirty_c == noValShow ? noValShow : '<em>'+val.thirty_c+'</em><i>('+val.thirty_c_rate+')</i>';
				var thirty_tips = val.thirty_c ==noValShow ? '' : val.thirty_c+'('+val.thirty_c_rate+')';

				 html +='<div class="Data_cjs_data_list" title="'+val.date+'"><span class="span_c_1">'+val.date+'</span>'+
                 '<span class="span_c_2" title="'+val.sys_platform+'">'+val.sys_platform+'</span>'+
                 '<span class="span_c_3" title="'+val.channel+'">'+val.channel+'</span>'+
                 '<span class="span_c_4" title="'+val.reg_cnt+'">'+val.reg_cnt+'</span>'+
                 '<span class="span_c_5" title="'+one_tips+'">'+one+'</span>'+
                 '<span class="span_c_6" title="'+two_tips+'">'+two+'</span>'+
                 '<span class="span_c_7" title="'+three_tips+'">'+three+'</span>'+
                 '<span class="span_c_11" title="'+seven_tips+'">'+seven+'</span>'+
                 '<span class="span_c_8" title="'+ten_tips+'">'+ten+'</span>'+
                 '<span class="span_c_9" title="'+fourteen_tips+'">'+fourteen+'</span>'+
                 '<span class="span_c_10" title="'+thirty_tips+'">'+thirty+'</span>'+
                 '</div>';
			});
			return html;
		}

		var htmlTitle = this.generalTitle();
		var htmlBody = this.genaralBody(dataSource.dataList); //.dataList
			if(htmlBody == ''){
				htmlBody = '<center>No Data</center>';
				$('#js_remain_export_btn').hide();
			}
			$('.js_table_all').find('.js_head_tr').remove().end().prepend(htmlTitle);
			$('.js_data_area').append(htmlBody);
			$('.js_sel_user_remain_day_num,.js_dayNum_tips').hide();
	},
	autoGenTableUserQuantity: function(dataSource){
		this.generalTitle = function(){
			var html = '<div class="Data_cjs_name Data_cjs_5 js_head_tr"><span class="span_c_1" >'+gStrTitleDate+'</span>'+
                '<span class="span_c_2"  >'+gStrTitleAppType+'</span>'+
                '<span class="span_c_3"  >'+gStrChannel+'</span>'+
                '<span class="span_c_4 js_table_title_total_active_user"  >'+gTotalLostUserCnt+'</span>' +
                '<span class="span_c_5 js_table_title_last"  >'+gTotalActiveUserCnt+'</span>' +
                '</div>'
                ;
			return html;
		}
		this.genaralBody = function(data){
			var html = '';
			$.each(data,function(key,val){
				var userCount  = 0;
				 /* if(dayNumHx == 1){
					 userCount = val.seven_c;
				 }else if(dayNumHx == 2){
					 userCount = val.fourteen_c;
				}else if(dayNumHx == 3){
					userCount = val.thirty_c;
				} */
				userCount = val.userCount;
				 html +='<div class="Data_c_list_z Data_cjs_5"><span class="span_c_1"  title="'+val.date+'">'+val.date+'</span>'+
                 '<span class="span_c_2"   title="'+val.sys_platform+'">'+val.sys_platform+'</span>'+
                 '<span class="span_c_3"  title="'+val.channel+'">'+val.channel+'</span>'+
                 //'<span class="span_c_4"  >'+val.prd_version+'</span>'+
                 /* '<span class="span_c_5"  >'+userCount+'</span>'+
                 '<span class="span_c_5"  >'+userCount+'</span>'+
                 '<span class="span_c_5"  >'+userCount+'</span>'+ */
                 '<span class="span_c_4"  title="'+val.active_cnt+'">'+val.active_cnt+'</span>' +
                 '<span class="span_c_5"  title="'+userCount+'">'+userCount+'</span>' +
                 '</div>';
			});
			return html;
		}
		$('#userStatisticsLine').show();
		//console.log('字段少的列表', dataSource.dataList);
		var htmlTitle = this.generalTitle();
		var htmlBody = this.genaralBody(dataSource.dataList);
			if(htmlBody == ''){
				htmlBody = '<center>No Data</center>';
				$('#js_remain_export_btn').hide();
			}
			$('.js_table_all').find('.js_head_tr').remove().end().prepend(htmlTitle);
			$('.js_data_area').append(htmlBody);

	},
	autoGenTableUserSix: function(dataSource){
		this.generalTitle = function(){
			var html = '<div class="Data_cjs_name Data_cjs_6 js_head_tr"><span class="span_c_1" >'+gStrTitleDate+'</span>'+
                '<span class="span_c_2"  >'+gStrTitleAppType+'</span>'+
                '<span class="span_c_3"  >'+gStrChannel+'</span>'+
                '<span class="span_c_4"  >'+'产品版本'+'</span>'+
                '<span class="span_c_5 js_table_title_lose_back_user"  >'+gTotalLostUserCnt+'</span>' +
                '<span class="span_c_6 js_table_title_last"  >'+gTotalActiveUserCnt+'</span>' +
                '</div>'
                ;
			return html;
		}
		this.genaralBody = function(data){
			var html = '';
			$.each(data,function(key,val){
				var userCount1 = userCount2  = 0;
				 if(dayNumHx == 1){
					 userCount2 = val.seven_c;
				 }else if(dayNumHx == 2){
					 userCount2 = val.fourteen_c;
				}else if(dayNumHx == 3){
					userCount2 = val.thirty_c;
				}else{
					userCount2 = val.gt_thirty_c;
				}

				if(dataType == 5){
					 if(dayNumHx == 1){
						 userCount1 = val.lt_7;
					 }else if(dayNumHx == 2){
						 userCount1 = val.ge_7_le_14;
					}else if(dayNumHx == 3){
						userCount1 = val.gt_14_le_30;
					}else{
						userCount1 = val.gt_30;
					}
				}else{
					userCount1 = val.active_cnt;
				}	
				 html +='<div class="Data_c_list_z Data_cjs_6"><span class="span_c_1"  title="'+val.date+'">'+val.date+'</span>'+
                 '<span class="span_c_2"   title="'+val.sys_platform+'">'+val.sys_platform+'</span>'+
                 '<span class="span_c_3"  title="'+val.channel+'">'+val.channel+'</span>'+
                 '<span class="span_c_4"  title='+val.prd_version+' >'+val.prd_version+'</span>'+
                 /* '<span class="span_c_5"  >'+userCount+'</span>'+
                 '<span class="span_c_5"  >'+userCount+'</span>'+
                 '<span class="span_c_5"  >'+userCount+'</span>'+ */
                 '<span class="span_c_5"  title="'+userCount1+'">'+userCount1+'</span>' +
                 '<span class="span_c_6"  title="'+userCount2+'">'+userCount2+'</span>' +
                 '</div>';
			});
			return html;
		}
		$('#userStatisticsLine').show();
		//console.log('字段少的列表', dataSource.dataList);
		var htmlTitle = this.generalTitle();
		var htmlBody = this.genaralBody(dataSource.dataList);
			if(htmlBody == ''){
				htmlBody = '<center>No Data</center>';
				$('#js_remain_export_btn').hide();
			}
			$('.js_table_all').find('.js_head_tr').remove().end().prepend(htmlTitle);
			$('.js_data_area').append(htmlBody);

	}
});


var gChartData = {:json_encode($chartSet['dataList'])};//用来生成列表的数据源

//请求变量回显使用
var dataType = "{$dataType}"; //下拉框中的数据类型
var sysPlatformHx = "{$sysPlatform}"; //系统平台
var channelHx = "{$channel}"; //频道
var dayNumHx  = "{$dayNum}"; //7、14、30
var prdVersionHx = "{$prdVersion}"; //产品版本
    dataType = parseInt(dataType);
var startDate = "{$startDate}"; //开始日期
var endDate   = "{$endDate}"; //结束日期
var statTypeHx = "{$statType}"; //日周月
var gJsChartDataSource = {:json_encode($chartSet)}; //用来生成折线图的数据源
/* if(dataType == 1 || dataType == 2){
	$('.js_btn_duibi').hide();
} */
//var duibi     = "$duibi";
//console && console.log('test',gJsChartDataSource)
/* if(duibi == 1){
	$('.time_duibi').show();
} */
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
//console && console.log('test liucun',gJsChartDataSource.chartData);
if(dataType >= 3){
	var gJsChartData = lineNames = [];
	//console.log('test', gJsChartDataSource.chartData)
	$.each(gJsChartDataSource.chartData,function(key,val){
		var name = $('.js_sel_user_remain_type').find('li[val="'+key+'"]').html();
		 $.each(val,function(j,num){
			    num = parseInt(num);
				if(num > max){
					max = num;
				}
		 });
		lineNames.push(name);
		//$.each(val,function(k,v){
			var obj = {
		            name: name,
		            type:'line',
		            //stack: '总量',
		            itemStyle : { normal: {color:colorList[0]}}, // 折线颜色
		            data: val //[120, 132, 101, 134, 90, 230, 210]
		       	 };
			gJsChartData.push(obj);
		//});
	});

	if(typeof(gJsChartDataSource.chartData2) != 'undefined'){
		$.each(gJsChartDataSource.chartData2,function(key,val){
			var name = $('.js_sel_user_remain_type').find('li[val="'+key+'"]').html();
			$.each(val,function(k,v){
				var obj = {
			            name: name+k,
			            type:'line',
			            //stack: '总量',
			           // itemStyle : { normal: {color:'#999'}}, // 折线颜色
			            data: v //[120, 132, 101, 134, 90, 230, 210]
			       	 };
				gJsChartData.push(obj);
			});
		});
	}

	var rst=paramsForGrid(max);
	// 指定图表的配置项和数据
	var echartOptionLine =  {
	        title: {
	            text: '留存分析',
	            textStyle : { color:'#333',fontSize:14,fontWeight:100}
	        },
		    tooltip : {
		        trigger: 'axis'
		    },
		    legend: {
	        	left: 'center',
	        	bottom: '0',
	        	selectedMode:true,
	            data: lineNames
		    },
		    grid: {
		        left: '3%',
		        right: '4%',
		        bottom: '7%',
		        containLabel: true
		    },
		    xAxis : [
		        {
		            type : 'category',
		            boundaryGap : false,
		            data : gJsChartDataSource.xTitle,//['周一','周二','周三','周四','周五','周六','周日'],
		            axisLabel : {
			            textStyle : {
				            color : '#999'
			            }
		            },
		            axisLine: {
		                lineStyle: {
		                    // 使用深浅的间隔色
		                    color: '#999',
		                    width: 1
		                }
		            },
		            splitLine: {
		            	show:true,
		                lineStyle: {
		                    // 使用深浅的间隔色
		                    color: ['#ddd'],
		                    type : 'dashed'
		                }
		            }
		        }
		    ],
		    yAxis : [
		        {
		            type : 'value',
	                max : rst.max,
	                splitNumber: rst.splitNumber,
	                interval: rst.interval,
		            splitLine: {
		            	show:true,
		                lineStyle: {
		                    // 使用深浅的间隔色
		                    color: ['#ddd'],
		                    type : 'dashed'
		                }
		            }
		        }
		    ],
		    series : gJsChartData,
		    //backgroundColor: '#000' // 设置图表背景颜色
		};
	//var echartOption = ;
	var gEchartSettings = [
	                       {containerId: 'userStatisticsLine', option : echartOptionLine},
	                      ];

	if(dataType>=4){
		$('.js_sel_user_prd_version').find('input:eq(0)').removeClass('active');
	}else{
		$('.js_sel_user_prd_version').removeClass('js_sel_user_prd_version js_sel_public');
	}
}else{
	$('.js_sel_user_prd_version').hide(); //隐藏产品版本
}
         /**
 		  * 获取请求参数
          */
        function getRemainParam(opts){
       		 typeof(opts) == 'undefined' ? opts= {} : null;
	   		var sysPlatformId = $('#sysPlatformId').val();
	   		var channelId 	  = $('#channelId').val();
	   		var activeTypeId  = $('#activeTypeId').val();
	   		var js_begintime  = $('#js_begintime').val();
	   		var js_endtime    = $('#js_endtime').val();
	   		var dayNum 	  =  $('#dayNum').val();
	   		var prdVersion  = $('#prdVersion').val();
	   		var statType = $('.js_stat_type').find('a').filter('.on').attr('value'); //日周月
       		if(typeof(opts.clickSource) != 'undefined' && opts.clickSource == 1){
       			js_begintime = js_endtime = '';
	       	}else{
	       		if(js_begintime == ''){
	       			$.global_msg.init({gType:'warning',icon:2,msg:'开始日期不能为空'});
	       			return false;
	       		}
	       		if(js_endtime == ''){
	       			$.global_msg.init({gType:'warning',icon:2,msg:'结束日期不能为空'});
	       			return false;
	       		}
		    }

	   		var data = {
	   				appType: sysPlatformId,
	   				channel: channelId,
	   				startDate: js_begintime,
	   				endDate: js_endtime,
	   				dataType: activeTypeId,
	   				dayNum: dayNum,
	   				statType: statType,
	   				prdVersion: prdVersion
	    	   		};
	   		typeof(opts) == 'undefined' ? opts= {} : null;
	   		$.extend(data,opts);
	   		/* if($('.time_duibi').is(":visible")){
	     		var js_begintime_duibi = $('#js_begintime1').val();
	       		var js_endtime_duibi = $('#js_endtime1').val();
	       		var tmpData  = {duibi:1,startDateCompare:js_begintime_duibi,endDateCompare:js_endtime_duibi};
	       		$.extend(data,tmpData);
	   		} */
	   		//去除空属性操作
	   		var tmp = {};
	   		for(var i in data){
				if(data[i]){
					tmp[i] = data[i];
				}
		   	}
	   		return tmp;
        }

       $(function(){
           //下拉框插件
    	 //  $('.js_sel_user_app').selectPlug({getValId:'sysPlatformId',defaultVal: sysPlatformHx});
    	   //$('.js_sel_user_channel').selectPlug({getValId:'channelId',defaultVal:channelHx}); //渠道
    	   //$('.js_sel_user_prd_version').selectPlug({getValId:'prdVersion',defaultVal: prdVersionHx}); //产品版本
    	   $('.js_sel_user_remain_type').selectPlug({getValId:'activeTypeId',defaultVal:dataType}); //留存类型
    	   $('.js_sel_user_remain_day_num').selectPlug({getValId:'dayNum',defaultVal:dayNumHx}); //7、14、30

      	   //调用列表函数
    	   $('#userStatisticsLine').hide();
    	   if(dataType == 3){
    		   $.autoGenTableUserQuantity({dataList: gChartData});
    		   $('.js_table_title_total_active_user').html('{$T->str_label_total_active_cnt}')
            }else if(dataType == 4 || dataType == 5){
				$.autoGenTableUserSix({dataList: gChartData});
				var tblTitle = dataType == 4 ? '{$T->str_lebal_day_active_cnt}':'{$T->str_label_day_lose_cnt}';
				$('.js_table_title_lose_back_user').html(tblTitle)
            }else{
          	  $.autoGenTable({dataList: gChartData});
            }

    	   //点击对比时间段按钮
    	    $('.js_btn_submit').click(function(){
    		   	ajaxRequestData();
    	    }); 

    	   //点击日周月标签
    	    $('.js_stat_type').on('click','a',function(){
        	    var statType = $(this).attr('value');
    	    	ajaxRequestData({statType:statType,'clickSource':1});
        	 });

      	 	//导出数据
    	   $('#js_remain_export_btn').click(function(){
    		   var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate, dayNum:dayNumHx,statType:statTypeHx };
    		    var data = getRemainParam(opts);
	    	   	var url = getDataUrlIndex.replace('.html','');//'../Index/exportCards';//urlExport;
	    	   	var dataType = 'activeUserCount';
	    	   	var date = new Date();
	    	   	var params = {'time':date.getTime(),'downloadStat':1};
	    	   	$.extend(params,data);
	    	   	exportFn(url,params);
    	   });

			//数据类型列表值改变后触发
    	   $('.js_sel_user_remain_type').on('click','li',function(){
    		   var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate,dayNum:'',statType:statTypeHx };//dayNum:dayNumHx,
		   		var data = getRemainParam(opts);
   				getDataUrlIndex = getDataUrlIndex.replace('.html','');
   				window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
        	 });
        	 // 7天、14天、30天点击切换
    	   $('.js_sel_user_remain_day_num').on('click','li',function(){
    		   var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate, dataType:dataType,statType:statTypeHx };
		   		var data = getRemainParam(opts);
   				getDataUrlIndex = getDataUrlIndex.replace('.html','');
   				window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
        	 });
        	 
	    	//请求对比时间段数据
/* 	    	$('.js_btn_duibi_submit').click(function(){
	     		var js_begintime_duibi = $('#js_begintime1').val();
	       		var js_endtime_duibi = $('#js_endtime1').val();
	       		var opts  = {duibi:1,startDateCompare:js_begintime_duibi,endDateCompare:js_endtime_duibi};
	    		ajaxRequestData(opts);
	    	}); */
	       	 //给列表添加滚动条
			var scrollObj = $('.js_data_area');
	    	if(!scrollObj.hasClass('mCustomScrollbar')){
	    		scrollObj.mCustomScrollbar({
			        theme:"dark", //主题颜色
			        autoHideScrollbar: false, //是否自动隐藏滚动条
			        scrollInertia :0,//滚动延迟
			        horizontalScroll : false,//水平滚动条
			    });
	    	}

	    	//修改列表的表头值(最后一个)
	    	var tableTitle = $('.js_sel_user_remain_type').find('li[val="'+dataType+'"]').html();
	    	$('.js_table_title_last').html(tableTitle);
        });
</script>
