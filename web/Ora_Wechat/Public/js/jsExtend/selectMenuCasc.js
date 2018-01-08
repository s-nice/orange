/**
 * 行业分类
 * cls_indust_one cls_indust_two
 * 调用方式：
 * 	//调用二级级联菜单
 * var dataIndust = {"1":{"id":1,"name":"\u65c5\u6e38 \u9910\u996e \u5a31\u4e50 \u4f11\u95f2 \u8d2d\u7269","children":[{"id":11,"name":"\u6d74\u573a"},{"id":12,"name":"\u4f11\u95f2\u5a31\u4e50"},{"id":13,"name":"\u65c5\u6e38\u3001\u5bbe\u9986"},{"id":14,"name":"\u9910\u996e "},{"id":15,"name":"\u4f53\u80b2\u3001\u82b1\u9e1f"},{"id":16,"name":"\u6587\u5316\u827a\u672f"},{"id":17,"name":"\u8d2d\u7269"},{"id":18,"name":"\u4f53\u80b2\u3001\u6587\u5a31\u7528\u54c1"},{"id":19,"name":"\u9152\u5e97\u3001\u53a8\u623f\u8bbe\u5907\u7528\u54c1"}]},"2":{"id":2,"name":"\u7eba\u7ec7 \u76ae\u9769 \u670d\u88c5 \u978b\u5e3d","children":[{"id":21,"name":"\u76ae\u9769\u3001\u6bdb\u76ae\u3001\u7fbd\u7ed2\u5236\u54c1"},{"id":22,"name":"\u978b\u5e3d"},{"id":23,"name":"\u7eba\u7ec7\u5370\u67d3"}]},"3":{"id":3,"name":"\u7535\u5b50\u7535\u5668 \u4eea\u5668\u4eea\u8868","children":[{"id":1,"name":"\u9632\u9759\u7535\u3001\u9632\u96f7\u3001\u9632\u7206\u53ca\u5f31\u7535\u5de5\u7a0b\u53ca\u8bbe\u5907"}]},"4":{"id":4,"name":"\u57ce\u5efa \u623f\u4ea7 \u5efa\u6750 \u88c5\u6f62","children":[]},"5":{"id":5,"name":"\u515a\u653f\u673a\u5173 \u793e\u56e2\u56e2\u4f53","children":[]},"6":{"id":6,"name":"\u65e5\u5e38\u670d\u52a1","children":[]},"7":{"id":7,"name":"\u8d38\u6613 \u6279\u53d1 \u5e02\u573a","children":[]},"8":{"id":8,"name":"\u51b6\u91d1 \u51b6\u70bc \u91d1\u5c5e\u53ca\u975e\u91d1\u5c5e\u5236\u54c1"},"9":{"id":9,"name":"\u77f3\u6cb9\u5316\u5de5 \u6a61\u80f6\u5851\u6599"},"10":{"id":10,"name":"\u65b0\u95fb \u51fa\u7248 \u79d1\u7814 \u6559\u80b2"}}; //行业下拉框数据
	CascMenusFn.init({data:dataIndust,callback1:callbackLevel1});
 */
var CascMenusFn = {
		data:null,
		objOne:null,  //一级菜单对象
		objTwo:null,  //二级菜单对象
		callback1:null, //一级下拉菜单回调函数
		callback2:null, //二级下拉菜单回调函数
		init:function(params){//初始化方法
			this.data = params.data || []; //一级、二级数据结构，是四维数组
			this.callback1 = params.callback1 || null; //一级菜单选择后回调函数1
			this.callback2 = params.callback2 || null; //二级菜单选择后回调函数2
			
			this.objOne = $('.cls_indust_one'); //一级最外层父对象
			this.objTwo = $('.cls_indust_two'); //二级最外层父对象
			this.event();			
			this.genLevelOneStruct(); //初始化一级数据结构
			
			this.objOne.children('ul').addClass('wgt_industry_ul_one cls_industry_close');
			this.objTwo.children('ul').addClass('wgt_industry_ul_two cls_industry_close');
		},
		event:function(){//给元素绑定事件
			var that = this;
			//绑定一级菜单相关事件
			$('.cls_indust_one_btn').on('click',function(){
				//that.objOne.find('.Industry_ul1_list').toggle();
				//that.objTwo.find('.Industry_ul2_list:visible').hide();
				//return false;
			});
			$('.Industry_ul1_list').on('click','li',function(e){
				var liObj = $(this);
				that.liAssignToOther(liObj,that.objOne);
				that.genLevelTwoStruct(liObj.attr('val'));
				that.callback1 && that.callback1(liObj); //回调函数
				//return false; //组织事件冒泡
			});
			
			//绑定二级菜单相关事件
			$('.cls_indust_two_btn').on('click',function(){
				//that.objTwo.find('.Industry_ul2_list').toggle();
				//that.objOne.find('.Industry_ul1_list:visible').hide();
				//return false;
			});
			
			$('.Industry_ul2_list').on('click','li',function(){
				var liObj = $(this);
				that.liAssignToOther(liObj,that.objTwo);
				that.callback2 && that.callback2(liObj); //回调函数
				//return false;
			});
			
			//点击页面其他区域关闭弹出层
			$(document).click(function(event){
				/*var e = event || window.event;   
			    var elem = e.srcElement||e.target;  
			   
			    while (elem) { //循环判断至跟节点，防止点击的是div子元素
			    	if($(elem).hasClass('cls_indust_one') ){
			    		 that.objTwo.find('ul').hide(); //若果二级弹出层是打开状态则关闭它
			    		return ;
			    	}
			    	if($(elem).hasClass('cls_indust_two')){
			    		  that.objOne.find('ul').hide(); //若果一级弹出层是打开状态则关闭它
			    		return ;
			    	}
			    	elem = elem.parentNode; 
			    }		
			    //若果点击的即非一级菜单，也非二级菜单，则两个弹出层都关闭
			    that.objOne.find('ul').hide();
			    that.objTwo.find('ul').hide();*/
				var obj = $(event.target);
				//if(obj.attr('id') == 'locationSearchBtn' || obj.parents('.cls_indust_one') || obj.hasClass('cls_indust_two')){
				//if(obj.attr('id') == 'locationSearchBtn' || obj.parents('.cls_indust_one') || obj.hasClass('cls_indust_two')){
					//return false;
				//}else{
					//$('.wgt_industry_ul_one,.wgt_industry_ul_two').hide();
					if(obj.parents('.cls_indust_one_btn').size()>0 || obj.hasClass('cls_indust_one_btn')){
						var objUl1 = $('.wgt_industry_ul_one');
						objUl1.is(':visible')?objUl1.hide():objUl1.show();
						
						var objUl2 = $('.wgt_industry_ul_two');
						objUl2.is(':visible')?objUl2.hide():'';
					}else if(obj.parents('.cls_indust_two_btn').size()>0 || obj.hasClass('cls_indust_two_btn')){
						var objUl2 = $('.wgt_industry_ul_two');
						objUl2.is(':visible')?objUl2.hide():objUl2.show();
						
						var objUl1 = $('.wgt_industry_ul_one');
						objUl1.is(':visible')?objUl1.hide():'';
					}else{
						var objUl1 = $('.wgt_industry_ul_one');
						objUl1.is(':visible')?objUl1.hide():'';
						var objUl2 = $('.wgt_industry_ul_two');
						objUl2.is(':visible')?objUl2.hide():'';
					}
				//}
				
			});
		},
		
		genLevelOneStruct:function(){//生成一级下拉菜单结构			
			var htmlArr = new Array('<li val="">'+this.objOne.find('em').attr('defaultVal')+'</li>');
			for(var i in this.data){
				var obj = this.data[i];
				htmlArr.push('<li val="'+obj.id+'" code="'+obj.code+'">'+obj.name+'</li>');
			}
			var htmlStr = htmlArr.join('');
			this.objOne.find('.Industry_ul1_list').html(htmlStr);
		},
		
		genLevelTwoStruct:function(id){//生成二级下拉菜单结构		
			var initHtml = ''; //<li val="">行业分类</li>
			var htmlArr = new Array();
			for(var i in this.data){
				if(this.data[i].id == id){
					if(typeof(this.data[i].children) == 'undefined' || !$.isArray(this.data[i].children)){
						break;
					}
					var objTwo = this.data[i].children;
					if(objTwo.length>0){
						var defaultVal = $('.cls_indust_two_btn').children().attr('defaultVal');
						htmlArr.push('<li val="" code="">'+defaultVal+'</li>');
						$.each(objTwo,function(i,item){
							htmlArr.push('<li val="'+item.id+'" code="'+item.code+'">'+item.name+'</li>');
						});
					}	
					break;
				}				
			}
			var htmlStr = htmlArr.length>0 ? htmlArr.join('') : initHtml;
			this.objTwo.find('.Industry_ul2_list').html(htmlStr);
			this.objTwo.find('em').html(this.objTwo.find('em').attr('defaultVal')).attr('val','');
		},
		liAssignToOther:function(obj,parentObj){//当点击li时，下拉菜单结构内部赋值操作,obj:当前被点击的li对象，parentObj最外层对象
			parentObj.find('em').html(obj.text()).attr('val',obj.attr('val'));
			parentObj.find('ul').hide(); //隐藏ul
		}
}