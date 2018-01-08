$.extend({
	activeoperation:{
		layer_div:null,
		sle_id:'',
        view_id:0,
        showid:'',
        postState:true,
		common:function(){
			//搜索条件选择框
			var _this = this;
			$('.js_select_div').on('click','.span_name,ul,em',function(e){
				$(this).parent('.js_select_div').find('ul').toggle();
				//点击其他地方，隐藏下拉框
				$(document).one("click", function(){
			        $(".js_select_div ul").hide();
			    });
				e.stopPropagation();
			});
			//点击li选中搜索条件
			$('.js_select_div').on('click','ul>li',function(){
				var val = $(this).attr('val');
				var text = $(this).text();
				var oInput = $(this).parents('.js_select_div').find('.span_name input');
				oInput.val(text).attr('title',text).attr('val',val);
			});

			//搜索
			$('#js_searchbutton').on('click',function(){
                window.location.href = _this.searchParam();
            }); 

			//单选
            $('.js_select').on('click',function(){
            	$(this).toggleClass('active');
            	_this.isSelectAll();
            })

			//全选
			$('#js_allselect').on('click',function(){
				$(this).toggleClass('active');
				var bool = $(this).hasClass('active');
				if(bool){
					$('.js_select').addClass('active');
				}else{
					$('.js_select').removeClass('active');
				}

			});

			//点击上方删除按钮
			$('#js_delnews').on('click',function(){
				if($('.js_select.active').length){
					
                    var obj = _this._getSelectId();
                    if(obj.candel===false){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:'发布后的任务不能删除'});
                        return false;
                    }
					_this._delTask(obj.str,delUrl,'删除');
				}else{
					$.global_msg.init({gType:'alert',icon:2,time:3,msg:'请选择后删除'});
                    return false;
				}

			});

			//点击列表后边删除
			$('.js_single_delete').on('click',function(){
				var id = $(this).parents('.sectionnot_list_c').find('.js_select').attr('val');
				_this._delTask(id,delUrl,'删除');
			});

            
		},
        _closeCommon:function(){
            //取消,关闭新增页面
            $('#js_cancel_close').on('click',function(){
                // window.history.back(-1);
                window.close();
            });
        },
		//活动列表页
		index:function(){
			var _this = this;
			_this.common();

            //点击预览
			$('#js_btn_preview').on('click',function(){
                if(!$('.js_select.active').length){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'请勾选活动后预览'});
                    return false;
                }
                var id = $('.js_select.active:eq(0)').attr('data-val');
                _this.view_id = 0;
                _this._getView(showinfoUrl,{id:id});
            });

            //点击预览框关闭
            $('#js_layer_div').on('click','.js_btn_channel_cancel',function(){
                layer.close(_this.layer_div);
            });

            //预览翻下页
            $('#js_layer_div').on('click','#js_btn_preview_next',function(){
                if((_this.view_id+1)>=$('.js_select.active').length){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'已到最后一篇'});
                    return false;
                }
                _this.view_id++;
                var id = $('.js_select.active:eq('+_this.view_id+')').attr('data-val');
                _this._getView(showinfoUrl,{id:id});
            });

            //预览翻上页
            $('#js_layer_div').on('click','#js_btn_preview_prev',function(){
                if(_this.view_id<=0){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'已到第一篇'});
                    return false;
                }
                _this.view_id--;
                var id = $('.js_select.active:eq('+_this.view_id+')').attr('data-val');
                _this._getView(showinfoUrl,{id:id});
            });

            //消息撤回
            $('.js_revoke').on('click',function(){
                var id = $(this).parents('.sectionnot_list_c').find('.js_select').attr('val');
                var op = $(this).text();
                _this._delTask(id,revokeUrl,op);
            });

            //点击推送
            $('.js_push_btn').on('click',function(){
                var id = $(this).parents('.sectionnot_list_c').find('.js_select').attr('val');
                _this._delTask(id,pushUrl,'推送');
            });
		},

        //预览活动 isAdd有值时表示在add页面预览，否则在列表页预览
        _getView:function(url,obj,isAdd){
            var _this = this;
            $.get(url,obj,function(re){
                if(re.status==0){
                    var wHeight = $(window).height();
                    layer.close(_this.layer_div);
                    $('#js_layer_div').html('<div id="js_inside_div" style="float:left;"></div>');
                    var oDiv = $('#js_inside_div');
                    oDiv.html(re.tpl);
                    if(isAdd){
                        $('#js_show_img').attr('src',$('#title_pic').attr('src'));
                        $('#js_show_title').text(isAdd.title);
                        $('#js_show_city').find('ee').text($('#js_push_set_city').val());
                        $('#js_show_cate').find('ee').text($('#js_push_set_category').val());
                        $('#js_show_job').find('ee').text($('#js_push_set_job').val());
                        var pushtime = $('#push_time').val()?$('#push_time').val():_this._getNowFormatDate();
                        $('#js_show_btime').find('ee').text(pushtime);
                        $('.js_e_lt').text(isAdd.regtime_lt);
                        $('.js_e_gt').text(isAdd.regtime_gt);
                        if(isAdd.regtime_lt===''){
                            $('.js_ee_lt').hide();
                        }
                        if(isAdd.regtime_gt===''){
                            $('.js_ee_gt').hide();
                        }
                        if(isAdd.content){
                        	// 预览激活音频文件
                            var $content=$(isAdd.content);
                			$content.find('img[audio]').each(function(){
                				var src=$(this).attr('audio');
                				var $audio=$("<audio src='"+src+"' controls></audio>");
                				$(this).after($audio).remove();
                			});
                            $content.find('img[video]').each(function(){
                                var src=$(this).attr('video');
                                var $video=$("<video src='"+src+"' controls>Do not support video tag!</video>");
                                $(this).after($video).remove();
                            });
                            $('#js_show_con').html($content);
                        }
                    }
                    setTimeout(function(){
                        var oHeight = oDiv.height();
                        var oWidth = oDiv.find('.js_review_box').width();
                        if(oHeight>wHeight){

                            var offsetHeight = '0px';
                            var scrollHeight = wHeight;
                        }else{  
                                            
                            var offsetHeight = parseInt((wHeight-oHeight)/2)+'px';
                            var scrollHeight = oHeight;
                        }
                        oDiv.mCustomScrollbar({
                                        theme:"dark", //主题颜色
                                        set_height:scrollHeight,
                                        autoHideScrollbar: false, //是否自动隐藏滚动条
                                        scrollInertia :0,//滚动延迟
                                        horizontalScroll : false//水平滚动条
                                    });
                        _this.layer_div = $.layer({
                            type: 1,
                            title: false,
                            area: [oWidth+'px',oHeight+'px'],
                            offset: [offsetHeight, ''],
                            bgcolor: '#ccc',
                            border: [0, 0.3, '#ccc'], 
                            shade: [0.2, '#000'], 
                            closeBtn:false,
                            page:{dom:oDiv},
                            shadeClose:true,
                        });
                    },100);
                }
            });
        },

        //获取当前时间
        _getNowFormatDate:function() {
            var date = new Date();
            var seperator1 = "-";
            var seperator2 = ":";
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                    + " " + date.getHours() + seperator2 + date.getMinutes();
            return currentdate;
        },

        //新增活动
        add:function(){
            var _this = this;
            _this._closeCommon();
            if(show_id){
                _this.sle_id = show_id;
            }
            _this._getXList(getShowUrl);


            //点击选择资讯
            $('#js_div_show').on('click',function(){
                _this.getLayerList(getShowUrl,{});
                
            });

            
            //点击X号删除资讯
            $('#js_show_list').on('click','.js_show_title e',function(){
                var id = $(this).parents('.js_show_title').attr('data_val');
                _this.sle_id = '';
                _this._showListDel(id);
            });

            //勾选资讯
            $('#layer_div').on('click','.js_select_code',function(){
                //当前未勾选时
                var id = $(this).attr('val');
                var title = $(this).parents('.waiflist_list_c').find('.js_title').attr('title');
                if(!$(this).hasClass('active')){
                    $('#layer_div .js_select_code').removeClass('active');
                    $(this).addClass('active');
                    $('.js_add_list_sub').one('click',function(){
                        _this.sle_id = id;
                        _this._showListAdd(id,title);
                    });
                    
                }else{//已勾选的取消
                    $(this).removeClass('active');
                    $('.js_add_list_sub').one('click',function(){
                        _this.sle_id = '';
                        _this._showListDel(id);
                    });
                    
                }
            });
            //选择活动类型下拉框
            $('.addactive_right').on('click',function(){
                $('.js_sel_ul').toggle();
            });

            //选择推送规则确定
            $('.js_sub_choose').on('click',function(){
                $('.js_rules').hide();
                $('.js_div_choose input[type=checkbox]').each(function(){
                    if($(this).is(':checked')){
                        var name = $(this).attr('choosename');
                        $('.'+name).show();
                    }
                });
                $('.js_div_choose').hide();
            });

            //取消选择推送规则
            $('.js_cancel_choose').on('click',function(){
                $('.js_div_choose').hide();
            });

            //点击选择推送规则
            $('#js_btn_choose').on('click',function(){
                $('.js_div_choose').show();
            });
            //点击选择活动类型
            $('.js_sel_ul li').on('click',function(){
                var val = $(this).attr('val');
                var text = $(this).text();
                $('#js_input_type').val(text).attr('val',val);
                if(val==2){
                    $('.js_title').hide();
                    $('.js_show').show();
                }else{
                    $('.js_title').show();
                    $('.js_show').hide();
                }
            });

            //上传标题图片
            $('#uploadImgField1').off('change').on('change',function(){
                //var fileNameHid = $(this).attr('hid');
                _this._uploadAddPageFile('uploadImgField1','title');

            });

            //提交保存
            $('#js_adddata').on('click',function(){
                
                _this._showOrPost(2);
            });

            //预览
            $('#js_review_now').on('click',function(){
                _this._showOrPost(1);
            });

            //点击预览框关闭
            $('#js_layer_div').on('click','.js_btn_channel_cancel',function(){
                layer.close(_this.layer_div);
            });

            //下拉菜单隐藏、显示
            $('.js_div_select').on('click',function(){
                $(this).find('.js_cate_list').toggle();
            });

            //点击选项
            $('ul.js_cate_list li').on('click',function(){
                var text = $(this).text();
                var val = $(this).attr('val');
                $(this).parents('.js_div_select').find('input').val(text).attr('val',val);
            });
        },
        //预览或提交
        _showOrPost:function(op){
            var _this = this;
            var title = $('#js_title').val();
            var title_pic = $('#uploadImgField1').attr('val');
            var content = ue.getContent();
            var aid = $('input[name=aid]').val();
            aid = aid?aid:'';
            if(!title){
                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请填写标题'});
                return false;
            }
            if(!title_pic&&!aid){
                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'标题图片不能为空'});
                return false;
            }
            //return false;
            if(!content){
                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'正文不能为空'});
                return false;
            }
            var reg = /^\d*$/;
            var isCheck = $('#js_push_set_inform').is(':checked')?1:2;
            var push_time = $('input[name=push_time]').val();
            var ifforeach = $('input[name=ifforeach]').is(':checked')?1:2;
            var region = $('#js_push_set_region_code').val();
            region = ($('.js_push_area').is(':visible')&&region)?region:'';
            var industry = $('#js_push_set_category_code').val();
            industry = ($('.js_push_industry').is(':visible')&&industry)?industry:'';
            var job = $('#js_push_set_job_code').val();
            job = ($('.js_push_job').is(':visible')&&job)?job:'';
            var group = $('input[name=group]:checked').val();
            group = ($('.js_push_groups').is(':visible')&&group)?group:0;
            var regtime_lt = $('input[name=regtime_lt]').val();
            regtime_lt = ($('.js_push_regtime').is(':visible')&&regtime_lt)?regtime_lt:'';
            var regtime_gt = $('input[name=regtime_gt]').val();
            regtime_gt = ($('.js_push_regtime').is(':visible')&&regtime_gt)?regtime_gt:'';
            if((regtime_gt&&!reg.test(regtime_gt))||(regtime_lt&&!reg.test(regtime_lt))){
                $.global_msg.init({gType:'alert',icon:2,time:3,msg:'注册时间为整数数字'});
                return false;
            }
            if((regtime_gt&&regtime_lt)&&((regtime_gt-regtime_lt)>0)){
                $.global_msg.init({gType:'alert',icon:2,time:3,msg:'注册时间大小不 符合逻辑'});
                return false;
            }
            var aid = $('input[name=aid]').val();
            aid = aid?aid:'';
            var author = $('#js_author').val();
            var url = $('#js_url').val();
            url = $('#isTurn').is(':checked')?url:'';
            if(url){
                var reg = /^(https?|ftp|file):\/\/[\-A-Za-z0-9\+&@#\/%\?=~_|!:,\.;]+[\-A-Za-z0-9\+&@#\/%=~_|]$/;
                if(!reg.test(url)){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'请填写合法的外部跳转链接'});
                    return false;
                }
            }
            var oJson = {title:title,title_pic:title_pic,content:content,isCheck:isCheck,region:region,industry:industry,job:job,regtime_gt:regtime_gt,regtime_lt:regtime_lt,push_time:push_time,ifforeach:ifforeach,aid:aid,author:author,url:url,group:group};
            if(op==2){
                if(_this.postState==false){
                    return false;
                }
                if(!region&&!industry&&!job&&!regtime_gt&&!regtime_lt){
                    $.global_msg.init({gType:'confirm',icon:2,msg:'当前操作会给所有注册用户推送消息，请确认是否推送',btns:true,close:true,title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                            _this.postState = false;
                            $.post(addActivityPostUrl,oJson,function(re){
                                _this.postState = true;
                                if(re.status==0){
                                    $.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                        if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                            window.opener.closeWindow(window, true);
                                        }
                                    }});
                                }else{
                                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                                    return false;
                                }
                            }); 
                        }
                    });
                }else{
                    _this.postState = false;
                    $.post(addActivityPostUrl,oJson,function(re){
                        _this.postState = true;
                        if(re.status==0){
                            $.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                    window.opener.closeWindow(window, true);
                                }
                            }});
                        }else{
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                            return false;
                        }
                    }); 
                }
            }else if(op==1){
                var id = $('input[name=id]').val();
                var obj = {id:id,isone:'1'};
                _this._getView(showinfoUrl,obj,{title:title,content:content,regtime_lt:regtime_lt,regtime_gt:regtime_gt,author:author});
            }

        },

		//兑换码列表页
		numcodelist:function(){
			var _this = this;
			_this.common();   

            //关闭弹框
            $('#js_layer_div').on('click','.js_logoutcancel,.js_add_cancel',function(){
            	layer.close(_this.layer_div);
            });

            //导出
            $('#js_export').on('click',function(){
                if($('.js_select.active').length){
                    var obj = _this._getSelectId();
                    if(obj.candel===false){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:'生成中的兑换码不能导出'});
                        return false;
                    }
                    if($('.js_select.active').length>1){
                        var num = 0;
                        $('.js_select.active').each(function(){
                            var tnum = $(this).parents('.sectionnot_list_c').find('.js_group_num').text();
                            num+=parseInt(tnum);
                        });
                        if(num>100000){
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:'数据量过大，请单独导出'});
                            return false;
                        }
                    }
                    var str = exportUrl+'/id/'+obj.str;
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定要导出吗，可能需要一定时间，请耐心等待',btns:true,close:true,title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                           _this._export(str); 
                        }
                    });
                    //$.global_msg.init({gType:'alert',icon:1,time:3,msg:'正在导出，请耐心等待'});
                    
                }else{
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'请选择后导出'});
                    return false;
                }
            });

            //追加
            $('.js_append').on('click',function(){
                var val = $(this).parents('.sectionnot_list_c').find('.js_select').attr('val');
                var name = $(this).parents('.sectionnot_list_c').find('.js_group_name').text();
                var oDiv = $('#js_layer_div');
                oDiv.find('input[name=groupname]').val(name);
                oDiv.find('input[name=groupid]').val(val);
                _this.layer_div = $.layer({
                            type: 1,
                            title: false,
                            area: ['440px','400px'],
                            offset: ['', ''],
                            bgcolor: '#ccc',
                            border: [0, 0.3, '#ccc'], 
                            shade: [0.2, '#000'], 
                            closeBtn:false,
                            page:{dom:oDiv},
                            shadeClose:true,
                        });
            });

            //追加保存
            $('.js_add_sub').on('click',function(){
                var id = $('input[name=groupid]').val();
                var num = parseInt($('input[name=append_num]').val());
                if(!num){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请填写追加数量'});
                    return false;
                }
                if(num>100000){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'每次追加不得超过100000'});
                    return false;
                }
                $.post(appendUrl,{id:id,num:num},function(re){
                    if(re.status===0){
                        $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                window.location.reload();
                            }});
                    }else{
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                    }
                });
            });
		},

        addredeem:function(){
            var _this = this;
            _this.common();
            _this._closeCommon();
            //点击input前的复选框
            $('#js_layer_div').on('click','.input_checkbox',function(){
                var bool = $(this).prop('checked');
                $(this).parents('.label_codelist').find('.input_text').attr('readonly',!bool);
                if(!bool){
                    $(this).parents('.label_codelist').find('.input_text').val('');
                }
            });

            //生成兑换码提交
            $('#js_layer_div').on('click','.js_add_sub',function(){
                var num = $('input[name=num]').val();
                var len = $('input[name=len]').val();
                var stock = $('input[name=stock]').val();
                var starttime = $('input[name=start_time_code]').val();
                var endtime = $('input[name=end_time_code]').val();
                if(!num||!starttime||!endtime){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'数量、兑换有效期不能为空'});
                    return false;
                }
                var booldata = _this._judgeDate(starttime,endtime);
                if(!booldata){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'开始日期不能大于结束日期'});
                    return false;
                }
                if(!(len||stock)){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'兑换时长、兑换存量至少填写一个'});
                    return false;
                }
                $.ajax({
                    type:'post',
                    dataType:'json',
                    timeout:20000,
                    url:add_post_url,
                    data:{num:num,len:len,stock:stock,starttime:starttime,endtime:endtime},
                    success:function(re){
                        if(re.status===0){
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                    if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                        window.opener.closeWindow(window, true);
                                    }
                                }});
                        }else{
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                        }
                    }
                });
/*                $.post(add_post_url,{num:num,len:len,stock:stock,starttime:starttime,endtime:endtime},function(re){
                    
                });*/
            });
        },

		//消费列表
		usedlist:function(){
			var _this = this;
            $('.js_invalid').on('click',function(){
                var $this = $(this);
                $.global_msg.init({gType:'confirm',icon:2,msg:'是否作废该兑换码',btns:true,close:true,title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                        var redeemcode = $this.parents('.redeemcode_uselist').attr('val');
                        $.post(invalidUrl,{redeemcode:redeemcode},function(re){
                            if(re.status==0){
                                $.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                    window.location.reload();
                                }});
                            }else{
                                $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                                return false;
                            }
                        });
                    }
                });
                
            });
			_this.common();
		},

		//任务列表页
		tasklist:function(){
			var _this = this;
			_this.common();

            //任务要求
			$('.js_task_info').on('click',function(){
                var id = $(this).parents('.sectionnot_list_c').find('.js_select').attr('val');
                $.get(taskinfoUrl,{id:id},function(re){
                    if(re.status==0){
                        var oDiv = $('#js_layer_div');
                        oDiv.html(re.tpl);
                        _this.layer_div = $.layer({
                            type: 1,
                            title: false,
                            area: ['440px','400px'],
                            offset: ['', ''],
                            bgcolor: '#ccc',
                            border: [0, 0.3, '#ccc'], 
                            shade: [0.2, '#000'], 
                            closeBtn:false,
                            page:{dom:oDiv},
                            shadeClose:true,
                        });
                    }
                });
            });

            //关闭任务要求
            $('#js_layer_div').on('click','.js_logoutcancel',function(){
                layer.close(_this.layer_div);
            });
			

		},

		//删除、推送、撤回操作
		_delTask:function(str,url,op){
			$.global_msg.init({gType:'confirm',icon:2,msg:'确定要'+op+'吗',btns:true,close:true,title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                	$.post(url,{str:str},function(re){
						if(re.status==0){
                            $.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                window.location.reload();
                            }});
                        }else{
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                            return false;
                        }
					})
                }
            });
		},	

        //达标用户
        finishtaskuser:function(){
            var _this = this;
            _this.common();
        },

        _getXList:function(url){
            //点击搜索   
            var _this = this;
            //搜索种类下拉切换
            $('#layer_div').on('click','.waif_name',function(){
                $(this).find('.select_items').toggle();
            });

            //关闭资讯,兑换码列表
            $('#layer_div').on('click','.js_add_list_cancel,.js_add_list_sub',function(){
                layer.close(_this.layer_div);
            });


            //搜索种类下拉选择
            $('#layer_div').on('click','.select_items li',function(){
                var val = $(this).attr('val');
                var text = $(this).text();
                //$('#js_type_value').attr('val',val).attr('title',text).val(text);
                $(this).closest('.waif_name').find('.js_select_value').attr('val',val).attr('title',text).val(text);
            });
            //搜索
            $('#layer_div').on('click','.butinput',function(){
                var k = $('#layer_div .textinput').val();
                var newsState = $('#js_state_value').attr('val');// 新闻类型
                if($('#js_type_value').length){
                    t = $('#js_type_value').attr('val');
                    obj = {k:k,t:t, state:newsState};
                }else{
                    obj = {k:k, state:newsState}
                }
                _this.getLayerList(url,obj);
            });

            //点击翻页
            $('#layer_div').on('click','a[href]',function(e){
                var href=$(this).attr('href');
                //阻止a标签跳转，使用ajax
                _this.getLayerList(href,{});
                return false;
            });

            //兑换码列表输入页数跳转
            $('#layer_div').on('click','form input[type=submit]',function(){
                var p = $(this).prev().val();
                if(p){
                    var url = $(this).parents('form').attr('action');
                    _this.getLayerList(url,{p:p});
                }
                return false;
            });


            
        },
        _showidPop:function(str){
            var _this = this;
            var newArr = [];
            $.each(_this.showid,function(k,v){
                if(v!=str){
                    newArr.push(v);
                }
            })
            _this.showid = newArr;
        },

        //添加资讯
        _showListAdd:function(id,title){
            var html = '<span title="'+title+'" data_val="'+id+'" class="addactive_show_title js_show_title"><em>'+title+'</em><e>X</e></span>';
            $('#js_show_list').html(html);
        },
        //清空资讯列表
        _showListDel:function(id){
            $('#js_show_list').html('');
        },
		//新增任务
		addtask:function(){
			var _this = this;
            _this._closeCommon();
            _this.sle_id = groupid;
            _this._getXList(getCodeListUrl);
			//点击选择兑换码
			$('#codelist').on('click',function(){
				_this.getLayerList(getCodeListUrl,{});
				
			});

            //勾选选择兑换码组
            $('#layer_div').on('click','.js_select_code',function(){
                //当前未勾选时
                if(!$(this).hasClass('active')){
                    $('#layer_div .js_select_code').removeClass('active');
                    $(this).addClass('active');
                    var name = $(this).parents('.waiflist_list_c').find('.js_name').attr('title');
                    //this.sle_id用来保存选中的合作商的ID
                    _this.sle_id = $(this).attr('val');
                    $('#codelist').val(name);
                }else{//已勾选的取消
                    $(this).removeClass('active');
                    _this.sle_id = '';
                    $('#codelist').val('');
                }
            });
			

            //新增提交
            $('#js_push_set_confirm').on('click',function(){
            	var starttime = $('input[name=begintime]').val();
            	var endtime = $('input[name=endtime]').val();
            	if(!starttime||!endtime){
            		$.global_msg.init({gType:'alert',icon:2,time:3,msg:'请选择日期'});
                    return false;
            	}
                var booldata = _this._judgeDate(starttime,endtime);
                if(!booldata){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'开始日期不能大于结束日期'});
                    return false;
                }
            	if(!_this.sle_id){
            		$.global_msg.init({gType:'alert',icon:2,time:3,msg:'请选择兑换码组'});
                    return false;
            	}
            	var arr_person =[], arr_code = [];
                var p = 0,c=0;
                var bool = true;
            	$('.addtask_add').each(function(k,v){
            		var person_num = parseInt($(this).find('.js_person_num').val());
            		var code_num = parseInt($(this).find('.js_code_num').val());
                    if(person_num>p){
                        p = person_num;
                    }else{
                        var this_row = $(this).find('ee:eq(0)').text();
                        var pre_row = $('.addtask_add:eq('+(k-1)+')').find('ee:eq(0)').text();
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:'成功人数要求'+this_row+'必须大于成功人数要求'+pre_row});
                        bool = false;
                        return false;
                    }
                    if(code_num>c){
                        c = code_num;
                    }else{
                        var this_row = $(this).find('ee:eq(0)').text();
                        var pre_row = $('.addtask_add:eq('+(k-1)+')').find('ee:eq(0)').text();
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:'兑换码数量'+this_row+'必须大于兑换码数量'+pre_row});
                        bool = false;
                        return false;
                    }
            		if(person_num&&code_num){
            			arr_person.push(person_num);
            			arr_code.push(code_num);
            		}
            	});
                if(bool==false){
                    return false;
                }
            	if(!arr_person.length){
            		$.global_msg.init({gType:'alert',icon:2,time:3,msg:'请填写任务要求'});
                    return false;
            	}
            	var str_person = arr_person.join('_');
            	var str_code = arr_code.join('_');
                var id = $('input[name=id]').val();
            	$.post(addPostUrl,{uptime:starttime,downtime:endtime,gid:_this.sle_id,person:str_person,code:str_code,id:id},function(re){
            		if(re.status==0){
            			$.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                    window.opener.closeWindow(window, true);
                                }
                            }});
            		}else{
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                        return false;
                    }
            	})
            });
            //新增取消
            $('#js_push_set_cancel').on('click',function(){
            	window.history.back(-1);
            });

            //增加
            $('.js_add_jia').on('click',function(){
            	var oDiv = $('.addtask_add:last').clone();
                var num = oDiv.find('ee:eq(0)').text();
                num = parseInt(num)+1;
                oDiv.find('ee').text(num);
            	oDiv.find('.safariborder').removeClass('js_add_jia').addClass('js_add_jian').text('-');

            	oDiv.find('input').val('');
            	$('.addtask_button').before(oDiv);
            });

            //减少
            $(document).on('click','.js_add_jian',function(){
            	$(this).parents('.addtask_add').remove();
            });
		},

		//跳出选择兑换码,资讯弹框时，如已选择兑换码组，选中
		_setActive:function(){
            var _this = this;
            $('#layer_div .js_select_code').each(function(){
                if($(this).attr('val')==_this.sle_id){
                    $(this).addClass('active');
                }
            });
		},

        _export:function(url){
            if(typeof($('#iframe_id').attr('src')) == 'undefined'){
                //window.open(url);
                var iframeHtml = '<iframe id="iframe_id" style="display:none"></iframe>';//无刷新下载iframe
                $('body').append(iframeHtml);
            }   
            $("#iframe_id").attr('src',url);//替换iframe src值 完成下载
        },

		//新增弹框
		getLayerList:function(url,obj){
			var _this = this;
			$.get(url,obj,function(re){
				if(re.status==0){
                    layer.close(_this.layer_div);
					var oDiv = $('#layer_div');
					oDiv.html(re.tpl);
        			_this.layer_div = $.layer({
		                type: 1,
		                title: false,
		                area: ['440px','400px'],
		                offset: ['100px', ''],
		                bgcolor: '#ccc',
		                border: [0, 0.3, '#ccc'], 
		                shade: [0.2, '#000'], 
		                closeBtn:false,
		                page:{dom:oDiv},
		                shadeClose:true,
		            });
		            _this._setActive();
				}
			});
		},

		//搜索提交
		searchParam:function(){
			var condition='';
            var keyword = encodeURIComponent($('input[name=keyword]').val());
            var starttime = $('#js_begintime').val();
            var endtime = $('#js_endtime').val();
            var type = $('input[name=search_type]').attr('val'); 
            if($('input[name=status]').length){
            	var status = $('input[name=status]').attr('val');
            	condition += '/s/'+status;
            }
            condition += '/t/'+type;
            if(keyword != ''){
                condition +='/k/'+keyword;
            }
            if($('#js_search_task_id').length){
                var tid = $('#js_search_task_id').val();
                condition +='/tid/'+tid;
            }
            if($('#js_search_group_id').length){
                var gid = $('#js_search_group_id').val();
                condition +='/gid/'+gid;
            }
            if(starttime != ''){
                condition +='/starttime/'+starttime;
            }
            if(endtime != ''){
                condition +='/endtime/'+endtime;
            }
            if($('input[name=isSearchLength]').length){
                if($('input[name=isSearchLength]').is(':checked')){
                    condition +='/isSearchLength/'+1;
                }
            }
            if($('input[name=isSearchStock]').length){
                if($('input[name=isSearchStock]').is(':checked')){
                    condition +='/isSearchStock/'+1;
                }
            }
            return searchurl+condition;
		},

		//检测是否全选,如果是选中全选框，不是，取消全选框
		isSelectAll:function(){
			var bool = true;
			$('.js_select').each(function(){
				if(!$(this).hasClass('active')){
					bool = false;
					return false;
				}
			});
			if(bool){
				$('#js_allselect').addClass('active');
			}else{
				$('#js_allselect').removeClass('active');
			}
		},

        _uploadAddPageFile: function(fileNameHid,type){

            $.ajaxFileUpload({
                url : gUrlUploadFile,
                secureuri: false,
                fileElementId: fileNameHid,
                data:{fileNameHid:fileNameHid},
                dataType: 'json',
                success: function (rtn, status){
                    var imgUrl = rtn.data.absolutePath;
                    if(type == 'content'){
                        var imgUrl = rtn.data.absolutePath;
                        var allObj = $('#textarea_right ');
                        //var content = allObj.find('.js_content').html();
                        var content =  '<img src="'+imgUrl+'" /><br/>';
                        //将图片插入到光标显示位置
                        allObj.find('.js_content').focus();
                        insertHtmlAtCaret(content)

                    }else{
                        if(rtn.status==1){
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:rtn.info});
                            return false;
                        }else{
                            $('#title_pic').attr('src',imgUrl).attr('hasimage',true);
                            $('#uploadImgField1').attr('val',imgUrl);
                        }
                        //$('#title_pic').show();
                    }
                },
                error: function (data, status, e){
                }
            });
        },

        //获取选中的行的val值并连城字符串
        _getSelectId:function(){
            var arr = [];
            var candel = true;
            $('.js_select.active').each(function(){
                arr.push($(this).attr('val'));
                if($(this).attr('cantdel')=='true'){
                    candel = false;
                }
            });
            var str = arr.join('_');
            return {str:str,candel:candel};
        },

        _importError:function(str){
           $.global_msg.init({gType:'alert',icon:2,time:3,msg:str});
           return false;
        },

        //判断开始日期和结束日期
        _judgeDate:function(starttime,endtime){
            var time1 = new Date(starttime);
            var time2 = new Date(endtime);
            if(time1>time2){
                return false;
            }else{
                return true;
            }
        },

	},
});