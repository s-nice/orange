//global_msg 系统公告提示消息 jiyl
var gMsgConfirm,gMsgAlert;
;(function ($) {
    $.extend({
    	//刷新页面
    	reloadPage:{
    		init:function(){
                window.location.reload(true);
            }
    	},
        global_msg: {
            msg: '',
            gType: '',
            btns: false,
            btn1: '',
            btn2: '',
            width: '5.81rem',
            height: '3.89rem',
            icon: 0,
            time: false,
            fn: '',
            noFn: '',
            title: false,
            close: false,
            fninfo: new Array(),
            nofninfo: new Array(),
            endFn: '',              //关闭窗口执行操作  function
            init: function (settings) {
                /* 初始化 */
                if (typeof settings == 'object') {
                    if (typeof settings.title == 'string' || typeof settings.title == 'boolean') {
                        this.title = settings.title;
                    }else {
                        this.title = gMessageTitle;
                    }
                    if (typeof settings.msg == 'string') {
                        this.msg = settings.msg;
                    }
                    if (typeof settings.gType == 'string') {
                        this.gType = settings.gType;
                    } else {
                        this.gType = 'alert';
                    }
                    if (typeof settings.btns == 'boolean') {
                        this.btns = settings.btns;
                    } else {
                        this.btns = false;
                    }
                    if (typeof settings.close == 'boolean') {
                        this.close = settings.close;
                    } else {
                        this.close = false;
                    }
                    if (typeof settings.btn1 == 'string') {
                        this.btn1 = settings.btn1;
                    } else {
                        this.btn1 = gMessageSubmit1;
                    }
                    if (typeof settings.btn2 == 'string') {
                        this.btn2 = settings.btn2;
                    } else {
                        this.btn2 = gMessageSubmit2;
                    }
                    if (typeof settings.width == 'string') {
                        this.width = settings.width;
                    }
                    if (typeof settings.height == 'string') {
                        this.height = settings.height;
                    }
                    if (typeof settings.icon == 'number') {
                        this.icon = settings.icon;
                    } else {
                        this.icon = 0;
                    }
                    if (typeof settings.time == 'number') {
                        this.time = settings.time;
                    } else {
                        this.time = false;
                    }
                    if (typeof settings.fn == 'function') {
                        this.fn = settings.fn;
                    } else {
                        this.fn = '';
                    }
                    if (typeof settings.noFn == 'function') {
                        this.noFn = settings.noFn;
                    } else {
                        this.noFn = '';
                    }
                    if (typeof settings.endFn == 'function') {
                        this.endFn = settings.endFn;
                    }
                    
                    if (typeof settings.fninfo != undefined) {
                        this.fninfo = settings.fninfo;
                    } else {
                        this.fninfo = '';
                    }

                    if (typeof settings.nofninfo != undefined) {
                        this.nofninfo = settings.nofninfo;
                    } else {
                        this.nofninfo = '';
                    }
                }

                if ($('#gMessageConfirm').length == 0) {
                    $.global_msg.addMsgHtml();
                }
                if (this.gType == 'alert') {
                    $.global_msg.alert();
                } else if (this.gType == 'confirm') {
                    $.global_msg.confirm();
                } else if (this.gType == 'load'){
                	return $.global_msg.load();
                }

            },
            // 加载项
            load:function(){
            	var gMsgLoad = $.layer({
                    type: 1,
                    title: false,
                    time: $.global_msg.time, // 自动关闭时间
                    area: ['auto', 'auto'], // 层的宽高
                    bgcolor: '',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: false, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom: "#gMessageLoad"},
                    success: function(layero){
                    },
                    end: function () {
                        if(typeof($.global_msg.endFn) === "function"){$.global_msg.endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
            	return gMsgLoad;
            },
            alert: function ()
            {
            	$('#gMessageAlert').css({width: $.global_msg.width, height: $.global_msg.height});
                $('#gMessageAlert #gMessageInfo #gInfo').html($.global_msg.msg);
                if ($.global_msg.icon == 1) {
                    $('#gMessageAlert #gMessageInfo').attr('class', 'poppage_success');
                    $('#gMessageAlert #gMessageInfo #gImg').attr('src', gPublic + 'images/bg_icon_dui.png');
                } else {
                    $('#gMessageAlert #gMessageInfo').attr('class', 'poppage_failure');
                    $('#gMessageAlert #gMessageInfo #gImg').attr('src', gPublic + 'images/bg_icon_erorr.png');
                }
                // 标题栏
                $('#gMessageAlert #gTitle').css('border-bottom','none');
//                if($.global_msg.close == false && $.global_msg.title == false){
//                	$('#gMessageAlert #gTitle').css('border-bottom','none');
//                }else{
//                	$('#gMessageAlert #gTitle').css('border-bottom','1px solid #d5d5d5;');
//                }
                // 标题
                if ($.global_msg.title != false) {
                    $('#gMessageAlert #gTitle #gInfo').css('display', 'block').html($.global_msg.title);
                } else {
                    $('#gMessageAlert #gTitle #gInfo').css('display', 'none');
                }
                // 关闭
                if ($.global_msg.close != false) {
                    $('#gMessageAlert #gTitle #gClose').css('display', 'block');
                } else {
                    $('#gMessageAlert #gTitle #gClose').css('display', 'none');
                }
                
                // 按键
                if ($.global_msg.btns == true)
                {
                    $('#gMessageAlert .gMessgaeSubmit').css('display', 'block').val($.global_msg.btn1);
                    $('#gMessageAlert .poppage_btn').css('display', 'block');
                } else {
                	if($.global_msg.icon == 1 && $.global_msg.time == false){
                		$.global_msg.time = 5;
                	}
                    $('#gMessageAlert .gMessgaeSubmit').css('display', 'none').val($.global_msg.btn1);
                    $('#gMessageAlert .poppage_btn').css('display', 'none');
                }
                gMsgAlert = $.layer({
                    type: 1,
                    title: false,
                    time: $.global_msg.time, // 自动关闭时间
                    area: [$.global_msg.width, $.global_msg.height], // 层的宽高
                    bgcolor: '#fff',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: true, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom: "#gMessageAlert"},
                    success: function(layero){
                    },
                    end: function () {
                        if(typeof($.global_msg.endFn) === "function"){$.global_msg.endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
                //自设关闭
                $('body').on('click', '.gAlertClose',function () {
                    layer.close(gMsgAlert);
                });
                $('.gMessgaeSubmit').off('click').on('click', function () {
                	layer.close(gMsgAlert);
                    if (typeof $.global_msg.fn == 'function')
                    {
                        $.global_msg.fn($.global_msg.fninfo);
                    }
                });
            },
            confirm: function ()
            {
            	var shadeClose = false;
                $('#gMessageConfirm').css({width: $.global_msg.width, height: $.global_msg.height});
                $('#gMessageConfirm #gMessageInfo #gInfo').html($.global_msg.msg);
                if ($.global_msg.icon == 2) {
                    $('#gMessageConfirm').find('img').attr('src', gPublic + 'images/bg_icon_erorr.png');
                } else {
                    $('#gMessageConfirm').find('img').attr('src', gPublic + 'images/bg_icon_dui.png');
                }
                // 标题栏
                $('#gMessageConfirm #gTitle').css('border-bottom','none');
//                if($.global_msg.close == false && $.global_msg.title == false){
//                	$('#gMessageConfirm #gTitle').css('border-bottom','none');
//                }else{
//                	$('#gMessageConfirm #gTitle').css('border-bottom','1px solid #d5d5d5');
//                }
                // 标题
                if ($.global_msg.title != false) {
                    $('#gMessageConfirm #gTitle #gInfo').html($.global_msg.title);
                    $('#gMessageConfirm #gTitle #gInfo').css('display', 'block');
                } else {
                    $('#gMessageConfirm #gTitle #gInfo').css('display', 'none');
                }
                // 关闭
                if ($.global_msg.close != false) {
                    $('#gMessageConfirm #gTitle #gClose').css('display', 'block');
                } else {
                    $('#gMessageConfirm #gTitle #gClose').css('display', 'none');
                }
                // 按键
                if ($.global_msg.btns == true)
                {
                    $('#gMessageConfirm .gMessgaeReset').css('display', 'block').val($.global_msg.btn2);
                    $('#gMessageConfirm .gMessgaeSubmit').css('display', 'block').val($.global_msg.btn1);
                    $('#gMessageConfirm .poppage_btn').css('display', 'block');
                } else {
                    shadeClose = true;
                    $('#gMessageConfirm .gMessgaeReset').css('display', 'none').val($.global_msg.btn2);
                    $('#gMessageConfirm .gMessgaeSubmit').css('display', 'none').val($.global_msg.btn1);
                    $('#gMessageConfirm .poppage_btn').css('display', 'none');
                }
                gMsgConfirm = $.layer({
                    type: 1,
                    title: false,
                    time: 0, // 自动关闭时间
                    area: [$.global_msg.width, $.global_msg.height], // 层的宽高
                    bgcolor: '#fff',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: shadeClose, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom: '#gMessageConfirm'},
                    success: function(layero){
                    },
                    end: function () {
                        if(typeof($.global_msg.endFn) === "function"){ $.global_msg.endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
              //自设关闭
                $('body').off('click').on('click','.gConfirmClose', function () {
                    layer.close(gMsgConfirm);
                });
                $('.gMessgaeSubmit').off('click').on('click', function () {
                	layer.close(gMsgConfirm);
                    if (typeof $.global_msg.fn == 'function')
                    {
                    	$.global_msg.fn($.global_msg.fninfo);
                    }
                });
                $('.gMessgaeReset').off('click').on('click', function () {
                	layer.close(gMsgConfirm);
                    if (typeof $.global_msg.noFn == 'function')
                    {
                    	$.global_msg.noFn($.global_msg.nofninfo);
                    }
                });
            },
            addMsgHtml: function () {
                var info = '';
                info += '<div id="gMessageConfirm" class="gMessageAlert_bgcolor" style="display:none;">';
                info += '<div id="gMessageInfo" class="poppage_info">';
                info += '<span><img src="'+gPublic + 'images/bg_icon_dui.png" /></span>';
                info += '<p id="gInfo"></p>';
                info += '</div>';
                info += '<div class="poppage_btn">';
                info += '<span><input type="button" class="gMessgaeSubmit input_sub" value="" /></span>';
                info += '<span><input type="button" class="gMessgaeReset input_but" value="" /></span>';
                info += '</div>';
                info += '</div>';
                info += '<div id="gMessageAlert" class="gMessageAlert_bgcolor" style="display:none;">';
                info += '<div id="gTitle" class="gMessageAlert_title"><span id="gInfo"></span><span id="gClose" class="gAlertClose gMessageClose_bin"><img src="'+gPublic + 'images/icons/cards_close_img.png" /></span></div>';
                info += '<div id="gMessageInfo" class="gMessageAlert_Info">';
                info += '<span><img id="gImg" src="" /><em id="gInfo"></em></span>';
                info += '</div>';
                info += '<div class="poppaget_btn poppage_btn">';
                info += '<span><input type="button" class="gMessgaeSubmit input_sub_failure" value="" /></span>';
                info += '</div>';
                info += '</div>';
                info += '<div id="gMessageLoad" class="spinner" style="display:none;right:0.60rem;margin-top:10px;">\
  <div class="spinner-container container1">\
    <div class="circle1"></div>\
    <div class="circle2"></div>\
    <div class="circle3"></div>\
    <div class="circle4"></div>\
  </div>\
  <div class="spinner-container container2">\
    <div class="circle1"></div>\
    <div class="circle2"></div>\
    <div class="circle3"></div>\
    <div class="circle4"></div>\
  </div>\
  <div class="spinner-container container3">\
    <div class="circle1"></div>\
    <div class="circle2"></div>\
    <div class="circle3"></div>\
    <div class="circle4"></div>\
  </div>\
</div>';
                $(info).appendTo($('body'));
                return;
            }
        }
    });
})(jQuery);
