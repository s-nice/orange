<foreach name="cardList" item="vo">
    <div class="scannersection_listshare_c card_list_c list_hover js_x_scroll_backcolor">
        <span class="span_span11"></span>
        <if condition="$vo.picture neq ''">
            <span class="span_span1 js_target_img" path="{$vo.picture}"><img
                    src="/images/editor_img_icon_pic.png"></span>
            <else/>
            <span class="span_span1 ">{$T->str_card_share_none}</span>
        </if>
        <span class="span_span2" title="{$vo.account}">{$vo.account}</span>
        <span class="span_span3" title="{$vo.FN}">{$vo.FN}</span>

            <?php
            $pattern="/(?:CELL:)([\\+\d]+)/";
            preg_match_all($pattern,$vo['TEL'],$matches);
            $_phone= join(",", $matches[1]);
            echo "<span class=\"span_span6\" title=\"$_phone\">$_phone</span>"
            ?>

        <span class="span_span5" title="{$vo.TITLE}">{$vo.TITLE}</span>
        <span class="span_span8" title="{$vo.ORG}">{$vo.ORG}</span>
        <span class="span_span6" title="{$vo.DEPAR}">{$vo.DEPAR}</span>
        <span class="span_span8" title="{$vo.EMAIL}">{$vo.EMAIL}</span>
        <span class="span_span8" title="{$vo.ADR}">{$vo.ADR}</span>
              <?php
              $pattern="/(?:[^CELL]:)([\\+\d]+)/";
              preg_match_all($pattern,$vo['TEL'],$matches);
              $_tel= join(",", $matches[1]);
              echo "<span class=\"span_span2\" title=\"$_tel\" style=\"margin-right:20px\">$_tel</span>";
              ?>
        <span class="span_span12" title="{$vo.createdtime}">{$vo.createdtime}</span>
    </div>

</foreach>
