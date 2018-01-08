if (dataJson && !dataJson.own_cardid){
	alert(str_360_check_personal_card);
	location.href=listUrl;
}
var rp = dataJson["relationship"];
var labelName0=str_360_same_city+'('+(rp[0].cards.length>99?'99+':rp[0].cards.length)+str_360_ren+')';
var labelName1=str_360_same_industry+'('+(rp[1].cards.length>99?'99+':rp[1].cards.length)+str_360_ren+')';
var labelName2=str_360_bigman+'('+(rp[2].cards.length>99?'99+':rp[2].cards.length)+str_360_ren+')';
var labelName3=str_360_same_job+'('+(rp[3].cards.length>99?'99+':rp[3].cards.length)+str_360_ren+')';

var nodes = [{id:0,category:0,name:'0',label:str_360_me,symbolSize:35,ignore:false,flag:true},
             {id:1,category:1,name:'1',label:labelName0,symbolSize:30,ignore:false,flag:true},
             {id:2,category:1,name:'2',label:labelName1,symbolSize:30,ignore:false,flag:true},
             {id:3,category:1,name:'3',label:labelName2,symbolSize:30,ignore:false,flag:true},
             {id:4,category:1,name:'4',label:labelName3,symbolSize:30,ignore:false,flag:true}];

var links = [{source : 1,target : 0},{source : 2,target : 0},{source : 3,target : 0},{source : 4,target : 0}]


var n = nodes.length - 1
for(i in rp){
    var r = rp[i]["relationship"]
    var cs = rp[i]["cards"]
    var type = 0
    switch(r){
    	case str_360_same_city:
    		type = 1
    		break;
    	case str_360_same_industry:
    		type = 2
    		break;
    	case str_360_bigman:
    		type = 3
    		break;
    	case str_360_same_job:
    		type = 4
    		break;
    }
    //console.info(type)
    for(c in cs){
        //console.info(cs[c])
        n++
        nodes.push({id:n,category:2,name:n + '',label:cs[c]["name"],symbolSize:20,ignore:true,flag:true,img:cs[c]["picture"]})
        links.push({source:n,target:type})
    }
}
//console.info(nodes)
//console.info(links)
var n = []
$.extend(n,nodes);
init(n,links);


$("#myModal").on('click', function(){
	$(this).modal('hide');
})

function init(nodes,links) {
    require.config({
        paths : {
            echarts : 'http://echarts.baidu.com/build/dist'
        }
    });
    require(["echarts", "echarts/chart/force"], function (ec) {
        var myChart = ec.init(document.getElementById('main'), 'macarons');
        var option = {
            tooltip: {
                show: false
            },
            series: [{
                type: 'force',
                name: "Force tree",
                itemStyle: {
                    normal: {
                        label: {show: true},
                        nodeStyle: {
                            brushType: 'both',
                            borderColor: 'rgba(255,215,0,0.4)',
                            borderWidth: 1
                        }
                    }
                },
                categories: [{name: str_360_me}, {name: str_360_guanxi}, {name: str_360_friend}],
                nodes: nodes,
                links: links
            }]
        };
        //console.info(option)
        myChart.setOption(option);
        /**  Echarts-Force
         力导向布局图树状结构实现节点可折叠效果
         功能：点击一次节点，展开一级子节点；再次点击节点，折叠所有子孙节点；
         弹出最终子节点的标签
         备注：在使用该方法的时候，在nodes的属性里要自定义flag属性，并设置ignore
         */
        var ecConfig = require('echarts/config');

        function openOrFold(param) {
            var linksNodes = [];//中间变量
            var data = param.data;//表示当前选择的某一节点

            var option = myChart.getOption();//获取已生成图形的Option
            var nodesOption = option.series[0].nodes;//获得所有节点的数组
            var linksOption = option.series[0].links;//获得所有连接的数组
            var categoryLength = option.series[0].categories.length;//获得类别数组的大小

            /**
             该段代码判断当前节点的category是否为最终子节点，
             如果是，则弹出该节点的label
             */
            if (data.category == (categoryLength - 1)) {
                $("#card_img").attr("src",data.img)
                $("#myModal").modal('show')
                //alert(data.label);
            }

            /**判断是否选择到了连接线上*/
            if (data != null && data != undefined) {
                /**
                 判断所选节点的flag
                 如果为真，则表示要展开数据,
                 如果为假，则表示要折叠数据
                 */
                if (data.flag) {
                    /**
                     遍历连接关系数组
                     最终获得所选择节点的一层子节点
                     */
                    for (var m in linksOption) {
                        //引用的连接关系的目标，既父节点是当前节点
                        if (linksOption[m].target == data.id) {
                            linksNodes.push(linksOption[m].source);//获得子节点数组
                        }
                    }//for(var m in linksOption){...}
                    /**
                     遍历子节点数组
                     设置对应的option属性
                     */
                    if (linksNodes != null && linksNodes != undefined) {
                        for (var p in linksNodes) {
                            nodesOption[linksNodes[p]].ignore = false;//设置展示该节点
                            nodesOption[linksNodes[p]].flag = true;
                        }
                    }
                    //设置该节点的flag为false，下次点击折叠子孙节点
                    nodesOption[data.id].flag = false;
                    //重绘
                    myChart.setOption(option);
                } else {
                    /**
                     遍历连接关系数组
                     最终获得所选择节点的所有子孙子节点
                     */
                    for (var m in linksOption) {
                        //引用的连接关系的目标，既父节点是当前节点
                        if (linksOption[m].target == data.id) {
                            linksNodes.push(linksOption[m].source);//找到当前节点的第一层子节点
                        }
                        if (linksNodes != null && linksNodes != undefined) {
                            for (var n in linksNodes) {
                                //第一层子节点作为父节点，找到所有子孙节点
                                if (linksOption[m].target == linksNodes[n]) {
                                    linksNodes.push(linksOption[m].source);
                                }
                            }
                        }
                    }//for(var m in linksOption){...}
                    /**
                     遍历最终生成的连接关系数组
                     */
                    if (linksNodes != null && linksNodes != undefined) {
                        for (var p in linksNodes) {
                            nodesOption[linksNodes[p]].ignore = true;//设置折叠该节点
                            nodesOption[linksNodes[p]].flag = true;
                        }
                    }
                    //设置该节点的flag为true，下次点击展开子节点
                    nodesOption[data.id].flag = true;
                    //重绘
                    myChart.setOption(option);
                }//if (data.flag) {...}
            }//if(data != null && data != undefined){...}
        }//function openOrFold(param){...}
        myChart.on("click", openOrFold);
    });
}