$(function(){
	$.extend({
		network:{
			//ajax获取任务数据
			exportData:null,
	   		platform:null,
	   		sle_type:null,
	   		ajaxTAb:function(type){
	   			_this = this;
	   			$.post(postTabUrl,{type:type},function(result){
	   				if(result.status==0){
	   					$('#start_time').val(result.data.start_time);
	   					$('#end_time').val(result.data.end_time);
	   					$.dataTimeLoad.init({statistic:result.data.statisticType,idArr: [{start:'start_time',end:'end_time'}]});
	   					_this.setPost();
	   				}
	   			});
	   		},
			setPost:function(){
				var oJson = this.getPostJson();
				this.postJson(oJson);
			},
			//获取 要提交的字段JSON
			getPostJson:function(){
				var platform = $('input[name=platform]').attr('val');
				var sle_type = $('input[name=sle_type]').attr('val');
				var start_time = $('input[name=start_time]').val();
				var end_time = $('input[name=end_time]').val();
				if(!start_time){
					$('#start_time').focus();//开始时间
					return false;
				}
				if(!end_time){
					$('#end_time').focus();//开始时间
					return false;
				}
				var type = $('input[name=type]').val();
				//根据对比时间段的DIV是否隐藏，判断所需提交的数据，组成数据对象

				var oJson = {platform:platform,sle_type:sle_type,start_time:start_time,end_time:end_time,type:type};
				return oJson;
			},
			//提交数据对象
			postJson:function(oJson){
				var _this = this;
				$.post(postUrl,oJson,function(result){
					// alert(result);return false;
					if(result.status==0){
						if(result.charts_display){
							$('#userStatisticsBar').show();
						}else{
							$('#userStatisticsBar').hide();
						}
						_this.setEchart(result.data,result.isPropor);
						var exportDataArr = JSON.parse(result.exportData);
						if(exportDataArr.length){
							$('#export').show();
						}else{
							$('#export').hide();
						}
						_this.platform = oJson.platform;
						_this.sle_type = oJson.sle_type;
						_this.exportData = result.exportData;//导出的数据
						//页面下方的table表格，如果条数过多，增加滚动
						$('.Data_c_content_1').html('<div class="scroll_div"></div>');
						$('.Data_c_content_1 .scroll_div').html(result.tpl);
						if($('.Data_c_content_1 .scroll_div .content_list').height()>500){	
							$('.Data_c_content_1 .scroll_div .content_list').mCustomScrollbar({
					            theme:"dark", //主题颜色
					            set_height:500,
					            autoHideScrollbar: false, //是否自动隐藏滚动条
					            scrollInertia :0,//滚动延迟
					            horizontalScroll : false,//水平滚动条
					        });
						}
					}
				});
			},
			//post提交并跳转
			StandardPost:function(url,args){
		        var body = $(document.body),
		            form = $("<form style='display:none;' method='post'></form>"),
		            input;
		        form.attr({"action":url});
		        $.each(args,function(key,value){
		            input = $("<input type='hidden'>");
		            input.attr({"name":key});
		            input.val(value);
		            form.append(input);
		        });

		        form.appendTo(document.body);
		        form.submit();
		        document.body.removeChild(form[0]);
		    },
			//根据数据作图
	 		setEchart:function(data,isPropor){
				list = JSON.parse(data);
				var date,max=0,avg=0,arr=[];
				for (k in list) {
					date = list[k].date;
					var obj = {};
					obj.name = k;
					obj.type = 'line';
					obj.data = list[k].num;
					for(j in list[k].num){
						max = Math.max(max,list[k].num[j]);
					}
					arr.push(obj);
				};
				avg = Math.ceil(max/5);
        		max = avg*6;
				var text = $('input[name=sle_type]').val();
				$('.left_s').text(text);
				var option = {
					title : {
				        text: text+'/时间',
				        textStyle : { color:'#333',fontSize:14,fontWeight:100}
				    },
				    legend: {
				       // data:titleList//['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
				    },
				    tooltip : {
				        trigger: 'axis'
				    },
				    grid: {
				        left: '3%',
				        right: '4%',
				        bottom: '3%',
				        containLabel: true
				    },
				    xAxis : [
				        {
				            type : 'category',
				            boundaryGap : false,
				            data : date,
				            axisLabel : {
					            textStyle : {
						            color : '#999'
					            }
				            },
				            axisLine: {
				                lineStyle: {
				                    // 使用深浅的间隔色
				                    color: '#999',
				                    width: 1
				                }
				            },
				            splitLine: {
				            	show:true,
				                lineStyle: {
				                    // 使用深浅的间隔色
				                    color: ['#ddd'],
				                    type : 'dashed'
				                }
				            }
				        }
				    ],
				    yAxis : [
				        {
				            type : 'value',
				            max : max,
		                    splitNumber: 6,
		                    interval: avg,
				            splitLine: {
				            	show:true,
				                lineStyle: {
				                    // 使用深浅的间隔色
				                    color: ['#ddd'],
				                    type : 'dashed'
				                }
				            }
				        }
				    ],
				    series : arr,
				    color:colorlist,
				}
				if(isPropor){
					option.yAxis[0].axisLabel={formatter:'{value} %'};
				}
				myChart = echarts.init(document.getElementById('userStatisticsBar'));
				myChart.setOption(option);
			},

		}
	});
	//日期插件

   	/*$.dataTimeLoad.init({idArr: [{start:'start_time',end:'end_time'},{start:'js_constarttime',end:'js_conendtime'}]});
   	
   	//页面加载进来 ，提交默认数据
	$.network.setPost();*/
	var type = $('input[name=type]').val(),
		statisticType;
	if(type=='day'){
		statisticType='d';
	}
	if(type=='month'){
		statisticType='m';
	}
	if(type=='week'){
		statisticType='w';
	}
	$.dataTimeLoad.init({statistic:statisticType,idArr: [{start:'start_time',end:'end_time'}]});
	$.network.setPost();
	//下拉菜单切换
	$('.select_xinzeng,.select_IOS').on('click',function(){
		$(this).find('ul').toggle();
	});


	//选择平台
	$('.select_IOS ul li').on('click',function(){
		var val = $(this).attr('val');
		var value = $(this).text();
		var oInput = $(this).parent('ul').parent().find('input');
		oInput.val(value);
		oInput.attr('val',val);
		$.network.setPost();
	});
	//选择查询种类
	$('.select_xinzeng ul li').on('click',function(){
		var val = $(this).attr('val');
		var oInput = $('.select_xinzeng').find('input[name=sle_type]');
		var currentVal = oInput.attr('val');
		if(val!=currentVal){
			if($(this).attr('ahref')){
				var oJson = $.network.getPostJson();
				$.network.StandardPost($(this).attr('ahref'),oJson);
				// window.location.href = $(this).attr('ahref');
			}else{
				oInput.attr('val',val);
				oInput.val($(this).text());
				_this.setPost();
			}
		}
	});

	//开始统计
	$('#statistics').on('click',function(){
		$.network.setPost();
	});

	//点击其他地方，下拉框隐藏
	$(document).on('click',function(e){
		var e = e||window.event;
		var ev = e.srcElement||e.target;
		$('.select_xinzeng,.select_IOS').each(function(){
			var state = $(ev).closest($(this)).length;
			if(!state){
				$(this).find('ul').hide();
			}
		});
	});

	//点击切换日周月
	$('.js_stat_date_type a').on('click',function(){
		$('.js_stat_date_type a').removeClass('on');
		$(this).addClass('on');
		var val = $(this).attr('val');
		$('input[name=type]').val(val);
		$.network.ajaxTAb(val);
	});
	//导出数据
	$('#export').on('click',function(){
		var data = JSON.stringify($.network.exportData);
		var ex_platform = $.network.platform;
		var ex_sle_type = $.network.sle_type;
	    $('#exportForm input[name=data]').val(data);
	    $('#exportForm input[name=ex_platform]').val(ex_platform);
	    $('#exportForm input[name=ex_sle_type]').val(ex_sle_type);
	    $('#exportForm').submit();
	});
	//对比
	$('#js_contrast').on('click',function(){
		$('#js_time_duibi').toggle();
	});
	//点击对比时间段
	$('#js_contrast_time').on('click',function(){
		$.network.setPost();
	});
});