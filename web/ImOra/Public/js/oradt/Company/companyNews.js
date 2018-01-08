/**
 *企业平台 企业动态JS
 *
 */
(function ($) {
    $.extend({
        companyNews: {
            init: function () {

                this.event();
                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                  checkboxClass: 'icheckbox_minimal-blue',
                  radioClass: 'iradio_minimal-blue'
                });
                //Initialize Select2 Elements
                $(".select2").select2();

            },
            event:function(){
                var that=this;

                if(  $('#js_endtime').length>0){ //日历插件
                    $('#js_endtime').dateMonthPick();
                }

                $('#js_search').on('click',function(){ //点击搜索按钮
                    that.search();
                });

                $('#js_select_type').on('change',function(){ //选择按月查询 显示选择月份框
                    var val=$(this).val();
                    if(val==3){
                       $('.js_select_mouth').show();

                    }else{
                        $('.js_select_mouth').hide();
                    }
                });

                $('#js_news_publish').on('click',function(){
                    $(this).attr("disabled", true);
                    that.checkNew();

                });

                $('.js_delete').on('click',function(){ //删除
                    var obj=$(this);
                        $.global_msg.init({gType:'confirm',icon:2,msg:gConfirmDelMsg ,btns:true,close:true,
                            title:false,btn1:gCancelStr ,btn2:gConfirmStr ,noFn:function(){
                                var id=obj.attr('id-data');
                                that.delNew(id)
                            }});


                });

                $('.js_reltype').on('click',function(){ //选择发布人
                    if($(this).val()==1){
                        $('#js_departments').hide(); //显示隐藏部门下拉框

                    }else{
                        $('#js_departments').show();

                    }
                })

            },
            search:function(){ //搜索 参数拼接跳转
                var condition = '';
                var p =$('#js_p_num').val();
                var type='';
                var timeType=$('#js_select_type').val();
                var mouth=$('#js_endtime').val();
                var title=encodeURIComponent($('#js_title').val());
                if($('#js_type_news').is(':checked') && !$('#js_type_notice').is(':checked')){
                    type='1';
                }else if(!$('#js_type_news').is(':checked') && $('#js_type_notice').is(':checked')){
                    type='2';

                }
              /*  if(p!=''){ //页数
                    condition+='/p/'+p;
                }*/

                if(type!=''){ //动态类型 新闻or公告
                    condition+='/type/' + type;
                }
                if(timeType!=''){ //事件类型 最近3个月  最近12个月 按月查询
                    condition+='/timeType/' +timeType;
                }
                if(mouth!='' && timeType==3){  //按月查询的月份
                    condition+='/mouth/' +mouth;

                }
                if(title!=''){ //标题
                    condition+='/title/' +title;
                }
               window.location.href=searchurl+condition;

            },

            checkNew:function(){ //检测 编辑或新建的动态
                var data={};
                data.type=$("input[name='type']:checked").val();
                var title=$("input[name='title']").val();
                var content=ue.getContent();
                data.reltype =$("input[name='reltype']:checked").val();

                if(typeof ($('#js_news_publish').attr('id-data'))!='undefined'){ //判断编辑或新建 编辑传入id
                    data.id=$('#js_news_publish').attr('id-data');
                }

                if(title!=''){
                    data.title=title;
                }else{
                    $.global_msg.init({gType: 'warning', msg:gDataNullMsg, icon: 2});
                    $('#js_news_publish').attr("disabled", false);
                    return false;
                }

                if(content!=''){
                    data.content=content;
                }else{
                    $.global_msg.init({gType: 'warning', msg: gDataNullMsg, icon: 2});
                    $('#js_news_publish').attr("disabled", false);
                    return false;
                }
                if( data.reltype==2 ){ //发布人选择部门 发送部门数据
                    data.departments=$('#js_departments').val();

                }
                this.submitNew(data)

            },

            submitNew:function(data){
                $.ajax({
                    url:gDoNewsUrl,
                    type:'post',
                    data:data,
                    success:function(response){
                        if(response['status']=='0'){
                            /*关闭当前页面 刷新列表页*/
                            if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                window.opener.closeWindow(window, true);
                            }
                        }else{

                            $.global_msg.init({gType: 'warning', msg:gPublishFailMsg, icon: 2});
                        }
                    },
                    fail:function(){
                        $.global_msg.init({gType: 'warning', msg:gPublishFailMsg, icon: 2});
                        $('#js_news_publish').attr("disabled", false);
                        return false;
                    }


                });

            },

            delNew:function (id){
                $.ajax({
                    url:gDelUrl,
                    type:'post',
                    data:{
                        id:id
                    },
                    success:function(response){
                        if(response['status']=='0'){
                            window.location.reload();

                        }else{

                            $.global_msg.init({gType: 'warning', msg:gDelFailMsg, icon: 2});
                        }

                    },
                    fail:function(){
                        $.global_msg.init({gType: 'warning', msg: gDelFailMsg, icon: 2});
                        return false;

                    }


                })


            }

        }

    });

    $.companyNews.init();
})(jQuery);