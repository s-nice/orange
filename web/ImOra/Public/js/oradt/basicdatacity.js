/**
* 设置基础数据管理JS
**/
(function($){
    $.extend({
        basicData:{
            init:function(){
                this.menu.click_triangle();//左侧和表单的地区列表三角符号的事件
                this.menu.click_select();//选择左侧和表单的地区列表中国的值
                this.select_input_click();//表单中的下拉菜单事件
                $(window).load(function() { //左侧列表滚动条
                    $(".l_menu").mCustomScrollbar({
                        theme: "dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia: 0,//滚动延迟
                        horizontalScroll: false//水平滚动条
                    });

                    $(".js_select_menus").mCustomScrollbar({// 表单列表滚动条
                        theme: "dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia: 0,//滚动延迟
                        horizontalScroll: false//水平滚动条

                    });
                });
            },
            /*左侧和表单中的地区菜单列表事件*/
            menu:{
               // specialCity:['10101','10102','10103','10104','10132','10133'],//直辖市+香港+澳门特殊城市的id
                loop:0,//循环起始值
                click_triangle:function(){ //菜单点击事件
                    var that=this;
                    /*点击两个菜单的三角符号的事件*/
                    $(".l_menu,.js_select_wrap").on('click','.triangle',function(){
                        var $menu=$(this).parent();
                        var clickMenu=$menu.hasClass('up_menus') ? 'left' : 'form';//判断点击事件来自哪个菜单
                        that.triangle($menu);//三角符号变化
                        var layer=$menu.attr("layer");
                        switch (layer){ //根据菜单的层级判断相应的事件
                            case "country": //国家
                                var obj=$menu;
                                that.countryMenu(clickMenu,obj);
                                break;
                            case "province"://省份，直辖市
                                var obj=$menu;
                                var code=$menu.attr('code');
                                that.provinceMenu(clickMenu,obj,code);
                                break;
  /*                          case "city"://城市
                                var $wrap=$menu.next(".js_region_wrap");
                                var code=$menu.attr('code');
                                that.cityMenu(clickMenu,$wrap,code);
                                break;
*/
                            default:
                                break;
                        }
                    });
                },
                /*点击选择两个菜单列表中的值*/
                click_select:function(){
                    $(".l_menu,.js_select_wrap").on('click','.js_city_menus',function(){
                        var code=$(this).parent().attr('code');//选中的code
                        var parentname=$(this).closest('.wrap').prev().children('.menus').text();//上一级菜单的名称
                        var parentcode=$(this).closest('.wrap').prev().attr('code');//上一级菜单code
                        $('#js_select_name').val($(this).text()); //名称input
                        $('#js_select_code').val(code); //名称input
                      //  $('#js_select_keyword').val($(this).text());//关键字input
                        $('#js_select_parentname').val(parentname);//上一级菜单的名称
                        $('#js_select_parentcode').val(parentcode);//上一级菜单的名称
                    })

                },
                /*三角符号变化*/
                triangle:function($menu){
                    var $triangle= $menu.children(".triangle");//获取三角符号
                    if($triangle.hasClass("triangle-down")){
                        $triangle.removeClass("triangle-down");
                        $triangle.addClass("triangle-right");
                    }else{
                        $triangle.removeClass("triangle-right");
                        $triangle.addClass("triangle-down");
                    }

                },
                /*点击国家级下拉菜单事件，隐藏和显示下级菜单*/
                countryMenu:function(clickMenu,obj){
                    var $wrap=obj.next('.js_province_wrap').length==1 ? obj.next('.js_province_wrap'):obj.children('.js_province_wrap');
                    $wrap.toggle();
                },

                /*点击省级下拉菜单事件，获取点击省份的城市列表*/
                provinceMenu:function(clickMenu,obj,code){
                    var that=this;
                    var  $wrap=obj.next(".js_city_wrap");//一般省份
                    var  $child=clickMenu=='left' ? $wrap.children('.up_menus') : $wrap.children('li');
                    if($child.length==0 && $wrap.children('.js_region_wrap').length==0 ) { //判断省或直辖市是否已经获取列表
                        $.ajax({
                            url: gUrl,
                            type: "get",
                            data: {
                                provincecode: code
                            },
                            success: function (response) {
                               /* if($.inArray(code,that.specialCity)==-1) { //判断是否为直辖市*/
                                    /*非直辖市*/
                                    if(clickMenu=='left'){//左侧菜单插入
                                        $.each(response, function () {
                                            $wrap.append(
                                                "<div class='up_menus' layer='city' code='" + this.prefecturecode + "'>" +
                                           /*     "<span class='triangle triangle-right'></span>" +*/
                                                "<span class='menus js_city_menus' >" + this.city + "</span>" +
                                                "</div>"
                                               /* +"<div class=' wrap js_region_wrap ' style='margin-left:30px'></div>");*/
                                            )
                                        });
                                    }else{ //表单下拉插入
                                        $.each(response, function () {
                                            $wrap.append(
                                                "<li class='js_form_menu' layer='city' code='" + this.prefecturecode + "' style='text-indent: 4em'>" +
                                               /* "<div class='triangle triangle-right triangle-div'>" +*/
                                                "</div>" +
                                                "<span class='menus'>"+ this.city + "</span>"+
                                                "</li>"
                                                /*"+<div class='wrap js_region_wrap'></div>"*/
                                            )
                                        })
                                    }
                          /*     }else{
                                      $wrap.append("<div class='js_region_wrap'></div>");
                                      that.cityMenu(clickMenu, $wrap.children('.js_region_wrap'),response[0]['code']);
                                }*/
                                that.loop = 0;
                            },
                            fail: function () {
                                if (that.loop < 3) { //失败后再次获取不超过3次
                                    that.provinceMenu($wrap.next(), this.code);
                                } else {
                                    $.global_msg.init({ //弹出消息框
                                        gType: 'warning',
                                        icon: 2,
                                        msg: '操作失败！',
                                        close: true,
                                        title: false
                                    });
                                }
                            }
                        })
                    }else{
                        if($wrap.is(":hidden")){ //判断隐藏和显示
                            $wrap.show();
                        }else{
                            $wrap.hide();
                        }
                    }
                },
                /*点击市级下拉菜单事件，获取点击城市的区列表*/
               /* cityMenu:function(clickMenu,$wrap,id){
                    var that=this;
                    var $child=clickMenu=='left' ? $wrap.children('.up_menus') : $wrap.children('li');
                    if($child.length==0) { //判断是否已经获取区列表
                        $.ajax({
                            url: gUrl,
                            type: "get",
                            data: {
                                action: "regionList",
                                id: id
                            },
                            success: function (response) {
                                if(clickMenu=='left'){ //左侧菜单插入
                                    $.each(response, function () {
                                        $wrap.append(
                                            "<div  layer='region' class='up_menus'  code='" + this.code + "'>" +
                                            "<span class='menus js_region_menus' >" + this.name + "</span>" +
                                            "</div>");
                                    })
                                }else{ //表单下拉插入
                                    $.each(response, function () {
                                        $wrap.append(
                                            "<li layer='region' code='" + this.code + "' style='text-indent: 6em' >" +
                                            "</div><span class='menus'>"
                                            + this.name +
                                            "</span></li>"+
                                            "<div class='js_region_wrap'></div>"
                                        )
                                    });
                                }
                                that.loop = 0;
                            },
                            fail: function () {
                                if (that.loop < 3) { //失败后再次获取不超过3次
                                    that.cityMenu()($wrap, id);
                                } else {
                                    $.global_msg.init({ //弹出消息框
                                        gType: 'warning',
                                        icon: 2,
                                        msg: '操作失败！',
                                        close: true,
                                        title: false
                                    });
                                }
                            }
                        })
                    }else{
                        if($wrap.is(":hidden")){ //判断隐藏和显示
                            $wrap.show();
                        }else{
                            $wrap.hide();
                        }
                    }
                }*/

            },
            /*表单下拉input点击事件*/
            select_input_click:function(){
                /*点击显示隐藏下面的列表*/
                $('.js_form_menu_on').on('click',function(){
                    $('.js_select_menus').toggle();
                });
                /*点击外部隐藏*/
                $(document).on('click', function (e) { //点击外部
                    if ($(e.target).parents('.js_select_wrap').length <= 0) {
                        $('.js_select_menus').hide();
                    }
                });

            }
        }
    });
    $.basicData.init();
})(jQuery);
