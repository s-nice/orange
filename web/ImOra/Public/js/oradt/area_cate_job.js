(function ($) {
    $.extend({
        area_cate_job: {
            area: [],
            cate: [],
            job: [],
            init: function () {
                this.event();//页面事件
                this.set_city(selectedProvinceCodes, selectedCityCodes);
                this.set_industry(selectedIndustryParentCodes, selectedIndustryCodes);
                this.set_Job(selectedJobParentCodes, selectedJobCodes);
            },
            event: function () {//页面公用事件
                var that = this;
                var now = new Date();
                $('.js_push_set_time').val(now.format('Y-m-d h:i'));//默认推送时间为当前时间

                $('.js_btn_channel_cancel').on('click', function () {//点击关闭弹框事件
                    var $audio = $(this).parent().parent().find('audio'); //如果有音频播放 停止播放
                    for (var i = 0; i < $audio.length; i++) {
                        $audio.get(i).pause();
                    }
                    $('.get_comment_pop').hide();
                    $('.appadmin_maskunlock').hide();

                });

                $('.js_set_city_wrap, .js_first_menu_list, .js_set_category_wrap, .js_first_job_list, .js_set_job_wrap').mCustomScrollbar({
                    theme: "dark",
                    autoHideScrollbar: false,
                    scrollInertia: 0,
                    horizontalScroll: false
                });
            },
            //specialCity: ['10101', '10102', '10103', '10104', '10132', '10133'],//直辖市+香港+澳门特殊城市的id
            set_city: function (selectedProvinceCodes, selectedCityCodes) {//设置地区
                this.selectedProvinceCodes = selectedProvinceCodes;
                this.selectedCityCodes = selectedCityCodes;
                var that = this;

                $('#js_push_set_city').on('click', function () { //弹出弹框
                    $(this).blur();
                    $('.appadmin_maskunlock').show();
                    $('.js_push_news_region_pop').show();
                });

                //一级菜单全选
                $('.js_push_news_region_pop .js_one_all_check').on('click', function () {
                    if ($(this).is(':checked')) {//选中
                        $('#js_isLoading').show();//loding 提示
                        $('.js_push_news_region_pop').css("z-index", 90);//加载二级选项的遮罩 遮罩层为99 小于99
                        var fn = function () {
                            if ($('.js_set_province').length == $('.js_city_list_wrap').length) {
                                $('.js_set_province,.js_set_city,.js_push_news_region_pop .js_two_all_check').prop('checked', true);//全部选项勾选
                                $('#js_isLoading').hide();
                                $('.js_push_news_region_pop').css("z-index", 223);//加载二级选项取消遮罩 遮罩层为99 大于99
                            }
                        };
                        $('.js_set_province').each(function (index, ele) { //加载全部二级菜单选项
                            var id = $(this).val();
                            that.getCityList(id, fn);
                        });
                    } else {//取消
                        $('.js_set_province,.js_set_city,.js_push_news_region_pop .js_two_all_check').prop('checked', false);//一所有选项取消
                        $(".js_city_list_wrap").hide();//所有以及省份对应的二级容器隐藏
                    }
                });

                //选择省，直辖市 一级菜单
                $('.js_set_province').on('change', function () {
                    var id = $(this).val();
                    if ($(this).is(':checked')) { //选中
                        var fn = function () {
                            $(".js_city_list_wrap[code='" + id + "'] input").prop('checked', true);//选择的二级菜单
                            if ($(".js_set_city:visible").length == $(".js_set_city:visible:checked").length) {
                                $('.js_push_news_region_pop .js_two_all_check').prop('checked', true); //判断二级菜单全选
                            }
                        };
                        that.getCityList(id, fn);//获取对应的城市列表
                        if ($('.js_set_province').length == $('.js_set_province:checked').length) {
                            $('.js_push_news_region_pop .js_one_all_check').prop('checked', true);//一级全选选中
                        }
                        if ($(".js_set_city:visible").length == $(".js_set_city:visible:checked").length) {
                            $('.js_push_news_region_pop .js_two_all_check').prop('checked', true); //全选
                        }
                    } else { //取消选中
                        $(".js_city_list_wrap[code='" + id + "']").hide(); //隐藏对应的二级城市
                        //  $(".js_city_list_wrap[code='" + id + "'] input").prop('checked',false)//清除已选择的二级菜单
                        $('.js_push_news_region_pop .js_one_all_check').prop('checked', false);//一级全选框取消选中
                        if ($(".js_set_city:visible").length == $(".js_set_city:visible:checked").length) { //判断二级菜单
                            $('.js_push_news_region_pop .js_two_all_check').prop('checked', true); //全选
                        }
                    }
                });

                //二级菜单全选
                $('.js_push_news_region_pop .js_two_all_check').on('click', function () {
                    //二级菜单全选
                    if ($(this).is(':checked')) {
                        $(".js_set_city:visible").prop('checked', true);//二级菜单全选
                    } else {
                        $(".js_set_city:visible").prop('checked', false);//二级菜单全选
                    }

                });
                //二级菜单单选
                $(".js_push_news_region_pop").on('click', '.js_set_city', function () { //二级菜单选中
                    if ($(this).is(':checked')) {//选中
                        //判断是否全选
                        if ($(".js_set_city:visible").length == $(".js_set_city:visible:checked").length) {
                            $('.js_push_news_region_pop .js_two_all_check').prop('checked', true); //全选
                        }
                    } else { //取消选择选择
                        $('.js_push_news_region_pop .js_two_all_check').prop('checked', false); //取消全选
                    }

                });


                //用于更新页面
                if (that.selectedProvinceCodes) {
                    var plist = that.selectedProvinceCodes.split(',');
                    var clist = that.selectedCityCodes.split(',');
                    for (var i = 0; i < plist.length; i++) {
                        var $obj = $('.js_provinces_wrap input[value="' + plist[i] + '"]');
                        if (!$obj.prop('checked')) {
                            $obj.click();
                        }
                    }

                    var it = setInterval(function () {
                        var flag = true;
                        for (var i = 0; i < clist.length; i++) {
                            var $obj = $('.js_city_list_wrap input[value="' + clist[i] + '"]');
                            if (!$obj.prop('checked')) {
                                flag = false;
                            }
                            $obj.prop('checked', true);
                        }

                        if (flag) {
                            clearInterval(it);
                        }
                    }, 100);
                }

                $('.js_set_city_confirm').on('click', function () { //点击确认按钮
                    var region = [];
                    var regionName = [];
                    /*        $(".js_set_province:checked").each(function () {
                     var pcode=$(this).val();
                     if ($('.js_city_list_wrap input[parentid="'+pcode+'"]:checked').length==0){
                     $('.js_city_list_wrap input[parentid="'+pcode+'"]').each(function(){
                     $(this).prop('checked', true);
                     });
                     }
                     });*/
                    $(".js_city_list_wrap:visible .js_set_city:checked").each(function () {
                        region.push($(this).val());
                        regionName.push($(this).next('span').html());
                    });

                    $('#js_push_set_region_code').val(region);
                    $('#js_push_set_city').val(regionName);
                    $('.js_push_news_region_pop').hide();
                    $('.appadmin_maskunlock').hide();
                });

                $(".js_set_city_cancel, .js_push_news_region_pop .get_comment_close").on('click', function () {//点击取消
                    $('.js_push_news_region_pop').hide();
                    $('.appadmin_maskunlock').hide();
                })

            },
            set_industry: function (selectedIndustryParentCodes, selectedIndustryCodes) {
                var that = this;
                $('#js_push_set_category').on('click', function () { //弹出弹框js_provinces_wrap
                    $(this).blur();
                    $('.appadmin_maskunlock').show();
                    $('.js_push_news_category_pop').show();
                });
                that.checkEvent( //选择事件
                    $('.js_push_news_category_pop'),
                    $('.js_set_category'),
                    $(".js_set_one_category_label"),
                    $(".js_set_second_category"),
                    $(".js_set_second_category_label")
                );


                //用于更新页面
                if (selectedIndustryParentCodes) {
                    var plist = selectedIndustryParentCodes.split(',');
                    var clist = selectedIndustryCodes.split(',');
                    for (var i = 0; i < plist.length; i++) {
                        var $obj = $('.js_push_news_category_pop .js_first_menu_list input[value="' + plist[i] + '"]');
                        if (!$obj.prop('checked')) {
                            $obj.click();
                        }
                    }

                    for (var i = 0; i < clist.length; i++) {
                        var $obj = $('.js_set_category_wrap input[value="' + clist[i] + '"]');
                        if (!$obj.prop('checked')) {
                            flag = false;
                        }
                        $obj.prop('checked', true);
                    }
                }

                $('.js_set_category_confirm').on('click', function () { //点击确认
                    var category = [];
                    var categoryName = [];

                    $(".js_set_category:checked").each(function () {
                        var pcode = $(this).val();
                        /*   if ($('.js_set_category_wrap input[parentid="'+pcode+'"]:checked').length==0){
                         $('.js_set_category_wrap input[parentid="'+pcode+'"]').each(function(){
                         $(this).prop('checked', true);
                         });
                         }*/
                    });
                    $(".js_set_second_category:checked:visible").each(function () {
                        category.push($(this).val());
                        categoryName.push($(this).next('span').html());
                    });
                    $('#js_push_set_category_code').val(category);
                    $('#js_push_set_category').val(categoryName);
                    $('.js_push_news_category_pop').hide();//关闭弹框
                    $('.appadmin_maskunlock').hide();
                });

                $('.js_set_category_cancel').on('click', function () { //关闭弹框
                    $('.appadmin_maskunlock').hide();
                    $('.js_push_news_category_pop').hide();
                });
            },
            set_Job: function (selectedJobParentCodes, selectedJobCodes) {
                var that = this;
                $('#js_push_set_job').on('click', function () { //弹出弹框js_provinces_wrap
                    $(this).blur();
                    $('.appadmin_maskunlock').show();
                    $('.js_push_news_job_pop').show();
                });
                that.checkEvent( //选择事件
                    $('.js_push_news_job_pop'),
                    $('.js_set_job'),
                    $(".js_set_one_job_label"),
                    $(".js_set_second_job"),
                    $(".js_set_second_job_label")
                );


                //用于更新页面
                if (selectedJobParentCodes) {
                    var plist = selectedJobParentCodes.split(',');
                    var clist = selectedJobCodes.split(',');
                    for (var i = 0; i < plist.length; i++) {
                        var $obj = $('.js_push_news_job_pop .js_first_job_list input[value="' + plist[i] + '"]');
                        if (!$obj.prop('checked')) {
                            $obj.click();
                        }
                    }

                    for (var i = 0; i < clist.length; i++) {
                        var $obj = $('.js_set_job_wrap input[value="' + clist[i] + '"]');
                        if (!$obj.prop('checked')) {
                            flag = false;
                        }
                        $obj.prop('checked', true);
                    }
                }

                $('.js_set_job_confirm').on('click', function () { //点击确认
                    var job = [];
                    var jobName = [];
                    $(".js_set_job:checked").each(function () {
                        var pcode = $(this).val();
                        /*   if ($('.js_set_job_wrap input[parentid="'+pcode+'"]:checked').length==0){
                         $('.js_set_job_wrap input[parentid="'+pcode+'"]').each(function(){
                         $(this).prop('checked', true);
                         });
                         }*/
                    });
                    $(".js_set_second_job:checked:visible").each(function () {
                        job.push($(this).val());
                        jobName.push($(this).next('span').html());
                    });
                    $('#js_push_set_job_code').val(job);
                    $('#js_push_set_job').val(jobName);
                    $('.js_push_news_job_pop').hide();//关闭弹框
                    $('.appadmin_maskunlock').hide();
                });

                $('.js_set_job_cancel').on('click', function () { //关闭弹框
                    $('.appadmin_maskunlock').hide();
                    $('.js_push_news_job_pop').hide();
                });
            },
            loop: 0,//循环起始值，判断循环次数

            /*
             * id 以及省份直辖市id
             * fn 成功后的调用的函数
             * */
            getCityList: function (id, fn) { //通过省份ID 获取省份的城市列表
                var that = this;
                // $(".js_city_list_wrap").hide();
                var $listWrap = $(".js_city_list_wrap[code='" + id + "']");
                if ($listWrap.length < 1) { //判断是否加载过
                    $.ajax({
                        url: gGetAddressUrl,
                        type: "get",
                        data: {action: "cityList", id: id},
                        success: function (response) {
                            var $wrap = $("#city_list");
                            $wrap.append("<div class='js_city_list_wrap' code=" + id + "></div>");
                            $listWrap = $(".js_city_list_wrap[code='" + id + "']");
                            $.each(response, function () {
                                $listWrap.append(
                                    "<label class='label_1-5 '>" +
                                    "<input class='js_set_city' type='checkbox' checked='checked' autocomplete='off' value=" + this.prefecturecode + " parentId=" + id + " />" +
                                    "<span>"
                                    + this.city + "" +
                                    "</span>" +
                                    "</label>"
                                );
                            });
                            that.loop = 0;
                            if (typeof fn === "function") {
                                fn();
                            }
                        },
                        error: function () { //获取失败最多重复提交3次
                            if (that.loop != 3) {
                                that.loop += 1;
                                that.getCityList(id)
                            } else {
                                $.global_msg.init({gType: 'warning', msg: '获取城市列表失败', icon: 1});
                            }
                        }
                    })
                } else {
                    if (typeof fn === "function") {
                        fn();
                    }
                    $listWrap.show();
                }
            },
            /*
             * 职能 行业 弹框 选择js
             * $wrap 主容器 obj
             * $oneCheck 一级菜单选择框input obj
             * $oneCheckLabel 一级菜单选项容器 obj
             * $twoCheck 二级菜单选择框input obj
             * $twoCheckLabel 二级菜单选项容器 obj
             * */
            checkEvent: function ($wrap, $oneCheck, $oneCheckLabel, $twoCheck, $twoCheckLabel) {
                var $one_all_check = $wrap.find('.js_one_all_check');//一级菜单全选对象
                var $two_all_check = $wrap.find('.js_two_all_check');//二级菜单全选对象
                var ifAllSelect = function () { //判断一二级菜是否全选
                    //var $showOneCheck=$wrap.find($oneCheckLabel).find($("input:visible"));//显示的一级菜单
                    var $showTwoCheck = $wrap.find($twoCheckLabel).find($("input:visible"));//显示的二级菜单
                    if ($oneCheck.length == $oneCheckLabel.find($(":checkbox:checked")).length) { //判断是否全选
                        $one_all_check.prop('checked', true);
                    }
                    if ($showTwoCheck.length == $twoCheckLabel.find($(":checkbox:checked")).length) {
                        $two_all_check.prop('checked', true); //全选
                    }
                };

                //一级分类的全选
                $one_all_check.on('click', function () {
                    if ($(this).is(':checked')) { //全选
                        //$oneCheck.prop('checked', true);//一级菜单全选
                        //$twoCheck.prop('checked', true);//二级菜单全选
                        //$twoCheckLabel.show();//所有二级菜单显示
                        $oneCheck.each(function(){
                        	if (!$(this).prop('checked')){
                        		$(this).click();
                        	}
                        });
                        $two_all_check.prop('checked', true);//二级全选框选中状态
                    } else { //取消全选
                        $oneCheck.prop('checked', false);//一级菜单全选
                        $twoCheck.prop('checked', false);//二级菜单取消全选
                        $twoCheckLabel.hide();//所有二级菜单隐藏
                        $two_all_check.prop('checked', false);//二级菜单全选框取消选中
                    }
                });
                //二级菜单全选
                $two_all_check.on('click', function () {
                    var $showTwoCheck = $wrap.find($twoCheckLabel).find($("input:visible"));//显示的二级菜单
                    if ($(this).is(':checked')) {
                        $showTwoCheck.prop('checked', true);//二级菜单全选
                    } else {
                        $showTwoCheck.prop('checked', false);//二级菜单全选
                    }
                });
                //选择一级显示2级列表
                $oneCheck.on('click', function () {
                    var parentid = $(this).val();
                    if ($(this).is(':checked')) { //选中
                        $twoCheck.each(function () {//清除已选择的二级菜单
                            if ($(this).attr('parentid') == parentid) {
                                $(this).prop('checked', true);
                                $(this).closest('label').show();
                            }
                        });
                        ifAllSelect()
                    } else { //取消选中
                        $twoCheck.each(function () {//清除已选择的二级菜单
                            if ($(this).attr('parentid') == parentid) {
                                $(this).prop('checked', false);
                                $(this).closest('label').hide();
                            }
                        });
                        ifAllSelect();
                        $one_all_check.prop('checked', false); //取消全选
                    }
                });

                $twoCheck.on('click', function () { //二级菜单选中
                    if ($(this).is(':checked')) {//选中
                        /*判断是否全选*/
                        ifAllSelect();
                    } else { //取消选择选择
                        $two_all_check.prop('checked', false); //取消全选
                    }
                });
            }
        }
    });
})(jQuery);