<layout name="../Layout/Company/AdminLTE_layout" />
<div class="cardtrend_warp">
        	  <!-- 条件搜索 start -->
        	  <div class="content_search_all">
        	  <div class="content_search" style="margin-right:0;">
            	<div class="search_right_c" style="float: none">
            		<!--  start
            		 <div id="select_date_type" class="select_sketch">
            			<input name="dateType" id="dateType" type="text" value="<if condition='!empty($country)'>{$country}<else/>日</if>" name='country' readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            				<li  val="day" title="天" <php> if(strstr($country,$dateType)!==false){echo "class='on'";}</php> ><php> echo $dateType;</php>天 </li>
            				<li  val="month" title="月" <php> if(strstr($country,$dateType)!==false){echo "class='on'";}</php> ><php> echo $dateType;</php>月 </li>
            			</ul>
            		</div>
            		<div id="select_day_what" class="select_sketch">
            			<input name="dayWhat" id="dayWhat"  type="text" name="province" value="<if condition='!empty($province)'>{$province}<else/>最近30天</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            				<li title="最近30天" val="1" data-link-value=",day," >最近30天</li>
	            			<li title="" val="2" data-link-value=",day,">最近15天</li>
	            			<li title="" val="3" data-link-value=",day,">最近7天</li>
	            			<li title="" val="4" data-link-value=",day,">自定义</li>
            			</ul>
            		</div>
            		-->
            		<!-- end -->
            		
					<!--日期选择
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
	            	-->
	            	<!-- 天/月选择下拉框 -->
	            	<div class="left_select">
	            	<div class="maxwidth_select1">
		            <select class="form-control select2" id="js_date_type_sel"  style="width: 100%;" >
		              <if condition="$dayTypeSel eq 'day'">
		              	<option selected="selected" value="day" title="天">天</option>
		              <else/>
		              	<option  value="day" title="天">天</option>
		              </if>
		               <if condition="$dayTypeSel eq 'month'">
		               		<option selected="selected"  value="month" title="月">月</option>
		               <else/>
		               		<option value="month" title="月">月</option>
		               </if>
	                  
	                </select>
	                </div>
            		<!-- 最近n天/n月下拉框 -->
            		<div class="maxwidth_select1">
		            <select class="form-control select2" id="js_date_val_sel" style="width: 100%;" >
	                  <option value="lastDay30-day" dataType="day" selected="selected" title="tit">最近30天</option><!--   -->
	                  <option value="lastDay15-day" dataType="day" title="tit">最近15天</option>
	                  <option value="lastDay7-day" dataType="day" title="tit">最近7天</option>
	                <!--  <option value="lastDay-day" dataType="day" >自定义</option> lastDay-day -->
	                  <option value="lastMonth5-month" dataType="month" title="tit">最近5月</option>
	                  <option value="lastMonth3-month" dataType="month" title="tit">最近3月</option>
	                  <option value="lastMonth2-month" dataType="month" title="tit">最近2月</option>
	                  <option value="lastMonth1-month" dataType="month" title="tit">最近1月</option>
	                  <!--<option value="lastMonth-month" dataType="month">自定义</option> lastMonth-month -->
	                  <option value="lastDefinedSelf" dataType="month" title="tit">自定义</option>
	                </select>
	                </div>
	                <div class="maxwidth_select">
	            	<div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-calendar"></i>
	                  </div>
	                  <input type="text" class="form-control pull-right" name="js_begintime_range" id="js_begintime_range" value="{$dateChoose['js_begintime_range']}" readOnly="readOnly">
	                </div>
	                </div>
	            	<!-- 部门下拉框 -->
	            	<div class="maxwidth_select1">
		            <select class="form-control select2" id="js_department"  style="width: 100%;" >
		              <option selected="selected" value="" title="全部部门">全部部门</option>
		              <foreach name="departSet" item="vo">
	                  <option  value="{$vo.name}" title="天">{$vo.name}</option>
	                  </foreach>
	                </select>
	                </div>
            		<!-- 鱼啊弄个下拉框 -->
            		<div class="maxwidth_select1">
		            <select class="form-control select2" id="js_employer"  style="width: 100%;" >
	                  <option selected="selected js_employer_default" value="" title="全部员工">全部员工</option>
	                  <foreach name="employerSet" item="vo">
	                  <option value="{$vo.name}" dataDepartId="{$vo.department}" title="{$vo.name}">{$vo.name}</option>
	                  </foreach>
	                </select>
	                </div>
	                </div>
	                <div class="maxwidth_select2">
            		 <input class="submit_button_c js_btn_submit" type="submit" value="查询"/><!-- 提交按钮 -->
            		</div>
            	</div>
            </div>
            <!-- 条件搜索 end -->
            </div>
            <div class="datastatistics_cardin">最近<span>30</span>天获得名片总数：<span>{$chartSet.sumCnt}</span>张</div>
            <!-- 折线图 start -->
            <div id="userStatisticsLine" style="width:80%;height:500px;padding-bottom:30px;margin:0% 11% 6% 11%;" class=""></div>
            <!-- 折线图 end -->
</div>
<script>
<include file="@Layout/js_stat_widget" />
var gStatisticDateType = "{$statType[0]}"; // 全局参数， 根据时间类型控制时间空间可选范围
var getDataUrlIndex =  "{:U(CONTROLLER_NAME.'/cardIncreTrend')}";
var chartDataSet 	= {:json_encode($chartSet)}; //折线图的数据源
var xTitle 			= chartDataSet.xTitle; //x坐标轴
var gJsChartDataSource = chartDataSet.chartData; //折线数据集合
var titleList    	= chartDataSet.chartTitle;

//请求变量回显使用
//var dateTypeVal = "{$dateType}"; //数据源类型
//var dayWhatVal = "{$dayWhatVal}"; //系统平台
var startDate = "{$startDate}"; //开始日期
var endDate   = "{$endDate}"; //结束日期
var max=0;
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
var gJsChartData = [];
	$.each(gJsChartDataSource,function(lineName,val){
	    var gLine1 = '新增名片数';
	    $.each(val,function(j,num){
		    	num = parseInt(num);
				if(num > max){
					max = num;
				}
		 });
		var obj = {
	            name: gLine1,
	            type:'line',
	          //  stack: '总量',
	            itemStyle : {normal: {color:colorList[0]} }, // 折线颜色 '#999'
	            data:val //[120, 132, 101, 134, 90, 230, 210]
	       	 };
		gJsChartData.push(obj);
	});
var rst=paramsForGrid(max);
// 指定图表的配置项和数据
var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
	    	bottom : '-2px',
	        data:['新增名片数']
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '8%',
	        containLabel: true
	    },
	    //timeline:{bottom:1},
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
	            data : xTitle,
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
		 backgroundColor: '#FFF' // 设置图表背景颜色
	};

var gEchartSettings = [{containerId: 'userStatisticsLine', option : echartOptionLine}];

		/**
		 * 获取请求参数
		*/
		function getRemainParam(){
				var typeSel = $("#js_date_type_sel").val();
				var valSel = $("#js_date_val_sel").val();
	     		var departId   = $('#js_department').val();
	       		var employId 	  = $('#js_employer').val();
	       		var js_begintime_range = $('#js_begintime_range').val();
	       		var js_begintimeArr = js_begintime_range.split(' - ');
	       		var js_begintime = js_begintimeArr[0];
	       		var js_endtime = js_begintimeArr[1]
	       		if(js_begintime == '' || js_endtime == ''){
	       			$.global_msg.init({gType:'warning',icon:2,msg:'日期不能为空'});
	       			return false;
	       		}
				var data = {
						departId: departId,
						employId: employId,
						startDate: js_begintime,
						endDate: js_endtime,
						dayTypeSel: typeSel,
						dayValSel: valSel
			   		};
		   		//去除空属性操作
		   		var tmp = {};
		   		for(var i in data){
					data[i] ? (tmp[i] = data[i]) : null;
			   	}
		   		return tmp;
		}

	       //异步请求数据
	       function ajaxRequestData(){
	        	var data = getRemainParam();
		       	if(data !== false){
		       		typeof(opts) != 'undefined' ? (data = $.extend(true,{},data, opts)) : null;
		       		getDataUrlIndex = getDataUrlIndex.replace('.html','');
		       		window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
		       	}
	       }
	       //编码url
	       function getEscapeParamStr (jsonData){
		       	if (!jsonData) return '';
	       		var qarr = [];
	       		for(i in jsonData){
	       			qarr.push(i+"/"+encodeURIComponent(jsonData[i]));
	       		}
	       		return qarr.join('/');
	       }
	       
       $(function(){
   	    
           //下拉框插件
    	  // $('#select_date_type').selectPlug({getValId:'dateTypeVal',defaultVal: dateTypeVal}); //系统平台
    	  // $('#select_day_what').selectPlug({getValId:'dayWhatVal',defaultVal: dayWhatVal}); //渠道
		   //点击提交按钮
           $('.js_btn_submit').click(function(){
        	  	 ajaxRequestData();
           });
          /*  $('#dateType').on('change',function(){
               console.log('cc')
				var val = $(this).val();
				if(val == 'day'){
					$('#select_day_what').show();
				}else if(val == 'month'){
					$('#select_day_what').hide();
				}
           }); */
          /*  $('#dayWhatVal').on('change',function(){
      				var val = $(this).val();
      				if(val == '4'){
      					$('.select_time_c').show();
      				}else{
      					$('.select_time_c').hide();
      				}
           }); */

   	   	 //Initialize Select2 Elements
   	   	 	
  
   	   	   $.dateSelect.init();//日期选择级联插件 、部门员工级联
        });

        var gDateChoose = {:json_encode($dateChoose)}; //日期定义的默认变量
        var gGetEmployerByDepart = "{:U(CONTROLLER_NAME.'/getEmployerByDepart')}"; //根据部门id获取当前部门下所有员工
        var gDayValSel = "{$dayValSel}";
        var gDepartId = "{$departId}";
        var gEmployId = "{$employId}";
		$.extend({
			//日期选择级联插件 、部门员工级联
			dateSelect:{
				type_val:{'day':'month','month':'day'},
				init: function(){
					this.initData();
					this.bindEvtDate();
				},
				initData: function(){
					gDayValSel && $('#js_date_val_sel option[value="'+gDayValSel+'"]').prop('selected', true);
					gDepartId && $('#js_department option[value="'+gDepartId+'"]').prop('selected', true);
					gEmployId && $('#js_employer option[value="'+gEmployId+'"]').prop('selected', true);
					
					//调用日期类型下拉框
		   	    	$("#js_date_type_sel").select2(); //日/月下拉框
		   	    	$("#js_date_val_sel").select2(); //最近n天/月下拉框
		   	    	$("#js_department").select2(); //部门下拉框
		   	    	$("#js_employer").select2(); //员工下拉框
		   	    	
		            //日期选择 ,locale:{daysOfWeek:['0','1','2','3','4','5','6']}  format: 'YYYY/MM/DD',
		   	    	$('#js_begintime_range').daterangepicker({ timePickerIncrement: 366, locale:{format: 'GGGG-MM-DD'}}); //调用adminLTE日期选择插件
			     //console.log($("#js_date_type_sel").val(), $("#js_date_val_sel").val());
			     var typeShowVal = $.trim($('#select2-js_date_type_sel-container').text());
			     var defaultTypeVal = $("#js_date_type_sel option[title='"+typeShowVal+"']").val();
			     var chooseVal = $.trim($("#js_date_val_sel option[dataType='"+defaultTypeVal+"']:selected").text());
			     if(!chooseVal){
			    	 chooseVal = $.trim($("#js_date_val_sel option[dataType='"+defaultTypeVal+"']:eq(0)").text());
			    	 $("#js_date_val_sel option[dataType='"+defaultTypeVal+"']:eq(0)").prop('selected',true);//第二个下拉框实际选中值
			     }
			     $('#select2-js_date_val_sel-container').html(chooseVal).attr('title',chooseVal); //第二个下拉框的显示值
				},
				bindEvtDate: function(){
					var that = this;
					//天/月级联  > 最近n天/最近n月 点击事件
		 	    	$('span[aria-labelledby="select2-js_date_val_sel-container"]').click(function(){
						var typeVal = $("#js_date_type_sel").val();
						$("li[id$='-"+that.type_val[typeVal]+"']").hide();
						$("li[id$='-"+typeVal+"']").show();						
	   	   	   		 });
	   	   	   		//天/月下拉框值变化时触发(第一个下拉框)
		 	    	$("#js_date_type_sel").change(function(){
			 	    	var type = $(this).val();
			 	    	var chooseValObj = $("#js_date_val_sel option[dataType='"+type+"']:eq(0)"); //获取第一个下拉框对象
			 	    	var val = chooseValObj.val();
			 	    	var showVal = chooseValObj.html();
			 	    	$("#js_date_val_sel option[dataType='"+type+"']:eq(0)").prop('selected',true);//第二个下拉框实际选中值
 			 	    	$('#select2-js_date_val_sel-container').html(showVal).attr('title',showVal); //第二个下拉框的显示值
			 	    	var valArr = val.split('-');
			 	    	var startDate = gDateChoose[valArr[0]];
			 	    	//console.log(startDate);
			 	    	var dateRange = startDate+' - '+gDateChoose['prevDay'];
				 	    $('#js_begintime_range').val(dateRange);
						$('#js_begintime_range').daterangepicker({timePickerIncrement: 366, locale:{format: 'GGGG-MM-DD'}});
			 	    });
			 	    //最近n-x下拉框值变化时触发(第二个下拉框)
		 	    	$("#js_date_val_sel").change(function(){
		 	    		var val = $(this).val();
		 	    		var valArr = val.split('-');
			 	    	var startDate = gDateChoose[valArr[0]];
			 	    	var dateRange = startDate+' - '+gDateChoose['prevDay'];
				 	   	//console.log(valArr[0],startDate,dateRange);
				 	    $('#js_begintime_range').val(dateRange);//startDate:startDate,endDate:gDateChoose['prevDay'], //GGGG-MM-DD用这个跨年有问题     MM/DD/YYYY
						$('#js_begintime_range').daterangepicker({ timePickerIncrement: 1068, locale:{format: 'YYYY-MM-DD'}});
		 	    	});
		 	    	
					//部门下拉框
		 	    	$("#js_department").change(function(){
						var departId = $.trim($(this).val());
						that.ajaxGetEmployer(departId); 
						/* if(departId){
							//$("#js_date_val_sel option[datadepartid='"+departId+"']:eq(0)").prop('selected',true);//第二个下拉框实际选中值
							$("#select2-js_employer-results li[id !='-"+departId+"']").hide();
						}else{
							//$("#js_date_val_sel option[datadepartid='"+departId+"']:eq(0)").prop('selected',true);//第二个下拉框实际选中值
							$("#select2-js_employer-results li[id $='-"+departId+"']").show();
						} */
					/* 	var employerFirstObj = $("#js_employer option:eq(0)");
							employerFirstObj.prop('selected', true);
						var showVal = employerFirstObj.text();
						$('#select2-js_employer-container').html(showVal).attr('title',showVal); //第二个下拉框的显示值
						console.log(showVal, $('#select2-js_employer-container')) */
			 	    });
			 	    //点击员工下拉框
/* 		 	    	$('span[aria-labelledby="select2-js_employer-container"]').click(function(){
						var departid = $("#js_department").val();
						if(departid){
							$("#select2-js_employer-results li[id !='-"+departid+"']").hide();
							$("#select2-js_employer-results li[id$='-"+departid+"']").show();
							$("#select2-js_employer-results li:eq(0)").show();
							$("#js_employer option:eq(0)").prop('selected',true);//第二个下拉框实际选中值
						}else{
							$("#js_employer option:eq(0)").prop('selected',true);
							$("#js_employer option:gt(0)").removeAttr('selected');
						}
	   	   	   		 }); */
				},
				allDepartId: 'fdsfd%$#$#@$@$#@$%43', //虚拟定义一个全部部门的id
				cacheEmployerData:{}, //缓存部门中的员工数据
				//根据id获取部门下的员工
				ajaxGetEmployer: function(departId){
					var that = this;
					var tmpDepartId = departId?departId:that.allDepartId;
					if(typeof(that.cacheEmployerData[tmpDepartId]) == 'undefined'){
						$.ajax({
						  type: "GET",
						  data: {departId:departId},
						  url: gGetEmployerByDepart,
						  dataType: "json",
						  async: false,
						  success: function(rst){
							  that.generalEmployer(rst);
							  that.cacheEmployerData[tmpDepartId] = rst;
						  }
						});
					}else{
						that.generalEmployer(that.cacheEmployerData[tmpDepartId]); //从缓存中获取数据
					}
				},
				//生成员工列表html结构
				generalEmployer: function(rst){
				  var html = '';
				  $.each(rst,function(i,obj){
					html += ' <option value="'+obj.department+'" dataDepartId="'+obj.department+'" title="'+obj.name+'">'+obj.name+'</option>';
				  });
				  $('#js_employer>option:gt(0)').remove();
				  $('#js_employer').append(html);
				}
			}
		});
</script>
