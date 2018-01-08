$.extend({
	hotelaccesscard:{
        unitListExist:0,//发卡单位列表是否存在标记
        bssidList:[],
		bssid:function(){
			var _this = this;
			//搜索
			$('#js_search').on('click',function(){
                window.location.href = _this._searchParam();
            }); 


            //关闭弹框
            $('#js_add_cancel').on('click',function(){
            	$('#js_add_edit_div').hide();
                $('.js_div_list').find('ul').hide();
                $('.js_masklayer').hide();//遮罩层
            });

            //删除
            $('.js_del').on('click',function(){
            	var id = $(this).attr('data-id');
            	$.global_msg.init({gType:'confirm',icon:2,msg:'确定要删除此条记录吗?',btns:true,close:true,title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
	                	$.post(delUrl,{id:id},function(re){
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
            });

			//添加
            $('#js_add').on('click',function(){
            	_this._dealTip({});
            });

            //编辑
            $('.js_edit').on('click',function(){
            	var id = $(this).attr('data-id');
            	_this._dealTip({id:id});
            });

            //下拉菜单
            $('.js_div_list').on('click',function(e){
                if(!$(e.target).closest('.mCSB_scrollTools').length){
                    $(this).find('ul').toggle();
                }
            });

            //选择li
            $('.js_div_list').on('click','li',function(){
                var text = $(this).text();
                var id = $(this).attr('data-val');
                $(this).parents('.js_div_list').find('input').val(text).attr('data-val',id);
                if($(this).closest('#js_ul_unit').length==1){ 
                    _this._getHotelList(id);
                    $('#js_deal_hotelname').val('').attr('data-val','');
                }
            });

            //添加bssid
            $('#js_add_edit_div').on('click','.js_inc',function(){
                var parents = $(this).parents('.js_bssid_ssid');
                var clone = parents.clone();
                clone.attr('data-val','');
                clone.find('input').val('');
                parents.after(clone);
            });

            //删除bssid
            $('#js_add_edit_div').on('click','.js_dec',function(){
                if($('.js_bssid_ssid').length>1){
                    $(this).parents('.js_bssid_ssid').remove();
                }

            });

            //确定提交
            $('#js_add_confirm').on('click',function(){
                var oSub = $(this);
                var canSub = oSub.attr('data-val');
                if(canSub==0){
                    return false;
                }
                
                var addList = [], editList = [], delList = [], idList = [],arr = [], msg = '';
                var unitid = $('#js_deal_unitname').attr('data-val');
                if(!unitid){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'发卡单位不能为空'});
                    return false;
                }
                var hotelid = $('#js_deal_hotelname').attr('data-val');
                if(!hotelid){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:'酒店不能为空'});
                    return false;
                }
                $('.js_bssid_ssid').each(function(){
                    var id = $(this).attr('data-val');
                    var bssid = $.trim($(this).find('.js_deal_bssid').val());
                    var ssid = $.trim($(this).find('.js_deal_ssid').val());
                    var obj = {bssid:bssid,ssid:ssid};
                    if(!bssid){
                        msg = 'bssid不能为空';
                        return false;
                    }
                    if(!ssid){
                        msg = 'ssid不能为空';
                        return false;
                    }
                    if($.inArray(bssid,arr)==-1){
                        if(id){
                            obj.id = id;
                            idList.push(id);
                            editList.push(obj);
                        }else{
                            addList.push(obj);
                        }
                        arr.push(bssid);
                    }else{
                        msg = 'bssid名称重复:'+bssid;
                        return false;
                    }
                });
                if(msg){
                    $.global_msg.init({gType:'alert',icon:2,time:3,msg:msg});
                    return false;
                }else{
                    delList = _this._getDelList(_this.bssidList,idList);
                    var data = {add:addList,edit:editList,del:delList};
                    data = JSON.stringify(data);
                    $(this).attr('data-val',0);
                    $.post(addBssidPostUrl,{unitid:unitid,hotelid:hotelid,data:data},function(re){
                        oSub.attr('data-val',1);
                        if(re.status==0){
                            $.global_msg.init({gType:'alert',icon:1,time:1,msg:re.msg,endFn:function(){
                                //return false;
                                window.location.reload();
                            }});
                        }else{
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:re.msg});
                            return false;
                        }
                    });
                }
            });
		},




		//添加编辑处理
		_dealTip:function(obj){
            var _this = this;
            obj.unitListExist = _this.unitListExist;
            _this.bssidList = [];
			$.get(addUrl,obj,function(re){
        		if(re.status==0){
        			_this._setDataToTip(re.data);
                    if(!_this.unitListExist){
    				    _this._setUnitHtml(re.unitList);
                    }
                    $('#js_add_edit_div').show();
                    $('.js_masklayer').show();//遮罩层
        		}
        	})
		},

        //处理弹框数据
        _setDataToTip:function(data){
            //console.log(data);return false;
            _this = this;
            var id = data[0]?data[0].id:'';
            var unitid = data[0]?data[0].unitid:'';
            var unitname = data[0]?data[0].unitname:'';
            var hotelid = data[0]?data[0].hotelid:'';
            var hotelname = data[0]?data[0].hotelname:'';
            var oDiv = $('#js_add_edit_div');
            oDiv.find('#js_deal_unitname').val(unitname).attr('data-val',unitid);
            oDiv.find('#js_deal_hotelname').val(hotelname).attr('data-val',hotelid);
            if(unitid){
                _this._getHotelList(unitid);
            }
            oDiv.find('.js_bssid_ssid:gt(0)').remove();
            oDiv.find('.js_bssid_ssid').attr('data-val','');
            oDiv.find('.js_bssid_ssid input').val('');
            if(data.length){
                var oClone = oDiv.find('.js_bssid_ssid').clone();
                oDiv.find('.js_bssid_ssid').remove();
                $.each(data,function(k,v){
                    var divClone = oClone.clone();
                    _this.bssidList.push(v.id);
                    divClone.attr('data-val',v.id);
                    divClone.find('.js_deal_bssid').val(v.bssid);
                    divClone.find('.js_deal_ssid').val(v.ssid);
                    $('#js_div_btn').before(divClone);
                });
            }
/*            if(oDiv.find('.js_bssid_ssid').length>1){
                oDiv.find('.js_bssid_ssid:gt(0)').remove();
            }
            oDiv.find('.js_deal_bssid').val(data.bssid);
            oDiv.find('.js_deal_ssid').val(data.ssid);*/
        },

        //根据发卡单位ID获取下属酒店信息
        _getHotelList:function(unitid){
            var _this = this;
            $.get(getHotelListUrl,{unitid:unitid},function(re){
                if(re.status==0){
                    _this._setHotelHtml(re.hotelList);
                }
            });
        },


		_setUnitHtml:function(list){
            var _this = this;
            var str = '';
            $.each(list,function(k,v){
                str+='<li data-val="'+v.id+'">'+v.lssuername+'</li>';
            });
            $('#js_ul_unit').html(str);
            if(list.length>8){    
                $('#js_ul_unit').mCustomScrollbar({
                    theme:"dark", //主题颜色
                    set_height:230,
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia :0,//滚动延迟
                    horizontalScroll : false,//水平滚动条
                });
            }
            _this.unitListExist = 1;
		},

		_setHotelHtml:function(list){
            var str = '';
            $.each(list,function(k,v){
                str+='<li data-val="'+v.id+'">'+v.name+'</li>';
            });
            $('#js_ul_hotel').html(str);
		},

        //根据两个数组计算要删除的bssid的数组
        _getDelList:function(arr1,arr2){
            var arr = [];
            $.each(arr1,function(k,v){
                if($.inArray(v,arr2)==-1){
                    arr.push(v);
                }
            });
            return arr;
        },
		
		//搜索提交
		_searchParam:function(){
			var condition='';
            var hotelname = encodeURIComponent($('input[name=hotelname]').val());
            var unitname = encodeURIComponent($('input[name=unitname]').val());
            var bssid = $('input[name=bssid]').val();
            var starttime = $('#js_begintime').val();
            var endtime = $('#js_endtime').val();
  			if(hotelname != ''){
                condition +='/hotelname/'+hotelname;
            }
            if(unitname != ''){
                condition +='/unitname/'+unitname;
            }
            if(bssid != ''){
                condition +='/bssid/'+bssid;
            }
            if(starttime != ''){
                condition +='/starttime/'+starttime;
            }
            if(endtime != ''){
                condition +='/endtime/'+endtime;
            }

            return searchurl+condition;
		},
	}
});
