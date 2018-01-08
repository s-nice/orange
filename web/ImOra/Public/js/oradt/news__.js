/**
 *资讯  问答 页面js
 */
var gloable_showid = '';//已选资讯id
var checkObj;//全选对象
var commentCurrentPreviewObj, commentCurrentPreviewObjIndex;//当前预览中的评论数组，及选择的索引
var checkDataIndex = 0; //选中数据当前被执行的索引
var maxDate= new Date().format(); //时间插件时间限制
var maxTime= new Date().format('H:i');
(function ($) {
    $.extend({
        news: {
            init: function () {
                var that = this;
                this.initCalendar();////表情转换   全选框  行业信息下拉框 初始化
                this.delNews(); //删除资讯  问答
                this.selTitle(); //下拉选择事件
                this.searchStart(); //点击搜索按钮 执行查询
                this.orderById();    //根据id排序
                this.orderByTime();              //根据时间排序
                this.orderByCilckNum(); //根据点击数排序
                this.orderByCommentNum();//根据评论数排序
                this.orderByCollectNum(); //根据收藏数排序
                this.orderByShareNum();//根据分享数排序
                this.publishToAudit(); //发布到审核   编辑弹框中的发布资讯到审核按钮
                this.successAudit();//审核通过多条资讯
                this.successOne();//审核通过一条资讯
                this.failAudit();//审核不通过多条资讯
                this.failOne();//审核不通过一条资讯
                this.delOne();//删除一条资讯
                this.storageInfomation(); //暂存资讯
                this.reviewNow(); //点击发布资讯页面的  预览按钮
                this.publishInfoToAudit();//发布资讯页面的  发布资讯到审核按钮
                this.addTitlePic(); //上传资讯标题图片
                this.addContentPic(); //上传资讯内容图片
                this.cancelPublishInfo(); //取消发布资讯
                this.commentPass();//评论审核通过
                this.commentPreview(); //评论预览
                this.commentOrder();// 评论相关排序
                this.privewNews();//批量预览资讯  问答 置顶 撤销
                this.editNews();//编辑资讯  问答
                this.releaseTime(); //发布时间


                $('#commentor').on('click', this.popupCommentors); // 点击输入框， 弹出beta用户列表， 供选择作为资讯评论人
                this.listenPopCommentor();
                this.listentAddCommentButton();

                $('#js_label').on('click', this.popupLabels); // 点击输入框， 弹出标签列表， 供选择标签
                this.listenPopLabel();


                //未提交资讯单条点击提交到审核按钮
                //state 1：暂存待提交（包括审核未通过）；2：发布待审核；3：审核成功（待推送）；5：删除;6已推送；
                $('.js_single_submit_check').on('click', function () {
                    var showid = $(this).attr('data-id');
                    that.updateStateById(showid, 2);


                });
                //未提交资讯单条点击到删除按钮
                $('.js_single_delete').on('click', function () {
                    var showid = $(this).attr('data-id');
                    $.global_msg.init({gType: 'confirm',
                        icon: 2,
                        msg: '确认删除资讯？',
                        btns: true, close: true,
                        title: false, btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            that.updateStateById(showid, 5);
                        }});

                });

                //已推送资讯单条点击撤销按钮
                $('.js_single_undo').on('click', function () {
                    var showid = $(this).attr('data-id');
                    $.global_msg.init({gType: 'confirm',
                        icon: 2,
                        msg: '确认撤销资讯？',
                        btns: true, close: true,
                        title: false, btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            that.updateStateById(showid, 3);
                        }});

                });

                $('#js_selkeyword').on('click', function () { //搜索标签弹框
                    if ('label' == $('#js_titlevalue').attr('seltitle')) {
                        that.popupLabels('radio');
                    }

                });

                $('.js_single_edit').on('click',function(){ //列表中编辑 打开新页面编辑
                    var showid=$(this).attr('data-id');
                    window.open(editUrl+'/showid/'+showid);

                });

                $('#js_edit_cancel').on('click',function(){ //编辑页面点击取消按钮

                    if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                        window.opener.closeWindow(window, false);
                    }

                });

                $('#js_news_edit_save').on('click',function(){ //编辑页面点击 暂存 和发布（未更改状态）
                    that.newPageEdit(gstate);

                });

                $('#js_news_edit_audit').on('click',function(){ //未提交资讯编辑到审核
                    that.newPageEdit(2); //2为待审核状态

                });
                /*选择标签包裹层初始化滚动条*/
                $('#selected_labels_wrap,#js_industry_select_wrap').mCustomScrollbar({
                    theme:"dark", //主题颜色
                    autoHideScrollbar: true, //是否自动隐藏滚动条
                    scrollInertia :0,//滚动延迟
                    horizontalScroll : false //水平滚动条
                });

              /*  $('.content_global').on('mouseover','#selected_labels',function () {
                    $('#selected_labels_wrap').mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: true, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false //水平滚动条
                    });
                });*/

                if($('.js_label').length >0){ //编辑标签初始化
                    $('#selected_labels .js_label,#selected_labels,.js_add_label').show();//显示包裹层

                }

                $('#js_releasetime').on('mousedown',function(){
                    maxDate= new Date().format(); //时间插件时间限制
                    maxTime= new Date().format('H:i');
                    $('#js_releasetime').datetimepicker({
                        format: "Y-m-d H:i", lang: 'ch',
                        showWeak: true,
                        timepicker: true,
                        step: 1, //跨度默认为60 不显示分钟 1显示分钟
                        maxDate:maxDate,
                        maxTime:maxTime
                    });

                });


                //选择行业下拉框js
                $('#js_industry_select_wrap').on('click','li',function(){
                    $('#js_industry_select').val($(this).html());
                    $('#js_industryId').val($(this).attr('data-id'));
                    $('#js_industry_select_wrap').hide();

                })


            },
            //根据单个id修改资讯状态
            //状态 1：暂存待提交（包括审核未通过）；2：发布待审核；3：审核成功（待推送）；5：删除;6已推送；
            updateStateById: function (showid, state) {
                $.post(publishauditurl, {showid: showid, state: state}, function (data) {
                    if ('0' != data['status']) {
                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                        return;
                    }
                    $.global_msg.init({
                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                            $.news.pageReload();

                        }
                    });
                })

            },
            //发布时间
            releaseTime: function () {
                $('#js_releasetime').datetimepicker({
                    format: "Y-m-d H:i", lang: 'ch',
                    showWeak: true,
                    timepicker: true,
                    step: 1, //跨度默认为60 不显示分钟 1显示分钟
                    maxDate:maxDate,
                    maxTime:maxTime
                });
            },
            //表情转换   全选框  行业信息下拉框
            initCalendar: function () {
       /*         $('.js_emoji_toimg').each(function () {        //将表情符号转换成表情图片
                    var $obj = $(this);
                    //内容
                    if ($obj.html() == '') {
                        return;
                    }
                    $obj.html($.expBlock.textFormat($obj.html()));
                });*/
                $.dataTimeLoad.init();//初始化时间插件
                //初始化页面中的全选框功能
                checkObj = $('.content_hieght').checkDialog({
                    checkAllSelector: '#js_allselect', checkChildSelector: '.js_select',
                    valAttr: 'val', selectedClass: 'active'
                });
                //点击下拉框之外的空白区域   行业信息下拉选择框隐藏
                $(document).click(function (e) {
                    if ($(e.target).attr('id') == 'js_previewtitlevalue' || $(e.target).attr('id') == 'js_titlevalue') {
                        $('.js_new_cate_list').show();
                        return;
                    }
                    if ($('.js_new_cate_list').is(":visible")) {
                        $('.js_new_cate_list').hide();
                    }
                });
                //点击跳转链接时  先判断页面中是否有未保存的内容
                $('a').on('click', function () {
                    if ($('#textarea_right').length == 0) {   //判断是不是在资讯添加页面
                        return;
                    }
                    var title = $('#js_title').val();
                    var keyword = $('#js_keyword').val();
                    var content = ue.getContent();
                    //先判断标题  内容  关键词是否为空
                    if (title != '' || content != '') {
                        if (!confirm(gStrLeaveTip)) {
                            return false;
                        }
                    }
                })

            },


            //点击删除按钮
            delNews: function () {
                $('#js_delnews').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();  //获取选中的资讯或问答id
                    if (gloable_showid == '') {  //判断是否选择了要删除的资讯
                        $.global_msg.init({gType: 'warning', msg: gStrselectdelnews, icon: 2});
                        return;
                    }
                    //判断要删除的是资讯 还是问答
                    var tipmsg = gStrconfirmdelnews;
                   /* if (gStrInfoType == 'ask') {
                        tipmsg = gStrconfirmdelasks;
                    }*/
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: tipmsg, btns: true, close: true,
                        title: false, btn1: gStrcanceldelnews, btn2: gStryesdelnews, noFn: function () {
                            $.post(delnewsurl, {showid: gloable_showid}, function (data) {
                                if ('0' == data['status']) {  //删除成功
                                    $.global_msg.init({
                                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {//判断当前页面是否还有列表
                                            $.news.pageReload();
                                        }
                                    });

                                } else {
                                    $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                }
                            })
                        }
                    });

                })
            },


            //删除或更新成功后  执行页面刷新效果
            pageReload: function () {
                $('.content_c .active').parent('span').parent('div').remove();
                var url = $.news.searchParam();
                var listnumb = $('.content_c .js_select').length;
                if (listnumb < 1) {
                    //翻页到前一页
                    var p = $('.page').find('.current').html() - 1;
                    url += '/p/' + p;

                }
                window.location.href = url;
            },

            //点击下拉选择事件
            selTitle: function () {
                //显示或隐藏下拉框
                $('.js_select_item i').on('click', function () {
                    $(this).closest('.js_select_item').find('ul').toggle();
                });
                $('.js_select_item .span_name input').on({
                    'click': function () {
                        $(this).closest('.js_select_item').find('ul').toggle();
                        $(this).blur();
                    }
                });
                //选择下拉框的数据
                var selOdiv = $('#js_selcontent');
                var titleOdiv = $('#js_titlevalue');
                selOdiv.on('click', 'li', function () {
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    titleOdiv.attr({'value': content, 'title': content, 'seltitle': title});
                    titleOdiv.val(content);
                    selOdiv.hide();
                })

                //点击区域外关闭此下拉框
                $(document).on('click', function (e) {
                    if ($(e.target).parents('.js_select_item').length > 0) {
                        var currUl = $(e.target).parents('.js_select_item').find('ul');
                        $('.js_select_item>ul').not(currUl).hide()
                    } else {
                        $('.js_select_item>ul').hide();
                    }
                });
            },


            //点击搜索按钮 执行查询
            searchStart: function () {
                $('#js_searchbutton').on('click', function () {
                    window.location.href = $.news.searchParam();
                })
            },

            //搜索条件拼接
            searchParam: function () {
                var condition = '';
                var keyword = encodeURIComponent($('#js_selkeyword').val());
                var starttime = $('#js_begintime').val();
                var endtime = $('#js_endtime').val();
                var type = $('#js_titlevalue').attr('seltitle');
                var industryName=encodeURIComponent($('#js_industry_select').val());
                var industryId=$('#js_industryId').val();

                condition += '/search_type/' + type;
                if (keyword != '') {
                    condition += '/keyword/' + keyword;
                }
                if (starttime != '') {
                    condition += '/starttime/' + starttime;
                }
                if (endtime != '') {
                    condition += '/endtime/' + endtime;
                }
                if (type == 'label') {
                    var tagId = $("input[name='tagsId']").val(); //标签的id
                    condition += '/tagId/' + $("input[name='tagsId']").val();

                }
                if(industryId!='' && industryName!='行业'){
                    condition += '/industryId/' + industryId;
                    condition += '/industryName/' + industryName;

                }

                return searchurl + condition;
            },
            //点击按id排序
            orderById: function () {
                $('#js_orderbyid').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('id', type);
                })
            },

            //点击按时间排序
            orderByTime: function () {
                $('#js_orderbytime').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    //排序的时间类型 有推送时间 pushtime 发布时间releasetime  默认releasetime
                    var timetype=typeof ($(this).attr('timetype'))!='undefined' ? $(this).attr('timetype'): 'releasetime'; //releasetime   datetime
                    $.news.orderByCondition(timetype, type);
                });
            },

            //点击按点击量排序
            orderByCilckNum: function () {
                $('#js_orderbyclick').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('clickcount', type);
                })
            },

            //点击按评论数排序
            orderByCommentNum: function () {
                $('#js_orderbycomment').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('commentcount', type);
                })
            },

            //点击按收藏数排序
            orderByCollectNum: function () {
                $('#js_orderbycollect').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('collectcount', type);
                })
            },

            //点击按分享数排序
            orderByShareNum: function () {
                $('#js_orderbyshare').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('sharecount', type);
                })
            },

            //查询条件拼接  str string  排序字段
            orderByCondition: function (str, type) {
                var condition = $.news.searchParam();

                condition += '/order/' + str;
                condition += '/ordertype/' + type;
                window.location.href = condition;
            },


            /**
             * 点击发送到审核按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败   5删除
             * 目前是发送资讯到审核   即发布待审核状态  state 为2
             * */
            publishToAudit: function () {
                $('#js_publishtoaudit').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();
                    if (gloable_showid == '') { //未选择要审核内容
                        $.global_msg.init({gType: 'warning', msg: gStrselectpublishnews, icon: 2});
                        return;
                    }
                    $.post(publishauditurl, {showid: gloable_showid, state: 2}, function (data) {
                        if ('0' != data['status']) {
                            $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                            return;
                        }
                        $.global_msg.init({
                            gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                $.news.pageReload();

                            }
                        });
                    })
                })
            },


            /**
             * 点击审核通过按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败
             * 目前是审核成功   即通过审核状态  state 为3
             * */
            successAudit: function () {
                $('.js_successaudit').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();
                    $.news.successShowid();
                })
            },

            /**
             * 点击单条资讯后面的审核通过按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败
             * 目前是审核成功   即通过审核状态  state 为3
             * */
            successOne: function () {
                $('.js_successone').on('click', function () {
                    $(this).parents('.sectionnotau_list_c').find('.js_select').addClass('active');
                    gloable_showid = $(this).attr('val');
                    $.news.successShowid();
                })
            },

            /**
             * 执行多条资讯或问答审核通过的方法
             * */
            successShowid: function () {
                //未选择审核内容
                if (gloable_showid == '') {
                    $.global_msg.init({gType: 'warning', msg: gStrselectauditnews, icon: 2});
                    return;
                }
                $.post(publishauditurl, {showid: gloable_showid, state: 3}, function (data) {
                    if ('0' != data['status']) {
                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                        return;
                    }
                    $.global_msg.init({
                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                            $.news.pageReload();
                        }
                    });
                })
            },

            /**
             * 点击审核不通过按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败
             * 目前是审核不通过   即审核失败状态  state 为4
             * */
            failAudit: function () {
                $('.js_failaudit').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();
                    $.news.failShowid();
                })
            },

            /**
             * 点击单条资讯后面的审核不通过按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败
             * 目前是审核不通过   即审核失败状态  state 为4
             * */
            failOne: function () {
                $('.js_failone').on('click', function () {
                    gloable_showid = $(this).attr('val');
                    //选中要删除的列
                    $(this).parents('.sectionnotau_list_c').find('.js_select').addClass('active');
                    $.news.failShowid();
                })
            },

            /**
             * 点击单条资讯后面的删除按钮
             * state 分四种   1：待发布状态  2：发布待审核  3.审核成功  4审核失败  5删除
             * 目前是删除   即删除状态  state 为5
             * */
            delOne: function () {
                $('.js_delone').on('click', function () {
                    var showid = $(this).attr('val');
                    if (showid == '') {  //资讯或问答id为空时 不执行删除
                        $.global_msg.init({gType: 'warning', msg: gStrselectdelnews, icon: 2});
                        return;
                    }
                    //将当前列选中
                    $(this).parents('.sectionnotau_list_c').find('.js_select').addClass('active');
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: gStrconfirmdelnews, btns: true, close: true,
                        title: false, btn1: gStrcanceldelnews, btn2: gStryesdelnews, noFn: function () {
                            $.post(delnewsurl, {showid: showid}, function (data) {
                                if ('0' == data['status']) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                            $.news.pageReload();
                                        }
                                    });

                                } else {
                                    $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                }
                            })
                        }
                    });

                })
            },

            /**
             * 执行审核失败的方法
             * */
            failShowid: function () {
                if (gloable_showid == '') {
                    $.global_msg.init({gType: 'warning', msg: gStrselectauditnews, icon: 2});
                    return;
                }
                //资讯审核未通过状态为1
                var state =1;
                //审核不通过   资讯自动返回到未发布状态  1为未发布
                $.post(publishauditurl, {showid: gloable_showid, state: state}, function (data) {
                    if ('0' != data['status']) {
                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                        return;
                    }
                    $.global_msg.init({
                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                            $.news.pageReload();
                        }
                    });
                })
            },

            /**
             * 点击发布资讯页的暂存按钮
             * state 1：暂存待提交（包括审核未通过）；2：发布待审核；3：审核成功（待推送）；5：删除;6已推送；
             * */
            storageInfomation: function () {
                $('#js_storagedata').on('click', function () {
                    $.news.newsHandleData(1);//暂存待发布
                })
            },


            /**
             * 点击发布资讯页面和所有编辑预览的  预览按钮
             *
             * */
            reviewNow: function () {
                $('#js_review_now').on('click', function () {
                    //获取页面中的值  替换预览弹框中的内容
                    var titlObj = $('#js_title');
                    //var contentObj = $('#js_content');
                    //var contentObj = $('#js_content .mCSB_container');
                    var keyObj = $('#js_keyword');
                    var titlevalObj = $('#js_titlevalue');
                    var title = titlObj.val();
                    //var content = contentObj.html();
                    var content = ue.getContent();
                    var $content=$(content);
        			$content.find('img[audio]').each(function(){
        				var src=$(this).attr('audio');
        				var $audio=$("<audio src='"+src+"' controls></audio>");
        				$(this).after($audio).remove();
        			});
                    var categoryid = titlevalObj.val();
                    var title_pic = $('#title_pic').attr('src');
                    var allObj = $('.js_btn_new_preview');
                    if (title_pic != '') {
                        allObj.find('.js_title_img').attr('src', title_pic);
                    } else {
                        allObj.find('.js_title_img').remove();
                    }
                    allObj.find('.js_title').html(title);
                    allObj.find('.js_category').html(categoryid);

                    allObj.find('.js_time').html($('#js_releasetime').val().substring(5).replace('-', '/'));
                    allObj.find('.js_content1').html($content);
                    allObj.find('.Check_bin').hide();
                    $('#js_btn_preview_prev, #js_btn_preview_next').hide();
                    //滚动条
                    var scrollObj = $('.js_btn_new_preview .js_new_summey');
                    if (!scrollObj.hasClass('mCustomScrollbar')) {
                        scrollObj.mCustomScrollbar({
                            theme: "dark", //主题颜色
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia: 0,//滚动延迟
                            horizontalScroll: false,//水平滚动条
                        });
                    }
                    $('.js_btn_new_preview,.js_masklayer').show();
                    //关闭弹出层
                    allObj.find('.js_btn_close').click(function () { //停止播放音频
                       var $audio=allObj.find('audio');
                        console.log(allObj);
                        for(var i=0; i<$audio.length; i++) {
                            $audio.get(i).pause();
                        }
                        allObj.hide();
                        $('.js_masklayer').hide();
                    });
                })
            },

            /**
             * 点击发布资讯页的发布到审核按钮
             *  state 1：暂存待提交（包括审核未通过）；2：发布待审核；3：审核成功（待推送）；5：删除;6已推送；
             * */
            publishInfoToAudit: function () {
                $('#js_adddata').on('click', function () {
                    $.news.newsHandleData(2);//发布到审核
                })
            },

            /**
             * 发布资讯页面    发布到审核和暂存待发布 数据处理
             * @param state 状态   1暂存待发布  2发布到审核
             *
             * */
            newsHandleData: function (state) {
                var titlObj = $('#js_title');
                var keyObj = $('#js_keyword');
                var webfromObj = $('#js_webfrom');
                var titlevalObj = $('#js_titlevalue');
                var releasetime = $('#js_releasetime').val();
                var title = titlObj.val();
                if (title.length > 128) { //控制标题长度
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrtitleoutlimit});
                    return;
                }
                //var content = contentObj.html();
                var content = ue.getContent();
                var keyword = keyObj.val();
                var webfrom = webfromObj.val();
                if (keyword.length > 100) { //控制关键字长度
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrkeywordoutlimit});
                    return;
                }
                var categoryid = titlevalObj.attr('seltitle');
                var title_pic = $('#title_pic').attr('src');
               // console.log(title,content,title_pic);
                if (title == '' || content == '' || title_pic == '') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrnotnullalloption});
                    return;
                }
                /*state 2发布待审核 isfilter 是否过滤敏感词  0 过滤 1不过滤*/
                var postParams = {
                    title: title,
                    releasetime: releasetime,
                    content: content,
                    categoryid: categoryid,
                    webfrom: webfrom,
                    //keyword:keyword,
                    state: state,
                    titlepic: title_pic,
                    isfilter: 0,
                    labels: $.news._getSelectedLabelIds(),
                    author: $('#js_titleauthor').val()
                };
                $('.js_masklayer').show();
                $.post(urlAppadminAdd, postParams, function (data) {
                    if ('0' == data['status']) {
                        $('#js_title,#js_keyword,#js_webfrom,#js_releasetime,#js_titlevalue, #js_titleauthor').val('');
                        $('#uploadpic').val(gStrclickuploadpic);
                        $('#js_titlevalue').attr('seltitle', '');
                        $.global_msg.init({
                            gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                location.reload();
                            }
                        });
                    } else if ('1' == data['status']) {
                        $('.js_masklayer').hide();
                        var where = str_news_content;
                        if (data['type'] == 'title') {
                            where = str_news_title;
                        }
                        $.global_msg.init({
                            gType: 'confirm',
                            icon: 2,
                            msg: where + tip_has_illegalword1 + data['word'] + tip_has_illegalword2,
                            btns: true,
                            close: true,
                            title: false,
                            btn1: gStrcanceldelnews,
                            btn2: gStryesdelnews,
                            noFn: function () {
                                postParams.isfilter=1;
                                $.post(urlAppadminAdd, postParams, function (data) {
                                    if ('0' == data['status']) {
                                        $('#js_title,#js_keyword,#js_webfrom,#js_releasetime,#js_titlevalue, #js_titleauthor')
                                            .val('');
                                        $('#uploadpic').val(gStrclickuploadpic);
                                        $('#js_titlevalue').attr('seltitle', '');
                                        $.global_msg.init({
                                            gType: 'warning',
                                            msg: data['msg'],
                                            icon: 1,
                                            endFn: function () {
                                                location.reload();
                                            }
                                        });
                                    } else {
                                        $('.js_masklayer').hide();
                                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                    }
                                })
                            },
                            endFn: function () {
                                //敏感词换成红色的
                                var list = data['word'].split(',');
                                list.sort(function (a, b) {
                                    return a.length > b.length ? 1 : -1;
                                });

                                //删除子重复的关键词（[屋顶啊,屋顶]的话，删除"屋顶"）
                                for (var i = 0; i < list.length; i++) {
                                    for (var j = i; j < list.length; j++) {
                                        if (list[i] != list[j] && list[j].indexOf(list[i]) >= 0) {
                                            list.splice(i, 1);
                                            i--;
                                            break;
                                        }
                                    }
                                }

                                for (var i = 0; i < list.length; i++) {
                                    var reg = new RegExp(list[i], "g");
                                    content = content.replace(reg, '<span style="color:red;">' + list[i] + '</span>');
                                }
                                ue.setContent(content);
                            }
                        });

                    } else {
                        $('.js_masklayer').hide();
                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});


                    }

                })
            },

            /**
             * 点击发布资讯页面的取消按钮  页面返回上一页
             * */
            cancelPublishInfo: function () {
                $('#js_cancelpub').on('click', function () {
                    window.history.back();
                })
            },


            /**
             * 点击标题图片上传框   上传图片
             * 执行uploadfile方法  传参  上传图片的filename
             * */
            addTitlePic: function () {
                $('#upload_logo').off('change').on('change', '#uploadImgField1', function () {
                    var fileNameHid = $('#uploadpic').attr('hid');
                    $.news.uploadAddPageFile(fileNameHid, 'title');
                })
            },

            /**
             * 点击正文图片上传框   上传图片
             * 执行uploadfile方法  传参  上传图片的filename
             * */
            addContentPic: function () {
                var obj = $('#upload_contentpic_form');
                $('.js_moni_upload').click(function () {
                    //$('#uploadContentImg').click();
                });
                //$("#textarea_right #js_content").attr("contentEditable", "true");
                obj.on('change', '#uploadContentImg', function () {
                    var fileNameHid = $('#uploadcontentpic').val();
                    $.news.uploadAddPageFile(fileNameHid, 'content');
                })
            },

            /**
             * 资讯添加页面上传图片
             * fileNameHid 图片名称
             * type 为content是上传内容图片  title是上传标题图片
             * */
            uploadAddPageFile: function (fileNameHid, type) {
                $.ajaxFileUpload({
                    url: gUrlUploadFile,
                    secureuri: false,
                    fileElementId: fileNameHid,
                    data: {fileNameHid: fileNameHid},
                    dataType: 'json',
                    success: function (rtn, status) {
                        var imgUrl = rtn.data.absolutePath;
                        if (type == 'content') {
                            var imgUrl = rtn.data.absolutePath;
                            var allObj = $('#textarea_right ');
                            //var content = allObj.find('.js_content').html();
                            var content = '<img src="' + imgUrl + '" /><br/>';
                            //将图片插入到光标显示位置
                            allObj.find('.js_content').focus();
                            insertHtmlAtCaret(content)

                        } else {
                            $('#title_pic').attr('src', imgUrl);
                            $('#uploadpic').val(imgUrl);
                            $('#title_pic').show();
                        }
                    },
                    error: function (data, status, e) {
                    }
                });
            },

            /**
             * 资讯编辑弹框上传图片
             * fileNameHid 图片名称
             * type 为content是上传内容图片  title是上传标题图片
             * */
            uploadFile: function (fileNameHid, type) {
                $.ajaxFileUpload({
                    url: gUrlUploadFile,
                    secureuri: false,
                    fileElementId: fileNameHid,
                    data: {fileNameHid: fileNameHid},
                    dataType: 'json',
                    success: function (rtn, status) {
                        var imgUrl = rtn.data.absolutePath;
                        if (type == 'content') {

                            var imgUrl = rtn.data.absolutePath;
                            var allObj = $('.js_new_edit_publish ');
                            var content = '<img src="' + imgUrl + '" /><br/>';
                            //将图片插入到光标显示位置
                            allObj.find('.js_content').focus();
                            insertHtmlAtCaret(content)
                            $(".js_new_edit_publish .js_content").find('.js_content').attr("contentEditable", "true");
                        } else {
                            $('#title_pic').attr('src', imgUrl);
                            $('#uploadpic').val(imgUrl);
                            $('#title_pic').show();
                        }
                    },
                    error: function (data, status, e) {
                    }
                });
            },
            /**
             * 获取选择好的标签id列表；
             */
            _getSelectedLabelIds: function () {
                var labelIds = [];
                var $selectedLabels = $('#selected_labels .js_label');
                for (var i = 0; i < $selectedLabels.length; i++) {
                    labelIds.push($selectedLabels.eq(i).attr('data-id'));
                }
                return labelIds;
            },

            //编辑资讯问答内容（批量操作）
            editNews: function () {
                //编辑按钮
                $('.js_btn_edit').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();

                    if (gloable_showid == '' || gloable_showid.indexOf(',') != -1) {
                        $.global_msg.init({gType: 'warning', msg: str_select_audit_edit, icon: 2});
                        return;
                    }
                    $('.section_list_c i.active').parent().siblings('.js_review_notpublish').click();
                });

                var allObj = $('.js_new_edit_publish');
      /*          $('.js_review_notpublish, .js_single_edit').on('click', function () {
                    //单个编辑采集内容
                    if ($(this).hasClass('js_no_push_news_edit')) { //判断 未提交页面 显示暂存按钮
                        $('.js_edit_pushlish_save').show();
                    }


                    var id = $(this).attr('data-id');
                    $.news.showEditNewContent(id);
                });*/
                //编辑时上传文件
                allObj.on('change', '#newEditUpload', function () {
                    $.news.newTitlePicUpload();
                });
                //编辑时正文上传内容
                allObj.on('change', '#newUploadImgField', function () {
                    $.news.uploadFile('newUploadImgField', 'content');
                });
                allObj.on('click', '.js_publish_toaudit , .js_edit_pushlish_save', function () {
                    var titlObj = $('#js_title');
                    //var contentObj = $('#js_content');
                    //var contentObj = $('#js_content .mCSB_container');
                    var keyObj = $('#js_keyword');
                    var webfromObj = $('#js_webfrom');
                    var picObj = $('#title_pic');
                    var titlevalObj = $('#js_previewtitlevalue');
                    var title = titlObj.val();
                    if (title.length > 128) { //控制标题长度
                        $.global_msg.init({gType: 'warning', icon: 2, msg: gStrtitleoutlimit});
                        return;
                    }
                    //var content = contentObj.html();
                    var content = ue.getContent();
                    var keyword = keyObj.val();
                    var webfrom = webfromObj.val();
                    if (keyword.length > 128) { //控制标题长度
                        $.global_msg.init({gType: 'warning', icon: 2, msg: gStrkeywordoutlimit});
                        return;
                    }
                    var categoryid = titlevalObj.attr('cate-id');
                    var title_pic = $('#title_pic').attr('value');
                    if (title == '' || content == '' || title_pic == '' || categoryid == '0' || categoryid == '') {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: gStrnotnullalloption});
                        return;
                    }
                    var showid = $('.js_new_edit_publish').attr('data-id');
                    /*state 2发布待审核 isfilter为0时进行敏感词过滤  为1时不进行敏感词过滤*/

                    var params = {
                        title: title,
                        content: content,
                        categoryid: categoryid,
                        webfrom: webfrom,
                        keyword: keyword,
                        titlepic: title_pic,
                        showid: showid,
                        isfilter: 0,
                        labels: $.news._getSelectedLabelIds(),
                        author: $('#js_titleauthor').val()
                    };
                    if ($(this).hasClass('js_publish_toaudit')) { //判断是暂存 还是提交到审核
                        params.state = gState;
                    }

                    $.post(publishauditurl, params, function (data) {
                        if ('0' == data['status']) {
                            $.global_msg.init({
                                gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                    location.reload();
                                }
                            });
                        } else if ('1' == data['status']) {
                            var where = str_news_content;
                            if (data['type'] == 'title') {
                                where = str_news_title;
                            }
                            $.global_msg.init({
                                gType: 'confirm',
                                icon: 2,
                                msg: where + tip_has_illegalword1 + data['word'] + tip_has_illegalword2,
                                btns: true,
                                close: true,
                                title: false,
                                btn1: gStrcanceldelnews,
                                btn2: gStryesdelnews,
                                noFn: function () {
                                    $.post(publishauditurl, {
                                        title: title,
                                        content: content,
                                        categoryid: categoryid,
                                        keyword: keyword,
                                        state: gState,
                                        titlepic: title_pic,
                                        showid: showid,
                                        isfilter: 1,
                                        labels: $.news._getSelectedLabelIds(),
                                        author: $('#js_titleauthor').val()
                                    }, function (data) {
                                        if ('0' == data['status']) {
                                            $.global_msg.init({
                                                gType: 'warning',
                                                msg: data['msg'],
                                                icon: 1,
                                                endFn: function () {
                                                    location.reload();
                                                }
                                            });
                                        } else {
                                            $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                        }
                                    })
                                },
                                endFn: function () {
                                    var reg = new RegExp(data['word'], "g");
                                    content = content.replace(reg, '<span style="color:red;">' + data['word'] + '</span>');
                                    ue.setContent(content);
                                }
                            })
                        } else {
                            $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                        }
                    })
                })
            },
            //资讯中的编辑（单个操作）
            newPageEdit:function (state){
                var titlObj = $('#js_title');
                var keyObj = $('#js_keyword');
                var webfromObj = $('#js_webfrom');
                var titlevalObj = $('#js_titlevalue');
                var releasetime = $('#js_releasetime').val();
                var title = titlObj.val();
                if (title.length > 128) { //控制标题长度
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrtitleoutlimit});
                    return;
                }
                var content = ue.getContent();
                console.log(content);return;
                var keyword = keyObj.val();
                var webfrom = webfromObj.val();
                if (keyword.length > 100) { //控制关键字长度
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrkeywordoutlimit});
                    return;
                }
                var categoryid = titlevalObj.attr('seltitle');
                var title_pic = $('#title_pic').attr('src');
                if (title == '' || content == '' || title_pic == '') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrnotnullalloption});
                    return;
                }
                /*state 2发布待审核 isfilter 是否过滤敏感词  0 过滤 1不过滤*/
                var postParams = {
                    showid:showId,
                    title: title,
                    releasetime: releasetime,
                    content: content,
                    categoryid: categoryid,
                    webfrom: webfrom,
                    state: state,
                    titlepic: title_pic,
                    isfilter: 0,
                    labels: $.news._getSelectedLabelIds(),
                    author: $('#js_titleauthor').val()
                };
                //console.log(content);
                $.post(publishauditurl,postParams, function (data) {
                    if ('0' == data['status']) {
                        $.global_msg.init({
                            gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                console.log(typeof window.opener == 'object' && typeof window.opener.closeWindow=='function');
                                if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                    window.opener.closeWindow(window, true);
                                }
                            }
                        });
                    } else if ('1' == data['status']) {
                        var where = str_news_content;
                        if (data['type'] == 'title') {
                            where = str_news_title;
                        }
                        $.global_msg.init({
                            gType: 'confirm',
                            icon: 2,
                            msg: where + tip_has_illegalword1 + data['word'] + tip_has_illegalword2,
                            btns: true,
                            close: true,
                            title: false,
                            btn1: gStrcanceldelnews,
                            btn2: gStryesdelnews,
                            noFn: function () {
                                $.post(publishauditurl, {
                                    title: title,
                                    content: content,
                                    categoryid: categoryid,
                                    keyword: keyword,
                                    state:state,
                                    titlepic: title_pic,
                                    showid: showId,
                                    isfilter: 1,
                                    labels: $.news._getSelectedLabelIds(),
                                    author: $('#js_titleauthor').val()
                                }, function (data) {
                                    if ('0' == data['status']) {
                                        $.global_msg.init({
                                            gType: 'warning',
                                            msg: data['msg'],
                                            icon: 1,
                                            endFn: function () {
                                                if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                                    window.opener.closeWindow(window, true);
                                                }
                                            }
                                        });
                                    } else {
                                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                    }
                                })
                            },
                            endFn: function () {
                                var words = data['word'].split(',');
                                for ( var i in words) {
                                    var reg = new RegExp(words[i], "mg");
                                    content = content.replace(reg, '<span style="color:red;">' + words[i] + '</span>');

                                }
                                ue.setContent(content);
                            }
                        })
                    } else {
                        $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                    }
                })

            },

            //显示编辑资讯内容弹出层
            showEditNewContent: function (id) {
                var objs = [];
                objs.push(id);
                if (objs && objs.length > 0) {
                    var id = objs[0];
                    var data = {id: id};
                    $.get(gGetDataUrl, data, function (rst) {
                        $.news.initNewEditData(rst);
                    }, 'json');
                }
            },

            //初始化资讯编辑数据
            initNewEditData: function (rst) {
                var data = rst.data;
                var allObj = $('.js_new_edit_publish');
                allObj.show();
                $('.js_masklayer').show();
                allObj.attr('data-id', data.showid);
                allObj.find('.new_edit_title').val(data.title); //标题
                if (data.image != '') {
                    allObj.find('#js_new_file_path').val(data.image); //标题图片
                    $('#title_pic').attr({'value': data.image, 'src': data.image}); //标题图片
                }

                allObj.find('.new_edit_keyword').val(data.keyword); //关键字
                $('#js_titleauthor').val(data.author);
                $('#js_webfrom').val(data.webfrom);
                $('#js_releasetime').val(data.releasetime);
                allObj.find('.js_new_catebtn_show').attr('cate-id', data.categoryid);//所属行业
                allObj.find('.js_new_catebtn_show').attr('value', data.category);//所属行业
                allObj.find('.js_new_catebtn_show').val(data.category);//所属行业
                for (var i = 0; i < data.labels.length; i++) { //标签
                    $.news._addLabelItem(data.labels[i].name, data.labels[i].id);
                    $('#selected_labels .js_label').show();
                    $('#selected_labels,.js_add_label').show();//显示包裹层
                }
                var content = data.content + '<br/>';

                var closeBtn = allObj.find('.js_btn_close');
                var events = $._data(closeBtn[0], "events");
                if (!events || !events['click']) {
                    allObj.find('.js_btn_close').on('click', function () {
                        allObj.hide();
                        $('.js_masklayer').hide();
                        var cateObj = allObj.find('.js_new_cate_list');
                        cateObj.hide().mCustomScrollbar("destroy");
                    });
                }

                //行业下拉点击事件
                var catebtn = allObj.find('.js_new_catebtn_show');
                events = $._data(catebtn[0], "events");
                if (!events || !events['click']) {
                    allObj.find('.js_new_catebtn_show').click(function () {
                        var cateObj = allObj.find('.js_new_cate_list');
                        //cateObj.toggle();
                        cateObj.mCustomScrollbar({
                            theme: "dark", //主题颜色
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia: 1000,//滚动延迟
                            horizontalScroll: false//水平滚动条
                        });
                    });
                }
                if ($('#edui1').length == 0) {  //判断是否已经初始化编辑器  如果没有就初始化
                    baidu.editor.commands['audio'] = {
                        execCommand: function () {
                            var _this = this;
                            $('#audio_file').remove();
                            var $file = $("<input type='file' id='audio_file' name='tmpFile' style='display:none;'>");
                            $file.on('change', function () {
                                var $obj = $(this);
                                var val = $obj.val();
                                var names = val.split(".");
                                var allowedExtentionNames = ['mp3'];
                                if (names.length<2 || $.inArray(names[names.length-1], allowedExtentionNames) == -1) {
                                    //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
                                    $.global_msg.init({gType: 'warning', msg: gUeAudioFormatErrMsg, icon: 2});
                                    return;
                                }

                                $.ajaxFileUpload({
                                    url: URL_UPLOAD,
                                    secureuri: false,
                                    fileElementId: $obj.attr('id'),
                                    data: {exts: 'mp3'},
                                    dataType: 'json',
                                    success: function (data, status) {
                                    	if (typeof (data.url) != 'string') {
                                        	$.global_msg.init({gType:'warning',msg:gUeAddAudioErrMsg,icon:2});
                                        	return;
                                        }
                                        _this.execCommand('insertHtml', "<img audio='" + data.url + "' src='" + URL_AUDIO_IMG + "'>");
                                    },
                                    error: function (data, status, e) {
                                        $.global_msg.init({gType: 'warning', msg: gUeAddAudioErrMsg, icon: 2});
                                    }
                                });
                            });
                            $('body').append($file);
                            setTimeout(function () {
                                $('#audio_file').click();
                            }, 100);
                            return true;
                        },
                        queryCommandState: function () {

                        }
                    };
                    ue = UE.getEditor('js_content', {
                        toolbars: [
                            ['simpleupload', 'fontsize', 'fontfamily', 'link', 'unlink', 'bold', 'italic',
                                'underline', 'strikethrough', 'superscript', 'subscript',
                                'removeformat', 'justifyleft', 'justifycenter', 'justifyright', 'audio'
                            ]
                        ],
                        wordCount: false,
                        elementPathEnabled: false,
                        autoHeightEnabled: false,
                        fontfamily: [{
                            label: 'arial',
                            name: 'arial',
                            val: 'arial, helvetica,sans-serif'
                        }, {
                            label: 'verdana',
                            name: 'verdana',
                            val: 'verdana'
                        }, {
                            label: 'georgia',
                            name: 'georgia',
                            val: 'georgia'
                        }, {
                            label: 'tahoma',
                            name: 'tahoma',
                            val: 'tahoma'
                        }, {
                            label: 'timesNewRoman',
                            name: 'timesNewRoman',
                            val: 'times new roman'
                        }, {
                            label: 'trebuchet MS',
                            name: 'trebuchet MS',
                            val: 'Trebuchet MS'
                        }, {
                            label: '宋体',
                            name: 'songti',
                            val: '宋体,SimSun'
                        }, {
                            label: '黑体',
                            name: 'heiti',
                            val: '黑体, SimHei'
                        }, {
                            label: '楷体',
                            name: 'kaiti',
                            val: '楷体,楷体_GB2312, SimKai'
                        }, {
                            label: '仿宋',
                            name: 'fangsong',
                            val: '仿宋, SimFang'
                        }, {
                            label: '隶书',
                            name: 'lishu',
                            val: '隶书, SimLi'
                        }, {
                            label: '微软雅黑',
                            name: 'yahei',
                            val: '微软雅黑,Microsoft YaHei'
                        }],
                        contextMenu: [],
                        iframeCssUrl: JS_PUBLIC + '/js/jsExtend/ueditor/themes/review.css',
                        initialFrameWidth: 706,//设置编辑器宽度
                        initialFrameHeight: 330//设置编辑器高度
                    });
                } else {
                    ue.setContent(content);
                }
                ue.addListener('ready', function (editor) {
                    ue.execCommand('pasteplain'); //设置编辑器只能粘贴文本
                    ue.setHeight(330);
                    ue.setContent(content);
                    setInterval(function () {
                        var offset = $('.edui-for-audio .edui-icon').offset();
                        $('#audio_file').css('top', offset.top);
                        $('#audio_file').css('left', offset.left);
                    }, 100);
                });
                //var contentObj = $(".js_new_edit_publish .js_content");
                //contentObj.html(content);
                //contentObj.attr("contentEditable", "true");

                //行业分类列表数据初始化
                $.news.initChannelSelect();

            },

            //初始化行业下拉框数据
            initChannelSelect: function () {
                var str = '';
                $.ajaxFileUpload({
                    url: gAllCategory,
                    secureuri: false,
                    data: {},
                    dataType: 'json',
                    success: function (data) {
                        //   console.info(data);return;
                        var len = data.length;
                        var tmpObj = null;
                        for (var i = 0; i < len; i++) {
                            tmpObj = data[i];
                            str += '<li data-id="' + tmpObj.categoryid + '">' + tmpObj.name + '</li>';
                        }
                        $('.js_new_cate_list').html(str);
                        $('.js_new_cate_list > li').on('click', function () {
                            var obj = $(this);
                            $('.js_new_catebtn_show').val(obj.html());
                            $('.js_new_catebtn_show').attr('cate-id', obj.attr('data-id'));
                            $('.js_new_cate_list').hide();
                        });
                    },
                    error: function (data, status, e) {
                        //console && console.info(data,status,e);
                    }
                });

            },

            //初始化行业下拉框数据
            inLabelelSelect: function () {
                var str = '';
                $.ajaxFileUpload({
                    url: gAllCategory,
                    secureuri: false,
                    data: {},
                    dataType: 'json',
                    success: function (data) {
                        //console.info(data);return;
                        var len = data.length;
                        var tmpObj = null;
                        for (var i = 0; i < len; i++) {
                            tmpObj = data[i];
                            str += '<li data-id="' + tmpObj.id + '">' + tmpObj.category + '</li>';
                        }
                        $('.js_new_cate_list').html(str);
                        $('.js_new_cate_list > li').on('click', function () {
                            var obj = $(this);
                            $('.js_new_catebtn_show').val(obj.html());
                            $('.js_new_catebtn_show').attr('cate-id', obj.attr('data-id'));
                            $('.js_new_cate_list').hide();
                        });
                    },
                    error: function (data, status, e) {
                        //console && console.info(data,status,e);
                    }
                });

            },

            //编辑时标题图片上传
            newTitlePicUpload: function () {
                var allObj = $('.js_new_edit_publish');
                var fileNameHid = allObj.find('#newuploadpic').val();
                $.ajaxFileUpload({
                    url: gUrlUploadFile,
                    secureuri: false,
                    fileElementId: fileNameHid,
                    data: {fileNameHid: fileNameHid},
                    dataType: 'json',
                    success: function (rtn, status) {
                        var imgUrl = rtn.data.absolutePath;
                        $('#js_new_file_path').val(imgUrl);
                        $('#title_pic').attr({'value': imgUrl, 'src': imgUrl});
                    },
                    error: function (data, status, e) {
                        console && console.info(data, status, e);
                    }
                });
            },

            //预览资讯问答内容(批量操作)
            privewNews: function () {
                //资讯置顶
                $('#js_btn_top').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();
                    if (gloable_showid == '' || gloable_showid.indexOf(',') != -1) {
                        $.global_msg.init({gType: 'warning', msg: str_select_audit_top, icon: 2});
                        return;
                    }
                    $.ajax({
                        url: newstopurl,
                        type: 'post',
                        data: {showids: gloable_showid},
                        success: function (res1) {
                            if (res1['status'] == '0') {
                                $.global_msg.init({
                                    gType: 'warning', msg: res1['msg'], time: 2, icon: 1, endFn: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                $.global_msg.init({gType: 'warning', msg: res1['msg'], icon: 0});
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({gType: 'warning', msg: 'error', icon: 0});
                        }
                    });
                });

                //资讯撤销
                $('#js_btn_undo').on('click', function () {
                    gloable_showid = (checkObj.getCheck()).toString();
                    if (gloable_showid == '') {
                        $.global_msg.init({gType: 'warning', msg: str_select_audit_top, icon: 2});
                        return;
                    }
                    $.global_msg.init({gType: 'confirm',
                        icon: 2,
                        msg: '确认撤销资讯？',
                        btns: true, close: true,
                        title: false, btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            $.ajax({
                                url: newsundourl,
                                type: 'post',
                                data: {showids: gloable_showid},
                                success: function (res1) {
                                    if (res1['status'] == '0') {
                                        $.global_msg.init({
                                            gType: 'warning', msg: res1['msg'], time: 2, icon: 1, endFn: function () {
                                                location.reload();
                                            }
                                        });
                                    } else {
                                        $.global_msg.init({gType: 'warning', msg: res1['msg'], icon: 0});
                                    }
                                },
                                fail: function (err) {
                                    $.global_msg.init({gType: 'warning', msg: 'error', icon: 0});
                                }
                            });
                        }});

                });

                $('#js_btn_preview').click(function () {
                    var type = $(this).attr('data-type');//type为1代表已发布的资讯，未发布资讯 和已审核的问答（通过和不通过）  type为2代表待审核的资讯和问答  当为1时预览弹框只显示删除按钮
                    gloable_showid = (checkObj.getCheck());
                    /*     if((gloable_showid.toString()).length == 0){
                     $.global_msg.init({gType:'warning',icon:2,msg:'请选中一项数据项在进行操作'});
                     return;
                     }*/
                    //没有选中的情况下，预览整个页面中的数据
                    if (gloable_showid.length == 0) {
                        var tmpArr = [];
                        var allDoms = $('.js_select');
                        $.each(allDoms, function () {
                            var obj = $(this);
                            tmpArr.push(obj.attr('val'));
                        });
                        gloable_showid = tmpArr;
                        if (gloable_showid.length == 0) {
                            return;//说明本页面无预览内容
                        }
                    }
                    if (gloable_showid) {
                        $('#js_btn_preview_next,#js_btn_preview_prev').attr('data-type', type);
                        $('.js_btn_new_preview .js_successone, .js_btn_new_preview .js_failone')
                            .attr('val', gloable_showid[0]);
                        $.news.preview(gloable_showid[0], type);
                    }
                });
                $('.js_onenews_review').on('click', function () {
                    var type = $(this).attr('data-type');
                    var id = $(this).attr('data-id');
                    $('.js_btn_new_preview .js_successone, .js_btn_new_preview .js_failone').attr('val', id);
                    gloable_showid = (checkObj.getCheck());
                    //没有选中的情况下，预览整个页面中的数据
                    if (gloable_showid.length == 0) {
                        var tmpArr = [];
                        var allDoms = $('.js_select');
                        $.each(allDoms, function () {
                            var obj = $(this);
                            tmpArr.push(obj.attr('val'));
                        });
                        gloable_showid = tmpArr;
                    }
                    $.news.preview(id, type);
                });
                //预览下一个内容 ...
                $('#js_btn_preview_next').click(function () {
                    if (checkDataIndex + 1 > gloable_showid.length - 1) {
                        $.global_msg.init({gType: 'warning', msg: gStrhasnonextone, icon: 2});
                        return;
                    }
                    var type = $(this).attr('data-type');//type为1代表已发布的资讯，未发布资讯 和已审核的问答（通过和不通过）  type为2代表待审核的资讯和问答  当为1时预览弹框只显示删除按钮
                    checkDataIndex = checkDataIndex + 1;
                    var id = gloable_showid[checkDataIndex];
                    $('.js_btn_new_preview .js_successone').attr('val', id);
                    $('.js_btn_new_preview .js_failone').attr('val', id);
                    $.news.preview(id, type);
                });
                //预览上一个内容
                $('#js_btn_preview_prev').click(function () {
                    if (checkDataIndex - 1 < 0) {
                        $.global_msg.init({gType: 'warning', msg: gStrhasnoprevone, icon: 2});
                        return;
                    }
                    checkDataIndex = checkDataIndex - 1;
                    var type = $(this).attr('data-type');//type为1代表已发布的资讯，未发布资讯 和已审核的问答（通过和不通过）  type为2代表待审核的资讯和问答  当为1时预览弹框只显示删除按钮
                    var id = gloable_showid[checkDataIndex];
                    $('.js_btn_new_preview .js_successone, .js_btn_new_preview .js_failone').attr('val', id);
                    $.news.preview(id, type);
                });
                //删除正在预览的资讯
                $('#js_new_del').on('click', function () {
                    var showid = $(this).data('showid');
                    //showid = 'bglhU2p3bCEYgV1Tq1RMWz34szeSxj1y';
                    if (showid == '') {
                        $.global_msg.init({gType: 'warning', msg: gStrselectdelnews, icon: 2});
                        return;
                    }
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: gStrconfirmdelnews, btns: true, close: true,
                        title: false, btn1: gStrcanceldelnews, btn2: gStryesdelnews, noFn: function () {
                            $.post(delnewsurl, {showid: showid}, function (data) {
                                if ('0' == data['status']) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: data['msg'], icon: 1, endFn: function () {
                                            location.reload();
                                        }
                                    });

                                } else {
                                    $.global_msg.init({gType: 'warning', msg: data['msg'], icon: 2});
                                }
                            })
                        }
                    });

                });
                //点击资讯列表中的图片图标   预览资讯中的所有图片
                $('.js_preview_pic').on('click', function () {
                    var id = $(this).attr('data-id');
                    var data = {id: id};
                    //获取资讯或问答数据
                    $.get(gGetDataUrl, data, function (rst) {
                        rst = rst.data;
                        var images = rst.allimages;    //所有图片
                        var htm = '';
                        for (var i = 0; i < images.length; i++) {
                            if (i == 0) {//第一张图片显示
                                htm += '<li class="picblock"><img src="' + images[i] + '"></li>';
                            } else {
                                htm += '<li class="picnone"><img src="' + images[i] + '"></li>';
                            }
                        }
                        $('.js_moreimages_content').html(htm);
                    })
                    $('.js_preview_morepic,.js_masklayer').show();
                    //关闭弹出层
                    var allObj = $('.js_preview_morepic');
                    allObj.find('.js_btn_close').click(function () {
                        allObj.hide();
                        $('.js_moreimages_content').html('');
                        $('.js_masklayer').hide();
                    });
                });

                //点击图片预览框显示上一张图片按钮
                $('.js_preview_morepic').on('click', '.js_prev_pic', function () {
                    //查看当前显示的是第几张图片
                    var blockindex = $('.js_moreimages_content').find('.picblock').index();
                    if (blockindex <= 0) {//已经是第一张了
                        $.global_msg.init({gType: 'warning', msg: gStrhasnoprevpic, icon: 2});
                        return;
                    }
                    $('.js_moreimages_content').find('.picblock').removeClass('picblock')
                        .addClass('picnone').prev('li').removeClass('picnone').addClass('picblock');
                });

                //点击图片预览框显示下一张图片按钮
                $('.js_preview_morepic').on('click', '.js_next_pic', function () {
                    //查看当前显示的是第几张图片
                    var blockindex = $('.js_moreimages_content').find('.picblock').index();
                    //图片总数
                    var alllength = $('.js_moreimages_content').find('li').length;
                    if (blockindex >= (alllength - 1)) {//已经是最后一张了
                        $.global_msg.init({gType: 'warning', msg: gStrhasnonextpic, icon: 2});
                        return;
                    }
                    $('.js_moreimages_content').find('.picblock').removeClass('picblock')
                        .addClass('picnone').next('li').removeClass('picnone').addClass('picblock');
                });

                //选择待推送咨询后点击进入推送设置
                $('#js_btn_news_push').on('click', function () {
                    if( $('.js_select.active').length>0){
                        var data = [];
                        var title = '';
                        var time = '';
                        var createdtime='';
                        var val = '';
                        var coverurl = ''; //封面图片
                        $('.js_select.active').each(function (index) { //获取选中条目的 标题时间 id
                            title = $(this).attr('title');
                            time = $(this).attr('time');
                            createdtime=$(this).attr('createdtime');
                            val = $(this).attr('val');
                            coverurl = $(this).attr('coverurl');
                            data.push({val: val, time: time, title: title, coverurl: coverurl, createdtime: createdtime});
                            // data[index+1]={val:val,time:time,title:title};

                        });
                        data = JSON.stringify(data);
                        data = encodeURI(data, 'utf-8');
                        // console.log(data);

                        /*  gloable_showid = (checkObj.getCheck()).toString();
                         if(gloable_showid == ''){
                         $.global_msg.init({gType:'warning',msg:str_select_audit_top,icon:2});
                         return;
                         }
                         */

                        $('#js_news_push_input').val(data);
                        $('#js_news_push_input').closest('form').submit();

                    }else{
                        $.global_msg.init({gType:'warning',msg:gMustSelectPush,icon:2});

                   }


                })

            },


            /**预览资讯内容
             * @param id  资讯或id
             * @param type 资讯状态   状态为2代表未审核的
             */
            preview: function (id, type) {
                var data = {id: id};
                $.get(gGetDataUrl, data, function (rst) {
                    rst = rst.data;
                    if (type != 2) {   //已审核的 需要隐藏审核按钮
                        $('#js_set_audit').hide();//隐藏审核通过按钮  这里是已发布资讯
                        $('#js_not_publish').hide();//隐藏审核不通过按钮  这里是已发布资讯
                        $('#js_new_del').hide(); //已推送 隐藏删除按钮
                    }

                    $('#js_new_del').data('showid', id);
                    $.news.previewGeneralPage(rst);
                    //滚动条
                    var scrollObj = $('.js_btn_new_preview .js_new_summey');
                    if (!scrollObj.hasClass('mCustomScrollbar')) {
                        scrollObj.mCustomScrollbar({
                            theme: "dark", //主题颜色
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia: 0,//滚动延迟
                            horizontalScroll: false,//水平滚动条
                        });
                    }
                    $('.js_btn_new_preview,.js_masklayer').show();

                }, 'json');
            },

            /**
             * 预览页面值替换
             * @param rst   array 资讯数据数组
             */
            previewGeneralPage: function (rst) {
                var allObj = $('.js_btn_new_preview');
                if (rst.image != '') {
                    allObj.find('.js_title_img').attr('src', rst.image);
                    allObj.find('.js_commentpop_img').show();
                } else {
                    allObj.find('.js_commentpop_img').hide();
                }
                allObj.find('.js_title').html(rst.title);
                allObj.find('.js_source').html(rst.webfrom);
                allObj.find('.js_time').html(rst.datetime);
                allObj.find('.js_category').html(rst.category);

                /*资讯中这块内容为空    资讯的图片资源是和资讯内容混合一块保存的   问答的内容和图片分开保存*/
                /*以下代码是针对问答的*/
                if (typeof(rst.resource) != 'undefined') {
                    var imgdata = rst.resource.list;
                    var imghtml = '';
                    if (imgdata.length > 0) {
                        for (var i = 0; i < imgdata.length; i++) {
                            imghtml += '<img src="' + imgdata[i].path + '">';
                        }
                        rst.content += imghtml;
                    }

                }

                /*针对问答的图片循环代码结束*/

                //替换预览中的内容  并把内容中的表情替换
                allObj.find('.js_content1').html($.expBlock.textFormat(rst.content));

                //关闭弹出层
                allObj.find('.js_btn_close').click(function () {
                    allObj.hide();
                    checkDataIndex = 0;
                    $('.js_masklayer').hide();
                });
            },

            /**
             * 评论审核
             */
            commentPass: function () {
                //通过
                $('#js_comment_pass').on('click', function () {
                    _pass(2);
                });

                //不通过
                $('#js_comment_reject').on('click', function () {
                    _pass(3);
                });
            },

            /**
             * 评论预览
             */
            commentPreview: function () {
                var cid = null;
                //评论按钮点击
                $('#js_comment_preview').on('click', function () {

                    commentCurrentPreviewObj = [];
                    commentCurrentPreviewObjIndex = 0;
                    if ($('.active[val]').length == 0) {  //如果没有选择内容  就预览全部
                        //$.global_msg.init({gType:'warning',msg:gStrselectcomment,icon:2});
                        //return;
                        $('.hand[val]').each(function () {
                            commentCurrentPreviewObj.push($(this).parent().parent());
                        });
                    } else {
                        $('.active[val]').each(function () {
                            commentCurrentPreviewObj.push($(this).parent().parent());
                        });
                    }

                    _render();
                });

                //评论关闭
                $('.appadmin_comment_close').on('click', function () {
                    $('.appaddmin_comment_pop, .appadmin_maskunlock').hide();
                });

                //上一个
                $('#comment_prev').on('click', function () {
                    if (commentCurrentPreviewObjIndex != 0) {
                        commentCurrentPreviewObjIndex--;
                        _render('prev');
                    } else {
                        $.global_msg.init({gType: 'warning', msg: gStrhasnoprevone, icon: 2});
                        return;
                    }
                });

                //下一个
                $('#comment_next').on('click', function () {
                    if (commentCurrentPreviewObjIndex != commentCurrentPreviewObj.length - 1) {
                        commentCurrentPreviewObjIndex++;
                        _render('next');
                    } else {
                        $.global_msg.init({gType: 'warning', msg: gStrhasnonextone, icon: 2});
                        return;
                    }
                });

                //审核通过
                $('#js_comment_pass2').on('click', function () {
                    _pass(2, cid);
                });

                //审核不通过
                $('#js_comment_reject2').on('click', function () {
                    _pass(3, cid);
                });
                //渲染
                function _render(type) {
                    cid = $(commentCurrentPreviewObj[commentCurrentPreviewObjIndex]).find('i:first').attr('val');
                    var txt = $(commentCurrentPreviewObj[commentCurrentPreviewObjIndex]).find('.span_span3').html();
                    $('.appaddmin_comment_pop').show().find('.appadmincomment_content').html(txt);
                    $('.appadmin_maskunlock').show();
                }
            },
            /**
             * 评论相关排序（时间在上面已经弄了，这里就不需要了）
             */
            commentOrder: function () {
                //ID(手机号)排序
                $('#js_orderbymobile').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('mobile', type);
                });

                //回复数排序
                $('#js_orderbycommentnum').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    $.news.orderByCondition('commentnum', type);
                });
            },
            /*常见问题*/
            faq: function () {
                /*搜索下拉框START---------------------------------------------------------------*/
                //显示或隐藏下拉框
                $('.js_select_item i').on('click', function () {
                    $(this).closest('.js_select_item').find('ul').toggle();
                });
                $('.js_select_item .span_name input').on({
                    'click': function () {
                        $(this).closest('.js_select_item').find('ul').toggle();
                        $(this).blur();
                    }
                });
                //选择下拉框的数据
                var selOdiv = $('#js_selcontent');
                var titleOdiv = $('#js_titlevalue');
                selOdiv.on('click', 'li', function () {
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    titleOdiv.attr({'value': content, 'title': content, 'seltitle': title});
                    titleOdiv.val(content);
                    selOdiv.hide();
                })

                //点击区域外关闭此下拉框
                $(document).on('click', function (e) {
                    if ($(e.target).parents('.js_select_item').length > 0) {
                        var currUl = $(e.target).parents('.js_select_item').find('ul');
                        $('.js_select_item>ul').not(currUl).hide()
                    } else {
                        $('.js_select_item>ul').hide();
                    }
                });
                /*搜索下拉框END-----------------------------------------------------------------*/

                /*搜索+排序START-------------------------------------*/
                $('#js_searchbutton2').on('click', function () {
                    window.location.href = searchParam();
                });

                //点击按id排序
                $('#js_orderbysort').on('click', function () {
                    //排序方式  desc为倒序  asc为正序
                    var type = $(this).attr('type') == 'asc' ? 'desc' : 'asc';
                    orderByCondition('sort', type);
                });

                //搜索条件拼接
                function searchParam() {
                    var condition = '';
                    var keyword = encodeURIComponent($('#js_selkeyword').val());
                    var type = $('#js_titlevalue').attr('seltitle');
                    type = 'question';
                    condition += '?search_type=' + type;
                    if (keyword != '') {
                        condition += '&keyword=' + keyword;
                    }
                    return searchurl + condition;
                }

                //排序
                function orderByCondition(str, type) {
                    var condition = searchParam();
                    condition += '&order=' + str;
                    condition += '&ordertype=' + type;
                    window.location.href = condition;
                }

                /*搜索+排序END---------------------------------------*/
                /*添加修改删除START--------------------------------------------*/
                var $f = $('.faq_comment_pop form');
                //添加常见问题
                $("#js_addfaq").on('click', function () {
                    show();
                });

                //显示添加弹层
                function show() {
                    $('.appadmin_maskunlock').show();
                    $('.faq_comment_pop').show();
                    $('.faqcomment_title').html($('#js_addfaq i').html());
                }

                //弹出层关闭
                $('.faq_comment_pop .js_btn_channel_cancel').on('click', function () {
                    var p = {
                        question: $f.find('input[name="question"]').val(),
                        answer: $f.find('textarea[name="answer"]').val(),
                    };
                    if (p.question || p.answer) {
                        if (!confirm(str_intro_leave)) {
                            return;
                        }
                    }

                    $('.appadmin_maskunlock').hide();
                    $('.faq_comment_pop').hide();
                    reset();
                });

                $('.faq_comment_pop .js_add_cancel').on('click', function () {
                    $('.js_btn_channel_cancel').click();
                });

                //表单初始化
                function reset() {
                    $f.find('input,textarea').val('');
                }

                reset();

                //添加问题操作
                $('.js_add_sub').on('click', function () {
                    var p = {
                        questionid: $f.find('input[name="questionid"]').val(),
                        question: $f.find('input[name="question"]').val(),
                        answer: $f.find('textarea[name="answer"]').val(),
                        typeid: typeid,
                        sort: $f.find('input[name="sort"]').val()
                    };

                    //表单验证
                    if ($.trim(p.question) == '') {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_question, icon: 2});
                        return;
                    }
                    if ($.trim(p.question).length > 30) {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_question_length, icon: 2});
                        return;
                    }
                    if ($.trim(p.answer) == '') {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_answer, icon: 2});
                        return;
                    }
                    if ($.trim(p.answer).length > 300) {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_answer_length, icon: 2});
                        return;
                    }
                    if ($.trim(p.sort) == '' || /[^0-9]/.test(p.sort)) {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_sort, icon: 2});
                        return;
                    }
                    if (parseInt($.trim(p.sort)) > 1000) {
                        $.global_msg.init({gType: 'warning', msg: str_faq_verify_sort, icon: 2});
                        return;
                    }

                    $.post(url_dofaq, p, function (rst) {
                        if (rst.status == 0) {
                            $.global_msg.init({
                                gType: 'warning', msg: rst.msg, icon: 1, endFn: function () {
                                    location.reload();
                                }
                            });
                        } else {
                            $.global_msg.init({gType: 'warning', msg: rst.msg, icon: 2});
                        }
                    });
                });

                //删除问题
                $('.faqdelete').on('click', function () {
                    var id = $(this).parent().parent().attr('qid');
                    $.global_msg.init({
                        gType: 'confirm',
                        icon: 2,
                        msg: str_faq_confirm,
                        btns: true,
                        title: false,
                        close: true,
                        btn1: str_btn_cancel,
                        btn2: str_btn_ok,
                        noFn: function () {
                            $.post(url_delfaq, {id: id}, function (rst) {
                                if (rst.status == 0) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: rst.msg, icon: 1, endFn: function () {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    $.global_msg.init({gType: 'warning', msg: rst.msg, icon: 2});
                                }
                            });
                        }
                    });
                });

                //修改
                $('.faqedit').on('click', function () {
                    var data = {};
                    var top = $(this).parent().parent();
                    data.id = top.attr('qid');
                    data.question = top.find('.span_span1').html();
                    data.answer = top.find('.span_span2').html();
                    data.sort = top.find('.span_span3').html();

                    //赋值
                    $f.find('input[name="questionid"]').val(data.id);
                    $f.find('input[name="question"]').val(data.question);
                    $f.find('textarea[name="answer"]').val(data.answer);
                    $f.find('input[name="sort"]').val(data.sort);

                    //显示
                    show();
                });

                /*添加修改删除END----------------------------------------------*/
            },

            /**
             *  点击输入框， 弹出beta用户列表， 供选择作为资讯评论人
             */
            popupCommentors: function () {
                $.news._loadCommentors();
                globalPopLayerIndex = $.layer({
                    type: 1,
                    title: false,
                    area: ['1000px', , '200px'],
                    offset: ['200px', ''],
                    bgcolor: '#ccc',
                    border: [0, 0.3, '#ccc'],
                    shade: [0.5, '#000'],
                    closeBtn: false,
                    page: {dom: $('#popChooseBetaUser')},
                    shadeClose: false,
                    fix: false
                });

                return false;
            },

            /**
             *  载入beta用户列表， 供选择作为资讯评论人
             */
            _loadCommentors: function (event) {
                var params = typeof(event) == 'undefined' ? {action: ''} : event.data;
                var p = parseInt($('#pagination .current').eq(0).text());
                var type = $('#pagination #type').val();
                var sort = $('#pagination #sort').val();
                var keyword = $('#pagination #keyword').val();
                var totalPage = $('#pagination').find('input[name="p"]').eq(0).attr('totalPage');
                switch (params.action) {
                    case 'next':
                        p = p >= totalPage ? p : (p + 1);
                        break;
                    case 'prev':
                        p = p > 1 ? (p - 1) : 1;
                        break;
                    case 'jump':
                        p = parseInt($('#pagination .jumppage').eq(0).val());
                        p = p > 1 ? p : 1;
                        p = p >= totalPage ? totalPage : p;
                        break;
                    case 'search':
                        type = $('#js_titlevalue').attr('seltitle');
                        keyword = $('#js_keyword').val();
                        break;
                    case 'sort':
                        sort = $(this).hasClass('list_sort_asc') ? 'desc' : 'asc';
                        break;
                    default:
                        break;
                }
                params = {p: p, type: type, sort: sort, keyword: keyword};

                $.ajax(gUrlToGetBetaUsers, {
                    type: 'GET',
                    data: params,
                    success: function (response) {
                        $('#commentorList').html(response);
                    }
                });

                return false;
            },
            /**
             * 在beta用户列表中， 选择某个beta用户作为当前资讯的评论人
             */
            chooseCommentors: function () {
                if ($('input[name="clientId"]:checked').length == 0) {
                    $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gSelectCommentUser});
                    return false;
                }
                $('#commentor').val($('input[name="clientId"]:checked').attr('data-username'));
                $('#commentorId').val($('input[name="clientId"]:checked').val());
                $('#popChooseBetaUser .js_close').trigger('click');

                return;
            },

            /**
             * 监听点击添加评论按钮， 和 取消按钮操作
             */
            listentAddCommentButton: function () {
                $('.addcom_button .input_sub').click(function () {
                    if ('' == $('#commentorId').val()) {
                        $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gSelectCommentUser});
                        return false;
                    }

                    if ('' == $('#commentText').val()) {
                        $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gAddCommentContent});
                        return false;
                    }
                    var params = {
                        id: $('#newsId').val(),
                        clientid: $('#commentorId').val(),
                        content: $('#commentText').val()
                    };
                    $.ajax(gUrlToPostComment, {
                        type: 'POST',
                        data: params,
                        success: function (response) {
                            if (response.status == 0) {
                                $.global_msg.init({
                                    gType: 'alert',
                                    icon: 1,
                                    time: 3,
                                    msg: gAddCommentSuccess,
                                    endFn: function () {
                                        window.location.href = gUrlToGoBack;
                                    }
                                });

                            } else {
                                $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gAddCommentFail});
                            }
                        }
                    });

                    return false;
                });
                $('.addcom_button .input_del').click(function () {
                    window.location.href = gUrlToGoBack;
                });
            },

            /**
             * 监听评论者列表弹框事件
             */
            listenPopCommentor: function () {
                // 关闭弹出框
                $('#popChooseBetaUser').on('click', '.js_close', function () {
                    layer.close(globalPopLayerIndex);
                });
                // 在beta列表中，选择某个用户， 将选择的用户作为当前资讯的评论人
                $('#popChooseBetaUser').on('click', '#clickChooseBeta', $.news.chooseCommentors);
                // 在beta列表中，点击下一页切换
                $('#popChooseBetaUser').on('click', '#pagination a.next', {action: 'next'}, $.news._loadCommentors);
                // 在beta列表中，选择某个用户， 将选择的用户作为当前资讯的评论人
                $('#popChooseBetaUser').on('click', '#pagination a.prev', {action: 'prev'}, $.news._loadCommentors);
                // 在页码框里， 按回车键， 不做任何操作
                $('#popChooseBetaUser').on('keydown keyup', '.jumppage', function (e) {
                    if (e.keyCode == 13) { // 回车键， 禁止提交表单
                        return false;
                    }
                });
                // 输入页码， 点击跳转
                $('#popChooseBetaUser').on('click', '#pagination input[type="submit"]', {action: 'jump'}, $.news._loadCommentors);
                // 在beta列表中，点击排序
                $('#popChooseBetaUser').on('click', '.list_sort_none, .list_sort_desc, .list_sort_asc', {action: 'sort'}, $.news._loadCommentors);
                // 搜索beta用户
                $('#popChooseBetaUser').on('click', '#clickSearchBeta', {action: 'search'}, $.news._loadCommentors);
            },
            /**
             *  点击输入框， 弹出label标签列表， 供选择作为资讯的标签
             */
            popupLabels: function (type) {
                if (typeof type == 'string') {
                    var params = {data: {type: type}};
                    $.news._loadLabels(params);
                } else {
                    $.news._loadLabels();
                }
                globalPopLayerIndex = $.layer({
                    type: 1,
                    title: false,
                    area: ['1000px', , '200px'],
                    offset: ['200px', ''],
                    bgcolor: '#ccc',
                    border: [0, 0.3, '#ccc'],
                    shade: [0.5, '#000'],
                    closeBtn: false,
                    page: {dom: $('#popChooseItem')},
                    shadeClose: false,
                    fix: false
                });

                return false;
            },

            /**
             *  载入标签列表， 供选择标签
             */
            _loadLabels: function (event) {
                var params = typeof(event) == 'undefined' ? {action: ''} : event.data;
                var p = parseInt($('#pagination .current').eq(0).text());
                var sort = $('#pagination #sort').val();
                var keyword = $('#pagination #keyword').val();
                var totalPage = $('#pagination').find('input[name="p"]').eq(0).attr('totalPage');
                switch (params.action) {
                    case 'next':
                        p = p >= totalPage ? p : (p + 1);
                        break;
                    case 'prev':
                        p = p > 1 ? (p - 1) : 1;
                        break;
                    case 'jump':
                        p = parseInt($('#pagination .jumppage').eq(0).val());
                        p = p > 1 ? p : 1;
                        p = p >= totalPage ? totalPage : p;
                        break;
                    case 'search':
                        type = $('#searchtype').val();
                        keyword = $('#js_keyword').val();
                        break;
                    case 'sort':
                        sort = $(this).hasClass('list_sort_asc') ? 'desc' : 'asc';
                        $(this).removeClass('list_sort_asc list_sort_desc');
                        $(this).addClass('list_sort_' + sort);
                        break;
                    default:
                        break;
                }
                var type = '';
                if (typeof (params.type) != 'undefined') {
                    type = params.type;
                } else if ($('.js_label_item').attr('type') == 'radio') {
                    type = 'radio';
                }

                params = {p: p, sort: sort, keyword: keyword, type: type};
                $.ajax(gUrlToGetLabels, {
                    type: 'GET',
                    data: params,
                    success: function (response) {
                        $.news._replaceLabels(response);
                    }
                });

                return false;
            },

            /**
             * ajax请求后， 替换页面的label标签内容， 同时将已经有的标签设置为选中状态。
             */
            _replaceLabels: function (response) {
                $('#labelsList').html(response);
                var $selectedLabels = $('#selected_labels .js_label');
                var $availableLabels = $('#labelsList .js_label_item');
                for (var i = 0; i < $selectedLabels.length; i++) {
                    for (var j = 0; j < $availableLabels.length; j++) {
                        if ($selectedLabels.eq(i).attr('data-id') == $availableLabels.eq(j).attr('value')) {
                            $availableLabels.eq(j).prop('checked', 'checked');
                        }
                    }
                }

                return false;
            },
            /**
             * 在label标签列表中， 点击确定， 将选中的label设置为可见
             */
            _chooseLabels: function () {
                if ($('input.js_label_item').type == 'checkbox') {

                }
                if ($('input.js_label_item:checked').length == 0) {
                    $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gSelectLabel});
                    return false;
                } else if ($('input.js_label_item').attr('type') == 'checkbox') {
                    $('.js_add_label,#selected_labels .js_label, #selected_labels').show();//显示包裹层
                    $('#popChooseItem .js_close').trigger('click');

                } else if ($('input.js_label_item').attr('type') == 'radio') { //标签搜索用单选
                    var val = $('input.js_label_item:checked').val();
                    var name = $('input.js_label_item:checked').attr('data-username');
                    $('#js_selkeyword').val(name);
                    $("input[name='tagsId']").val(val);
                    $('#popChooseItem .js_close').trigger('click');
                }


                return;
            },

            /**
             * 选中一个label标签， 插入到页面， 设置为不可见。只有点击确定后，才可见
             */
            _addLabelItem: function (labelName, labelId) {

                if ($(".js_label_item:checked").length > 100) {
                    $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: gSelectLabelMax});
                    return false;
                }

                if (typeof(labelId) != 'undefined' || $(this).is(':checked')) {
                    if (typeof(labelId) == 'undefined') {
                        labelName = $(this).attr('data-username');
                        labelId = $(this).attr('value');
                    }
                    if ($('#selected_labels .js_label[data-id="' + labelId + '"]').length) {
                        return;
                    }
                    var $span = $('<span class="js_label"><em class="js_remove">x</em></span>');
                    $span.attr('data-id', labelId);
                    $span.prepend(labelName);
                    $('#selected_labels').prepend($span.hide());
                } else {
                    $('#selected_labels .js_label[data-id="' + $(this).attr('value') + '"]').remove();
                }


            },

            /**
             * 监听评论者列表弹框事件
             */
            listenPopLabel: function () {
                // 关闭弹出框
                $('#popChooseItem').on('click', '.js_close', function () {
                    layer.close(globalPopLayerIndex);
                });
                // 在已有选中的标签列表中，点击X后，移除标签
                $('#selected_labels').on('click', '.js_remove', function () {
                    $(this).closest('span').remove();
                    if (!$('#selected_labels span').length) { //全部移除 隐藏包裹层
                        $('#selected_labels').hide();
                        $('.js_add_label').hide();

                    }
                });
                // 在标签列表中，选择标签后， 点击确定，将选中的标签添加
                $('#popChooseItem').on('click', '#clickChoose', $.news._chooseLabels);
                // 在标签列表中，选择某个标签， 添加到标签中
                $('#popChooseItem').on('click', '.js_label_item', $.news._addLabelItem);
                // 在beta列表中，点击下一页切换
                $('#popChooseItem').on('click', '#pagination a.next', {action: 'next'}, $.news._loadLabels);
                // 在beta列表中，选择某个用户， 将选择的用户作为当前资讯的评论人
                $('#popChooseItem').on('click', '#pagination a.prev', {action: 'prev'}, $.news._loadLabels);
                // 在页码框里， 按回车键， 不做任何操作
                $('#popChooseItem').on('keydown keyup', '.jumppage', function (e) {
                    if (e.keyCode == 13) { // 回车键， 禁止提交表单
                        return false;
                    }
                });
                // 输入页码， 点击跳转
                $('#popChooseItem').on('click', '#pagination input[type="submit"]', {action: 'jump'}, $.news._loadLabels);
                // 在beta列表中，点击排序
                $('#popChooseItem').on('click', '.clickSort', {action: 'sort'}, $.news._loadLabels);
                // 搜索beta用户
                $('#popChooseItem').on('click', '#clickSearch', {action: 'search'}, $.news._loadLabels);
            },
        },
        //标签管理
        labelManage: {
            init: function () {
                //初始化列表的复选框插件
                window.gLabelCheckObj = $('.content_hieght').checkDialog({
                    checkAllSelector: '#js_allselect',
                    checkChildSelector: '.js_select', valAttr: 'val', selectedClass: 'active'
                });
                $.labelManage.initBindEvt();//初始化绑定事件
            },
            initBindEvt: function () {
                //点击添加按钮，显示添加频道模板
                $('#js_add_channel').click(function () {
                    $('.js_channel_pop,.js_masklayer').show();
                    $('#js_channel_pop_type').val('add');
                    $('#js_chanel_name').val('');
                    $('.js_channel_title').html(gStrAddLabelTitle);
                });
                //弹出层确定按钮
                $('.js_btn_channel_ok').click(function () {
                    $.labelManage.modifyLabel();
                });
                //弹出层取消按钮
                $('.js_btn_channel_cancel').click(function () {
                    $('.js_channel_pop,.js_masklayer').hide();
                });
                //删除频道
                $('#js_del_channel').click(function () {
                    $.labelManage.delLabel();
                });
                //单项删除采集内容
                $('.js_single_del').click(function () {
                    var id = $(this).parent().attr('data-id');
                    $.labelManage.delLabel(id);
                });
            },
            /**
             * 添加/修改频道
             */
            modifyLabel: function () {
                var name = $.trim($('#js_chanel_name').val());
                var len = $.getStrLen(name);
                if (len == 0) {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gLabelNameEmptyMsg});
                    return;
                }
                /*else if(len > gChannelNameLen*2){
                 $.global_msg.init({gType:'warning',icon:2,msg:channel_name_limit.replace('%d',gChannelNameLen)});
                 return;
                 }*/
                $.ajax({
                    data: {name: name},
                    url: labelAddUrl,
                    type: 'POST',
                    dataType: 'json',
                    success: function (rst) {
                        if (rst.status == 0) {
                            $('.js_channel_pop,.js_masklayer').hide();
                            $('#js_chanel_name').val('');
                        }
                        var icon = rst.status == 0 ? 1 : 2;
                        $.global_msg.init({
                            gType: 'warning', icon: icon, msg: rst.msg,
                            endFn: function () {
                                if (rst.status == 0) {
                                    window.location.reload();
                                }
                            }
                        });
                    },
                    error: function () {
                    }
                });
            },
            /**
             * 删除频道
             */
            delLabel: function (ids) {
                var that = this;
                if (typeof(ids) == 'undefined') {
                    if (window.gLabelCheckObj.getCheck().length == 0) {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: gStrPleaseSelectData});
                        return;
                    } else {
                        $.global_msg.init({
                            gType: 'confirm', icon: 2, msg: gStrConfirmDelSelectData, btns: true, close: true,
                            title: false, btn1: gStrBtnCancel, btn2: gStrBtnOk, noFn: function () {
                                var checkIdArr = window.gLabelCheckObj.getCheck();
                                ids = checkIdArr.join(',');
                                that.delLabelOpera(ids);
                            }
                        });
                    }
                } else {
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: gStrConfirmDelSelectData, btns: true, close: true,
                        title: false, btn1: gStrBtnCancel, btn2: gStrBtnOk, noFn: function () {
                            that.delLabelOpera(ids);
                        }
                    });
                }
            },
            delLabelOpera: function (ids) {
                var data = {id: ids};
                $.ajax({
                    data: data,
                    url: labelDelUrl,
                    type: 'POST',
                    dataType: 'json',
                    success: function (rst) {
                        $.global_msg.init({
                            gType: 'warning', icon: 1, msg: rst.msg, endFn: function () {
                                if (rst.status == 0) {
                                    window.location.href = window.location.href;
                                }
                            }
                        });
                    },
                    error: function () {
                    }
                });
            }
        },
        /**
         * 获取字符串长度 包含中文处理(一个中文按照两个英文字母计算)
         * (参数说明：原字符串)
         * demo: getStrLen('我收中国人abc他');输出为：15
         */
        getStrLen: function (str) {
            if (!str)return 0;
            var chineseRegex = /[^\x00-\xff]/g;
            var strLength = str.replace(chineseRegex, "**").length;
            return strLength;
        }
    });

    //评论审核操作
    function _pass(status, cid) {
        var ids = [];
        if (cid) {
            ids.push(cid);
        } else {
            $('.active').each(function () {
                if ($(this).attr('val')) {
                    ids.push($(this).attr('val'));
                }
            });
        }

        if (ids.length == 0) {
            $.global_msg.init({gType: 'warning', icon: 2, msg: gStrselectauditcomment});
            return;
        }

        $.post(commentpassurl, {status: status, commentid: ids.join(',')}, function (data) {
            $.global_msg.init({gType: 'warning', icon: data['status'] - '' + 1, msg: data['msg']});
            if (data['status'] == 0) {
                $.news.pageReload();
            }
        });
    }
})(jQuery);
//控制字符串长度
function strlen(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        var c = str.charCodeAt(i);
        //单字节加1
        if ((c >= 0x0001 && c <= 0x007e) || (0xff60 <= c && c <= 0xff9f)) {
            len++;
        }
        else {
            len += 2;
        }
    }
    return len;
}


//实时获取内容的光标位置
//var gRange;
//$('.js_content').on('focus',function(){
//	var sel;
//	setInterval(function(){
//		 if (window.getSelection) {
//			sel = window.getSelection();
//			try{
//				if (sel.anchorNode.parentNode.id!='js_content'){
//					return;
//				}
//		        if (sel.getRangeAt && sel.rangeCount) {
//		        	gRange = sel.getRangeAt(0);
//		        	//gRange.deleteContents();
//		        }
//			} catch(e){
//				return;
//			}
//		 }
//	},100);
//}).focus();

//资讯内容中插入图片    将图片插入到坐标位置
//function insertHtmlAtCaret(html) {
//    var sel, range;
//    if (window.getSelection) {
//        // IE9 and non-IE
//        sel = window.getSelection();
//        if (sel.getRangeAt && sel.rangeCount) {
//
//            range = sel.getRangeAt(0);
//            range.deleteContents();
//            if (gRange){
//            	range = gRange;
//            }
//
//            // Range.createContextualFragment() would be useful here but is
//            // non-standard and not supported in all browsers (IE9, for one)
//            var el = document.createElement("div");
//            el.innerHTML = html;
//            var frag = document.createDocumentFragment(), node, lastNode;
//            while ( (node = el.firstChild) ) {
//                lastNode = frag.appendChild(node);
//            }
//            range.insertNode(frag);
//            // Preserve the selection
//            if (lastNode) {
//                range = range.cloneRange();
//                range.setStartAfter(lastNode);
//                range.collapse(true);
//                sel.removeAllRanges();
//                sel.addRange(range);
//            }
//        }
//    } else if (document.selection && document.selection.type != "Control") {
//        // IE < 9
//        document.selection.createRange().pasteHTML(html);
//    }
//}

//控制资讯内容添加编辑器 粘贴内容
//function cellkeydown(event) {
//    datainfo =$('#js_content').html();
//    if (event.ctrlKey && event.keyCode == 86) {
//    $('#js_content').focus();
////            $('#js_content').select();
//    // 等50毫秒，keyPress事件发生了再去处理数据
//    setTimeout("dealwithData()",1);
//}
//}
//function dealwithData(event) {
//    //编辑框中  粘贴后的内容
//    var newdatainfo = $('#js_content').html();
//    //替换掉原来的内容   剩下的是粘贴进去的内容
//    var copyhtml = newdatainfo.replace(datainfo,'');
//    //将html代码清空
//    var newhtml = copyhtml.replace(/<[^>]+>/g,"");
//    //最终要粘贴进去的内容
//    var lasthtml = datainfo+newhtml;
//    $('#js_content').html(lasthtml);
//    //如果有src 证明粘贴内容中有图片   不允许
//    if(copyhtml.indexOf('src')> -1 && copyhtml.indexOf('img')> -1){
//        $.global_msg.init({gType:'warning',icon:2,msg:'不可以复制粘贴图片'});
//        return;
//    }
//
//}
