<layout name="../Layout/Company/AdminLTE_layout" />
<!-- 正文内容部分 star -->
    <div class="Authorize_box">
        <div class="company_Authorize">
            <div class="Authorize_title"><span class="left">{$T->str_accredit_bought}：<i><empty name="accreditnum">0<else />{$accreditnum}</empty></i>个</span>
                <em class="right">
                    <a href="{:U(MODULE_NAME.'/Index/buyOrRenew')}"><input type="button" value="{$T->str_accredit_buy}" /></a>
                </em>
            </div>
            <notempty name="list['list']">
                <foreach name="list['list']" item="val">
                <div class="Authorize_list">
                    <div class="list_title"><span class="left">{$T->str_accredit_discrib_no}[{$val['residuenum']}]个</span><em class="right">{$T->str_accredit_expire_time}：{$val['exprietime']|date='Y-m-d',###}</em></div>
                    <div class="list_c">
                        <div class="left left_list">
                            <p>{$T->str_accredit_number}：{$val['authorizenum']}</p>
                            <p>{$T->str_accredit_card_number}：{$val['storagenum']}</p>
                            <p>{$T->str_accredit_length_time}：{$val['length']}{$T->str_accredit_year}</p>
                        </div>
                        <div class="right right_list">
                            <p>{$T->str_accredit_buy_time}：{$val['buytime']|date='Y-m-d',###}</p>
                            <a href="{:U(MODULE_NAME.'/Index/buyOrRenew',array('id'=>$val['authorid'],'t'=>7))}"><input type="button" data-id="{$val['authorid']}" id="js_renew" value="{$T->str_accredit_renew}" /></a>
                        </div>
                    </div>
                </div>
                </foreach>
            <else />
                No data !!!
            </notempty>
        </div>
        <div class="page">
            {$pagedata}
        </div>
    </div>
<!-- 正文内容部分  end-->