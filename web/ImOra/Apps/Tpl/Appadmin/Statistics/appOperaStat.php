<layout name="../Layout/Layout"/>
<style>
    .select_IOS li {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="form_margintop">
	            <div class="content_search">
	                <div class="search_right_c">
	                    <form method="get" action="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}">
                            <!--系统平台-->
                            <div class="select_IOS js_select_item">
                                <input type="text" name="platform" id="js_select_platform"
                                       title="{:isset($_GET['platform'])?$_GET['platform']:$T->stat_apperror_sys_platform}"
                                       value="{:isset($_GET['platform'])?$_GET['platform']:$T->stat_apperror_sys_platform}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"/></i>
                                <ul class="js_scroll_data" style="max-height: 144px; overflow: auto">
                                    <li title="{:$T->stat_apperror_sys_platform}" id="js_platform_all">{:$T->stat_apperror_sys_platform}</li>
                                    <li title="IOS" class="js_platform_click">IOS</li>
                                    <li title="Android" class="js_platform_click">Android</li>
                                    <li title="Leaf" class="js_platform_click">Leaf</li>
                                </ul>
                            </div>                         

	                        <!--时间-->
	                        <!-- 
	                        <div class="select_time_c">
	                            <span>{$T->stat_apperror_time}</span>
	                            <div class="time_c">
	                                    <input class="time_input" type="text" name="startTime" id="js_begintime" value="{//$startTime}"/>
	                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                                </div>
	                                <span>--</span>
	                            <div class="time_c"><!--结束时间-->
	                               <!--  <input class="time_input" type="text" name="endTime" id="js_endtime"
	                                       value="{$endTime}"/>
	                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"/></i>
	                            </div>
	                        </div>
	                        <div class="submit_stat_form" style="float:left">
	                            <input class="submit" type="submit" value="{$T->stat_apperror_submit}"/>
	                        </div>
	                         -->
	                        
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
	                        

	                    </form>
	                </div>
	            </div>

	           <!--  <div class="js_stat_date_type">
	                <a class="on"
	                   href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=day&'.$urlParams_time)}">{$T->stat_apperror_day}</a>
	                <a class=""
                       href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=week&'.$urlParams_time)}">{$T->stat_apperror_week}</a>
	                <a class=""
                       href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?timeType=month&'.$urlParams_time)}">{$T->stat_apperror_month}</a>
             </div> -->
             <!-- 数据类型 -->
              <div class="select_xinzeng js_sel_public js_sel_user_active_type margin_top">
            	<input type="text" value="{$T->str_active_user_cnt}" readonly="readonly"  class="hand"/>
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul class="hand">
            		<li title="{$T->stat_apperror_num_amount}" val="1"  class="hand">{$T->stat_apperror_num_amount}</li><!--程序错误个数-->
            		<li title="{$T->str_menu_new_incre_opera_static}" val="2" add="%"  class="hand">{$T->str_menu_new_incre_opera_static}</li><!--操作统计-->
            	</ul>
            </div>
            
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
                <div class="Data_bt">
                    <span class="left_s">{$T->stat_appopera_list}</span>
                    <if condition="count($tableData) gt 0">
            	  <span class="right_s"><a
                          href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?downloadStat=1&'.$urlParams)}">{$T->stat_apperror_export}</a>
                  </span>
                    </if>
                </div>
                <div class="Data_c_content Data_jsc_content">
                    <div class="DataError_c_name">
                        <span class="span_c_1">{$T->stat_apperror_date}</span>
                        <span class="span_c_2">{$T->stat_apperror_sys_platform}</span>
                        <span class="span_c_6">{$T->stat_title_click_evt}</span>
                        <span class="span_c_7">{$T->stat_apperror_num}</span>
                    </div>
                    <div class="js_scroll_data">
                    <if condition="count($tableData) gt 0">
                        <volist name="tableData" id="_stat">
                            <div class="DataError_c_list">
                                <span class="span_c_1">{:str_replace(' ',"-",trim($_stat['date_index']))}</span>
                                <span class="span_c_2">{$_stat.sys_platform}</span>
                                <span class="span_c_6">{$_stat.model}</span>
                                <span class="span_c_7">{$_stat.count_all}</span>
                            </div>
                        </volist>
                        <else/>
                        No Data
                    </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
<include file="@Layout/js_stat_widget" />
var gStatisticDateType = "d"; // 全局参数， 根据时间类型控制时间空间可选范围
    var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
    var yAxisData = [];
    var list = {:json_encode($chartData)};
    var versionName = [];
    var initData = [];
    var gStatisticDateType = "{$timeType}";//时间类型
    var dataType = 2;
    var sysPlatformHx = "{$_GET['platform']}";
    var getDataUrlIndex = "{:U(MODULE_NAME.'/Statistics/appError')}";
    var getDataUrlCurr = "{:U(MODULE_NAME.'/Statistics/increOperaStatic')}";
    var $urlParams_time = "{$urlParams_time}";
    /*图表配置项*/
    var echartOptionLine = {
        tooltip: {
            trigger: 'axis',
            formatter: function (data) {
                for (i = 0; i < data.length; i++) {
                    if (data[i].seriesName == data[i].name) {
                        return data[i].name + "错误数：" + data[i].data;
                    }

                }
                return data.seriesName;
            },
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data: [],
            bottom:1,
            selectedMode: false
        },
        grid: {
            left: '1%',
            right: '3%',
            bottom: '10%',
            containLabel: true
        },
        xAxis: {
            type: 'value',
        },
        yAxis: {
            type: 'category',
            data: []
        },
        series: []
    };

    /*获取图表数据*/
    if (list[0]) {
        var j = list.length - 1 >= 9 ? 9 : list.length - 1; //top10
        for (var jj = 0; jj <= j; jj++) { //数据值全为0的数组
            initData.push(0);
        }
        for (var i = j, k = 0; i >= 0, k <= j; i--, k++) { //top5
            versionName.push(list[i].prd_version); //版本名称
            //echartOptionLine.series[0].data.push(list[i].count_all);
            echartOptionLine.yAxis.data = versionName; //Y轴数据版本名称
            var mydata = initData.concat();
            mydata[k] = list[i].count_all;
            echartOptionLine.series.push(
                {
                    name: list[i].prd_version,
                    type: 'bar',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'right'
                        }
                    },
                    barMaxWidth: 70,
                    data: mydata,
                    itemStyle: {
                        normal: {
                            color: colorList[k]
                        }
                    }

                }
            );
            echartOptionLine.legend.data.push(
                {
                    name: list[i].prd_version,
                    // 强制设置图形为圆。
                    // icon: 'circle',
                    // 设置文本为
                    textStyle: {
                        color: colorList[k]
                    }
                }
            )


        }
        /*
         整数：统计值最大值为“11213”，进位至“11220”，平均刻度值=11220/5=2244,坐标轴最大值为11220+2244=13464；
         0≤MAX≤5，分5段，平均间距=1
         5＜MAX＜10，分5段，平均间距=2
         */
        if (echartOptionLine.series[j].data[j] <= 5) {
            echartOptionLine.xAxis.max = 5;
            echartOptionLine.xAxis.interval = 1;
        } else if (echartOptionLine.series[j].data[j] < 10) {
            echartOptionLine.xAxis.max = 10;
            echartOptionLine.xAxis.interval = 2;

        } else {
            echartOptionLine.xAxis.max = Math.ceil(list[0].count_all / 10) * 10 * 1.2;
            echartOptionLine.xAxis.interval = echartOptionLine.xAxis.max / 6;
        }
    } else {
        echartOptionLine.series = [
            {
                name: "No Data",
                type: 'bar',
                data: 0
            }

        ];

    }

    var gEchartSettings = [
        {containerId: 'userStatisticsLine', option: echartOptionLine}
    ];

    var gStrPlatform="{:$T->stat_apperror_sys_platform}";
    var gGetPlatform="{:$_GET['platform']}";
    $(function () {
       /*日，周，月 按钮样式*/
       /*  switch (gStatisticDateType) {
            case "week":
                $(".js_stat_date_type a").removeClass("on");
                $(".js_stat_date_type a:eq(1)").addClass("on");
                break;
            case "month":
                $(".js_stat_date_type a").removeClass("on");
                $(".js_stat_date_type a:eq(2)").addClass("on");
                break;
            default:
                $(".js_stat_date_type a").removeClass("on");
                $(".js_stat_date_type a:eq(0)").addClass("on");
        } */

        /*多选已选择选项样式*/

       /*  $(".js_checkbox_input").each (function(index,obj){
                var selectVal= $.trim(obj.title).split("/");
               $(this).siblings("ul").find("li").each(function(index,li_obj){
                   for(var i=0;i<selectVal.length;i++) {
                       if ($.trim(li_obj.title) == $.trim(selectVal[i])) {
                           $(this).addClass("on");
                           selectVal.splice(i,1);
                       }
                   }
                });
        }); */

        /*选项联动*/

        if(gGetPlatform!=gStrPlatform && gGetPlatform!=''){
            $(".js_scroll_data li[platform!='"+gGetPlatform+"']").hide();
            $(".js_platform_click").show();
            $("#js_platform_all").show();
            $(".js_default_select").show();
        }

        var defaultVal=new Array;
        $(".js_default_select").each(function(){
           defaultVal.push($.trim($(this).text()));
        });
       $(".js_platform_click").on("click",function(){
           var _platfrom=$(this).attr('title');
           $(".js_scroll_data li").show();
           $(".js_scroll_data li[platform!='"+_platfrom+"']").hide();
           $(".js_platform_click").show();
           $("#js_platform_all").show();
           $(".js_default_select").show();
           $(".js_scroll_data li").removeClass('on');
           $(".js_default_input").each(function(index,obj){
               obj.title=defaultVal[index];
               obj.value=defaultVal[index];
           })
       });
        $("#js_platform_all").on("click",function(){
            $(".js_scroll_data li").show();
            $(".js_scroll_data li").removeClass('on');
            $(".js_default_input").each(function(index,obj){
                obj.title=defaultVal[index];
                $(this).val(defaultVal[index]);
            })
        });

        $('.js_sel_user_active_type').selectPlug({getValId:'activeTypeId',defaultVal: dataType}); //性能统计类型
		//数据类型列表值改变后触发
  	   $('.js_sel_user_active_type').on('click','li',function(){
 	  		var dataType = $('#activeTypeId').val();
  		   	var opts = {platform:sysPlatformHx,dataType:dataType};
	   		var param = '';
	   		for(var i in opts){
			if(opts[i]){
				if(param){
					param += '&';
				}
				param += i+'='+opts[i];
			}
  		   	}
  		   	if(dataType == 2){
  	  		   	param += '&'+$urlParams_time;
  	  	  		getDataUrlIndex = getDataUrlCurr;
  		   	}
   			window.location.href = getDataUrlIndex+ '?'+param;
      	 });
        

    });


</script>
