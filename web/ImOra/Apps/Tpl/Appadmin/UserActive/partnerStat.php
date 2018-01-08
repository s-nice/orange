<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	  <!-- 条件搜索 start -->
        	  <div class="content_search_all">
        	  <div class="content_search">
            	<div class="search_right_c">            		
					<!--对比时段-->
            		<div class="select_time_c">
					    <span>{$T->str_time}</span>
					    <if condition="$dataType eq '2'"></if>
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
            	<if condition="$dataType eq '2'">
				<a class="<if condition='$statType eq "d"'>on</if>" href="javascript:void(0);" value="d">{$T->str_date_day}</a><!--日-->
				<a class="<if condition='$statType eq "w"'>on</if>" href="javascript:void(0);" value="w">{$T->str_date_week}</a><!--周-->
				<a class="<if condition='$statType eq "m"'>on</if>" href="javascript:void(0);" value="m">{$T->str_date_month}</a><!--月-->
				</if>
			</div>
              <div class="select_xinzeng js_sel_public js_sel_user_active_type margin_top">
            	<input type="text" value="{$T->str_active_user_cnt}" readonly="readonly"  class="hand"/>
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul class="hand">
            		<li title="{$T->str_grand_total_partner_number}" val="1"  class="hand">{$T->str_grand_total_partner_number}</li><!--累计合作商数量-->
            		<li title="{$T->str_new_incre_partner_number}" val="2"   class="hand">{$T->str_new_incre_partner_number}</li><!--新增合作商数量 add="%"-->
            	</ul>
            </div>
             <div class="select_xinzeng js_sel_public js_sel_user_acitve_new_user margin_top" style="display:block;">
            	<input type="text" value="{$T->str_label_all}" class="hand" id="entType" name="entType" readonly="readonly"/>
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul class="hand js_sel_ul">
            		<li title="{$T->str_label_all}" val="3">{$T->str_label_all}</li> <!--全部-->
            		<li title="{$T->offcialpartner_public_place}" val="2">{$T->offcialpartner_public_place}</li> <!--公共场所-->
            		<li title="{$T->str_partner}" val="1">{$T->str_partner}</li> <!--企业-->
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
            		<!-- 累计合作商数量 -->
            		<if condition="$dataType == '1'">
            		  <div class="Data_cjs_name js_data_title Data_cjs_num1">
		                  <span class="span_c_1">{$T->str_title_date}<!--日期--></span>
		                  <span class="span_c_5">{$T->str_grand_total_partner_number}<!--系统平台--></span>
	                   </div>
	                   <div class="js_scroll_data">
			            <if condition="count($dataSet) gt 0">
					            <php>$index = 1;</php>
					           <volist name="dataSet" id="_userStat">
					                <div class="Data_c_list_z js_data_body Data_cjs_num1">
					                  <span class="span_c_1" index="{$index}">{$_userStat.date}</span>
					                  <span class="span_c_5">{$_userStat.count}</span>
					                </div>
					                 <php>$index++;</php>
					          </volist>
				      	 <else/>
				              <center>No Data</center>
				        </if>
				        </div>
            		<else/>
            			<!-- -->
            		   <div class="Data_cjs_name js_data_title Data_cjs_num2">
		                  <span class="span_c_1">{$T->str_title_date}<!--日期--></span>
		                  <span class="span_c_5 js_table_title_last">{$T->str_active_user_cnt}</span>
	                   </div>
	                   <div class="js_scroll_data">
			            <if condition="count($dataSet) gt 0">
					            <php>$index = 1;</php>
					           <volist name="dataSet" id="_userStat">
					                <div class="Data_c_list_z js_data_body Data_cjs_num2">
					                  <span class="span_c_1" index="{$index}">{$_userStat.date}</span>
					                  <span class="span_c_5">{$_userStat.count}</span>
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
var getDataUrlIndex =  "{:U(CONTROLLER_NAME.'/partnerStat')}";
var chartDataSet 	= {:json_encode($chartSet)}; //折线图的数据源
var xTitle 			= chartDataSet.xTitle; //x坐标轴
var gJsChartDataSource = chartDataSet.chartData; //折线数据集合
var titleList    	= chartDataSet.chartTitle;

//请求变量回显使用
var dataType = "{$dataType}"; //数据源类型
var entTypeHx = "{$entType}"; //企业类型
var statTypeHx = "{$statType}"; //日周月
var startDate = "{$startDate}";
var endDate = "{$endDate}";
var max=0;
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
var tableTitle = $('.js_sel_user_active_type').find('li[val="'+dataType+'"]').html();

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
            text: tableTitle,
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

		/**
		 * 获取请求参数
		*/
		function getRemainParam(opts){
			    typeof(opts) == 'undefined' ? opts= {} : null;
	     		var entType = $('#entTypeVal').val();
	       		var activeTypeId  = $('#activeTypeId').val();
	       		var js_begintime = $('#js_begintime').val();
	       		var js_endtime = $('#js_endtime').val();
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
						entType: entType,
						startDate: js_begintime,
						endDate: js_endtime,
						dataType: activeTypeId,
						statType: statType
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
    	   $('.js_sel_user_active_type').selectPlug({getValId:'activeTypeId',defaultVal: dataType}); //活跃性类型
    	   $('.js_sel_user_acitve_new_user').selectPlug({getValId:'entTypeVal',defaultVal: entTypeHx}); //新老用户


			//对比时段按钮
           $('.js_btn_submit').click(function(){
        	  	 ajaxRequestData();
              });

			//数据类型列表值改变后触发
    	   $('.js_sel_user_active_type').on('click','li',function(){
        	   //entType:entTypeHx,
    			   var opts = {entType:3,startDate:startDate, endDate:endDate, statType:statTypeHx };
    		   		var data = getRemainParam(opts);
	   				getDataUrlIndex = getDataUrlIndex.replace('.html','');
	   				window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
        	 });

    	   //全部、公共场所、企业触发
    	   $('.js_sel_user_acitve_new_user').on('click','li',function(){
			   var opts = {dataType:dataType,startDate:startDate, endDate:endDate, statType:statTypeHx };
		   		var data = getRemainParam(opts);
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
		    	var opts = {entType:entTypeHx,startDate:startDate, endDate:endDate, statType:statTypeHx };
	    		var dataParam = getRemainParam(opts);
	    		var url = getDataUrlIndex.replace('.html','');//'../Index/exportCards';//urlExport;
	    		var dataType = 'activeUserCount';
	    		var date = new Date();
	    		var params = {'time':date.getTime(),'downloadStat':1};
	    		$.extend(params,dataParam);
	    		exportFn(url,params);
	    	});

	    	//修改列表的表头值(最后一个)
	    	$('.js_table_title_last').html(tableTitle);

        });

</script>
