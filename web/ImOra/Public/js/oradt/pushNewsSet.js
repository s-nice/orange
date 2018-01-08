(function ($) {
    $.extend({
        willPush: {
            init: function () {
                this.event();//页面事件
                this.set_city();//设置地区
                this.set_industry();//设置行业
                this.set_Job();//设置职能
                this.preview();//预览带推送资讯
                $(":checkbox").removeAttr('checked'); //加载清除记忆的默认选择
            },
            event: function () {//页面公用事件
                var that=this;
                var now = new Date();
                var initVal='';
                $('.js_push_set_time').val(now.format('Y-m-d h:i'));//默认推送时间为当前时间


                $('.js_btn_channel_cancel').on('click', function () {//点击关闭弹框事件
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.get_comment_pop ').hide();

                });

                $('.js_start_pop').on('click', function () { //点击一个弹框 隐藏其他不对应的弹框
                    var popName = $(this).attr('popName');
                    $('.get_comment_pop').not($(".get_comment_pop [popName!=popName]")).hide();
                });


                $('#js_push_set_confirm').on('click',function(){ //提交按钮
                    that.submitPush();
                });

                $('#js_push_set_cancel').on('click',function(){ //取消按钮 返回列表页面
                    location.href =gWillPushListUrl;

                });

                $('#js_push_set_inform').on('change',function(){
                    if($(this).is(':checked')){
                        $(this).val(1);
                    }else{
                        $(this).val(0);
                    }

                });

                var scrollObj = $('.js_provinces_wrap,.js_first_menu_list,.js_set_category_wrap,.js_set_job_wrap');
                if(!scrollObj.hasClass('mCustomScrollbar')){
                    scrollObj.mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                }

                $('.js_push_news_region_pop').on('mouseover', '.js_set_city_wrap', function () {
                    $(this).mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                });

                $('.js_push_list_wrap').on({ //排序判断输入是否为正整数，不为正整数返回原来的值
                    keydown:function(){
                        initVal=$(this).val();
                    },
                    keyup:function() {
                        var re=/^[1-9]+[0-9]*]*$/;
                        if ( $(this).val()!='' &&　!re.test($(this).val()))  {
                            $(this).val(initVal);
                            return false;
                        }
                    }
                },'.js_push_set_sort');


            },
           // specialCity: ['10101', '10102', '10103', '10104', '10132', '10133'],//直辖市+香港+澳门特殊城市的id
            set_city: function () {//设置地区
                var that = this;
                $('#js_push_set_city').on('click', function () { //弹出弹框
                    $('.js_masklayer').show();
                    $('.js_push_news_region_pop').show();
                });
                $('.js_set_province').on('change', function () { //选择省，直辖市获取城市列表
                    var id = $(this).val();
                    if ($(this).is(':checked')) { //选中
                        $(this).attr('all', 1);//标记默认全省
                        that.getCityList(id);
                    } else { //取消选中
                        $(".js_city_list_wrap[code='" + id + "']").hide();
                        $(".js_city_list_wrap[code='" + id + "'] input").removeAttr('checked');//清除已选择的二级菜单

                    }
                });
                $('.js_set_city_wrap').on('change', '.js_set_city', function () { //二级城市选项
                    var parentVal = $(this).attr('parentId');
                    if($(this).is(':checked')){
                        $('.js_set_province:checked').each(function () {
                            if ($(this).val() == parentVal) {
                                $(this).attr('all', 0);//标记二级非全部
                            }
                        })
                    }else{
                        if(!$(this).closest('.js_set_city_wrap').find('.js_set_city:checked').length){
                            $('.js_set_province:checked').each(function () {
                                if ($(this).val() == parentVal) {
                                    $(this).attr('all', 1);//1级默认全选
                                }
                            })
                        }
                    }

                });

                $('.js_set_city_confirm').on('click', function () { //点击确认按钮
                    var region = [];
                    var regionName = [];
                    $(".js_set_province:checked").each(function () {
                        if ($(this).attr('all') == 1 ) { //判断城市是否为默认全部
                            var parentid=$(this).val();
                         //   region.push($(this).val());//所选的省id
                            regionName.push($(this).next('span').html());//名称
                            $(".js_set_city[parentid='"+parentid+"']").each(function(){
                                region.push($(this).val());

                            })
                        }
                    });
                    $(".js_set_city:checked").each(function () {
                        region.push($(this).val());
                        regionName.push($(this).next('span').html())
                    });
                    $('#js_push_set_region_code').val(region);
                    $('#js_push_set_city').val(regionName);
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_region_pop').hide();
                });

                $(".js_set_city_cancel").on('click', function () {//点击取消
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_region_pop').hide();
                })

            },
            set_industry: function () {
                $('#js_push_set_category').on('click', function () { //弹出弹框js_provinces_wrap
                    $('.js_masklayer').show();
                    $('.js_push_news_category_pop').show();
                });

                $('.js_set_category').on('change', function () { //选择一级行业 显示2级列表
                    var parentid = $(this).val();
                    if ($(this).is(':checked')) { //选中
                        $(this).attr('all', 1);//标记默认全选
                        $(".js_set_second_label[parentid='"+parentid+"']").show();

                    } else { //取消选中
                        $(".js_set_second_label[parentid='"+parentid+"']").hide();
                        $(".js_set_second_category[parentid='" + parentid + "']").removeAttr('checked');//清除已选择的二级菜单

                    }
                });

                $('.js_set_second_category').on('change', function () { //二级城市选项
                    var parentid = $(this).attr('parentid');
                    if($(this).is(':checked')){ //选中
                        $('.js_set_category:checked').each(function () {
                            if ($(this).val() == parentid) {
                                $(this).attr('all', 0);//标记二级非全部
                            }
                        })

                    }else{ //取消选中
                        if(!$(this).closest('.js_category_list_wrap').find('.js_set_second_category:checked').length){
                            $('.js_set_category:checked').each(function () {
                                if ($(this).val() == parentid) {
                                    $(this).attr('all', 1);//1级默认全选
                                }
                            })
                        }

                    }

                });

                $('.js_set_category_confirm').on('click', function () { //点击确认
                    var category = [];
                    var categoryName = [];
                    $(".js_set_category:checked").each(function () {
                        if ($(this).attr('all') == 1) { //判断否为默认全部行业
                            var parentid=$(this).val();//所选id
                            categoryName.push($(this).next('span').html());//名称
                            $(".js_set_second_category[parentid='"+parentid+"']").each(function(){
                                category.push($(this).val());

                            })
                        }
                    });

                    $(".js_set_second_category:checked").each(function () {
                        category.push($(this).val());
                        categoryName.push($(this).next('span').html());
                    });

                    $('#js_push_set_category_code').val(category);
                    $('#js_push_set_category').val(categoryName);
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_category_pop').hide();//关闭弹框
                });

                $('.js_set_category_cancel').on('click', function () { //关闭弹框
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_category_pop').hide()
                })


            },
            set_Job: function () {
                $('#js_push_set_job').on('click', function () { //弹出弹框
                    $('.js_masklayer').show();//遮罩层
                    $('.js_push_news_job_pop').show();
                });

                $('.js_set_industry').on('change', function () { //选择行业获取职能列表
                    var parentid = $(this).val();
                    if ($(this).is(':checked')) { //选中
                        $(this).attr('all', 1);//标记默认全选
                        $(".js_set_job_label[parentid='"+parentid+"']").show();
                    } else { //取消选中
                        $(".js_set_job_label[parentid='"+parentid+"']").hide();
                        $(".js_set_job[parentid='" + parentid + "']").removeAttr('checked');//清除已选择的二级菜单

                    }
                });

                $('.js_set_job').on('change', function () { //二级
                    var parentid = $(this).attr('parentid');
                    if($(this).is(':checked')) { //选中
                        $('.js_set_industry:checked').each(function () {
                            if ($(this).val() == parentid) {
                                $(this).attr('all', 0);//标记二级非全部
                            }
                        })
                    }else{
                        if(!$(this).closest('.js_set_job_wrap').find('.js_set_job:checked').length){
                            $('.js_set_industry:checked').each(function () {
                                if ($(this).val() == parentid) {
                                    $(this).attr('all', 1);//1级默认全选
                                }
                            })
                        }

                    }

                });

                $('.js_set_job_confirm').on('click', function () { //点击确认
                    var job = [];
                    var jobName = [];
                    $(".js_set_industry:checked").each(function () {
                        if ($(this).attr('all') == 1) { //判断否为默认全部
                            var parentid = $(this).val();//所选id
                            jobName.push($(this).next('span').html());//名称
                            $(".js_set_job[parentid='"+parentid+"']").each(function(){
                                job.push($(this).val());

                            })
                        }
                    });
                    $(".js_set_job:checked").each(function () {
                        job.push($(this).val());
                        jobName.push($(this).next('span').html())
                    });

                    $('#js_push_set_job_code').val(job);
                    $('#js_push_set_job').val(jobName);
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_job_pop').hide();
                });

                $('.js_set_job_cancel').on('click', function () { //关闭弹框
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('.js_push_news_job_pop').hide()
                })


            },
            preview: function () {//预览带推送资讯
                var that = this;
                $('.js_news_preview').on('click', function () {
                    var showid = $(this).attr('val');
                    that.getPreview(showid);

                })
            },
            loop: 0,//循环起始值，判断循环次数
            getCityList: function (id) { //通过省份ID 获取省份的城市列表
                var that = this;
               // $(".js_city_list_wrap").hide();
                var $listWrap = $(".js_city_list_wrap[code='" + id + "']");
                if ($listWrap.length < 1) { //判断是否加载过
                    $.ajax({
                        url: gGetAddressUrl,
                        type: "get",
                        data: {action: "cityList", id: id},
                        async:false,
                        success: function (response) {
                            var $wrap = $("#city_list");
                            $wrap.append("<div class='js_city_list_wrap' code=" + id + "></div>");
                            $listWrap = $(".js_city_list_wrap[code='" + id + "']");
                            $.each(response, function () {
                                $listWrap.append(
                                "<label class='label_1-5 '>" +
                                "<input class='js_set_city' type='checkbox' value="+this.code+" parentId="+id+" />" +
                                "<span>"
                                +this.name+"" +
                                "</span>" +
                                "</label>"
                                );
                            });
                            that.loop = 0;
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

                    $listWrap.show();
                }

            },
            getPreview: function (showid) {  //通过showid 获取待推送资讯的详细信息
                $('#js_btn_preview_prev,#js_btn_preview_next,.Check_bin').hide();//编辑框中预览只有一条，隐藏翻页和所有按钮
                $.news.preview(showid,3);//2代表未审核的资讯


            },
            submitPush:function(){
                var title=[];
                var showid=[];
                var sort=[];
                var coverurl=[];
                var createdtime=[];

                $("input[name='title[]']").each(function(){
                    title.push($(this).val());
                });
                $("input[name='showid[]']").each(function(){
                    showid.push($(this).val());
                });
                $("input[name='sort[]']").each(function(){
                    sort.push($(this).val());
                });
                $("input[name='coverurl[]']").each(function(){
                    coverurl.push($(this).val());
                });
                $("input[name='createdtime[]']").each(function(){
                    createdtime.push($(this).val());
                });
               var region=$("#js_push_set_region_code").val();
               var industry=$("#js_push_set_category_code").val();
               var func=$("#js_push_set_job_code").val();
               if(region=='' && industry=='' && func==''){ //地区 行业 任选其一
                   $.global_msg.init({gType: 'warning', msg: '请填写完整信息', icon: 1});
                   return false;

               }
                /*判断排序是否有重复*/
                var sortArr=sort.slice(0).sort();
                for(var i= 0;i<sortArr.length-1;i++){
                    if(sortArr[i]==sortArr[i+1]){
                        $.global_msg.init({gType: 'warning', msg: '文章存在相同排序，请重新排序', icon: 1});
                        return false;
                        break;
                    }

                }
                $.ajax({
                    url: gSubmitPushUrl,
                    type: 'post',
                    data: {
                        title:title,
                        showid:showid,
                        sort:sort,
                        coverurl:coverurl,
                        createdtime:createdtime,
                        isnotice:$("#js_push_set_inform").val(),
                        pushtime:$("#js_begintime").val(),
                        region:region,
                        industry:industry,
                        func:func

                    },
                    success: function (response) {
                        //获取预览数据
                        if (response.status == 0) {
                            location.href=gWillPushListUrl;
                        } else {
                            $.global_msg.init({gType: 'warning', msg: '推送失败', icon: 1});
                        }


                    },
                    error: function () {
                        $.global_msg.init({gType: 'warning', msg: '推送失败', icon: 1});
                    }

                });

            }
        }

    });
})(jQuery);