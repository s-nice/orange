/**
 * 功能： 表情控制插件
 * 作者： simon
 * 时间：2012.1.11
 * email：406400939@qq.com
 * 实现：
 * 	静态控制表情的显示
 * 	表情的展示应该有对一个的html dom树结构，如果不对应，很可能导致错误
 * 	一个holder中只能有一个textarea和一个trigger
 * 更改(2012.1.17):
 * 	正则优化
 */
$(function(){
	$.expBlock = {};
	var 
		//表情图片树的json格式
		EXP_DATA = [
					{
						name: '默认',
						icons:[
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f001.png",title:"f001"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f002.png",title:"f002"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f003.png",title:"f003"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f004.png",title:"f004"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f005.png",title:"f005"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f006.png",title:"f006"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f007.png",title:"f007"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f008.png",title:"f008"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f009.png",title:"f009"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f010.png",title:"f010"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f011.png",title:"f011"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f012.png",title:"f012"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f013.png",title:"f013"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f014.png",title:"f014"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f015.png",title:"f015"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f016.png",title:"f016"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f017.png",title:"f017"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f018.png",title:"f018"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f019.png",title:"f019"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f020.png",title:"f020"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f021.png",title:"f021"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f022.png",title:"f022"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f023.png",title:"f023"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f024.png",title:"f024"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f025.png",title:"f025"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f026.png",title:"f026"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f027.png",title:"f027"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f028.png",title:"f028"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f029.png",title:"f029"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f030.png",title:"f030"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f031.png",title:"f031"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f032.png",title:"f032"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f033.png",title:"f033"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f034.png",title:"f034"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f035.png",title:"f035"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f036.png",title:"f036"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f037.png",title:"f037"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f038.png",title:"f038"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f039.png",title:"f039"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f040.png",title:"f040"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f041.png",title:"f041"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f042.png",title:"f042"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f043.png",title:"f043"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f044.png",title:"f044"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f045.png",title:"f045"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f046.png",title:"f046"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f047.png",title:"f047"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f048.png",title:"f048"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f049.png",title:"f049"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f050.png",title:"f050"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f051.png",title:"f051"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f052.png",title:"f052"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f053.png",title:"f053"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f054.png",title:"f054"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f055.png",title:"f055"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f056.png",title:"f056"},
							{url:JS_PUBLIC+"/js/jsExtend/expression/js/plugins/exp/img/f057.png",title:"f057"}
						]
					}
				],
		//图片数组，用于表情从代号到图片的便捷转化
		IMGS_DATA = [],		
		//表情的控制参数
		expEnable = true,
		//配置
		config = {
			//用户表情结构数据
			expData: null,
			//包含textarea和表情触发的exp-holder
			holder: '.exp-holder',
			//exp-holder中的textarea输入dom，默认为textarea
			textarea : 'textarea',
			//触发dom
			trigger : '.exp-block-trigger',
			//每页显示表情的组数
			grpNum : 5,
			//位置相对页面固定(absolute)||窗口固定(fixed)
			posType : 'absolute',
			//表情层数
//			zIndex : '100'
		},
		//矫正插件位置偏离
		pos_correct_left = 30,
		//关闭triggerpos_correct_left
		exp_close_tri = '.exp-close',
		//group panel可容纳的最发group数量
		grp_num_per_panel = 1,
		win = window || document,
		bd = 'body';
	
	/**
	 * 初始化表情插件
	 */
	function init(cfg){
		//参数整合
		$.extend(config,cfg);
		//console.log(config.textarea.attr('index'));
		if(config.expData != null) EXP_DATA = config.expData;
		_getImgData();
		var triggers = cfg.trigger;
		triggers.each(function(){
			$(this).bind('click',function(){
                $(this).addClass('active').siblings('span').removeClass('active');
                if($('.OrangeShow_icon_box .picture').length>0){
                    $('.OrangeShow_icon_box .picture').removeClass('active');
                }
				//大量参数预定义,获取
				var me = $(this),
					holder = $(me.parents(config.holder)[0]),
					ta = cfg.textarea,
					exp = $(_genrt_html()),
					off = me.offset(), me_l = off.left - 50, me_t = off.top, me_w = me.width(), me_h = me.height(),
					exp_t = me_t + me_h, exp_l = me_l + (me_w + pos_correct_left)/2,
					exp_close = exp.find(exp_close_tri),
					exp_sub_tab = exp.find('.exp-sub-tab'), sub_tab_items = exp_sub_tab.children('.group-name'), sub_tab_pre = exp_sub_tab.find('.pre'),sub_tab_next = exp_sub_tab.find('.next'), curGroup = null,
					grpCnt = EXP_DATA.length,
					grpPgCnt = (function(){
						var p = Math.floor(grpCnt / config.grpNum);
						if(grpCnt % config.grpNum != 0){
							return p +1;
						}else{
							return p;
						}
					})(), curGrpPg = 1,
					expUl = exp.find('.exp-detail');
				console.log(ta.attr('index'));
				//功能函数准备	
				var 
					/**
					 * 显示第i组的表情
					 */
					showXGroupExp = function(i){
						var expList = '', listDOM;
						if(curGroup != null && curGroup != i){
							sub_tab_items.eq(curGroup).removeClass('slct');
							curGroup = i;
							sub_tab_items.eq(i).addClass('slct');
							sub_tab_items.eq(i).addClass('slct');
							for(var j = 0; j < EXP_DATA[i].icons.length; j++){
								expList += '<li action-data="['+EXP_DATA[i].icons[j].title+']"><img title="'+EXP_DATA[i].icons[j].title+'" alt="'+EXP_DATA[i].icons[j].title+'" src="'+EXP_DATA[i].icons[j].url+'"></li>';
							}
							listDOM = $(expList);
							//alert(listDOM.length);
							listDOM.each(function(){
								$(this).click(function(){
									var me = $(this), actData = me.attr('action-data'),taVal = ta.val();
									ta.val(taVal+actData);
									$(bd).unbind('click');
									me.unbind('mouseout');
									$(win).unbind('resize');
									exp.remove();
								});
							});
							expUl.children().remove();
							expUl.append(listDOM);
						}
						else if(curGroup == null){
							curGroup = i;
							sub_tab_items.eq(i).addClass('slct');
							for(var j = 0; j < EXP_DATA[i].icons.length; j++){
								expList += '<li action-data="['+EXP_DATA[i].icons[j].title+']"><img title="'+EXP_DATA[i].icons[j].title+'" alt="'+EXP_DATA[i].icons[j].title+'" src="'+EXP_DATA[i].icons[j].url+'"></li>';
							}
							listDOM = $(expList);
							//alert(listDOM.length);
							listDOM.each(function(){
								$(this).click(function(){
									var me = $(this), actData = me.attr('action-data'),taVal = ta.val();
                                    if(taVal == '请输入你要发布的内容'){
                                        taVal = '';
                                    }
									ta.val(taVal+actData);
									$(bd).unbind('click');
									me.unbind('mouseout');
									$(win).unbind('resize');
									exp.remove();
                                    $(config.trigger).removeClass('active');
								});
							});
							expUl.children().remove();
							expUl.append(listDOM);
						}else if(curGroup !=null && curGroup == i){
						}
					},
					/**
					 * 显示第i页的group
					 */
					showGrp = function(i){
						var range = {};
						range.left = (i-1)*config.grpNum;
						range.left = Math.max(0,range.left);
						range.right = (i)*config.grpNum - 1;
						range.right = Math.min(range.right,grpCnt-1);
						sub_tab_items.hide();
						for(var j = range.left; j <= range.right; j++){
							sub_tab_items.eq(j).show();
						}
						curGrpPg  = i;
						
						
						if(curGrpPg == 1){
							sub_tab_pre.addClass('pre-disable');
						}
						else{
							sub_tab_pre.removeClass('pre-disable');
						}
						if(curGrpPg >= grpPgCnt){
							sub_tab_next.addClass('next-disalbe');
						}
						else{
							sub_tab_next.removeClass('next-disalbe');
						}
						
					};
					
				if(config.posType == 'fixed'){
					me_t = off.top - $(win).scrollTop();
					exp_t = me_t + me_h;
				}

				//如果允许表情
				if(expEnable){
					//确定表情插件的位置
					exp.css({position: config.posType, zIndex: config.zIndex, left:exp_l+'px', top: exp_t+'px'});
					//窗口重置时重新调整插件位置
					$(win).resize(function(){
						off = me.offset(), me_l = off.left - 50, me_t = off.top;
						exp_t = me_t + me_h, exp_l = me_l + (me_w + pos_correct_left)/2;
						exp.css({left:exp_l+'px', top: exp_t+'px'});
					});
					
					/*各种事件绑定*/
					
					//关闭X事件
					exp_close.click(function(){
						$(bd).unbind('click');
						me.unbind('mouseout');
						$(win).unbind('resize');
						exp.remove();
                        $(".biaoqing ").removeClass('active');

					});
					
					//trigger的鼠标移出事件（点击之后就删除）
					me.mouseout(function(){
						$(bd).click(function(e){
							var clickDOM = $(e.target);
							var a = clickDOM.parents('.exp-layer');
							if(!a.hasClass('exp-layer')){
								exp.remove();
								$(".biaoqing ").removeClass('active');
								$(bd).unbind('click');
								me.unbind('mouseout');
								$(win).unbind('resize');
							}
						})
					});
					
					showGrp(1);
					//设置group—panel的翻页切换事件
					sub_tab_pre.click(function(){
						var p = curGrpPg -1, rg;
						p = (p < 1)?1 : p;
						showGrp(p);
						
					});
					sub_tab_next.click(function(){
						var p = curGrpPg + 1, rg;
						p = (p > grpPgCnt)? curGrpPg : p;
							showGrp(p);
						
					})
					
					//默认打开第一组表情
					showXGroupExp(0);
					//group点击事件
					sub_tab_items.each(function(){
						$(this).click(function(){
							var me = $(this), groupIndex = me.attr('grp-index');
							showXGroupExp(groupIndex);
						});
					});
					
					
					//往页面插入dom
					$('body').append(exp);
					exp.show();
                    if(config.textarea == '#publishContent'){
                        $('#OrangeShow_iconbox .OrangeShow_icon_pic').hide();
                        swfu.setButtonDisabled(false);
                    }

				}
			});
		})
	}
	/**
	 * 使所有的添加了表情触发类的click事件在表情上失效
	 */
	function disableExp(){
		expEnable = false;
	}
	/**
	 * 重新启用表情
	 */
	function enableExp(){
		expEnable = true;
	}
	/**
	 * 获取远程表情的数据结构，必须返回符合规定数据格式的json数据，ajax形式传入
	 * 数据格式如：[{name: groupname,icons:[{url:'imgurl',title:"iconname"},{url:'imgurl',title:"iconname"}]},{name: groupname,icons:[{url:'imgurl',title:"iconname"},{url:'imgurl',title:"iconname"}]},...]
	 */
	function getRemoteNewExp(data_url){
		$.ajax({
			url: data_url,
			success : function(data){
				EXP_DATA = eval(data);
				_getImgData();
			},
			error: function(){
				('error url');
			}
		})
	}
	
	/**
	 * 将字符串中的表情代号以图片标签代替
	 */
	function textFormat(str){
		var reg = /\[([^\]\[\/ ]+)\]/g,
			src = str,
			rslt,
			temp;
		_getImgData();
		while(temp =reg.exec(src)){
			var s = _switchImg(temp[1]),
				creg,
				t =  "\\[("+temp[1]+")\\]" ; 
			creg = new RegExp(t,"g");
			if(src.match(temp[0]) && s != temp[1]){
				src = src.replace(creg,s);
			}
		}
		return src;	
	}
	//私有函数
	
	/**
	 * 生成表情的html代码
	 */
	function _genrt_html(){
		var html = '<div class="exp-layer"><div class="holder"><div class="content"><div class="exp-tab clearfix"><a href="javascript:;">常用表情</a></div><div class="exp-sub-tab clearfix">';
		for(var i = 0; i < EXP_DATA.length; i++){
			
				html += '<a class="group-name" grp-index="'+i+'" href="javascript:;">'+ EXP_DATA[i].name+'</a>';
		}
		html += '<div class="sub-tab-pagination"><a class="pre"></a><a class="next"></a></div></div><ul class="exp-detail clearfix">';
		/*
		for(var j = 0; j < EXP_DATA[0].icons.length; j++){
					html += '<li action-data="['+EXP_DATA[0].icons[i].title+']"><img title="'+EXP_DATA[0].icons[i].title+'" alt="'+EXP_DATA[0].icons[i].title+'" src="'+EXP_DATA[0].icons[i].url+'"></li>';
				}*/
		
		html +='</ul></div><a class="exp-close" href="javascript:;"></a></div><a class="exp-tri" href="javascript:;"></a></div>';
		return html;
	}
	
	/**
	 * 图片转换，目的是将表情代号转化成图片地址
	 * 如:[微笑] == > <img src='smile.png' />
	 */
	function _switchImg(str){
		for(var i = 0; i < IMGS_DATA.length; i++){
			if(IMGS_DATA[i].title == str){
				return '<img src="'+IMGS_DATA[i].url+'" width="20" height="20" />';
			}
		}
		return str;
	}
	
	/**
	 * 集中生成图片数据,根据EXP_DATA生成提取里面的图片数组
	 */
	function _getImgData(){
		for(var i = 0 ; i < EXP_DATA.length; i++){
			IMGS_DATA.push(EXP_DATA[i].icons);
			for(var j = 0; j < EXP_DATA[i].icons.length; j++){
				IMGS_DATA.push(EXP_DATA[i].icons[j]);
			}
		}
	}
		
	//扩展到jquery
	$.expBlock = {
			initExp : init,
			disableExp : disableExp,
			enableExp : enableExp,
			getRemoteExp : getRemoteNewExp,
			textFormat : textFormat
	};

})
