<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <!-- 引入 echarts.js -->
    <script src="dist/echarts.js?v=<?php echo time();?>"></script>
</head>
<body>
<?php include 'data.php';?>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 1200px;height:600px;"></div>
    <script type="text/javascript">
        // 路径配置
        require.config({
            paths: {
                echarts: 'http://jiyanli.oradt.com/test/echarts/dist'
            }
        });
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/force' // 使用关系图加载force模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('main')); 

                option = {
                	    title : {
                	        text: '橙脉关系：<?php echo $jsnode[0]['name'];?>',
                	        subtext: '数据橙脉',
                	        x:'right',
                	        y:'bottom'
                	    },
                	    tooltip : {
                	        trigger: 'item',
                	        formatter: '{a} : {b}'
                	    },
                	    toolbox: {
                	        show : false,
                	        feature : {
                	            restore : {show: true},
                	            magicType: {show: true, type: ['force', 'chord']},
                	            saveAsImage : {show: true}
                	        }
                	    },
                	    legend: {
                	        x: 'left',
                	        data:['朋友','一度人脉','二度人脉']
                	    },
                	    series : [
                	        {
                	            type:'force',
                	            name : "橙脉",
                	            ribbonType: false,
                	            categories : [
                	                {
                	                    name: '朋友'
                	                },
                	                {
                	                    name: '一度人脉',
                	                    symbol: 'diamond'
                	                },
                	                {
                	                    name:'二度人脉'
                	                }
                	            ],
                	            itemStyle: {
                	                normal: {
                	                    label: {
                	                        show: true,
                	                        textStyle: {
                	                            color: '#333'
                	                        }
                	                    },
                	                    nodeStyle : {
                	                        brushType : 'both',
                	                        borderColor : 'rgba(255,215,0,0.4)',
                	                        borderWidth : 1
                	                    }
                	                },
                	                emphasis: {
                	                    label: {
                	                        show: false
                	                        // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                	                    },
                	                    nodeStyle : {
                	                        //r: 30
                	                    },
                	                    linkStyle : {}
                	                }
                	            },
                	            minRadius : 15,
                	            maxRadius : 25,
                	            gravity: 1.1,
                	            scaling: 1.2,
                	            draggable: false,
                	            linkSymbol: 'arrow',
                	            steps: 10,
                	            coolDown: 0.9,
                	            //preventOverlap: true,
                	            nodes:<?php echo json_encode($jsnode);?>,
                	            links : <?php echo json_encode($jslink);?>
                	        }
                	    ]
                	};
	            	// 为echarts对象加载数据 
	                myChart.setOption(option); 
//                 	var ecConfig = require('echarts/config');
//                 	function focus(param) {
//                 	    var data = param.data;
//                 	    var links = option.series[0].links;
//                 	    var nodes = option.series[0].nodes;
//                 	    if (
//                 	        data.source != null
//                 	        && data.target != null
//                 	    ) { //点击的是边
//                 	        var sourceNode = nodes.filter(function (n) {return n.name == data.source})[0];
//                 	        var targetNode = nodes.filter(function (n) {return n.name == data.target})[0];
//                 	        console.log("选中了边 " + sourceNode.name + ' -> ' + targetNode.name + ' (' + data.weight + ')');
//                 	    } else { // 点击的是点
//                 	        console.log("选中了" + data.name + '(' + data.value + ')');
//                 	    }
//                 	}
//                 	myChart.on(ecConfig.EVENT.CLICK, focus)

//                 	myChart.on(ecConfig.EVENT.FORCE_LAYOUT_END, function () {
//                 	    console.log(myChart.chart.force.getPosition());
//                 	});



        
                
            }
        );
    </script>
</body>
</html>