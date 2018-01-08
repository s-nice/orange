<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>热点分析</title>
    <script src="__PUBLIC__/js/oradt/Home/echarts.min.js"></script>
    <script src="__PUBLIC__/js/oradt/Home/echarts-wordcloud.min.js"></script>
    <script src="__PUBLIC__/js/jquery/jquery.js"></script>

</head>
<body style="">
    <div class="container" style="width: 1200px;height: 800px;margin: 30px auto;">
        <div id="main" style="width: 1200px;height:800px;"></div>
    </div>
    <form action="{:U(MODULE_NAME.'/WordCloud/showPics')}" id="tag-form" method="post">
        <input type="hidden" name="id" value>
        <input type="hidden" name="tag" value>
<!--        <input type="submit">-->
    </form>
    <script type="text/javascript">

        var myChart = echarts.init(document.getElementById('main'));
        option = {
            title: {
                text: '热点分析',
                link: 'https://www.baidu.com/s?wd=' + encodeURIComponent('ECharts'),
                x: 'center',
                textStyle: {
                    fontSize: 23
                }

            },
            backgroundColor: '#F7F7F7',
            tooltip: {
                show: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {
                        iconStyle: {
                            normal: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            },
            series: [{
                name: '热点分析',
                type: 'wordCloud',
                //size: ['9%', '99%'],
                sizeRange: [10, 60],
                //textRotation: [0, 45, 90, -45],
                rotationRange: [-45, 90],
                //            shape: 'circle',
                textPadding: 50,
                autoSize: {
                    enable: true,
                    minSize: 12
                },
                textStyle: {
                    normal: {
                        color: function() {
                            return 'rgb(' + [
                                Math.round(Math.random() * 160),
                                Math.round(Math.random() * 160),
                                Math.round(Math.random() * 160)
                            ].join(',') + ')';
                        }
                    },
                    emphasis: {
                        shadowBlur: 10,
                        shadowColor: '#333'
                    }
                },
                data: [{
                    name: "Jayfee",
                    value: 666
                }, {
                    name: "Nancy",
                    value: 520
                }]
            }]
        };
        var getTags = '{:U(MODULE_NAME."/WordCloud/getTags")}';
        $.get(getTags,{id:'ofIP5vjEMkDnoPmxAfNdiETpjeNE'},function(res){
            console.log(res);


            if(res.head.status===0){
                var list = [];
                for(var i=0;i<res.body.list.length;i++){
                    var obj = {};
                    $.each(res.body.list[i],function(i,v){
                        if(i=='tag_name'){
                            obj.name = v;
                        }else{
                            obj.value = v;
                        }
                    })
                    list.push(obj);
                }
                option.series[0].data = list;
                //console.log(list);
                myChart.setOption(option);
                myChart.on('click', function (params) {
                    $('input[name=id]').val('ofIP5vjEMkDnoPmxAfNdiETpjeNE');
                    $('input[name=tag]').val(params.name);
                    $('#tag-form').submit();
                });
            }
        });


        var JosnList = [{
            name: "人才招聘",
            value: "50"
        }, {
            name: "市场环境",
            value: "40"
        }, {
            name: "行政事业收费",
            value: "11"
        }, {
            name: "食品安全与卫生",
            value: "11"
        }, {
            name: "城市交通",
            value: "11"
        }, {
            name: "房地产开发",
            value: "11"
        }, {
            name: "房屋配套问题",
            value: "11"
        }, {
            name: "物业服务",
            value: "11"
        }, {
            name: "物业管理",
            value: "11"
        }, {
            name: "占道",
            value: "11"
        }, {
            name: "园林绿化",
            value: "11"
        }, {
            name: "户籍管理及身份证",
            value: "11"
        }, {
            name: "公交运输管理",
            value: "11"
        }, {
            name: "公路（水路）交通",
            value: "11"
        }, {
            name: "房屋与图纸不符",
            value: "11"
        }, {
            name: "有线电视",
            value: "11"
        }, {
            name: "社会治安",
            value: "11"
        }, {
            name: "林业资源",
            value: "11"
        }, {
            name: "其他行政事业收费",
            value: "11"
        }, {
            name: "经营性收费",
            value: "11"
        }, {
            name: "食品安全与卫生",
            value: "11"
        }, {
            name: "体育活动",
            value: "11"
        }, {
            name: "有线电视安装及调试维护",
            value: "11"
        }, {
            name: "低保管理",
            value: "11"
        }, {
            name: "劳动争议",
            value: "11"
        }, {
            name: "社会福利及事务",
            value: "11"
        }, {
            name: "一次供水问题",
            value: "5"
        }];


//        option.series[0].data = JosnList;
//
//
//        myChart.setOption(option);
//        myChart.on('click', function (params) {
////            window.open('https://www.baidu.com/s?wd=' + encodeURIComponent(params.name));
//            window.open('https://www.baidu.com/s?wd=' + params.name);
//
//        });
    </script>
</body>
</html>