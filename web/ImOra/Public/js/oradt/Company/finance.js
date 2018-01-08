$.extend({
    finance: {
        invoiceList: function () {
            var oDiv = $('#layer_div');
            var layer_div = null;
            $('#js_btn_apply').on('click', function () {
                $.get(applyUrl, {}, function (re) {
                    if (re.status === 0) {
                        oDiv.html(re.html);
                        layer_div = $.layer({
                            type: 1,
                            title: false,
                            area: ['400px', '200px'],
                            offset: ['100px', ''],
                            bgcolor: '#ccc',
                            border: [0, 0.3, '#ccc'],
                            shade: [0.2, '#000'],
                            closeBtn: false,
                            page: {dom: oDiv},
                            shadeClose: true,
                        });
                    }
                });

            });

            $('#layer_div').on('click', '#js_finance_can', function () {
                layer.close(layer_div);
            });
            $('#layer_div').on('click', '#js_finance_sub', function () {
                var money = $('#layer_div input[name=money]').val();
                $.post(postUrl, {money: money}, function (re) {
                    if (re.status === 0) {
                        $.global_msg.init({
                            gType: 'alert', time: 1, icon: 1, msg: re.msg, endFn: function () {
                                window.location.reload();
                            }
                        });
                    } else {
                        $.global_msg.init({gType: 'alert', time: 3, icon: 0, msg: re.msg});
                    }
                });
            })
        },

        invoiceMsg: function () {
            var that = this;
            //点击上传图片
            $('.js_add_img').on('click', function () { //点击上传图片图标
                $('#uploadImg').click();
            });
            $('#uploadImg').off('change').on('change', function () {
                that.uploadImg();
            });
            //鼠标滑过删除图片按钮出现
            $('.js_uploadImg_single').on("mousemove mouseout",function(event){
                if($("#js_img_show").css("display") == "block"){
                    if(event.type == "mousemove"){
                        $(this).find('.js_remove_img').show();
                    }else if(event.type == "mouseout"){
                        $(this).find('.js_remove_img').hide();
                    }
                }
            });
            //点击关闭图片
           $('.js_remove_img').on('click',function(){
               $('#js_img_url').val('');
               $('#js_img_show').hide();
               $('#js_img_show').attr('src','');
               $('.js_remove_img').hide()

           });
            //编辑按钮
            $('#js_invoice_edit').on('click', function () {
                $('#js_show_wrap').hide();
                $('#js_edit_wrap').show();
            });

            //取消按钮
            $('#js_cancel_edit').on('click', function () {
                window.location.reload();
            });

            //点击保存
            $('#finance_sub').on('click', function () {
                if (!that.checkEmpty($('input[name=taxpayer_code]'))) {
                    return false;
                } else {
                    var taxpayer_code = $('input[name=taxpayer_code]').val();
                }
                if (!that.checkEmpty($('input[name=company_addr]'))) {
                    return false;
                } else {
                    var company_addr = $('input[name=company_addr]').val();
                }
                if (!that.checkEmpty($('input[name=company_tel]'))) {
                    return false;
                } else {
                    var company_tel = $('input[name=company_tel]').val();
                }
                if (!that.checkEmpty($('input[name=bank]'))) {
                    return false;
                } else {
                    var bank = $('input[name=bank]').val();
                }
                if (!that.checkEmpty($('input[name=bank_account]'))) {
                    return false;
                } else {
                    var bank_account = $('input[name=bank_account]').val();
                }
                if (!that.checkEmpty($('input[name=img]'),'',$('.div_prove'))) {
                    return false;
                } else {
                    var img = $('input[name=img]').val();
                }

                $.post(postUrl, {
                    code: taxpayer_code,
                    regaddress: company_addr,
                    regtelephone: company_tel,
                    bank: bank,
                    bankaccount: bank_account,
                    paytaxprove: img,
                    imgPath:imgPath//判断是否重新上传图片
                }, function (re) {
                    if (re.status == 0) {
                        $.global_msg.init({gType: 'alert', time: 3, icon: 1, msg: re.msg});
                         window.location.reload();
                    } else {
                        $.global_msg.init({gType: 'alert', time: 3, icon: 0, msg: re.msg});
                        return false;
                    }
                })
            });

        },
        /**
         * param $element input 对象
         * param val 值 默认为 input val
         * parma $showEle  边框变红的 元素对象 默认 input框
         * */

        checkEmpty: function ($element, val, $showEle) { //财务信息输入检测是否填写
            val = val || $element.val(); //设置检测val 默认为input对象的val
            $showEle =$showEle || $element; //设置默认变色边框 为input框
            if (!val) { //未填写
                $showEle.addClass('errinput');//输入框变红
                if ($('html').scrollTop() > 0 || $('body').scrollTop() > 0 ) { //滚动条回滚
                    $('html').scrollTop(0);
                    $('body').scrollTop(0);
                }
                console.log($showEle);
                $.global_msg.init({gType: 'alert', time: 3, icon: 0, msg: str_please_complete});//弹框
                return false;
            } else {
                $showEle.removeClass('errinput');
                return true;
            }

        },
        /**
        * 上传图片
        * */
        uploadImg: function () {
            $.ajaxFileUpload({
                url: gUrlUploadFile,
                secureuri: false,
                fileElementId: 'uploadImg',
                data: {options:{exts:'jpg,jpeg,png'}},
                dataType: 'json',
                type: 'post',
                success: function (re) {
                    if (re.status === 0) {
                        console.log(re);
                        var imgUrl = re.url;
                        $('#js_img_show').attr('src', imgUrl);
                        $('#js_img_url').val(imgUrl);
                        $('#js_img_show').show();
                        $('.remove_img').show();
                    }
                },
                error: function (data, status, e) {
                    $.global_msg.init({gType: 'alert', time: 3, icon: 0, msg: '上传失败'});//弹框
                }
            });

        }
    }
});