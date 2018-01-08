<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<style type="text/css">
*{padding:0;margin:0;}
</style>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/cocos2d/cocos2d-js-v3.12.min.js"></script>
<script type="text/javascript">
var data=JSON.parse('{$data}');
var source="{$source}";
var images={'FRONT':'','BACK':''};
var URL_SAVEIMG = "{:U('Company/Aaa/saveCard')}";
$(function(){
	//预加载图片
	var preloadImages=JSON.parse('{$preloadImages}');
	var _dataKey='FRONT';
	//当前模板UUID
	var cardId="{$cardId}";

	//当前运行中的场景
	var RUNNING_SCENE;
	var _canvasId='cardEditor';
	var $canvas=$('#'+_canvasId);

	var TAG_CORNER    = 100;
	var TAG_SIDE      = 110;
	var TAG_DRAW_NODE = 120;
	var TAG_SUB_LABEL = 130;
	var TAG_BG        = 140;

	var ZORDER_BG    = 10000;
	var ZORDER_IMG   = 20000;
	var ZORDER_ICON  = 30000;
	var ZORDER_LABEL = 40000;
	var ZORDER_DRAW  = 90000;

	var _imgIcon   = '/images/cardEditor/icon.png';
	var _imgCorner = '/images/cardEditor/corner.png';
	var _imgSide   = '/images/cardEditor/side.png';
	var _imgNone   = '/images/cardEditor/none.png';

	/**
	 * 添加可拖拽放大缩小按钮和旋转按钮
	 * 创建影子node(放大缩小旋转时候使用)
	 * @param item
	 */
	function addCornerAndSide(item){
		if (item.type=='bg') return;
		var box=item.getBoundingBox();
		var file=item.getTexture().url;
		var shadow1 = cc.Sprite.create(file);
		shadow1.setOpacity(0);
		shadow1.setAnchorPoint(cc.p(1,1));
		shadow1.setColor(cc.color(255,0,0));
		item.addChild(shadow1);
		item.shadowImg1 = shadow1;
		
		var shadow2 = cc.Sprite.create(file);
		shadow2.setOpacity(0);
		shadow2.setColor(cc.color(0,255,0));
		shadow2.setPosition(cc.p(box.width/2, box.height/2));
		item.addChild(shadow2);
		item.shadowImg2 = shadow2;
	}
	/**
	 * #ffffff to rgb
	 * @param hex (color string as #ffffff)
	 * @returns (rbg color object)
	 */
	function hexToRgb(hex) {
	    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	    return result ? {
	        r: parseInt(result[1], 16),
	        g: parseInt(result[2], 16),
	        b: parseInt(result[3], 16)
	    } : null;
	}
	/**
	 * 获取canvas的size
	 * @returns cc.size
	 */
	function _getWinSize(){
		return cc.size($canvas.attr('width'), $canvas.attr('height'));
	}
	/**
	 * 添加文字标签
	 * @param val (内容)
	 * @param title (标签文字)
	 * @param p (位置 as cc.p(x,y))
	 * @param uuid 
	 * @param datatype (such as name, address, mobilephone)
	 * @param isTitleVisible (标签是否显示)
	 * @param selfdefType (自定义标签的类别，非自定义标签则为false)
	 * @returns 添加的标签node
	 */
	function addLabel(val, title, lang, p, uuid, datatype, isTitleVisible, selfdefType){
		var index=0;
		for(var i=0;i<RUNNING_SCENE.getChildrenCount();i++){
			var _item=RUNNING_SCENE.getChildren()[i];
			if (_item.datatype && _item.datatype==datatype){
				index++;
			}
			if (_item.datatype && _item.datatype==datatype && _item.lang==lang){
				alert(title+'已经存在');
				return;
			}
		}
		
		var label = MyLabel.createLabel( isTitleVisible ? title+'：'+val : val,"微软雅黑",32);
		var size = _getWinSize();
	    p ? label.setPosition(p): label.setPosition(size.width/2,size.height/2);
	    uuid ? label.uuid=uuid : label.uuid=getUUID();
	    label.datatype = datatype;
	    label.val = val;
	    label.isShowLabel = isTitleVisible;
	    label.labelName = title;
	    label.lang = lang;
	    label.index = index;
	    RUNNING_SCENE.addChild(label);
	    if (selfdefType){
	    	label.selfdefType=selfdefType;
	    } else {
	    	$('#'+datatype+'-'+lang).attr('uuid', label.uuid).next().attr('uuid', label.uuid);
	    }
	    return label;
	}
	/**
	 * 添加图片
	 * @param url (路径)
	 * @param p (位置 as cc.p(x,y))
	 * @param uuid
	 * @returns 添加的图片node
	 */
	function addImg(url, p, uuid){
		var img=MyImg.createImg(url);
		uuid ? img.uuid=uuid: img.uuid=getUUID();
		var size = _getWinSize();
		p ? img.setPosition(p) : img.setPosition(size.width / 2, size.height/2);
	    RUNNING_SCENE.addChild(img);
	    return img;
	}
	/**
	 * 添加图标
	 * @param url (路径)
	 * @param p (位置 as cc.p(x,y))
	 * @param uuid
	 */
	function addIcon(url, p, uuid){
		var icon=MyImg.createIcon(url);
		uuid ? icon.uuid=uuid : icon.uuid=getUUID();
		var size = _getWinSize();
		p? icon.setPosition(p): icon.setPosition(size.width / 2, size.height/2);
	    RUNNING_SCENE.addChild(icon);
	}
	/**
	 * 添加背景图片
	 * @param url (路径)
	 * @param p (位置 as cc.p(x,y))
	 * @param isVisible (是否显示)
	 */
	function addBg(url, p, isVisible){
		var bg=MyImg.createBg(url);
		bg.bgVisible = isVisible;
		bg.uuid = data[_dataKey]['TEMP']['ID'];
		var size = _getWinSize();
		p? bg.setPosition(p): bg.setPosition(size.width / 2, size.height/2);
		RUNNING_SCENE.removeChildByTag(TAG_BG);
	    RUNNING_SCENE.addChild(bg);
	}
	/**
	 * 文字标签类
	 */
	var MyLabel = cc.Sprite.extend({
		/**
		 * 绘制下划线
		 */
		drawUnderline: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			var box=label.getBoundingBox();
			this.drawNode.clear();
			this.drawNode.drawSegment(cc.p(box.x, box.y), cc.p(box.x+box.width, box.y), 1, label.getColor());
		},
		/**
		 * 左对齐
		 */
		alignLeft: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			label.setAnchorPoint(cc.p(0, 0.5));
			label.setPosition(cc.p(0, label.getPosition().y));
			this.align=cc.TEXT_ALIGNMENT_LEFT;
		},
		/**
		 * 居中
		 */
		alignCenter: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			label.setAnchorPoint(cc.p(0.5, 0.5));
			label.setPosition(cc.p(this.getBoundingBox().width/2, label.getPosition().y));
			this.align=cc.TEXT_ALIGNMENT_CENTER;
		},
		/**
		 * 右对齐
		 */
		alignRight: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			label.setAnchorPoint(cc.p(1, 0.5));
			label.setPosition(cc.p(this.getBoundingBox().width, label.getPosition().y));
			this.align=cc.TEXT_ALIGNMENT_RIGHT;
		},
		/**
		 * 加粗
		 */
		makeBold: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			if (label._getFontWeight()=='bold'){
				label._setFontWeight('normal');
				this.bold=false;
			} else {
				label._setFontWeight('bold');
				this.bold=true;
			}
		},
		/**
		 * 斜体
		 */
		makeItalic: function(){
			var label=this.getChildByTag(TAG_SUB_LABEL);
			if (label.getSkewX()>0){
				label.setSkewX(0);
				this.italic=false;
			} else {
				label.setSkewX(10);
				this.italic=true;
			}
		},
		/**
		 * 下划线
		 */
		makeUnderline: function(){
			if (this.underline){
				this.underline=false;
			} else {
				this.underline=true;
			}
		}
	});
	/**
	 * 创建文字标签类
	 */
	MyLabel.createLabel=function(str, font, size){
		var width=Math.round($('#'+_canvasId).width()*2/3);
		var height=30;
		var item=new MyLabel(_imgNone,cc.rect(0,0,width,height));
		item.type='label';
		item.setLocalZOrder(ZORDER_LABEL);
		
		var label = cc.LabelTTF.create(str,"微软雅黑",32);
		label.setOpacity(255);
	    label.setPosition(width/2,height/2);
	    label.textAlign = cc.TEXT_ALIGNMENT_CENTER;
	    label.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_CENTER;
	    label.tag=TAG_SUB_LABEL;
	    label.setColor(cc.color.BLACK);
	    item.label=label;
	    item.addChild(label);
	    
	    item.drawNode = cc.DrawNode.create();
		item.drawNode.setLocalZOrder(ZORDER_DRAW);
		item.addChild(item.drawNode);
		return item;
	}
	/**
	 * 图片类(包括背景图片，图标，一般图片)
	 */
	var MyImg = cc.Sprite.extend({
		
	});
	/**
	 * 创建一般图片
	 */
	MyImg.createImg=function(file){
		var item=new MyImg(file);
		item.type='img';
		item.setLocalZOrder(ZORDER_IMG);
		item.setOpacity(0);
		item.addLoadedEventListener(function(){
			if (!item.originBox){
				item.originBox=item.getBoundingBox();
				item.setOpacity(255);
			}
			addCornerAndSide(item);
		}, item, file);
		return item;
	}
	/**
	 * 创建图标
	 */
	MyImg.createIcon=function(file){
		var item=MyImg.createImg(file);
		item.setLocalZOrder(ZORDER_ICON);
		item.type='icon';
		item.setOpacity(0);
		item.addLoadedEventListener(function(){
			if (!item.originBox){
				item.setOpacity(255);
			}
		}, item);
		return item;
	}
	/**
	 * 创建背景图片
	 */
	MyImg.createBg=function(file){
		var item=MyImg.createImg(file);
		item.setLocalZOrder(ZORDER_BG);
		item.type='bg';
		item.tag=TAG_BG;
		item.setOpacity(0);
		item.addLoadedEventListener(function(){
			var size = _getWinSize();
			var box = item.getBoundingBox();
			item.setScaleX(size.width/box.width);
			item.setScaleY(size.height/box.height);
			item.setOpacity(item.bgVisible?255:0);
		}, item);
		return item;
	}
	/**
	 * 主场景类
	 */
	var CardEditor = cc.Scene.extend({
	    onEnter:function () {
	        this._super();
	        var _this=this;
	        this.loadData();
	        this.update();
	        //this.scheduleUpdate();
	    },
	    /**
	     * 加载场景时候，读取数据，并添加元素到场景里
	     */
	    loadData: function(){
	    	var tag = 100;
	    	for(var key in data[_dataKey]){
	    		if (key == 'TEMP' && data[_dataKey][key].BGURL){
	    			addBg(data[_dataKey][key].BGURL, cc.p(data[_dataKey][key].WIDTH/2, data[_dataKey][key].HEIGHT/2), data[_dataKey][key].BGVISIBLE==1?true:false);
	    		}
	    		if (key == 'IMAGE'){
	    			for(var i=0;i<data[_dataKey][key].length;i++){
	    				var tmp=data[_dataKey][key][i];
	    				var img=addImg(tmp.PHOTO, null, tmp.ID);
	    				img.setLocalZOrder(tmp.ORDER);
	    				img.tag = tag++;
	    				var p=this.itemCenterPoint(tmp.MINX, tmp.MINY, tmp.WIDTH, tmp.HEIGHT);
	    				img.setPosition(p);
	    				
	    				function callback(img, tmp){
	    					img.addLoadedEventListener(function(){
	        					var box=img.getBoundingBox();
	        					var scaleX=tmp.WIDTH/box.width;
	        					var scaleY=tmp.HEIGHT/box.height;
	        					img.setScaleX(scaleX);
	        					img.setScaleY(scaleY);
	        					
	        					img.shadowImg1.setScaleX(scaleX);
	        					img.shadowImg1.setScaleY(scaleY);
	        					
	        					if (!!tmp.ROTATE){
	        						img.setRotation(tmp.ROTATE);
	            					img.shadowImg2.setRotation(-tmp.ROTATE);
	        					}
	        				}, img, tmp);
	    				}
	    				callback(img, tmp);
	    			}
	    		}
				if (key == 'TEXT'){
					for(var i=0;i<data[_dataKey][key].length;i++){
						var tmp=data[_dataKey][key][i];
						var p=this.itemCenterPoint(tmp.MINX, tmp.MINY, tmp.WIDTH, tmp.HEIGHT);
						var selfdefType = tmp.VALUES[0].SELFDEFTYPE ? tmp.VALUES[0].SELFDEFTYPE : '';
						var visible=tmp.VALUES[0].VISIBLE=='1'?true:false;
						var label = addLabel(tmp.VALUES[0].VALUE, tmp.VALUES[0].LABEL, tmp.VALUES[0].LANG, p, tmp.ID, tmp.VALUES[0].FIELD, visible, selfdefType);
						
						label.setLocalZOrder(tmp.ORDER);
						
						tmp.BOLD-'' && label.makeBold();
						tmp.ITALIC-'' && label.makeItalic();
						tmp.UNDERLINE-'' && label.makeUnderline();
						
						tmp.ALIGN == 'LEFT' && label.alignLeft();
						tmp.ALIGN == 'RIGHT' && label.alignRight();
						
						color=hexToRgb(tmp.COLOR);
						color && label.label.setColor(cc.color(color.r, color.g, color.b));
						label.label.setFontSize(tmp.SIZE);
						
						label.label.setFontName(tmp.FONT);
						if (visible && !selfdefType){
							
						} else if(visible && selfdefType){
							label.label.setString(visible ? tmp.VALUES[0].LABEL+'：'+tmp.VALUES[0].VALUE : tmp.VALUES[0].VALUE);
						}
					}
				}
	    	}
	    },
	    /**
	     * 获取左上角为远点的坐标
	     */
	    itemCenterPoint: function(x, y, width, height){
	    	x = x-'';
	    	y = y-'';
	    	width=width-'';
	    	height=height-'';
	    	return cc.p(x+width/2, _getWinSize().height-(y+height/2));
	    },
	    /**
	     * 循环执行的方法
	     */
	    update: function(dt){
	    	//统一绘制下划线
	    	for(var i=0;i<this.getChildrenCount();i++){
	    		var _item=this.getChildren()[i];
	    		if (_item.type=='label'){
	    			_item.underline ? _item.drawUnderline() : _item.drawNode.clear();
	    		}
	    	}
	    	
	    	var posting=false;
	    	var it = setInterval(function(){
		    	if (posting) return;
	    		var img = document.getElementById("cardEditor").toDataURL("image/png");
	    		if (img.length != images[_dataKey].length){
	    			images[_dataKey] = img;
	    		} else {
		    		if (_dataKey == 'FRONT'){
			    		if (source==''){
			    			loadScene('BACK', (data[_dataKey]['TEMP'] && data[_dataKey]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait');
			    			clearInterval(it);
			    			return;
			    		} else {
			    			$.post(URL_SAVEIMG, {image:images,cardId:cardId,source:source}, function(rst){
				    			document.title = 'ok';
				    			clearInterval(it);
				    			return;
				    		});
				    		return;
			    		}
		    		} else {
		    			posting=true;
		    			$.post(URL_SAVEIMG, {image:images,cardId:cardId,source:source}, function(rst){
			    			document.title = 'ok';
			    			clearInterval(it);
			    			return;
			    		});
		    		}
	    		}
		    }, 1000);
	    }
	});
	/**
	 * 加载场景
	 * @param type ('front','back')
	 * @param orientation ('landscape', 'portrait')
	 */
	function loadScene(type, orientation){
		_dataKey = type;
		var newScene = new CardEditor();
		RUNNING_SCENE = newScene;
		cc.director.runScene(RUNNING_SCENE);
	}
	
	cc._loaderImage=false;
    cc.game.onStart = function(){
    	cc.director.setDisplayStats(false);
        cc.LoaderScene.preload(preloadImages, function () {
        	loadScene(_dataKey, (data[_dataKey]['TEMP'] && data[_dataKey]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait');
        }, this);
    };
    cc.game.config={debugMode:0, frameRate:60, id:_canvasId, renderMode:1, jsList:[]};
    cc.game.run(_canvasId);
    
    /*
    setTimeout(function(){
    	loadScene('BACK', (data[_dataKey]['TEMP'] && data[_dataKey]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait');
    },1000);*/
});

</script>
</head>
<body>
	<if condition="$orientation eq 1">
    <canvas id="cardEditor" width="400" height="700" style='cursor:default;' orientation='portrait'></canvas>
    <else/>
    <canvas id="cardEditor" width="700" height="400" style='cursor:default;' orientation='landscape'></canvas>
    </if>
</body>

</html>