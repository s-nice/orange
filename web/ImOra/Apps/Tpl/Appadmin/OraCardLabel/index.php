<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="search_label">
                <div class="search_right">
					<input id="js_search_val" type="text" <if condition="isset($params['tag'])"> value="{$params['tag']}"</if> placeholder="{$T->str_orange_label_input}"><button type="button" id="js_label_search"></button>
				</div>
			</div>
				<div class="label_card_type_list">
                    <ul class="js_card_type_list">
						<foreach name="cardTypesList" item="cardType">
							<li val="{$cardType['id']}" title="{$cardType['firstname']}"
							<if condition="$cardType['id'] eq $params['cardtypeid']" > class='on'</if>>{$cardType['firstname']}</li>
						</foreach>
                    </ul>
                </div>

			<div class="rank_style">
				<h5>{$T->str_orange_label_type}</h5>
				<ul class="rank_tab js_label_type_wrap">
					<li class="js_label_type none_hover on" type-id="all"><h6>{$T->str_orange_label_all}</h6></li>
					<li class="left_btn" id="js_left_btn"><b class="left_l l_color"></b></li>
					<if condition="isset($typelist) && $typelist['status'] eq 0 ">
						<volist name="typelist['data']['list']" id="vo">
							<if condition="$key lt 5">
								<li class="js_label_type" type-id="{$vo.id}"><h6 title="{$vo.name}">{$vo.name}</h6><i class="i_edit js_edit_type"><img src="__PUBLIC__/images/icon_pencil-edit.png" ></i><i class=" js_del_type i_remove">X</i></li>
								<else/>
								<li class="js_label_type" type-id="{$vo.id}" style="display: none" title="{$vo.name}"><h6>{$vo.name}</h6><i class="i_edit js_edit_type"><img src="__PUBLIC__/images/icon_pencil-edit.png" ></i><i class=" js_del_type i_remove">X</i></li>
							</if>
						</volist>
						<else/>
						{$T->str_orange_label_get_type_fail}
					</if>
					<li class="left_btn right_btn" id="js_right_btn"><b class="right_l"></b></li>
					<li class="rank_add_label" id="js_add_label_type">+{$T->str_orange_label_type}</li>
				</ul>
				<div class="rank_list_l clear" id="js_wrap_main">
					<div class="rank_title_l">
						<span class="span_span11">
							<i id="js_allselect"></i>
							{$T->str_orange_label_select_all}
						</span>
						<div class="label_change">
							<button type="button" class="button_disabel" id="js_del_label" disabled="disabled">{$T->str_orange_label_del}</button>
							<button type="button" class="button_disabel"  id="js_edit_label" disabled="disabled">{$T->str_orange_label_edit}</button>
							<button type="button" class="button_disabel" id="js_add_label" disabled="disabled">+{$T->str_orange_label}</button>
						</div>
					</div>
					<div class="rank_list_content js_label_list_wrap" type-id="all" load-p="1" numfound="{:$labellist['status']==0 ? $labellist['data']['numfound'] : 0}" >
						<if condition="isset($labellist) && $labellist['status'] eq 0 ">
							<volist name="labellist['data']['list']" id="vo">
								<div class="rank_label">
						        	<span class="span_span11">
							        	<i class="js_select" type-id="{$vo.typeid}" data-id="{$vo.id}" data-name="{$vo.tag}" ></i>
					        		</span>
									<em title="{$vo.tag}" class="js_label_name" title="{$vo.tag}">{$vo.tag}</em>
								</div>

							</volist>
							<else/>
							{$T->str_orange_label_get_list_fail}
						</if>
						<!--	<div class="rank_label">
                                <span class="span_span11">
                                    <i class="js_select"></i>
                                </span>
                                <em class="js_label_name">工商</em>
                            </div>-->

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--添加标签弹类型弹框-->
<div class="show_label" id="js_add_type_box">
	<div class="margin_box">
		<h5>{$T->str_orange_label_type_name}</h5>
		<input class="js_box_input" type="text">
		<div class="eidt_label_btn">
			<button class="btn_left button_disabel js_submit_button js_submit_label_type" type="button"  disabled="disabled">{$T->str_orange_label_confirm}</button>
			<button type="button" class="js_box_cancel">{$T->str_orange_label_cancel}</button>
		</div>
	</div>
</div>
<!--添加和修改标签弹框-->
<div class="show_label" id="js_add_label_box">
	<div class="margin_box">
		<h5>{$T->str_orange_label_name}</h5>
		<input class="js_box_input" type="text">
		<div class="eidt_label_btn">
			<button class="btn_left button_disabel js_submit_button" type="button" id="js_submit_label" disabled="disabled">{$T->str_orange_label_confirm}</button>
			<button type="button" class="js_box_cancel">{$T->str_orange_label_cancel}</button>
		</div>
	</div>
</div>
<script>
	var gCardtypeid="{$params['cardtypeid']}";
	var gMaxNum=20;//每页显示最多标签数
	var gName="{$params['tag']}";
	var gUrl="{:U('Appadmin/OraCardLabel/index','','html','',true)}";
	var gAddFailMsg="{$T->str_orange_label_add_fail}";
	var gConfirmMsg="{$T->str_orange_label_confirm}";
	var gCancelMsg="{$T->str_orange_label_cancel}";
	var gDelConfirmMsg="{$T->str_orange_label_del_confirm}";
	var gDelFailMsg="{$T->str_orange_label_del_fail}";
	var gLoadingFailMsg="{$T->str_orange_label_loading_fail}";
	var gMaxLengthFailMsg="{$T->str_orange_label_max_length_fail}";
	var gExistTypeMsg="{$T->str_orange_label_type_exist_fail}";
	var gExistMsg="{$T->str_orange_label_exist_fail}";
	var gAddStr="{$T->str_orange_label_add}";
	var gEditStr="{$T->str_orange_label_edit}";
	var gLabelStr="{$T->str_orange_label}";
	var gStr="{$T->str_orange_label_fail}";

	$(function(){
		$.orangeLabel.init();
	});

</script>