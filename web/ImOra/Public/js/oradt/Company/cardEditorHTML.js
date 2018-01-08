$(function(){
	initData();
	render();
	adjustText();
	//GLOBAL_INTERVAL
	setInterval(function(){
		if (IS_STOP_INTERVAL){
			return;
		}
		//return;
		//----------------------大小屏幕适应START
		//文字wrap宽度设置
		$canvas.find('ortext').each(function(){
			var $p=$(this).parent();
			var tw=$(this).width();
			var pw=$p.width();
			
			if (pw!=tw && $(this).attr('adjust')){
				var float=$(this).css('float');
				if (float=='left'){
					$p.width(tw+(IS_DOUBLE_SIZE?40:20));
				}
				if (float=='none'){
					var npw=tw+(IS_DOUBLE_SIZE?40:20);
					$p.width(npw);
					if (npw<pw){
						var right=(pw-npw)/2;
						var pleft=parseFloat($p.css('left'));
						$p.css('left', pleft+right);
					} else {
						var right=parseFloat($(this).css('right'));
						var pleft=parseFloat($p.css('left'));
						$p.css('left', pleft-right);
						$(this).css('right', '0px');
					}
				}
				if (float=='right'){
					var npw=tw+(IS_DOUBLE_SIZE?40:20);
					$p.width(npw);
					if (npw!=pw){
						var right=(pw-npw);
						var pleft=parseFloat($p.css('left'));
						$p.css('left', pleft+right);
					}
				}
				$(this).removeAttr('adjust');
			}
		});
		
		//上传图片缩小
		if (!IS_DOUBLE_SIZE){
			$canvas.find('orimgwrap[scale]').each(function(){
				var $img=$(this).find('img:first');
				if ($img.width()>0 && $img.height()>0){
					var w=$img.width()/2;
					var h=$img.height()/2;
					$img.width(w);
					$img.height(h);
					$(this).removeAttr('scale');
				}
			});
		}
		//----------------------大小屏幕适应END
		
		//查找选中元素
		$active=$canvas.find('.active');
		$active.length==0 && ($active=null);
		if (!$active){
			$canvas.find('.corner, .side').hide();
			return;
		}
		
		if (IS_STOP_UPDATE) return;
		
		//字体颜色
		var type=$active.attr('type');
		if (type=='text'){
			var color=$('#colorLabel').val();
			var color2=rgbToHex($active.css('color'));
			if (color != color2){
				$active.css('color','#'+color);
			}
		}
		
		//设置图片大小，透明度，旋转
		if (type=='img' || type=='icon'){
			$active.find('.corner, .side').show();
			var $img=$active.find('.img');
			var w=$width.val();
			var h=$height.val();
			var o=parseInt($opacity.val())/100;
			var r=$rotation.val();
			
			if ($img.width()!=w){
				var _x=$img.width()-w;
				var ol=parseFloat($active.css('left'));
				$img.width(w);
				var l=ol+_x/2;
				
				//防止图片超出画板范围而找不到
				if (l<0){
					$active.css({left:0});
				} else if(l>$canvas.width()){
					$active.css({left:$canvas.width()-w});
				} else {
					$active.css({left:l});
				}
			}
			if ($img.height()!=h){
				var _y=$img.height()-h;
				var ot=parseFloat($active.css('top'));
				$img.height(h);
				var t=ot+_y/2;
				
				//防止图片超出画板范围而找不到
				if (t<0){
					$active.css({top:0});
				} else if(t>$canvas.height()){
					$active.css({top:$canvas.height()-h});
				} else {
					$active.css({top:t});
				}
			}
			
			if ($img.css('opacity')!=o) $img.css('opacity',o);
			if ($img.attr('rotation')!=r){
				setRotate($img.parent(),r);
			}
			
			//图标的话，还有个改变北京颜色
			if (type=='icon'){
				var c=$color.val();
				var b=$img.css('backgroundColor');
				if (b!=c && $color.is(':focus')){
					$img.css('backgroundColor', '#'+c);
				}
			}
		} else {
			$canvas.find('.corner, .side').hide();
		}
	},30);
	
	//collect data
	setInterval(function(){
		if (IS_STOP_INTERVAL){
			return;
		}
		$canvas.find('ortextwrap,orimgwrap,orbg').each(function(){
			var $this=$(this);
			var type=$this.attr('type');
			var _data={};
    		_data['ID'] = $this.attr('id');
    		data[DATA_KEY]['TEMP']['TEMPORI'] = ORIENTATION=='landscape' ? 0 : 1;
    		
    		if (type=='bg'){
    			data[DATA_KEY]['TEMP']['BGURL'] = $this.find('img').attr('src');
    			if (ORIENTATION=='landscape'){
    				data[DATA_KEY]['TEMP']['WIDTH'] = WIDTH;
        			data[DATA_KEY]['TEMP']['HEIGHT'] = HEIGHT;
    			} else {
    				data[DATA_KEY]['TEMP']['WIDTH'] = HEIGHT;
        			data[DATA_KEY]['TEMP']['HEIGHT'] = WIDTH;
    			}
    			
				data[DATA_KEY]['TEMP']['ALPHA'] = $this.is(':visible') ? 1 : 0;
    		}
			if (type=='text'){
				_data['ALIGN'] = $this.css('textAlign').toUpperCase();
				_data['WIDTH'] = $this.width()*(!IS_DOUBLE_SIZE?2:1);
				_data['HEIGHT'] = $this.height()*(!IS_DOUBLE_SIZE?2:1);
				_data['MINX'] = parseFloat($this.css('left'))*(!IS_DOUBLE_SIZE?2:1);
				_data['MINY'] = parseFloat($this.css('top'))*(!IS_DOUBLE_SIZE?2:1);
				_data['COLOR'] = '#'+rgbToHex($this.css('color'));
				_data['SIZE'] = parseInt($this.css('fontSize'))*(!IS_DOUBLE_SIZE?2:1);
				_data['BOLD'] = $this.css('fontWeight')=='700'?1:0;
				_data['UNDERLINE'] = $this.find('ortext').css('textDecoration')=='underline'?1:0;
				_data['ITALIC'] = $this.css('fontStyle')=='italic'?1:0;
				_data['ORDER'] = $this.css('zIndex');
				_data['FONT'] = $this.css('fontFamily');
				_data['VALUE']={};
				_data['VALUE']['FIELD'] = $this.attr('datatype');
				_data['VALUE']['LABEL'] = $this.attr('label');
				_data['VALUE']['VALUE'] = $this.attr('val');
				//_data['VALUE']['VISIBLE'] = $this.attr('isshowlabel')=='1'?1:0;
				_data['VALUE']['VISIBLE'] = 1;
				_data['LABEL'] = $this.attr('isshowlabel')=='1'?1:0;
				var selfdeftype=$this.attr('selfdeftype');
				if (selfdeftype){
					_data['VALUE']['SELFDEFTYPE'] = selfdeftype;
				}
				editData(_data, _data['ID'], 'TEXT');
			}
			if (type=='img' || type=='icon'){
				var $img=$this.find('.img');
    			_data['PHOTO'] = $img.attr('src');
    			_data['WIDTH'] = $img.width()*(!IS_DOUBLE_SIZE?2:1);
				_data['HEIGHT'] = $img.height()*(!IS_DOUBLE_SIZE?2:1);
				_data['MINX'] = parseFloat($this.css('left'))*(!IS_DOUBLE_SIZE?2:1);
				_data['MINY'] = parseFloat($this.css('top'))*(!IS_DOUBLE_SIZE?2:1);
				var rotate=$img.parent().attr('rotation');
				_data['ROTATE'] = !!rotate?rotate:0;
				_data['ORDER'] = $this.css('zIndex');
				_data['ALPHA'] = $img.css('opacity');
				_data['TYPE'] = type;
				if (type=='icon'){
					var c=$img.css('backgroundColor');
					if (c=='transparent' || c=='rgba(0, 0, 0, 0)'){
						_data['COLOR'] = 'transparent';
					} else {
						_data['COLOR'] = '#'+rgbToHex($img.css('backgroundColor'));
					}
				}
				editData(_data, _data['ID'], 'IMAGE');
			}
		});
	},1000);
	
	//画板
	$canvases.on('mousedown', function(evt){
		if (!$active) return;
		var offset=$(this).offset();
		
		//鼠标原始坐标
		var point={x:evt.pageX-offset.left,y:evt.pageY-offset.top};
		$active.data({'downPoint':point});
		
		//图片拖拽放大缩小START
		var $corner=$active.find('.corner');
		if ($corner.length>0 && $active.data('imgscale') && rectContainsPoint($corner, point, offset)){
			$(this).data('imgscale', true);
			
			var $img=$active.find('.img');
			$active.data({
				'orgSize':{width:$img.width(),height:$img.height()},
				'orgOffset':{top:parseFloat($active.css('top')),left:parseFloat($active.css('left'))}
			});
			IS_STOP_UPDATE=true;
			return;
		}
		
		//图片旋转START
		var $side=$active.find('.side');
		if ($side.length>0 && $active.data('imgrotate') && rectContainsPoint($side, point, offset)){
			$(this).data('imgrotate', true);
			var $img=$active.find('.img');
			$active.data({
				'orgRotate':$img.attr('rotation')
			});
			IS_STOP_UPDATE=true;
			return;
		}
		
		//元素移动START
		if (rectContainsPoint($active,point,offset)){
			$(this).data('move', true);
			$active.data({'orgOffset':{top:parseFloat($active.css('top')),left:parseFloat($active.css('left'))}});
			$canvases.css('opacity', 0.6).find('orbg').css('opacity', 0.6);
			$webcanvas.css('opacity', 1);
			return;
		}
	}).on('mousemove', function(evt){
		if (!$active) return;
		var offset=$(this).offset();
		
		//元素移动DOING
		if ($(this).data('move')){
			var downPoint=$active.data('downPoint');
			var _x=evt.pageX-downPoint.x-offset.left;
			var _y=evt.pageY-downPoint.y-offset.top;
			
			var orgOffset=$active.data('orgOffset');
			$active.css({top:orgOffset.top+_y,left:orgOffset.left+_x});
			align();
		}
		
		//图片拖拽放大缩小DOING
		if ($(this).data('imgscale')){
			var downPoint=$active.data('downPoint');
			var _x=evt.pageX-downPoint.x-offset.left;
			var _y=evt.pageY-downPoint.y-offset.top;
			
			var $img=$active.find('.img');
			var orgSize=$active.data('orgSize');
			var orgOffset=$active.data('orgOffset');
			
			var min=IS_DOUBLE_SIZE?20:10;
			var w=orgSize.width+_x*2;
			var h=orgSize.height+_y*2;
			
			if (w<min){
				w=min;
				_x=(w-orgSize.width)/2;
			}
			if (h<min){
				h=min;
				_y=(h-orgSize.height)/2;
			}
			$img.css({
				width:w,
				height:h
			});
			$active.css({
				top:orgOffset.top-_y+'px',
				left:orgOffset.left-_x+'px'
			});
			$width.val(w);
			$height.val(h);
		}
		
		//图片旋转DOING
		if ($(this).data('imgrotate')){
			var c=getPosition($active);
			var p={x:evt.pageX-offset.left,y:evt.pageY-offset.top};
			var r=parseInt(Math.atan2(p.y-c.y,p.x-c.x)/(Math.PI*2/360));
			setRotate($active.find('orimg'),r,true,true);
		}
		
	}).on('mouseup', function(evt){
		var b;//点击空白处，active消失
		
		//元素移动END
		if ($(this).data('move')){
			$(this).data('move', null);
			$active.data({
				'downPoint':null,
				'orgOffset':null
			});
			b=true;
			$canvases.css('opacity', 1).find('orbg').css('opacity', 1);
			$webcanvas.css('opacity', 0);
		}
		//图片拖拽放大缩小END
		if ($(this).data('imgscale')){
			$(this).data('imgscale', null);
			$active.data({
				'downPoint':null,
				'orgSize':null,
				'orgOffset':null,
				'imgscale':null
			});
			b=true;
		}
		//图片旋转END
		if ($(this).data('imgrotate')){
			$(this).data('imgrotate', null);
			$active.data({
				'imgrotate':null
			});
			b=true;
		}
		if (!b){
			removeActive();
		}
		IS_STOP_UPDATE=false;
	});
	
	//中文英文切换
	$('.cardpage_btn .yuanjiao_input').each(function(index){
		$(this).attr('index', index).on('click', function(){
			var num=$(this).attr('index')-'';
			if (num==0){
				$('#tab_1 .row:eq(1)').show().next().hide();
				$(this).addClass('on').next().removeClass('on');
			} else {
				$('#tab_1 .row:eq(2)').show().prev().hide();
				$(this).addClass('on').prev().removeClass('on');
			}
		});
	});
	
	//字体下拉
	$('.cardp_fonts span:first').on('click', function(evt){
		evt.stopPropagation();
		if (!$active) return;
		var fontName = $active.find('ortext').css('font-family');
		fontName = fontName.split(',')[0];
		var $li=$('#fontList li[val='+fontName+']');
		$li.length!=0 && $li.addClass('active');
		$('#fontList').toggle();
	});
	
	//点击字体列表
	$('#fontList li').on('click', function(){
		var fontName=$(this).attr('val');
		$active.css('font-family',fontName);
	});
	
	//字体列表的字体初始化
	fontListInit();
	
	//字号下拉
	$('.cardp_fonts_px span:first').on('click', function(evt){
		evt.stopPropagation();
		if (!$active || $active.find('ortext').length==0) return;
		var fontSize = parseInt($active.find('ortext').css('fontSize'))*(IS_DOUBLE_SIZE?1:2);
		var $li=$('#fontSizeList li[val='+fontSize+']');
		$li.addClass('active').siblings().removeClass('active');
		$('#fontSizeList').toggle().scrollTop($li.height()*(fontSize-11));
	});
	
	//点击字体大小
	$('#fontSizeList li').on('click', function(){
		var size=parseInt($(this).attr('val'))*(IS_DOUBLE_SIZE?1:0.5)+'px';
		$active.css({'fontSize':size,'lineHeight':size});
	});

	//字体下拉列表和字号下拉列表隐藏
	$(document).on('click', function(){
		$('#fontSizeList, #fontList').hide(),
		$('.cardpage_editor li.active').removeClass('active');
	});
	
	
	//元素
	$('#company_name, #name, #department, #job, #mobile, #telephone, #fax, #email, #web, #address, #name1, #department1, #job1, #mobile1, #telephone1, #fax1, #email1, #web1').on('click', function(){
		var field=$(this).attr('id');
		if ($canvas.find('ortextwrap[datatype="'+field+'"]').length!=0){
			var msg=$(this).find('span:first').html()+'已经存在';
			$.global_msg.init({gType:'warning', msg:msg, btns:true, icon:2});
			return;
		}
		var uuid=addLabel($(this).attr('val'), $(this).find('span:first').html(), 20, 'center', DEFAULT_FONT, $(this).attr('uuid'), field, $(this).find('input').is(':checked'), null, true);
		var w=$('#'+uuid).find('ortext').attr('adjust', true).width();
		$('#'+uuid).width(w+1);
		
	});
	
	//添加自定义标签
	$('#selfdef, #selfdef1').on('click', function(){
		selfdefWindowShow($(this).attr('lang'), 'add');
	});
	
	//自定义窗口-保存按钮
	$('#selfdef_window button:last').on('click', function(){
		var $w=$('#selfdef_window');
		var wtype=$w.attr('type');
		
		var val=$w.find(':text').val();
		!$.trim(val) && _hide();
		
		var visible=$w.find(':checkbox').is(':checked');
		var type=$w.find('select').val();
		var title=$w.find('select option:selected').html();
		
		if (wtype == 'add'){
			var uuid=addLabel(val, title, 20, 'center', DEFAULT_FONT, null, type, visible, 'selfdef-'+new Date().getTime());
			var w=$('#'+uuid).find('ortext').attr('adjust', true).width();
			$('#'+uuid).width(w+1);
		} else if(wtype == 'edit'){
			var $obj=$w.data('obj');
			if (visible){
				$obj.find('ortext').html(title+':'+val);
			} else {
				$obj.find('ortext').html(val);
			}
			$obj.attr({val:val,isShowLabel:visible?1:0,labelName:title,selfdeftype:type});
			
			//数据更新
			for(var i=0;i<data[DATA_KEY].TEXT;i++){
				if (data[DATA_KEY].TEXT[i].ID!=$obj.attr('id')){
					continue;
				}
				data[DATA_KEY].TEXT[i].VALUE.VALUE      =$obj.attr('val');
				data[DATA_KEY].TEXT[i].VALUE.VISIBLE    =$obj.attr('isShowLabel');
				data[DATA_KEY].TEXT[i].VALUE.LABEL      =$obj.attr('labelName');
				data[DATA_KEY].TEXT[i].VALUE.SELFDEFTYPE=$obj.attr('selfdeftype');
			}
		}
		_hide();
	});
	
	//自定义窗口-取消按钮
	$('#selfdef_window button:first').on('click', function(){
		_hide();
	});
	
	//自定义窗口隐藏方法
	function _hide(){
		$('#selfdef_window').modal('hide');  
		$('#selfdef_window').find(':text').val('');
	}
	
	//左对齐
	$('#left').on('click', function(){
		if (!$active) return;
		$active.css('textAlign','left').find('ortext').css('float', 'left');
		$(this).addClass('active').siblings().removeClass('active');
	});
	//居中
	$('#center').on('click', function(){
		if (!$active) return;
		$active.css('textAlign','center').find('ortext').css('float', 'none');
		$(this).addClass('active').siblings().removeClass('active');
	});
	//右对齐
	$('#right').on('click', function(){
		if (!$active) return;
		$active.css('textAlign','right').find('ortext').css('float', 'right');
		$(this).addClass('active').siblings().removeClass('active');
	});
	
	//加粗
	$('#bold').on('click', function(){
		if (!$active) return;
		if ($active.css('fontWeight')=='400'){
			$active.css('fontWeight','700');
			$(this).addClass('active');
		} else {
			$active.css('fontWeight','400');
			$(this).removeClass('active');
		}
	});
	//斜体
	$('#italic').on('click', function(){
		if (!$active) return;
		if ($active.css('fontStyle')=='normal'){
			$active.css('fontStyle','italic');
			$(this).addClass('active');
		} else {
			$active.css('fontStyle','normal');
			$(this).removeClass('active');
		}
	});
	//下划线
	$('#underline').on('click', function(){
		if (!$active) return;
		if ($active.find('ortext').css('textDecoration')=='none'){
			$active.find('ortext').css('textDecoration','underline');
			$(this).addClass('active');
		} else {
			$active.find('ortext').css('textDecoration','none');
			$(this).removeClass('active');
		}
	});
	
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法

	//切换TAB时，如果是图片OR素材，则要把图片编辑面板移动过来
	$('#tab_img, #tab_icon').on('click', function(){
		var id=$(this).attr('id');
		if (id == 'tab_img'){
			$('#tab_2').append($('#imageEditPanel'));
			$('#imageEditPanel').find('.cardp_bgcolor').hide();
		} else if (id == 'tab_icon'){
			$('#tab_4').append($('#imageEditPanel'));
			$('#imageEditPanel').find('.cardp_bgcolor').show();
		}
	});
	
	//拖动条
	$('.opacity_button').on('mousedown', function(evt){
		$(this).attr('drag', true);
	});
	$(document).on('mousemove', function(evt){
		var $obj=$('.opacity_button[drag]');
		if ($obj.length==0){
			return;
		}
		var org=$obj.prev().offset();
		var _x=evt.pageX - org.left;
		_x<=0 && (_x=0);
		_x>=240 && (_x=240);
		if ($obj.attr('type')=='opacity'){
			$obj.css('left', _x).next().val(Math.round(_x/240*100));
		}
		if ($obj.attr('type')=='rotate'){
			$obj.css('left', _x).next().val(Math.round(_x/240*360));
		}
	}).on('mouseup', function(){
		$('.opacity_button').removeAttr('drag');
	});
	
	//图片上传
	$('#imgFile').on('change', function(){
		$('#uploadBtn').html('上传中...');
		uploadImages($(this), function(url){
			setTimeout(function(){
				addImg(url,'img',null,true);
			}, 500);
			addImgUploadPanel(url);
			$('#uploadBtn').html('上传图片');
		});
	});
	
	//添加左侧图片添加按钮
	function addImgUploadPanel(url){
		var $img=$("<div class='cardpage_pic hand'><span style='text-align:center'><img height=168 src='"+url+"'></span><i class='cardp_d hand'></i></div>");
		$img.find('i').on('click', function(){
			var $this=$(this);
			$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
				delImg($this);
			}});
		});
		$img.find('img:first').on('click', function(){
			addImg($(this).attr('src'),'img',null,true);
		});
		$('.cardp_sc:first').after($img);
	}
	
	//点击已经上传图片，在画板添加图片
	$('#tab_2 .cardpage_pic img').on('click', function(){
		addImg($(this).attr('src'),'img',null,true);
	});
	
	//删除上传的图片
	$('#tab_2 .cardpage_pic i').on('click', function(){
		var $this=$(this);
		$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
			delImg($this);
		}});
	});
	
	/**
	 * 删除上传图片
	 * @param obj $obj 删除icon-X对象
	 */
	function delImg($obj){
		var $this=$obj;
		var src=$this.parent().find('img').attr('src');
		$canvases.find('orimgwrap').each(function(){
			if ($(this).find('img:first').attr('src')==src){
				$(this).remove();
			}
		});
		
		if (data.FRONT.IMAGE){
			for(var i=0;i<data.FRONT.IMAGE.length;i++){
				src.split('/').pop() == data.FRONT.IMAGE[i].PHOTO.split('/').pop() && data.FRONT.IMAGE.splice(i,1);
			}
		}
		if (data.BACK.IMAGE){
			for(var i=0;i<data.BACK.IMAGE.length;i++){
				src.split('/').pop() == data.BACK.IMAGE[i].PHOTO.split('/').pop() && data.BACK.IMAGE.splice(i,1);
			}
		}
		
		$this.parent().slideUp('normal','swing',function(){
			$(this).remove();
		});
	}
	/**
	 * 删除上传背景
	 * @param obj $obj 删除icon-X对象
	 */
	function delBg($obj){
		var $this=$obj;
		var src=$this.parent().find('img').attr('src');
		$canvases.find('orbg img').each(function(){
			if ($(this).attr('src')==src){
				$(this).parent().remove();
			}
		});
		if (data.FRONT.TEMP.BGURL.split('/').pop() == src.split('/').pop()){
			data.FRONT.TEMP.BGURL='';
		}
		if (data.BACK.TEMP.BGURL.split('/').pop() == src.split('/').pop()){
			data.BACK.TEMP.BGURL='';
		}
		
		$this.parent().slideUp('normal','swing',function(){
			$(this).remove();
		});
	}
	
	//判断背景是否显示，设置checkbox
	function isBgShow(){
		if (data[DATA_KEY] && data[DATA_KEY].TEMP){
			$('#bgVisible').prop('checked', data[DATA_KEY].TEMP.ALPHA==1)
		}
	}

	//背景是否显示
	$('#bgVisible').on('change', function(){
		var $bg=$canvas.find('orbg');
		if ($bg){
			$(this).is(':checked') ? $bg.show() : $bg.hide();
		}
	});
	isBgShow();
	
	//在画板切换背景
	$('#tab_3 .cardpage_pic img').on('click', function(){
		addBg($(this).attr('src'), null, true);
	});
	
	//删除上传的背景
	$('#tab_3 .cardpage_pic i').on('click', function(){
		var $this=$(this);
		$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
			delBg($this);
		}});
	});
	
	//背景上传
	$('#bgFile').on('change', function(){
		$('#uploadBtn2').html('上传中...');
		uploadImages($(this), function(url){
			setTimeout(function(){
				addBg(url, null, true);
			}, 500);
			$bgVisible.prop('checked', true);
			addBgUploadPanel(url);
			$('#uploadBtn2').html('上传背景');
		});
	});
	
	//添加左侧背景面板
	function addBgUploadPanel(url){
		var $img=$("<div class='cardpage_pic hand'><span style='text-align:center'><img height=168 src='"+url+"'></span><i class='cardp_d hand'></i></div>");
		$img.find('i').on('click', function(){
			var $this=$(this);
			$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
				delBg($this);
			}});
		});
		$img.find('img:first').on('click', function(){
			addBg($(this).attr('src'),null,true);
		});
		$('.cardp_sc:last').after($img);
	}
	
	//图标
	$('#tab_4 img[type="icon"]').on('click', function(){
		addImg($(this).attr('s'), 'icon',null,true);
	});
	
	//透明图片背景为透明
	$('#transparent').on('click', function(){
		if (!$active){
			return;
		}
		$active.find('.img').css('backgroundColor', 'transparent');
		$color.val('');
		$colorStyle.css('backgroundColor', 'transparent');
	});
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法
	//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法
	
	//横版竖版切换
	$('#landscape').on('click', function(){
		ORIENTATION = 'landscape';
		orientationChange();
		$(this).addClass('bgcolor');
		$('#portrait').removeClass('bgcolor');
	});
	$('#portrait').on('click', function(){
		ORIENTATION = 'portrait';
		orientationChange();
		$(this).addClass('bgcolor');
		$('#landscape').removeClass('bgcolor');
	});
	
	//正面切换
	$('#front').on('click', function(){
		if ('FRONT' == DATA_KEY || $(this).attr('disabled')) return;
		$canvases.removeClass('flip');
		DATA_KEY = 'FRONT';
		isBgShow();
		$canvas=$canvases.eq(0);
		removeActive();
		$('#tab_1 .row:gt(0) input:checkbox').removeAttr('uuid').iCheck('uncheck');
		setTimeout(function(){
			render();
			adjustText();
			$('#front, #back').removeAttr('disabled');
			$('#front').addClass('bgcolor');
			$('#back').removeClass('bgcolor');
		},300);
	});
	
	//反面切换
	$('#back').on('click', function(){
		if ('BACK' == DATA_KEY || $(this).attr('disabled')) return;
		$canvases.addClass('flip');
		DATA_KEY = 'BACK';
		isBgShow();
		$canvas=$canvases.eq(1);
		removeActive();
		$('#tab_1 .row:gt(0) input:checkbox').removeAttr('uuid').iCheck('uncheck');
		setTimeout(function(){
			render();
			adjustText();
			$('#front, #back').removeAttr('disabled');
			$('#back').addClass('bgcolor');
			$('#front').removeClass('bgcolor');
		},300);
	});
	
	/**
	 * 上移下移
	 * @param bool b(上移true, 下移false)
	 */
	function updown(b){
		if (!$active) return;
		var zindex=parseInt($active.css('zIndex'));
		if (b){
			zindex++;
		} else {
			zindex--;
		}
		if (zindex == 0) zindex = 1;
		
		$tip.removeClass('showing');
		$active.css('zIndex', zindex);
		
		var top=$active.offset().top;
		if (parseFloat($active.css('top'))<5){
			top=$active.offset().top+$active.height()-20;
		}
		
		var left=$active.offset().left+$active.width()+10;
		if (parseFloat($active.css('left'))+$active.width()>$canvas.width()){
			left=$active.offset().left-20;
		}
		
		if(window.browser.type=="IE" && window.browser.version=='9'){
			//ie9不支持css3动画，所以单独处理
			$tip.css({top:top,left:left,opacity:1,'fontSize':IS_DOUBLE_SIZE?40:20}).html(zindex);
			clearTimeout($tip.timeout);
			$tip.timeout = setTimeout(function(){
				$tip.css('opacity', 0);
			},1000);
		} else {
			//提示
			setTimeout(function(){
				$tip.css({top:top,left:left}).html(zindex).addClass('showing');
			}, 80);
		}
	}
	
	//上移
	$('#up').on('click', function(){
		updown(true);
	}).on('mousedown', function(){
		$(this).addClass('bgcolor');
	}).on('mouseup', function(){
		$(this).removeClass('bgcolor');
	});
	
	//下移
	$('#down').on('click', function(){
		updown(false);
	}).on('mousedown', function(){
		$(this).addClass('bgcolor');
	}).on('mouseup', function(){
		$(this).removeClass('bgcolor');
	});
	
	//确认删除按钮
	$('#del').on('click', function(){
		//$active && $('#confirm_window').modal('show');
		if (!$active) return;
		$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
			if (data[DATA_KEY].TEXT){
				for(var i=0;i<data[DATA_KEY].TEXT.length;i++){
					data[DATA_KEY].TEXT[i].ID == $active.attr('id') && data[DATA_KEY].TEXT.splice(i,1);
				}
			}
			if (data[DATA_KEY].IMAGE){
				for(var i=0;i<data[DATA_KEY].IMAGE.length;i++){
					data[DATA_KEY].IMAGE[i].ID == $active.attr('id') && data[DATA_KEY].IMAGE.splice(i,1);
				}
			}
			$active.remove();
		}});
	}).on('mousedown', function(){
		$(this).addClass('bgred');
	}).on('mouseup', function(){
		$(this).removeClass('bgred');
	});
	
	//确定删除按钮
	$('#itemDelete').on('click', function(){
		if ($active){
			if (data[DATA_KEY].TEXT){
				for(var i=0;i<data[DATA_KEY].TEXT.length;i++){
					data[DATA_KEY].TEXT[i].ID == $active.attr('id') && data[DATA_KEY].TEXT.splice(i,1);
				}
			}
			if (data[DATA_KEY].IMAGE){
				for(var i=0;i<data[DATA_KEY].IMAGE.length;i++){
					data[DATA_KEY].IMAGE[i].ID == $active.attr('id') && data[DATA_KEY].IMAGE.splice(i,1);
				}
			}
			$active.remove();
			$('#confirm_window').modal('hide');
		}
	});
	
	//预览
	$('#preview').on('click', function(){
		$(this).button('loading');
		$.ajax({
            'type':'post',
            'async':true,
            'url':URL_CARD_CAPTURE,
            'data':{data:data,cardId:cardId},
            'success':function(rst){
            	if (!rst){
    				return;
    			}
    			rst=$.parseJSON(rst);
    			_canvasImages['FRONT'] = rst.FRONT;
    			_canvasImages['BACK'] = rst.BACK;
    			$('#previewImg1').attr('src', _canvasImages['FRONT']);
    			$('#previewImg2').attr('src', _canvasImages['BACK']);
    			$('#preview_window').modal('show');
    			$('#preview').button('reset');
    		}
        });
	});
	
	//保存图片
	$('#submit').on('click', function(){
		$(this).button('loading');
		removeActive();
		$.ajax({
            'type':'post',
            'async':true,
            'url':URL_SAVEIMG,
            'data':{data:data,textData:getTextData(),cardId:cardId,sysid:SYSID,systype:SYSTYPE},
            'success':function(rst){
            	$('#submit').button('reset');
            	rst=$.parseJSON(rst);
            	if (rst.status==0){
            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:1});
            		setTimeout(function(){
	            		location.href=URL_CARD_LIST;
	            	}, 2000);
            	} else {
            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:0});
            	}
    		}
        });
	});
	
	//选择系统模板-切换方案事件
	$('#template_window .way_btn span').on('click', function(){
		var urla=$(this).attr('urla');
		if (urla){
			$(this).parent().siblings('.way_card').find('img:first').attr('src', urla);
			$(this).addClass('active').siblings().removeClass('active');
			$(this).parent().siblings('.card_btn').attr('type', $(this).attr('type'));
		}
	});
	
	//选择选择模板-显示弹框
	$('.cardpage_xzmb').on('click', function(){
		$('#template_window').modal('show');
		sysTemplateLoad($('#template_window'), 1, true);
	});
	
	//选择选择模板-鼠标滚动加载更多
	$('#template_window').bind('mousewheel', function(evt,delta){
		var a=this.scrollTop+$(window).height();
		var $dialog=$(this).find('.modal-dialog');
		var b=$dialog.height()+parseFloat($dialog.css('marginTop'))+parseFloat($dialog.css('marginBottom'));
		if (a>=b && delta<0){
			//加载
			sysTemplateLoad($(this));
		}
	});
	
	/**
	 * 加载系统模板
	 * @param jquery-obj $tplWin 系统模板窗口对象
	 * @param str p 页码（加载更多时候不传）
	 * @param str ori (landscape横版，portrait竖版)
	 * @param bool isClear 是否清空原来数据
	 */
	function sysTemplateLoad($tplWin, p, isClear){
		if ($tplWin.data('dataloading')){
			return;
		}
		$tplWin.data('dataloading', true);
		var sort=$('.label_left .text_color').attr('sort');
		var ori='';
		var $ori=$('.label_left input:checked');
		if ($ori.length==1){
			ori=$ori.attr('ori');
		}
		if (isClear){
			$tplWin.find('.way_top:gt(0)').remove();
		}
		
		$('#sysloading').show();
		var count=$tplWin.find('.way_left').length-2;
		var url=p?URL_SYSTEMP_LIST:URL_SYSTEMP_LOAD;
		
		$.get(url,{count:count, p:p, sort:sort, ori:ori},function(rst){
			rst=$.parseJSON(rst);
			if (rst.status==0){
				if (p){
					$('.label_right page:last').html(Math.ceil(parseInt(rst.data.numfound)/PAGESIZE));
				}
				if (rst.data.templates.length==0){
					$('#sysloading').hide();
					//$tplWin.data('dataloading', false);
					return;
				}
				var $obj=$tplWin.find('.way_top:first').clone(true).show();
				$obj.find('.way_left').each(function(n){
					var data=rst.data.templates[n];
					$(this).find('.card_btn').attr('sysid', data['tempid']);
					$(this).find('.way_btn span:gt('+(data.types.length-1)+')').hide();
					for(var i=0;i<data.types.length;i++){
						$(this).find('.way_btn span:eq('+i+')').attr('urla', data.types[i]);
					}
					$(this).find('img:first').attr('src', data.types[0]);
					if (data.tempori==1){
						var $img=$(this).find('.card_style').addClass('card_left')
							.removeClass('card_style').find('img');
						var $cardLeft=$(this).find('.card_left');
						var h=$cardLeft.width();
						var w=$cardLeft.height();
						$img.height(h);
						$img.width(w);
						$img.css({top:(w-h)/2+'px', left:-w/4+8+'px'});
						$img.addClass('img_rotate90');
					}
					
					$(this).fadeIn();
					if (rst.data.templates.length==1) return false;
				});
				$('#sysloading').hide().before($obj);
				$tplWin.data('dataloading', false);
			}
		});
	}
	//选择选择模板-人气最高,最新方案
	$('.label_left b').on('click', function(){
		$(this).addClass('text_color').siblings().removeClass('text_color');
		$('#template_window').data('dataloading', false);
		sysTemplateLoad($('#template_window'), 1, true);
	});
	//选择选择模板-横版,竖版
	$('.label_left input:checked').on('change', function(){
		$('#template_window').data('dataloading', false);
		sysTemplateLoad($('#template_window'), 1, true);
	});
	
	//选择选择模板-上一页
	$('.label_right span:first').on('click', function(){
		var p=parseInt($.trim($('.label_right page:first').html()))-1;
		if (p==0){
			return;
		}
		$('#template_window').data('dataloading', false);
		sysTemplateLoad($('#template_window'), p, true);
		$('.label_right page:first').html(p);
	});
	//下一页
	$('.label_right span:last').on('click', function(){
		var p=parseInt($.trim($('.label_right page:first').html()))+1;
		if (p>parseInt($.trim($('.label_right page:last').html()))){
			return;
		}
		$('#template_window').data('dataloading', false);
		sysTemplateLoad($('#template_window'), p, true);
		$('.label_right page:first').html(p);
	});
	
	//选择选择模板-【背景】菜单里【方案】点击事件
	//不替换文字布局信息
	$('.cardpage_f_a .col-md-6').on('click', function(){
		var type=$(this).attr('type');
		$(this).parent().find('.active').removeClass('active');
		$(this).find('b').addClass('active');
		
		//面板图片路径换掉
		$canvases.find('orbg,orimgwrap').each(function(){
			var $img=$(this).find('img:first')
			var file=$img.attr('src').split('/').pop();
			for(var i=0;i<REPLACABLE_IMAGES.length;i++){
				if (file==REPLACABLE_IMAGES[i]){
					$img.attr('src', SYSTPL_BASEURL+type+'/'+file);
				}
			}
		});
		
		//数据也要换掉
		data.FRONT.TEMP.BGURL = replaceTypeInUrl(data.FRONT.TEMP.BGURL, type);
		data.BACK.TEMP.BGURL  = replaceTypeInUrl(data.BACK.TEMP.BGURL, type);
		for(var i=0;i<data.FRONT.IMAGE.length;i++){
			data.FRONT.IMAGE[i].PHOTO = replaceTypeInUrl(data.FRONT.IMAGE[i].PHOTO, type);
		}
		for(var i=0;i<data.BACK.IMAGE.length;i++){
			data.BACK.IMAGE[i].PHOTO = replaceTypeInUrl(data.BACK.IMAGE[i].PHOTO, type);
		}
		
		//还有左侧面板（图片，背景）
		$('.cardpage_pic img').each(function(){
			var src=$(this).attr('src');
			$(this).attr('src', replaceTypeInUrl(src, type));
		});
		
		SYSTYPE=type;
	});
	
	function replaceTypeInUrl(url, type){
		return url.replace('/'+SYSTYPE+'/', '/'+type+'/');
	}
	
	//选择选择模板-点击【选择】按钮
	$('#template_window .card_btn').on('click', function(){
		var $this=$(this);
		var sysid=$(this).attr('sysid');
		var type=$(this).attr('type');
		//获取正反面vcard(经过处理，比如图片路径加type，field翻译，true false改为1 0，正反面合并)
		$.ajax({
            'type':'post',
            'async':true,
            'url':URL_GET_SYSTPLDATA,
            'data':{sysid:sysid,type:type},
            'dataType':'json',
            'success':function(rst){
            	if (rst.status==0){
            		SYSTPL_BASEURL=rst.typeurl.replace('/type/', '/Images/');
            		SYSID=sysid;
            		SYSTYPE=type;
            		
            		//【背景】编辑栏的【方案】
            		var typeCount=$this.siblings('.way_btn').find('span:visible').length;
            		$('.cardpage_f_a div').hide();
            		for(var i=1;i<=typeCount;i++){
            			$('.cardpage_f_a img:eq('+(i-1)+')').attr('src', rst.typeurl+i+'.png');
            			$('.cardpage_f_a div:eq('+(i-1)+')').show();
            		}
            		
            		//渲染
            		IS_STOP_INTERVAL=true;
            		$canvases.find('ortextwrap,orbg,orimgwrap').remove();
            		data=rst.data;
            		//给text.value.value添加默认值
            		for(var i=0;i<data.FRONT.TEXT.length;i++){
            			var $obj=$('#'+data.FRONT.TEXT[i].VALUE.FIELD);
            			data.FRONT.TEXT[i].VALUE.VALUE = $obj.attr('val');
            		}
            		for(var i=0;i<data.BACK.TEXT.length;i++){
            			var $obj=$('#'+data.BACK.TEXT[i].VALUE.FIELD);
            			data.BACK.TEXT[i].VALUE.VALUE = $obj.attr('val');
            		}
            		
            		REPLACABLE_IMAGES=[];
            		var bgList=[];
            		//左侧背景添加面板
            		if (!!data.FRONT.TEMP.BGURL){
            			REPLACABLE_IMAGES.push(data.FRONT.TEMP.BGURL);
            		}
            		if (!!data.BACK.TEMP.BGURL){
            			REPLACABLE_IMAGES.push(data.BACK.TEMP.BGURL);
            		}
            		REPLACABLE_IMAGES = REPLACABLE_IMAGES.unique();
            		for(var i=0;i<REPLACABLE_IMAGES.length;i++){
            			addBgUploadPanel(REPLACABLE_IMAGES[i]);
            			REPLACABLE_IMAGES[i] = REPLACABLE_IMAGES[i].split('/').pop();
            		}
            		
            		//左侧图片添加面板
            		var imgList=[];
            		for(var i=0;i<data.FRONT.IMAGE.length;i++){
            			imgList.push(data.FRONT.IMAGE[i].PHOTO);
            		}
            		for(var i=0;i<data.BACK.IMAGE.length;i++){
            			imgList.push(data.BACK.IMAGE[i].PHOTO);
            		}
            		
            		imgList = imgList.unique();
            		
            		for(var i=0;i<imgList.length;i++){
            			addImgUploadPanel(imgList[i]);
            			imgList[i] = imgList[i].split('/').pop();
            		}
            		REPLACABLE_IMAGES = REPLACABLE_IMAGES.concat(imgList);
            		
            		render();
            		adjustText();
            		
            		//如果是竖版
            		if (data.FRONT.TEMP.TEMPORI==1){
            			$('#portrait').click();
            		} else {
            			$('#landscape').click();
            		}
            		IS_STOP_INTERVAL=false;
            		
            		$('#template_window').modal('hide');
            		
            		//当前方案选中状态
            		$('.cardpage_f_a .active').removeClass('active');
            		$('.cardpage_f_a b:eq('+(SYSTYPE-''-1)+')').addClass('active');
            		$('#tab_bg').click();
            	} 
    		}
        });
	});
	
	
	//modal弹框回调方法, 设置content-wrapper高度防止出现2个滚动条
	$('#selfdef_window, #confirm_window, #preview_window, #template_window').on('show.bs.modal', function(){
		$('.content-wrapper').height(1);
	}).on('hide.bs.modal', function(){
		$('.content-wrapper').height('auto');
	});
	
	//IE禁止选中文字
	$(document).bind('selectstart', function(){
		return false;
	});
	
	//面片内容项checkbox样式以及点击事件
	$('#tab_1 .row:gt(0) input:checkbox').iCheck({
		handle: 'checkbox',
    	checkboxClass: 'icheckbox_minimal-blue'
    }).on('ifClicked', function(){
    	var $this=$(this);
    	setTimeout(function(){
    		toggleLabelPrefix($this);
    	},100);
    });
	
	//显示标签全选
	$('#checkall').iCheck({
		handle: 'checkbox',
    	checkboxClass: 'icheckbox_minimal-blue'
    }).on('ifClicked', function(){
    	var $this=$(this);
    	setTimeout(function(){
    		var $objs=$('#tab_1 .row:visible:last input:checkbox');
    		var b=$this.prop('checked');
    		$objs.each(function(){
    			if (b){
    				if ($(this).prop('checked')==true){
    					return;
    				}
    				$(this).iCheck('check');
    				toggleLabelPrefix($(this));
    			} else {
    				if ($(this).prop('checked')==false){
    					return;
    				}
    				$(this).iCheck('uncheck');
    				toggleLabelPrefix($(this));
    			}
    		});
    	},100);
    });
	
	//自定义窗口checkbox样式
	$('#selfdef_window input:checkbox').iCheck({
		handle: 'checkbox',
    	checkboxClass: 'icheckbox_minimal-blue'
    });
});
