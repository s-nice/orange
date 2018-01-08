$.extend({
    orastatguard:{
        init:function(){
            var _this = this;
            //数据列表 滚动条
            _this.ScrollBarfunc('#js_scroll_dom');
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
                //$(this).addClass('on').siblings().removeClass('on');
                var oDiv = $(this).parents('.js_se_div');
                var val = $(this).attr('val');
                //var text = $(this).text();
                //var oInput = oDiv.find('input[type=text]');
                //oInput.val(text).attr('val',val);
                var getcondition = selfUrl;
                if(val==1 || val==2){
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

                    var itemkey = $('#js_stat_type li[class=on]').attr('val');
                    var datetype = '';
                    if(itemkey==1 || itemkey==2){
                        datetype = '/dt/'+$('.js_stat_date_type a[class=on]').index();
                    }
                    getcondition += startTime+endTime+datetype;
                }else{
                    var endTime = $('input[name=endTime]').val();
                    if(endTime){
                        endTime = '/endTime/'+endTime;
                    }else{
                        endTime = '';
                    }
                    getcondition += endTime;
                }
                getcondition += '/itemKey/'+val;


                if(oDiv.attr('id')=='js_stat_type'){
                    window.location.href = getcondition;
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

            /*var startTime = $('input[name=startTime]').val();
            if(startTime) startTime = '/startTime/'+startTime;
            var endTime = $('input[name=endTime]').val();
            if(endTime)  endTime = '/endTime/'+endTime;*/
            var date_type = $('.js_stat_date_type a.on').index();
            var getcondition = '/itemKey/'+itemkey+'/dt/'+date_type+s_versions+h_versions;//+startTime+endTime;

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

            var itemkey = $('#js_stat_type li[class=on]').attr('val');
            var datetype = '';
            if(itemkey==1 || itemkey==2){
                datetype = '/dt/'+$('.js_stat_date_type a[class=on]').index();
            }

            var getcondition = s_versions+h_versions+startTime+endTime+datetype;

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
        }

    }
});
			
