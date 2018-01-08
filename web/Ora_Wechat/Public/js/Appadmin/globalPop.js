//global_msg 系统公告提示消息 jiyl
/* 警告提示框调用方法 gType:'warning' icon:0(X)|1(√)|2(!) time:5(自动关闭时间，默认为5秒后自动关闭)
 * endFn:自动关闭后的回调函数,可不写
 * $.global_msg.init({gType:'warning',icon:2,msg:'提示内容'}); 
 * 
 */
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
            width: 440,
            height: 242,
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
                    if (typeof settings.width == 'number') {
                        this.width = settings.width;
                    }else{
                    	this.width = 440;
                    }
                    if (typeof settings.height == 'number') {
                        this.height = settings.height;
                    }else{
                    	this.height = 242;
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
                    }else{
                    	this.endFn = '';
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
                    this.addMsgHtml(this);
                }
                if (this.gType == 'alert') {
//                	this.alert(this);
                	if (typeof settings.height == 'number') {
                        this.height = settings.height;
                    }else{
                    	this.height = 150;
                    }
                	//自适应高度
                	this.height = settings.height;
                	this.warning(this);
                } else if (this.gType == 'confirm') {
                	
                    this.confirm(this);
                } else if(this.gType == 'warning') {
                	if (typeof settings.height == 'number') {
                        this.height = settings.height;
                    }else{
                    	this.height = 150;
                    }
                	//自适应高度
                	this.height = settings.height;
                	
                	this.warning(this);
                }
            },
            alert: function (obj)
            {
                $('#gMessageAlert #gMessageInfo #gInfo').html(obj.msg);
                if (obj.icon == 1) {
                    $('#gMessageAlert #gMessageInfo').attr('class', 'poppage_success');
                    $('#gMessageAlert #gMessageInfo #gImg').attr('src', gPublic + 'images/icons/company_editor_dui.png');
                } else {
                    $('#gMessageAlert #gMessageInfo').attr('class', 'poppage_failure');
                    $('#gMessageAlert #gMessageInfo #gImg').attr('src', gPublic + 'images/icons/company_editor_cuo.png');
                }
                // 标题栏
                $('#gMessageAlert #gTitle').css('border-bottom','none');
//                if(obj.close == false && obj.title == false){
//                	$('#gMessageAlert #gTitle').css('border-bottom','none');
//                }else{
//                	$('#gMessageAlert #gTitle').css('border-bottom','1px solid #d5d5d5;');
//                }
                // 标题
                if (obj.title != false) {
                    $('#gMessageAlert #gTitle #gInfo').css('display', 'block').html(obj.title);
                } else {
                    $('#gMessageAlert #gTitle #gInfo').css('display', 'none');
                }
                // 关闭
                if (obj.close != false) {
                    $('#gMessageAlert #gTitle #gClose').css('display', 'block');
                } else {
                    $('#gMessageAlert #gTitle #gClose').css('display', 'none');
                }
                
                // 按键
                if (obj.btns == true)
                {
                    $('#gMessageAlert .gMessgaeSubmit').css('display', 'block').val(obj.btn1);
                    $('#gMessageAlert .poppage_btn').css('display', 'block');
                } else {
                	if(obj.icon == 1 && obj.time == false){
                		obj.time = 5;
                	}
                    $('#gMessageAlert .gMessgaeSubmit').css('display', 'none').val(obj.btn1);
                    $('#gMessageAlert .poppage_btn').css('display', 'none');
                }
                var divId = new Date().getTime();
                var endFn = obj.endFn;
                var fn = obj.fn;
                var fninfo = obj.fninfo;
                $("body").append($('#gMessageAlert').clone().attr('id','gMessageAlert'+divId));
                $('#gMessageAlert'+divId).css({width: obj.width + 'px', height: obj.height + 'px'});
                var layerindex = $.layer({
                    type: 1,
                    title: false,
                    time: obj.time, // 自动关闭时间
                    //area: [obj.width + 'px', obj.height + 'px'], // 层的宽高
                    area: [obj.width + 'px', 150 + 'px'], // 层的宽高
                    bgcolor: '#fff',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.7, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: true, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom:$('#gMessageAlert'+divId) },
                    end: function () {
                    	$('#gMessageAlert'+divId).remove();
                        if(typeof(endFn) === "function"){endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
                //自设关闭 
                $('#gMessageAlert'+divId).on('click', '.gAlertClose',function () {
                    layer.close(layerindex);
                });
                $('#gMessageAlert'+divId).on('click', '.gMessgaeSubmit',function () {
                	layer.close(layerindex);
                    if (typeof fn == 'function')
                    {
                    	fninfo != ''?fn(fninfo):fn();
                    }
                });
            },
            confirm: function (obj)
            {
            	var shadeClose = false;
                
                // 标题栏
                $('#gMessageConfirm #gTitle').css('border-bottom','none');
//                if(obj.close == false && obj.title == false){
//                	$('#gMessageConfirm #gTitle').css('border-bottom','none');
//                }else{
//                	$('#gMessageConfirm #gTitle').css('border-bottom','1px solid #d5d5d5');
//                }
                // 标题
                if (obj.title != false) {
                    $('#gMessageConfirm #gTitle #gInfo').html(obj.title);
                    $('#gMessageConfirm #gTitle #gInfo').css('display', 'block');
                } else {
                    $('#gMessageConfirm #gTitle #gInfo').css('display', 'none');
                }
                // 关闭
                if (obj.close != false) {
                    $('#gMessageConfirm #gTitle #gClose').css('display', 'block');
                } else {
                    $('#gMessageConfirm #gTitle #gClose').css('display', 'none');
                }
                // 按键
                if (obj.btns == true)
                {
                    $('#gMessageConfirm .gMessgaeReset').css('display', 'block').val(obj.btn2);
                    $('#gMessageConfirm .gMessgaeSubmit').css('display', 'block').val(obj.btn1);
                    $('#gMessageConfirm .poppage_btn').css('display', 'block');
                } else {
                    shadeClose = true;
                    $('#gMessageConfirm .gMessgaeReset').css('display', 'none').val(obj.btn2);
                    $('#gMessageConfirm .gMessgaeSubmit').css('display', 'none').val(obj.btn1);
                    $('#gMessageConfirm .poppage_btn').css('display', 'none');
                }
                var divId = new Date().getTime();
                $("body").append($('#gMessageConfirm').clone().attr('id','gMessageConfirm'+divId));
                $('#gMessageConfirm'+divId).css({width: obj.width + 'px', height: obj.height + 'px'});
                $('#gMessageConfirm'+divId+' #gMessageInfo #gInfo').html(obj.msg);
                var endFn = obj.endFn;
                var fn = obj.fn;
                var fninfo = obj.fninfo;
                var noFn = obj.noFn;
                var nofninfo = obj.nofninfo;
                var layerIndex = $.layer({
                    type: 1,
                    title: false,
                    time: 0, // 自动关闭时间
                    //area: [obj.width + 'px', obj.height + 'px'], // 层的宽高
                    area: [obj.width + 'px', obj.height + 'px'], // 层的宽高
                    bgcolor: '#fff',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.7, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: shadeClose, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom: '#gMessageConfirm'+divId},
                    end: function () {
                    	$('#gMessageConfirm'+divId).remove();
                        if(typeof(endFn) === "function"){ endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
              //自设关闭
                $('#gMessageConfirm'+divId).on('click','#gClose', function () {
                    layer.close(layerIndex);
                });
                $('#gMessageConfirm'+divId).on('click', '.gMessgaeSubmit',function () {
                	layer.close(layerIndex);
                    if (typeof fn == 'function')
                    {
                    	fninfo != ''?fn(fninfo):fn();
                    }
                });
                $('#gMessageConfirm'+divId).on('click', '.gMessgaeReset',function () {
                	layer.close(layerIndex);
                    if (typeof noFn == 'function')
                    {
                    	nofninfo != ''?noFn(nofninfo):noFn();
                    }
                });
            },
            warning:function(obj){
                $('#gMessageWarning #gInfo').html(obj.msg);
                switch (obj.icon ) {
                	case 0:
                		$('#gMessageWarning #gImg').attr('class','imgc_em');
                		break;
                	case 1:
                		$('#gMessageWarning #gImg').attr('class','img_em');
                		break;
                	case 2:
                		$('#gMessageWarning #gImg').attr('class','imgts_em');
                		break;
                	default:
                		$('#gMessageWarning #gImg').attr('class','imgc_em');
                }
                var divId = new Date().getTime();
                $("body").append($('#gMessageWarning').clone().attr('id','gMessageWarning'+divId));
                
                $('#gMessageWarning'+divId).find('.public_pop_c , .margin_auto').css({width: obj.width + 'px', height: obj.height + 'px'});
                $('#gMessageWarning'+divId).css({width: obj.width + 'px', height: obj.height + 'px'});

                var endFn = obj.endFn;
                $.layer({
                    type: 1,
                    title: false,
                    time: typeof(obj.time) == 'number'?obj.time:5, // 自动关闭时间
                    //area: [obj.width + 'px', obj.height + 'px'], // 层的宽高
                    area: [obj.width + 'px', 150 + 'px'], // 层的宽高
                    bgcolor: '#fff',
                    border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                    shade: [0.7, '#000'], //遮罩透明度, 遮罩颜色
                    shadeClose: true, // 点击遮罩层是否关闭弹出层
                    closeBtn: [0, false], //去掉默认关闭按钮
                    fix: true, // 不随滚动条而滚动，固定在可视区域
                    moveOut: false, // 是否允许被拖出可视窗口外
                    shift: 'top', // 从上面动画弹出
                    page: {dom: '#gMessageWarning'+divId},
                    end: function () {
                    	$('#gMessageWarning'+divId).remove();
                        if(typeof(endFn) === "function"){endFn.apply(this); }
                    } // 层被彻底关闭后进行的操作
                });
            },
            addMsgHtml: function () {
                var info = '';
                info += '<div id="gMessageConfirm" class="gMessageAlert_bgcolor" style="display:none;">';
                info += '<div id="gTitle" class="gTitle_title"><span id="gInfo"></span><span id="gClose" class="gConfirmClose gMessageClose_bin"><img src="'+gPublic + 'images/Appadmin/icons/cards_close_img.png" /></span></div>';
                info += '<div id="gMessageInfo" class="poppage_info">';
                info += '<p id="gInfo"></p>';
                info += '</div>';
                info += '<div class="poppage_btn">';
                info += '<span><input type="button" class="gMessgaeSubmit input_sub" value="" /></span>';
                info += '<span><input type="button" class="gMessgaeReset input_but" value="" /></span>';
                info += '</div>';
                info += '</div>';
                info += '<div id="gMessageAlert" class="gMessageAlert_bgcolor" style="display:none;">';
                info += '<div id="gTitle" class="gMessageAlert_title"><span id="gInfo"></span><span id="gClose" class="gAlertClose gMessageClose_bin"><img src="'+gPublic + 'images/Appadmin/icons/cards_close_img.png" /></span></div>';
                info += '<div id="gMessageInfo" class="gMessageAlert_Info">';
                info += '<span><img id="gImg" src="" /><i id="gInfo"></i></span>';
                info += '</div>';
                info += '<div class="poppaget_btn poppage_btn">';
                info += '<span><input type="button" class="gMessgaeSubmit input_sub_failure" value="" /></span>';
                info += '</div>';
                info += '</div>';
                info += '<div id="gMessageWarning" class="public_pop_c" style="display: none;">\
                		<div class="margin_auto">\
                		<div><em id="gImg" class=""></em></div>\
                		<span id="gInfo"></span>\
                		</div>\
                		</div>';
                $(info).appendTo($('body'));
                return;
            }
        }
    });
})(jQuery);
