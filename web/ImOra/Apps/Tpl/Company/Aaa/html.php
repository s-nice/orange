<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<style type="text/css">
*{padding:0;margin:0;border:none;}

orcanvas {display:inline-block;position:relative;cursor:default;overflow:hidden;background-color:white;top:-2px;}
orcanvas ortextwrap{border:1px solid transparent;position:absolute;display:inline-block;top:0;left:0;}
orcanvas ortextwrap.active{border:1px dotted black;}
orcanvas ortextwrap ortext{display:inline-block;word-break:keep-all;text-wrap:none; white-space: nowrap;position:relative;}
orcanvas ortextwrap img{display:inline;padding-right:23px;/*padding-top:8px;*/}

orcanvas orimgwrap{position:absolute;display:block;}
orcanvas orimgwrap orimg{position:relative;display:block;border:1px solid transparent;}
orcanvas orimgwrap.active orimg{border:1px dotted black;}
orcanvas orimgwrap orimg .img{position:relative;}
orcanvas orimgwrap orimg .corner{position:absolute;right:-20px;bottom:-20px;display:none;}
orcanvas orimgwrap orimg .side{position:absolute;right:-20px;top:50%;margin-top:-10px;display:none;}

orcanvas orbg{position:absolute;top:0;left:0;z-index:0;width:100%;height:100%;display:block;}
orcanvas orbg img{width:100%;height:100%;}

@font-face {font-family: 'Farrington7B';src: url('{:U('/')}fonts/new/farrington7b.ttf') format('truetype');}
@font-face {font-family: 'CenturyGothicWGL';src: url('{:U('/')}fonts/new/CGot_WG_.ttf') format('truetype');}
</style>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/Company/cardEditorHTMLFunc.js"></script>
</head>
<body style='height:720px;'>
<orcanvas id="cardEditor"></orcanvas>
<if condition="$isShowBack eq '1'">
<orcanvas id="cardEditorBack"></orcanvas>
</if>

</body>
<script type="text/javascript">
var $canvas=$('#cardEditor');
var $canvas2=$('#cardEditorBack');

var DATA_KEY='FRONT';
var data=JSON.parse('{$data}');
var IS_DOUBLE_SIZE=true;
var IS_ADD_PHONT_ICON='{$isAddPhoneIcon}';
var ORIENTATION=(!data[DATA_KEY]['TEMP'] || data[DATA_KEY]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait';
$canvas.attr('orientation', ORIENTATION);
$canvas2.attr('orientation', ORIENTATION);

var WIDTH="{$width}"-'';
var HEIGHT="{$height}"-'';
if (ORIENTATION=='landscape'){
	$canvas.css({width:WIDTH,height:HEIGHT});
	$canvas2.css({width:WIDTH,height:HEIGHT});
} else {
	$canvas.css({width:HEIGHT,height:WIDTH});
	$canvas2.css({width:HEIGHT,height:WIDTH});
}

var _imgCorner = '/images/cardEditor/corner.png';
var _imgSide   = '/images/cardEditor/side.png';
var SRC_PHONE="__PUBLIC__/images/ic_card_back_phone.png";

var ZORDER_BG    = 10;
var ZORDER_IMG   = 11;
var ZORDER_ICON  = 12;
var ZORDER_LABEL = 13;
var ZORDER_DRAW  = 14;

$(function(){
	render();
	DATA_KEY='BACK';
	if ($canvas2){
    	$canvas=$canvas2;
    	render(DATA_KEY);
	}
    if (IS_ADD_PHONT_ICON=='1'){
    	addPhoneIcon();
    }
	adjustText();
});
</script>
</html>