/**
 *orange 别名维护js
 *
 * */
;(function($){
    $.extend({
        alias:{
            init:function(){ //页面初始化
                var that=this;
                $('#js_alias_sort').on('click',function(){ //点击排序事件
                    var sort=gSort=='desc' ? 'asc' : 'desc' ;
                    that.sort(sort);
                });

                $('#js_alias_search').on('click',function(){ //搜索
                    var keyword=encodeURIComponent($('#js_alias_search_input').val());
                    that.search(keyword);

                });

                $('#js_add_alias').on('click',function(){ //编辑页 添加别名按钮
                    var aliasStr= $('#js_alias_name_input').val();
                    if(that.checkNameOrKeywords()){//检测公司名，和中文关键字
                        if(aliasStr==''){ //为空边框加粗变红
                            $('#js_alias_name_input').css('border','2px solid red');
                            return;
                        }

                        $('#js_alias_name_input,#js_company_name_input,#js_company_keywordscn_input').css('border',' 1px solid #b8b8b8');
                        aliasStr=aliasStr.replace(/\s+/g,"");//删除所有空格;
                        aliasStr=aliasStr.replace(/，/g,",");//全角逗号替换半角逗号;
                        that.checkAlias(aliasStr);

                    }


                });

                /*别名删除*/
                $('#js_show_alias_wrap').on('click','.js_alias_del',function(){
                    $(this).parent().remove();
                    if($('.js_alias_del').length==0){
                        $('#js_show_alias_wrap').hide();

                    }

                });

                /*保存按钮*/
                $('#js_alias_save').on('click', function(){
                    var data={};
                    var id=$(this).attr('data-id');
                    if(typeof (id)!='undefined'){
                        data.id=id;
                    }
                    if(that.checkNameOrKeywords()){//检测 公司名 和 中文关键字
                        data.alias=that.getAddedAliasArr();
                        data.name= $.trim($('#js_company_name_input').val());
                        data.keywordscn=$.trim($('#js_company_keywordscn_input').val());
                        if( 0==data.alias.length  ){ //别名不能为空
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '请输入完整信息'});
                            return;

                        }else{
                            data.alias=data.alias.join(",");
                            that.saveAlias(data);//保存编辑或新增的数据
                        }
                    }

                })

            },
            /*排序*/
            sort:function(sort){ //排序功能
                var condition='/sort/' + sort;
                if(gKeyword!=''){
                    condition+='/keyword/' + encodeURIComponent(gKeyword);
                }
                window.location.href = gUrl +condition;//跳转

            },
            /*搜索*/
            search: function (keyword) { //搜索功能
                var condition='';
                if($.trim(keyword)!=''){
                   condition= '/keyword/' + keyword;
                };
                if(gSort!='desc'){
                    condition+='/sort/' + gSort;
                }
                window.location.href = gUrl +condition;//跳转
            },
            checkNameOrKeywords:function(){ //检测 公司名 和 中文关键字
                var companyName=$.trim($('#js_company_name_input').val());
                var keywordscn= $.trim($('#js_company_keywordscn_input').val());
                if(companyName==''){
                    $('#js_company_name_input').css('border','2px solid red');
                    return false;
                }else{
                    $('#js_company_name_input').css('border','1px solid #b8b8b8');

                }

                if(keywordscn==''){
                    $('#js_company_keywordscn_input').css('border','2px solid red');
                    return false;
                }else{
                    $('#js_company_keywordscn_input').css('border','1px solid #b8b8b8');

                }

                var reg = /^[\u4E00-\u9FA5]+$/;
                if(!reg.test(keywordscn)){
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请正确填写中文关键字'});
                    $('#js_company_keywordscn_input').css('border','2px solid red');
                    return false;
                }else{
                    $('#js_company_keywordscn_input').css('border','1px solid #b8b8b8');

                }

                return true;

            }
            ,
            /*检测别名*/
            checkAlias:function(aliasStr){
                var that=this;
                var arr=aliasStr.split(',');
                var verifiedArr=[];
                var addedArr=that.getAddedAliasArr();//获取已添加到显示容器的别名数组
                for(var i=0;i<arr.length;i++){
                    if(arr[i]!=''){ //判断不为空的
                        if(arr[i].length>128){//判断长度
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '单个别名长度超出限制'});
                            return ;
                        }else if(addedArr.indexOf(arr[i])>-1 || verifiedArr.indexOf(arr[i])>-1 ){//判断是否重复添加
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '别名不能重复添加'});
                            return ;
                        }else{
                            verifiedArr.push(arr[i]);
                        }
                    }
                }
                $('#js_alias_name_input').val('');
                that.newAliasToWrap(verifiedArr);
            },
            /*检测成功处理后的别名显示到容器中*/
            newAliasToWrap:function(arr){
                for(var i=0;i<arr.length;i++){
                    $('#js_show_alias_wrap').append(
                    "<span class='js_alias_name' val='"+arr[i]+"'><em>"+arr[i]+"</em><i class='js_alias_del'>X</i></span>")
                }
                $('#js_show_alias_wrap').show();


            },
            //获取已添加到显示容器的别名数组
            getAddedAliasArr:function(){
                var addedArr=[];
                $('.js_alias_name').each(function(){
                    addedArr.push($.trim($(this).attr('val')));

                });
                return addedArr;

            },
            /*保存数据*/
            saveAlias:function(data){
                $.ajax({
                    url:gSaveUrl,
                    data:data,
                    type:'post',
                    success:function(res){
                        if(0==res.status){
                            $.global_msg.init({gType: 'warning', icon: 1,time:3 ,msg: '保存成功',endFn:function(){
                                window.location.href = gUrl;
                            }});
                        }else if(res.status==999036){
                            var errParam=res.msg.substr(0,res.msg.indexOf(' '));
                            switch(errParam){
                                case 'name':
                                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: "'"+data.name+"'"+'公司名称已经存在，请修改后保存'});
                                    break;
                                case 'keywordscn':
                                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: "'"+data.keywordscn+"'"+'中文关键字已经存在，请修改后保存'});
                                    break;
                                case 'alias':
                                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: "'"+res.data+"'"+'别名已经存在，请修改后保存'});
                                    break
                                default:
                                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});

                            }
                        }else{
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});
                        }
                    },
                    fail:function(){
                        $.global_msg.init({gType: 'warning', icon: 2,time:3 ,msg: '保存失败'});
                    }

                })

            }

        }

    });
    $.alias.init()
})(jQuery);
