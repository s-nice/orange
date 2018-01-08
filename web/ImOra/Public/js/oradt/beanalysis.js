/**
 * 行为分析  “我” “橙秀” “搜索” “文件共享”模块js
 * Created by zhuxl on 2016-02-23.
 */
;(function($){
    $.extend({
        //初始化
        beanalysis: {
            init: function () {
                this.allClick();//初始化页面中的点击事件
                
                //搜索页面的系统平台 和 产品版本 联动
                if (typeof(searchPage)!='undefined'){
                	new $.selectLinkage({
        				selectors : ['#js_selectIOS li', '#js_productversionul li'], // 联动的数据项
        				prevAttr  : 'val', // 用于计算联动的上一级属性
        				nextAttr  : 'data-link-value', // 用户计算联动的下一级属性
        				listenEvent: 'click', // 需要监听的事件名称，如 click。 如果不需要监听事件， 留空
        				activeClass: 'on',     // 项目为选定状态时的class
        				eventBindActiveClass: false  // 是否在事件激发时， 将 activeClass绑定。 如果绑定， 将 添加/取消 activeClass
                	});
                }
            },

            allClick:function(){
                //对比时段弹框显示隐藏
                $('#js_contrast').on('click',function(){
                    var sel_obj = $('#js_time_duibi');
                    if(sel_obj.is(':visible')){
                        sel_obj.hide();
                    }else{
                        sel_obj.show();
                    }
                });
                //点击发起对比按钮
                $('#js_contrast_time').on('click',function(){
                    var con_starttime = $('#js_begintime1').val();
                    if(con_starttime ==''){ //先判断对比时段的开始时间是否填写
                        $.global_msg.init({gType:'warning',icon:2,msg:jsInsertContrastTime});
                        return;
                    }
                    //组装跳转链接  拼接参数
                    jsSearchLink = $.beanalysis.getCondition();
                    location.href = jsSearchLink;
                });
                //平台下拉框显示 隐藏事件      ----注：如果是“我”模块的名片模板使用数和主题类型使用数搜索  去除平台事件
                if(jssecondselect == jsCardTempUseNum || jssecondselect == jsCardThemeUseNum){
                	$('#js_selectIOS input').off().css('color','#999');
                	$('#js_selectIOS i').off();
                	$('#js_begintime').off().css('color','#999').next().hide();
                }

                //点击选中某平台事件
                $('#js_selectIOSul').on('click','li',function(){
                    var sel_obj = $('#js_selectIOSul');//下拉框
                    var sel_title = $(this).attr('title');
                    var sel_txt = $(this).html();
                    $('#js_selectIOS input').val(sel_txt);
                    $('#js_selectIOS input').attr('seltitle',sel_title);
                    $('#js_selectIOS input').attr('title',sel_txt);
                    sel_obj.hide();
                });
                
                //选择某版本
                $('#js_productversionul').on('click','li',function(){
                	var arr=[];
                	var items='';
                	var title='';
                	$('#js_productversionul li[class="on"]').each(function(){
                		arr.push($(this).attr('val'));
                	})
                	items = arr.join(',');
                	title = arr.join(',');
                	if (items==''){
                		items = $('#js_productversionul li:first').attr('val');
                		title = '';
                	}
                	$('#js_productversion').val(items);
                    $('#js_productversion').attr('title',title);
                });

                //具体查询选择类型
                $('#js_secondselectul').on('click','li',function(){
                    $('#js_secondselectul').hide();
                    var selecttype = $(this).attr('title');
                    $('#js_secondselect').val(selecttype);
                    jsSearchLink = $.beanalysis.getCondition(selecttype);
                    if(jsSearchLink == 'false' || jsSearchLink == false){
                        return;
                    }
                    location.href = jsSearchLink;
                });
                //点击查询按钮
                $('#js_search').on('click',function(){
                    jsSearchLink = $.beanalysis.getCondition();
                    if(jsSearchLink == 'false' || jsSearchLink == false){
                        return;
                    }
                    //某一个日期为空，则不能提交
                    if ($.trim($('#js_begintime').val())=='' || $.trim($('#js_endtime').val())==''){
                    	$.global_msg.init({gType:'warning',icon:2,msg:tip_select_time});
                    	return;
                    } 
                    
                    location.href = jsSearchLink;
                });
                //按日  月  周查询
                $('.js_stat_date_type').on('click','a',function(){
                    var stattype = $(this).attr('val');
                    $(this).addClass('on').siblings('a').removeClass('on');
                    jsSearchLink = $.beanalysis.getCondition(true);
                    if(jsSearchLink == 'false' || jsSearchLink == false){
                        return;
                    }
                    location.href = jsSearchLink+'/statType/'+stattype;
                });

                //具体查询选择类型
                $('#js_thirdselectul').on('click','li',function(){
                    $('#js_thirdselectul').hide();
                    var thirdtype = $(this).attr('title');
                    $('#js_thirdselect').val(thirdtype);
                    jsSearchLink = $.beanalysis.getCondition();
                    //如果返回false  代表弹出提示框阻止向下执行
                    if(jsSearchLink == 'false' || jsSearchLink == false){
                        return;
                    }
                    location.href = jsSearchLink;
                });

                //列表展示添加滚动条
                var scrollObj =  $('.js_c_content') ;
                if(!scrollObj.hasClass('mCustomScrollbar')){
                    scrollObj.mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                }

            },
            getCondition:function(type){
                var selecttype = $('#js_secondselect').val();

                var starttime = $('#js_begintime').val();
                var endtime = $('#js_endtime').val();
                jsSearchLink += '/selecttype/'+encodeURIComponent(selecttype);
                if (typeof(type)=='string'){
                	//如果是子模块跳转，则清空其他条件
                	//return jsSearchLink;
                }
                
                //判断是否存在平台查询
                if($('#js_selectIOS').length>0){
                    var sysplat = $('#js_selectIOS input').attr('title');
                    jsSearchLink += '/appType/'+encodeURIComponent(sysplat);
                }
                //判断是否存在版本查询
                if($('#js_productversion').length>0){
                    var appversion = $('#js_productversion').attr('title');
                    if (appversion){
                    	jsSearchLink += '/appVersion/'+encodeURIComponent(appversion);
                    }
                }
                //判断是否细分查询条件
                if($('#js_thirdselect').length>0){
                    var thirdtype = $('#js_thirdselect').val();
                    jsSearchLink += '/thirdtype/'+encodeURIComponent(thirdtype);
                }
                if (typeof(type)=='boolean'){
                	//如果是日周月跳转，则带上其他条件，不要日期
                	return jsSearchLink;
                }
                
                //拼接查询条件
                if(starttime != ''){
                    jsSearchLink += '/startDate/'+starttime;
                }

                if(endtime != ''){
                    jsSearchLink += '/endDate/'+endtime;
                }
                
                //日期搜索类型
                var stattype=$('.js_stat_date_type .on').attr('val');
                jsSearchLink += '/statType/'+stattype;
                
                //判断是否需要对比时间段
                if($('#js_time_duibi').is(":visible")){
                    var  constarttime  =  $('#js_begintime1').val();
                    var  conendtime  =  $('#js_endtime1').val();
                    if(conendtime != '' || constarttime != ''){
                        if(constarttime =='' && conendtime !=''){  //如果只填了结束时间  没填写开始时间  需要提示填写完整
                            $.global_msg.init({gType:'warning',icon:2,msg:jsInsertContrastTime});
                            return false;
                        }else if(constarttime != '' && conendtime ==''){ //开始不为空 结束时间为空
                            jsSearchLink += '/contrast/1/constarttime/'+constarttime;
                        }else{  //都不为空
                            jsSearchLink += '/contrast/1/constarttime/'+constarttime+'/conendtime/'+conendtime;
                        }

                    }
                }
                return jsSearchLink;
            }
        }
        });
})(jQuery);