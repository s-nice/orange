	<layout name="Layout" />
	<div class="warp_tongs" id="search_result_list">
		<empty name="list">
	        <div class="nodata_div"><h1>什么情况？ 橙脉库里居然没找到和“{$keywords}”有关的人！</h1></div>
	    <else />
			<foreach name="list" item="val">
			<div class="warp_tongs_list js_report_click" userId="{:$_SESSION[MODULE_NAME]['clientid']}" vcardId="{$val['uuid']}" cardOwnerId="{$val['account_id']}">
				<div class="warp_tongs_pic"><img src="{$val['picture']}" srca="{$val['pic_path_a']}"  srcb="{$val['pic_path_b']}" /></div>
				<div class="warp_mask maskanimation"></div>
				<div class="warp_tongs_text warp_tongs_animation js_highlight_keyword">
					<span><i>{$val['FN']|mb_substr=###,0,11,'utf-8'}</i><em>{$val['TITLE']|mb_substr=###,0,18,'utf-8'}</em></span>
					<p>{$val['ORG']|mb_substr=###,0,35,'utf-8'}</p>
					<p>{$val['ADR']|mb_substr=###,0,16,'utf-8'}</p>
				</div>
              <if condition="$val['account_id'] neq ''">
              <!-- 标明是系统用户， 显示头像 -->
                <div class="thumb_icon"></div>
              </if>
			</div>
	    </foreach>
		</empty>
	    <div class="clear"></div>
		<!-- 翻页效果引入 -->
		<include file="@Layout/pagemain" />
	</div>

	<script type="text/javascript">
    $(function () {
        $.demo.highlightKeyword();
    });
	</script>
