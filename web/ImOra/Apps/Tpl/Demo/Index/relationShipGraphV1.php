<layout name="Layout" />
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="__PUBLIC__/js/jsExtend/echart/cytoscape-context-menus.css"
	rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/js/jsExtend/echart/cytoscape.js"></script>
<script src="__PUBLIC__/js/jsExtend/echart/cytoscape-context-menus.js"></script>

<div id="cy" class="main"
	style="	width: 1000px;
	height: 800px;
	display: block;"></div>

<script>
   var getAvatarUrl = "{:U('Demo/Index/getAvatar')}";
   var nodes = {$nodes};
   var links = {$links};

   //document.addEventListener('DOMContentLoaded', function(){
   $(function(){
	   var style =  [
	                 { selector: 'node',  //设置通用的节点
	                     css: { 'content': 'data(name)'}//,'background-color': '#00ffcc','background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'
	                   },
	                  { selector: 'node[label = "Person"]', //对单个进行设置
	                    css: {'background-color': '#6FB1FC', 'content': 'data(name)'}
	                  },
	                  { selector: '#13729', //对单个进行设置
	                      css: {'background-color': '#6FB1FC', 'content': 'data(name)', 'background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'}
	                  },
	                  { selector: '#21023', //对单个进行设置
	                      css: {'background-color': '#6FB1FC', 'content': 'data(name)', 'background-image': 'https://farm4.staticflickr.com/3063/2751740612_af11fb090b_b.jpg'}
	                  },
	                  { selector: 'node[label = "Movie"]', 
	                    css: {'background-color': '#F5A45D', 'content': 'data(title)'}
	                  },
	                  { selector: 'edge', 
	                    css: {'content': 'data(relationship)', 'target-arrow-color': 'gray','target-arrow-shape': 'triangle','line-color':'gray','line-style':'sold','curve-style': 'bezier'},
	                  }    
	                ];

		 var cssObjPerson = {'border-width':'3','border-style':'dotted','content': 'data(name)', 'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg','width':30,'hight':30};
		 var cssObjCom = {'border-width':'5','border-color': 'red','border-style':'double','content': 'data(name)'}; //background-color
		 var cssObjCard = {'border-width':'1','border-color': 'sandy beige', 'content': 'data(name)'};
		 getAvatarUrl = getAvatarUrl.replace('.html','');
		 for(var i in nodes){
			 var type = nodes[i]['data']['type']
	         var userid = nodes[i]['data']['userid'];
	         var id = nodes[i]['data']['id'];
	        
	         if(typeof(userid) != 'undefined'){
	        	 cssObjPerson['background-image'] = getAvatarUrl+'/clientid/'+userid;
	        	 style.push({selector: '#'+id, css: cssObjPerson});
	         }else if(type == 'Company'){
	        	 style.push({selector: '#'+id, css: cssObjCom});
	          }else if(type == 'Card'){
	        	 style.push({selector: '#'+id, css: cssObjCard});
	          }
		  }
		  console.log(style)
		  
 cy = cytoscape({
       container: document.getElementById('cy'),
       minZoom: 1,
       maxZoom: 4,
       style: style,
       elements: {
         nodes: nodes/* [
           {data: {id: '172', name: 'Tom Cruise', label: 'Person'}},{data: {id: '183', title: 'Top Gun', label: 'Movie'}},
           {data: {id: '1', title: 'title1', label: 'Movie1'}},//,parent:'5'表示画一个区域
           {data: {id: '2', title: 'title2', label: 'Movie2'}},{data: {id: '3', title: 'title3', label: 'Movie3'}},{data: {id: '4', title: 'title4', label: 'Movie4'}},
           {data: {id: '5', title: 'title5', label: 'Movie5'}}
         ] */,
         edges: links/* [
                 {data: {source: '172', target: '183', relationship: 'Acted_In'}},{data: {source: '1', target: '183', relationship: 'ActIn1'}},
                 {data: {source: '2', target: '183', relationship: 'Ac_In2'}},
                 {data: {source: '3', target: '183', relationship: 'ActIn3'}},{data: {source: '4', target: '183', relationship: 'ActIn4'}},
                 {data: {source: '5', target: '183', relationship: 'ActIn5'}},{data: {source: '1', target: '3', relationship: '1-3'}},{data: {source: '1', target: '2', relationship: '1-2'}},
              ] */
       } ,
       layout: { name: 'cose', fit: true} //circle cose preset spread
     //  layout: { name: 'breadthfirst',  directed: true, padding: 10}  //立体效果
     });

    rightMenu(cy);
    bindEvt(cy);
   });

  
   function bindEvt(cy){
	   cy.on('mousedown', function(event){
		   // cyTarget holds a reference to the originator
		   // of the event (core or element)
		   var evtTarget = event.cyTarget;

		   if( evtTarget === cy ){
		       console.log('tap on background');
		   } else if(evtTarget.group() == 'nodes'){
		     console.log('tap on some element # nodes');
		   }else if(evtTarget.group() == 'edges'){/*evtTarget.isEdge()*/
			 console.log('tap on some element # edges'); 
		   } 
	   });
	}
   //鼠标右键菜单
   function rightMenu(cy){
  	 var selectAllOfTheSameType = function(ele) {
  		 cy.elements().unselect();
  		 if(ele.isNode()) {
  			 cy.nodes().select();
  		 }
  		 else if(ele.isEdge()) {
  			 cy.edges().select();
  		 }
  	 };
  	cy.contextMenus({
  		  menuItems: [
  			  {
  				  id: 'remove',
  				  title: 'remove',
  				  selector: 'node, edge',
  				  onClickFunction: function (event) {
  					event.cyTarget.remove();
  					console.log(event.cyTarget,event.cyTarget._private.data.id, event.cyTarget.group());
  				  },
  				  hasTrailingDivider: true
  				},
  				{
  				  id: 'hide',
  				  title: 'hide',
  				  selector: '*',
  				  onClickFunction: function (event) {
  					event.cyTarget.hide();
  				  },
  				  disabled: false
  				},
  				{
  				  id: 'add-node',
  				  title: 'add node',
  				  coreAsWell: true,
  				  onClickFunction: function (event) {
  					var data = {
  						group: 'nodes'
  					};
  					
  					cy.add({
  						data: data,
  						position: {
  							x: event.cyPosition.x,
  							y: event.cyPosition.y
  						}
  					});
  				  }
  				},
  				{
  				  id: 'remove-selected',
  				  title: 'remove selected',
  				  coreAsWell: true,
  				  onClickFunction: function (event) {
  					cy.$(':selected').remove();
  				  }
  				},
  				{
  				  id: 'select-all-nodes',
  				  title: 'select all nodes',
  				  selector: 'node',
  				  onClickFunction: function (event) {
  					selectAllOfTheSameType(event.cyTarget);
  				  }
  				},
  				{
  				  id: 'select-all-edges',
  				  title: 'select all edges',
  				  selector: 'edge',
  				  onClickFunction: function (event) {
  					selectAllOfTheSameType(event.cyTarget);
  				  }
  				}
  			  ]
  	   });
  }
    </script>

