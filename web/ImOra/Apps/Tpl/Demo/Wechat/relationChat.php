<!DOCTYPE html>
<html lang="en" style="width:100%;height:100%;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>关系图</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="__PUBLIC__/js/jsExtend/echart/cytoscape-context-menus.css?v={:C('WECHAT_APP_VERSION')}"
	rel="stylesheet" type="text/css" />
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jsExtend/echart/cytoscape.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jsExtend/echart/cytoscape-context-menus.js?v={:C('WECHAT_APP_VERSION')}"></script>

</head>
<body style="background-color: white;width:100%;height:100%;">
<div><a href="{:U(MODULE_NAME.'/Wechat/touchDirection','','',true)}">测试滑动方向使用</a></div>
<div id="cy" class="main"
	style="	width: 100%;
	height: 90%;"></div>

<script>
   var getAvatarUrl = "{:U('Demo/Index/getAvatar')}";
   var nodes = [
                {data: {id: '172', name: 'Tom Cruise', label: 'Human'}},{data: {id: '183', title: 'Top Gun', label: 'Company'}},
                {data: {id: '1', title: 'title1', label: 'Company',name:'张三'}},//,parent:'5'表示画一个区域
                {data: {id: '2', title: 'title2', label: 'Company'}},{data: {id: '3', title: 'title3', label: 'Company'}},{data: {id: '4', title: 'title4', label: 'Company'}},
                {data: {id: '5', title: 'title5', label: 'Company'}}
              ];
   var links =  [
                 {data: {source: '172', target: '183', relationship: 'Acted_In'}},{data: {source: '1', target: '183', relationship: 'ActIn1'}},
                 {data: {source: '2', target: '183', relationship: 'Ac_In2'}},
                 {data: {source: '3', target: '183', relationship: 'ActIn3'}},{data: {source: '4', target: '183', relationship: 'ActIn4'}},
                 {data: {source: '5', target: '183', relationship: 'ActIn5'}},{data: {source: '1', target: '3', relationship: '1-3'}},{data: {source: '1', target: '2', relationship: '1-2'}},
              ];
   var nodes = {$nodes};
   var links = {$links};

   $(function(){
	   var style =  [
	                 { selector: 'node',  //设置通用的节点
	                     css: { 'content': 'data(name)','text-valign': 'center'}//,'background-color': '#00ffcc','background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'
	                   },
	                  { selector: 'node[label = "Human"]', //对人进行设置
	                    css: {'background-color': '#F67A52','width':'50','height':'50','font-size':'12','color':'#fff', 'content': 'data(name)'}
	                  },
	                 /*  { selector: '#13729', //对单个进行设置
	                      css: {'background-color': '#6FB1FC', 'content': 'data(name)', 'background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'}
	                  },
	                  { selector: '#21023', //对单个进行设置
	                      css: {'background-color': '#6FB1FC', 'content': 'data(name)', 'background-image': 'https://farm4.staticflickr.com/3063/2751740612_af11fb090b_b.jpg'}
	                  }, */
	                  { selector: 'node[label = "Company"]', //对公司进行设置
	                    css: {'background-color': '#46A2D2','width':'80','height':'80','font-size':'14', 'content': 'data(name)', 'text-wrap':'wrap','color':'#fff'}
	                  },
	                  { selector: 'edge',
	                    css: {'content': 'data(relationship)', 'target-arrow-color': 'gray','target-arrow-shape': 'triangle','line-color':'green','line-style':'sold','curve-style': 'bezier','width':'1px'},
	                  }
	                ];

		 var cssObjPerson = {'border-width':'3','border-style':'dotted','content': 'data(name)', 'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg','width':30,'hight':30};
		 var cssObjCom = {'border-width':'5','border-color': 'red','border-style':'double','content': 'data(name)'}; //background-color
		 var cssObjCard = {'border-width':'1','border-color': 'sandy beige', 'content': 'data(name)'};
		 getAvatarUrl = getAvatarUrl.replace('.html','');
/* 		 for(var i in nodes){
			 var type = nodes[i]['data']['type']
	         var userid = nodes[i]['data']['userid'];
	         var id = nodes[i]['data']['id'];

	         if(typeof(userid) != 'undefined'){
	        	 cssObjPerson['background-image'] = getAvatarUrl+'/clientid/'+userid;
	        	 style.push({selector: '#'+id, css: cssObjPerson});
	         }else if(type == 'Company'){
	        	 style.push({selector: '#'+id, css: cssObjCom});
	          }else if(type == 'Human'){
	        	 style.push({selector: '#'+id, css: cssObjCard});
	          }
		  } */
		//  console.log(style)
			for(var i in links){
				var clsName = links[i]['classes'];
				 style.push({selector: 'edge.'+clsName, css: {'line-color':links[i]['data']['color']}});
			}

	 cy = cytoscape({
	       container: document.getElementById('cy'),
	       minZoom: -1,
	       maxZoom: 4,
	       style: style,
	       elements: {
	         nodes: nodes,
	         edges: links
	       } ,
	       layout: { name: 'cose', fit: true} //circle cose preset spread
	     //  layout: { name: 'breadthfirst',  directed: true, padding: 10}  //立体效果
	     });
	   });

    </script>
</body>
</html>