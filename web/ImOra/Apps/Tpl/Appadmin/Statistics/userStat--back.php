<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
              <select class="form_sketch text_sketch" id="u50_input">
          <option value="IOS端">IOS端</option>
          <option value="Android端">Android端</option>
          <option value="Leaf">Leaf</option>
        </select>
        <select class="form_sketch text_sketch" id="u57_input">
          <option value="渠道">渠道</option>
          <option value="渠道一">渠道一</option>
          <option value="渠道二">渠道二</option>
          <option value="渠道三">渠道三</option>
        </select>
        <select class="form_sketch text_sketch" id="u58_input">
          <option value="系统平台版本号">系统平台版本号</option>
          <option value="版本一">版本一</option>
          <option value="版本二">版本二</option>
          <option value="版本三">版本三</option>
        </select>
        时间
<input type="text" name="startTime[]"/>
至
<input type="text" name="endTime[]"/>
<input type="button" value="对比时段"/>
        <hr/>
        <select class="form_sketch text_sketch" id="u60_input">
          <option value="活跃用户量">活跃用户量</option>
          <option value="日活跃占比">日活跃占比</option>
          <option value="周活跃占比">周活跃占比</option>
          <option value="人均在线时长">人均在线时长</option>
          <option value="单次登录平均在线时长">单次登录平均在线时长</option>
          <option value="人均登录次数">人均登录次数</option>
        </select>
        <select class="form_sketch text_sketch" id="u227_input">
          <option value="全部">全部</option>
          <option value="新注册用户">新注册用户</option>
          <option value="老注册用户">老注册用户</option>
        </select>
            </div>
            <div id="userStatisticsBar" style="width:800px;height:500px" class=""></div>
            <div id="userStatisticsLine" style="width:800px;height:200px" class=""></div>
            <div id="userStatisticsData" class="">
            <if condition="count($userStats) gt 0">
                <dl>
                  <dt>Count All</dt><dt>User Id</dt><dt>Create Time</dt>
                  <volist name="userStats" id="_userStat">
                  <dd>{$_userStat.count_all}</dd>
                  <dd>{$_userStat.user_id}</dd>
                  <dd>{$_userStat.created_time}</dd>
                  </volist>
                </dl>
            <else/>
              No Data
            </if>
            </div>
        </div>
    </div>
</div>

<script>
// 指定图表的配置项和数据
var echartOptionBar = {
        title: {
            text: 'ECharts 入门示例'
        },
        tooltip: {},
        legend: {
            data:['销量', 'test1', 'test2']
        },
        yAxis: {
        	type : 'value', // 表明是值
        },
        xAxis: {
        	type : 'category',  // 表明是分类
            data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
        },
        series: [{
            name: '销量',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        },{
            name: 'test1',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(0,255,0,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        },{
            name: 'test2',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(0,0,255,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        }]
    };

var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
	        data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '3%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
	            data : ['周一','周二','周三','周四','周五','周六','周日']
	        }
	    ],
	    yAxis : [
	        {
	            type : 'value'
	        }
	    ],
	    series : [
	        {
	            name:'邮件营销',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[120, 132, 101, 134, 90, 230, 210]
	        },
	        {
	            name:'联盟广告',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[220, 182, 191, 234, 290, 330, 310]
	        },
	        {
	            name:'视频广告',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[150, 232, 201, 154, 190, 330, 410]
	        },
	        {
	            name:'直接访问',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[320, 332, 301, 334, 390, 330, 320]
	        },
	        {
	            name:'搜索引擎',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[820, 932, 901, 934, 1290, 1330, 1320]
	        }
	    ],
	    backgroundColor: '#000' // 设置图表背景颜色
	};
//var echartOption = ;

var gEchartSettings = [
                       {containerId: 'userStatisticsBar', option : echartOptionBar},
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];
</script>