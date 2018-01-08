(function($){
$.extend({
	scannererror:{
		//故障查询列表
		errorList:function(){
			//日期选择
			$.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
			
			//下拉
			$('.js_firsttype').selectPlug({getValId: 'cardType', defaultVal: ''});
			$('.js_partner_type').selectPlug({getValId: 'cardType', defaultVal: ''});
			
			//搜索
			$('.serach_but input').on('click', function(){
				reload();
			});
			
			//重新加载数据
			function reload(){
				var params={
					'scannerid':$('#js_sn').val(),
					'type':$('#js_type').attr('val'),
					'reporttype':$('#js_reporttype').attr('val'),
					'starttime': $('#js_begintime').val(),
					'endtime': $('#js_endtime').val()
            	};
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
			}
			
			//故障记录
			$('.js_show_one').on('click', function(){
				var params={
					'scannerid':$(this).attr('id'),
					'type': $.trim($(this).parent().siblings('span:eq(1)').html()),
					'reporttype': $.trim($(this).parent().siblings('span:eq(3)').html()),
					'lastusetime': $.trim($(this).parent().siblings('span:eq(2)').html()),
					'reporttime': $.trim($(this).parent().siblings('span:eq(4)').html())
				};
				params = $.param(params);
				location.href=URL_DETAIL+'?'+params;
			});
			
			//重新启动
			$('.js_reboot').on('click', function(){
                var scannerid =$(this).attr('id');
                $.global_msg.init({
                    gType: 'confirm', icon: 2, msg: '确认是否重启?', btns: true, close: true,
                    title: false, btn1: '取消', btn2: '确认', noFn: function () {
                        $.scannererror.restart(scannerid);

                    }
                });

			});
		},
		//重新启动
		restart: function(id){
            $.ajax({
                url:URL_RESTART,
                type:'post',
                data:{
                    'scannerid':id
                },
                success:function(res){
                    if (res['status'] == 0) {
                        $.global_msg.init({
                            gType: 'warning', msg: '重启成功', time: 2, icon: 1, endFn: function () {
                                location.reload();
                            }
                        });
                    } else {
                        $.global_msg.init({
                            gType: 'warning', msg: '重启失败', time: 2, icon: 0, endFn: function () {
                                location.reload();
                            }
                        });
                    }
                },
                fail: function (err) {
                    $.global_msg.init({
                        gType: 'warning', msg: '重启失败', time: 2, icon: 0

                    });
                }

            })

		},

		//余额提醒
		moneyremind:function(){
			//保存余额
			$('#save').on('click', function(){
                var id=$(this).attr('data-id');
                var remindprice= $.trim($('#js_remindprice').val());
                if(isNaN(remindprice)){
                    $.global_msg.init({
                        gType: 'warning', msg: '请填写正确的余额', time: 2, icon: 1
                    });
                    return;
                }
				$.ajax({
					url:URL_SAVE,
					async:false,
					type:'post',
					data:{
                        id:id,
                        remindprice:remindprice
                    },
					success:function(res1){
						if(res1.status=='0'){
                            $.global_msg.init({
                                gType: 'warning', msg: '设置成功', time: 2, icon: 1, endFn: function () {
                                    location.reload();
                                }
                            });
						}else{
                            $.global_msg.init({
                                gType: 'warning', msg: '设置失败', time: 2, icon: 0, endFn: function () {
                                    location.reload();
                                }
                            });
						}
					},
					fail:function(err){
                        $.global_msg.init({
                            gType: 'warning', msg: '设置失败', time: 2, icon: 0

                        });
					}
				});
			});
			
			//添加提醒人
			$('#add').on('click', function(){
				var params={
					'name':$.trim($('.reminder input:eq(0)').val()),
					'email':$.trim($('.reminder input:eq(1)').val()),
					'mobile':$.trim($('.reminder input:eq(2)').val())
				};
				if(params.name=='' || params.email=='' || params.mobile==''){
                    $.global_msg.init({
                        gType: 'warning', msg: '请填写正确的接收人信息', time: 2, icon: 1
                    });
                    return;
                }
				$.ajax({
					url:URL_ADD,
					async:false,
					type:'post',
					data:params,
					success:function(res1){
                        if(res1.status=='0'){
                            $.global_msg.init({
                                gType: 'warning', msg: '添加成功', time: 2, icon: 1, endFn: function () {
                                    location.reload();
                                }
                            });
                        }else{
                            $.global_msg.init({
                                gType: 'warning', msg: '添加失败', time: 2, icon: 0, endFn: function () {
                                    location.reload();
                                }
                            });
                        }
                    },
					fail:function(err){
                        $.global_msg.init({
                            gType: 'warning', msg: '添加失败', time: 2, icon: 0

                        });
					}
				});
			});
			
			//删除提醒人
			$('.del').on('click', function(){
                var id =$(this).attr('data-id');
                console.log(id);
				$.global_msg.init({gType:'confirm',icon:2,msg:'是否删除？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                	$.ajax({
        				url:URL_DEL,
        				async:false,
        				type:'post',
        				data:{id:id},
                        success:function(res1){
                            if(res1.status=='0'){
                                $.global_msg.init({
                                    gType: 'warning', msg: '删除成功', time: 2, icon: 1, endFn: function () {
                                        location.reload();
                                    }
                                });
                            }else{
                                $.global_msg.init({
                                    gType: 'warning', msg: '删除失败', time: 2, icon: 0, endFn: function () {
                                        location.reload();
                                    }
                                });
                            }
                        },
                        fail:function(err){
                            $.global_msg.init({
                                gType: 'warning', msg: '删除失败', time: 2, icon: 0

                            });
                        }
        			});
                }});
			});
		},

        //统计
        statJs:function(){
            var _this = this;
            //数据列表 滚动条
            //_this.ScrollBarfunc('#js_scroll_dom');
            _this.ScrollBarfunc('.js_scroll_list');
            //点击提交
            $('.submit_button').on('click',function(){
                //提交
                _this.formSubmit();
            });
            //下拉框js
            _this.searchjs();
            $(document).on('click',function(e){
                if(!$(e.target).parents('.js_se_div').length){
                    $('.js_se_div>ul').hide();
                }
            });
            $('.js_se_div').on('click',function(e){
                $(this).find('ul').toggle();
            });
            //点击第一个 下拉框跳转
            $('.js_se_div').on('click','li',function(e){
                //下拉框选中样式
                $(this).addClass('on').siblings().removeClass('on');
                var oDiv = $(this).parents('.js_se_div');
                var val = $(this).attr('val');
                var text = $(this).text();
                var oInput = oDiv.find('input[type=text]');
                oInput.val(text).attr('val',val);

                if(oDiv.attr('id')=='js_stat_type'){
                    window.location.href = selfUrl+'/itemKey/'+val;
                }
            });
            //统计周期
            $('.js_stat_date_type').on('click','a',function(){
                $(this).addClass('on').siblings().removeClass('on');
                //提交
                _this.dataSubmit();
            });
        },
        //提交搜索
        dataSubmit:function(){
            var itemkey = $('#js_stat_type li[class=on]').attr('val');
            var s_versions = '';
            if($('.js_proversion ul li[val=all] input').prop('checked')==false){
                s_versions = $('input[name=s_versions]').val();
                if(s_versions) s_versions = '/s_versions/'+s_versions;
            }
            var h_versions = '';
            if($('.js_modelversion ul li[val=all] input').prop('checked')==false){
                h_versions = $('input[name=h_versions]').val();
                if(h_versions) h_versions = '/h_versions/'+h_versions;
            }

            var startTime = $('input[name=startTime]').val();
            if(startTime) startTime = '/startTime/'+startTime;
            var endTime = $('input[name=endTime]').val();
            if(endTime)  endTime = '/endTime/'+endTime;
            var date_type = $('.js_stat_date_type a.on').index();
            var getcondition = '/itemKey/'+itemkey+'/dt/'+date_type+s_versions+h_versions+startTime+endTime;

            window.location.href = selfUrl+getcondition;

        },
        formSubmit:function(){
            var s_versions = '';
            if($('.js_proversion ul li[val=all] input').prop('checked')==false){
                s_versions = $('input[name=s_versions]').val();
                if(s_versions) s_versions = '/s_versions/'+s_versions;
            }
            var h_versions = '';
            if($('.js_modelversion ul li[val=all] input').prop('checked')==false){
                h_versions = $('input[name=h_versions]').val();
                if(h_versions) h_versions = '/h_versions/'+h_versions;
            }

            var startTime = $('input[name=startTime]').val();
            if(startTime){
                startTime = '/startTime/'+startTime;
            }else{
                startTime = '';
            }

            var endTime = $('input[name=endTime]').val();
            if(endTime){
                endTime = '/endTime/'+endTime;
            }else{
                endTime = '';
            }
            var getcondition = s_versions+h_versions+startTime+endTime;

            window.location.href = subUrl+getcondition;

        },

        /*滚动条*/
        ScrollBarfunc: function (_dom) {
            var scrollObjs = $(_dom);

            scrollObjs.mCustomScrollbar({
                theme:"dark", //主题颜色
                autoHideScrollbar: false, //是否自动隐藏滚动条
                scrollInertia :0,//滚动延迟
                height:50,
                horizontalScroll : false//水平滚动条
            });
        },
        //搜索框js
        searchjs:function(){
            function checkAll(oDom){
                var isAll = true;
                var boxs = oDom.find('input[type=checkbox]');
                $.each(boxs,function(k,v){
                    if(k){
                        if(!$(this).is(':checked')){
                            isAll = false;
                        }
                    }
                });
                boxs.eq(0).prop('checked',isAll);
            }
            function getCheckValue(oDom){
                var boxs = oDom.find('input[type=checkbox]');
                var arr = [];
                $.each(boxs,function(k,v){
                    if(k){
                        if($(this).is(':checked')){
                            arr.push($(this).val());
                        }
                    }
                });
                var str = arr.join(',');
                oDom.find('input[type=hidden]').val(str);
            }
            //点击区域外关闭此下拉框
            $(document).on('click',function(e){
                if(!$(e.target).parents('.js_s_div').length){
                    $('.js_s_div>ul').hide();
                }
            });
            $('.js_s_div').on('click',function(e){
                if(!$(e.target).parents('ul').length){
                    $(this).find('ul').toggle();
                }
            });

            $('.js_s_div').on('click','input[type=checkbox]',function(){
                var index = $(this).parent('li').index();
                if(index){
                    checkAll($(this).parents('.js_s_div'));

                }else{

                    $(this).parents('.js_s_div').find('input[type=checkbox]').prop('checked',$(this).is(':checked'));
                }
                getCheckValue($(this).parents('.js_s_div'));
            })
            $.dataTimeLoad.init();
            $.each($('.js_s_div'),function(){
                checkAll($(this));
            });
        },
        errorDetail:function(){
            //重新启动
            $('.js_reboot').on('click', function(){
                var scannerid =$(this).attr('data-id');
                $.global_msg.init({
                    gType: 'confirm', icon: 2, msg: '确认是否重启?', btns: true, close: true,
                    title: false, btn1: '取消', btn2: '确认', noFn: function () {
                        $.scannererror.restart(scannerid);

                    }
                });

            });

        }
	}
});
})(jQuery);