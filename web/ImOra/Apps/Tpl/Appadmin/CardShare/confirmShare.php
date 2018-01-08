<layout name="../Layout/Layout"/>
<div class="share_card_body">
    <div class="share_top_box">
        <div class="sourceAccount">
            <div class="card">
                <span class="cardName" title="{$sourceAccountInfo.name}">{$sourceAccountInfo.name}</span>
                <span title="{$sourceAccountInfo.phone}">{$sourceAccountInfo.phone}</span>
                <span title="{$sourceAccountInfo.title}">{$sourceAccountInfo.title}</span>
                <span title="{$sourceAccountInfo.company}">{$sourceAccountInfo.company}</span>
            </div>

        </div>
        <div class="mid">
            <div class="shareTo">
                <div id="rectangle"></div>
                <div id="triangle-right"></div>
            </div>

        </div>
        <div style="display:table-cell">
            <div class="shareAccount">
                <foreach name="shareAccountList" item="vo">
                    <div class="card">
                        <span class="cardName" title="{$vo.realname}">{$vo.realname}</span>
                        <span title="{$vo.account}">{$vo.account}</span>
                        <span title="{$vo.title}">{$vo.title}</span>
                        <span title="{$vo.company}">{$vo.company}</span>
                    </div>
                </foreach>
            </div>
        </div>
    </div>
    <div class="Administrator_bin_b Administrator_masttop">
        <input class="dropout_inputr cursorpointer js_confirm_share big_button" type="button"
               value="{$T->str_card_share_confirm}"/>
        <input class="dropout_inputl cursorpointer js_share_cancel big_button" type="button" value="{$T->str_card_share_cancel}"/>
    </div>
    <include file="CardShare/variable"/>
</div>
<script>
    var gShareid = {$shareid};

</script>