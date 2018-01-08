/**
 * 绘制对齐线
 * @param type 绘制类型
 * @param $target 目标元素
 */
function drawLine(type,$target){
	var mx,my,tx,ty;
	webcanvasCtx.lineWidth = 3;
	webcanvasCtx.strokeStyle='#0ff';
	webcanvasCtx.beginPath();
	if (type=='top_top' || type=='center_top' || type=='bottom_top'){
		mx=0;
		my=parseFloat($target.css('top'));
		tx=$webcanvas.width();
		ty=my;
	}
	if (type=='bottom_bottom' || type=='center_bottom' || type=='top_bottom'){
		mx=0;
		my=parseFloat($target.css('top'))+$target.height()+2;
		tx=$webcanvas.width();
		ty=my;
	}
	if (type=='left_left' || type=='right_left' || type=='center_left'){
		mx=parseFloat($target.css('left'));
		my=0;
		tx=mx;
		ty=$webcanvas.height();
	}
	if (type=='right_right' || type=='center_right' || type=='left_right'){
		mx=parseFloat($target.css('left'))+$target.width()+2;
		my=0;
		tx=mx;
		ty=$webcanvas.height();
	}
	
	if (type=='left_center' || type=='right_center' || type=='center_center_x'){
		mx=parseFloat($target.css('left'))+$target.width()/2+1;
		my=0;
		tx=mx;
		ty=$webcanvas.height();
	}
	if (type=='top_center' || type=='bottom_center' || type=='center_center_y'){
		mx=0;
		my=parseFloat($target.css('top'))+$target.height()/2+1;
		tx=$webcanvas.width();
		ty=my;
	}
	
	//console.log("mx="+mx+",my="+my+",tx="+tx+",ty="+ty);
	webcanvasCtx.moveTo(mx,my);
	webcanvasCtx.lineTo(tx,ty);
	webcanvasCtx.closePath();
	webcanvasCtx.stroke();
}
/**
 * 根据拖动的元素，找到对齐点，并移动$active
 * @param bool isBgAlign 是否和背景图片进行对齐操作
 */
function align(isBgAlign){
	var aPoints=getPoints($active);
	webcanvasCtx.clearRect(0, 0, $webcanvas.width(), $webcanvas.height());
	$canvas.children().each(function(){
		var type=$(this).attr('type');
		var atype=$active.attr('type');
		
		if (isBgAlign){
			if ($(this).hasClass('active')){
				return true;
			}
		} else {
			if ($(this).hasClass('active') || type=='bg'){
				return true;
			}
		}
		
		var sPoints=getPoints($(this));
		var aAlign=atype=='text'?$active.css('textAlign'):false;
		var cAlign=type=='text'?$(this).css('textAlign'):false;
		
		var nearby=isPointNearby(aPoints, sPoints, aAlign, cAlign);
		if (!nearby){
			return true;
		}
		//console.log(nearby);
		moveObjTo(nearby, $(this), $active);
		drawLine(nearby, $(this));
	});
}
/**
 * 判断生成的对齐线类型
 * @param p1 $acitve元素的坐标
 * @param p2 其他元素的坐标
 * @param aAlign 如果aAlign不为false,则p1只判断该值
 * @param cAlign 如果cAlign不为false,则p2只判断该值
 * @returns str($active的那一边_目标元素的哪一边) or false
 */
function isPointNearby(p1,p2,aAlign,cAlign){
	var rst=false;
	var offset=3;
	if (Math.abs(p1.left-p2.left)<offset){
		if ((!aAlign || aAlign=='left') && (!cAlign || cAlign=='left')){
			!rst && (rst = 'left_left');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1.right-p2.right)<offset){
		if ((!aAlign || aAlign=='right') && (!cAlign || cAlign=='right')){
			!rst && (rst = 'right_right');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1.left-p2.right)<offset){
		if ((!aAlign || aAlign=='left') && (!cAlign || cAlign=='right')){
			!rst && (rst = 'left_right');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1.right-p2.left)<offset){
		if ((!aAlign || aAlign=='right') && (!cAlign || cAlign=='left')){
			!rst && (rst = 'right_left');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1.top-p2.top)<offset){
		!rst && (rst = 'top_top');
	}
	if (Math.abs(p1.bottom-p2.bottom)<offset){
		!rst && (rst = 'bottom_bottom');
	}
	if (Math.abs(p1.top-p2.bottom)<offset){
		!rst && (rst = 'top_bottom');
	}
	if (Math.abs(p1.bottom-p2.top)<offset){
		!rst && (rst = 'bottom_top');
	}
	
	var p1c={x:(p1.right-p1.left)/2+p1.left,y:(p1.bottom-p1.top)/2+p1.top};
	var p2c={x:(p2.right-p2.left)/2+p2.left,y:(p2.bottom-p2.top)/2+p2.top};
	
	if (Math.abs(p1c.x-p2.left)<offset){
		if ((!aAlign || aAlign=='center') && (!cAlign || cAlign=='left')){
			!rst && (rst = 'center_left');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1c.x-p2.right)<offset){
		if ((!aAlign || aAlign=='center') && (!cAlign || cAlign=='right')){
			!rst && (rst = 'center_right');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1c.y-p2.top)<offset){
		if (!aAlign || aAlign=='center'){
			!rst && (rst = 'center_top');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1c.y-p2.bottom)<offset){
		if (!aAlign || aAlign=='center'){
			!rst && (rst = 'center_bottom');
		} else {
			!rst && (rst = false);
		}
	}

	
	if (Math.abs(p2c.x-p1.left)<offset){
		if ((!aAlign || aAlign=='left') && (!cAlign || cAlign=='center')){
			!rst && (rst = 'left_center');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p2c.x-p1.right)<offset){
		if ((!aAlign || aAlign=='right') && (!cAlign || cAlign=='center')){
			!rst && (rst = 'right_center');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p2c.y-p1.top)<offset){
		if (!cAlign || cAlign=='center'){
			!rst && (rst = 'top_center');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p2c.y-p1.bottom)<offset){
		if (!cAlign || cAlign=='center'){
			!rst && (rst = 'bottom_center');
		} else {
			!rst && (rst = false);
		}
	}
	
	if (Math.abs(p1c.x-p2c.x)<offset){
		if ((!aAlign || aAlign=='center') && (!cAlign || cAlign=='center')){
			!rst && (rst = 'center_center_x');
		} else {
			!rst && (rst = false);
		}
	}
	if (Math.abs(p1c.y-p2c.y)<offset){
		if ((!aAlign || aAlign=='center') && (!cAlign || cAlign=='center')){
			!rst && (rst = 'center_center_y');
		} else {
			!rst && (rst = false);
		}
	}
	/*
	if (Math.abs(p1c.x-p2c.x)<offset && Math.abs(p1c.y-p2c.y)<offset){
		rst && (rst = 'center_center');
	}*/
	return rst;
}
/**
 * 获取元素top,bottom,left,right值
 * @param $obj
 * @returns obj
 */
function getPoints($obj){
	var aleft=parseFloat($obj.css('left'));
	var aright=parseFloat($obj.css('left'))+$obj.width()+2;
	var atop=parseFloat($obj.css('top'));
	var abottom=parseFloat($obj.css('top'))+$obj.height()+2;
	return {left:aleft,right:aright,top:atop,bottom:abottom};
}

/**
 * 元素移动到对齐地点
 * @param type 对齐类型
 * @param $target 目标元素
 * @param $obj 要移动的元素
 */
function moveObjTo(type,$target,$obj){
	var top=parseFloat($obj.css('top'));
	var left=parseFloat($obj.css('left'));
	
	if (type=='top_top'){
		top=parseFloat($target.css('top'));
	}
	if (type=='top_bottom'){
		top=parseFloat($target.css('top'))+$target.height();
	}
	if (type=='top_center'){
		top=parseFloat($target.css('top'))+$target.height()/2;
	}
	
	if (type=='bottom_bottom'){
		top=parseFloat($target.css('top'))+$target.height()-$obj.height();
	}
	if (type=='bottom_top'){
		top=parseFloat($target.css('top'))-$obj.height();
	}
	if (type=='bottom_center'){
		top=parseFloat($target.css('top'))+$target.height()/2-$obj.height();
	}
	
	
	if (type=='left_left'){
		left=parseFloat($target.css('left'));
	}
	if (type=='left_right'){
		left=parseFloat($target.css('left'))+$target.width();
	}
	if (type=='left_center'){
		left=parseFloat($target.css('left'))+$target.width()/2;
	}

	if (type=='right_right'){
		left=parseFloat($target.css('left'))+$target.width()-$obj.width();
	}
	if (type=='right_left'){
		left=parseFloat($target.css('left'))-$obj.width();
	}
	if (type=='right_center'){
		left=parseFloat($target.css('left'))+$target.width()/2-$obj.width();
	}
	
	if (type=='center_left'){
		left=parseFloat($target.css('left'))-$obj.width()/2;
	}
	if (type=='center_right'){
		left=parseFloat($target.css('left'))+$target.width()-$obj.width()/2;
	}
	if (type=='center_top'){
		top=parseFloat($target.css('top'))-$obj.height()/2;
	}
	if (type=='center_bottom'){
		top=parseFloat($target.css('top'))+$target.height()-$obj.height()/2;
	}
	if (type=='center_center_x'){
		left=parseFloat($target.css('left'))+$target.width()/2-$obj.width()/2;
	}
	if (type=='center_center_y'){
		top=parseFloat($target.css('top'))+$target.height()/2-$obj.height()/2;
	}
	
	$obj.css({top:top,left:left});
}

//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑对齐线方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑对齐线方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑对齐线方法

/**
 * 添加文字
 * @param txt 文字内容
 * @param labelName 标签名称
 * @param size 文字大小
 * @param align 对齐方式
 * @param fontName 字体名字
 * @param uuid 
 * @param datatype
 * @param isShowLabel 标签是否显示
 * @param selfDefKey 自定义标签field字段
 * @param isAnimate 是否执行添加动画
 */
function addLabel(txt,labelName,size,align,fontName,uuid,datatype,isShowLabel,selfDefKey,isAnimate){
	var $checkbox=$('#tab_1 input[type="checkbox"][datatype="'+datatype+'"]');
	!selfDefKey && $checkbox.attr('uuid', uuid);
	
	if (uuid){
		if ($('#'+uuid).length>0){
			!selfDefKey && $checkbox.prop('checked', isShowLabel);
			!selfDefKey && $checkbox.iCheck('update');
			return;
		}
	} else {
		uuid = getUUID();
		!selfDefKey && $checkbox.attr('uuid', uuid);
	}
	size=(IS_DOUBLE_SIZE?size*2:size)+'px';
	
	var $txtwrap = $("<ortextwrap><ortext></ortext></ortextwrap>").on('click', function(){
		var $this=$(this);
		
		//自定义标签双击修改事件相关
		if ($(this).attr('selfdeftype')){
			if ($(this).data('dbclickTime')){
				//双击修改
				selfdefWindowShow($this.attr('lang'), 'edit', $this);
			}
			$(this).data('dbclickTime',true);
			setTimeout(function(){
				$this.data('dbclickTime',null);
			}, 300);
		}
		
		if ($(this).hasClass('active')){
			$(this).removeClass('active');
		} else {
			removeActive();
			$(this).addClass('active');
			
			//设置字体颜色编辑框的值
			var $ortext=$(this).find('ortext');
			var color=rgbToHex($ortext.css('color'));
			$('#colorLabel').val(color);
			$('#colorLabelStyle').css('backgroundColor', '#'+color);
			
			//设置对齐，加粗斜体下划线编辑框的值
			$('#'+$(this).css('textAlign')).addClass('active').siblings().removeClass('active');
			$(this).css('fontWeight')=='700'           ?$bold.addClass('active')      :$bold.removeClass('active');
			$(this).css('fontStyle')=='italic'         ?$italic.addClass('active')    :$italic.removeClass('active');
			$ortext.css('textDecoration')=='underline' ?$underline.addClass('active') :$underline.removeClass('active');
		}
		tabChange('text');
	}).on('mouseup', function(evt){
		//拖拽移动后保持active状态
		var $this=$(this);
		var orgOffset=$(this).data('orgOffset');
		if (!orgOffset) return;
		if (orgOffset.top != parseFloat($(this).css('top')) || orgOffset.left != parseFloat($(this).css('left'))){
			setTimeout(function(){
				$this.addClass('active');
			});
		}
	});
	
	$txtwrap.attr({
		'type':'text',
		'label':labelName,
		'id':uuid,
		'datatype':datatype,
		'val':txt,
		'isShowLabel':isShowLabel?1:0
	}).css({
		'textAlign':align,
		'z-index':ZORDER_LABEL,
		'fontFamily':fontName,
		'fontSize':size,
		'lineHeight':size
	});
	if (align!='center'){
		$txtwrap.find('ortext').css('float', align);
	}
	
	//如果是自定义标签
	if (selfDefKey){
		$txtwrap.attr({'datatype':selfDefKey,'selfdeftype':datatype});
	}
	
	//如果是普通标签并显示前缀
	if (isShowLabel){
		$txtwrap.find('ortext').html(labelName+':'+txt);
		!selfDefKey && $checkbox.prop('checked', true);
		!selfDefKey && ($checkbox.iCheck && $checkbox.iCheck('update'));
	} else {
		$txtwrap.find('ortext').html(txt);
	}
	
	//添加动画
	if (isAnimate){
		$canvas.append($txtwrap.css('opacity', 0));
		$('#'+uuid).animate({opacity:1});
	} else {
		$canvas.append($txtwrap);
	}
	return uuid;
}
/**
 * checkbox切换标签内容显示与否
 * @param $checkbox
 */
function toggleLabelPrefix($checkbox){
	var uuid=$checkbox.attr('uuid');
	if (!uuid) return;
	var $obj=$('#'+uuid),str;
	var b=$checkbox.is(':checked');
	if (b){
		str=$obj.attr('label')+':'+$obj.attr('val');
	} else {
		str=$obj.attr('val');
	}
	$obj.attr('isshowlabel',b?1:0).find('ortext').html(str);
}


//字体下拉列表初始化
function fontListInit(){
	//字号列表初始化
	var $fontSizeList=$('#fontSizeList');
	for (var i=1;i<131;i++){
		var $tmp=$fontSizeList.find('li:first').clone();
		var size=$tmp.attr('val')-'';
		size=size+i;
		$tmp.attr('val',size).html(size+'px');
		$fontSizeList.append($tmp);
	}
}
/**
* 华康字体
* @param fontName
* @param txt
*/
function huakangFont(fontName, txt){
	$('#testHuakang').html(txt+':');
	$('#testHuakang').css("fontFamily", fontName);
	jsgendfo();
}
/**
* 给选中的Label渲染字体
* @param fontName
* @param txt
* @param callback
*/
function font(fontName, txt, callback, obj){
	$('#fontPanel').html(txt+':');
	var fontCfg = {
		p:'zP8KhbQ1',
		fonts: [{
			fontName: fontName,
			selecters: ["#fontPanel"]
		}]
	};
	var myFont = new FTFont(fontCfg);
}

/**
 * 自定义添加修改窗口弹出
 * @param lang (zh, en)
 * @param type (add, edit)
 * @param $obj 操作对象
 */
function selfdefWindowShow(lang, type, $obj){
	var $w=$('#selfdef_window');
	
	$('#selfdef_type option').each(function(){
		if (lang=='zh'){
			$(this).html($(this).attr('textzh'));
		} else {
			$(this).html($(this).attr('texten'));
		}
	});
	
	if (type == 'edit'){
		$w.find(':text').val($obj.attr('val'));
		$w.find(':checkbox').prop('checked', $obj.attr('isShowLabel')=='1');
		$w.find('select').val($obj.attr('selfdefType'));
	}
	
	$("#selfdef_type").select2();
	$("#selfdef_window input:checkbox").iCheck('update');
	$w.modal('show').attr('type', type).attr('lang', lang).data('obj',$obj);
}

//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
/**
 * 设置旋转
 * @param $obj
 * @param degree
 */
function setRotate($obj,degree,isChange$rotation,isChangeSlidebar) {
	if (degree<0) degree=360+degree;
	var str='rotate(' + degree + 'deg)';
	$obj.css({
		'-webkit-transform': str,
		'-moz-transform': str,
		'-ms-transform': str,
		'-o-transform': str,
		'transform': str
	}).attr('rotation',degree);
	
	if (isChange$rotation && $rotation){
		$rotation.val(degree);
	}
	
	if (isChangeSlidebar && $rotateSlider){
		$rotateSlider.css('left', degree/360*240);
	}
}

/**
 * 添加背景
 * @param url (路径)
 * @param uuid
 * @param isVisible (是否显示)
 * @param isAnimate 是否执行添加动画
 * @param isSelectable 是否可以选择
 */
function addBg(url,uuid,isVisible,isSelectable){
	var $bg=$canvas.find('orbg');
	if ($bg.length==0){
		!uuid && (uuid=getUUID());
		$bg=$("<orbg id='"+uuid+"' type='bg'><img src='"+url+"' ondragstart='return false;'></orbg>");
		$canvas.append($bg);
		if (isSelectable){
			$bg.on('click', function(){
				if ($(this).hasClass('active')){
					$(this).removeClass('active');
				} else {
					$(this).addClass('active');
				}
			});
		}
	} else {
		$bg.find('img').attr('src', url);
	}
	isVisible ? $bg.show() : $bg.hide();
}

/**
 * 添加图片
 * @param url (路径)
 * @param p (位置 as cc.p(x,y))
 * @param uuid
 * @param isAnimate 是否执行添加动画
 * @return bool
 */
function addImg(url,type,uuid,isAnimate){
	if (uuid){
		if ($('#'+uuid).length>0) return false;
	} else {
		uuid = getUUID();
	}
	
	var $img=$("<orimgwrap id='"+uuid+"'><orimg><img class='img' src='"+url+"' ondragstart='return false;'><img class='corner' src='"+_imgCorner+"' ondragstart='return false;'><img class='side' src='"+_imgSide+"' ondragstart='return false;'></orimg></orimgwrap>");
	$img.find('.img').on('click', function(){
		var $parent=$(this).parent().parent();
		if ($parent.hasClass('active')){
			$parent.removeClass('active');
		} else {
			removeActive();
			$parent.addClass('active');
			
			//把图片的相关值写入编辑框里
			var $img=$(this);
			var w=$img.width();
			var h=$img.height();
			$img.width(w);
			$img.height(h);
			$width.val(w);
			$height.val(h);
			
			$opacity.val($img.css('opacity')*100);
			$('#opacityBarBtn').css('left', $opacity.val()/100*240);
			
			var r=$img.parent().attr('rotation');
			!r && (r=0);
			$rotation.val(r);
			$rotateSlider.css('left', r/360*240);
			
			if ($parent.attr('type')=='icon'){
				//背景颜色值写入编辑框里
				var c=$img.css('backgroundColor');
				if (c=='transparent' || c=='rgba(0, 0, 0, 0)'){
					$color.val('');
					$colorStyle.css('backgroundColor', 'transparent');
				} else {
					c=rgbToHex(c);
					$color.val(c);
					$colorStyle.css('backgroundColor', '#'+c);
				}
			}
		}
		tabChange($parent.attr('type'));
	}).on('mouseup', function(evt){
		//拖拽移动后保持active状态
		var $this=$(this).parent().parent();
		var orgOffset=$this.data('orgOffset');
		if (!orgOffset) return;
		if (orgOffset.top != parseFloat($this.css('top')) || orgOffset.left != parseFloat($this.css('left'))){
			setTimeout(function(){
				$this.addClass('active');
			});
		}
	});
	
	$img.find('.corner').on('mousedown', function(){
		$(this).parent().parent().data('imgscale', true);
	});
	$img.find('.side').on('mousedown', function(){
		$(this).parent().parent().data('imgrotate', true);
	});
	
	var zIndex;
	if (type=='img'){
		zIndex=ZORDER_IMG;
	} else if(type=='icon'){
		zIndex=ZORDER_ICON;
	}
	$img.attr('type',type).css({'zIndex':zIndex});
	!IS_DOUBLE_SIZE && $img.attr('scale', true);
	
	//添加动画
	if (isAnimate){
		$canvas.append($img.css('opacity', 0));
		$('#'+uuid).animate({opacity:1});
	} else {
		$canvas.append($img);
	}
	return true;
}

/**
 * 上传图片方法
 * @param $obj (input=='file' 的 jquery对象)
 * @param func (回调方法)
 */
function uploadImages($obj, func){
	var val = $obj.val();
    var names=val.split(".");
    var allowedExtentionNames = ['gif', 'jpg', 'jpeg', 'png'];
    if($.inArray(names.pop().toLowerCase(), allowedExtentionNames)==-1){
        //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
        $.global_msg.init({gType:'warning', msg:'图片格式不对', btns:true, icon:2});
        return;
    }
    $.ajaxFileUpload({
		url:URL_UPLOAD,
		secureuri:false,
		fileElementId:$obj.attr('id'),
		dataType: 'json',
		success: function (data, status){
			if (data.status!='0'){
				$.global_msg.init({gType:'warning', msg:data.info, btns:true, icon:2});
			}
			func(data.url);
		},
		error: function (data, status, e){
			alert(e);
		}
	});
}

//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑图片操作方法

/**
 * 数据初始化
 */
function initData(){
	if (data[DATA_KEY]['TEMP']){
		return;
	}
	for (var key in data){
		data[key]['TEMP']={};
		data[key]['TEMP']['BGCOLOR'] = '#FFFFFF';
		data[key]['TEMP']['ALPHA'] = 0;
		data[key]['TEMP']['BGURL'] = '';
		data[key]['TEMP']['ID'] = getUUID();
		data[key]['TEMP']['TEMPORI'] = 0;
		
    	data[key]['TEMP']['WIDTH'] = WIDTH;
		data[key]['TEMP']['HEIGHT'] = HEIGHT;
    	
    	data[key]['TEXT']=[];
    	data[key]['IMAGE']=[];
	}
}

/**
 * 更新布局数据
 * @param _data obj
 * @param uuid string
 * @param type ('IMAGE' or 'TEXT')
 */
function editData(_data, uuid, type){
	if (!data[DATA_KEY][type]){
		data[DATA_KEY][type] = [];
	}
	for(var i=0;i<data[DATA_KEY][type].length;i++){
		if (data[DATA_KEY][type][i].ID == uuid){
			data[DATA_KEY][type][i] = _data;
			return;
		}
	}
	data[DATA_KEY][type].push(_data);
}
/**
 * 横版竖版切换
 */
function orientationChange(){
	$canvases.attr('orientation', ORIENTATION);
	var w,h;
	if (IS_DOUBLE_SIZE){
		if (ORIENTATION=='landscape'){
			w=WIDTH;
			h=HEIGHT;
		} else {
			w=HEIGHT;
			h=WIDTH;
		}
	} else {
		if (ORIENTATION=='landscape'){
			w=WIDTH/2;
			h=HEIGHT/2;
		} else {
			w=HEIGHT/2;
			h=WIDTH/2;
		}
	}
	$canvases.css({width:w,height:h});
	$webcanvas && $webcanvas.attr({width:w,height:h});
	$canvaswrap && $canvaswrap.css({width:w,height:h});
	
	if (data['FRONT']['TEMP']){
		data['FRONT']['TEMP']['TEMPORI'] = ORIENTATION=='landscape' ? 0 : 1 ;
	}
	if (data['BACK']['TEMP']){
		data['BACK']['TEMP']['TEMPORI']  = ORIENTATION=='landscape' ? 0 : 1 ;
	}
}

/**
 * 获取生成vcard的原始数据
 * @returns obj
 */
function getTextData(){
	var textData={'front':{},'back':{}};
	for(var key in data){
		for(var key2 in data[key]){
			if (key2!='TEXT'){
				continue;
			}
			for (var i=0;i<data[key][key2].length;i++){
				textData[key.toLowerCase()][data[key][key2][i].VALUE.FIELD] = {
					value:'（'+data[key][key2][i].VALUE.LABEL+'）',
	    			visible:true,
	    			label:data[key][key2][i].VALUE.LABEL
				};
			}
		}
	}
	return textData;
}

/**
 * 校准align==center的ortext
 */
function adjustText(){
	$('ortext').each(function(){
		var $parent=$(this).parent();
		var pw=$parent.width();
		var tw=$(this).width();
		var float=$(this).css('float');
		if (float=='none' && pw<tw){
			$(this).css('right', -(pw-tw)/2);
		}
		$(this).attr('adjust', 1);
	});
}

/**
 * 添加电话图标
 */
function addPhoneIcon(){
	//电话图标
	$('ortextwrap').each(function(){
		if ($(this).attr('label').indexOf('电话') === -1){
			return true;
		}
		if ($(this).find('img').length>0){
			return true;
		}
		
		var size=parseInt($(this).css('font-size'));
		var fontSize=size;
		var lineHeight=size;
		//if (lineHeight<minLineHeight*(IS_DOUBLE_SIZE?1:0.5)) lineHeight=minLineHeight*(IS_DOUBLE_SIZE?1:0.5);
		
		//phone icon edit
		var width=fontSize
		//width=42*(IS_DOUBLE_SIZE?1:0.5);
		//var paddingTop=0;
		//paddingTop=(parseInt(size)-width)/2+2;
		
	    var $img=$('<img src="'+SRC_PHONE+'" style="float:'+$(this).css('text-align')+';width:'+width+'px;">');
	    //$img.css('padding-top', paddingTop);
		if ($(this).css('text-align')=='right'){
			var $ortext=$(this).find('ortext');
			var orgLeft=parseInt($(this).css('left'));
			var offsetLeft=$ortext.width()-$(this).width()+width+23;
			$(this).width($ortext.width()+width+23);
			$(this).css({'left':orgLeft-offsetLeft+'px', 'fontSize':fontSize+'px', 'lineHeight':lineHeight+'px'}).find('ortext').after($img);
		} else {
			$(this).css({'width':1200, 'fontSize':fontSize+'px', 'lineHeight':lineHeight+'px'}).find('ortext').before($img);
		}
	});
}
/**
 * 根据数据渲染名片
 * @param bool isBgSelectable 背景是否可选择
 */
function render(isBgSelectable){
	for(var key in data[DATA_KEY]){
		if (key == 'TEMP' && data[DATA_KEY][key].BGURL){
			addBg(data[DATA_KEY][key].BGURL, data[DATA_KEY][key].ID, data[DATA_KEY][key].ALPHA==1?true:false, isBgSelectable);
		}
		if (key == 'IMAGE'){
			for(var i=0;i<data[DATA_KEY][key].length;i++){
				var tmp=data[DATA_KEY][key][i];
				var b=addImg(tmp.PHOTO, tmp.TYPE, tmp.ID);
				if (!b) continue;
				
				var $imgwrap=$('#'+tmp.ID);
				var $img=$imgwrap.find('.img');
				$imgwrap.css({
					top:(IS_DOUBLE_SIZE?tmp.MINY:tmp.MINY/2)+'px',
					left:(IS_DOUBLE_SIZE?tmp.MINX:tmp.MINX/2)+'px',
					'z-index':tmp.ORDER
				});
				tmp.WIDTH-='';
				tmp.HEIGHT-='';
				var bgColor=tmp.COLOR=='transparent'?'transparent':tmp.COLOR;
				$img.css({
					width:tmp.WIDTH-'',
					height:tmp.HEIGHT-'',
					backgroundColor:bgColor,
					opacity:tmp.ALPHA
				});
				setRotate($img.parent(),tmp.ROTATE);
				
				//如果是会员卡模板的二维码的话
				if (!!tmp['FIELD'] && !!tmp['LABEL'] && !!tmp['VALUE']){
					$imgwrap.attr('textfield', tmp['FIELD']);
					$imgwrap.attr('textvalue', tmp['VALUE']);
					$imgwrap.attr('textlabel', tmp['LABEL']);
					$imgwrap.attr('textcontact', tmp['CONTACT']);
				}
			}
		}
		if (key == 'TEXT'){
			for(var i=0;i<data[DATA_KEY][key].length;i++){
				var tmp=data[DATA_KEY][key][i];
				var values=tmp.VALUE;
				//var labelVisible=values.VISIBLE=='1';
				var labelVisible=tmp.LABEL=='1';
				var size=tmp.SIZE/2;
				//如果值为空，则不添加
				if (!values.VALUE){
					continue;
				}
				
				if (values.SELFDEFTYPE){
					addLabel(values.VALUE,values.LABEL,size,tmp.ALIGN,tmp.FONT,tmp.ID,values.SELFDEFTYPE,labelVisible,values.FIELD);
				} else {
					if (tmp.FONT=='Farrington7B'){
						size*=2;
					}
					addLabel(values.VALUE,values.LABEL,size,tmp.ALIGN,tmp.FONT,tmp.ID,values.FIELD,labelVisible);
				}
				
				var $textwrap=$('#'+tmp.ID);
				$textwrap.attr('format', values.FORMAT);
				$textwrap.attr('contact', values.CONTACT);
				var $text=$textwrap.find('ortext');
				$textwrap.css({
					'font-weight':tmp.BOLD=='1'?700:400,
					'font-style':tmp.ITALIC=='1'?'italic':'normal',
					color:tmp.COLOR,
					top:(IS_DOUBLE_SIZE?tmp.MINY:tmp.MINY/2)+'px',
					left:(IS_DOUBLE_SIZE?tmp.MINX:tmp.MINX/2)+'px',
					width:(parseInt(tmp.WIDTH))/(IS_DOUBLE_SIZE?1:2)
				});
				
				$text.css({
					'text-decoration':tmp.UNDERLINE=='1'?'underline':'none',
					'float':tmp.ALIGN=='CENTER'?'none':tmp.ALIGN
				});
			}
		}
	}
}

/**
 * 根据当前选中元素的类别，切换到相应tab
 * @param type (text, img, icon)
 */
function tabChange(type){
	type=='text' && $tabTxt.click();
	type=='img'  && $tabImg.click();
	type=='icon' && $tabIcon.click();
}

/**
 * 删除选中元素的选中状态
 */
function removeActive(){
	if (!$active){
		return;
	}
	$active.find('.corner, .side').hide();
	$active.removeClass('active');
}
/**
 * rgb to #ffffff
 * @param c (rgb object)
 * @returns (color string as #ffffff)
 */
function rgbToHex(rgb){
	var arr=rgb.split(',');
	var r=parseInt(arr[0].substring(4));
	var g=parseInt(arr[1]);
	var b=parseInt(arr[2]);
	r=r==0?'00':r.toString(16);
	g=g==0?'00':g.toString(16);
	b=b==0?'00':b.toString(16);
	if (r.length==1) r='0'+r;
	if (g.length==1) g='0'+g;
	if (b.length==1) b='0'+b;
	return (''+r+g+b).toUpperCase();
}

/**
 * 获取元素的中心点
 * @param $obj
 * @return {x,y}
 */
function getPosition($obj){
	var left=parseFloat($obj.css('left'));
	var top=parseFloat($obj.css('top'));
	var width=$obj.width();
	var height=$obj.height();
	
	return {x:left+width/2,y:top+height/2};
}

/**
 * 对象是否包含点
 * @param $obj
 * @param point {x,y}
 * @return bool
 */
function rectContainsPoint($obj, point, canvasOffset){
	var left=$obj.offset().left-canvasOffset.left;
	var top=$obj.offset().top-canvasOffset.top;
	
	var width=$obj.width();
	var height=$obj.height();
	//console.log("left="+left+",top="+top+",width="+width+",height="+height+",x="+point.x+",y="+point.y);
	if (point.x<left){
		//console.log('failed1');
		return false;
	}
	if (point.y<top){
		//console.log('failed2');
		return false;
	}
	if (point.x>left+width){
		//console.log('failed3');
		return false;
	}
	if (point.y>top+height){
		//console.log('failed4');
		return false;
	}
	return true;
}

/**
 * 获取唯一uuid
 * @returns string
 */
function getUUID(){
	return Math.uuid();
}

//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑其他公用方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑其他公用方法
//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑其他公用方法