<script>
    var gCancelUrl = "{:U('Appadmin/CardShare/cancelShare','',false)}";
    var gTxt = "{:$T->str_card_share_enter.$T->str_card_share_original_order}";
    var gconfirmShareUrl = "{:U('Appadmin/CardShare/confirmShare','',false)}";
    var gindexUrl = "{:U('Appadmin/CardShare/index','',false)}";
    var gaddUrl = "{:U('Appadmin/CardShare/addShare','',false)}";
    var gShowShareUrl = "{:U('Appadmin/CardShare/showShare','',false)}";
    var gFail = "{$T->str_card_share_fail}";
    var gMsg = {};
    gMsg['yes'] = "{$T->str_card_share_yes}";//‘确认’
    gMsg['cancel'] = "{$T->str_card_share_cancel}";//‘取消’
    gMsg['sync'] = "{$T->str_card_share_confirm_sync}";
    gMsg['undo'] = "{$T->str_card_share_undo_account_operation}";
    gMsg['empty'] = "{:$T->str_card_share_original_order.$T->str_card_share_not_empty}";
    gMsg['leastOne'] = "{:$T->str_card_share_account_num.$T->str_card_share_least_one}";
    gMsg['repetitive'] = "{:$T->str_card_share_id.$T->str_card_share_repetitive}";
    gMsg['unknown'] = "{$T->str_card_share_unknown_account}";
</script>