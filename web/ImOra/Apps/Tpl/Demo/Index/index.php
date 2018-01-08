<layout name="Layout" />
<div class="warp_erdrm" id="warp_erdrm">
    <empty name="list">
        <div class="nodata_div"><h1>您还没有二度人脉， 赶快多加些朋友吧！</h1></div>
    <else />
        <foreach name="list" item="val">
            <section class="warp_card_list js_report_click" userId="{:$_SESSION[MODULE_NAME]['clientid']}" vcardId="{$val['uuid']}" cardOwnerId="{$val['clientid']}">
                <div class="warp_card_pic">
                <img src="{$val['picture']}" srca="{$val['picpatha']}" srcb="{$val['picpathb']}" />
              <if condition="$val['clientid'] neq ''">
              <!-- 标明是系统用户， 显示头像 -->
                <div class="thumb_icon"></div>
              </if>
                </div>
                <div class="warp_card_text">
                    <span><i>{$val['contactname']|mb_substr=###,0,9,'utf-8'}</i><em>{$val['position']|mb_substr=###,0,14,'utf-8'}</em></span>
                    <p>{$val['company']|mb_substr=###,0,28,'utf-8'}</p>
                    <p>{$val['address']|mb_substr=###,0,29,'utf-8'}</p>
                </div>
            </section>
        </foreach>
    </empty>
    <div class="clear"></div>
    <!-- 翻页效果引入 -->
    <include file="@Layout/pagemain" />
</div>
