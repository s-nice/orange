/**
 *订单管理 企业充值列表 邮寄服务订单列表js
 *
 * */
;(function($){
    $.extend({
        publicFn:{
            select:function(){ //下拉选项
                $('.js_select_title').on('click',function(){ //点击选择
                    $(this).nextAll( $('.js_select_content')).toggle();

                });

                $('.js_select_content li').on('click',function(){ //点击下拉选项
                    $(this).parent().siblings($('.js_select_title')).val($.trim($(this).html()));
                    $('.js_select_content ').hide();
                });

                $(document).on('click', function (e) { //点击外部 隐藏下拉选项
                    if ($(e.target).parents('.menu_list').length==0) {
                        $('.js_select_content').hide();
                    }else{
                        var $obj=$(e.target).parents('.menu_list').find( $('.js_select_content'));
                        $('.js_select_content').not($obj).hide()

                    }
                });

            },
            search:function(){ //搜索拼接url
                $('.js_search').on('click',function(){
                    var condition='';
                    $('.js_search_params').each(function(){
                        if($.trim($(this).val())!=''){
                            var searchVal = encodeURIComponent($.trim($(this).val()));//搜索的值
                            var searchName =encodeURIComponent($.trim($(this).attr('name')));//搜索的值
                            condition+=searchName+ '=' + searchVal+'&';
                        }

                    });
                    window.location.href = gUrl+'?' + condition;//跳转

                })


            },
            sort:function(){ //点击排序拼接URL
                $('.js_sort').on('click',function(){
                    var _url=window.location.href;
                    var em = $(this).parent().find('em');
                    var sort = em.hasClass('list_sort_desc') ? 'asc' : 'desc';
                    if(_url.indexOf('.html?')!=-1){
                        if(_url.indexOf('sort=')!=-1){
                            var replaceSort= sort == 'asc' ? 'desc' :'asc';
                           _url= _url.replace(replaceSort,sort);
                            window.location.href =_url;
                        }else{
                            window.location.href =_url+'sort='+sort;
                        }
                    }else{
                        window.location.href = gUrl+'?' + 'sort='+sort;
                    }
                } )
            }

         },

        payList:{ //企业充值列表
            init:function(){ //页面初始化
                $.dataTimeLoad.init();//日历插件
                $.publicFn.select();//下拉选择
                $.publicFn.search();//搜索事件
                $.publicFn.sort();//排序
            }
        },
        consumeList:{//企业消费列表
            init:function(){ //页面初始化
                $.dataTimeLoad.init();//日历插件
                $.publicFn.select();//下拉选择
                $.publicFn.search();//搜索事件
                $.publicFn.sort();//排序
            }
        },
        postList:{ // 邮寄服务订单列表
            init:function(){
                $.dataTimeLoad.init();//日历插件
                $.publicFn.select();//下拉选项
                $.publicFn.search();//搜索事件
                $.publicFn.sort();//排序
            }
        }


    });
})(jQuery);