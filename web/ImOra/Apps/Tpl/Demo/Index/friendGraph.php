<layout name="Layout" />
<!-- 关系图  start -->
<div class="warp_erdrm" id="main" style="height: 800px;">
</div>
<!-- 关系图 end -->
<script>
$(function(){

	var $nodes = {: json_encode($nodes)};
	$nodes.forEach(function (node) {
        node.draggable = true;
    });

	// 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    myChart.showLoading();
    var nodeType = {:json_encode($params['nodeType'])};
    var linkType = {:json_encode($params['linkType'])};
    var lenged = {: json_encode($params['legend'])};
    var categories = [];
    var color = {:json_encode($params['color'])};
    for (var i in lenged){
    	categories[i] = {name : lenged[i]};
    }
        option = {
            title: {
//                 text: 'Les Miserables',
//                 subtext: 'Default layout',
//                 top: 'bottom',
//                 left: 'right'
            },
            tooltip: {
            	trigger: 'item',
    	        formatter: function(params){
        	        var type;
        	        if(typeof params.data.type !='undefined'){
        	        	type = params.data.type;
        	        	var str = params.data.name.split('+');
        	        	if ('1'==params.data.isSelf) {
            	        	return '我';
        	        	}
            	        return nodeType[type]+':'+str[0];
        	        }else{
        	        	type = params.data.name;
        	        	return linkType[type];
        	        }
    	        }
	        },
            legend: [{
                // selectedMode: 'single',
//                 data: lenged
            }],
            animation: false,
            series : [
                {
                    //draggable : false,
                    name: '',
                    color: color,
                    type: 'graph',
                    layout: 'force',
                    data: $nodes,
                    links: {: json_encode($links)},
                    categories: categories,
                    roam: true, // 'scale' 或者 'move'。设置成 true 是否开启鼠标缩放和平移漫游
                    focusNodeAdjacency: true,	//是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点
	                lineStyle: {
	                    normal: {
	                        color: 'source',
	                        curveness: 0,
	                        width: 1,
	                    },
	                    emphasis:{
	                    	width: 2,
	                        color: '#f39707'
	                    }
	                },
                    label: {
                        normal: {
                        	show:true,
                            position: 'right',
                            formatter: function(params){
                    	        if(typeof params.data !='undefined'){
                                    return params.data.label;
                    	        }
                	        }
                        }
                    },
                    force: {
                        initLayout:'circular',
                        repulsion :1000,
                        edgeLength : 300
                    }
                }
            ]
        };
        myChart.hideLoading();
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    // 绑定事件
    myChart.on('dblclick', function (params) {
        //console.log(params);
		if(typeof params.data != 'undefined' && typeof params.data.type != 'undefined'){
			if(params.data.type == 'card'){
				var src = params.data.symbol;
				var src = src.replace("image://",'');
				showMsgImg(src);
			}
		}
    });
	// 高亮显示节点
    myChart.dispatchAction({
        type:'highlight',
        name:'{$searchName}'

    });
});
</script>