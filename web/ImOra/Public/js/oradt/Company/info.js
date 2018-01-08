/**
 * Created by zhaoge on 2016/8/11.
 */
alert(2);
(function ($) {
    $.extend({
        companyInfo: {
            init: function () {
                this.getAddressList(); //点击地址选项事件
                this.checkEmpty(); //检查表单必选项是否为空
                this.checkSubmit();//检查表单规则

            },
            msg: {
                err_contact: '您输入的联系人有误，请重新输入！',//联系人错误消息提示
                err_phone: '您输入的联系人电话有误，请重新输入！', //联系人电话错误消息提示
                err_website: '您输入的网址格式错误，请重新输入！',//企业网址输入错误提示
                error: '操作失败',
                success: '保存成功'
            },
            re: {
                /*联系人电话规则：数字或”-”，“,”（ 长度64）必填项，可以输入多个号码，多个号码用”，”号分隔，可以是坐机号或手机号
                 电话开头可以有一个“+”号 “+”号后不能直接写“-” 分割的逗号只能半角，
                 */
                phone: /^[\+\d][\d]+([-]?[\d])+(,[\+\d][\d]+([-]?[\d])+)*$/,
                website: /^(http(s)?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w\-\.\/?%&=]*)?$/

            },
            loop: 0,//循环初始值
            getAddressList: function () { //更改省份城市列表时刷新城市和区列表
                var that = this;
                $("#province").on('change', function () { //更改省份事件
                    var provinceId = $(this).val();
                    that.getCityList(provinceId); //刷新城市列表

                });
                $("#city").on('change', function () { //更改城市事件
                    var cityId = $(this).val();
                    that.getRegionList(cityId);//同时更改默认的区列表
                })

            },
            getCityList: function (id) { //通过省份ID 获取省份的城市列表
                var that = this;
                $.ajax({
                    url: gGetAddressUrl,
                    type: "get",
                    data: {
                        action: "cityList",
                        id: id
                    },
                    success: function (response) {
                        $("#city option").remove();
                        $.each(response, function () {
                            $("#city").append("<option></option>");
                            $("#city option:last").html(this.name);
                            $("#city option:last").val(this.code);
                        });
                        var cityId = $("#city").val();
                        that.getRegionList(cityId);//同时更改默认的区列表
                        that.loop = 0;

                    },
                    fail: function () { //获取失败最多重复提交3次
                        if (that.loop != 3) {
                            that.loop += 1;
                            that.getCityList(id)

                        } else {
                            $.global_msg.init({ //弹出消息框
                                gType: 'warning',
                                icon: 2,
                                msg: that.msg.error,
                                close: true,
                                title: false
                            });

                        }

                    }
                })
            },
            getRegionList: function (id) { //通过城市ID获取区列表
                var that = this;
                $.ajax({
                    url: gGetAddressUrl,
                    type: "get",
                    data: {
                        action: "regionList",
                        id: id
                    },
                    success: function (response) {
                        console.log(response);
                        $("#region option").remove();
                        $.each(response, function () {
                            $("#region").append("<option></option>");
                            $("#region option:last").html(this.name);
                            $("#region option:last").val(this.code);
                        });
                        that.loop = 0;
                    },
                    fail: function () { //获取失败最多重复提交3次
                        if (that.loop != 3) {
                            that.loop += 1;
                            that.getRegionList(id)

                        } else {
                            $.global_msg.init({ //弹出消息框
                                gType: 'warning',
                                icon: 2,
                                msg: that.msg.error,
                                close: true,
                                title: false
                            });

                        }

                    }
                })
            },
            checkEmpty: function () { //必填项有空，保存按钮状态为不可用
                $('form input').on('change', function () {
                    if ($.trim($('#contact').val()) && $.trim($('#phone').val()) && $.trim($('#website').val())) {
                        $(".js_submit").removeAttr('disabled');
                    } else {
                        $(".js_submit").attr('disabled', 'true');
                    }
                })

            },
            checkSubmit: function () { //点击提交检查表单的规则，不通过阻止默认提交
                var that = this;
                $('form').on('submit', function (e) {
                    e.preventDefault(); // 阻止默认提交
                    if ($('#contact').val().length > 64) { //联系人不为空且长度小于64
                        $.global_msg.init({ //弹出消息框
                            gType: 'warning',
                            icon: 2,
                            msg: that.msg.err_contact,
                            close: true,
                            title: false
                        });
                    } else if (!that.re.phone.test($('#phone').val()) || $('#phone').val().length > 64) { //联系人电话规则
                        $.global_msg.init({ //弹出消息框
                            gType: 'warning',
                            icon: 2,
                            msg: that.msg.err_phone,
                            close: true,
                            title: false
                        });

                    } else if (!that.re.website.test($('#website').val())) {
                        $.global_msg.init({ //弹出消息框
                            gType: 'warning',
                            icon: 2,
                            msg: that.msg.err_website,
                            close: true,
                            title: false
                        });

                    } else {
                        $.ajax({
                            url: gSaveUrl,
                            type: "post",
                            data: {
                                type: $("#type").val(),
                                contact: $("#contact").val(),
                                phone: $("#phone").val(),
                                size: $("#size").val(),
                                address: $("#address").val(),
                                website: $("#website").val(),
                                province: $("#province").val(),
                                city: $("#city").val(),
                                region: $("#region").val()
                            },
                            success: function (response) {
                                if (response == 0) {
                                    $.global_msg.init({ //弹出消息框
                                        //  gType: 'warning',
                                        icon: 1,
                                        msg: that.msg.success,
                                        close: true,
                                        title: false,
                                        time: 3, //不点击关闭，3s 后自动关闭
                                        endFn: function () {
                                            window.location.href = gIndexUrl;
                                        }
                                    });
                                } else {
                                    $.global_msg.init({ //弹出消息框
                                        gType: 'warning',
                                        icon: 2,
                                        msg: that.msg.error,
                                        close: true,
                                        title: false
                                    });
                                }
                            },
                            fail: function () { //获取失败最多重复提交3次
                                $.global_msg.init({ //弹出消息框
                                    gType: 'warning',
                                    icon: 2,
                                    msg: that.msg.error,
                                    close: true,
                                    title: false
                                });

                            }

                        })
                    }

                })
            }

        }

    });
    $.companyInfo.init();
})(jQuery);