
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">累计拥有用户数</span>
					</div>
                    <div class="clear" id="js_scroll_dom" style="max-height:438px;">
                        <if condition="count($data['listdata']) gt 0">
                            <foreach name="data['listdata']" item="v">
                            <div class="table_list">
                                <span class="span_t1">{$v['dt']}</span>
                                <span class="span_t1">{:$_GET['s_versions']?$v['pro_version']:'全部'}</span>
                                <span class="span_t1">{:$_GET['h_versions']?$v['model']:'全部'}</span>
                                <span class="span_t1">{$v['chartnumb']}</span>
                            </div>
                            </foreach>
                        <else />
                            No Data
                        </if>
                    </div>
				</div>
                <script>
                    $(function(){

                        var chart = echarts.init(document.getElementById('userStatisticsLine'));
                        chart.setOption({
                            tooltip : {
                                trigger: 'axis'
                            },
                            legend: {
                                data:[]
                            },
                            grid: {
                                left: '3%',
                                right: '4%',
                                bottom: '8%',
                                containLabel: true
                            },
                            calculable : true,
                            xAxis : [
                                {
                                    type : 'category',
                                    boundaryGap : false,
                                    data : [
                                        <?php
                                        foreach($data['xlinedata'] as $v){
                                            echo '"'.$v.'",';
                                        }
                                    ?>
                                    ]
                                }
                            ],
                            yAxis : [
                                {
                                    type : 'value',
                                    splitNumber: 6,
                                    minInterval:1,
                                    max : {$data['maxval']},
                                    interval: {$data['aveval']},
                                    splitLine: {
                                        show:true,
                                        lineStyle: {
                                            // 使用深浅的间隔色
                                            color: ['#B8B8B8'],
                                            type : 'dashed'
                                        }
                                    }
                                }
                            ],
                            series : [
                                <?php
                                    if(!empty($data['chartdata'])){

                                ?>
                                {
                                    name: '累计拥有用户数',
                                    type: 'line',
                                    itemStyle: {normal: {color: '#123abc'}}, // 折线颜色
                                    data: [
                                        <?php
                                            foreach($data['xlinedata'] as $vv){
                                                $mark = 0;
                                                foreach($data['chartdata'] as $ke=>$va){
                                                    if($vv == $va['dt']){
                                                        echo '"'.sprintf("%.2f", $va['chartnumb']).'",';
                                                        $mark = 1;
                                                        break;
                                                    }
                                                }
                                                if($mark){
                                                    continue;
                                                }else{
                                                    echo '"0",';
                                                }

                                            }
                                        ?>
                                    ]
                                },
                                <?php
                                    }
                                ?>
                            ]
                        });

                    });
                </script>