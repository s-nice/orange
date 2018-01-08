/**
 * orange 推荐规则管理
 *
 * */
;(function ($) {
    $.extend({
        OraRecommendRule: {
            /*事件初始化*/
            init: function () {
                this.initEvent();//初始化页面事件
            },
            /*初始化页面事件*/
            initEvent: function () {
            	var $this = this;

                //卡类型切换标签滚动条
                $this.ScrollBarfunc('.js_card_type_list');//卡类型切换标签滚动条

            	var $selectStrategy = $('.js_selected_strategy');
            	// 将已添加的推荐规则删除
            	$selectStrategy.on('click', 'span > i', function () {
                    $(this).closest('span').remove();
                    
                    $this.resort();
                });
            	// 选择策略/标签， 加入到推荐规则中
                $('.js_strategy_for_choose, .js_label_for_choose').on('click', 'span > b', function () {
                	var $dom = $(this).closest('span');
                	var id = $dom.attr('data-id');

                    $dom = $dom.clone();
                    $dom.find('b').remove();
                    //标签
                    if($dom.attr('data-type')!='strategy'){
                        //tag ，获取卡类型id
                        var itemcardtypeid = '';
                        var itemcardtypesname = '';
                        $('.js_card_type_list .mCSB_container li').each(function(i,d){
                            if($(d).hasClass('on')){
                                itemcardtypeid = $(d).attr('val');
                                itemcardtypesname = $(d).html();
                            }
                        });
                        $dom.attr('data-cardtypeid',itemcardtypeid);
                        $dom.attr('title',itemcardtypesname+'-'+$dom.attr('data-name'));

                        //获取标签类型名称
                        var itemtypename = '';
                        itemtypename = $('#js_wrap_main .js_label_type_wrap li[type-id='+$dom.attr('type-id')+']').find('em').html();
                        $dom.attr('data-typename',itemtypename);

                        //删除父级标签类型
                        var typeid = $dom.attr('type-id');
                        $selectStrategy.find('span').each(function(i,d){
                            if ($(d).attr('data-id') == typeid && $(d).attr('data-type')!='strategy') {
                                $(d).remove();
                            }
                        });

                    }else{
                        var existstrategy = 0;
                        $selectStrategy.find('span').each(function(i,d){
                            if ($(d).attr('data-id') == id && $(d).attr('data-type')=='strategy') {
                                existstrategy = 1;
                            }
                        });

                        if(existstrategy == 1){
                            return false;
                        }
                    }

                    $selectStrategy.append($dom.prepend('<b></b>').append('<i>X</i>'));


                    $this.resort();
                });
                //父类标签选择
                $('#js_wrap_main').on('click','.js_label_type_wrap .js_label_type i',function(){
                    var itemhtml = $(this).siblings().html();
                    var itemid = $(this).parent().attr('type-id');

                    //tag ，获取卡类型id
                    var itemcardtypeid = '';
                    var itemcardtypesname = '';
                    $('.js_card_type_list .mCSB_container li').each(function(i,d){
                        if($(d).hasClass('on')){
                            itemcardtypeid = $(d).attr('val');
                            itemcardtypesname = $(d).html();
                        }
                    });

                    //判断是否已存在
                    var isused = 0;
                    $selectStrategy.find('span').each(function(i,d){
                        if($(d).attr('data-id')==itemid && $(d).attr('data-type')!='strategy'){
                            isused = 1;
                        }
                        //如果存在子类已选标签，则删除子类已选标签
                        if ($(d).attr('type-id') == itemid) {
                            $(d).remove();
                        }
                    });

                    if(isused == 1){
                        return false;
                    }

                    $selectStrategy.append('<span title="'+itemcardtypesname+'-'+itemhtml+'" data-name="'+itemhtml+'" data-id="'+itemid+'" type-id="" data-cardtypeid="'+itemcardtypeid+'"><b></b><em>'+itemhtml+'</em><i>X</i></span>');

                    //重新排序
                    $this.resort();
                });


                // 点击保存推荐规则
                $('#save_button').click(function () {
                	var $selectStrategy = $('.js_selected_strategy span');

                    //获取推荐策略优先级
                    var strategystr = '[';

                    var strategylist = '{';
                    strategylist += '"froms":"strategy",';
                    strategylist += '"type":"",';
                    strategylist += '"cardtypeid":"",';
                    strategylist += '"tagtypeid":"",';
                    strategylist += '"sort":"",';
                    strategylist += '"w":[{';
                    var existstrategylist = 0;

                    var tagtypelist = '{';
                    var tagtypeidlist = [];
                    //判断是否选择了推荐规则
                    var isexist = 0;

                    $selectStrategy.each(function(ind,dom){
                        isexist = 1;
                        var sortnumb = $(dom).find('b').html();
                        if($(dom).attr('data-type')=='strategy'){
                            existstrategylist = 1;
                            strategylist += '"fromid":'+$(dom).attr('data-id')+',';
                            strategylist += '"name":"'+$(dom).attr('title')+'",';
                            strategylist += '"sort":'+sortnumb+'},{';
                        }else{
                            if($(dom).attr('type-id')==undefined || $(dom).attr('type-id')==''){
                                tagtypelist += '"froms":"tag",';
                                tagtypelist += '"type":"'+$(dom).attr('data-name')+'",';
                                tagtypelist += '"cardtypeid":'+$(dom).attr('data-cardtypeid')+',';
                                tagtypelist += '"tagtypeid":'+$(dom).attr('data-id')+',';
                                tagtypelist += '"sort":'+sortnumb+',';
                                tagtypelist += '"w":[]},{';
                            }else{
                                //获取typeid
                                if($.inArray($(dom).attr('type-id'),tagtypeidlist)==-1){
                                    tagtypeidlist.push($(dom).attr('type-id'));
                                }
                            }
                        }

                    });
                    //提示选择推荐策略(已修改为可以为空
                    /*if(isexist==0){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请选择至少一项推荐策略'});
                        return false;
                    }*/

                    //判断是否有默认优先级策略,如果没有，则清空优先级策略json
                    if(existstrategylist==0){
                        strategylist = '';
                    }

                    //定义tag数组
                    var taglist = [];
                    for (var i=0;i<tagtypeidlist.length;i++) {
                        taglist[tagtypeidlist[i]] = '{';
                        taglist[tagtypeidlist[i]] += '"froms":"tag",';
                        taglist[tagtypeidlist[i]] += '"type":"'+$('.js_selected_strategy span[type-id="'+tagtypeidlist[i]+'"]').first().attr('data-typename')+'",';
                        taglist[tagtypeidlist[i]] += '"tagtypeid":'+[tagtypeidlist[i]]+',';
                        taglist[tagtypeidlist[i]] += '"sort":"",';

                    }
                    $selectStrategy.each(function(ind,dom){
                        var sortnumb = $(dom).find('b').html();
                        if($(dom).attr('data-type')!='strategy' && $(dom).attr('type-id')!='' && $(dom).attr('type-id')!=undefined){
                            var $i = $(dom).attr('type-id');
                            if(taglist[$i].substring(taglist[$i].length-3,taglist[$i].length)=='},{'){
                                taglist[$i] += '"fromid":'+$(dom).attr('data-id')+',';
                                taglist[$i] += '"name":"'+$(dom).attr('data-name')+'",';
                                taglist[$i] += '"sort":'+sortnumb+'},{';
                            }else{
                                taglist[$i] += '"cardtypeid":'+$(dom).attr('data-cardtypeid')+',';
                                taglist[$i] += '"w":[{';
                                taglist[$i] += '"fromid":'+$(dom).attr('data-id')+',';
                                taglist[$i] += '"name":"'+$(dom).attr('data-name')+'",';
                                taglist[$i] += '"sort":'+sortnumb+'},{';
                            }
                        }
                    });

                    var tagliststr = '';
                    for (var i=0;i<tagtypeidlist.length;i++) {
                        taglist[tagtypeidlist[i]] = taglist[tagtypeidlist[i]].substring(0,taglist[tagtypeidlist[i]].length-2);
                        taglist[tagtypeidlist[i]] += ']}';
                        tagliststr+=taglist[tagtypeidlist[i]]+',';
                    }
                    tagtypelist = tagtypelist.substring(0,tagtypelist.length-2);

                    if(strategylist!=''){
                        strategylist = strategylist.substring(0,strategylist.length-2);
                        strategylist += ']}';
                        strategystr += strategylist+',';
                    }
                    if(tagtypelist!=''){
                        strategystr += tagtypelist+',';
                    }
                    if(tagliststr!=''){
                        strategystr += tagliststr;
                    }

                    strategystr = strategystr.substring(0,strategystr.length-1);
                    strategystr += ']';
                    if(strategystr.length < 5){
                        strategystr = '';
                    }

                	$.ajax($(this).attr('data-url'), {
                		data    : {stragegyids : strategystr},
                		type    : 'POST',
                        datatype:'json',
                		success : function () {
                            $.global_msg.init({gType:'warning',icon:1,msg:'保存成功' ,time:3,close:true,title:false ,endFn:function(){
                                location.href=URL_FROM;
                                //window.location.href = $('#save_button').attr('data-jump');
                            }});
                		},
                		error   : function () {
                            //失败
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});
                		}
                	});
                });
                
                $('#cancel_button').click(function () {
                    location.href=URL_FROM;
                	//window.location.href = $(this).attr('data-url');
                });
                
                $this.resort();
                
                // 加入可拖拽排序功能
                $( ".js_selected_strategy" ).sortable({
                	stop : $this.resort
                });
                $( ".js_selected_strategy" ).disableSelection();
                
                // 标签选择部分， 切换卡类型， 标签类型和标签进行
                $('.js_card_type_list li').click ( function () {
                	if ($(this).hasClass('on') ) return;
                	
                	$(this).addClass('on').siblings('.on').removeClass('on');
                	$('#js_wrap_main .js_label_list_wrap, #js_wrap_main .js_label_type[type-id!="all"]').remove();
                	var cardTypeId = $(this).attr('val');
                	$.ajax(gGetLabelUrl, {
                		data : {'cardTypeId' : cardTypeId},
                		type : 'get',
                		success : function (response) {
                			$.popLabel._buildLabelTypes(response.data.list);
                			$('#js_wrap_main .js_label_type:first').removeClass('on').trigger('click');
                		},
                		error : function () {
                			
                		}
                	});
                });
            },
            
            // 重新将选择的推荐规则排上序号
            resort : function () {
            	var $selectStrategy = $('.js_selected_strategy').find('span');
            	var total = $selectStrategy.length;
            	for(var i=1; i<=total; i++) {
            		$selectStrategy.eq(i-1).find('b').text(i);
            	}
            },
            /*滚动条*/
            ScrollBarfunc: function (_dom) {
                var scrollObjs = $(_dom);

                scrollObjs.mCustomScrollbar({
                    theme:"dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia :0,//滚动延迟
                    height:50,
                    horizontalScroll : false//水平滚动条
                });
            }
        }
    });

})(jQuery);
