<layout name="../Layout/Layout"/>
<div class="share_card_body">
    <div class="add_share_wrap">
        <div class="Administrator_pop_c">
            <!--  <form  id="js_share_form" method="post" action="{:U('Appadmin/CardShare/confirmShare','',false)}">-->
            <div class="Administrator_user"><span>{$T->str_card_share_original_order}:</span>
                <input name="sourceAccount" id="js_Source_Account" class="js_share_input"
                       value="{:$T->str_card_share_enter.$T->str_card_share_original_order}" type="text"/></div>
            <div class="js_Add_Account">
                <div class="Administrator_user Administrator_number js_Share_Account">
                    <span>{$T->str_card_share_account}<i>1</i>:</span>
                    <input class="js_share_input js_target_Account " name="targetAccount[]" id="" type="text" style="float:left;"/>
                    <i class="js_Add_Account_Icon add_jia safariborder">+</i>
                </div>
            </div>
            <div class="Administrator_liukong"></div>
            <div class="Administrator_bin_b Administrator_masttop">
                <input id="js_share_submit" type="button" class="big_button cursorpointer js_logoutok"
                       value="{$T->str_extend_submit}" style="cursor: pointer;"/>
            </div>
            </form>
        </div>
    </div>
    <include file="CardShare/variable"/>
</div>

