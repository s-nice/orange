<layout name="../Layout/Company/AdminLTE_layout" />
<style>

/*选中字体OR字号背景色*/
.text_style span.active, .cardp_fonts ul li.active, .cardp_fonts ul li:hover, .cardp_fonts_px ul li.active, .cardp_fonts_px ul li:hover, .cardp_css *.active{background-color:#ccc;}

/*删除按钮点中状态*/
.bgred{background-color:red !important;color:white !important;}

/*加载一个默认字体
@font-face {font-family: 'FZLTDHJW';src: url('/fonts/new/FZLTDHJW.TTF') format('truetype');}*/

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
orcanvas ortextwrap.active{border:1px dotted black;}
orcanvas ortextwrap ortext{display:inline-block;word-break:keep-all;white-space: nowrap;position:relative;}

orcanvas orimgwrap{position:absolute;display:block;top:0;left:0;}
orcanvas orimgwrap orimg{position:relative;display:block;border:1px solid transparent;}
orcanvas orimgwrap.active orimg{border:1px dotted black;}
orcanvas orimgwrap orimg .img{position:relative;}
orcanvas orimgwrap orimg .corner{position:absolute;right:-20px;bottom:-20px;display:none;}
orcanvas orimgwrap orimg .side{position:absolute;right:-20px;top:50%;margin-top:-10px;display:none;}

orcanvas orbg{position:absolute;top:0;left:0;z-index:0;width:100%;height:100%;display:block;}
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

.img_rotate90{ -moz-transform:rotate(90deg); -webkit-transform:rotate(90deg); -ms-transform:rotate(90deg); -o-transform:rotate(90deg); transform:rotate(90deg);}

</style>
<tip id='tip'>111</tip>
<div class="cardpage_warp">
	<div class="cardpage_pad">
		<div class="cardpage_padleft">
			<div class="cardpage_xzmb cardpage14 hand">选择模板</div>
			<div class="row">
				<div class="col-md-12">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a id='tab_txt' href="#tab_1" data-toggle="tab" aria-expanded="true">文字</a></li>
							<li class=""><a id='tab_img' href="#tab_2" data-toggle="tab" aria-expanded="false">图片</a></li>
							<li class=""><a id='tab_bg' href="#tab_3" data-toggle="tab" aria-expanded="false">背景</a></li>
							<li class=""><a id='tab_icon' href="#tab_4" data-toggle="tab" aria-expanded="false">素材</a></li>
						</ul>
						<div class="tab-content">
							<div id="tab_1" class="tab-pane active">
								<div class="row">
									<div class="col-md-8 cardpage_btn">
										<span class="cardpage_14 yuanjiao_input on hand">中文</span>
										<span class="cardpage_14 yuanjiao_input hand">英文</span>
									</div>
									<div class="col-md-4 cardpage_ri">
										<label class="cardpage_14">显示标签<input id='checkall' type="checkbox" autocomplete='off' /></label>
									</div>
								</div>
								<div class="row" style="display:block">
									<div class="col-md-12 cardpage_list hand" id='name' datatype='name' val='张三'>
										<span class="cardpage_pub14">姓名</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='nameLabel' datatype='name'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='department' datatype='department' val='市场营销部门'>
										<span class="cardpage_pub14">部门</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='departmentLabel' datatype='department'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='job' datatype='job' val='销售经理'>
										<span class="cardpage_pub14">职位</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='jobLabel' datatype='job'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='company_name' datatype='company_name' val='{$companyName}'>
										<span class="cardpage_pub14">公司名称</span>
										<i><input type="checkbox" autocomplete='off' id='company_nameLabel' datatype='company_name'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='mobile' datatype='mobile' val='13812345678'>
										<span class="cardpage_pub14">手机</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='mobileLabel' datatype='mobile'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='telephone' datatype='telephone' val='010-9876543'>
										<span class="cardpage_pub14">电话</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='telephoneLabel' datatype='telephone'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='fax' datatype='fax' val='010-1234567'>
										<span class="cardpage_pub14">传真</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='faxLabel' datatype='fax'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='email' datatype='email' val='zhangsan@163.com'>
										<span class="cardpage_pub14">邮箱</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='emailLabel' datatype='email'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='web' datatype='web' val='{$companyWebSite}'>
										<span class="cardpage_pub14">网址</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='webLabel' datatype='web'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='address' datatype='address' val='{$companyAddress}'>
										<span class="cardpage_pub14">详细地址</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='addressLabel' datatype='address'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='selfdef' datatype='selfdef'>
										<span class="cardpage_pub14">自定义内容</span>
									</div>
									<div class="clear"></div>
								</div>
								<div class="row" style="display:none">
									<div class="col-md-12 cardpage_list hand" id='name1' datatype='name1' val='Zhang San'>
										<span class="cardpage_pub14">Name</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='nameLabel1' datatype='name1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='department1' datatype='department' val='Marketing Dept'>
										<span class="cardpage_pub14">Department</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='departmentLabel1' datatype='department1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='job1' datatype='job' val='Sales manager'>
										<span class="cardpage_pub14">Title</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='jobLabel1' datatype='job1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='mobile1' datatype='mobile' val='13812345678'>
										<span class="cardpage_pub14">Mob</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='mobileLabel1' datatype='mobile1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='telephone1' datatype='telephone' val='010-9876543'>
										<span class="cardpage_pub14">Tel</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='telephoneLabel1' datatype='telephone1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='fax1' datatype='fax' val='010-1234567'>
										<span class="cardpage_pub14">Fax</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='faxLabel1' datatype='fax1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='email1' datatype='email' val='zhangsan@163.com'>
										<span class="cardpage_pub14">Email</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='emailLabel1' datatype='email1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='web1' datatype='web' val='{$companyWebSite}'>
										<span class="cardpage_pub14">Web</span>
										<i><input type="checkbox" type='checkbox' autocomplete='off' id='webLabel1' datatype='web1'/></i>
									</div>
									<div class="col-md-12 cardpage_list hand" id='selfdef1' datatype='selfdef'>
										<span class="cardpage_pub14">Other</span>
									</div>
									<div class="clear"></div>
								</div>
								<div class="cardpage_editor">
									<div class="cardp_editor_icon"><img src="__PUBLIC__/images/companycard/company_icon_editor.png" /></div>
									<div class="cardp_fonts hand" style='height:auto;'>
										<span>字体</span>
										<i></i>
										<input type='hidden' id='font' autocomplete='off'>
										<ul id='fontList' style='height:auto;' class='hand'>
                                            <foreach name="fonts" item="v" key="k">
                                            <li id='{$k}' val='{$k}'>{$v}</li>
                                            </foreach>
										</ul>
									</div>
									<div class="cardp_fonts_px hand" style='height:auto;'>
										<span>字号</span>
										<i></i>
										<input type='hidden' id='size' autocomplete='off'>
										<ul id='fontSizeList' style='height:200px;overflow-y:scroll' class='hand'>
											<li val='10'>10px</li>
										</ul>
									</div>
									<div class="cardp_center">
										<span class="fonts_style">对齐方式</span>
										<div class="text_style">
											<span id="left" class="text_left"><i></i></span>
											<span id="center" class="text_center"><i></i></span>
											<span id="right" class="text_right"><i></i></span>
										</div>
									</div>
									<div class="cardp_css">
										<span>样式</span>
										<p class='hand'>
											<b class="text_bold" id='bold'>Bold</b>
											<i class="text_italic" id='italic'>Italic</i>
											<u id='underline'>Underline</u>
										</p>
									</div>
									<div class="cardp_bgcolor" style='height:auto;'>
										<span>颜色</span>
										<div class="bgcolor_r" style='height:auto;'>
											<input id='colorLabel' type="text" autocomplete='off' class="jscolor{valueElement:'colorLabel', styleElement:'colorLabelStyle'}" value="000000"/>
											<em id='colorLabelStyle' class="yuanjiao_input hand"></em>
										</div>
									</div>
								</div>
							</div>
							<div id="tab_2" class="tab-pane">
								<div class="cardp_sc">
									<input type="file" name='img' id='imgFile' class='hand'/>
									<div id='uploadBtn' class="cardp_text yuanjiao_input" title='上传图片'>上传图片</div>
								</div>
								<foreach name="imgList" item="v" key="k">
								    <div class="cardpage_pic hand" style='text-align:center'>
    									<span><img src="__PUBLIC__{$v}" height=168 /></span>
    									<i class="cardp_d"></i>
    								</div>
								</foreach>
								<!--
								<div class="cardpage_pic">
									<span><img src="__PUBLIC__/images/companycard/company_cardpic.png" /></span>
									<i class="cardp_d"></i>
									<i class="cardp_e"></i>
								</div> -->
							</div>
							<div id="tab_3" class="tab-pane">
                                <div class="cardp_sc">
									<input type="file" name='img' id='bgFile' class='hand'/>
									<div id='uploadBtn2' class="cardp_text yuanjiao_input" title='上传背景'>上传背景</div>
								</div>
								<foreach name="bgList" item="v" key="k">
								    <div class="cardpage_pic hand" style='text-align:center'>
    									<span><img src="__PUBLIC__{$v}" height=168 /></span>
    									<i class="cardp_d"></i>
    								</div>
								</foreach>
								<div class="cardpage_label"><label><input type="checkbox" id='bgVisible' autocomplete='off'/>显示背景</label></div>
								<div class="cardpage_f_a">
								    <?php 
								    for ($i = 0; $i < 6; $i++) {
								        $num=$i+1;
								        if (empty($typeImgs[$i])){
								            echo "<div class='col-md-6' style='display: none;' type='$num'><i class='text'>方案$num</i><i><img><b></b></i></div>";
								        } else {
								            $src=$typeImgs[$i];
								            echo "<div class='col-md-6' style='' type='$num'><i class='text'>方案$num</i><i><img src='$src'><b></b></i></div>";
								        }
								    }
								    ?>
								</div>
							</div>
							<div id="tab_4" class="tab-pane">
								<div class="cardp_text yuanjiao_input">形状</div>
								<div class="row cardpage_xz">
                                    <foreach name="icons" item="v" key="k">
                                        <div class="col-md-2"><i class='hand'><img type='icon' src="__PUBLIC__/images/companycard/company_icon_xz.png" s="{$v}" num="{$k}"/></i></div>
                                    </foreach>								    
								    <!-- 
									<div class="col-md-2"><i class='hand'><img type='icon' src="__PUBLIC__/images/companycard/company_icon_xz.png" s="/images/cardEditor/icon.png"/></i></div>
									<div class="col-md-2"><i class='hand'><img type='icon' src="__PUBLIC__/images/companycard/company_icon_xz.png" s="/images/cardEditor/icon2.png" /></i></div>
									<div class="col-md-2"><i class='hand'><img type='icon' src="__PUBLIC__/images/companycard/company_icon_xz.png" s="/images/cardEditor/2.png" /></i></div> -->
								</div>
								<div class="cardp_xiant yuanjiao_input">线条</div>
								<div id='imageEditPanel'>
    								<div class="cardpage_kg">
    									<span><i><label>宽</label><input type="text" id='width' autocomplete='off'/></i><em><label>高</label><input type="text" id='height' autocomplete='off'/></em></span>
    								</div>
    								<div class="cardpage_opactiy">
    									<span>透明</span>
    									<div class="opacity_c">
    										<i>0</i>
    										<div class="opactiy_box">
    											<div class="opacity_bgc"></div>
    											<div id='opacityBarBtn' class="opacity_button hand" type='opacity' style='left:240px;'></div>
    											<input type='hidden' id='opacity' autocomplete='off'/>
    										</div>
    										<em>100</em>
    									</div>
    								</div>
    								<div class="cardpage_opactiy">
    									<span>旋转</span>
    									<div class="opacity_c">
    										<i>0</i>
    										<div class="opactiy_box">
    											<div class="opacity_bgc"></div>
    											<div id='rotateSlider' class="opacity_button hand" type='rotate'></div>
    											<input type='hidden' id='rotation' autocomplete='off'>
    										</div>
    										<em>360</em>
    									</div>
    								</div>
    								<div class="cardp_bgcolor">
    									<span>颜色</span>
    									<div class="bgcolor_r">
    									    <button id='transparent' style="float:left;margin-top:2px">透明</button>
    										<input id='color' type="text" autocomplete='off' class="jscolor{valueElement:'color', styleElement:'colorStyle'}" value="none"/>
    										<em id='colorStyle' class="yuanjiao_input hand"></em>
    									</div>
    								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="cardpage_padright">
			<div class="row cardpage_c">
				<div class="col-md-3">
					<div class="col-md-6"><i id='landscape' class="cardpage_14 yuanjiao_input bgcolor hand">横版</i></div>
					<div class="col-md-6"><i id='portrait' class="cardpage_c14 yuanjiao_input hand">竖版</i></div>
				</div>
				<div class="col-md-4 cardpage_b">
					<div class="col-md-6"><i id='front' class="cardpage_14 yuanjiao_input bgcolor hand">编辑正面</i></div>
					<div class="col-md-6"><i id='back' class="cardpage_c14 yuanjiao_input hand">编辑反面</i></div>
				</div>
				<div class="col-md-3">
					<div class="col-md-6"><i id='up' class="cardpage_14 yuanjiao_input hand">上移</i></div>
					<div class="col-md-6"><i id='down' class="cardpage_c14 yuanjiao_input hand">下移</i></div>
				</div>
				<div class="col-md-1"><i id='del' class="cardpage_14 yuanjiao_input hand">删除</i></div>
			</div>
			<div class="row cardpage_p">
				<div class="col-md-12 cardpage_w" style='padding:0;text-align:center;'>
				    <orcanvaswrap>
    				    <orcanvas class='cardEditorFront'></orcanvas>
    				    <orcanvas class='cardEditorBack'></orcanvas>
    				    <canvas id='webcanvas' style='opacity:0;'></canvas>
				    </orcanvaswrap>
				</div>
				<div class="cardpage_bin clear">
					<div class="pull-left zhushi">注：图片只支持上传jpg、jepg和png格式图片，最大不可以超过2M.<br>系统图片长宽比为：{$width}-{$height}</div>
					<div class="box-footer cardpage">
						<button data-loading-text="图片生成中..." class="btn btn-info button_bgcolor" type="submit" id='preview' autocomplete='off'>预览</button><br>
						<button data-loading-text="保存中..." class="btn btn-info button_bgcolor" type="submit" id='submit' autocomplete='off'>保存</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 自定义内容窗口 -->
<div class="modal fade" id="selfdef_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">自定义标签</h4>
			</div>
			<div class="modal-body">
                <form class="form-inline" role="form">
                <div class="form-group">
				<select id="selfdef_type" class='form-control select2' autocomplete='off'>
					<option value="text" textzh='文本' texten='Text'>文本</option>
					<option value="telephone" textzh='电话' texten='Tel'>电话</option>
					<option value="email" textzh='邮箱' texten='Email'>邮箱</option>
					<option value="web" textzh='网址' texten='Web Site'>网址</option>
					<option value="address" textzh='详细地址' texten='Address'>详细地址</option>
					<option value="company_name" textzh='公司名称' texten='Company Name'>Company Name</option>
				</select>
				</div>
				<div class="form-group">
				<label class='checkbox-inline'><input type='checkbox' autocomplete='off'>显示标签</label>
				</div>
				<div class="form-group">
				<input type='text' class="form-control" placeholder="请输入内容" autocomplete='off'>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" datatype='selfdef'>确定</button>
			</div>
		</div>
	</div>
</div>
<!-- 删除确认窗口 -->
<div class="modal fade" id="confirm_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">警告</h4>
			</div>
			<div class="modal-body"><h3>确定删除</h3></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-danger" id='itemDelete'>确定</button>
			</div>
		</div>
	</div>
</div>
<!-- 预览窗口 -->
<div class="modal fade" id="preview_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">预览</h4>
			</div>
			<div class="modal-body">
                <img id='previewImg1' src="" width=570 height=320 style='border:1px solid #ccc;'>
                <img id='previewImg2' src="" width=570 height=320 style='border:1px solid #ccc;'>
			</div>
		</div>
	</div>
</div>
<!-- 选择模板窗口 -->
<div class="modal fade" id="template_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content bg_card">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title card_title" id="myModalLabel">名片模板选择:</h4>
			</div>
			<div class="modal-body">
	            <div class="lable_box">
					<div class="label_left">
						<span><b class="text_color" sort='totalnum'>人气最高</b>|<b sort='createdtime'>最新方案</b></span>
						<label><input type="checkbox" ori='0'>横版</label>
						<label><input type="checkbox" ori='1'>竖版</label>
					</div>
					<div class="label_right">
						<em><page>1</page>/<page>20</page></em>
						<span><</span>
						<span>></span>
					</div>
	            </div>
	            <div class="card_way">
					<div class="way_top" style='display:none;'>
						<div class="way_left" style='display: none;'>
							<div class="way_btn">
								<span class='active' type='1'>方案1</span>
								<span type='2'>方案2</span>
								<span type='3'>方案3</span>
								<span type='4'>方案4</span>
								<span type='5'>方案5</span>
								<span type='6'>方案6</span>
							</div>
							<div class="way_card">
								<div class="card_style"><img style='width: 333px;height:140px;'></div><!-- card_left 158 298 -->
								<div class="card_style"><img style='width: 333px;height:140px;'></div>
							</div>
							<div class="card_btn" type='1'>选择编辑</div>
						</div>
						<div class="way_left" style='display: none;'>
							<div class="way_btn">
								<span class='active' type='1'>方案1</span>
								<span type='2'>方案2</span>
								<span type='3'>方案3</span>
								<span type='4'>方案4</span>
								<span type='5'>方案5</span>
								<span type='6'>方案6</span>
							</div>
							<div class="way_card">
								<div class="card_style"><img style='width: 333px;height:140px;'></div>
								<div class="card_style"><img style='width: 333px;height:140px;'></div>
							</div>
							<div class="card_btn" type='1'>选择编辑</div>
						</div>
					</div>
					<div id='sysloading' style='text-align:center;height:30px;'><span>加载中...</span></div>
	            </div>
			</div>
		</div>
	</div>
</div>
<!-- 
<div style='display:none;' id='fontPanel'>显示客户</div>
<div style='display:none;' id='FZLTDHJW1'>{$FZLTDHJW}</div>
<div style='display:none;' id='FZLTHJW1'>{$FZLTHJW}</div>
<div style='display:none;' id='FZLTZCHJW1'>{$FZLTZCHJW}</div>
<div style='display:none;' id='FZRBSJW1'>{$FZRBSJW}</div>
<div style='display:none;' id='FZXHJW1'>{$FZXHJW}</div>
<div style='display:none;' id='FZXZZBJW1'>{$FZXZZBJW}</div>
<div style='display:none;' id='FZZHUNYSJW1'>{$FZZHUNYSJW}</div>
<div style='display:none;' id='FZZJ-DYKTJW1'>{$FZZJDYKTJW}</div>
<div style='display:none;' id='FZZJ-ZSCWBJW1'>{$FZZJZSCWBJW}</div>
<div style='display:none;' id='FZZJ-ZTGBXSJW1'>{$FZZJZTGBXSJW}</div>

<div style='opacity:0;font-family:DFKAI5A;'   id='DFKAI5A'>{$DFKAI5A}</div>
<div style='opacity:0;font-family:DFSHAONV5;' id='DFSHAONV5'>{$DFSHAONV5}</div>
<div style='opacity:0;font-family:DFHEI5A;'   id='DFHEI5A'>{$DFHEI5A}</div>
<div style='opacity:0;' id='testHuakang'></div>

<div style='display:none;line-height:30px;' onclick="jsgendfo();">设置字体</div> 
<script type="text/javascript" src="http://cdn1.foundertype.com/webfont/js/ftfont-init.js"></script>
<script type="text/javascript" src="https://dfo.dynacw.com.cn/DFO_SDK/js/dfo.js"></script>-->
<script type="text/javascript">

//当前为正面还是反面('FRONT','BACK')
var DATA_KEY='FRONT';
var isEditPage=true;
//全局数据
var data=JSON.parse('{$data}');
var REPLACABLE_IMAGES=[];
var rImgs='{$rImgs}';
if (rImgs){
	REPLACABLE_IMAGES=JSON.parse(rImgs);
}

var SYSTPL_BASEURL='{$sysbaseurl}';
var SYSID='{$sysid}';
var SYSTYPE='{$systype}';

if (!data[DATA_KEY]){
	isEditPage=false;
	data['FRONT']={};
	data['BACK']={};
}

//名片的正反面截图
var _canvasImages={
	'FRONT': '{$frontImg}',
	'BACK': '{$backImg}'
};

//当前模板UUID
var cardId="{$cardId}";

var URL_SAVEIMG="{:U('Company/CompanyInfo/saveCard2')}";
var URL_UUID="{:U('Company/CompanyInfo/getUUID')}";
var URL_UPLOAD="{:U('Company/CompanyInfo/uploadImg')}";
var URL_HEARTBEAT="{:U('Company/CompanyInfo/index')}";
var URL_CARD_CAPTURE="{:U('Company/CompanyInfo/createCardImg')}";
var URL_CARD_LIST="{:U('Company/CompanyInfo/cardList')}";
var URL_SYSTEMP_LIST="{:U('Company/CompanyInfo/sysTemplates')}";
var URL_SYSTEMP_LOAD="{:U('Company/CompanyInfo/sysTemplatesLoad')}";
var URL_GET_SYSTPLDATA="{:U('Company/CompanyInfo/sysTemplateData')}";
var PAGESIZE=parseInt("{$pagesize}");

//画板
var $canvases=$('.cardEditorFront, .cardEditorBack');
var $canvas=$canvases.eq(0);
var $canvaswrap=$('orcanvaswrap');
var $webcanvas=$('#webcanvas');
var webcanvas = document.getElementById('webcanvas')
var webcanvasCtx = webcanvas.getContext('2d');

var $width=$('#width'),$height=$('#height'),$opacity=$('#opacity'),$rotation=$('#rotation'),$color=$('#color'),
	$font=$('#font'),$size=$('#size'),$colorLabel=$('#colorLabel'),$colorStyle=$('#colorStyle'),$transparent=$('#transparent'),
	$left=$('#left'),$center=$('#center'),$right=$('#right'),
	$bold=$('#bold'),$italic=$('#italic'),$underline=$('#underline'),
	$bgVisible=$('#bgVisible'),$tabTxt=$('#tab_txt'),$tabImg=$('#tab_img'),$tabIcon=$('#tab_icon'),
	$tip=$('#tip'),$transparent=$('#transparent'),$bgVisible=$('#bgVisible'),$rotateSlider=$('#rotateSlider')
	;
	
//选中的元素,停止main interval
var $active, IS_STOP_UPDATE, TIMEOUT;

var ZORDER_BG    = 10;
var ZORDER_IMG   = 11;
var ZORDER_ICON  = 12;
var ZORDER_LABEL = 13;
var ZORDER_DRAW  = 14;

var _imgIcon   = '/images/cardEditor/icon.png';
var _imgCorner = '/images/cardEditor/corner.png';
var _imgSide   = '/images/cardEditor/side.png';
var _imgNone   = '/images/cardEditor/none.png';

var IS_STOP_INTERVAL=false;
var DEFAULT_FONT='{$defaultFont}';
var ORIENTATION=(!data[DATA_KEY]['TEMP'] || data[DATA_KEY]['TEMP']['TEMPORI'] == 0) ? 'landscape' : 'portrait';
$canvases.attr('orientation', ORIENTATION);

var WIDTH="{$width}"-'';
var HEIGHT="{$height}"-'';

var IS_DOUBLE_SIZE=($(window).width()>=1890);
if (IS_DOUBLE_SIZE){
	if (ORIENTATION=='landscape'){
		$canvases.css({width:WIDTH,height:HEIGHT});
	} else {
		$canvases.css({width:HEIGHT,height:WIDTH});
	}
} else {
	if (ORIENTATION=='landscape'){
		$canvases.css({width:WIDTH/2,height:HEIGHT/2});
	} else {
		$canvases.css({width:HEIGHT/2,height:WIDTH/2});
	}
}
$canvaswrap.css({width:$canvases.width(),height:$canvases.height()});
$webcanvas.attr({width:$canvases.width(),height:$canvases.height()});

if (ORIENTATION=='portrait'){
	$('#landscape').removeClass('bgcolor');
	$('#portrait').addClass('bgcolor');
}
/*
FontJSON = { id: "demo", pwd: "demopwd", Font: ["DFKAI5A", "DFSHAONV5", "DFHEI5A"] };
jsgendfo();*/
</script>
