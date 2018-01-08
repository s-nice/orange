/**
 * Created by zhaoge on 2016/12/20.
 */
;(function($){
    $.extend({
        agreement:{
            index_init:function(){ //列表页面初始化
                var that=this;
                $('.js_agreement_sort').on('click',function(){ //点击排序事件
                    var sort=$(this).attr('type')=='desc' ? 'asc' : 'desc' ;
                    var sortType=$(this).attr('sortType');
                    that.sort(sort,sortType);
                });

                $('#js_agreement_search').on('click',function(){ //搜索
                    var data={};
                    data.keyword= $.trim(encodeURIComponent($('#js_agreement_search_input').val()));
                    data.startTime= $.trim($('#js_begintime').val());
                    data.endTime= $.trim($('#js_endtime').val());
                    that.search(data);

                });

                $('#js_add_agreement').on('click',function(){ //编辑页 添加别名按钮
                    var agreementStr= $('#js_agreement_name_input').val();
                    var companyName=$.trim($('#js_company_name_input').val());
                    if(companyName==''){
                        $('#js_company_name_input').css('border','2px solid red');
                        return;
                    }
                    if(agreementStr==''){ //为空边框加粗变红
                        $('#js_agreement_name_input').css('border','2px solid red');
                        return;
                    }
                    $('#js_agreement_name_input,#js_company_name_input').css('border',' 1px solid #b8b8b8');
                    agreementStr=agreementStr.replace(/\s+/g,"");//删除所有空格;
                    agreementStr=agreementStr.replace(/，/g,",");//全角逗号替换半角逗号;
                    that.checkagreement(agreementStr);

                });

                /*删除*/
                $('#js_show_agreement_wrap').on('click','.js_agreement_del',function(){
                    $(this).parent().remove();
                    if($('.js_agreement_del').length==0){
                        $('#js_show_agreement_wrap').hide();

                    }

                });

                /*保存按钮*/
          /*      $('#js_agreement_save').on('click', function(){
                    var data={};
                    var id=$(this).attr('data-id');;
                    if(typeof (id)!='undefined'){
                        data.id=id;
                    }
                    data.name= $.trim($('#js_company_name_input').val());
                    data.agreement=that.getAddedagreementArr();
                    if(data.name=='' || 0==data.agreement.length){ //公司名和别名不能为空
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '请输入完整信息'});
                        return;

                    }else{
                        data.agreement=data.agreement.join(",");
                        that.saveAreement(data);//保存编辑或新增的数据
                    }

                })*/

                /*列表点击预览*/
                $('.js_show_one').on('click',function(){
                    var index = $(this).index('.js_show_one');
                    var content = $(this).parent().find('.js_content_temp').html();
                    console.log(content);
                    that.showOne(content,index);
                    $(' .js_masklayer').show();//遮罩层
                    $('#js_show_one_container').show();
                });

                /*关闭预览框*/
                $('#js_show_one_container .appadmin_comment_close').on('click',function(){
                    $('#js_show_one_container').hide();
                    $(' .js_masklayer').hide();//关闭遮罩层

                });

                /*预览上一篇*/
                $('#js_show_one_container .js_previous').on('click',function(){
                    var index = parseInt($('#js_show_one_container').attr('data-index')) - 1;
                    if(index < 0){
                        $.global_msg.init({gType: 'warning', msg:'没有上一篇了', icon: 2});
                    }else{
                        var content = $('.js_show_one').eq(index).parent().find('.js_content_temp').html();
                        that.showOne(content,index);
                    }

                });

                /*预览下一篇*/
                $('#js_show_one_container .js_next').on('click',function(){
                    var index = parseInt( $('#js_show_one_container').attr('data-index')) + 1;
                    console.log($('.js_show_one').eq(index).length,index);
                    if(!$('.js_show_one').eq(index).length){
                        $.global_msg.init({gType: 'warning', msg:'没有下一篇了', icon: 2});
                    }else{
                        var content = $('.js_show_one').eq(index).parent().find('.js_content_temp').html();
                        that.showOne(content,index);
                    }

                })




            },
            edit_init:function (){
                var that=this;
                /*初始化编辑器*/
                var editor;
                KindEditor.ready(function(K) {
                    editor = K.create('#js_content', {
                       // filterMode :false,
                        resizeType : null,
                        pasteType : 1,
                        minWidth: 515,
                        items : [
                            'source', '|', 'fontsize', 'bold', 'italic', 'underline',
                            'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'indent', 'outdent']
                    });
                });

                /*点击保存按钮*/
                $('#js_agreement_save').on('click',function(){
                    var data={};
                    data.id=$(this).attr('data-id');
                    data.agreement= editor.html();
                    if($.trim(editor.text())==''){
                        $('.ke-edit').addClass('invalid_warning');
                        $.global_msg.init({gType: 'warning', msg:'请填写使用协议', icon: 2});
                        return;
                    }
                    that.saveAreement(data);

                });

                /*点击预览*/
                $('#js_show_one').on('click',function(){
                    var text =editor.text();
                    if($.trim(text)==''){
                        $('.ke-edit').addClass('invalid_warning');
                        $.global_msg.init({gType: 'warning', msg:'请填写使用协议', icon: 2});
                    }else{
                        $('.ke-edit').removeClass('invalid_warning');
                        that.showOne(editor.html(),0);
                        $(' .js_masklayer').show();//遮罩层
                        $('#js_show_one_container').show();
                    }

                });

                /*关闭预览框*/
                $('#js_show_one_container .appadmin_comment_close').on('click',function(){
                    $('#js_show_one_container').hide();
                    $(' .js_masklayer').hide();//关闭遮罩层

                });

            },
            /*排序*/
            sort:function(sort,sortType){ //排序功能
                var condition='/sort/' + sort +'/sortType/' + sortType;
                if(gKeyword!=''){
                    condition+='/keyword/' +encodeURIComponent(gKeyword);
                }
                if(gStartTime!=''){
                    condition+='/gStartTime/' + gStartTime;
                }
                if(gEndTime!=''){
                    condition+='/gEndTime/' + gEndTime;
                }
                window.location.href = gUrl +condition;//跳转

            },
            /*搜索*/
            search: function (data) { //搜索功能
                var condition='';
                if(gSort!='' && gSortType!=''){
                    condition+='/sort/' + gSort + '/sortType/' + gSortType ;
                }
                if(typeof (data.keyword)!='undefined' && data.keyword!=''){
                    condition+='/keyword/'+ data.keyword;
                }
                if(typeof (data.startTime)!='undefined' && data.startTime!='' ){
                    condition+='/startTime/'+ data.startTime;
                }
                if(typeof (data.endTime)!='undefined' && data.endTime!=''){
                    condition+='/endTime/'+ data.endTime;
                }
                window.location.href = gUrl + $.trim(condition);//跳转
            },
            /*保存数据*/
            saveAreement:function(data){
                $.ajax({
                    url:gSaveUrl,
                    data:data,
                    type:'post',
                    success:function(res){
                        if(0==res.status){
                            $.global_msg.init({gType: 'warning', icon: 1,time:3 ,msg: '保存成功',endFn:function(){
                                //window.location.href = gUrl;
                                if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                    window.opener.closeWindow(window, true); //刷新列表页
                                }

                            }});
                        }else{
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});
                        }
                    },
                    fail:function(){
                        $.global_msg.init({gType: 'warning', icon: 2,time:3 ,msg: '保存失败'});
                    }

                })
            },
            /*预览*/
            showOne:function(content,index){
                $('#js_show_one_container .appadmincomment_content').html(content);
                $('#js_show_one_container').attr('data-index',index);
            }


        }

    });

})(jQuery);
