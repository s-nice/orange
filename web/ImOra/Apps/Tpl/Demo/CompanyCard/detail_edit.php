<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{$T->str_card_edit_title}</title>
    <script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
    <link rel="stylesheet" href="__PUBLIC__/css/weDialog.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body style='display:none;'>
    <form id="form1" action="{:U('CompanyCard/bizCardEdit','','',true)}" method="post" onsubmit="return checkdatas()">
        <input type="hidden" name="cardid" value="{$cardid}">
        <section class="edit_main">
            <div class="card_img">
                <if condition="$side eq 'back'">
                    <img src="{$info.picpathb}" alt="No img" />
                    <else/>
                    <img src="{$info.picpatha}" alt="No img" />
                </if>
            </div>
            <input type="hidden" name="isself" value="{$info['isself']}" >
            <section class="main">
                <div class="info_list">
                    <div class="info_item">
                        <div class="icon per_icon"></div>
                        <div class="edit_info">
                            <div class="i_list">
                                <input type="text" name="name" maxlength="12" value="{$info[$side]['FN']}" />
                                <h6>{$T->str_mycard_name}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="info_item">
                        <div class="icon building_icon"></div>
                        <div class="edit_info">
                            <div class="i_list">
                                <input type="text" name="company" maxlength="22" value="{$info[$side]['ORG']}" />
                                <h6>{$T->str_mycard_company}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="info_item">
                        <div class="icon map_icon"></div>
                        <div class="edit_info">
                            <div class="i_list">
                                <input type="text" name="address" maxlength="55" value="{$info[$side]['ADR']}" />
                                <h6>{$T->str_mycard_workaddr}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- 电话 -->
                    <notempty name="info[$side]['CELL']">
                        <foreach name="info[$side]['CELL']" item="vo">
                            <div class="info_item">
                                <div class="icon phone_icon"></div>
                                <div class="edit_info">
                                    <div class="i_list">
                                        <input type="phone" name="telphone[]" maxlength="15" onkeyup="checkphone(this)" onblur="checkphone(this)" value="{$vo}"  />
                                        <h6>{$T->str_mycard_telephone}</h6>
                                    </div>
                                </div>
                            </div>
                        </foreach>
                    <else/>
                        <div class="info_item">
                            <div class="icon phone_icon"></div>
                            <div class="edit_info">
                                <div class="i_list">
                                    <input type="phone" name="telphone[]" maxlength="15" onkeyup="checkphone(this)" onblur="checkphone(this)"  />
                                    <h6>{$T->str_mycard_telephone}</h6>
                                </div>
                            </div>
                        </div>
                    </notempty>

                    <!--手机-->
                    <notempty name="info[$side]['TEL']">
                        <foreach name="info[$side]['TEL']" item="vo">
                                <div class="info_item">
                                    <div class="icon mobile_icon"></div>
                                    <div class="edit_info">
                                        <div class="i_list">
                                            <input type="phone" name="mobile[]" maxlength="15" onkeyup="checkphone(this)" onblur="checkphone(this)"  value="{$vo}" />
                                            <h6>{$T->str_mycard_phone}</h6>
                                        </div>
                                    </div>
                                </div>
                        </foreach>
                    <else/>
                        <div class="info_item">
                            <div class="icon mobile_icon"></div>
                            <div class="edit_info">
                                <div class="i_list">
                                    <input type="phone" name="mobile[]" maxlength="15" onkeyup="checkphone(this)" onblur="checkphone(this)" />
                                    <h6>{$T->str_mycard_phone}</h6>
                                </div>
                            </div>
                        </div>
                    </notempty>

                    <!-- 邮箱 -->
                    <notempty name="info[$side]['EMAIL']">
                        <foreach name="info[$side]['EMAIL']" item="vo">
                            <notempty name="vo">
                            <div class="info_item">
                                <div class="icon email_icon"></div>
                                <div class="edit_info">
                                    <div class="i_list">
                                        <input class="js_emailinput" type="text" name="email[]" maxlength="30" onblur="checkemail(this)" value="{$vo}" />
                                        <h6>{$T->str_mycard_workemail}</h6>
                                    </div>
                                </div>
                            </div>
                            </notempty>
                        </foreach>
                        <else/>
                        <div class="info_item">
                            <div class="icon email_icon"></div>
                            <div class="edit_info">
                                <div class="i_list">
                                    <input class="js_emailinput" type="text" name="email[]" onblur="checkemail(this)" maxlength="30" value="" />
                                    <h6>{$T->str_mycard_workemail}</h6>
                                </div>
                            </div>
                        </div>
                    </notempty>

                    <!-- 网址 -->
                    <notempty name="info[$side]['URL']">
                        <foreach name="info[$side]['URL']" item="vo">
                            <notempty name="vo">
                            <div class="info_item">
                                <div class="icon www_icon"></div>
                                <div class="edit_info">
                                    <div class="i_list">
                                        <input type="text" name="url[]" maxlength="30" value="{$vo}" />
                                        <h6>{$T->str_mycard_site}</h6>
                                    </div>
                                </div>
                            </div>
                            </notempty>
                        </foreach>
                        <else/>
                        <div class="info_item">
                            <div class="icon www_icon"></div>
                            <div class="edit_info">
                                <div class="i_list">
                                    <input type="text" name="url[]" maxlength="30" value="" />
                                    <h6>{$T->str_mycard_site}</h6>
                                </div>
                            </div>
                        </div>
                    </notempty>

                </div>
            </section>
            <footer class="info_submit border-top">
                <div class="s_btn_width">
                    <input type="hidden" name="cardid" value="{$cardid}">
                    <input type="hidden" name="side" id="side" value="{$side}">
                    <input type="hidden" name="android" id="android" value="{$android}">
                    <input type="hidden" name="openid" value="{$openid}">
                    <button class="btn" type="submit button">{$T->str_mycard_submit}</button>
                </div>
                <if condition="$userAgent eq 'line'">
                <div class="s_btn_width btn_top">
                    <button id='isself' class="btn"><if condition="$info['isself'] eq '1'">{$T->str_mycard_cancelself}<else/>{$T->str_mycard_setself}</if></button>
                </div>
                </if>
            </footer>
        </section>
    </form>
    <input type="hidden" name="success" value="{$result}">
    <div id="toast" style="opacity:0.9;display:none;">
        <div class="weui-mask-transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">{$T->str_card_edit_success}</p>
        </div>
    </div>
</body>
</html>

<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var js_cardedit_success = "{$T->str_card_edit_success}";
    var js_cardedit_faild = "{$T->str_card_edit_faild}";
    var js_isself = "{$info['isself']}";
    var checkphoneres = 0;
    var checkemailres = 0;
    $(document).ready(function() {
        var data = $("input[name=success]").val();
        if(data){
            if(data=='success'){$("#weui-toast-content").html(js_cardedit_success);}
            if(data=='fail'){$("#weui-toast-content").html(js_cardedit_faild);}
            var side = $('#side').val();
            if(side == 'front'){
                if(js_isself==1){
                    var wDetailZpUrl = "{:U(MODULE_NAME.'/CompanyCard/wDetailZp',array('isMenu'=>'1','cardid'=>$cardid,'android'=>$android),'',true)}";
                }else{
                    var wDetailZpUrl = "{:U(MODULE_NAME.'/CompanyCard/wDetailZp',array('cardid'=>$cardid,'android'=>$android),'',true)}";
                }

            }else{
                var wDetailZpUrl = "{:U(MODULE_NAME.'/CompanyCard/detailBack',array('cardid'=>$cardid,'android'=>$android),'',true)}";
            }

            $("#toast").show();
            setTimeout(function(){location.href = wDetailZpUrl},1500);
        }

        //取消个人名片
        $('#isself').on('click', function(){
        	var v=js_isself==1?0:1;
        	$('#form1 input[name="isself"]').val(v);
        	$('#form1').submit();
        });
    });
    /*$("#cancel").click(function(){
        window.location.href = "{:U(MODULE_NAME.'/Wechat/'.$rtnPage,array('cardid'=>$info['cardid'],'android'=>$android),'',true)}";
    });*/
    function checkphone(obj){
        obj.value = obj.value.replace(/[^\d\+\-\(\)]/g,"");  //清除  以外的字符
    }
    function checkphones(values){
        var patrn=/[^\d\+\-\(\)]/g;
        //var patrn=/([0-9]|[+-\\(\\)]){4,19}$/;
        if(patrn.exec(values) || values==''){
            showMsg(0,'电话号码格式有误');
            checkphoneres = 1;
        }

    }
    function checkemail(obj){
        //var elems = document.getElementsByClassName('js_emailinput');
        if(/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(obj.value) === false){
            //alert('请输入正确的email格式');
            showMsg(0,'请输入正确的email格式');
            //$(obj).focus();
            return false;
        }
    }
    function checkemails(_value){
        var patrn=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
        if(!patrn.exec(_value)){
            showMsg(0,'请输入正确的email格式');
            checkemailres = 1;
        }
    }

    function checkdatas(){
        $('#form1').find('input[name="telphone[]"]').each(function(i,d){
            checkphones($(d).val());
        });
        $('#form1').find('input[name="mobile[]"]').each(function(i,d){
            checkphones($(d).val());
        });
        if(checkphoneres){
            checkphoneres = 0 ;
            return false;
        }

        $('#form1').find('input[name="email[]"]').each(function(i,d){
            checkemails($(d).val());
        });
        if(checkemailres){
            checkemailres = 0;
            return false;
        }

    }
    function showMsg(type,msg){
        if(type){
            $('#toast .weui-toast i').addClass('weui-icon-success-no-circle');
            $('#toast .weui-toast i').removeClass('weui-icon-faild-no-circle');
        }else{
            $('#toast .weui-toast i').removeClass('weui-icon-success-no-circle');
            $('#toast .weui-toast i').addClass('weui-icon-faild-no-circle');
        }

        $("#toast .weui-toast p").html(msg);
        $("#toast").show();
        setTimeout(function(){$("#toast").hide();},1000);
    }
</script>