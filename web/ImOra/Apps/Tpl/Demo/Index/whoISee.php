<layout name="Layout" />
<script src="__PUBLIC__/js/jsExtend/echart/cytoscape.js"></script>
<!-- 好友 star -->
<div class="warp_tongs">
	<div><span><a href="{:U('/Demo/Index/whoISee','','',true )}">列表图</a></span>|<span><a href="{:U('/Demo/Index/whoISee',array('st'=>'relation'),'',true )}">关系图</a></span></div>
     <if condition="$showType eq 'list'">
    <empty name="list" >
        <div class="nodata_div"><h1>交几个朋友吧。</h1></div>
    <else />
        <foreach name="list" item="val">
            <div class="warp_tongs_list js_report_click" userId="{:$_SESSION[MODULE_NAME]['clientid']}" vcardId="{$val['vcardid']}" cardOwnerId="{$val['useid']}">
                <div class="warp_tongs_pic"><img src="{$val['picture']}" srca="{$val['picpatha']}" srcb="{$val['picpathb']}" /></div>
                <div class="warp_mask maskanimation"></div>
                <div class="warp_tongs_text warp_tongs_animation">
                    <span class="check_card_time" >{:date('Y-m-d H:i:s', $val['createtime'])} &nbsp;</span>
                    <span><i>{$val['FN']|mb_substr=###,0,11,'utf-8'}</i><em>{$val['TITLE']|mb_substr=###,0,18,'utf-8'}</em></span>
                    <p>{$val['ORG']|mb_substr=###,0,35,'utf-8'}</p>
                    <p>{$val['ADR']|mb_substr=###,0,16,'utf-8'}</p>
                </div>
              <if condition="$val['clientid'] neq ''">
              <!-- 标明是系统用户， 显示头像 -->
                <div class="thumb_icon"></div>
              </if>
            </div>
        </foreach>
    </empty>
    <else/>
    <!-- 展示关系图div层 -->
    <div id="cy" class="main"	style="	width: 100%;height:1000px;display: white;">
    	<style>
			.pop_position{left:; top:; width:200px; height:150px; background:gray; color:#fff; z-index:333333;position:relative;}
		</style>
    </div>
    </if>
    <div class="clear"></div>
    <!-- 翻页效果引入 -->
    <include file="@Layout/pagemain" />
</div>
<!-- 好友 end -->
<if condition="$showType eq 'relation'">
<script>
   var selfId = "{$Think.session.Demo.clientid}";
   var getAvatarUrl = "{:U('Demo/Index/getAvatar','','',true)}";
   var getCardUrl = "{:U('Demo/Index/getCardImage','','',true)}";
   var nodes = {$nodes};
   var links = {$links};

   document.addEventListener('DOMContentLoaded', function(){
	   var style = [
	                 { selector: 'node[type="Company"]',  //设置通用的节点
	                    css: { 'content': 'data(name)','shape':'octagon'}//,'background-color': '#00ffcc','background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'
	                 },
	                 { selector: 'node[type="User"]',  //设置通用的节点
		                    css: { 'content': 'data(show)'}//,'background-color': '#00ffcc','background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'
		                 },
	                 { selector: 'node[type = "Card"]',
	                   css: {'background-color': '#F5A45D', 'content': 'data(name)','shape':'roundrectangle','height':'60','width':'100'}
	                 },
	                 { selector: 'edge',
	                   css: {'content': 'data(relationship)', 'target-arrow-color': 'gray','target-arrow-shape': 'triangle','line-color':'data(faveColor)','target-arrow-color': 'data(faveColor)','line-style':'sold','curve-style': 'bezier'},
	                  // style: {	'width': 4,	'target-arrow-shape': 'triangle','line-color': '#9dbaea','target-arrow-color': '#9dbaea','curve-style': 'bezier'}
	                 }/* ,
	                 { selector: 'edge.SeeCard',
		               style: {'line-color':'data(faveColor)','line-style':'dotted','source-arrow-color':'data(faveColor)', 'target-arrow-color': 'data(faveColor)'},
		             },
	                 { selector: 'edge.SeeUser',
			               style: {'line-color':'data(faveColor)','line-style':'dotted'},
			             }     */
	               ];


		 getAvatarUrl = getAvatarUrl.replace('.html','');
/* 		 for(var i in nodes){
			 var cssObjPerson = {'border-width':'3','border-style':'dotted','content': 'data(name)', 'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg','width':30,'hight':30};
			 var cssObjCom = {'border-width':'5','border-color': 'red','border-style':'double','content': 'data(name)'}; //background-color
			 var cssObjCard = {'border-width':'1','border-color': 'sandy beige', 'content': 'data(name)'};

			 var type = nodes[i]['data']['type']
	         var userid = nodes[i]['data']['userid'];
	         var id = nodes[i]['data']['id'];

	         if(typeof(userid) != 'undefined'){
	        	 cssObjPerson['background-image'] = getAvatarUrl+'/clientid/'+userid+'/t/'+Math.random();
	        	 style.push({selector: '#'+id, css: cssObjPerson});
	         }else if(type == 'Company'){
	        	 style.push({selector: '#'+id, css: cssObjCom});
	          }else if(type == 'Card'){
	        	  cssObjCard['background-image'] = getCardUrl+'/cardid/'+nodes[i]['data']['cardid']+'/t/'+Math.random();
	        	  style.push({selector: '#'+id, css: cssObjCard});
	          }
		  } */

   var cy = cytoscape({
       container: document.getElementById('cy'),
       minZoom: 0,
       maxZoom: 4,
       style: style,
       elements: {
         nodes: nodes,
         edges: links
       } ,
      // layout: { name: 'cose', fit: true} //circle cose preset spread
      /*  layout: {
           name: 'concentric',
           concentric: function( node ){
             return node.degree();
           },
           levelWidth: function( nodes ){
             return 2;
           }
         }, */
         layout: {
             name: 'cose',
             idealEdgeLength: 100,
             nodeOverlap: 20
           },
     //  layout: { name: 'breadthfirst',  directed: true, padding: 10}  //立体效果
     });
   //绑定事件
   cy.on('tap', 'node', function(evt){
	   var node = evt.cyTarget;
	   //console.log( 'tapped ' + node.id(),node.data(),node.css()); console.log( evt.cyTarget,evt.cyTarget._private.data );
	   var src = node.css('background-image')
	   showMsgImg(src);
	 }).on('mouseover','node[type="User"]', function(evt){/*[type="User"]*/
		 var obj = evt.cyTarget;
		 var data = obj.data();
		 var pos = obj.renderedPosition();
		 var content = '<div>姓名：'+data.name+'</div><div>公司：'+data.company+'</div><div>职位：'+data.title+'</div>';
		 if($('.pop_position').size()==0){
			 var html='<div class="pop_position">'+content+'</div>';
			 $('#cy').children('div').append(html);
		 }else{
			 $('#cy').find('.pop_position').html(content).show();
		 }
		 $('.pop_position').css({left:pos.x,'top':pos.y});
	 }).on('mouseout', 'node',function(evt){
		  $('.pop_position').hide();
	 });

	 getAvatarUrl = getAvatarUrl.replace('.html','');
	 getCardUrl = getCardUrl.replace('.html','');
	 for(var i in nodes){/*'border-style':'dotted',*/
	     var cssObjPerson = {'border-width':'2','content': 'data(name)', 'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg','width':80,'height':80, 'font-size':12};
	     var cssObjCom = {'border-width':'5','border-color': 'red','border-style':'double','content': 'data(name)'}; //background-color
	     var cssObjCard = {'border-width':'1','border-color': 'sandy beige', 'content': 'data(name)'};
		 var type = nodes[i]['data']['type']
         var userid = nodes[i]['data']['userid'];
         var id = nodes[i]['data']['id'];

         if (userid == selfId) {
        	 cssObjPerson = {'border-color': 'red','border-width':'2','content': 'data(name)', 'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg','width':120,'height':120, 'font-size':12};
         }

         if(typeof(userid) != 'undefined'){/*头像*/
        	 cssObjPerson['background-image'] = getAvatarUrl+'/clientid/'+userid;
        	 cy.style().selector('#'+id).css(cssObjPerson).update();
         }else if(type == 'Company'){/*公司*/
        	 cy.style().selector('#'+id).css(cssObjCom).update();
          }else if(type == 'Card'){/*名片*/
        	 // cssObjCard['background-image'] = getCardUrl+'/cardid/'+nodes[i]['data']['cardid'];
        	 // cy.style().selector('#'+id).css(cssObjCard).update();
        	   //$.get(getCardUrl,{cardid:nodes[i]['data']['cardid']}, function(imgPath){
            	   /* return function(imgPath){
        		     cssObjCard['background-image'] = imgPath;
        		 	 cy.style().selector('#'+id).css(cssObjCard).update();
            	   } */

            	   /* (function(){
                       return function(){
                    	   cssObjCard['background-image'] = imgPath;
                    	   cy.style().selector('#'+id).css(cssObjCard).update();
                       }
                   })(); */
        		  /*  cssObjCard['background-image'] = imgPath;
        		 	 cy.style().selector('#'+id).css(cssObjCard).update(); */
        		//},'text');

        	var explorer =navigator.userAgent;//获取浏览器类型
          	if (explorer.indexOf("MSIE") >=0){/*ie*/
            	  $.ajax({
             		   type: "GET",
             		   url: getCardUrl,
             		   data: {cardid:nodes[i]['data']['cardid']},
             		   dataType:'text',
                		async: false,
             		   success: function(imgPath){
                			cssObjCard['background-image'] = imgPath;
                		 	 cy.style().selector('#'+id).css(cssObjCard).update();
             		   }
             		});
          	}else if (explorer.indexOf("Firefox") >= 0) {/*firefox*/
              	 cssObjCard['background-image'] = getCardUrl+'/cardid/'+nodes[i]['data']['cardid'];
              	 cy.style().selector('#'+id).css(cssObjCard).update();
          	}else if(explorer.indexOf("Chrome") >= 0){	/*Chrome*/
            	  $.ajax({
           		   type: "GET",
           		   url: getCardUrl,
           		   data: {cardid:nodes[i]['data']['cardid']},
           		   dataType:'text',
              		async: false,
           		   success: function(imgPath){
              			cssObjCard['background-image'] = imgPath;
              		 	 cy.style().selector('#'+id).css(cssObjCard).update();
           		   }
           		});
          	}else{
            	  $.ajax({
           		   type: "GET",
           		   url: getCardUrl,
           		   data: {cardid:nodes[i]['data']['cardid']},
           		   dataType:'text',
              	   async: false,
           		   success: function(imgPath){
              			cssObjCard['background-image'] = imgPath;
              		 	 cy.style().selector('#'+id).css(cssObjCard).update();
           		   }
           		});
          	}
          }

         //
	  }

   });

    </script>
</if>
