<!--橙脉-搜索次数-->
<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="form_margintop">
                <include file="../Layout/nav_stat_app" />
                <div class="select_xinzeng margin_top js_select_menu js_select_action">
                    <input type="text" value="搜索次数">
                    <i><img src="/images/appadmin_icon_xiala.png"></i>
                    <ul>
                        <li value="">搜索用户数</li>
                        <li value="">搜索次数</li>
                        <li value="">人均搜索次数</li>
                    </ul>
                </div>
                <div class="js_stat_date_type">
                    <a  <if condition="$period eq 'd' ">class="on"</if> val="d">1日</a>
                    <a  <if condition="$period eq 'd3' ">class="on"</if> val="d3">3日</a>
                    <a  <if condition="$period eq 'w' ">class="on"</if> val="w">周</a>
                    <a  <if condition="$period eq 'm' ">class="on"</if> val="m">月</a>
                </div>
            </div>
            <!-- 图表放置 -->
            <div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">

            </div>
            <div id="userStatisticsData">
                <div class="Data_bt">
                    <span class="left_s">搜索次数数据表</span>
                    <if condition="count($tableData) gt 0">
                        <form class="js_download" method="post" target="_blank" action="/Appadmin/StatSearch/index">
                            <input type="hidden" value="{$s_versions_name}" name ="s_versions"/>
                            <input type="hidden" value="{$h_versions_name}" name ="h_versions"/>
                            <input type="hidden" value="1" name ="downloadStat"/>
                            <input type="hidden" value="{$startTime}" name ="startTime"/>
                            <input type="hidden" value="{$endTime}" name ="endTime"/>
                            <input type="hidden" value="{$action}" name ="action"/>
                            <input type="hidden" value="{$period}" name ="timeType"/>
                            <button class="right_down" type="button">导出</button>
                        </form>
                    </if>
                </div>
                <div class="table_content">
                    <div class="table_list table_tit">
                        <span class="span_t9">日期</span>
                        <span class="span_t9">软件版本</span>
                        <span class="span_t9">硬件版本</span>
                        <span class="span_t9">总使用用户数</span>
                        <span class="span_t9">文本搜索次数</span>
                        <span class="span_t9">语音搜索次数</span>
                    </div>
                    <div class="scrolls table_scrolls  clear">
                        <if condition="count($tableData) gt 0">
                            <volist name="tableData" id="list">
                                <div class="table_list">
                                    <span class="span_t9" title="{$list.dt}">{$list.dt}</span>
                                    <span class="span_t9" title="{$list.pro_version}">{$list.pro_version}</span>
                                    <span class="span_t9" title="{$list.model}">{$list.model}</span>
                                    <span class="span_t9" title="{$list.user_all}">{$list.user_all}</span>
                                    <span class="span_t9" title="{$list.num}">{$list.num}</span>
                                    <span class="span_t9" title="{$list.num}">{$list.num}</span>
                                </div>
                            </volist>
                            <else/>
                            NO DATA
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var gAction="{$action}";
    var gTimeType="{$period}";
    var gXdata={$line_x};//横轴数据
    var gYdata={$line_x_val};//横轴对应的值
    var gMaxVal={$maxVal};//最大值
    $(function(){
        gMaxVal= $.OraStatSystemCard.getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
        /*配置图表*/
        var myChart = echarts.init(document.getElementById('userStatisticsLine'));
        myChart.showLoading({
            text: '正在努力的读取数据中...',
        });
        var option = {
            tooltip: {
                trigger: 'axis'
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                //data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
                data:gXdata
            },
            yAxis: {
                max:gMaxVal, //最大刻度/
                splitNumber:6,//分5个断（6个刻度）
                minInterval: 1,	//	保证分科刻度为整数
                type: 'value'
            },
            series: [
                {
                    name: '人均使用次数',
                    type: 'line',
                    //data: [0, 200, 400, 600, 800, 1000]
                    data:gYdata
                }

            ]
        };
        myChart.setOption(option);
        // 数据整理完毕
        myChart.hideLoading();
        $.OraStatSystemCard.init();
    })
</script>