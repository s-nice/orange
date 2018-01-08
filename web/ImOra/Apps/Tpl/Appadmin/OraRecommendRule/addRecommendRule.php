<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="setting_codex clear h3_float">
				<h5>{$ruleInfo['firstlevelname']} 推荐规则优先级：</h5>
				<div class="codex_info clear">
					<div class="codex_bg"></div>
					<div class="codex_gu js_selected_strategy sortable">
                        <volist name="ruleInfo['rulevals']" id="ruleval">
                            <span data-typename="{$ruleval['tagtypename']}"  data-id="{$ruleval['fromid']}" type-id="{$ruleval['tagtypeid']}" data-cardtypeid="{:('tagtype' == $ruleval['froms'] ? $ruleval['choosecardtypeid'] : $ruleval['choosecardtypeid'])}"
                               title="{:htmlspecialchars('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['cardtypesname'].'-'.$ruleval['name'])}"
                               data-name="{:htmlspecialchars('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}"
                               data-type="{:('strategy' == $ruleval['froms'] ? 'strategy' : 'tag')}">
                              <b>{$i}</b>
                              <em>{:('strategy' == $ruleval['froms'] ? $strategyList[$ruleval['fromid']] : $ruleval['name'])}</em>
                              <i>X</i>
                            </span>
                        </volist>
					</div>
				</div>
			</div>
			<div class="important_label">
                <h5>策略：</h5>
					<div class="move_label important_info clear js_strategy_for_choose">
					  <foreach name="strategyList" key="strategyKey" item="strategyName">
						<span data-type="strategy" data-key="{$strategyKey}" title="{:htmlspecialchars($strategyName)}" data-id="{$strategyKey}"><em>{$strategyName}</em><b>&uarr;</b></span>
					  </foreach>
					</div>
			</div>
	                <div class="important_label js_label_for_choose">
                    <h5>{$T->str_orange_type_tags}：</h5>
                    <div class="big_nav" >
                        <div class="label_card_type_list js_cardtype_mark" id="js_card_type_container" style="max-height: 300px">
                            <div class="nav_bg js_nav_bg" style="display: none;"></div>
                            <ul class="js_card_type_list" >
                                <foreach name="cardTypesList" item="val">
                                    <li <if condition="$val['id'] eq $ruleInfo['id'] " > class="on" </if> val="{$val['id']}">{$val['firstname']}</li>
                                </foreach>
                            </ul>
                        </div>
                        <div class="nav_add_box" id="js_wrap_main">
                            <div class="nav_label">
                                <ul  class=" js_label_type_wrap">
                                    <li class="on js_label_type"  type-id="all">{$T->str_orange_type_all}</li>
                                    <li class="left_btn" id="js_left_btn"><b class="left_l l_color"></b></li>

                                    <li class="left_btn right_btn" id="js_right_btn"><b class="right_l"></b></li>
                                </ul>
                            </div>
                            <div class="move_label important_info clear js_label_list_wrap" type-id="all" load-p="0">
                                <!--  <span><em>工商</em><b>&uarr;</b></span> -->
                            </div>
                        </div>
                    </div>
                </div>
					<div class="codex_btn">
				<button class="big_button"
				     data-url="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/edit',array('id'=>$_GET['id']))}"
				     data-jump="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}"
				     id="save_button" style="margin-right:15px;" type="button">保存</button>
				<button class="big_button" data-url="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}" id="cancel_button"  type="button">取消</button>
			</div>
			<div class="warning_font">
                <h5>推荐策略说明：</h5>
                <p>1、标签：推荐包含某些标签的卡。</p>
                <p>2、日历事件：从最近日历中拿取；若无，则不显示；<br><em>2.1设置在里程卡、航程卡下，推荐包含行程的日历信息。</em></p>
                <p>3、相关地点：当前位置直径1公里的商户会员卡。<br><em>3.1设置在日历卡下，则是基于日历描述中的位置直径1公里的商户会员卡。</em><br><em>3.2设置在航程卡下，则推荐包含起落机场的商户会员卡。</em></p>
            </div>
		</div>
	</div>
</div>
	<script>
		var gGetLabelUrl = "{:U('Appadmin/Common/getOraLabel','','','',true)}";
		var gGetLabelTypeUrl="{:U('Appadmin/Common/getOraLabelType','','','',true)}";
        var URL_FROM = "{$_SERVER['HTTP_REFERER']}";//上级路径
		$(function(){
            //标签部分js;
			$.popLabel.init(2,<?php
                if(in_array($ruleInfo['id'],array(1,2,3,4,5,6,7,8,15,16,17,18,19))){ //规定的卡模板id
                    echo $ruleInfo['id'];
                }else{
                    echo 0;
                }
                ?>);
            $.OraRecommendRule.init();
		})

	</script>