/**
 * 拓展-名片共享js
 * */
(function ($) {
    $.extend({
        cardShare: {
            init: function () {
                this.selectBox(); //下拉框事件
                this.showshareTap();//查看共享标签切换事件
                this.OpenCardImg();//查看共享 点击查看图片事件
                this.PageAjax.fn();//名片列表分页 ajax提交
                this.UndoWindow();//撤销同步事件
                this.ConfirmSyncWindonw();//确认同步事件
                this.AddAccount();//添加账号页面事件
            },

            /*下拉框*/
            selectBox: function () {

                $('.js_select_box ').on('click', function () {//点击输入框
                    $(this).find('ul').toggle();
                });
                $('.js_select_box li').on('click', function () { //点击选项
                    var val = $(this).attr('val');
                    var $input = $(this).closest('.js_select_box').find('input');
                    $input.val(val);
                    $input.attr('title', val);
                    $(this).closest('ul').attr('display', 'none');
                });
                $(document).on('click', function (e) { //点击外部
                    if ($(e.target).parents('.js_select_box').length > 0) {
                        var currUl = $(e.target).parents('.js_select_box').find('ul');
                        $('.js_select_box>ul').not(currUl).hide()
                    } else {
                        $('.js_select_box>ul').hide();
                    }
                });

            },
            /*查看共享标签切换*/
            showshareTap: function () {
                $('.share_user_title').on('click', function () { //共享账户列表标签切换点击事件
                    if (!$(this).hasClass('on')) {
                        $('.share_card_title').removeClass('on');
                        $(this).addClass('on');
                        $('.share_card_list').hide();
                        $('.share_user_list').show();
                        $('.js_card_page').hide();
                        $('.js_user_page').show();
                    }
                });
                $('.share_card_title').on('click', function () { //共享名片列表标签切换点击事件
                    var shareid = $(this).attr('shareid'); //分享ID号
                    /*切换效果*/
                    if (!$(this).hasClass('on')) {
                        $('.share_user_title').removeClass('on');
                        $(this).addClass('on');
                        $('.share_user_list').hide();
                        $('.share_card_list').show();
                        $('.js_card_page').show();
                        $('.js_user_page').hide();
                        /*ajax获取名片信息列表*/
                        if ($('.card_list_c').length == 0) { //判断是否以获取，不重复提交
                            $.ajax({  //提交获取名片列表 （进入查看共享页面不载入数据，点击标签后获取）
                                url: gShowShareUrl,
                                type: 'get',
                                data: {
                                    shareid: shareid
                                },
                                success: function (response) { //提交
                                    $('.js_no_data').remove();
                                    if(response.list!='NO DATA'){
                                        $('.js_share_card_list').append(response.list);//获取列表数据，刷新列表
                                    }else{
                                        $('.js_share_card_list').append(
                                            "<span class='js_no_data'>NO DATA</span>"
                                        )
                                    }
                                    $(".js_card_page").children('*').remove();//删除分页数据
                                    $(".js_card_page").append(response.pagedata);//刷新分页


                                },
                                fail: function () { //ajax提交失败
                                    $.cardShare.errorAlert();
                                }
                            });
                        }
                    }

                })
            },
            /*点击打开名片图片*/
            OpenCardImg: function () {
                $(".share_card_list").on('click', '.js_target_img', function () {
                    var path = $(this).attr('path'); //图片的路径
                    $(".js_masklayer").show();
                    $(".js_preview_morepic").show();
                    $(".js_moreimages_content img").remove();
                    $(".js_moreimages_content").append("<img/>");
                    $(".js_moreimages_content img").attr('src', path);

                });
                $(".js_btn_close").on('click', function () {
                    $(".js_preview_morepic").hide();
                    $(".js_masklayer").hide();
                })

            },
            /*名片列表分页ajax*/
            PageAjax: {
                fn: function () {
                    var that = this;
                    var shareid = $('.share_card_title').attr('shareid');
                    var p = '';
                    $(".js_card_page").on('submit', ' form', function (e) { //提交翻页，输入页数点击‘跳转’
                        e.preventDefault();
                        p = $(this).find('.jumppage').val();
                        that._ajax(p, shareid);

                    });
                    $(".js_card_page").on('click', '.prev', function (e) { //点击上一页
                        e.preventDefault();
                        p = $(this).siblings('.nowandall').html().split("/",1);
                        p = parseInt(p) - 1;
                        that._ajax(p, shareid);

                    });
                    $(".js_card_page").on('click', '.next', function (e) { //点击下一页
                        e.preventDefault();
                        p = $(this).siblings('.nowandall').html().split("/",1);
                        p = parseInt(p) + 1;
                        that._ajax(p, shareid);

                    })

                },
                _ajax: function (p, shareid) { // 根据页数，id 号提交获取数据
                    $.ajax({
                        url: window.location.href,
                        type: 'get',
                        data: {
                            shareid: shareid,
                            p: p
                        },
                        success: function (response) { //提交成功
                            $('.card_list_c').remove();
                            $('.js_share_card_list').append(response.list);//刷新列表
                            $(".js_card_page").children('*').remove();
                            $(".js_card_page").append(response.pagedata); //刷新分页

                        },
                        fail: function () { //ajax提交失败
                            $.cardShare.errorAlert();
                        }
                    });

                }


            },

            /*添加共享账号*/
            AddAccount: function () {
                /*原账号input默认值显示和隐藏*/
                var txt = gTxt; //input默认的提示
                $('#js_Source_Account').each(function () { //为空显示默认提示
                    $(this).focus(function () {
                        if (txt === $(this).val()) $(this).val("");
                    }).blur(function () {
                        if ($(this).val() == "") $(this).val(txt);
                    });
                });
                /*点击加号添加账号*/
                $('.js_Add_Account').on('click', '.js_Add_Account_Icon', function () {
                    if($('.js_share_input').length==24){ //长度超过容器初始化滚动条
                        var $wrapObj=$('.add_share_wrap');
                        var maxHeight=$wrapObj.height();
                        $wrapObj.css('max-height',maxHeight);
                        $wrapObj.mCustomScrollbar({
                            theme: "dark", //主题颜色
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia: 0,//滚动延迟
                            horizontalScroll: false,//水平滚动条

                        });



                    }
                    var $cloneObj = $('.js_Share_Account:last');
                    var num = Number($.trim($('.js_Share_Account:last>span>i').text())) + 1; //添加账号每行前的序号
                    $('.js_Add_Account').append($cloneObj.clone());
                    $('.js_target_Account:last').val('');
                    $('.js_Share_Account:last>span>i').text(num);
                    $(this).remove();


                });
                /*检查表单是否为空，及是否有重复 不通过阻止默认submit*/
                $('#js_share_submit').on('click', function () {
                    var TargetAccount = $.cardShare.Check.CheckTargetAccount();
                    /*判断源账号,目标账号不能为空*/

                    if ($.cardShare.Check.CheckSourceAccount(txt)) {
                        $.global_msg.init({   //所有账号不能为空
                            gType: 'warning',
                            icon: 2,
                            msg: gMsg['empty'],
                            close: true,
                            title: false
                        });
                        return;
                        /*目标账号至少有一个*/

                    } else if (TargetAccount == 'isEmpty') {
                        $.global_msg.init({   //添加共享账号数量至少为1个
                            gType: 'warning',
                            icon: 2,
                            msg: gMsg['leastOne'],
                            close: true,
                            title: false
                        });
                        return;
                    } else if (TargetAccount == 'isRepetitive') {
                        $.global_msg.init({   //所有账号不能重复
                            gType: 'warning',
                            icon: 2,
                            msg: gMsg['repetitive'],
                            close: true,
                            title: false
                        });
                        return;

                    } else {
                        var account = TargetAccount[0];
                        TargetAccount.shift();
                        var Count=TargetAccount.length; //分享账号数量
                        $.ajax({
                            url: window.location.href,
                            type: 'post',
                            data: {
                                account: account,
                                shareaccount: TargetAccount

                            },
                            success: function (response) { //提交
                                if (response.status != 0) {
                                    if (response.msg == "account not exists") {
                                        $.global_msg.init({
                                            gType: 'warning',
                                            icon: 2,
                                            msg: gMsg['unknown'],
                                            close: true,
                                            title: false
                                        });
                                    } else {
                                        $.cardShare.errorAlert();
                                    }
                                } else {
                                    window.location.href = gconfirmShareUrl + "?shareid=" + response.data.shareid+"&count="+Count;
                                }
                            },
                            fail: function () { //ajax提交失败
                                $.cardShare.errorAlert();
                            }
                        });

                    }
                })


            },
            /*撤销同步操作*/
            UndoWindow: function () {
                $(".js_Undo").on('click', function () {
                    var $this = $(this);
                    var account = $.trim($(this).closest('.Journalsection_list_c').find('.js_account_number').text());//账号
                    $.global_msg.init({   //确认撤销弹框
                        gType: 'confirm',
                        icon: 2,
                        msg: gMsg['undo'].replace('account', account),//‘是否要撤销账号xxx的操作’
                        btns: true, btn1: gMsg['yes'],//‘确认’
                        btn2: gMsg['cancel'],//'取消'
                        close: true,
                        title: false,
                        fn: function () { //确定后的执行
                            var shareid = $this.attr('shareId');//共享ID
                            $.ajax({
                                url: gCancelUrl,
                                type: 'post',
                                data: {
                                    shareid: shareid
                                },
                                success: function (response) { //提交成功
                                    if (response.status == 0) {
                                        location.reload();
                                    } else {
                                        $.cardShare.errorAlert();
                                    }
                                },
                                fail: function () { //ajax提交失败
                                    $.cardShare.errorAlert();
                                }
                            });
                        }
                    })
                })
            },
            /*确认同步弹框*/
            ConfirmSyncWindonw: function () {
                $(".js_confirm_share").on('click', function () {
                    $.global_msg.init({ //提示弹框
                        gType: 'confirm',
                        icon: 2,
                        msg: gMsg['sync'], //"确定同步吗？",
                        btns: true, btn1: gMsg['yes'],
                        btn2: gMsg['cancel'],
                        close: true,
                        title: false,
                        fn: function () { //确定后的执行
                            $.ajax({
                                url: gconfirmShareUrl,
                                type: 'post',
                                data: {
                                    confirm: 1,
                                    shareid: gShareid
                                },
                                success: function (response) { //提交成功
                                    if (response.status == 0) { //数据更新成功跳转到列表页
                                        window.location.href = gindexUrl;
                                    } else {
                                        console.info(response);
                                        $.cardShare.errorAlert();
                                    }
                                },
                                fail: function () { //ajax提交失败
                                    $.cardShare.errorAlert();
                                }
                            });
                        }
                    })

                });
                /*取消操作*/

                $('.js_share_cancel').on('click', function () {
                    $.ajax({
                        url: gconfirmShareUrl,
                        type: 'post',
                        data: {
                            confirm: 0,
                            shareid: gShareid
                        },
                        success: function (response) { //提交成功
                            if (response.status==0) { //删除成功跳转到列表页
                                window.location.href = gaddUrl;
                            } else {
                                $.cardShare.errorAlert();
                            }
                        },
                        fail: function () { //ajax提交失败
                            $.cardShare.errorAlert();
                        }
                    });


                })

            },
            Check: { //添加共享的账号检测
                /*源账号是否为空*/
                CheckSourceAccount: function (txt) {
                    if ($('#js_Source_Account').val() == '' || $('#js_Source_Account').val() == txt) {
                        return true;
                    } else {
                        return false;
                    }

                },
                /*判断目标账号至少有一个，所有账号无重复*/
                CheckTargetAccount: function () {
                    var thisCheck = true;
                    var valArr = [$("#js_Source_Account").val()];
                    var num = 1;
                    var _length = $('.js_target_Account').length;
                    $('.js_target_Account').each(function (index) {
                        if ($(this).val() != '') {
                            thisCheck = false;
                            valArr.push($.trim($(this).val()));
                            //如果前面有删除的行，序号补全
                            $(this).siblings('span').children('i').html(num);
                            num = num + 1
                        } else {
                            if (index != _length - 1) {
                                $(this).closest('.js_Share_Account').remove();//删除非第一个空的input不提交
                            } else { //最后一行保留
                                $(this).siblings('span').children('i').html(num);
                            }
                        }
                    });
                    var tempArr=valArr.slice(0);
                    if (thisCheck) {
                        return 'isEmpty';

                    } else if (valArr.length > $.unique(tempArr.sort()).length) {
                        return 'isRepetitive';

                    } else {
                        return valArr;
                    }
                }
            },
            /*操作失败统一弹框*/
            errorAlert: function () {
                $.global_msg.init({
                    gType: 'warning',
                    icon: 2,
                    msg: gFail,
                    close: true,
                    title: false
                });
            }
        }
    });
    $.cardShare.init();//监听事件
})(jQuery);
