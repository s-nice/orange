<script src="__PUBLIC__/js/jsExtend/expression/js/plugins/exp/exp.js"></script>
<script>
    var delnewsurl = "{:U('Appadmin/News/delNews','','','',true)}";//删除资讯地址
    var publishauditurl = "{:U('Appadmin/News/updateAudit','','','',true)}";//发布到审核  或者更新
    var gGetDataUrl = "{:U('Appadmin/News/getOneNew','','','',true)}";//获取一条资讯详情
    var newstopurl = "{:U('Appadmin/News/topNews','','','',true)}";//新闻置顶
    var newsundourl = "{:U('Appadmin/News/undoNews','','','',true)}";//新闻撤销
    
    var gStrconfirmdelnews = "{$T->str_confirm_del_infomation}";//确认删除该条资讯
    var gStrconfirmdelasks = "{$T->str_confirm_del_ask}";//确认删除该条问答
    var gStrcanceldelnews = "{$T->str_cancel_del_new}";//取消
    var gStryesdelnews = "{$T->str_yes_del_new}";//确认
    var gStrselectdelnews = "{$T->str_select_del_new}";//请至少选择一项内容进行删除
    var gStrselectpublishnews = "{$T->str_select_publish_new}";//请至少选择一项内容进行发布
    var gStrselectauditnews = "{$T->str_select_audit_new}";//请至少选择一项内容进行审核
    var gStrselectauditnews = "{$T->str_select_audit_new}";//请至少选择一项内容进行审核
    var gStrselectauditcomment = "{$T->str_select_audit_comment}";//请至少选择一项评论进行审核
    var str_select_audit_top = "{$T->str_select_audit_top}";//请至少选择一项评论进行置顶
    var str_select_audit_undo = "{$T->str_select_audit_undo}";//请至少选择一项评论进行撤销
    var str_select_audit_edit = "{$T->str_select_audit_edit}";//请至少选择一项评论进行编辑
    
    var gStrnotnullalloption = "{$T->str_all_option_notnull}";//所有选项不能为空
    var gStrhasnoprevone = "{$T->str_hasno_prevone}";//没有上一篇了
    var gStrhasnoprevpic = "{$T->str_hasno_prevpic}";//没有上一张了
    var gStrhasnonextone = "{$T->str_hasno_nextone}";//没有下一篇了
    var gStrhasnonextpic = "{$T->str_hasno_nextpic}";//没有下一张了
    var gStrtitleoutlimit= "{$T->str_title_outlimit}";//标题超出限制
    var gStrkeywordoutlimit= "{$T->str_keyword_outlimit}";//关键词超出限制
    var gStrclickuploadpic= "{$T->str_news_click_uploadpic}";//点击选择文件
    var gStrselectcomment="{$T->str_select_comment}";//请选择至少一项评论
  //  var gStrInfoType = "{：$infotype ? $infotype :'}";//判断是资讯还是问答
    var gStrLeaveTip = "{$T->str_tip_leave}";//离开编辑资讯页面时  提示是否有未保存信息

    var tip_has_illegalword1 = "{$T->tip_has_illegalword1}";
    var tip_has_illegalword2 = "{$T->tip_has_illegalword2}";
    var str_news_title = "{$T->str_news_title}";
    var str_news_content = "{$T->str_news_content}";
    var JS_PUBLIC = "__PUBLIC__";

    var gUeAudioFormatErrMsg="{$T->str_ue_audio_format_error}";//音频格式不正确
    var gUeAddAudioErrMsg="{$T->str_ue_add_audio_fail}";//添加音频失败:请检查文件大小和格式
    var gMustSelectPush="{$T->str_news_select_push}";//请选择一项内容进行推送
    var gSelectCommentUser="{$T->str_comment_select_user}";//请选择评论人
    var gAddCommentContent="{$T->str_comment_add_content}";//请输入评论内容
    var gAddCommentSuccess="{$T->str_comment_add_success}";//添加评论成功
    var gAddCommentFail="{$T->str_comment_add_fail}";//添加评论失败
    var gSelectLabel="{$T->str_label_select}";//请选择标签
    var gSelectLabelMax="{$T->str_label_select_max}";//标签最多同时选择100个
</script>
