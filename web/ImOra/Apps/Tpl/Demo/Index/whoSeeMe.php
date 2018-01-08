<layout name="Layout" />
<!-- 好友 star -->
<div class="warp_tongs">
    <empty name="list" >
        <div class="nodata_div"><h1>交几个朋友吧。</h1></div>
    <else />
        <foreach name="list" item="val">
            <div class="warp_tongs_list js_report_click" userId="{:$_SESSION[MODULE_NAME]['clientid']}" vcardId="{$val['vcardid']}" cardOwnerId="{$val['userid']}">
                <div class="warp_tongs_pic"><img src="{$val['picture']}" srca="{$val['picpatha']}" srcb="{$val['picpathb']}" /></div>
                <div class="warp_mask maskanimation"></div>
                <div class="warp_tongs_text warp_tongs_animation">
                    <span class="check_card_time" >{:date('Y-m-d H:i:s', $val['createtime'])} &nbsp;</span>
                    <span><i>{$val['FN']|mb_substr=###,0,11,'utf-8'}</i><em>{$val['TITLE']|mb_substr=###,0,18,'utf-8'}</em></span>
                    <p>{$val['ORG']|mb_substr=###,0,35,'utf-8'}</p>
                    <p>{$val['ADR']|mb_substr=###,0,16,'utf-8'}</p>
                </div>
              <if condition="$val['clientid'] neq ''">
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
<!-- 好友 end -->
