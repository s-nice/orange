<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <!-- 引入 echarts.js -->
    <script src="dist/echarts.js?v=<?php echo time();?>"></script>
    <script src="jquery.js"></script>
</head>
<body>
<?php
$str = '{
  "results": [
    {
      "columns": [
        "q"
      ],
      "data": [
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14623,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "20221",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "路凯",
                  "userid": "ArvgE6kOiwu6ip8PrUBtDdINmXhNo00000000830"
                }
              }
            ],
            "relationships": [
              {
                "id": "14623",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "20221",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14622,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "19776",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "Justin",
                  "userid": "AqPaxjkxYz2bPv1n1oqZVJCYfwu4I00000008688"
                }
              },
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              }
            ],
            "relationships": [
              {
                "id": "14622",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "19776",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14621,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "19298",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "CHarles ZH",
                  "userid": "ApDyxkzaxDbblvAf7jJ9E3CYYbt5q00000001503"
                }
              }
            ],
            "relationships": [
              {
                "id": "14621",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "19298",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14620,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "18862",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王喆",
                  "userid": "AO9uRiVzxwPPxTlGTmS7onMch5iWg00000000797"
                }
              }
            ],
            "relationships": [
              {
                "id": "14620",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "18862",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14619,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "18755",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "39101",
                  "userid": "ANuZxQMFSiOTr0o57c1dMtnaOxXXq00000019846"
                }
              }
            ],
            "relationships": [
              {
                "id": "14619",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "18755",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14618,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "16951",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "Thomas",
                  "userid": "Aj6IpGh7ACBWUKOz2ObHw6EuHqb7a00000008687"
                }
              }
            ],
            "relationships": [
              {
                "id": "14618",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "16951",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14617,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "15312",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "崔琦",
                  "userid": "AeRkWWn27xjbOa5cNNo5457PrfnR600000000804"
                }
              },
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              }
            ],
            "relationships": [
              {
                "id": "14617",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "15312",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14616,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "14839",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "相知相守",
                  "userid": "ADGwejBjg7MCHFvXkLKRbvjkGAvmG00000000768"
                }
              }
            ],
            "relationships": [
              {
                "id": "14616",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "14839",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14615,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "13980",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "蔡蓉",
                  "userid": "AB6K15DgluQ5OAmwRMNCO5B61lcUw00000000827"
                }
              }
            ],
            "relationships": [
              {
                "id": "14615",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "13980",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14613,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "12886",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "Mary",
                  "userid": "A69vDLwcS5YXEi8umL0B9eheCB7hX00000008686"
                }
              }
            ],
            "relationships": [
              {
                "id": "14613",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "12886",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14612,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "12666",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "崔琦",
                  "userid": "A4Z5UP279dnWWroTFliZCXnf2J4Pr00000000804"
                }
              }
            ],
            "relationships": [
              {
                "id": "14612",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "12666",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14611,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "11829",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "COCO在线",
                  "userid": "A0MamBXtNHo013cb5AqqSQHJztSHz00000009061"
                }
              }
            ],
            "relationships": [
              {
                "id": "14611",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "11829",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14628,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "22794",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "胡承群",
                  "userid": "AyR4cf2mHhJ3A1VqFIx6ZQ86h0Nvf00000000798"
                }
              }
            ],
            "relationships": [
              {
                "id": "14628",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "22794",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14624,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "20803",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "ma8401",
                  "userid": "AteqY6CkOCNVmnQ17DNS34tR3uMzx00000000775"
                }
              }
            ],
            "relationships": [
              {
                "id": "14624",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "20803",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14625,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "22114",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "Jason",
                  "userid": "AwVsYzw0qMfpkO3TM6j7STcUkLWRO00000008684"
                }
              }
            ],
            "relationships": [
              {
                "id": "14625",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "22114",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14626,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "22277",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "杜潜",
                  "userid": "AXEeU08pona2csv4FvqBCiYF605Qf00000004366"
                }
              }
            ],
            "relationships": [
              {
                "id": "14626",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "22277",
                "properties": {}
              }
            ]
          }
        },
        {
          "row": [
            {}
          ],
          "meta": [
            {
              "id": 14627,
              "type": "relationship",
              "deleted": false
            }
          ],
          "graph": {
            "nodes": [
              {
                "id": "11825",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "王存平",
                  "userid": "A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752"
                }
              },
              {
                "id": "22618",
                "labels": [
                  "User"
                ],
                "properties": {
                  "name": "田建林PHP",
                  "userid": "AYcjhx1QeKsVnxn41orehpKo7RrCr00000001196"
                }
              }
            ],
            "relationships": [
              {
                "id": "14627",
                "type": "Friend",
                "startNode": "11825",
                "endNode": "22618",
                "properties": {}
              }
            ]
          }
        }
      ],
      "stats": {
        "contains_updates": false,
        "nodes_created": 0,
        "nodes_deleted": 0,
        "properties_set": 0,
        "relationships_created": 0,
        "relationship_deleted": 0,
        "labels_added": 0,
        "labels_removed": 0,
        "indexes_added": 0,
        "indexes_removed": 0,
        "constraints_added": 0,
        "constraints_removed": 0
      }
    }
  ],
  "errors": [],
  "responseTime": 25
}';
$str = json_decode($str,true);
$arr = $str['results'][0]['data'];
$nodes = $links = array();
foreach ($arr as $v){
	$nodeArr = $lineArr = array();
	if($v['meta'][0]['deleted'] === false){
		$nodeArr = $v['graph']['nodes'];
		$linkArr = $v['graph']['relationships'];
	}
	foreach ($nodeArr as $nodeV){
		$nodes[$nodeV['id']] = array('id'=>$nodeV['properties']['userid'],'name'=>$nodeV['properties']['name']);
	}
	foreach ($linkArr as $lineV){
		$links[] = array('start'=>$lineV['startNode'],'end'=>$lineV['endNode'],'name'=>$lineV['type']);
	}
}
?>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 600px;height:400px;"></div>
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
//                 	        text: '人物关系：乔布斯',
//                 	        subtext: '数据来自人立方',
//                 	        x:'right',
//                 	        y:'bottom'
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
                	        data:['家人','朋友']
                	    },
                	    series : [
                	        {
                	            type:'force',
                	            name : "人物关系",
                	            ribbonType: false,
                	            categories : [
                	                {
                	                    name: '人物'
                	                },
                	                {
                	                    name: '家人',
                	                    symbol: 'diamond'
                	                },
                	                {
                	                    name:'朋友'
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
                	            nodes:[
                	                {
                	                    category:0, name: '乔布斯', value : 10,
                	                    symbol: 'image://http://www.damndigital.com/wp-content/uploads/2010/12/steve-jobs.jpg',
                	                    symbolSize: [60, 35],
                	                    draggable: true,
                	                    itemStyle: {
                	                        normal: {
                	                            label: {
                	                                position: 'right',
                	                                textStyle: {
                	                                    color: 'black'
                	                                }
                	                            }
                	                        }
                	                    }
                	                },
                	                {category:1, name: '丽萨-乔布斯',value : 2},
                	                {category:1, name: '保罗-乔布斯',value : 3},
                	                {category:1, name: '克拉拉-乔布斯',value : 3},
                	                {category:1, name: '劳伦-鲍威尔',value : 7},
                	                {category:2, name: '史蒂夫-沃兹尼艾克',value : 5},
                	                {category:2, name: '奥巴马',value : 8},
                	                {category:2, name: '比尔-盖茨',value : 9},
                	                {category:2, name: '乔纳森-艾夫',value : 4},
                	                {category:2, name: '蒂姆-库克',value : 4},
                	                {category:2, name: '龙-韦恩',value : 1},
                	            ],
                	            links : [
                	                {source : '丽萨-乔布斯', target : '乔布斯', weight : 1, name: '女儿', itemStyle: {
                	                    normal: {
                	                        width: 10,
                	                        color: 'red'
                	                    }
                	                }},
                	                {source : '乔布斯', target : '丽萨-乔布斯', weight : 1, name: '父亲', itemStyle: {
                	                    normal: { color: 'red' }
                	                }},
                	                {source : '保罗-乔布斯', target : '乔布斯', weight : 2, name: '父亲'},
                	                {source : '克拉拉-乔布斯', target : '乔布斯', weight : 1, name: '母亲'},
                	                {source : '劳伦-鲍威尔', target : '乔布斯', weight : 2},
                	                {source : '史蒂夫-沃兹尼艾克', target : '乔布斯', weight : 3, name: '合伙人'},
                	                {source : '奥巴马', target : '乔布斯', weight : 1},
                	                {source : '比尔-盖茨', target : '乔布斯', weight : 6, name: '竞争对手'},
                	                {source : '乔纳森-艾夫', target : '乔布斯', weight : 1, name: '爱将'},
                	                {source : '蒂姆-库克', target : '乔布斯', weight : 1},
                	                {source : '龙-韦恩', target : '乔布斯', weight : 1},
                	                {source : '克拉拉-乔布斯', target : '保罗-乔布斯', weight : 1},
                	                {source : '奥巴马', target : '保罗-乔布斯', weight : 1},
                	                {source : '奥巴马', target : '克拉拉-乔布斯', weight : 1},
                	                {source : '奥巴马', target : '劳伦-鲍威尔', weight : 1},
                	                {source : '奥巴马', target : '史蒂夫-沃兹尼艾克', weight : 1},
                	                {source : '比尔-盖茨', target : '奥巴马', weight : 6},
                	                {source : '比尔-盖茨', target : '克拉拉-乔布斯', weight : 1},
                	                {source : '蒂姆-库克', target : '奥巴马', weight : 1}
                	            ]
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