<layout name="../Layout/Layout" />
<style>

/*选中字体OR字号背景色*/
.font_height li.active, .font_height li:hover, #fontSizeList li.active, #fontSizeList li:hover, #fontSizeList2 li.active, #fontSizeList2 li:hover, #colorList li.active, #colorList li:hover{background-color:white;}

/*删除按钮点中状态*/
.bgred{background-color:red !important;color:white !important;}

/*加载一个默认字体*/
@font-face {font-family: 'Farrington7B';src: url('{:U('/')}fonts/new/farrington7b.eot'),url('{:U('/')}fonts/new/farrington7b.ttf') format('truetype');}
@font-face {font-family: 'CenturyGothicWGL';src: url('{:U('/')}fonts/new/CGot_WG_.eot'),url('{:U('/')}fonts/new/CGot_WG_.ttf') format('truetype');}

/*禁止选中文字*/
body{
    -moz-user-select:none;
    -webkit-user-select:none;
	-ms-user-select:none;
	-khtml-user-select:none;
	-o-user-select:none;
    user-select:none;
}

/*HTML画板样式*/
orcanvaswrap, orcanvas{transition: all 0.6s ease-in-out 0s;}
orcanvaswrap{display:inline-block;position:relative;}

orcanvas {background-color:white;display:block;position:absolute;cursor:default;border:1px solid #ccc;overflow:hidden;top:0;left:0;transform-style: preserve-3d;backface-visibility: hidden;}

orcanvas.cardEditorFront{z-index:9;opacity:1;transform:rotateY(0deg);}
orcanvas.cardEditorBack{z-index:8;opacity:0;transform:rotateY(-179deg);}

orcanvas.cardEditorFront.flip{z-index:8;opacity:0;transform:rotateY(179deg);}
orcanvas.cardEditorBack.flip{z-index:9;opacity:1;transform:rotateY(0deg);}

orcanvas ortextwrap{border:1px solid transparent;position:absolute;display:inline-block;top:0;left:0;}
orcanvas ortextwrap.active{border:1px dotted #00ffff;}
orcanvas ortextwrap ortext{display:inline-block;word-break:keep-all;white-space: nowrap;position:relative;}
orcanvas ortextwrap img{display:inline;padding-right:12px;/*padding-top:4px;*/}

orcanvas orimgwrap{position:absolute;display:block;top:0;left:0;}
orcanvas orimgwrap orimg{position:relative;display:block;border:1px solid transparent;}
orcanvas orimgwrap.active orimg{border:1px dotted #00ffff;}
orcanvas orimgwrap orimg .img{position:relative;}
orcanvas orimgwrap orimg .corner{position:absolute;right:-20px;bottom:-20px;display:none;}
orcanvas orimgwrap orimg .side{position:absolute;right:-20px;top:50%;margin-top:-10px;display:none;}

orcanvas orbg{position:absolute;top:0;left:0;z-index:0;width:100%;height:100%;display:block;}
orcanvas orbg.active{border:1px dotted #00ffff;}
orcanvas orbg img{width:100%;height:100%;}
tip{position:absolute;top:0;left:0;opacity:0;color:red;z-index:9999999;background-color:white;}
.select2-search{display:none;}
tip.showing{ -moz-animation: bumpin 0.4s ease-out;-ms-animation: bumpin 0.4s ease-out;-webkit-animation: bumpin 0.4s ease-out;-o-animation: bumpin 0.4s ease-out;animation: bumpin 0.4s ease-out;}
@-moz-keyframes bumpin {
    0%   { -moz-transform: scale(1);opacity:0; }
    50%  { -moz-transform: scale(2);opacity:1; }
    100% { -moz-transform: scale(3);opacity:0; }
}

@-webkit-keyframes bumpin {
    0%   { -webkit-transform: scale(1);opacity:0; }
    50%  { -webkit-transform: scale(2);opacity:1; }
    100% { -webkit-transform: scale(3);opacity:0; }
}

@-ms-keyframes bumpin {
    0%   { -ms-transform: scale(1);opacity:0; }
    50%  { -ms-transform: scale(2);opacity:1; }
    100% { -ms-transform: scale(3);opacity:0; }
}

@-o-keyframes bumpin {
    0%   { -o-transform: scale(1);opacity:0; }
    50%  { -o-transform: scale(2);opacity:1; }
    100% { -o-transform: scale(3);opacity:0; }
}
@keyframes bumpin {
    0%   { transform: scale(1);opacity:0; }
    50%  { transform: scale(2);opacity:1; }
    100% { transform: scale(3);opacity:0; }
}
</style>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="template_left">
				<div class="only">{$T->str_orangecard_property}</div>
				<div class="only_tit">{$T->str_orangecard_property_common}</div>
				<ul class="card_ul">
				    <foreach name='commonProps' item='val'>
			        <li tid='attr{$val.id}'>
			            <span title="{$val.attr} ({$val.val})">{$val.attr}</span>
			            <input type="hidden" value="{$val.val}" autocomplete='off'  contact="{$val.contact}">
			        </li>
				    </foreach>
				</ul>
				<div class="only_tit">{$T->str_orangecard_property_cardunits}</div>
				<ul class="card_ul_text">
				    <foreach name='cardProps' item='val'>
			        <li tid='attr{$val.id}'>
			            <if condition="$val['isedit'] eq 1">
			            <span title="{$val.attr}">{$val.attr}</span>
			            <input type="text" value="{$val.val}" autocomplete='off'>
			            <else/>
			            <span class='max' title="{$val.attr} ({$val.val})">{$val.attr}</span>
			            <input type="hidden" value="{$val.val}" autocomplete='off'>
			            </if>
			        </li>
				    </foreach>
				</ul>
				<div class="edit_warmp">
					<div class="edit_text">
						<h5>{$T->str_orangecard_font}</h5>
						<i class="sheap"></i>
						<h6></h6>
						<ul class="font_height" class="z_index" id='fontList' style='height:64px;'>
							<foreach name="fonts" item="v" key="k">
                            <li id='{$k}' val='{$k}'>{$v}</li>
                            </foreach>
						</ul>
					</div>
					<div class="edit_text clear">
						<h5>{$T->str_orangecard_font_size}</h5>
						<i class="sheap"></i>
						<h6></h6>
						<ul class="font_height" id='fontSizeList'>
							<li val='20'>20px</li>
						</ul>
						<ul class="font_height" id='fontSizeList2' style='height:64px;'>
                            <foreach name="fontSizes7B" item="v" key="k">
                            <li val='{$v.val}'>{$v.str}</li>
                            </foreach>
						</ul>
					</div>
					<div class="edit_text edit_color clear">
						<h5>{$T->str_orangecard_color}</h5>
						<div class="edit_show_color">
							<input id='colorLabel' type="text" readonly autocomplete='off' class="jscolor{valueElement:'colorLabel', styleElement:'colorLabelStyle'}" value="000000"/>
							<span id='colorLabelStyle'></span>
							<em class="left_line" style='opacity:0;'></em>
							<em class="right_line" style='opacity:0;'></em>
						</div>
					</div>
					<div class="edit_text edit_color clear" style='display:none;'>
						<h5>颜色</h5>
						<i class="sheap"></i>
						<h6></h6>
						<ul class="font_height" id='colorList' style='height:94px;'>
							<foreach name="fontColors7B" item="v" key="k">
                            <li val='#{$v.val}'>{$v.str}</li>
                            </foreach>
						</ul>
					</div>
					<div class="edit_text">
						<h5>坐标</h5>
						<div class="edit_show_color">
							<i class="left" style="line-height:30px;margin-right:3px;">X</i>
							<input id='x' style="width:48px;" type="text">
							<i class="left" style="line-height:30px;margin-right:3px;">Y</i>
							<input id='y' style="width:48px;" type="text">
						</div>
					</div>
					<div class="edit_text edit_center clear">
						<h5>页面排版</h5>
						<span>居中</span>
					</div>
					<div class="edit_text clear">
						<h5>{$T->str_orangecard_style}</h5>
						<span class="edit_style">
							<em id='bold' class="left_em"><b>B</b></em>
							<em id='italic' class="i_middle"><i>I</i></em>
							<em id='underline' class="u_right"><b>U</b></em>
						</span>
						<span class="edit_align">
							<em id='left' ><b class="r_left"></b></em>
							<em id='center' ><b class="r_middle"></b></em>
							<em id='right' ><b class="r_right"></b></em>
						</span>
					</div>
					
					<div class="edit_text" id='numberFormat' style='display:none;'>
						<h5>卡号格式</h5>
						<i class="sheap"></i>
						<h6></h6>
						<ul class="font_height s_one_list" style="height:66px;" id='numberFormatList'>
							<li val='默认连续' class='default'>默认连续</li>
							<li>
								<em>自定义：</em>
								<input type="text" autocomplete='off'>
								<button type="button">确定</button>
							</li>
						</ul>
					</div>
					<div class="edit_text" id='dateFormat' style='display:none;'>
						<h5>有效期格式</h5>
						<i class="sheap"></i>
						<h6></h6>
						<ul class="font_height" style="height:auto;" id='dateFormatList'>
                            <foreach name='dateFormats' item='val'>
                            <li val='{$val.format}'>{$val.val}</li>
                            </foreach>

						</ul>
					</div>
				</div>
			</div>
			<div class="template_right">
				<div class="edit_box">
					<div class="edit_btn">
						<button class="btnBg" type="button" id='front'>{$T->str_orangecard_edit_front}</button>
						<button type="button" id='back'>{$T->str_orangecard_edito_back}</button>
					</div>
					<input id='del' class="del_btn" type="button" value="{$T->str_orangecard_del}">
				</div>

				<div class="add_template_card hand" style='overflow:hidden;'>
				    <input class="input_file" name="img" type="file" id='imgFile' style='display:none;opacity:0;' autocomplete='off'>
					<em id='imgFileEm' str='{$T->str_orangecard_add_background}' uploading='{$T->str_orangecard_uploading}'>{$T->str_orangecard_add_background}</em>
                    <orcanvaswrap>
    				    <orcanvas class='cardEditorFront'></orcanvas>
    				    <orcanvas class='cardEditorBack'></orcanvas>
    				    <canvas id='webcanvas' style='opacity:0;'></canvas>
    				    <div class="x_y">
							<i>200</i>,<i>400</i>
    				    </div>
				    </orcanvaswrap>
				</div>
				<!-- 
				<if condition="$isCommonLayout neq ''">
				    <div class="template_checked">
    					<p><label><input id='applyAll' type="checkbox" autocomplete='off'></label>{$T->str_orangecard_apply_to_all}</p>
    					<p>{$T->str_orangecard_notice}</p>
    				</div>
				</if> -->
				<div class="template_save">
				    <img src="/images/barcode.png" class="img" style="display:none;">
					<button id='submit' class="big_button" type="button" autocomplete='off'>{$T->str_orangecard_save}</button>
					<button class="big_button" type="button">{$T->str_orangecard_cancel}</button>
					<input type='hidden' id='cardtypeid' value='{$cardtypeid}' autocomplete='off'>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var str_orangecard_ets_label_exist="{$T->str_orangecard_ets_label_exist}";
var str_orangecard_nct_upload_front="{$T->str_orangecard_nct_upload_front}";
var str_orangecard_nct_add_attr="{$T->str_orangecard_nct_add_attr}";
var str_orangecard_nct_add_attr_multiple="{$T->str_orangecard_nct_add_attr_multiple}";
var str_orangecard_ets_saving="{$T->str_orangecard_ets_saving}";
var str_orangecard_save="{$T->str_orangecard_save}";
var str_orangecard_del_confirm="{$T->str_orangecard_del_confirm}";
var str_orangecard_cancel="{$T->str_orangecard_cancel}";
var str_orangecard_confirm="{$T->str_orangecard_confirm}";
var str_orangecard_not_empty="{$T->str_orangecard_not_empty}";

//当前为正面还是反面('FRONT','BACK')
var DATA_KEY='FRONT';
//var isEditPage=true;
//全局数据
var data=JSON.parse('{$data}');
if (!data || !data[DATA_KEY]){
	//isEditPage=false;
	data={};
	data['FRONT']={};
	data['BACK']={};
}
var REQUIRED=JSON.parse('{$required}');//必填添加的卡属性

//7B字体大小和颜色
var fontSizes7BData=JSON.parse('{$fontSizes7BJson}');
var fontColors7BData=JSON.parse('{$fontColors7BJson}');

//当前模板UUID
var cardId="{$cardId}";
var URL_BARCODE="{:U('/')}"+'images/barcode.png';
var URL_SAVEIMG="{:U('Appadmin/OraMembershipCard/saveCard')}";
var URL_UPLOAD="{:U('Appadmin/OraMembershipCard/uploadImg')}";
var URL_HEARTBEAT="{:U('Appadmin/OraMembershipCard/index')}";
var URL_CARD_CAPTURE="{:U('Appadmin/OraMembershipCard/createCardImg')}";
var URL_SAVE_TMP_TPL="{:U('Appadmin/OraMembershipCard/saveTmpTplData')}";

//从哪里跳转过来的（判断全局模板与否）
var URL_FROM="{$fromUrl}";
//电话图标（添加包含【电话】关键字的卡属性时用到）
var SRC_PHONE="__PUBLIC__/images/ic_card_back_phone.png";

//画板(正反两个)
var $canvases=$('.cardEditorFront, .cardEditorBack');
//当前画板
var $canvas=$canvases.eq(0);
//画板容器
var $canvaswrap=$('orcanvaswrap');

//显示对齐线的canvas
var $webcanvas=$('#webcanvas');
var webcanvas = document.getElementById('webcanvas')
var webcanvasCtx = webcanvas.getContext('2d');

//面板组件
var $width=$('#width'),$height=$('#height'),$opacity=$('#opacity'),$rotation=$('#rotation'),$color=$('#color'),
	$font=$('#font'),$size=$('#size'),$colorLabel=$('#colorLabel'),$colorStyle=$('#colorStyle'),$transparent=$('#transparent'),
	$left=$('#left'),$center=$('#center'),$right=$('#right'),
	$bold=$('#bold'),$italic=$('#italic'),$underline=$('#underline'),
	$bgVisible=$('#bgVisible'),$tabTxt=$('#tab_txt'),$tabImg=$('#tab_img'),$tabIcon=$('#tab_icon'),
	$tip=$('.x_y'),$transparent=$('#transparent'),$bgVisible=$('#bgVisible'),$rotateSlider=$('#rotateSlider'),
	$x=$('#x'),$y=$('#y'),$fontSelect=$('.edit_warmp .edit_text:first'),$fontSizeSelect=$('.edit_warmp .edit_text:eq(1)'),
	$colorSelect7B=$('.edit_color:last')
	;
	
//选中的元素,停止main interval, 坐标xy同步
var $active, IS_STOP_UPDATE, IS_STOP_XY;

//元素默认zindex
var ZORDER_BG    = 10;
var ZORDER_IMG   = 11;
var ZORDER_ICON  = 12;
var ZORDER_LABEL = 13;
var ZORDER_DRAW  = 14;

//图片放大旋转图标
var _imgCorner = '/images/cardEditor/corner.png';
var _imgSide   = '/images/cardEditor/side.png';

//默认字体
var DEFAULT_FONT='{$defaultFont}';
//模板方向(landscape, portrait)
var ORIENTATION=(!data[DATA_KEY]['TEMP'] || data[DATA_KEY]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait';
$canvases.attr('orientation', ORIENTATION);

//模板宽高
var WIDTH="{$width}"-'';
var HEIGHT="{$height}"-'';

//var IS_DOUBLE_SIZE=($(window).width()>=1890);
//画板是否为双倍大小
var IS_DOUBLE_SIZE=false;
if (IS_DOUBLE_SIZE){
	$canvases.css({width:WIDTH,height:HEIGHT});
} else {
	$canvases.css({width:WIDTH/2,height:HEIGHT/2});
}
$canvaswrap.css({width:$canvases.width(),height:$canvases.height()});
$webcanvas.attr({width:$canvases.width(),height:$canvases.height()});

if (ORIENTATION=='portrait'){
	$('#landscape').removeClass('bgcolor');
	$('#portrait').addClass('bgcolor');
}

$(function(){
	$.editTemplateStyle.init();

	//进入页面默认显示正面还是反面
	var isBackFirst="{$isBackFirst}";
	if (isBackFirst){
		$('#back').click();
	}
});
</script>
