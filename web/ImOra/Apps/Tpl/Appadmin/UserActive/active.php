<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	  <!-- 条件搜索 start -->
        	  <div class="content_search_all">
        	  <div class="content_search">
            	<div class="search_right_c">
            		<div id="select_platform" class="select_sketch menu_list select_IOS js_sel_public js_sel_user_app js_select_item">
            			<input type="text"  name="sysPlatformId" id="sysPlatformId" value="<if condition='!empty($sysPlatform)'>{$sysPlatform}<else/>{$T->str_title_app_type}</if>" readonly="readonly" class="hand"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            			<li class="on" title="{$T->stat_sys_platform}" val="{$T->stat_sys_platform}"  class="hand">{$T->stat_sys_platform}</li>
            			<volist name="appTypeSet" id="vo">
            				<li title="{$vo}" val="{$key}"  <if condition="$sysPlatform eq $vo"> class='on'</if>>{$vo}</li>
            			</volist>
            			</ul>
            		</div>
            		
            		<!-- 国家省份 start-->
            		 <div id="select_country" class="select_sketch select_IOS menu_list js_select_item js_multi_select">
            			<input name="countryId" id="countryId" type="text" value="<if condition='!empty($country)'>{$country}<else/>{$T->str_country}</if>" name='country' readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			    <li class="on" val="" title="{$T->str_country}" class="js_all_in_one">{$T->str_country}</li>
            			    <foreach name='countrys' item='countr'>
            				<li  val="<php>echo $countr['country'];</php>" title="<php>echo $countr['country'];</php>" <php> if(strstr($country,$countr['country'])!==false){echo "class='on'";}</php> ><php> echo $countr['country'];</php> </li>
            		    	</foreach>
            			</ul>
            		</div>
            		<div id="select_province" class="select_sketch js_select_item  js_multi_select menu_list">
            			<input name="provinceId" id="provinceId"  type="text" name="province" value="<if condition='!empty($province)'>{$province}<else/>{$T->str_province}</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			<li class="on" val='' title='{$T->str_province}' class='js_all_in_one'>{$T->str_province}</li>
            			<foreach name='provinces' item='provinc'>
            				<li data-link-value=",{$provinc['countrys']},"  val="<php>echo $provinc['province'];</php>" title="<php>echo $provinc['province'];</php>" <php> if(strstr($province,$provinc['province'])!==false){echo "class='on'";}</php> ><php>echo $provinc['province'];</php> </li>
            		    </foreach>
            			</ul>
            		</div>
            		<!-- 国家省份end -->
            		
            		<div  id="select_channel" class="select_sketch js_sel_public js_sel_user_channel js_select_item js_multi_select menu_list">
            			<input name="channelId" id="channelId" type="text" value="<if condition='!empty($channel)'>{$channel}<else/>{$T->str_channel}</if>" readonly="readonly"  class="hand"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            				<li class="on" title="{$T->str_channel}" val="0" class="js_all_in_one">{$T->str_channel}</li>
            				<volist name="channList" id="vo">
            				<li title="{$vo.channel}" val="{$vo.channel}"  data-link-value=",{$vo['sys_platforms']},"  <php> if(strstr($channel,$vo['channel'])!==false){echo "class='on'";}</php>>{$vo.channel}</li>
            				</volist>
            			</ul>
            		</div>
            		<!-- 产品版本 -->
            		 <div id="select_prd_version" class="select_sketch js_sel_public js_sel_user_prd_version js_select_item js_multi_select menu_list">
            			<input name="prdVersion" id="prdVersion" type="text" value="<if condition='!empty($prdVersion)'>{$prdVersion}<else/>{$T->str_prd_version}</if>" readonly="readonly"  class="hand"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            				<li class="on" title="{$T->str_prd_version}" val="0" class="js_all_in_one">{$T->str_prd_version}</li>
            				<volist name="prdVerList" id="vo">
            				<li data-link-value=",{$vo['sys_platforms']}," title="{$vo.prd_version}" val="{$vo.prd_version}"  <php> if(strstr($prdVersion,$vo['prd_version'])!==false){echo "class='on'";}</php>>{$vo.prd_version}</li>
            				</volist>
            			</ul>
            		</div>
					<!--对比时段-->
            		<div class="select_time_c">
					    <span>{$T->str_time}</span>
						<div class="time_c">
							<input class="time_input hand" type="text" name="js_begintime" id="js_begintime" value="{$startDate}" readOnly="readOnly"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input class="time_input hand" type="text" name="js_endtime" id="js_endtime" value="{$endDate}" readOnly="readOnly"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						
			            <input class="submit_button_c js_btn_submit" type="submit" value="{$T->str_btn_submit}"/>
	            	</div>
            	</div>
            </div>
            <!-- 条件搜索 end -->
            <div class="js_stat_date_type js_stat_type">
				<a class="<if condition='$statType eq "d"'>on</if>" href="javascript:void(0);" value="d">{$T->str_date_day}</a><!--日-->
				<a class="<if condition='$statType eq "w"'>on</if>" href="javascript:void(0);" value="w">{$T->str_date_week}</a><!--周-->
				<a class="<if condition='$statType eq "m"'>on</if>" href="javascript:void(0);" value="m">{$T->str_date_month}</a><!--月-->
			</div>
              <div class="select_xinzeng js_sel_public js_sel_user_active_type margin_top menu_list">
            	<input type="text" value="{$T->str_active_user_cnt}" readonly="readonly"  class="hand"/>
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul class="hand">
            		<li class="on" title="{$T->str_active_user_cnt}" val="1"  class="hand">{$T->str_active_user_cnt}</li><!--活跃用户量-->
            		<li title="{$T->str_day_active_rate}" val="5" add="%"  class="hand">{$T->str_day_active_rate}</li><!--日活跃占比-->
            		<li title="{$T->str_week_active_rate}" val="6" add="%"  class="hand">{$T->str_week_active_rate}</li><!--周活跃占比-->
            		<li title="{$T->str_person_avg_online_time}" val="2"  class="hand">{$T->str_person_avg_online_time}</li><!--人均在线时长-->
            		<li title="{$T->str_single_login_online_time}" val="3"  class="hand">{$T->str_single_login_online_time}</li><!--单次登陆平均在线时长-->
            		<li title="{$T->str_person_login_cnt}" val="4"  class="hand">{$T->str_person_login_cnt}</li> <!--人均登陆次数-->
            	</ul>
            </div>
             <div class="select_xinzeng js_sel_public js_sel_user_acitve_new_user margin_top menu_list" style="display:none;">
            	<input type="text" value="{$T->str_label_all}" class="hand" id="remainDataType" readonly="readonly"/>
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul class="hand js_sel_ul">
            		<li class="on" title="{$T->str_label_all}" val="">{$T->str_label_all}</li> <!--全部-->
            		<li title="{$T->str_new_user}" val="1">{$T->str_new_user}</li> <!--新用户-->
            		<li title="{$T->str_new_old}" val="0">{$T->str_new_old}</li> <!--老用户-->
            	</ul>
            </div>
            </div>
            <!-- 折线图 start -->
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <!-- 折线图 end -->
            <!-- 数据列表 start -->
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top"><span class="left_s js_table_title_last"><!-- 新增设备量数据表 --></span>
            	<if condition="count($dataSet) gt 0">
            	<span class="right_s js_active_export_btn">{$T->str_btn_export}<!--导出--></span>
            	</if>
            	</div>
            	<div class="Data_c_content js_active_anyi">
            		<!-- 日活跃占比 -->
            		<if condition="$dataType == '5'">
            		  <div class="Data_cjs_name js_data_title Data_cjs_6">
		                  <span class="span_c_1">{$T->str_title_date}<!--日期--></span>
		                  <span class="span_c_2">{$T->str_title_app_type}<!--系统平台--></span>
		                  <span class="span_c_3">{$T->str_channel}<!--渠道--></span>
		                  <span class="span_c_4">{$T->str_prd_version}<!--产品版本--></span>
		                  <span class="span_c_5 ">{$T->str_day_active_rate_week}</span>
		                  <span class="span_c_5 ">{$T->str_day_active_rate_month}</span>
	                   </div>
	                   <div class="js_scroll_data">
			            <if condition="count($dataSet) gt 0">
					            <php>$index = 1;</php>
					           <volist name="dataSet" id="_userStat">
					                <div class="Data_c_list_z js_data_body Data_cjs_6">
					                  <span class="span_c_1" index="{$index}" title="{$_userStat.date}">{$_userStat.date}</span>
					                  <span class="span_c_2" title="{$_userStat.sys_platform}">{$_userStat.sys_platform}</span>
					                  <span class="span_c_3" title="{$_userStat.channel}">{$_userStat.channel}</span>
					                  <span class="span_c_4" title="{$_userStat.prd_version}">{$_userStat.prd_version}</span>
					                  <span class="span_c_5" title="{$_userStat.count}">{$_userStat.count}</span>
					                  <span class="span_c_5" title="{$_userStat.count_30}">{$_userStat.count_30}</span>
					                </div>
					                 <php>$index++;</php>
					          </volist>
				      	 <else/>
				              <center>No Data</center>
				        </if>
				        </div>
            		<else/>
            			<!-- 其他如  活跃用户量、周活跃占比、人均在线时长、单次登陆平均在线时长、人均登陆次数 -->
            		   <div class="Data_cjs_name js_data_title Data_cjs_5">
		                  <span class="span_c_1">{$T->str_title_date}<!--日期--></span>
		                  <span class="span_c_2">{$T->str_title_app_type}<!--系统平台--></span>
		                  <span class="span_c_3">{$T->str_channel}<!--渠道--></span>
		                  <span class="span_c_4">{$T->str_prd_version}<!--产品版本--></span>
		                  <span class="span_c_5 js_table_title_last">{$T->str_active_user_cnt}</span>
	                   </div>
	                   <div class="js_scroll_data">
			            <if condition="count($dataSet) gt 0">
					            <php>$index = 1;</php>
					           <volist name="dataSet" id="_userStat">
					                <div class="Data_c_list_z js_data_body Data_cjs_5">
					                  <span class="span_c_1" index="{$index}" title="{$_userStat.date}">{$_userStat.date}</span>
					                  <span class="span_c_2" title="{$_userStat.sys_platform}">{$_userStat.sys_platform}</span>
					                  <span class="span_c_3" title="{$_userStat.channel}">{$_userStat.channel}</span>
					                  <span class="span_c_4" title="{$_userStat.prd_version}">{$_userStat.prd_version}</span>
					                  <span class="span_c_5" title="{$_userStat.count}">{$_userStat.count}</span>
					                </div>
					                 <php>$index++;</php>
					          </volist>
				      	 <else/>
				              <center>No Data</center>
				        </if>
				       </div>
            		</if>
					
		         </div>
            </div>
        	<!-- 数据列表end -->
        </div>
    </div>
</div>
<script>
<include file="@Layout/js_stat_widget" />
var gStatisticDateType = "{$statType[0]}"; // 全局参数， 根据时间类型控制时间空间可选范围
var getDataUrlIndex =  "{:U(CONTROLLER_NAME.'/active')}";
var chartDataSet 	= {:json_encode($chartSet)}; //折线图的数据源
var xTitle 			= chartDataSet.xTitle; //x坐标轴
var gJsChartDataSource = chartDataSet.chartData; //折线数据集合
var titleList    	= chartDataSet.chartTitle;

//请求变量回显使用
var dataType = "{$dataType}"; //数据源类型
var sysPlatformHx = "{$sysPlatform}"; //系统平台
var channelHx = "{$channel}"; //频道
var prdVersionHx = "{$prdVersion}"; //产品版本
var startDate = "{$startDate}"; //开始日期
var endDate   = "{$endDate}"; //结束日期
var isNewUser  = "{$isNewUser}"; //新老用户
var statTypeHx = "{$statType}"; //日周月
var max=0;
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
if(dataType>=5){
	$('.js_stat_type').hide();
}
var gJsChartData = lineNames = [];
	$.each(gJsChartDataSource,function(lineName,val){
	    var gLine1 = '';
	    var gSelObjTmp1 = $('.js_sel_user_active_type').find('li[val="'+lineName+'"]');
	    gLine1 = gSelObjTmp1.html();
	    if(typeof(gSelObjTmp1.attr('add')) != 'undefined'){
	    	gLine1 += '('+gSelObjTmp1.attr('add')+')';
	    }
	    $.each(val,function(j,num){
		    	num = parseInt(num);
				if(num > max){
					max = num;
				}
		 });
		 if(dataType == '5'){
			 gLine1 += '('+'周'+')';
		  }
		 lineNames.push(gLine1);
		var obj = {
	            name: gLine1,
	            type:'line',
	          //  stack: '总量',
	            itemStyle : {normal: {color:colorList[0]} }, // 折线颜色 '#999'
	            data:val //[120, 132, 101, 134, 90, 230, 210]
	       	 };
		gJsChartData.push(obj);
	});

	if(typeof(chartDataSet.chartData2) != 'undefined'){
		$.each(chartDataSet.chartData2,function(lineName,val){
		    var gLine2 = '';
		    var gSelObjTmp2 = $('.js_sel_user_active_type').find('li[val="'+lineName+'"]');
		    gLine2 = gSelObjTmp2.html();
		    if(typeof(gSelObjTmp2.attr('add')) != 'undefined'){
		    	gLine2 += '('+gSelObjTmp2.attr('add')+')';
		    }
		    $.each(val,function(j,num){
		    	num = parseInt(num);
				if(num > max){
					max = num;
				}
			 });
			 if(dataType == '5'){
				 gLine2 += '('+'月'+')';
			  }
			 lineNames.push(gLine2);
			var obj = {
		            name: gLine2,
		            type:'line',
		          //  stack: '总量',
		            itemStyle : { normal: {color:colorList[1]}}, // 折线颜色
		            data:val //[120, 132, 101, 134, 90, 230, 210]
		       	 };
			gJsChartData.push(obj);
		});
	}
var rst=paramsForGrid(max);
// 指定图表的配置项和数据
var echartOptionLine =  {
        title: {
            text: '活跃分析',
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
	        left: '1%',
	        right: '3%',
	        bottom: '7%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
	            data : xTitle,//['周一','周二','周三','周四','周五','周六','周日'],
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
	    series : gJsChartData
	    //backgroundColor: '#000' // 设置图表背景颜色
	};

var gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];
//显示是否新用户的下拉框
if(dataType == '1' || dataType == '2' || dataType == '3' || dataType == '4'){ // || dataType == '4'
	$('.js_sel_user_acitve_new_user').show();
}
		/**
		 * 获取请求参数
		*/
		function getRemainParam(opts){
			    typeof(opts) == 'undefined' ? opts= {} : null;
	     		var sysPlatformId = $('#sysPlatformId').val();
	       		var channelId 	  = $('#channelId').val();
	       		var activeTypeId  = $('#activeTypeId').val();
	       		var js_begintime = $('#js_begintime').val();
	       		var js_endtime = $('#js_endtime').val();
	       		var isNewUser	= $('#isNewUser').val();
	       		var prdVersion  = $('#prdVersion').val();
	       		var countryId   = $('#countryId').val();
	       		var provinceId  = $('#provinceId').val();
	       		var statTypeArr = ['d','w','m'];
	       		var statType    = statTypeArr[$('.js_stat_type').find('a.on').index()];
	       		//channelId = channelId.replace(/\//g,',');
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
						isNewUser: isNewUser,
						prdVersion: prdVersion,
						statType: statType,
						countryId: countryId,
						provinceId: provinceId
			   		};
		   		$.extend(data,opts);

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
           //给所有的input加上title提示
           $($('input[type="text"]')).each(function(i,dom){
        	   var obj = $(dom);
        	   obj.attr('title',obj.val());
               obj.on('change',function(){
      				obj.attr('title',obj.val());
                 });
             });

           //下拉框插件
    	   //$('.js_sel_user_app').selectPlug({getValId:'sysPlatformId',defaultVal:sysPlatformHx}); //系统平台
    	  // $('.js_sel_user_channel').selectPlug({getValId:'channelId',defaultVal:channelHx}); //渠道
    	   //$('.js_sel_user_prd_version').selectPlug({getValId:'prdVersion',defaultVal: prdVersionHx}); //产品版本
    	   $('.js_sel_user_active_type').selectPlug({getValId:'activeTypeId',defaultVal: dataType}); //活跃性类型
    	   $('.js_sel_user_acitve_new_user').selectPlug({getValId:'isNewUser',defaultVal: isNewUser}); //新老用户

			//对比时段按钮
           $('.js_btn_submit').click(function(){
        	  	 ajaxRequestData();
              });

			//数据类型列表值改变后触发
    	   $('.js_sel_user_active_type').on('click','li',function(){
    		   		var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate, isNewUser:'',statType:statTypeHx };
    		   		var data = getRemainParam(opts);//{dataType: activeTypeId};
	   				getDataUrlIndex = getDataUrlIndex.replace('.html','');
	   				window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
        	 });

    	   //是否新用户点击触发
    	   $('.js_sel_user_acitve_new_user').on('click','li',function(){
		   		var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate, dataType:dataType,statType:statTypeHx };
		   		var data = getRemainParam(opts);//{dataType: activeTypeId};
 				getDataUrlIndex = getDataUrlIndex.replace('.html','');
 				window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
  	 		});

      	   //点击日周月标签
      	    $('.js_stat_type').on('click','a',function(){
          	    var statType = $(this).attr('value');
      	    	ajaxRequestData({statType:statType,'clickSource':1});
          	 });

        	 //给列表添加滚动条
	    	$.pageInfo.scrollData();

	    	//导出数据
	    	$('.js_active_export_btn').click(function(){
		    	var opts = {appType:sysPlatformHx, channel:channelHx, prdVersion:prdVersionHx, startDate:startDate, endDate:endDate, isNewUser:isNewUser,statType:statTypeHx };
	    		var dataParam = getRemainParam(opts);
	    		var url = getDataUrlIndex.replace('.html','');//'../Index/exportCards';//urlExport;
	    		var dataType = 'activeUserCount';
	    		var date = new Date();
	    		var params = {'time':date.getTime(),'downloadStat':1};
	    		$.extend(params,dataParam);
	    		exportFn(url,params);
	    	});

	    	//修改列表的表头值(最后一个)
	    	var tableTitle = $('.js_sel_user_active_type').find('li[val="'+dataType+'"]').html();
	    	$('.js_table_title_last').html(tableTitle);

        });

</script>
