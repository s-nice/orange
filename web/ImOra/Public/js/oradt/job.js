$(function(){
	//表单
	var $f=$('.unlock_comment_pop form');
	//html编辑器
    var editor;
    KindEditor.ready(function(K) {
		editor = K.create('#content', {
			resizeType : null,
			pasteType : 1,
			minWidth: 515,
			items : [
				'source', '|', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'indent', 'outdent']
		});
	});
    
	//添加招聘
	$("#js_addjob").on('click',function(){
		show();
	});
	
	//显示添加弹层
	function show(){
		$('.appadmin_maskunlock').show();
		$('.unlock_comment_pop').show();
	}
	
	//招聘弹出层关闭
	$('.js_btn_channel_cancel').on('click',function(){
		$('.appadmin_maskunlock').hide();
		$('.unlock_comment_pop').hide();
		reset();
	});
	$('.unlock_comment_pop .js_coll_del').on('click',function(){
		$('.js_btn_channel_cancel').click();
	});
	
	//表单初始化
	function reset(){
		$f.find('input,textarea').val('');
		$f.find('input[name="lang"]').val(1);
		$('#lang').val($('#lang').attr('default'));
		editor.html('');
	}
	var it=setInterval(function(){
		if (editor){
			reset();
			clearInterval(it);
		}
	},100);
	
	
	// 日历插件
    $('#js_begintime').datetimepicker({format: "Y-m-d",lang:'ch',showWeak:true,timepicker:false,validateOnBlur:false,
        onSelectDate:function(){
            var starttime = $('#js_begintime').val();
            $('#js_endtime').datetimepicker({'minDate':starttime});
        }
    });
    $('#js_endtime').datetimepicker({format: "Y-m-d",lang:'ch',showWeak:true,formatDate:'Y-m-d',timepicker:false,validateOnBlur:false,
        onSelectDate:function(){
            var endtime = $('#js_endtime').val();
            $('#js_begintime').datetimepicker({'maxDate':endtime});
        }
    });
    
    //语言选择相关
    $('#lang').on('click',function(evt){//显示
    	evt.stopPropagation();
    	$('#lang_list').show();
    });
    $('#lang').next().on('click',function(){
    	$('#lang').click();
    });
    $(document).on('click',function(){//隐藏
    	$('#lang_list').hide();
    });
    $('#lang_list li').on('click',function(){//点击下拉菜单
    	$('#lang').val($(this).html());
    	$('#lang').next().val($(this).attr('val'));
    });
	
    //添加招聘操作
    $('.js_coll_publish_content').on('click',function(){
    	var p={
    		id:$f.find('input[name="id"]').val(),
    		title:$f.find('input[name="title"]').val(),
    		lang:$f.find('input[name="lang"]').val(),
    		startdate:$f.find('input[name="startTime"]').val(),
    		enddate:$f.find('input[name="endTime"]').val(),
    		sort:$f.find('input[name="sort"]').val(),
    		content:editor.html()
    	};
    	
    	//表单验证
    	if ($.trim(p.title)==''){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_title,icon:2});
    		return;
    	}
    	if ($.trim(p.startdate)=='' || $.trim(p.enddate)==''){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_date,icon:2});
    		return;
    	}
    	if ($.trim(p.startdate)>$.trim(p.enddate)){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_date_compare,icon:2});
    		return;
    	}
    	if ($.trim(p.sort)=='' || /[^0-9]/.test(p.sort)){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_sort,icon:2});
    		return;
    	}
    	if (parseInt($.trim(p.sort))>1000){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_sort,icon:2});
    		return;
    	}
    	if ($.trim(p.content)==''){
    		$.global_msg.init({gType:'warning',msg:str_job_verify_content,icon:2});
    		return;
    	}
    	
    	var url=url_doaddjob;
    	if (p.id){
    		url=url_doeditjob
    	}
    	
    	$.post(url,p,function(rst){
    		if (rst.status==0){
    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:1,endFn:function(){ location.reload();}});
    		} else {
    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:2});
    		}
    	});
    });
    
    //选择框
    $('.js_select').on('click',function(){
    	if ($(this).hasClass('active')){
    		$(this).removeClass('active');
    	} else {
    		$(this).addClass('active');
    	}
    });
    
    //删除招聘
    $('.jobdelete').on('click',function(){
    	var id=$(this).parent().parent().find('i:first').attr('val');
    	$.global_msg.init({gType:'confirm',icon:2,msg:str_job_confirm,btns:true,title:false,close:true,btn1:str_btn_cancel ,btn2:str_btn_ok,noFn:function(){
			$.post(url_deljob,{id:id},function(rst){
				if (rst.status==0){
	    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:1,endFn:function(){ location.reload();}});
	    		} else {
	    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:2});
	    		}
			});
		}});
    });
    
    //发布招聘
    $('#js_publishjob').on('click',function(){
    	publish(2);
    });
    
    //取消发布招聘
    $('#js_unpublishjob').on('click',function(){
    	publish(1);
    });
    
    //发布 OR 取消发布
    function publish(status){
    	if ($('.content_c .active').length==0){
    		$.global_msg.init({gType:'warning',msg:str_job_choose_data,icon:2});
    		return;
    	}
    	var ids=[];
    	$('.content_c .active').each(function(){
    		ids.push($(this).attr('val'));
    	});
    	
    	$.post(url_dopublish,{ids:ids,status:status},function(rst){
    		if (rst.status==0){
    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:1,endFn:function(){ location.reload();}});
    		} else {
    			$.global_msg.init({gType:'warning',msg:rst.msg,icon:2});
    		}
    	});
    }
    
    //修改
    $('.jobedit').on('click',function(){
    	var data={};
    	var top=$(this).parent().parent();
    	data.id=top.find('i:first').attr('val');
    	data.title=top.find('.span_span1').html();
    	data.startDate=top.find('.span_span2').html().substring(0,10);
    	data.endDate=top.find('.span_span2').html().substring(12);
    	data.sort=top.find('.span_span3').html();
    	data.lang=top.find('.span_span6').attr('val');
    	data.langName=top.find('.span_span6').html();
    	data.content=top.find('.span_span11').attr('content');

    	//console.dir(data);
    	//赋值
    	$f.find('input[name="id"]').val(data.id);
		$f.find('input[name="title"]').val(data.title);
		$f.find('input[name="lang"]').val(data.lang);
		$f.find('input[name="startTime"]').val(data.startDate);
		$f.find('input[name="endTime"]').val(data.endDate);
		$f.find('input[name="sort"]').val(data.sort);
		$('#lang').val(data.langName);
		editor.html((data.content));
    	
    	//显示
    	show();
    });
    
    //日期排序
    $('#sort_starttime').on('click',function(){
    	sort('start_date',$(this).find('em').attr('class'));
    });
    
    //序号排序
    $('#sort_sort').on('click',function(){
    	sort('sort',$(this).find('em').attr('class'));
    });
    
    function sort(key,className){
    	var type='asc';
    	if (className=='list_sort_asc'){
    		type='desc';
    	}
    	
    	location.href=url_base+'?key='+key+'&type='+type;
    }
});